<?php

namespace App\Filament\App\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PlayerProfileLinkWidget extends Widget
{
    protected string $view = 'filament.app.widgets.player-profile-link-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $player = User::with([
            'teamMemberships.team.tournaments',
        ])->find($user->id);

        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;

        if ($player) {
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
            'player' => $player,
            'totalPlayed' => $totalPlayed,
            'totalWon' => $totalWon,
            'totalLost' => $totalLost,
            'winRate' => $winRate,
            'profileUrl' => $user->username ? route('player.profile.username', $user->username) : route('player.profile', $user->id),
        ];
    }
}
