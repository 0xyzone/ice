<?php

namespace Tests\Feature;

use App\Models\EsportsMatch;
use App\Models\Game;
use App\Models\MatchSeries;
use App\Models\OwnTeam;
use App\Models\PlayerMatchStat;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTournamentStatTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_profile_shows_correct_aggregated_stats(): void
    {
        $user = User::factory()->create([
            'name' => 'Sumin Shrestha',
            'username' => 'sumin_shrestha',
        ]);

        $game = Game::create([
            'name' => 'PUBG Mobile',
        ]);

        $team = OwnTeam::create([
            'name' => 'Ice Cream Gaming',
            'slug' => 'ice-cream-gaming',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $tournament1 = Tournament::create([
            'name' => 'Cyber Cup 2026',
            'prize_pool' => '5000',
            'status' => 'completed',
        ]);

        $tournament2 = Tournament::create([
            'name' => 'Neon Invitational',
            'prize_pool' => '10000',
            'status' => 'ongoing',
        ]);

        // Create match for Tournament 1
        $match1 = EsportsMatch::create([
            'tournament_id' => $tournament1->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Team Alpha',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 3,
            'our_score' => 2,
            'opponent_score' => 1,
        ]);

        // Map 1 for Match 1
        $series1 = MatchSeries::create([
            'match_id' => $match1->id,
            'game_number' => 1,
            'map_name' => 'Miramar',
            'result' => 'won',
            'our_score' => 15,
            'opponent_score' => 8,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $series1->id,
            'user_id' => $user->id,
            'kills' => 15,
            'deaths' => 5,
            'assists' => 10,
            'is_mvp' => true,
            'extra_stats' => [
                'Hero' => 'Ling',
                'Gold' => '12K',
                'Damage' => '85000',
            ],
        ]);

        // Map 2 for Match 1
        $series2 = MatchSeries::create([
            'match_id' => $match1->id,
            'game_number' => 2,
            'map_name' => 'Sanhok',
            'result' => 'lost',
            'our_score' => 5,
            'opponent_score' => 12,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $series2->id,
            'user_id' => $user->id,
            'kills' => 10,
            'deaths' => 5,
            'assists' => 5,
            'is_mvp' => false,
        ]);

        // Create match for Tournament 2
        $match2 = EsportsMatch::create([
            'tournament_id' => $tournament2->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Team Beta',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 1,
            'our_score' => 1,
            'opponent_score' => 0,
        ]);

        // Map 1 for Match 2
        $series3 = MatchSeries::create([
            'match_id' => $match2->id,
            'game_number' => 1,
            'map_name' => 'Erangel',
            'result' => 'won',
            'our_score' => 10,
            'opponent_score' => 4,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $series3->id,
            'user_id' => $user->id,
            'kills' => 15,
            'deaths' => 5,
            'assists' => 5,
            'is_mvp' => true,
        ]);

        // Total calculated expected:
        // Matches Played: 3
        // Wins: 2
        // Losses: 1
        // Kills: 40
        // Deaths: 15
        // Assists: 20
        // MVPs: 2
        // KDA Ratio: (40 + 20) / 15 = 4.00
        // Win Rate: (2 / 3) * 100 = 66.7%

        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);

        // Verify custom sections and aggregated statistics exist on screen
        $response->assertSee('Combat Specification');
        $response->assertSee('KDA RATIO');
        $response->assertSee('4.00');
        $response->assertSee('66.7%');
        $response->assertSee('2'); // MVPs

        // Verify specific tournament names are listed
        $response->assertSee('Cyber Cup 2026');
        $response->assertSee('Neon Invitational');

        // Verify dynamic custom game stats are outputted correctly
        $response->assertSee('Hero:');
        $response->assertSee('Ling');
        $response->assertSee('Gold:');
        $response->assertSee('12K');
        $response->assertSee('Damage:');
        $response->assertSee('85000');
    }

    public function test_player_profile_hides_stats_section_if_no_data(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johndoe',
        ]);

        // No stats created

        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);

        // Verify combat metrics section is hidden
        $response->assertDontSee('Combat Specification & Metrics');
        $response->assertDontSee('KDA RATIO');
        $response->assertDontSee('BATTLE WIN RATE');
    }

    public function test_player_profile_shows_stats_when_no_tournament_associated(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
        ]);

        $game = Game::create([
            'name' => 'PUBG Mobile',
        ]);

        $team = OwnTeam::create([
            'name' => 'Ice Cream Gaming',
            'slug' => 'ice-cream-gaming',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $tournament = Tournament::create([
            'name' => 'Cyber Cup 2026',
            'prize_pool' => '5000',
            'status' => 'completed',
        ]);

        // Create match with associated tournament_id
        $match = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Team Gamma',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 3,
            'our_score' => 2,
            'opponent_score' => 1,
        ]);

        $series = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 1,
            'map_name' => 'Erangel',
            'result' => 'won',
            'our_score' => 10,
            'opponent_score' => 5,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $series->id,
            'user_id' => $user->id,
            'kills' => 8,
            'deaths' => 2,
            'assists' => 4,
            'is_mvp' => true,
        ]);

        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);

        // Verify that combat metrics display properly
        $response->assertSee('Combat Specification');
        $response->assertSee('KDA RATIO');
        $response->assertSee('6.00'); // (8 + 4) / 2 = 6.00
        $response->assertSee('100%'); // 1 match won
        $response->assertSee('1'); // 1 MVP
    }

    public function test_match_series_result_and_scores_are_auto_calculated(): void
    {
        $tournament = Tournament::create([
            'name' => 'Auto Score Tournament',
            'status' => 'ongoing',
        ]);

        $game = Game::create(['name' => 'Mobile Legends']);
        $team = OwnTeam::create([
            'name' => 'MLBB Team',
            'slug' => 'mlbb-team',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $match = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Team Delta',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 3,
            'our_score' => 0,
            'opponent_score' => 0,
        ]);

        // Game 1: Win (our score > opponent score)
        $series1 = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 1,
            'our_score' => 18,
            'opponent_score' => 10,
        ]);

        $this->assertEquals('won', $series1->fresh()->result);
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(0, $match->fresh()->opponent_score);

        // Game 2: Loss (our score < opponent score)
        $series2 = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 2,
            'our_score' => 8,
            'opponent_score' => 20,
        ]);

        $this->assertEquals('lost', $series2->fresh()->result);
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(1, $match->fresh()->opponent_score);

        // Game 3: Draw (our score == opponent score)
        $series3 = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 3,
            'our_score' => 15,
            'opponent_score' => 15,
        ]);

        $this->assertEquals('draw', $series3->fresh()->result);
        // Scores should stay 1 and 1 since it's a draw, not a win or loss
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(1, $match->fresh()->opponent_score);

        // Deleting Game 3 should trigger recalculate
        $series3->delete();
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(1, $match->fresh()->opponent_score);

        // Deleting Game 2 should leave only Game 1 (1 - 0)
        $series2->delete();
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(0, $match->fresh()->opponent_score);
    }
}
