<?php

namespace App\Filament\Resources\Tournaments\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'teams';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pivot.matches_played')
                    ->label('Matches Played')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('pivot.matches_won')
                    ->label('Matches Won')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('pivot.matches_lost')
                    ->label('Matches Lost')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('pivot.points')
                    ->label('Points')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('pivot.rank')
                    ->label('Rank')
                    ->placeholder('e.g. 1st Place, Quarterfinalist')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Team Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot.matches_played')
                    ->label('Played')
                    ->sortable(),
                TextColumn::make('pivot.matches_won')
                    ->label('Won')
                    ->sortable(),
                TextColumn::make('pivot.matches_lost')
                    ->label('Lost')
                    ->sortable(),
                TextColumn::make('pivot.points')
                    ->label('Points')
                    ->sortable(),
                TextColumn::make('pivot.rank')
                    ->label('Rank')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('matches_played')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('matches_won')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('matches_lost')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('points')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('rank')
                            ->placeholder('e.g. 1st Place')
                            ->maxLength(255),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
