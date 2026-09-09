<?php

namespace App\Filament\Resources\OwnTeams\RelationManagers;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Team Members & Roster';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('own_team_id')
                    ->default($this->ownerRecord->id),

                Select::make('user_id')
                    ->label('Player')
                    ->prefixIcon('heroicon-m-user')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->native(false),

                Select::make('role')
                    ->label('Team Role')
                    ->prefixIcon('heroicon-m-tag')
                    ->options([
                        'captain' => 'Captain',
                        'player' => 'Player',
                        'main_roster' => 'Main Roster Player',
                        'substitute' => 'Substitute / Reserve',
                        'coach' => 'Coach',
                        'analyst' => 'Analyst',
                        'manager' => 'Manager',
                    ])
                    ->default('player')
                    ->required()
                    ->native(false),

                Toggle::make('is_main_roster')
                    ->label('Main Roster Lineup')
                    ->helperText('Turn ON for the primary starting lineup, or OFF for normal/reserve players.')
                    ->default(true)
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user-group')
                    ->onColor('success')
                    ->offColor('gray'),

                Toggle::make('status')
                    ->label('Is Active Member')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true)
                    ->live(),

                DatePicker::make('joined_at')
                    ->label('Joined Date')
                    ->prefixIcon('heroicon-m-calendar-days')
                    ->default(now())
                    ->required()
                    ->native(false),

                DatePicker::make('left_at')
                    ->label('Left Date')
                    ->prefixIcon('heroicon-m-calendar-days')
                    ->required(fn ($get) => ! $get('status'))
                    ->visible(fn ($get) => ! $get('status'))
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('role')
            ->defaultSort('is_main_roster', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Player')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                ToggleColumn::make('is_main_roster')
                    ->label('Main Roster')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user-group')
                    ->onColor('success')
                    ->offColor('gray')
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'captain' => 'warning',
                        'main_roster' => 'success',
                        'substitute' => 'info',
                        'coach' => 'primary',
                        'analyst' => 'secondary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($record, $state) {
                        if (! $state && ! $record->left_at) {
                            $record->update(['left_at' => now()->toDateString()]);
                        } elseif ($state) {
                            $record->update(['left_at' => null]);
                        }

                        Notification::make()
                            ->title('Membership Status Updated')
                            ->success()
                            ->send();
                    }),

                TextColumn::make('joined_at')
                    ->label('Joined')
                    ->date()
                    ->sortable(),

                TextColumn::make('left_at')
                    ->label('Left')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_main_roster')
                    ->label('Lineup Type')
                    ->placeholder('All Players')
                    ->trueLabel('Main Roster Lineup')
                    ->falseLabel('Reserves / Normal Players'),
                TernaryFilter::make('status')
                    ->label('Active Membership')
                    ->placeholder('All Members')
                    ->trueLabel('Active Members')
                    ->falseLabel('Past Members'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
