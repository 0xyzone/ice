<?php

namespace App\Filament\Widgets;

use App\Models\OwnTeam;
use App\Models\Tournament;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MukhiyasStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Registered Players', User::role('player')->count())
                ->description('Competitive players')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('danger'),
            Stat::make('Esports Teams', OwnTeam::count())
                ->description('Registered teams')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'),
            Stat::make('Live Tournaments', Tournament::where('status', 'ongoing')->count())
                ->description('Tournaments in progress')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('warning'),
        ];
    }
}
