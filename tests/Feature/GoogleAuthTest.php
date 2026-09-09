<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'player']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'super_admin']);
    }

    public function test_google_redirect_sets_session_and_redirects(): void
    {
        $response = $this->get(route('auth.google.redirect'));

        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
        $this->assertEquals('login', session('google_oauth_mode'));
    }

    public function test_google_redirect_for_logged_in_user_sets_connect_mode(): void
    {
        $user = User::factory()->create();
        $user->assignRole('player');

        $response = $this->actingAs($user)->get(route('auth.google.redirect'));

        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
        $this->assertEquals('connect', session('google_oauth_mode'));
    }

    public function test_login_with_existing_google_id_authenticates_user(): void
    {
        $user = User::factory()->create([
            'email' => 'player@example.com',
            'google_id' => 'google-test-id-123',
        ]);
        $user->assignRole('player');

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-test-id-123');
        $abstractUser->shouldReceive('getEmail')->andReturn('player@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://google.com/avatar.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_matching_email_links_google_id_and_authenticates(): void
    {
        $user = User::factory()->create([
            'email' => 'pro_gamer@gmail.com',
            'google_id' => null,
        ]);
        $user->assignRole('player');

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unique-999');
        $abstractUser->shouldReceive('getEmail')->andReturn('pro_gamer@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://google.com/avatar999.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect('/app');
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertEquals('google-unique-999', $user->google_id);
        $this->assertEquals('https://google.com/avatar999.jpg', $user->google_avatar_url);
    }

    public function test_login_with_unregistered_google_account_is_blocked(): void
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unregistered');
        $abstractUser->shouldReceive('getEmail')->andReturn('unknown@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect('/login');
        $this->assertGuest();
        $response->assertSessionHasErrors('login');
    }

    public function test_authenticated_player_can_connect_google_account(): void
    {
        $user = User::factory()->create([
            'email' => 'player_self@example.com',
            'google_id' => null,
        ]);
        $user->assignRole('player');

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-connected-555');
        $abstractUser->shouldReceive('getEmail')->andReturn('player_self@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://google.com/photo.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->actingAs($user)
            ->withSession(['google_oauth_mode' => 'connect'])
            ->get(route('auth.google.callback'));

        $response->assertRedirect('/app/manage-profile');
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertEquals('google-connected-555', $user->google_id);
    }

    public function test_authenticated_player_cannot_connect_already_linked_google_account(): void
    {
        User::factory()->create([
            'email' => 'other_player@example.com',
            'google_id' => 'already-taken-google-id',
        ]);

        $currentUser = User::factory()->create([
            'email' => 'my_player@example.com',
            'google_id' => null,
        ]);
        $currentUser->assignRole('player');

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('already-taken-google-id');
        $abstractUser->shouldReceive('getEmail')->andReturn('other_player@example.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->actingAs($currentUser)
            ->withSession(['google_oauth_mode' => 'connect'])
            ->get(route('auth.google.callback'));

        $response->assertRedirect('/app/manage-profile');
        $response->assertSessionHas('error');

        $currentUser->refresh();
        $this->assertNull($currentUser->google_id);
    }

    public function test_authenticated_player_can_disconnect_google_account(): void
    {
        $user = User::factory()->create([
            'google_id' => 'to-be-removed-id',
        ]);
        $user->assignRole('player');

        $response = $this->actingAs($user)->post(route('auth.google.disconnect'));

        $response->assertRedirect('/app/manage-profile');
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertNull($user->google_id);
    }
}
