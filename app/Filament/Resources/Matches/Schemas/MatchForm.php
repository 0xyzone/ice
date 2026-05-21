<?php

namespace App\Filament\Resources\Matches\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MatchForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Match Matchup Details')
                                    ->description('Configure the overall matchup in the tournament.')
                                    ->schema([
                                        $isRelation
                                            ? Select::make('tournament_id')
                                                ->relationship('tournament', 'name')
                                                ->disabled()
                                                ->dehydrated()
                                                ->hidden()
                                            : Select::make('tournament_id')
                                                ->label('Tournament')
                                                ->relationship('tournament', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required(),
                                        Select::make('own_team_id')
                                            ->label('Our Participating Team')
                                            ->relationship('ownTeam', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->live() // Triggers reactive updates for player filtering in nested repeaters
                                            ->required(),
                                        TextInput::make('opponent_name')
                                            ->label('Opponent Team Name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('stage')
                                            ->label('Tournament Stage')
                                            ->placeholder('e.g. Group Stage, Grand Finals')
                                            ->maxLength(255),
                                        DateTimePicker::make('match_date')
                                            ->label('Match Date & Time')
                                            ->required(),
                                        TextInput::make('best_of')
                                            ->label('Best Of Series (BO)')
                                            ->numeric()
                                            ->default(3)
                                            ->required(),
                                    ])->columns(2),

                                Section::make('Match Series Games & Maps')
                                    ->description('Add individual maps/games played in this series.')
                                    ->schema([
                                        Repeater::make('series')
                                            ->relationship('series')
                                            ->label('Match Series Maps')
                                            ->itemLabel(fn (array $state): ?string => isset($state['game_number']) ? 'Game #'.$state['game_number'] : null)
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('game_number')
                                                            ->label('Game / Map Number')
                                                            ->numeric()
                                                            ->default(1)
                                                            ->required(),
                                                        TextInput::make('our_score')
                                                            ->label('Our Score')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->required(),
                                                        TextInput::make('opponent_score')
                                                            ->label('Opponent Score')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->required(),
                                                    ]),

                                                Section::make('Player Stats for this Game')
                                                    ->schema([
                                                        Repeater::make('playerStats')
                                                            ->relationship('playerStats')
                                                            ->label('Player Individual Performance')
                                                            ->schema([
                                                                Grid::make(5)
                                                                    ->schema([
                                                                        Select::make('user_id')
                                                                            ->label('Player')
                                                                            ->relationship('user', 'name')
                                                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} (@{$record->username})")
                                                                            ->options(function (callable $get) {
                                                                                // Trace back double nested repeater context in Filament v5
                                                                                $teamId = $get('../../own_team_id');

                                                                                if (! $teamId) {
                                                                                    return User::whereHas('roles', fn ($q) => $q->where('name', 'player'))
                                                                                        ->get()
                                                                                        ->mapWithKeys(fn ($user) => [
                                                                                            $user->id => $user->name.' (@'.$user->username.')',
                                                                                        ])
                                                                                        ->toArray();
                                                                                }

                                                                                return User::whereHas('teamMemberships', fn ($q) => $q->where('own_team_id', $teamId))
                                                                                    ->get()
                                                                                    ->mapWithKeys(fn ($user) => [
                                                                                        $user->id => $user->name.' (@'.$user->username.')',
                                                                                    ])
                                                                                    ->toArray();
                                                                            })
                                                                            ->searchable()
                                                                            ->preload()
                                                                            ->required()
                                                                            ->columnSpan(2),
                                                                        TextInput::make('kills')
                                                                            ->label('Kills')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->required(),
                                                                        TextInput::make('deaths')
                                                                            ->label('Deaths')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->required(),
                                                                        TextInput::make('assists')
                                                                            ->label('Assists')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->required(),
                                                                        Toggle::make('is_mvp')
                                                                            ->label('MVP')
                                                                            ->inline(false)
                                                                            ->columnSpan(1),
                                                                    ]),
                                                                KeyValue::make('extra_stats')
                                                                    ->label('Extra / Game-Specific Stats')
                                                                    ->keyLabel('Metric Name')
                                                                    ->valueLabel('Value')
                                                                    ->keyPlaceholder('e.g. Hero, Gold, Damage, ACS')
                                                                    ->valuePlaceholder('e.g. Ling, 12K, 85000, 240')
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->defaultItems(0)
                                                            ->columns(1)
                                                            ->grid(1),
                                                    ])
                                                    ->compact()
                                                    ->columnSpanFull(),
                                            ])
                                            ->defaultItems(1)
                                            ->columns(1)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Opponent Logo')
                                    ->schema([
                                        FileUpload::make('opponent_logo')
                                            ->hiddenLabel()
                                            ->image()
                                            ->optimize('webp')
                                            ->downloadable()
                                            ->disk('public')
                                            ->directory('matches/opponents')
                                            ->visibility('public')
                                            ->previewable()
                                            ->maxSize(2048),
                                    ]),

                                Section::make('Overall Match Outcome')
                                    ->schema([
                                        Select::make('status')
                                            ->label('Match Status')
                                            ->options([
                                                'scheduled' => 'Scheduled',
                                                'ongoing' => 'Ongoing',
                                                'completed' => 'Completed',
                                            ])
                                            ->default('completed')
                                            ->required(),
                                        TextInput::make('our_score')
                                            ->label('Maps Won By Us')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->required(),
                                        TextInput::make('opponent_score')
                                            ->label('Maps Won By Opponent')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
