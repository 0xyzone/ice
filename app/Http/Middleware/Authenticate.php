<?php

namespace App\Http\Middleware;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Http\Exceptions\HttpResponseException;
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

                throw new HttpResponseException(
                    redirect()->route('auth.deactivated')
                );
            }

            $panel = Filament::getCurrentOrDefaultPanel();

            if ($user instanceof FilamentUser && $user instanceof User && ! $user->canAccessPanel($panel)) {
                throw new HttpResponseException(
                    redirect()->to($user->getDefaultPanelUrl())
                );
            }
        }

        parent::authenticate($request, $guards);
    }

    protected function redirectTo($request): ?string
    {
        return route('login');
    }
}
