<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AccountStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'player']);
        Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_active_player_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'active_player@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);
        $user->assignRole('player');

        $response = $this->post('/login', [
            'login' => 'active_player@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);
    }

    public function test_deactivated_player_is_blocked_and_redirected_to_deactivated_page(): void
    {
        $user = User::factory()->create([
            'email' => 'banned_player@example.com',
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);
        $user->assignRole('player');

        $response = $this->post('/login', [
            'login' => 'banned_player@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('auth.deactivated'));
        $this->assertGuest();
    }

    public function test_deactivated_notice_page_renders_successfully(): void
    {
        $response = $this->get(route('auth.deactivated'));

        $response->assertStatus(200);
        $response->assertSee('ACCOUNT');
        $response->assertSee('DEACTIVATED');
        $response->assertSee('Access Denied by Administrator');
    }

    public function test_deactivated_user_cannot_access_filament_panel(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
        ]);
        $user->assignRole('player');

        $this->assertFalse($user->isActive());
    }
}
