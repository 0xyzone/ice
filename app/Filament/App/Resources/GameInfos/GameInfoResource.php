<?php

namespace App\Filament\App\Resources\GameInfos;

use App\Filament\App\Resources\GameInfos\Pages\CreateGameInfo;
use App\Filament\App\Resources\GameInfos\Pages\EditGameInfo;
use App\Filament\App\Resources\GameInfos\Pages\ListGameInfos;
use App\Filament\App\Resources\GameInfos\Schemas\GameInfoForm;
use App\Filament\App\Resources\GameInfos\Tables\GameInfosTable;
use App\Models\GameInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GameInfoResource extends Resource
{
    protected static ?string $model = GameInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::PuzzlePiece;

    protected static ?string $recordTitleAttribute = 'in_game_id';

    public static function form(Schema $schema): Schema
    {
        return GameInfoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameInfosTable::configure($table);
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
            'index' => ListGameInfos::route('/'),
            'create' => CreateGameInfo::route('/create'),
            'edit' => EditGameInfo::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
