<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum GameType: string implements HasColor, HasIcon, HasLabel
{
    case Mlbb = 'mlbb';
    case PubgMobile = 'pubg_mobile';
    case FreeFire = 'free_fire';

    public function getLabel(): string
    {
        return match ($this) {
            self::Mlbb => 'Mobile Legends: Bang Bang',
            self::PubgMobile => 'PUBG Mobile',
            self::FreeFire => 'Free Fire',
        };
    }

    public function getShortName(): string
    {
        return match ($this) {
            self::Mlbb => 'MLBB',
            self::PubgMobile => 'PUBGM',
            self::FreeFire => 'FF',
        };
    }

    public function getLogoPath(): string
    {
        return match ($this) {
            self::Mlbb => 'images/games/mlbb.svg',
            self::PubgMobile => 'images/games/pubg-mobile.svg',
            self::FreeFire => 'images/games/free-fire.svg',
        };
    }

    public function getLogoUrl(): string
    {
        return asset($this->getLogoPath());
    }

    public function getCategory(): string
    {
        return match ($this) {
            self::Mlbb => 'moba',
            self::PubgMobile, self::FreeFire => 'battle_royale',
        };
    }

    public function isMoba(): bool
    {
        return $this->getCategory() === 'moba';
    }

    public function isBattleRoyale(): bool
    {
        return $this->getCategory() === 'battle_royale';
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Mlbb => 'info',
            self::PubgMobile => 'warning',
            self::FreeFire => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Mlbb => 'heroicon-m-sparkles',
            self::PubgMobile => 'heroicon-m-shield-check',
            self::FreeFire => 'heroicon-m-fire',
        };
    }

    /**
     * @return array<string, string>
     */
    public function getRoles(): array
    {
        return match ($this) {
            self::Mlbb => MlbbRole::options(),
            self::PubgMobile => PubgRole::options(),
            self::FreeFire => FreeFireRole::options(),
        };
    }

    public function getRoleRank(?string $role): int
    {
        return match ($this) {
            self::Mlbb => MlbbRole::rankFor($role),
            self::PubgMobile => PubgRole::rankFor($role),
            self::FreeFire => FreeFireRole::rankFor($role),
        };
    }

    /**
     * @return array<string, string>
     */
    public function getMaps(): array
    {
        return match ($this) {
            self::Mlbb => [
                'Sanctum Island' => 'Sanctum Island',
                'Celestial Palace' => 'Celestial Palace',
                'Western Desert' => 'Western Desert',
                'Imperial Sanctuary' => 'Imperial Sanctuary',
            ],
            self::PubgMobile => [
                'Erangel' => 'Erangel',
                'Miramar' => 'Miramar',
                'Sanhok' => 'Sanhok',
                'Vikendi' => 'Vikendi',
                'Livik' => 'Livik',
                'Karakin' => 'Karakin',
            ],
            self::FreeFire => [
                'Bermuda' => 'Bermuda',
                'Purgatory' => 'Purgatory',
                'Kalahari' => 'Kalahari',
                'Alpine' => 'Alpine',
                'NeXT' => 'NeXT',
            ],
        };
    }
}
