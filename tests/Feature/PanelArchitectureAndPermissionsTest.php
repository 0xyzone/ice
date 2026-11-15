<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\GameType;
use App\Filament\App\Pages\ManageProfile;
use App\Filament\App\Resources\GameInfos\GameInfoResource;
use App\Filament\Resources\Admins\AdminResource;
use App\Filament\Resources\Matches\MatchResource;
use App\Filament\Resources\OwnTeams\OwnTeamResource;
use App\Filament\Resources\Tournaments\TournamentResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\EsportsMatch;
use App\Models\GameInfo;
use App\Models\OwnTeam;
use App\Models\Tournament;
use App\Models\User;
use BezhanSalleh\FilamentShield\Resources\Roles\RoleResource;
use Database\Seeders\ShieldSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PanelArchitectureAndPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_own_teams_table_does_not_have_slug_column_and_team_route_uses_id(): void
    {
        $this->assertFalse(Schema::hasColumn('own_teams', 'slug'));

        $team = OwnTeam::create([
            'name' => 'Ice Cream Elite',
            'status' => true,
            'game' => GameType::Mlbb,
        ]);

        $this->get("/team/{$team->id}")
            ->assertOk()
            ->assertSee('Ice Cream Elite');

        $this->get('/team/ice-cream-elite')
            ->assertNotFound();
    }

    public function test_mukhiyas_panel_hides_game_infos_and_manage_profile(): void
    {
        $panel = Filament::getPanel('mukhiyas');

        $this->assertNotContains(GameInfoResource::class, $panel->getResources());
        $this->assertNotContains(ManageProfile::class, $panel->getPages());
    }

    public function test_strict_three_tier_role_and_permission_segregation(): void
    {
        $this->seed(ShieldSeeder::class);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $player = User::factory()->create();
        $player->assignRole('player');

        $team = OwnTeam::create([
            'name' => 'Test Division',
            'status' => true,
            'game' => GameType::PubgMobile,
        ]);
        $tournament = Tournament::create([
            'name' => 'Test Cup',
            'status' => 'ongoing',
            'game' => GameType::PubgMobile,
        ]);
        $match = EsportsMatch::create([
            'tournament_id' => $tournament->id,
            'own_team_id' => $team->id,
            'opponent_name' => 'Rivals',
            'match_date' => now(),
            'status' => 'upcoming',
        ]);
        $role = Role::where('name', 'player')->firstOrFail();

        // Super Admin: full admin panel access, no player-only permissions
        $this->actingAs($superAdmin);
        $this->assertTrue($superAdmin->can('viewAny', Role::class));
        $this->assertTrue(AdminResource::can('viewAny'));
        $this->assertTrue(UserResource::can('viewAny'));
        $this->assertTrue($superAdmin->can('viewAny', OwnTeam::class));
        $this->assertTrue($superAdmin->can('viewAny', Tournament::class));
        $this->assertTrue($superAdmin->can('viewAny', EsportsMatch::class));
        $this->assertFalse($superAdmin->hasPermissionTo('ViewAny:GameInfoResource'));
        $this->assertFalse($superAdmin->hasPermissionTo('View:ManageProfile'));

        // Admin: esports & players only, no RoleResource / AdminResource / GameInfo
        $this->actingAs($admin);
        $this->assertFalse($admin->can('viewAny', $role));
        $this->assertFalse(AdminResource::can('viewAny'));
        $this->assertTrue(UserResource::can('viewAny'));
        $this->assertTrue($admin->can('viewAny', OwnTeam::class));
        $this->assertTrue($admin->can('viewAny', Tournament::class));
        $this->assertTrue($admin->can('viewAny', EsportsMatch::class));
        $this->assertFalse($admin->can('viewAny', GameInfo::class));
        $this->assertFalse($admin->can('View:ManageProfile'));

        // Player: GameInfo, ManageProfile, view Tournament only
        $this->actingAs($player);
        $this->assertFalse($player->can('viewAny', Role::class));
        $this->assertFalse(AdminResource::can('viewAny'));
        $this->assertFalse(UserResource::can('viewAny'));
        $this->assertFalse($player->can('viewAny', OwnTeam::class));
        $this->assertFalse($player->can('viewAny', $match));
        $this->assertTrue($player->can('viewAny', GameInfo::class));
        $this->assertTrue($player->can('View:ManageProfile'));
        $this->assertTrue($player->can('viewAny', Tournament::class));
        $this->assertFalse($player->can('create', Tournament::class));

        // Verify RoleResource and OwnTeamResource classes exist
        $this->assertTrue(class_exists(RoleResource::class));
        $this->assertTrue(class_exists(OwnTeamResource::class));
        $this->assertTrue(class_exists(TournamentResource::class));
        $this->assertTrue(class_exists(MatchResource::class));
    }

    public function test_manage_profile_page_renders_with_tabbed_sections(): void
    {
        $this->seed(ShieldSeeder::class);

        $player = User::factory()->create();
        $player->assignRole('player');

        $this->actingAs($player);
        Filament::setCurrentPanel('app');

        Livewire::test(ManageProfile::class)
            ->assertOk()
            ->assertSee('Personal & Bio')
            ->assertSee('Emergency Contact')
            ->assertSee('Socials & Gallery')
            ->assertSee('Legal Documents');
    }
}
