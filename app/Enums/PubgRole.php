<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PubgRole: string implements HasColor, HasLabel
{
    case Igl = 'igl';
    case Fragger = 'fragger';
    case Assaulter = 'assaulter';
    case Sniper = 'sniper';
    case Scout = 'scout';
    case Support = 'support';

    public function getLabel(): string
    {
        return match ($this) {
            self::Igl => 'IGL (In-Game Leader)',
            self::Fragger => 'Fragger',
            self::Assaulter => 'Assaulter',
            self::Sniper => 'Sniper / DMR',
            self::Scout => 'Scout / Recon',
            self::Support => 'Supporter',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Igl => 'warning',
            self::Fragger => 'danger',
            self::Assaulter => 'primary',
            self::Sniper => 'info',
            self::Scout => 'gray',
            self::Support => 'success',
        };
    }

    public function rank(): int
    {
        return match ($this) {
            self::Igl => 1,
            self::Fragger => 2,
            self::Assaulter => 3,
            self::Sniper => 4,
            self::Scout => 5,
            self::Support => 6,
        };
    }

    public static function rankFor(?string $value): int
    {
        if (! $value) {
            return 999;
        }

        return self::tryFrom($value)?->rank() ?? 999;
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->sortBy(fn (self $role): int => $role->rank())
            ->mapWithKeys(fn (self $role) => [$role->value => $role->getLabel()])
            ->toArray();
    }
}
