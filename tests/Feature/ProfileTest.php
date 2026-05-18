<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\OwnTeam;
use App\Models\PlayerDetail;
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
}
