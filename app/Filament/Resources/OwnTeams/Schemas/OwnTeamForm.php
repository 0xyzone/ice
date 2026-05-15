<?php

namespace App\Filament\Resources\OwnTeams\Schemas;

use App\Models\OwnTeam;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OwnTeamForm
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
                                Section::make('Team Information')
                                    ->description('Basic details about the team.')
                                    ->schema([
                                        Select::make('game_id')
                                            ->label('Game')
                                            ->relationship('game', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('gender')
                                            ->label('Gender Category')
                                            ->options([
                                                'male' => 'Male',
                                                'female' => 'Female',
                                                'other' => 'Other',
                                                'mixed' => 'Mixed',
                                            ])
                                            ->placeholder('Select gender')
                                            ->nullable(),
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('short_name')
                                            ->label('Short Name')
                                            ->maxLength(50),
                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->unique(table: OwnTeam::class, column: 'email', ignoreRecord: true)
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Additional Information')
                                    ->schema([
                                        Textarea::make('note')
                                            ->label('Team Note')
                                            ->columnSpanFull()
                                            ->maxLength(1000)
                                            ->rows(4),
                                    ]),
                            ]),

                        Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Team Logo')
                                    ->schema([
                                        FileUpload::make('logo_image')
                                            ->hiddenLabel()
                                            ->image()
                                            ->optimize('webp')
                                            ->downloadable()
                                            ->directory('own_teams/logos')
                                            ->previewable()
                                            ->maxSize(2048),
                                    ]),
                                Section::make('Status')
                                    ->schema([
                                        Toggle::make('status')
                                            ->label('Active Team')
                                            ->helperText('Is this team currently active?')
                                            ->default(true),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
