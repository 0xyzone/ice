<?php

namespace App\Filament\Resources\Games\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Game Information')
                                    ->description('Basic details about the game.')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Game Banner')
                                    ->schema([
                                        FileUpload::make('game_banner')
                                            ->hiddenLabel()
                                            ->image()
                                            ->optimize('webp')
                                            ->downloadable()
                                            ->previewable()
                                            ->disk('public')
                                            ->directory('games/banners')
                                            ->visibility('public')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Game Logo')
                                    ->schema([
                                        FileUpload::make('game_logo')
                                            ->hiddenLabel()
                                            ->image()
                                            ->optimize('webp')
                                            ->downloadable()
                                            ->previewable()
                                            ->disk('public')
                                            ->directory('games/logos')
                                            ->visibility('public'),
                                    ]),

                                Section::make('Status')
                                    ->schema([
                                        Toggle::make('status')
                                            ->label('Active Game')
                                            ->helperText('Is this game currently active on the platform?')
                                            ->default(false),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
