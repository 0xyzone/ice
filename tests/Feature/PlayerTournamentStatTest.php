<?php

namespace Tests\Feature;

use App\Models\PlayerTournamentStat;
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

        // Attach stats for Tournament 1
        PlayerTournamentStat::create([
            'user_id' => $user->id,
            'tournament_id' => $tournament1->id,
            'matches_played' => 10,
            'matches_won' => 7,
            'matches_lost' => 3,
            'kills' => 25,
            'deaths' => 10,
            'assists' => 15,
            'mvps' => 2,
        ]);

        // Attach stats for Tournament 2
        PlayerTournamentStat::create([
            'user_id' => $user->id,
            'tournament_id' => $tournament2->id,
            'matches_played' => 5,
            'matches_won' => 4,
            'matches_lost' => 1,
            'kills' => 15,
            'deaths' => 5,
            'assists' => 5,
            'mvps' => 1,
        ]);

        // Total calculated expected:
        // Matches Played: 15
        // Wins: 11
        // Losses: 4
        // Kills: 40
        // Deaths: 15
        // Assists: 20
        // MVPs: 3
        // KDA Ratio: (40 + 20) / 15 = 4.00
        // Win Rate: (11 / 15) * 100 = 73.3%

        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);

        // Verify custom sections and aggregated statistics exist on screen
        $response->assertSee('Combat Specification');
        $response->assertSee('KDA RATIO');
        $response->assertSee('4.00');
        $response->assertSee('73.3%');
        $response->assertSee('3'); // MVPs

        // Verify specific tournament names are listed
        $response->assertSee('Cyber Cup 2026');
        $response->assertSee('Neon Invitational');
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
}
