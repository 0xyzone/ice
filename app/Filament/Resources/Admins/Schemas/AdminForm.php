<?php

namespace App\Filament\Resources\Admins\Schemas;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admin Credentials')
                    ->description('Manage administrator credentials and system access details.')
                    ->icon('heroicon-m-shield-check')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->prefixIcon('heroicon-m-user')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->prefixIcon('heroicon-m-envelope')
                            ->email()
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

                        Toggle::make('is_active')
                            ->label('Account Active')
                            ->default(true)
                            ->inline(false)
                            ->disabled(fn (?User $record) => $record && $record->id === auth()->id())
                            ->helperText(fn (?User $record) => $record && $record->id === auth()->id()
                                ? 'You cannot deactivate your own account.'
                                : 'Deactivated administrators are blocked from logging in to the system.'),
                    ]),
            ]);
    }
}
