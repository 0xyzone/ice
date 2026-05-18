<?php

namespace App\Filament\Widgets;

use App\Models\Tournament;
use Filament\Widgets\ChartWidget;

class TournamentsStatusChart extends ChartWidget
{
    protected ?string $heading = 'Tournament Status Distribution';

    protected ?string $maxHeight = '250px';

    protected static ?int $sort = 5;

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Tournaments',
                    'data' => [
                        Tournament::where('status', 'upcoming')->count(),
                        Tournament::where('status', 'ongoing')->count(),
                        Tournament::where('status', 'completed')->count(),
                    ],
                    'backgroundColor' => [
                        '#9ca3af', // gray for upcoming
                        '#eab308', // yellow for ongoing
                        '#10b981', // green for completed
                    ],
                ],
            ],
            'labels' => ['Upcoming', 'Ongoing', 'Completed'],
        ];
    }
}
