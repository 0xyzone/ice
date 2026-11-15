<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\Matches\MatchResource;
use App\Filament\Resources\OwnTeams\OwnTeamResource;
use App\Filament\Resources\Tournaments\TournamentResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\EsportsMatch;
use App\Models\OwnTeam;
use App\Models\Tournament;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class MukhiyasHero3DWidget extends Widget
{
    protected string $view = 'filament.widgets.mukhiyas-hero-3d-widget';

    protected static ?int $sort = -10;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $metrics = [];

        if (OwnTeamResource::canViewAny()) {
            $metrics[] = [
                'label' => 'Active Squads',
                'value' => OwnTeam::where('status', true)->count(),
            ];
        }

        if (TournamentResource::canViewAny()) {
            $metrics[] = [
                'label' => 'Live Tournaments',
                'value' => Tournament::where('status', 'ongoing')->count(),
            ];
        }

        if (MatchResource::canViewAny()) {
            $metrics[] = [
                'label' => 'Total Matches',
                'value' => EsportsMatch::count(),
            ];
        }

        if (UserResource::canViewAny()) {
            $metrics[] = [
                'label' => 'Registered Players',
                'value' => User::role('player')->count(),
            ];
        }

        return [
            'userName' => $user->name,
            'roleLabel' => $user->hasRole('super_admin') ? 'Super Admin' : 'Esports Admin',
            'metrics' => $metrics,
        ];
    }
}
