<?php

namespace App\Http\Controllers;

use App\Models\EsportsMatch;
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
        ])->findOrFail($id);

        return $this->renderTeam($team);
    }

    public function showBySlug(string $slug): View
    {
        $team = OwnTeam::with([
            'game',
            'members' => function ($query) {
                $query->where('status', true); // Only active roster members
            },
            'members.user.player',
        ])->where('slug', $slug)->firstOrFail();

        return $this->renderTeam($team);
    }

    private function renderTeam(OwnTeam $team): View
    {
        // Fetch all completed matches of this team
        $matches = EsportsMatch::where('own_team_id', $team->id)
            ->where('status', 'completed')
            ->with(['tournament', 'series.playerStats.user'])
            ->get();

        $tournaments = [];
        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;
        $totalPoints = 0;

        foreach ($matches->groupBy('tournament_id') as $tournamentId => $tournamentMatches) {
            $tournament = $tournamentMatches->first()->tournament;
            if (! $tournament) {
                continue;
            }

            $played = $tournamentMatches->count();
            $won = $tournamentMatches->filter(fn ($m) => $m->our_score > $m->opponent_score)->count();
            $lost = $tournamentMatches->filter(fn ($m) => $m->our_score < $m->opponent_score)->count();

            // points: sum of our_score from each match series/map
            $points = $tournamentMatches->sum(fn ($m) => $m->series->sum('our_score'));

            $totalPlayed += $played;
            $totalWon += $won;
            $totalLost += $lost;
            $totalPoints += $points;

            // Compute dynamic rank for this team in this tournament
            // All matches in this tournament
            $allTournamentMatches = EsportsMatch::where('tournament_id', $tournament->id)
                ->where('status', 'completed')
                ->with('series')
                ->get();

            // Group by own_team_id and calculate points
            $teamPoints = $allTournamentMatches->groupBy('own_team_id')->map(function ($tMatches) {
                return $tMatches->sum(fn ($m) => $m->series->sum('our_score'));
            })->sortDesc();

            $rank = 1;
            $finalRank = 'Participant';
            foreach ($teamPoints as $tId => $pts) {
                if ($tId == $team->id) {
                    if ($rank === 1) {
                        $finalRank = 'Champion';
                    } elseif ($rank === 2) {
                        $finalRank = '2nd Place';
                    } elseif ($rank === 3) {
                        $finalRank = '3rd Place';
                    } else {
                        $finalRank = $rank.'th Place';
                    }
                    break;
                }
                $rank++;
            }

            $tournaments[] = (object) [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'start_date' => $tournament->start_date,
                'matches_played' => $played,
                'matches_won' => $won,
                'matches_lost' => $lost,
                'points' => $points,
                'rank' => $finalRank,
                'matches' => $tournamentMatches,
            ];
        }

        // Sort tournaments by start_date descending
        usort($tournaments, fn ($a, $b) => strcmp($b->start_date ?? '', $a->start_date ?? ''));

        $winRate = $totalPlayed > 0 ? round(($totalWon / $totalPlayed) * 100, 1) : 0.0;

        return view('team-profile', compact('team', 'tournaments', 'totalPlayed', 'totalWon', 'totalLost', 'totalPoints', 'winRate'));
    }
}
