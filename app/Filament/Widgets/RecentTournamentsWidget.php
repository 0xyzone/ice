<?php

namespace App\Filament\Widgets;

use App\Models\Tournament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTournamentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tournament::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tournament Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prize_pool')
                    ->label('Prize Pool')
                    ->placeholder('N/A'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'upcoming' => 'gray',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date(),
            ]);
    }
}
