<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tournaments\RelationManagers;

use App\Models\Tournament;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerStatsRelationManager extends RelationManager
{
    protected static string $relationship = 'playerStats';

    protected static ?string $title = 'Player Tournament Stats';

    public function form(Schema $schema): Schema
    {
        /** @var Tournament $tournament */
        $tournament = $this->ownerRecord;
        $isBr = $tournament?->isBattleRoyale() ?? false;

        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Player')
                    ->relationship('user', 'name', fn ($query) => $query->whereHas('roles', fn ($q) => $q->where('name', 'player')))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('matches_played')
                    ->label($isBr ? 'Matches / Rounds Played' : 'Matches Played')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('matches_won')
                    ->label($isBr ? 'Wins (#1 WWCD / Booyah)' : 'Matches Won')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('matches_lost')
                    ->label('Matches Lost')
                    ->numeric()
                    ->default(0)
                    ->visible(! $isBr)
                    ->required(! $isBr),
                TextInput::make('kills')
                    ->label($isBr ? 'Total Eliminations / Kills' : 'Total Kills')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('deaths')
                    ->label('Total Deaths')
                    ->numeric()
                    ->default(0)
                    ->visible(! $isBr)
                    ->required(! $isBr),
                TextInput::make('assists')
                    ->label('Total Assists')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('total_damage')
                    ->label('Total Damage Dealt')
                    ->numeric()
                    ->placeholder('e.g. 15400')
                    ->nullable(),
                TextInput::make('total_points')
                    ->label('Total Points Accumulated')
                    ->numeric()
                    ->placeholder('e.g. 120')
                    ->visible($isBr)
                    ->nullable(),
                TextInput::make('avg_survival_time')
                    ->label('Avg Survival Time (Seconds)')
                    ->numeric()
                    ->placeholder('e.g. 1100')
                    ->visible($isBr)
                    ->nullable(),
                TextInput::make('mvps')
                    ->label('MVP Awards')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Player')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('matches_played')
                    ->label('Played')
                    ->sortable(),
                TextColumn::make('matches_won')
                    ->label('Won / Wins')
                    ->sortable(),
                TextColumn::make('kills')
                    ->label('Kills')
                    ->sortable(),
                TextColumn::make('deaths')
                    ->label('Deaths')
                    ->sortable(),
                TextColumn::make('assists')
                    ->label('Assists')
                    ->sortable(),
                TextColumn::make('total_damage')
                    ->label('Damage')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('total_points')
                    ->label('Pts')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('mvps')
                    ->label('MVPs')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
