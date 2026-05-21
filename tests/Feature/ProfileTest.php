<?php

namespace Tests\Feature;

use App\Models\EsportsMatch;
use App\Models\Game;
use App\Models\MatchSeries;
use App\Models\OwnTeam;
use App\Models\PlayerDetail;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_profile_routes_work_correctly(): void
    {
        $user = User::factory()->create([
            'name' => 'Sumin Shrestha',
            'username' => 'sumin_shrestha',
        ]);

        PlayerDetail::create([
            'user_id' => $user->id,
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
            'personal_contact_number' => '9800000001',
            'alt_personal_contact_number' => '9800000002',
            'emergency_contact_name' => 'Father',
            'emergency_contact_number' => '9800000003',
            'emergency_contact_relationship' => 'father',
        ]);

        // Test route by ID
        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);
        $response->assertSee('Sumin Shrestha');

        // Test route by username
        $response = $this->get('/player/sumin_shrestha');
        $response->assertStatus(200);
        $response->assertSee('Sumin Shrestha');
    }

    public function test_team_profile_routes_work_correctly(): void
    {
        $game = Game::create([
            'name' => 'PUBG Mobile',
        ]);

        $team = OwnTeam::create([
            'name' => 'Ice Cream Gaming',
            'slug' => 'ice-cream-gaming',
            'status' => true,
            'game_id' => $game->id,
        ]);

        // Test route by ID
        $response = $this->get("/team/{$team->id}");
        $response->assertStatus(200);
        $response->assertSee('Ice Cream Gaming');

        // Test route by slug
        $response = $this->get('/team/ice-cream-gaming');
        $response->assertStatus(200);
        $response->assertSee('Ice Cream Gaming');
    }

    public function test_team_profile_shows_correct_dynamic_statistics(): void
    {
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
            'name' => 'Vidanta Champions League',
            'prize_pool' => '50000',
            'status' => 'ongoing',
        ]);

        // Match 1: Won (BO3, we won 2-1)
        $match1 = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Alpha',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 3,
            'our_score' => 2,
            'opponent_score' => 1,
        ]);

        MatchSeries::create([
            'match_id' => $match1->id,
            'game_number' => 1,
            'map_name' => 'Erangel',
            'result' => 'won',
            'our_score' => 15,
            'opponent_score' => 5,
        ]);

        MatchSeries::create([
            'match_id' => $match1->id,
            'game_number' => 2,
            'map_name' => 'Miramar',
            'result' => 'lost',
            'our_score' => 3,
            'opponent_score' => 15,
        ]);

        MatchSeries::create([
            'match_id' => $match1->id,
            'game_number' => 3,
            'map_name' => 'Sanhok',
            'result' => 'won',
            'our_score' => 10,
            'opponent_score' => 8,
        ]);

        // Match 2: Lost (BO1, we lost 0-1)
        $match2 = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Enemy Beta',
            'match_date' => now(),
            'status' => 'completed',
            'best_of' => 1,
            'our_score' => 0,
            'opponent_score' => 1,
        ]);

        MatchSeries::create([
            'match_id' => $match2->id,
            'game_number' => 1,
            'map_name' => 'Erangel',
            'result' => 'lost',
            'our_score' => 5,
            'opponent_score' => 10,
        ]);

        $response = $this->get("/team/{$team->id}");
        $response->assertStatus(200);

        // Assert dynamic metrics are visible
        $response->assertSee('Vidanta Champions League');
        $response->assertSee('2'); // Matches Played
        $response->assertSee('50%'); // Win Rate
        $response->assertSee('33'); // Total Points

        // Assert match campaigns and details are visible
        $response->assertSee('Match Campaigns');
        $response->assertSee('VS Enemy Alpha');
        $response->assertSee('VS Enemy Beta');
        $response->assertSee('Game 1');
        $response->assertSee('Game 2');
        $response->assertSee('Game 3');
    }
}
