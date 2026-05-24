<?php

namespace App\Services;

use App\Enums\MlbbHero;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MlbbHeroService
{
    /**
     * Fetch and cache all MLBB heroes from the API, falling back to enum cases.
     *
     * @return array<string, array{name: string, icon: ?string, role: ?string}>
     */
    public function getHeroes(): array
    {
        return Cache::remember('mlbb_heroes_list', now()->addDay(), function (): array {
            try {
                $response = Http::timeout(5)
                    ->retry(2, 100)
                    ->get('https://mlbb-wiki-api.vercel.app/api/heroes');

                if ($response->successful()) {
                    $json = $response->json();
                    if (isset($json['success']) && $json['success'] && isset($json['data']) && is_array($json['data'])) {
                        $heroes = [];
                        foreach ($json['data'] as $item) {
                            if (isset($item['hero_name'])) {
                                $name = $item['hero_name'];
                                $heroes[$name] = [
                                    'name' => $name,
                                    'icon' => $item['icon'] ?? null,
                                    'role' => $item['role'] ?? null,
                                ];
                            }
                        }

                        if (! empty($heroes)) {
                            return $heroes;
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to fetch MLBB heroes from API: '.$e->getMessage());
            }

            // Fallback: Generate list from our Enum cases
            $fallback = [];
            foreach (MlbbHero::cases() as $case) {
                $fallback[$case->value] = [
                    'name' => $case->value,
                    'icon' => null,
                    'role' => null,
                ];
            }

            return $fallback;
        });
    }

    /**
     * Get the icon URL of a specific hero.
     */
    public function getHeroIcon(string $name): ?string
    {
        $heroes = $this->getHeroes();

        return $heroes[$name]['icon'] ?? null;
    }

    /**
     * Get associative array of hero names sorted alphabetically.
     *
     * @return array<string, string>
     */
    public function getHeroOptions(): array
    {
        $heroes = $this->getHeroes();
        $options = [];

        foreach ($heroes as $name => $details) {
            $options[$name] = $name;
        }

        ksort($options);

        return $options;
    }
}
