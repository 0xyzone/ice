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
            'gameInfos.game',
            'galleries',
            'tournamentStats.tournament',
        ])->findOrFail($id);

        return $this->renderProfile($player);
    }

    public function showByUsername(string $username): View
    {
        $player = User::with([
            'socials',
            'player',
            'teamMemberships.team.game',
            'gameInfos.game',
            'galleries',
            'tournamentStats.tournament',
        ])->where('username', $username)->firstOrFail();

        return $this->renderProfile($player);
    }

    private function renderProfile(User $player): View
    {
        // Calculate dynamic player stats from individual tournament records
        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;
        $totalKills = 0;
        $totalDeaths = 0;
        $totalAssists = 0;
        $totalMvps = 0;

        foreach ($player->tournamentStats as $stat) {
            $totalPlayed += $stat->matches_played;
            $totalWon += $stat->matches_won;
            $totalLost += $stat->matches_lost;
            $totalKills += $stat->kills;
            $totalDeaths += $stat->deaths;
            $totalAssists += $stat->assists;
            $totalMvps += $stat->mvps;
        }

        $winRate = $totalPlayed > 0 ? round(($totalWon / $totalPlayed) * 100, 1) : 0.0;
        $kda = $totalPlayed > 0 ? round(($totalKills + $totalAssists) / max(1, $totalDeaths), 2) : 0.00;

        return view('player-profile', compact(
            'player',
            'totalPlayed',
            'totalWon',
            'totalLost',
            'winRate',
            'totalKills',
            'totalDeaths',
            'totalAssists',
            'totalMvps',
            'kda'
        ));
    }
}
