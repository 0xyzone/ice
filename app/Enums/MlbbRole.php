<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MlbbRole: string implements HasColor, HasLabel
{
    case Jungler = 'jungler';
    case GoldLane = 'gold_lane';
    case MidLane = 'mid_lane';
    case ExpLane = 'exp_lane';
    case Roamer = 'roamer';
    case Flex = 'flex';

    public function getLabel(): string
    {
        return match ($this) {
            self::Jungler => 'Jungler / Hyper',
            self::GoldLane => 'Gold Laner',
            self::MidLane => 'Mid Laner',
            self::ExpLane => 'EXP Laner',
            self::Roamer => 'Roamer / Tank',
            self::Flex => 'Flex / Utility',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Jungler => 'primary',
            self::GoldLane => 'warning',
            self::MidLane => 'info',
            self::ExpLane => 'danger',
            self::Roamer => 'success',
            self::Flex => 'gray',
        };
    }

    public function rank(): int
    {
        return match ($this) {
            self::Jungler => 1,
            self::GoldLane => 2,
            self::MidLane => 3,
            self::ExpLane => 4,
            self::Roamer => 5,
            self::Flex => 6,
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
