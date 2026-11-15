<?php

namespace App\Filament\Resources\Admins;

use App\Filament\Resources\Admins\Pages\ListAdmins;
use App\Filament\Resources\Admins\Schemas\AdminForm;
use App\Filament\Resources\Admins\Tables\AdminsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::UserCircle;

    protected static UnitEnum|string|null $navigationGroup = 'People & Access';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Admin';

    protected static ?string $pluralModelLabel = 'Admins';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
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
            'index' => ListAdmins::route('/'),
        ];
    }

    public static function getAuthorizationResponse(string|UnitEnum $action, ?Model $record = null): Response
    {
        $actionName = $action instanceof UnitEnum ? $action->name : $action;
        $permission = ucfirst($actionName).':'.class_basename(static::class);

        $user = Auth::user();

        if ($user && ($user->hasRole('super_admin') || $user->can($permission))) {
            return Response::allow();
        }

        return Response::deny();
    }

    public static function can(string|UnitEnum $action, ?Model $record = null): bool
    {
        return static::getAuthorizationResponse($action, $record)->allowed();
    }
}
