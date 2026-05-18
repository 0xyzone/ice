<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class PlayerProfileController extends Controller
{
    public function show(int $id): View
    {
        $player = User::with([
            'socials',
            'player',
            'teamMemberships.team.game',
            'teamMemberships.team.tournaments',
            'gameInfos.game',
            'galleries',
        ])->findOrFail($id);

        // Calculate dynamic player stats from tournament records of participating teams
        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;

        foreach ($player->teamMemberships as $membership) {
            if ($membership->team) {
                foreach ($membership->team->tournaments as $tournament) {
                    $totalPlayed += $tournament->pivot->matches_played;
                    $totalWon += $tournament->pivot->matches_won;
                    $totalLost += $tournament->pivot->matches_lost;
                }
            }
        }

        $winRate = $totalPlayed > 0 ? round(($totalWon / $totalPlayed) * 100, 1) : 0.0;

        return view('player-profile', compact('player', 'totalPlayed', 'totalWon', 'totalLost', 'winRate'));
    }
}
