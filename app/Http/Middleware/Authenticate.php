<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Illuminate\Support\Facades\Auth;

class Authenticate extends FilamentAuthenticate
{
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if ($guard->check()) {
            $user = $guard->user();

            if (method_exists($user, 'isActive') && ! $user->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                redirect()->route('auth.deactivated')->send();
                exit;
            }
        }

        parent::authenticate($request, $guards);
    }

    protected function redirectTo($request): ?string
    {
        return route('login');
    }
}
