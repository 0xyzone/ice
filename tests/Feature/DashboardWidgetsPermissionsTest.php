<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\GameType;
use App\Filament\App\Widgets\PlayerGameAccountsWidget;
use App\Filament\App\Widgets\PlayerHero3DWidget;
use App\Filament\App\Widgets\PlayerProfileLinkWidget;
use App\Filament\App\Widgets\PlayerStatsOverviewWidget;
use App\Filament\App\Widgets\PlayerTeamsWidget;
use App\Filament\App\Widgets\PlayerTimelineWidget;
use App\Filament\App\Widgets\PlayerTournamentsWidget;
use App\Filament\App\Widgets\PlayerUpcomingMatchesWidget;
use App\Filament\App\Widgets\PlayerWinsLossesChart;
use App\Filament\Widgets\GameDivisionBreakdownWidget;
use App\Filament\Widgets\MukhiyasHero3DWidget;
use App\Filament\Widgets\MukhiyasStatsOverview;
use App\Filament\Widgets\PlayersRegistrationChart;
use App\Filament\Widgets\RecentPlayersWidget;
use App\Filament\Widgets\RecentTournamentsWidget;
use App\Filament\Widgets\SuperAdminAccessOverviewWidget;
use App\Filament\Widgets\TournamentsStatusChart;
use App\Filament\Widgets\UpcomingMatchesWidget;
use App\Models\GameInfo;
use App\Models\OwnTeam;
use App\Models\TeamMember;
use App\Models\User;
use Database\Seeders\ShieldSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_all_mukhiyas_widgets(): void
    {
        $this->seed(ShieldSeeder::class);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $this->actingAs($superAdmin);
        Filament::setCurrentPanel(Filament::getPanel('mukhiyas'));

        $this->assertTrue(MukhiyasHero3DWidget::canView());
        $this->assertTrue(SuperAdminAccessOverviewWidget::canView());
        $this->assertTrue(GameDivisionBreakdownWidget::canView());
        $this->assertTrue(UpcomingMatchesWidget::canView());
        $this->assertTrue(MukhiyasStatsOverview::canView());
        $this->assertTrue(RecentTournamentsWidget::canView());
        $this->assertTrue(RecentPlayersWidget::canView());
        $this->assertTrue(PlayersRegistrationChart::canView());
        $this->assertTrue(TournamentsStatusChart::canView());
    }

    public function test_admin_can_view_operational_mukhiyas_widgets_but_not_super_admin_overview(): void
    {
        $this->seed(ShieldSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('mukhiyas'));

        $this->assertTrue(MukhiyasHero3DWidget::canView());
        $this->assertTrue(GameDivisionBreakdownWidget::canView());
        $this->assertTrue(UpcomingMatchesWidget::canView());
        $this->assertTrue(MukhiyasStatsOverview::canView());
        $this->assertFalse(SuperAdminAccessOverviewWidget::canView());
    }

    public function test_player_cannot_view_mukhiyas_widgets_and_can_view_app_widgets(): void
    {
        $this->seed(ShieldSeeder::class);

        $player = User::factory()->create();
        $player->assignRole('player');

        $this->actingAs($player);

        $this->assertFalse(MukhiyasHero3DWidget::canView());
        $this->assertFalse(SuperAdminAccessOverviewWidget::canView());
        $this->assertFalse(RecentPlayersWidget::canView());
        $this->assertFalse(MukhiyasStatsOverview::canView());
        $this->assertFalse(GameDivisionBreakdownWidget::canView());
        $this->assertFalse(UpcomingMatchesWidget::canView());

        $this->assertTrue(PlayerHero3DWidget::canView());
        $this->assertTrue(PlayerGameAccountsWidget::canView());
        $this->assertTrue(PlayerUpcomingMatchesWidget::canView());
        $this->assertTrue(PlayerStatsOverviewWidget::canView());
        $this->assertTrue(PlayerProfileLinkWidget::canView());
        $this->assertTrue(PlayerTeamsWidget::canView());
        $this->assertTrue(PlayerTournamentsWidget::canView());
        $this->assertTrue(PlayerWinsLossesChart::canView());
        $this->assertTrue(PlayerTimelineWidget::canView());
    }

    public function test_mukhiyas_and_app_3d_and_division_widgets_render_with_real_database_data(): void
    {
        $this->seed(ShieldSeeder::class);

        $superAdmin = User::factory()->create(['name' => 'Boss Mukhiya']);
        $superAdmin->assignRole('super_admin');

        $playerOne = User::factory()->create(['name' => 'Alpha Player']);
        $playerOne->assignRole('player');

        $playerTwo = User::factory()->create(['name' => 'Other Player']);
        $playerTwo->assignRole('player');

        $team = OwnTeam::create([
            'name' => 'Ice Cream PUBGM',
            'status' => true,
            'game' => GameType::PubgMobile,
        ]);

        TeamMember::create([
            'own_team_id' => $team->id,
            'user_id' => $playerOne->id,
            'status' => true,
        ]);

        GameInfo::create([
            'user_id' => $playerOne->id,
            'game' => GameType::PubgMobile,
            'in_game_username' => 'ALPHA_CRASH',
            'in_game_id' => '5123456789',
            'roles' => ['igl', 'fragger'],
            'status' => true,
        ]);

        GameInfo::create([
            'user_id' => $playerTwo->id,
            'game' => GameType::FreeFire,
            'in_game_username' => 'OTHER_SNIPER',
            'in_game_id' => '9988776655',
            'roles' => ['sniper'],
            'status' => true,
        ]);

        $this->actingAs($superAdmin);
        Filament::setCurrentPanel(Filament::getPanel('mukhiyas'));

        Livewire::test(MukhiyasHero3DWidget::class)
            ->assertOk()
            ->assertSee('Boss Mukhiya');

        Livewire::test(GameDivisionBreakdownWidget::class)
            ->assertOk()
            ->assertSee('PUBG Mobile')
            ->assertSee('Free Fire');

        $this->actingAs($playerOne);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(PlayerHero3DWidget::class)
            ->assertOk()
            ->assertSee('Alpha Player');

        Livewire::test(PlayerGameAccountsWidget::class)
            ->assertOk()
            ->assertSee('ALPHA_CRASH')
            ->assertDontSee('OTHER_SNIPER');
    }
}
