<?php

namespace App\Filament\App\Widgets;

use App\Models\Tournament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PlayerTournamentsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $teamIds = Auth::user()->teamMemberships()->pluck('own_team_id')->toArray();

        return $table
            ->query(
                Tournament::query()
                    ->join('tournament_team', 'tournaments.id', '=', 'tournament_team.tournament_id')
                    ->whereIn('tournament_team.own_team_id', $teamIds)
                    ->select('tournaments.*', 'tournament_team.own_team_id', 'tournament_team.matches_played', 'tournament_team.matches_won', 'tournament_team.points', 'tournament_team.rank')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tournament')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('matches_played')
                    ->label('Matches Played')
                    ->alignCenter(),
                TextColumn::make('matches_won')
                    ->label('Matches Won')
                    ->alignCenter()
                    ->color('success'),
                TextColumn::make('points')
                    ->label('Total Points')
                    ->alignCenter()
                    ->color('warning')
                    ->weight('bold'),
                TextColumn::make('rank')
                    ->label('Placement Rank')
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => match ((int) $state) {
                        1 => 'success',
                        2 => 'info',
                        3 => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => '#'.$state),
            ]);
    }
}
