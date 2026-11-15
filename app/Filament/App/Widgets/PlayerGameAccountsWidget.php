<?php

declare(strict_types=1);

namespace App\Filament\App\Widgets;

use App\Filament\App\Resources\GameInfos\GameInfoResource;
use App\Models\GameInfo;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PlayerGameAccountsWidget extends Widget
{
    protected string $view = 'filament.app.widgets.player-game-accounts-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check() && GameInfoResource::canViewAny();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $accounts = GameInfo::where('user_id', Auth::id())
            ->where('status', true)
            ->orderBy('game')
            ->get()
            ->map(fn (GameInfo $info): array => [
                'gameEnum' => $info->game,
                'game' => $info->gameLabel,
                'short' => $info->game?->getShortName() ?? 'GAME',
                'ign' => $info->in_game_username,
                'uid' => $info->in_game_id,
                'roles' => $info->getRoleLabels(),
            ])
            ->all();

        return [
            'accounts' => $accounts,
        ];
    }
}
