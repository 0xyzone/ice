<?php

declare(strict_types=1);

namespace App\Filament\Resources\Matches\Schemas;

use App\Enums\GameType;
use App\Models\Tournament;
use App\Models\User;
use App\Services\MlbbHeroService;
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
        $getGameType = function (callable $get): ?GameType {
            $tournamentId = $get('tournament_id');
            if ($tournamentId) {
                return Tournament::find($tournamentId)?->game;
            }

            return null;
        };

        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Match & Tournament Setup')
                                    ->description('Configure tournament match details and game format.')
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
                                                ->live()
                                                ->required(),

                                        Select::make('own_team_id')
                                            ->label('Our Participating Team')
                                            ->relationship('ownTeam', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->required(),

                                        TextInput::make('opponent_name')
                                            ->label(fn (callable $get): string => match ($getGameType($get)) {
                                                GameType::PubgMobile, GameType::FreeFire => 'Lobby / Group Name',
                                                default => 'Opponent Team Name',
                                            })
                                            ->placeholder(fn (callable $get): string => match ($getGameType($get)) {
                                                GameType::PubgMobile, GameType::FreeFire => 'e.g. Grand Finals Lobby A / 16 Teams',
                                                default => 'e.g. Team Liquid / Falcon Esports',
                                            })
                                            ->nullable()
                                            ->maxLength(255),

                                        TextInput::make('stage')
                                            ->label('Tournament Stage / Day')
                                            ->placeholder('e.g. Group Stage, Grand Finals Day 1')
                                            ->maxLength(255),

                                        DateTimePicker::make('match_date')
                                            ->label('Match Date & Time')
                                            ->required(),

                                        TextInput::make('best_of')
                                            ->label('Best Of Series (BO)')
                                            ->numeric()
                                            ->default(3)
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                            ->required(),
                                    ])->columns(2),

                                Section::make('Games / Maps / Rounds Played')
                                    ->description('Record rounds or maps played in this match.')
                                    ->schema([
                                        Repeater::make('series')
                                            ->relationship('series')
                                            ->label('Match Maps / Rounds')
                                            ->itemLabel(fn (array $state): ?string => isset($state['game_number']) ? 'Round / Map #'.$state['game_number'] : null)
                                            ->schema([
                                                // ── Round / Map Header ───────────────────────────
                                                Grid::make(4)
                                                    ->schema([
                                                        TextInput::make('game_number')
                                                            ->label('Game / Map Number')
                                                            ->numeric()
                                                            ->default(1)
                                                            ->required(),

                                                        Select::make('map_name')
                                                            ->label('Map / Arena')
                                                            ->options(function (callable $get) use ($getGameType): array {
                                                                $game = $getGameType($get);

                                                                return $game ? $game->getMaps() : [
                                                                    'Erangel' => 'Erangel',
                                                                    'Miramar' => 'Miramar',
                                                                    'Sanhok' => 'Sanhok',
                                                                    'Bermuda' => 'Bermuda',
                                                                    'Sanctum Island' => 'Sanctum Island',
                                                                ];
                                                            })
                                                            ->searchable()
                                                            ->nullable(),

                                                        // MOBA score inputs
                                                        TextInput::make('our_score')
                                                            ->label('Our Score')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                                            ->required(),

                                                        TextInput::make('opponent_score')
                                                            ->label('Opponent Score')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                                            ->required(),
                                                    ]),

                                                // ── Battle Royale Scoring Row ─────────────────────
                                                Grid::make(4)
                                                    ->visible(fn (callable $get): bool => $getGameType($get)?->isBattleRoyale() ?? false)
                                                    ->schema([
                                                        TextInput::make('placement')
                                                            ->label('Placement / Rank')
                                                            ->placeholder('e.g. 1 for #1 WWCD/Booyah')
                                                            ->numeric()
                                                            ->minValue(1)
                                                            ->live()
                                                            ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                                                if ($state === 1) {
                                                                    $set('did_we_win', true);
                                                                }
                                                                $pPts = (int) ($get('placement_points') ?? 0);
                                                                $kPts = (int) ($get('kill_points') ?? 0);
                                                                $set('total_points', $pPts + $kPts);
                                                            }),

                                                        TextInput::make('placement_points')
                                                            ->label('Placement Points')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->live()
                                                            ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                                                $pPts = (int) ($state ?? 0);
                                                                $kPts = (int) ($get('kill_points') ?? 0);
                                                                $set('total_points', $pPts + $kPts);
                                                            }),

                                                        TextInput::make('kill_points')
                                                            ->label('Kill Points')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->live()
                                                            ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                                                $pPts = (int) ($get('placement_points') ?? 0);
                                                                $kPts = (int) ($state ?? 0);
                                                                $set('total_points', $pPts + $kPts);
                                                            }),

                                                        TextInput::make('total_points')
                                                            ->label('Total Points')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->helperText('Placement Pts + Kill Pts'),
                                                    ]),

                                                Grid::make(2)
                                                    ->schema([
                                                        Toggle::make('did_we_win')
                                                            ->label(fn (callable $get): string => match ($getGameType($get)) {
                                                                GameType::PubgMobile => 'Winner Winner Chicken Dinner (#1 WWCD)',
                                                                GameType::FreeFire => 'Booyah! Winner (#1)',
                                                                default => 'We Won This Game',
                                                            })
                                                            ->inline(false)
                                                            ->afterStateHydrated(function (Toggle $component, $record): void {
                                                                $component->state($record?->result === 'won');
                                                            }),
                                                    ]),

                                                // ── Player Performance Sub-Repeater ───────────────
                                                Section::make('Player Individual Performance')
                                                    ->schema([
                                                        Repeater::make('playerStats')
                                                            ->relationship('playerStats')
                                                            ->label('Player Performances')
                                                            ->schema([
                                                                // Row 1: Player & Hero / Identity
                                                                Grid::make(4)
                                                                    ->schema([
                                                                        Select::make('user_id')
                                                                            ->label('Player')
                                                                            ->relationship('user', 'name')
                                                                            ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->name} (@{$record->username})")
                                                                            ->options(function (callable $get): array {
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

                                                                        Select::make('hero')
                                                                            ->label('Hero Played')
                                                                            ->options(app(MlbbHeroService::class)->getHeroOptions())
                                                                            ->searchable()
                                                                            ->nullable()
                                                                            ->placeholder('Select hero...')
                                                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                                                            ->columnSpan(2),
                                                                    ]),

                                                                // Row 2: Core Combat Metrics (Kills, Deaths, Assists, MVP)
                                                                Grid::make(4)
                                                                    ->schema([
                                                                        TextInput::make('kills')
                                                                            ->label(fn (callable $get): string => $getGameType($get)?->isBattleRoyale() ? 'Eliminations / Kills' : 'Kills')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->required(),

                                                                        TextInput::make('deaths')
                                                                            ->label('Deaths')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                                                            ->required(),

                                                                        TextInput::make('assists')
                                                                            ->label('Assists')
                                                                            ->numeric()
                                                                            ->default(0)
                                                                            ->required(),

                                                                        Toggle::make('is_mvp')
                                                                            ->label('MVP of Match')
                                                                            ->inline(false),
                                                                    ]),

                                                                // Row 3: MOBA-specific stats (Gold, Damage, Turret Damage)
                                                                Grid::make(3)
                                                                    ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true)
                                                                    ->schema([
                                                                        TextInput::make('total_gold')
                                                                            ->label('Total Gold Farmed')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 12500'),

                                                                        TextInput::make('damage_dealt')
                                                                            ->label('Hero Damage Dealt')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 85000'),

                                                                        TextInput::make('turret_damage')
                                                                            ->label('Turret Push Damage')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 7400'),
                                                                    ]),

                                                                // Row 4: Battle Royale specific stats (Survival Time, Damage, Knocks/Revives/Headshots)
                                                                Grid::make(4)
                                                                    ->visible(fn (callable $get): bool => $getGameType($get)?->isBattleRoyale() ?? false)
                                                                    ->schema([
                                                                        TextInput::make('damage_dealt')
                                                                            ->label('Total Damage Dealt')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 1450'),

                                                                        TextInput::make('survival_time')
                                                                            ->label('Survival Time (Seconds)')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 1240 (20m 40s)'),

                                                                        TextInput::make('knockdowns')
                                                                            ->label('Knockdowns (DBNO)')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 4')
                                                                            ->visible(fn (callable $get): bool => in_array($getGameType($get), [GameType::PubgMobile, null], true)),

                                                                        TextInput::make('revives')
                                                                            ->label('Teammates Revived')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 2')
                                                                            ->visible(fn (callable $get): bool => in_array($getGameType($get), [GameType::PubgMobile, null], true)),

                                                                        TextInput::make('headshots')
                                                                            ->label('Headshot Kills')
                                                                            ->numeric()
                                                                            ->placeholder('e.g. 5')
                                                                            ->visible(fn (callable $get): bool => in_array($getGameType($get), [GameType::FreeFire, null], true)),
                                                                    ]),

                                                                KeyValue::make('extra_stats')
                                                                    ->label('Extra / Custom Game Stats')
                                                                    ->keyLabel('Metric Name')
                                                                    ->valueLabel('Value')
                                                                    ->keyPlaceholder('e.g. Accuracy, Heals, Medals')
                                                                    ->valuePlaceholder('e.g. 85%, 450, Gold Badge')
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
                                Section::make('Opponent / Lobby Media')
                                    ->schema([
                                        FileUpload::make('opponent_logo')
                                            ->label('Opponent or Tournament Logo')
                                            ->image()
                                            ->optimize('webp')
                                            ->downloadable()
                                            ->disk('public')
                                            ->directory('matches/opponents')
                                            ->visibility('public')
                                            ->previewable()
                                            ->maxSize(2048),
                                    ]),

                                Section::make('Overall Match Result')
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
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true),

                                        TextInput::make('opponent_score')
                                            ->label('Maps Won By Opponent')
                                            ->numeric()
                                            ->default(0)
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isMoba() ?? true),

                                        TextInput::make('placement')
                                            ->label('Overall Lobby Placement')
                                            ->numeric()
                                            ->placeholder('#1, #2, etc.')
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isBattleRoyale() ?? false),

                                        TextInput::make('total_points')
                                            ->label('Total Points Scored')
                                            ->numeric()
                                            ->placeholder('e.g. 35')
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isBattleRoyale() ?? false),

                                        Toggle::make('is_winner')
                                            ->label('Winner of Match (WWCD / Booyah)')
                                            ->visible(fn (callable $get): bool => $getGameType($get)?->isBattleRoyale() ?? false),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
