<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UnifiedAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('ICECREAM');
        $response->assertSee('DECRYPT');
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/app');
        $response->assertRedirect('/login');

        $response = $this->get('/mukhiyas');
        $response->assertRedirect('/login');
    }

    public function test_user_can_login_with_email_or_username(): void
    {
        $user = User::factory()->create([
            'email' => 'player@example.com',
            'username' => 'pro_player',
            'password' => bcrypt('secret-key'),
        ]);

        // Assign 'player' role
        $role = Role::create(['name' => 'player']);
        $user->assignRole($role);

        // Test login with email
        $response = $this->post('/login', [
            'login' => 'player@example.com',
            'password' => 'secret-key',
        ]);

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Test login with username
        $response = $this->post('/login', [
            'login' => 'pro_player',
            'password' => 'secret-key',
        ]);

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_redirects_to_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
