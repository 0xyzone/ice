<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tournaments\Tables;

use App\Enums\GameType;
use App\Filament\Resources\Tournaments\TournamentResource;
use App\Models\Tournament;
use Filament\Actions\Action;
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

class TournamentsTable
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
                        TextColumn::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'upcoming' => 'gray',
                                'ongoing' => 'warning',
                                'completed' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->grow(false),
                    ]),
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large)
                        ->searchable(),
                    Split::make([
                        TextColumn::make('prize_pool')
                            ->icon('heroicon-m-trophy')
                            ->color('warning')
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('Prize TBD')
                            ->searchable(),
                        TextColumn::make('start_date')
                            ->icon('heroicon-m-calendar')
                            ->date('M d, Y')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->placeholder('Date TBD')
                            ->grow(false),
                    ]),
                ])->space(3),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->label('Game')
                    ->options(GameType::class)
                    ->native(false),
                SelectFilter::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                    ])
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make('quick_edit')
                    ->label('Quick Edit')
                    ->url(null)
                    ->slideOver(),
                Action::make('manage')
                    ->label('Manage')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->color('warning')
                    ->url(fn (Tournament $record): string => TournamentResource::getUrl('edit', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
