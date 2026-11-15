<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Credentials')
                    ->description('Manage player credentials, status, and basic account information.')
                    ->icon('heroicon-m-user-circle')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->prefixIcon('heroicon-m-user')
                            ->required()
                            ->disabledOn('edit')
                            ->maxLength(255),

                        TextInput::make('username')
                            ->prefixIcon('heroicon-m-at-symbol')
                            ->required()
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
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
                            ->label('Player ID')
                            ->hiddenOn('create')
                            ->disabled()
                            ->copyable(),

                        Toggle::make('is_active')
                            ->label('Account Active')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Deactivated players are blocked from logging in to the portal.'),
                    ]),
            ]);
    }
}
