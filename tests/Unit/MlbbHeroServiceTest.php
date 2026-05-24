<?php

namespace Tests\Unit;

use App\Services\MlbbHeroService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MlbbHeroServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /**
     * Test that heroes list is correctly fetched and cached from API.
     */
    public function test_get_heroes_fetches_and_caches_from_api(): void
    {
        Http::fake([
            'https://mlbb-wiki-api.vercel.app/api/heroes' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'hero_name' => 'Miya',
                        'icon' => 'https://example.com/miya.png',
                        'role' => 'Marksman',
                    ],
                    [
                        'hero_name' => 'Saber',
                        'icon' => 'https://example.com/saber.png',
                        'role' => 'Assassin',
                    ],
                ],
            ], 200),
        ]);

        $service = new MlbbHeroService;
        $heroes = $service->getHeroes();

        $this->assertCount(2, $heroes);
        $this->assertArrayHasKey('Miya', $heroes);
        $this->assertArrayHasKey('Saber', $heroes);
        $this->assertEquals('https://example.com/miya.png', $heroes['Miya']['icon']);

        // Verify it was cached
        $this->assertTrue(Cache::has('mlbb_heroes_list'));

        // If we fake different data, the cached version is still returned
        Http::fake([
            'https://mlbb-wiki-api.vercel.app/api/heroes' => Http::response(['success' => false], 500),
        ]);

        $cachedHeroes = $service->getHeroes();
        $this->assertCount(2, $cachedHeroes);
    }

    /**
     * Test that service falls back to Enum cases when API fails.
     */
    public function test_get_heroes_falls_back_to_enum_on_failure(): void
    {
        Http::fake([
            'https://mlbb-wiki-api.vercel.app/api/heroes' => Http::response(null, 500),
        ]);

        $service = new MlbbHeroService;
        $heroes = $service->getHeroes();

        // Should fall back to the MlbbHero enum cases
        $this->assertNotEmpty($heroes);
        $this->assertArrayHasKey('Miya', $heroes);
        $this->assertNull($heroes['Miya']['icon']);
    }

    /**
     * Test getting a single hero icon.
     */
    public function test_get_hero_icon(): void
    {
        Http::fake([
            'https://mlbb-wiki-api.vercel.app/api/heroes' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'hero_name' => 'Miya',
                        'icon' => 'https://example.com/miya.png',
                    ],
                ],
            ], 200),
        ]);

        $service = new MlbbHeroService;
        $this->assertEquals('https://example.com/miya.png', $service->getHeroIcon('Miya'));
        $this->assertNull($service->getHeroIcon('UnknownHero'));
    }

    /**
     * Test getting options list.
     */
    public function test_get_hero_options(): void
    {
        Http::fake([
            'https://mlbb-wiki-api.vercel.app/api/heroes' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'hero_name' => 'Saber',
                        'icon' => 'https://example.com/saber.png',
                    ],
                    [
                        'hero_name' => 'Miya',
                        'icon' => 'https://example.com/miya.png',
                    ],
                ],
            ], 200),
        ]);

        $service = new MlbbHeroService;
        $options = $service->getHeroOptions();

        $this->assertEquals([
            'Miya' => 'Miya',
            'Saber' => 'Saber',
        ], $options);
    }
}
