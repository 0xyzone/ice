<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\FreeFireRole;
use App\Enums\GameType;
use App\Enums\MlbbRole;
use App\Enums\PubgRole;
use App\Models\EsportsMatch;
use App\Models\GameInfo;
use App\Models\MatchSeries;
use App\Models\OwnTeam;
use App\Models\PlayerMatchStat;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_types_and_roles_are_correctly_configured(): void
    {
        $this->assertEquals('Mobile Legends: Bang Bang', GameType::Mlbb->getLabel());
        $this->assertEquals('PUBG Mobile', GameType::PubgMobile->getLabel());
        $this->assertEquals('Free Fire', GameType::FreeFire->getLabel());

        $this->assertTrue(GameType::Mlbb->isMoba());
        $this->assertFalse(GameType::Mlbb->isBattleRoyale());

        $this->assertTrue(GameType::PubgMobile->isBattleRoyale());
        $this->assertTrue(GameType::FreeFire->isBattleRoyale());

        // Test roles
        $this->assertArrayHasKey(MlbbRole::GoldLane->value, GameType::Mlbb->getRoles());
        $this->assertArrayHasKey(PubgRole::Assaulter->value, GameType::PubgMobile->getRoles());
        $this->assertArrayHasKey(FreeFireRole::Rusher->value, GameType::FreeFire->getRoles());

        // Test maps
        $this->assertArrayHasKey('Sanctum Island', GameType::Mlbb->getMaps());
        $this->assertArrayHasKey('Erangel', GameType::PubgMobile->getMaps());
        $this->assertArrayHasKey('Bermuda', GameType::FreeFire->getMaps());
    }

    public function test_player_can_create_game_specific_profile_infos(): void
    {
        $user = User::factory()->create([
            'name' => 'Ketan Gamer',
            'username' => 'ketan_gamer',
        ]);

        // MLBB Profile
        $mlbbInfo = GameInfo::create([
            'user_id' => $user->id,
            'game' => GameType::Mlbb,
            'in_game_id' => '12345678',
            'server_id' => '2001',
            'in_game_username' => 'KetanML',
            'role' => MlbbRole::GoldLane->value,
            'main_heroes' => ['Beatrix', 'Claude'],
            'status' => true,
        ]);

        // PUBG Mobile Profile
        $pubgInfo = GameInfo::create([
            'user_id' => $user->id,
            'game' => GameType::PubgMobile,
            'in_game_id' => '5123456789',
            'in_game_username' => 'KetanPUBG',
            'role' => PubgRole::Assaulter->value,
            'device_type' => 'Smartphone (iOS/Android)',
            'status' => true,
        ]);

        // Free Fire Profile
        $ffInfo = GameInfo::create([
            'user_id' => $user->id,
            'game' => GameType::FreeFire,
            'in_game_id' => '987654321',
            'in_game_username' => 'KetanFF',
            'role' => FreeFireRole::Rusher->value,
            'status' => true,
        ]);

        $this->assertEquals('Mobile Legends: Bang Bang', $mlbbInfo->gameLabel);
        $this->assertEquals('Gold Laner', $mlbbInfo->roleLabel);
        $this->assertContains('Beatrix', $mlbbInfo->main_heroes);

        $this->assertEquals('PUBG Mobile', $pubgInfo->gameLabel);
        $this->assertEquals('Assaulter / Entry', $pubgInfo->roleLabel);

        $this->assertEquals('Free Fire', $ffInfo->gameLabel);
        $this->assertEquals('Rusher / Entry Frag', $ffInfo->roleLabel);

        // Verify profile route renders the multi-game accounts
        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);
        $response->assertSee('KetanML');
        $response->assertSee('KetanPUBG');
        $response->assertSee('KetanFF');
        $response->assertSee('Gold Laner');
        $response->assertSee('Assaulter / Entry');
        $response->assertSee('Rusher / Entry Frag');
        $response->assertSee('Beatrix');
    }

    public function test_battle_royale_round_scoring_and_telemetry(): void
    {
        $user = User::factory()->create([
            'name' => 'PUBG Pro',
            'username' => 'pubg_pro',
        ]);

        $team = OwnTeam::create([
            'name' => 'Chicken Hunters',
            'slug' => 'chicken-hunters',
            'status' => true,
            'game' => GameType::PubgMobile,
        ]);

        $tournament = Tournament::create([
            'name' => 'PUBG Mobile Pro League (PMPL)',
            'prize_pool' => '25000',
            'status' => 'completed',
            'game' => GameType::PubgMobile,
        ]);

        $match = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Grand Finals Lobby A',
            'match_date' => now(),
            'status' => 'completed',
        ]);

        // Round 1: Erangel - #1 WWCD (10 placement pts + 8 kill pts = 18 total pts)
        $round1 = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 1,
            'map_name' => 'Erangel',
            'placement' => 1,
            'placement_points' => 10,
            'kill_points' => 8,
            'total_points' => 18,
            'did_we_win' => true,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $round1->id,
            'user_id' => $user->id,
            'kills' => 5,
            'damage_dealt' => 1250,
            'survival_time' => 1350, // 22m 30s
            'knockdowns' => 4,
            'revives' => 1,
            'is_mvp' => true,
        ]);

        $this->assertEquals('won', $round1->fresh()->result);
        $this->assertTrue($match->fresh()->is_winner);
        $this->assertEquals(18, $match->fresh()->total_points);
        $this->assertEquals(1, $match->fresh()->placement);

        // Check player profile displays Battle Royale stats accurately
        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);
        $response->assertSee('PUBG Mobile Pro League (PMPL)');
        $response->assertSee('WWCD / Winner');
        $response->assertSee('18 pts');
        $response->assertSee('5 Kills');
        $response->assertSee('1,250 Dmg');
        $response->assertSee('⏱ 22:30');
    }

    public function test_moba_match_scoring_and_telemetry(): void
    {
        $user = User::factory()->create([
            'name' => 'Fanny God',
            'username' => 'fanny_god',
        ]);

        $team = OwnTeam::create([
            'name' => 'Icecream MLBB',
            'slug' => 'icecream-mlbb',
            'status' => true,
            'game' => GameType::Mlbb,
        ]);

        $tournament = Tournament::create([
            'name' => 'MPL Season 14',
            'prize_pool' => '100000',
            'status' => 'completed',
            'game' => GameType::Mlbb,
        ]);

        $match = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Blacklist International',
            'match_date' => now(),
            'best_of' => 3,
            'status' => 'completed',
        ]);

        $game1 = MatchSeries::create([
            'match_id' => $match->id,
            'game_number' => 1,
            'map_name' => 'Sanctum Island',
            'our_score' => 22,
            'opponent_score' => 11,
        ]);

        PlayerMatchStat::create([
            'match_series_id' => $game1->id,
            'user_id' => $user->id,
            'kills' => 12,
            'deaths' => 1,
            'assists' => 7,
            'hero' => 'Fanny',
            'total_gold' => 14500,
            'damage_dealt' => 98000,
            'turret_damage' => 4500,
            'is_mvp' => true,
        ]);

        $this->assertEquals('won', $game1->fresh()->result);
        $this->assertEquals(1, $match->fresh()->our_score);
        $this->assertEquals(0, $match->fresh()->opponent_score);

        $response = $this->get("/player/{$user->id}");
        $response->assertStatus(200);
        $response->assertSee('MPL Season 14');
        $response->assertSee('Fanny');
        $response->assertSee('12/1/7');
        $response->assertSee('14,500');
        $response->assertSee('4,500');
    }
}
