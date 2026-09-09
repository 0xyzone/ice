<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PlayerDetail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $request->session()->put('google_oauth_mode', 'connect');
        } else {
            $request->session()->put('google_oauth_mode', 'login');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate / connect.
     */
    public function callback(Request $request): RedirectResponse
    {
        if ($request->has('error') || $request->has('denied')) {
            if (Auth::check()) {
                return redirect('/app/manage-profile')->with('error', 'Google connection was cancelled.');
            }

            return redirect('/login')->withErrors([
                'login' => 'Google authentication was cancelled.',
            ]);
        }

        try {
            /** @var \Laravel\Socialite\Two\User $googleUser */
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            if (Auth::check()) {
                return redirect('/app/manage-profile')->with('error', 'Failed to authenticate with Google: '.$e->getMessage());
            }

            return redirect('/login')->withErrors([
                'login' => 'Failed to authenticate with Google. Please try again.',
            ]);
        }

        $mode = $request->session()->pull('google_oauth_mode', Auth::check() ? 'connect' : 'login');

        // Flow 1: Logged-in user connecting Google account to their existing profile
        if (Auth::check() || $mode === 'connect') {
            /** @var User $currentUser */
            $currentUser = Auth::user();

            if (! $currentUser) {
                return redirect('/login')->withErrors([
                    'login' => 'Please sign in first before connecting your Google account.',
                ]);
            }

            // Check if this Google ID is already linked to another account
            $existingWithGoogleId = User::where('google_id', $googleUser->getId())
                ->where('id', '!=', $currentUser->id)
                ->first();

            if ($existingWithGoogleId) {
                return redirect('/app/manage-profile')->with('error', 'This Google account is already linked to another user profile.');
            }

            // Check if another account uses this Google email
            $existingWithEmail = User::where('email', $googleUser->getEmail())
                ->where('id', '!=', $currentUser->id)
                ->first();

            if ($existingWithEmail) {
                return redirect('/app/manage-profile')->with('error', 'The email associated with this Google account is already in use by another profile.');
            }

            $currentUser->google_id = $googleUser->getId();
            if (! $currentUser->google_avatar_url) {
                $currentUser->google_avatar_url = $googleUser->getAvatar();
            }
            $currentUser->save();

            return redirect('/app/manage-profile')->with('status', 'Google account successfully linked!');
        }

        // Flow 2: Guest user logging in with Google
        // Check 1: User with this google_id already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        // Check 2: Match by email if account was created with Google email
        if (! $user && $googleUser->getEmail()) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->google_id = $googleUser->getId();
                if (! $user->google_avatar_url) {
                    $user->google_avatar_url = $googleUser->getAvatar();
                }
                if (! $user->email_verified_at) {
                    $user->email_verified_at = now();
                }
                $user->save();
            }
        }

        // Check 3: If no account exists
        if (! $user) {
            $allowRegistration = config('services.google.allow_registration', false);

            if ($allowRegistration) {
                $user = $this->createNewGoogleUser($googleUser);
            } else {
                return redirect('/login')->withErrors([
                    'login' => 'No player account found associated with '.$googleUser->getEmail().'. Please contact an administrator.',
                ]);
            }
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return $this->redirectUser($user);
    }

    /**
     * Disconnect the connected Google account from the user's profile.
     */
    public function disconnect(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        $user->google_id = null;
        $user->save();

        return redirect('/app/manage-profile')->with('status', 'Google account disconnected successfully.');
    }

    /**
     * Create a new user when auto-registration is enabled.
     */
    protected function createNewGoogleUser($googleUser): User
    {
        $username = Str::slug($googleUser->getName() ?? 'player', '_');
        $baseUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername.'_'.$counter;
            $counter++;
        }

        $user = User::create([
            'name' => $googleUser->getName() ?? 'Player',
            'email' => $googleUser->getEmail(),
            'username' => $username,
            'google_id' => $googleUser->getId(),
            'google_avatar_url' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(32)),
        ]);

        if (class_exists(Role::class)) {
            $user->assignRole('player');
        }

        PlayerDetail::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    /**
     * Redirect the user according to their assigned roles.
     */
    protected function redirectUser(User $user): RedirectResponse
    {
        if ($user->hasRole(['admin', 'super_admin'])) {
            return redirect('/mukhiyas');
        }

        return redirect('/app');
    }
}
