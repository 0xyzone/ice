<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Database\Seeders\ShieldSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use STS\FilamentImpersonate\Facades\Impersonation;
use Tests\TestCase;

class ImpersonatePlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_can_impersonate_and_only_players_can_be_impersonated(): void
    {
        $this->seed(ShieldSeeder::class);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $player = User::factory()->create();
        $player->assignRole('player');

        $this->assertTrue($superAdmin->canImpersonate());
        $this->assertFalse($admin->canImpersonate());
        $this->assertFalse($player->canImpersonate());

        $this->assertTrue($player->canBeImpersonated());
        $this->assertFalse($admin->canBeImpersonated());
        $this->assertFalse($superAdmin->canBeImpersonated());
    }

    public function test_impersonate_button_is_only_visible_to_super_admin_and_redirects_to_app_panel(): void
    {
        $this->seed(ShieldSeeder::class);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $player = User::factory()->create();
        $player->assignRole('player');

        Filament::setCurrentPanel(Filament::getPanel('mukhiyas'));

        $this->actingAs($admin);
        Livewire::test(ListUsers::class)
            ->assertTableActionHidden('impersonate', $player);

        $this->actingAs($superAdmin);
        Livewire::test(ListUsers::class)
            ->assertTableActionVisible('impersonate', $player)
            ->callTableAction('impersonate', $player)
            ->assertRedirect(Filament::getPanel('app')->getUrl());

        $this->assertTrue(Impersonation::isImpersonating());
        $this->assertSame($player->id, auth()->id());
    }
}
