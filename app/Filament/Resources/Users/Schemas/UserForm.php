<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\GridDirection;
use Illuminate\Database\Eloquent\Builder;

class UserForm
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
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
            ])->columns(3);
    }
}
