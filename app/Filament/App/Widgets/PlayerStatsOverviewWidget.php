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
            'teamMemberships.team.tournaments',
        ])->find($user->id);

        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;
        $teamsCount = 0;

        if ($player) {
            $teamsCount = $player->teamMemberships()->count();
            foreach ($player->teamMemberships as $membership) {
                if ($membership->team) {
                    foreach ($membership->team->tournaments as $tournament) {
                        $totalPlayed += $tournament->pivot->matches_played;
                        $totalWon += $tournament->pivot->matches_won;
                        $totalLost += $tournament->pivot->matches_lost;
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
