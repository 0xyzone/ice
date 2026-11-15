<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\GameType;
use App\Filament\Resources\OwnTeams\OwnTeamResource;
use App\Filament\Resources\Tournaments\TournamentResource;
use App\Models\GameInfo;
use App\Models\OwnTeam;
use App\Models\Tournament;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class GameDivisionBreakdownWidget extends Widget
{
    protected string $view = 'filament.widgets.game-division-breakdown-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! ($user?->hasAnyRole(['super_admin', 'admin']) ?? false)) {
            return false;
        }

        return OwnTeamResource::canViewAny() || TournamentResource::canViewAny();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $divisions = collect(GameType::cases())->map(function (GameType $game): array {
            return [
                'name' => $game->getLabel(),
                'short' => $game->getShortName(),
                'category' => $game->isMoba() ? 'MOBA 5v5' : 'Battle Royale',
                'teams' => OwnTeam::forGame($game)->where('status', true)->count(),
                'accounts' => GameInfo::where('game', $game->value)->where('status', true)->count(),
                'tournaments' => Tournament::where('game', $game->value)->count(),
            ];
        })->all();

        return [
            'divisions' => $divisions,
        ];
    }
}
