<?php

namespace App\Filament\App\Widgets;

use App\Models\EsportsMatch;
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
                    ->whereHas('matches', function ($query) use ($teamIds) {
                        $query->whereIn('own_team_id', $teamIds);
                    })
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tournament')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('matches_played')
                    ->label('Matches Played')
                    ->alignCenter()
                    ->getStateUsing(fn ($record) => $record->matches()->whereIn('own_team_id', $teamIds)->where('status', 'completed')->count()),
                TextColumn::make('matches_won')
                    ->label('Matches Won')
                    ->alignCenter()
                    ->color('success')
                    ->getStateUsing(fn ($record) => $record->matches()->whereIn('own_team_id', $teamIds)->where('status', 'completed')->whereColumn('our_score', '>', 'opponent_score')->count()),
                TextColumn::make('points')
                    ->label('Total Points')
                    ->alignCenter()
                    ->color('warning')
                    ->weight('bold')
                    ->getStateUsing(fn ($record) => $record->matches()->whereIn('own_team_id', $teamIds)->where('status', 'completed')->with('series')->get()->sum(fn ($match) => $match->series->sum('our_score'))),
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
                    ->getStateUsing(function ($record) use ($teamIds) {
                        // Find the first participating team of the user in this tournament
                        $userTeamId = collect($teamIds)->first(fn ($teamId) => $record->matches()->where('own_team_id', $teamId)->where('status', 'completed')->exists());
                        if (! $userTeamId) {
                            return null;
                        }

                        // All matches in this tournament
                        $allTournamentMatches = EsportsMatch::where('tournament_id', $record->id)
                            ->where('status', 'completed')
                            ->with('series')
                            ->get();

                        // Group by own_team_id and calculate points
                        $teamPoints = $allTournamentMatches->groupBy('own_team_id')->map(function ($tMatches) {
                            return $tMatches->sum(fn ($m) => $m->series->sum('our_score'));
                        })->sortDesc();

                        $rank = 1;
                        foreach ($teamPoints as $tId => $pts) {
                            if ($tId == $userTeamId) {
                                return $rank;
                            }
                            $rank++;
                        }

                        return null;
                    })
                    ->formatStateUsing(fn ($state) => $state ? '#'.$state : 'N/A'),
            ]);
    }
}
