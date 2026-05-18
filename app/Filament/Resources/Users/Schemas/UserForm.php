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
                    ->columns(4)
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

                        TextInput::make('password')
                            ->prefixIcon('heroicon-m-key')
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->maxLength(255)
                            ->helperText(fn (string $context): string => $context === 'edit' ? 'Leave blank to keep current password.' : ''),

                        TextInput::make('id')
                            ->disabled()
                            ->copyable(),
                    ]),
            ]);
    }
}
