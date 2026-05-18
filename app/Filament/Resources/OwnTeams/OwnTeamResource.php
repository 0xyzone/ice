<?php

namespace App\Filament\Resources\OwnTeams;

use App\Filament\Resources\OwnTeams\Pages\CreateOwnTeam;
use App\Filament\Resources\OwnTeams\Pages\EditOwnTeam;
use App\Filament\Resources\OwnTeams\Pages\ListOwnTeams;
use App\Filament\Resources\OwnTeams\RelationManagers\MembersRelationManager;
use App\Filament\Resources\OwnTeams\Schemas\OwnTeamForm;
use App\Filament\Resources\OwnTeams\Tables\OwnTeamsTable;
use App\Models\OwnTeam;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OwnTeamResource extends Resource
{
    protected static ?string $model = OwnTeam::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Trophy;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OwnTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OwnTeamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOwnTeams::route('/'),
            'create' => CreateOwnTeam::route('/create'),
            'edit' => EditOwnTeam::route('/{record}/edit'),
        ];
    }
}
