<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\GameInfos\Tables;

use App\Enums\GameType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GameInfosTable
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
                        TextColumn::make('game')
                            ->badge(),
                        TextColumn::make('roleLabel')
                            ->state(fn ($record): array => $record->getRoleLabels())
                            ->badge()
                            ->color('info')
                            ->placeholder('No Role'),
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
                            })
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('in_game_username')
                            ->weight(FontWeight::Bold)
                            ->size(TextSize::Large)
                            ->searchable(),
                        Split::make([
                            TextColumn::make('in_game_id')
                                ->prefix('ID: #')
                                ->fontFamily(FontFamily::Mono)
                                ->color('gray')
                                ->size(TextSize::Small)
                                ->searchable(),
                            TextColumn::make('server_id')
                                ->prefix('Zone: ')
                                ->fontFamily(FontFamily::Mono)
                                ->color('gray')
                                ->size(TextSize::Small)
                                ->placeholder('')
                                ->grow(false),
                        ]),
                    ])->space(1),
                ])->space(3),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->options(GameType::class),
            ])
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
