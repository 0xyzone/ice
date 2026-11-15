<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FreeFireRole: string implements HasColor, HasLabel
{
    case Igl = 'igl';
    case PrimaryRusher = 'primary_rusher';
    case SecondaryRusher = 'secondary_rusher';
    case Bomber = 'bomber';
    case Sniper = 'sniper';
    case Flanker = 'flanker';
    case Support = 'support';

    public function getLabel(): string
    {
        return match ($this) {
            self::Igl => 'IGL (In-Game Leader)',
            self::PrimaryRusher => 'Primary Rusher',
            self::SecondaryRusher => 'Secondary Rusher / Support',
            self::Bomber => 'Bomber / Nader',
            self::Sniper => 'Sniper',
            self::Flanker => 'Flanker',
            self::Support => 'Support / Utility',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Igl => 'warning',
            self::PrimaryRusher => 'danger',
            self::SecondaryRusher => 'primary',
            self::Bomber => 'info',
            self::Sniper => 'info',
            self::Flanker => 'gray',
            self::Support => 'success',
        };
    }

    public function rank(): int
    {
        return match ($this) {
            self::Igl => 1,
            self::PrimaryRusher => 2,
            self::SecondaryRusher => 3,
            self::Bomber => 4,
            self::Sniper => 5,
            self::Flanker => 6,
            self::Support => 7,
        };
    }

    public static function rankFor(?string $value): int
    {
        if (! $value) {
            return 999;
        }

        if ($value === 'rusher') {
            return self::PrimaryRusher->rank();
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
