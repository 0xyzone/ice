<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class PlayersRegistrationChart extends ChartWidget
{
    protected ?string $heading = 'Player Registration Trend';

    protected static ?int $sort = 7;

    public static function canView(): bool
    {
        return UserResource::canViewAny();
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[] = User::role('player')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Players Registered',
                    'data' => $data,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
