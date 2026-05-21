<?php

namespace App\Filament\Resources\Matches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tournament.name')
                    ->label('Tournament')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ownTeam.name')
                    ->label('Our Team')
                    ->sortable(),
                TextColumn::make('opponent_name')
                    ->label('Opponent Team')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('our_score')
                    ->label('Our Score')
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('opponent_score')
                    ->label('Opponent Score')
                    ->alignCenter()
                    ->badge()
                    ->color('danger')
                    ->sortable(),
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
                //
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
