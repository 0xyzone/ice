<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\GameInfos\Schemas;

use App\Enums\FreeFireRole;
use App\Enums\GameType;
use App\Enums\MlbbRole;
use App\Enums\PubgRole;
use App\Services\MlbbHeroService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GameInfoForm
{
    public static function configure(Schema $schema, ?int $forcedUserId = null): Schema
    {
        return $schema
            ->components([
                Section::make('Game Identity & Credentials')
                    ->description('Set up your official in-game credentials according to the selected title.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('game')
                                    ->label('Select Game')
                                    ->options(GameType::class)
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->default(GameType::Mlbb->value),
                                Hidden::make('user_id')
                                    ->default($forcedUserId ?? auth()->id()),
                                TextInput::make('in_game_username')
                                    ->label('In-Game Name (IGN)')
                                    ->placeholder('e.g. ApexPredator')
                                    ->required()
                                    ->maxLength(100),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('in_game_id')
                                    ->label(fn (callable $get): string => match ($get('game')) {
                                        GameType::Mlbb->value, 'mlbb' => 'MLBB User ID',
                                        GameType::PubgMobile->value, 'pubg_mobile' => 'Character ID (UID)',
                                        GameType::FreeFire->value, 'free_fire' => 'Player UID',
                                        default => 'In-Game ID',
                                    })
                                    ->placeholder(fn (callable $get): string => match ($get('game')) {
                                        GameType::Mlbb->value, 'mlbb' => 'e.g. 12345678',
                                        GameType::PubgMobile->value, 'pubg_mobile' => 'e.g. 5123456789',
                                        default => 'e.g. 10982345',
                                    })
                                    ->required()
                                    ->maxLength(100),

                                TextInput::make('server_id')
                                    ->label('Zone ID / Server ID')
                                    ->placeholder('e.g. 2001')
                                    ->visible(fn (callable $get): bool => in_array($get('game'), [GameType::Mlbb->value, 'mlbb'], true))
                                    ->maxLength(50),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('roles')
                                    ->label('Tactical Roles')
                                    ->multiple()
                                    ->options(fn (callable $get): array => match ($get('game')) {
                                        GameType::Mlbb->value, 'mlbb' => MlbbRole::options(),
                                        GameType::PubgMobile->value, 'pubg_mobile' => PubgRole::options(),
                                        GameType::FreeFire->value, 'free_fire' => FreeFireRole::options(),
                                        default => [],
                                    })
                                    ->helperText('Select one or more roles. Ordered automatically by tactical priority.')
                                    ->native(false)
                                    ->searchable(),

                                Select::make('device_type')
                                    ->label('Device / Setup Type')
                                    ->options([
                                        'Smartphone (iOS/Android)' => 'Smartphone (iOS/Android)',
                                        'Tablet / iPad' => 'Tablet / iPad',
                                        'Handheld / ROG' => 'Handheld / Gaming Phone',
                                    ])
                                    ->visible(fn (callable $get): bool => in_array($get('game'), [GameType::PubgMobile->value, 'pubg_mobile'], true))
                                    ->native(false),
                            ]),

                        Select::make('main_heroes')
                            ->label('Main / Signature Heroes')
                            ->multiple()
                            ->options(app(MlbbHeroService::class)->getHeroOptions())
                            ->searchable()
                            ->visible(fn (callable $get): bool => in_array($get('game'), [GameType::Mlbb->value, 'mlbb'], true))
                            ->columnSpanFull(),

                        FileUpload::make('profile_image')
                            ->label('In-Game Profile Screenshot / Proof')
                            ->image()
                            ->optimize('webp')
                            ->downloadable()
                            ->previewable()
                            ->disk('public')
                            ->directory('game-infos/profile')
                            ->visibility('public')
                            ->columnSpanFull(),

                        Toggle::make('status')
                            ->label('Active on Roster')
                            ->helperText('Enable to display this account on your public profile and team listings.')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
