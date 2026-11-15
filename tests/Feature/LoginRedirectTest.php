<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'player']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'super_admin']);
    }

    public function test_super_admin_is_redirected_to_mukhiyas_even_if_app_was_intended(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('super_admin');

        $response = $this->withSession(['url.intended' => url('/app')])
            ->post('/login', [
                'login' => $user->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(url('/mukhiyas'));
    }

    public function test_player_is_redirected_to_app_even_if_mukhiyas_was_intended(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('player');

        $response = $this->withSession(['url.intended' => url('/mukhiyas')])
            ->post('/login', [
                'login' => $user->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(url('/app'));
    }

    public function test_player_is_redirected_to_intended_app_subpage(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('player');

        $response = $this->withSession(['url.intended' => url('/app/manage-profile')])
            ->post('/login', [
                'login' => $user->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(url('/app/manage-profile'));
    }

    public function test_admin_can_redirect_to_intended_app_or_default_to_mukhiyas(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('admin');

        $this->withSession(['url.intended' => url('/app')])
            ->post('/login', [
                'login' => $user->email,
                'password' => 'password',
            ])
            ->assertRedirect(url('/app'));

        $this->post('/logout');

        $this->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ])->assertRedirect(url('/mukhiyas'));
    }

    public function test_user_without_panel_role_is_redirected_to_homepage(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }
}
