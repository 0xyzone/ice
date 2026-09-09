<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\OwnTeam;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamRosterTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_member_is_main_roster_scopes_and_helpers(): void
    {
        $game = Game::create(['name' => 'PUBG Mobile']);
        $team = OwnTeam::create([
            'name' => 'Alpha Squad',
            'slug' => 'alpha-squad',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $userStarter = User::factory()->create(['name' => 'Starter One', 'username' => 'starter1']);
        $userSub = User::factory()->create(['name' => 'Bench One', 'username' => 'bench1']);

        $starter = TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $userStarter->id,
            'role' => 'captain',
            'is_main_roster' => true,
            'status' => true,
            'joined_at' => now(),
        ]);

        $sub = TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $userSub->id,
            'role' => 'substitute',
            'is_main_roster' => false,
            'status' => true,
            'joined_at' => now(),
        ]);

        $this->assertTrue($starter->isMainRoster());
        $this->assertFalse($sub->isMainRoster());

        $mainRosterMembers = TeamMember::mainRoster()->pluck('id')->toArray();
        $this->assertContains($starter->id, $mainRosterMembers);
        $this->assertNotContains($sub->id, $mainRosterMembers);

        $reserveMembers = TeamMember::reserves()->pluck('id')->toArray();
        $this->assertContains($sub->id, $reserveMembers);
        $this->assertNotContains($starter->id, $reserveMembers);
    }

    public function test_team_profile_displays_main_roster_and_reserve_sections(): void
    {
        $game = Game::create(['name' => 'Mobile Legends']);
        $team = OwnTeam::create([
            'name' => 'Ice Tigers',
            'slug' => 'ice-tigers',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $starter = User::factory()->create(['name' => 'Apex Striker', 'username' => 'apex_striker']);
        $reserve = User::factory()->create(['name' => 'Bench Guardian', 'username' => 'bench_guardian']);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $starter->id,
            'role' => 'player',
            'is_main_roster' => true,
            'status' => true,
            'joined_at' => now(),
        ]);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $reserve->id,
            'role' => 'substitute',
            'is_main_roster' => false,
            'status' => true,
            'joined_at' => now(),
        ]);

        $response = $this->get('/team/ice-tigers');

        $response->assertStatus(200);
        $response->assertSee('Main Roster Lineup');
        $response->assertSee('Reserves & Normal Squad');
        $response->assertSee('Apex Striker');
        $response->assertSee('Bench Guardian');
        $response->assertSee('⚡ MAIN LINEUP');
        $response->assertSee('🛡️ RESERVE');
    }

    public function test_homepage_shows_differentiated_main_and_reserve_badges(): void
    {
        $game = Game::create(['name' => 'Valorant']);
        $team = OwnTeam::create([
            'name' => 'Cyber Wolves',
            'slug' => 'cyber-wolves',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $starter = User::factory()->create(['name' => 'Ghost Runner', 'username' => 'ghost_runner']);
        $reserve = User::factory()->create(['name' => 'Shadow Standby', 'username' => 'shadow_standby']);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $starter->id,
            'role' => 'captain',
            'is_main_roster' => true,
            'status' => true,
            'joined_at' => now(),
        ]);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $reserve->id,
            'role' => 'substitute',
            'is_main_roster' => false,
            'status' => true,
            'joined_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Ghost Runner');
        $response->assertSee('Shadow Standby');
        $response->assertSee('MAIN');
        $response->assertSee('RESERVE');
        $response->assertSee('⚡ MAIN ROSTER');
        $response->assertSee('🛡️ RESERVE');
    }

    public function test_player_profile_shows_lineup_status_badge(): void
    {
        $game = Game::create(['name' => 'Dota 2']);
        $team = OwnTeam::create([
            'name' => 'Viper Core',
            'slug' => 'viper-core',
            'status' => true,
            'game_id' => $game->id,
        ]);

        $user = User::factory()->create(['name' => 'Roster Hero', 'username' => 'roster_hero']);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'captain',
            'is_main_roster' => true,
            'status' => true,
            'joined_at' => now(),
        ]);

        $response = $this->get('/player/roster_hero');

        $response->assertStatus(200);
        $response->assertSee('⚡ MAIN ROSTER');
        $response->assertSee('Captain');
    }
}
