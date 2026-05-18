<?php

namespace App\Filament\App\Widgets;

use App\Models\TeamMember;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PlayerTeamsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TeamMember::query()->where('user_id', Auth::id())->with('team.game')
            )
            ->columns([
                TextColumn::make('team.name')
                    ->label('Team Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('team.game.name')
                    ->label('Game')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('role')
                    ->label('My Role')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ]);
    }
}
