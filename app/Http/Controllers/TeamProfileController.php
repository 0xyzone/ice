<?php

namespace App\Http\Controllers;

use App\Models\OwnTeam;
use Illuminate\Contracts\View\View;

class TeamProfileController extends Controller
{
    public function show(int $id): View
    {
        $team = OwnTeam::with([
            'game',
            'members' => function ($query) {
                $query->where('status', true); // Only active roster members
            },
            'members.user.player',
            'tournaments',
        ])->findOrFail($id);

        // Aggregate dynamic tournament metrics
        $totalPlayed = $team->tournaments->sum('pivot.matches_played');
        $totalWon = $team->tournaments->sum('pivot.matches_won');
        $totalLost = $team->tournaments->sum('pivot.matches_lost');
        $totalPoints = $team->tournaments->sum('pivot.points');
        $winRate = $totalPlayed > 0 ? round(($totalWon / $totalPlayed) * 100, 1) : 0.0;

        return view('team-profile', compact('team', 'totalPlayed', 'totalWon', 'totalLost', 'totalPoints', 'winRate'));
    }
}
