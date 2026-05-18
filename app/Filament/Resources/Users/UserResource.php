<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\RelationManagers\GameInfoRelationManager;
use App\Filament\Resources\Users\RelationManagers\PlayerRelationManager;
use App\Filament\Resources\Users\RelationManagers\SocialsRelationManager;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::UserGroup;

    protected static ?string $modelLabel = 'Player';

    protected static ?string $pluralModelLabel = 'Players';

    protected static UnitEnum|string|null $navigationGroup = 'User Management';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'players';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'player' => PlayerRelationManager::class,
            'gameInfos' => GameInfoRelationManager::class,
            'socials' => SocialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getAuthorizationResponse(string|UnitEnum $action, ?Model $record = null): Response
    {
        $actionName = $action instanceof UnitEnum ? $action->name : $action;
        $permission = ucfirst($actionName).':'.class_basename(static::class);

        return filament()->auth()->user()?->can($permission)
            ? Response::allow()
            : Response::deny();
    }

    public static function can(string|UnitEnum $action, ?Model $record = null): bool
    {
        return static::getAuthorizationResponse($action, $record)->allowed();
    }
}
