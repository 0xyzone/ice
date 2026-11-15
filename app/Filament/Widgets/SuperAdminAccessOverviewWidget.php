<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\Admins\AdminResource;
use App\Models\User;
use BezhanSalleh\FilamentShield\Resources\Roles\RoleResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;

class SuperAdminAccessOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'System Access & Security';

    public static function canView(): bool
    {
        return AdminResource::canViewAny() || RoleResource::canViewAny();
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Admin Accounts', User::role(['super_admin', 'admin'])->count())
                ->description('Super Admins & Admins')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),

            Stat::make('Permission Roles', Role::count())
                ->description('Configured access tiers')
                ->descriptionIcon('heroicon-m-key')
                ->color('info'),

            Stat::make('Active Accounts', User::where('is_active', true)->count())
                ->description(User::where('is_active', false)->count().' deactivated')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
