<?php

namespace App\Filament\App\Resources\Tournaments;

use App\Filament\App\Resources\Tournaments\Pages\ListTournaments;
use App\Filament\App\Resources\Tournaments\Pages\ViewTournament;
use App\Filament\Resources\Tournaments\Schemas\TournamentForm;
use App\Filament\Resources\Tournaments\Tables\TournamentsTable;
use App\Models\Tournament;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Trophy;

    public static function form(Schema $schema): Schema
    {
        return TournamentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        $table = TournamentsTable::configure($table);

        return $table
            ->actions([
                ViewAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTournaments::route('/'),
            'view' => ViewTournament::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $teamIds = auth()->user()->teamMemberships()->pluck('own_team_id')->toArray();

        return parent::getEloquentQuery()->whereHas('matches', function ($query) use ($teamIds) {
            $query->whereIn('own_team_id', $teamIds);
        });
    }
}
