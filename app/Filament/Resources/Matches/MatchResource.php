<?php

namespace App\Filament\Resources\Matches;

use App\Filament\Resources\Matches\Pages\CreateMatch;
use App\Filament\Resources\Matches\Pages\EditMatch;
use App\Filament\Resources\Matches\Pages\ListMatches;
use App\Filament\Resources\Matches\Schemas\MatchForm;
use App\Filament\Resources\Matches\Tables\MatchesTable;
use App\Models\EsportsMatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MatchResource extends Resource
{
    protected static ?string $model = EsportsMatch::class;

    protected static ?string $modelLabel = 'Match';

    protected static ?string $pluralModelLabel = 'Matches';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTv;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Tv;

    protected static \UnitEnum|string|null $navigationGroup = 'Esports Management';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return MatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatches::route('/'),
            'create' => CreateMatch::route('/create'),
            'edit' => EditMatch::route('/{record}/edit'),
        ];
    }
}
