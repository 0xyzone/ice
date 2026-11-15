<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FreeFireRole: string implements HasColor, HasLabel
{
    case Rusher = 'rusher';
    case Sniper = 'sniper';
    case Igl = 'igl';
    case Support = 'support';

    public function getLabel(): string
    {
        return match ($this) {
            self::Rusher => 'Rusher / Entry Frag',
            self::Sniper => 'Sniper / Marksman',
            self::Igl => 'IGL (In-Game Leader)',
            self::Support => 'Support / Flanker',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Rusher => 'danger',
            self::Sniper => 'info',
            self::Igl => 'warning',
            self::Support => 'success',
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
