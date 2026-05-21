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
            'matchStats.matchSeries.match.tournament',
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
            'matchStats.matchSeries.match.tournament',
        ])->where('username', $username)->firstOrFail();

        return $this->renderProfile($player);
    }

    private function renderProfile(User $player): View
    {
        $totalPlayed = 0;
        $totalWon = 0;
        $totalLost = 0;
        $totalKills = 0;
        $totalDeaths = 0;
        $totalAssists = 0;
        $totalMvps = 0;

        $tournamentStats = [];

        foreach ($player->matchStats as $stat) {
            $series = $stat->matchSeries;
            if (! $series) {
                continue;
            }
            $match = $series->match;
            if (! $match) {
                continue;
            }

            $totalPlayed++;

            if ($series->result === 'won') {
                $totalWon++;
            } elseif ($series->result === 'lost') {
                $totalLost++;
            }

            $totalKills += $stat->kills;
            $totalDeaths += $stat->deaths;
            $totalAssists += $stat->assists;
            if ($stat->is_mvp) {
                $totalMvps++;
            }

            $tournament = $match->tournament;
            if ($tournament) {
                $tId = $tournament->id;
                if (! isset($tournamentStats[$tId])) {
                    $tournamentStats[$tId] = (object) [
                        'tournament' => $tournament,
                        'matches_played' => 0,
                        'matches_won' => 0,
                        'matches_lost' => 0,
                        'kills' => 0,
                        'deaths' => 0,
                        'assists' => 0,
                        'mvps' => 0,
                        'matches' => [],
                    ];
                }

                $tStat = $tournamentStats[$tId];
                $tStat->matches_played++;
                if ($series->result === 'won') {
                    $tStat->matches_won++;
                } elseif ($series->result === 'lost') {
                    $tStat->matches_lost++;
                }
                $tStat->kills += $stat->kills;
                $tStat->deaths += $stat->deaths;
                $tStat->assists += $stat->assists;
                if ($stat->is_mvp) {
                    $tStat->mvps++;
                }

                $matchId = $match->id;
                if (! isset($tStat->matches[$matchId])) {
                    $tStat->matches[$matchId] = (object) [
                        'match' => $match,
                        'series' => [],
                    ];
                }

                $tStat->matches[$matchId]->series[] = (object) [
                    'map' => $series,
                    'player_stat' => $stat,
                ];
            }
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
            'kda',
            'tournamentStats'
        ));
    }
}
