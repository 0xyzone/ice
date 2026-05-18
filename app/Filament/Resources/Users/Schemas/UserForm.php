<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Credentials')
                    ->description('Manage user credentials and basic account information.')
                    ->icon('heroicon-m-user-circle')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->prefixIcon('heroicon-m-user')
                            ->required()
                            ->disabledOn('edit')
                            ->maxLength(255),

                        TextInput::make('email')
                            ->prefixIcon('heroicon-m-envelope')
                            ->email()
                            ->disabledOn('edit')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('id')
                            ->disabled()
                            ->copyable(),
                    ]),
            ]);
    }
}
