<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that avatar_full_url is automatically appended to the serialized array and json.
     */
    public function test_avatar_full_url_is_appended_to_serialized_formats(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'avatar_url' => 'avatars/johndoe.png',
        ]);

        $array = $user->toArray();
        $this->assertArrayHasKey('avatar_full_url', $array);
        $this->assertEquals(asset('storage/avatars/johndoe.png'), $array['avatar_full_url']);

        $json = $user->toJson();
        $this->assertStringContainsString('avatar_full_url', $json);
    }

    /**
     * Test avatar_full_url fallback when avatar_url is null.
     */
    public function test_avatar_full_url_fallback_when_avatar_url_is_null(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'avatar_url' => null,
        ]);

        $array = $user->toArray();
        $this->assertArrayHasKey('avatar_full_url', $array);
        $this->assertEquals('https://ui-avatars.com/api/?name=John Doe', $array['avatar_full_url']);
    }
}
