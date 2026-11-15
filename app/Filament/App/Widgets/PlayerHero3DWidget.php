<?php

declare(strict_types=1);

namespace App\Filament\App\Widgets;

use App\Models\GameInfo;
use App\Models\PlayerMatchStat;
use App\Models\TeamMember;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PlayerHero3DWidget extends Widget
{
    protected string $view = 'filament.app.widgets.player-hero-3d-widget';

    protected static ?int $sort = -10;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $activeGames = GameInfo::where('user_id', $user->id)->where('status', true)->count();
        $activeTeams = TeamMember::where('user_id', $user->id)->where('status', true)->count();

        $stats = PlayerMatchStat::where('user_id', $user->id)->get();
        $kills = $stats->sum('kills');
        $deaths = $stats->sum('deaths');
        $assists = $stats->sum('assists');
        $kda = $deaths > 0 ? round(($kills + $assists) / $deaths, 2) : (float) ($kills + $assists);

        $primaryMembership = TeamMember::with('team')
            ->where('user_id', $user->id)
            ->where('status', true)
            ->orderByDesc('is_main_roster')
            ->first();

        return [
            'playerName' => $user->name,
            'username' => $user->username,
            'teamName' => $primaryMembership?->team?->name ?? 'Free Agent',
            'metrics' => [
                ['label' => 'Active Games', 'value' => $activeGames],
                ['label' => 'Active Squads', 'value' => $activeTeams],
                ['label' => 'Maps / Rounds', 'value' => $stats->count()],
                ['label' => 'Career KDA', 'value' => number_format($kda, 2)],
            ],
        ];
    }
}
