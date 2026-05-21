<?php

namespace App\Filament\Resources\Tournaments\RelationManagers;

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

    protected static ?string $title = 'Player Stats';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Player')
                    ->relationship('user', 'name', fn ($query) => $query->whereHas('roles', fn ($q) => $q->where('name', 'player')))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('matches_played')
                    ->label('Matches Played')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('matches_won')
                    ->label('Matches Won')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('matches_lost')
                    ->label('Matches Lost')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('kills')
                    ->label('Kills')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('deaths')
                    ->label('Deaths')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('assists')
                    ->label('Assists')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('mvps')
                    ->label('MVPs')
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
                    ->label('Won')
                    ->sortable(),
                TextColumn::make('matches_lost')
                    ->label('Lost')
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
                TextColumn::make('mvps')
                    ->label('MVPs')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
