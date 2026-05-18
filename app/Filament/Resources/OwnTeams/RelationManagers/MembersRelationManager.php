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
                        'main_roster' => 'Main Roster',
                        'substitute' => 'Substitute / Reserve',
                        'coach' => 'Coach',
                        'analyst' => 'Analyst',
                        'manager' => 'Manager',
                    ])
                    ->required()
                    ->native(false),

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
            ->columns([
                TextColumn::make('user.name')
                    ->label('Player')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

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
