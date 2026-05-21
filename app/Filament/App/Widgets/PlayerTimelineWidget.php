<?php

namespace App\Filament\App\Widgets;

use App\Models\Tournament;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PlayerTimelineWidget extends Widget
{
    protected string $view = 'filament.app.widgets.player-timeline-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 6;

    public function getViewData(): array
    {
        $user = Auth::user();
        $player = User::with([
            'teamMemberships.team',
        ])->find($user->id);

        $events = [];

        if ($player) {
            foreach ($player->teamMemberships as $membership) {
                if ($membership->team) {
                    $events[] = [
                        'date' => $membership->created_at ? $membership->created_at->format('M d, Y') : 'N/A',
                        'timestamp' => $membership->created_at ? $membership->created_at->timestamp : 0,
                        'title' => 'Joined Roster',
                        'desc' => "Joined team **{$membership->team->name}** as a **".ucfirst($membership->role).'**.',
                        'type' => 'team',
                        'color' => '#8b5cf6',
                    ];

                    // Find all unique tournaments this team has matches in
                    $tournaments = Tournament::whereHas('matches', function ($query) use ($membership) {
                        $query->where('own_team_id', $membership->own_team_id);
                    })->get();

                    foreach ($tournaments as $tournament) {
                        $events[] = [
                            'date' => $tournament->start_date ? date('M d, Y', strtotime($tournament->start_date)) : 'N/A',
                            'timestamp' => $tournament->start_date ? strtotime($tournament->start_date) : 0,
                            'title' => 'Tournament Campaign Started',
                            'desc' => "Campaign began in **{$tournament->name}** playing for **{$membership->team->name}**.",
                            'type' => 'tournament',
                            'color' => '#ef4444',
                        ];
                    }
                }
            }
        }

        usort($events, fn ($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return [
            'events' => array_slice($events, 0, 5),
        ];
    }
}
