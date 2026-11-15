<?php

declare(strict_types=1);

namespace App\Filament\Resources\Matches\Tables;

use App\Enums\GameType;
use App\Models\EsportsMatch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tournament.game')
                    ->label('Game')
                    ->badge()
                    ->sortable(),
                TextColumn::make('tournament.name')
                    ->label('Tournament')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ownTeam.name')
                    ->label('Our Team')
                    ->sortable(),
                TextColumn::make('opponent_name')
                    ->label('Matchup / Lobby')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Lobby / Multi-Team'),
                TextColumn::make('result_display')
                    ->label('Outcome / Score')
                    ->state(function (EsportsMatch $record): string {
                        if ($record->isBattleRoyale()) {
                            $placement = $record->placement ? "#{$record->placement}" : 'Unranked';
                            $pts = $record->total_points !== null ? " ({$record->total_points} pts)" : '';
                            $winner = $record->is_winner ? ' 🏆' : '';

                            return "{$placement}{$pts}{$winner}";
                        }

                        return "{$record->our_score} - {$record->opponent_score}";
                    })
                    ->badge()
                    ->color(function (EsportsMatch $record): string {
                        if ($record->isBattleRoyale()) {
                            return $record->is_winner || $record->placement === 1 ? 'success' : ($record->placement && $record->placement <= 3 ? 'warning' : 'gray');
                        }

                        return $record->our_score > $record->opponent_score ? 'success' : ($record->our_score < $record->opponent_score ? 'danger' : 'gray');
                    }),
                TextColumn::make('match_date')
                    ->label('Match Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->relationship('tournament', 'game')
                    ->options(GameType::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
