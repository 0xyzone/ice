<?php

namespace App\Filament\App\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PlayerWinsLossesChart extends ChartWidget
{
    protected ?string $heading = 'Matches Outcome Distribution';

    protected ?string $maxHeight = '250px';

    protected static ?int $sort = 5;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $player = User::with([
            'matchStats.matchSeries',
        ])->find($user->id);

        $totalWon = 0;
        $totalLost = 0;

        if ($player) {
            foreach ($player->matchStats as $stat) {
                if ($stat->matchSeries) {
                    if ($stat->matchSeries->result === 'won') {
                        $totalWon++;
                    } elseif ($stat->matchSeries->result === 'lost') {
                        $totalLost++;
                    }
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Matches Outcome',
                    'data' => [$totalWon, $totalLost],
                    'backgroundColor' => [
                        '#10b981', // green for wins
                        '#ef4444', // red for losses
                    ],
                ],
            ],
            'labels' => ['Matches Won', 'Matches Lost'],
        ];
    }
}
