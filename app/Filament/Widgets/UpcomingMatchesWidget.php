<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\Matches\MatchResource;
use App\Models\EsportsMatch;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class UpcomingMatchesWidget extends TableWidget
{
    protected static ?string $heading = 'Recent & Upcoming Matches';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! ($user?->hasAnyRole(['super_admin', 'admin']) ?? false)) {
            return false;
        }

        return MatchResource::canViewAny();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                EsportsMatch::query()
                    ->with(['tournament', 'ownTeam'])
                    ->orderByRaw("CASE WHEN status = 'ongoing' THEN 0 WHEN status = 'upcoming' THEN 1 ELSE 2 END")
                    ->orderByDesc('match_date')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('tournament.name')
                    ->label('Tournament')
                    ->weight('bold')
                    ->placeholder('Standalone Match'),

                TextColumn::make('ownTeam.name')
                    ->label('Our Team')
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
