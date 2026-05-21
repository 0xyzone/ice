<?php

namespace App\Filament\App\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PlayerStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $player = User::with([
            'matchStats.matchSeries',
        ])->find($user->id);

        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;
        $teamsCount = 0;

        if ($player) {
            $teamsCount = $player->teamMemberships()->count();
            foreach ($player->matchStats as $stat) {
                if ($stat->matchSeries) {
                    $totalPlayed++;
                    if ($stat->matchSeries->result === 'won') {
                        $totalWon++;
                    } elseif ($stat->matchSeries->result === 'lost') {
                        $totalLost++;
                    }
                }
            }
        }

        $winRate = $totalPlayed > 0 ? round(($totalWon / $totalPlayed) * 100, 1) : 0.0;

        return [
            Stat::make('Win Rate', $winRate.'%')
                ->description('Performance index')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Matches Played', $totalPlayed)
                ->description('Tournament matches')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('primary'),
            Stat::make('My Active Teams', $teamsCount)
                ->description('Registered rosters')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
