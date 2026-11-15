<?php

declare(strict_types=1);

namespace App\Filament\App\Widgets;

use App\Models\EsportsMatch;
use App\Models\TeamMember;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class PlayerUpcomingMatchesWidget extends TableWidget
{
    protected static ?string $heading = 'My Team Matches';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check();
    }

    public function table(Table $table): Table
    {
        $teamIds = TeamMember::where('user_id', Auth::id())
            ->where('status', true)
            ->pluck('own_team_id');

        return $table
            ->query(
                EsportsMatch::query()
                    ->with(['tournament', 'ownTeam'])
                    ->whereIn('own_team_id', $teamIds)
                    ->orderByRaw("CASE WHEN status = 'ongoing' THEN 0 WHEN status = 'upcoming' THEN 1 ELSE 2 END")
                    ->orderByDesc('match_date')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('tournament.name')
                    ->label('Tournament')
                    ->weight('bold')
                    ->placeholder('Friendly / Scrim'),

                TextColumn::make('ownTeam.name')
                    ->label('My Squad')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('opponent_name')
                    ->label('Opponent / Lobby'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'ongoing' => 'warning',
                        'upcoming' => 'info',
                        'completed' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('match_date')
                    ->label('Scheduled')
                    ->dateTime('M d, Y H:i')
                    ->placeholder('TBD'),
            ])
            ->paginated(false);
    }
}
