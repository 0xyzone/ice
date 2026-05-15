<?php

namespace App\Filament\App\Resources\GameInfos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GameInfoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('game_id')
                    ->relationship('game', 'name')
                    ->required(),
                Hidden::make('user_id')
                    ->default(auth()->id()),
                TextInput::make('in_game_id'),
                TextInput::make('in_game_username'),
                TextInput::make('server_id'),
                FileUpload::make('profile_image')
                    ->image()
                    ->optimize('webp')
                    ->downloadable()
                    ->previewable()
                    ->disk('public')
                    ->directory('game-infos/profile')
                    ->visibility('public'),
                Toggle::make('status')
                    ->default(false)
                    ->required(),
            ]);
    }
}
