<?php

namespace App\Filament\Resources\Tournaments\RelationManagers;

use App\Filament\Resources\Matches\Schemas\MatchForm;
use App\Filament\Resources\Matches\Tables\MatchesTable;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MatchesRelationManager extends RelationManager
{
    protected static string $relationship = 'matches';

    protected static ?string $title = 'Matches';

    public function form(Schema $schema): Schema
    {
        return MatchForm::configure($schema, isRelation: true);
    }

    public function table(Table $table): Table
    {
        $table = MatchesTable::configure($table);

        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
