<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPlayersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::role('player')->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Player Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('playerDetail.gender')
                    ->label('Gender')
                    ->placeholder('N/A')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                TextColumn::make('playerDetail.age')
                    ->label('Age')
                    ->placeholder('N/A')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view_profile')
                    ->label('View Profile')
                    ->icon('heroicon-o-eye')
                    ->color('danger')
                    ->url(fn (User $record) => route('player.profile', $record))
                    ->openUrlInNewTab(),
            ]);
    }
}
