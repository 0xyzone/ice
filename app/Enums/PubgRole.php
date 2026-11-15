<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PubgRole: string implements HasColor, HasLabel
{
    case Assaulter = 'assaulter';
    case Sniper = 'sniper';
    case Igl = 'igl';
    case Support = 'support';

    public function getLabel(): string
    {
        return match ($this) {
            self::Assaulter => 'Assaulter / Entry',
            self::Sniper => 'Sniper / DMR',
            self::Igl => 'IGL (In-Game Leader)',
            self::Support => 'Support / Medic',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Assaulter => 'danger',
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
