<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MlbbRole: string implements HasColor, HasLabel
{
    case GoldLane = 'gold_lane';
    case ExpLane = 'exp_lane';
    case MidLane = 'mid_lane';
    case Roamer = 'roamer';
    case Jungler = 'jungler';

    public function getLabel(): string
    {
        return match ($this) {
            self::GoldLane => 'Gold Laner',
            self::ExpLane => 'EXP Laner',
            self::MidLane => 'Mid Laner',
            self::Roamer => 'Roamer / Tank',
            self::Jungler => 'Jungler / Hyper',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GoldLane => 'warning',
            self::ExpLane => 'danger',
            self::MidLane => 'info',
            self::Roamer => 'success',
            self::Jungler => 'primary',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role) => [$role->value => $role->getLabel()])
            ->toArray();
    }
}
