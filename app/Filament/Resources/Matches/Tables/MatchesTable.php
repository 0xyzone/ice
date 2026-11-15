<?php

declare(strict_types=1);

namespace App\Filament\Resources\Matches\Tables;

use App\Enums\GameType;
use App\Models\EsportsMatch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('tournament.game')
                            ->badge(),
                        TextColumn::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'scheduled' => 'gray',
                                'ongoing' => 'warning',
                                'completed' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('tournament.name')
                            ->size(TextSize::Small)
                            ->color('gray')
                            ->searchable(),
                        TextColumn::make('matchup_title')
                            ->state(function (EsportsMatch $record): string {
                                $team = $record->ownTeam?->name ?? 'Team';
                                if ($record->isBattleRoyale()) {
                                    return "{$team} — ".($record->opponent_name ?: 'Lobby Round');
                                }

                                return "{$team} vs ".($record->opponent_name ?: 'Opponent');
                            })
                            ->weight(FontWeight::Bold)
                            ->size(TextSize::Medium),
                    ])->space(1),
                    Split::make([
                        TextColumn::make('result_display')
                            ->badge()
                            ->state(function (EsportsMatch $record): string {
                                if ($record->isBattleRoyale()) {
                                    $placement = $record->placement ? "#{$record->placement}" : 'Unranked';
                                    $pts = $record->total_points !== null ? " ({$record->total_points} pts)" : '';
                                    $winner = $record->is_winner ? ' 🏆' : '';

                                    return "{$placement}{$pts}{$winner}";
                                }

                                return "{$record->our_score} - {$record->opponent_score}";
                            })
                            ->color(function (EsportsMatch $record): string {
                                if ($record->isBattleRoyale()) {
                                    return $record->is_winner || $record->placement === 1 ? 'success' : ($record->placement && $record->placement <= 3 ? 'warning' : 'gray');
                                }

                                return $record->our_score > $record->opponent_score ? 'success' : ($record->our_score < $record->opponent_score ? 'danger' : 'gray');
                            }),
                        TextColumn::make('match_date')
                            ->dateTime('M d, Y · H:i')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->grow(false),
                    ]),
                ])->space(3),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->relationship('tournament', 'game')
                    ->options(GameType::class),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
