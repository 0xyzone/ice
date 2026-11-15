<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if (! $user->isActive()) {
                Auth::logout();

                return redirect()->route('auth.deactivated');
            }

            return $this->redirectUser($user);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authData = [
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($authData, $request->boolean('remember'))) {
            /** @var User $user */
            $user = Auth::user();

            if (! $user->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('auth.deactivated');
            }

            $request->session()->regenerate();

            return $this->redirectUser($user);
        }

        return back()->withErrors([
            'login' => __('filament-panels::auth/pages/login.messages.failed'),
        ])->onlyInput('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/login');
    }

    protected function redirectUser(User $user): RedirectResponse
    {
        $intended = session()->pull('url.intended');

        if ($user->canAccessIntendedUrl($intended)) {
            return redirect()->to($intended);
        }

        return redirect()->to($user->getDefaultPanelUrl());
    }
}
