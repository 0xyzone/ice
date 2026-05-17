<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\GridDirection;
use Illuminate\Database\Eloquent\Builder;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                ->hiddenOn('create'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->hiddenOn('create'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->hiddenOn('create'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                CheckboxList::make('roles')
                    ->relationship(name: 'roles', titleAttribute: 'name', modifyQueryUsing: function (Builder $query) {
                        $query->where('name', "!=", 'super_admin');
                    })
                    ->getOptionLabelFromRecordUsing(fn($record) => ucfirst($record->name))
                    ->columns(3)
                    ->required()
                    ->gridDirection(GridDirection::Row),
            ])->columns(3);
    }
}
