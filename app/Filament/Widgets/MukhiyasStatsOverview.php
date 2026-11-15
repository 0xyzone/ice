<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OwnTeams\OwnTeamResource;
use App\Filament\Resources\Tournaments\TournamentResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\OwnTeam;
use App\Models\Tournament;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MukhiyasStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! ($user?->hasAnyRole(['super_admin', 'admin']) ?? false)) {
            return false;
        }

        return UserResource::canViewAny()
            || OwnTeamResource::canViewAny()
            || TournamentResource::canViewAny();
    }

    protected function getStats(): array
    {
        $stats = [];

        if (UserResource::canViewAny()) {
            $stats[] = Stat::make('Total Registered Players', User::role('player')->count())
                ->description('Competitive players')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('danger');
        }

        if (OwnTeamResource::canViewAny()) {
            $stats[] = Stat::make('Esports Teams', OwnTeam::count())
                ->description('Registered teams')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary');
        }

        if (TournamentResource::canViewAny()) {
            $stats[] = Stat::make('Live Tournaments', Tournament::where('status', 'ongoing')->count())
                ->description('Tournaments in progress')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('warning');
        }

        return $stats;
    }
}
