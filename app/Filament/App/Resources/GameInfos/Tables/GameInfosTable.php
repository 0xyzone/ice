<?php

namespace App\Filament\App\Resources\GameInfos\Tables;

use App\Enums\GameType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use TinusG\FilamentHoverImageColumn\HoverImageColumn;

class GameInfosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game')
                    ->label('Game')
                    ->badge()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Player')
                    ->searchable(),
                TextColumn::make('in_game_username')
                    ->label('IGN')
                    ->searchable(),
                TextColumn::make('in_game_id')
                    ->label('ID / UID')
                    ->searchable(),
                TextColumn::make('server_id')
                    ->label('Zone/Server')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('roleLabel')
                    ->label('Role')
                    ->badge()
                    ->placeholder('-'),
                HoverImageColumn::make('profile_image'),
                ToggleColumn::make('status')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($record) {
                        Notification::make()
                            ->title('Status updated')
                            ->success()
                            ->send();
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('game')
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
