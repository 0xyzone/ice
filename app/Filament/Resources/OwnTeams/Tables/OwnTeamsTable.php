<?php

declare(strict_types=1);

namespace App\Filament\Resources\OwnTeams\Tables;

use App\Enums\GameType;
use App\Filament\Resources\OwnTeams\OwnTeamResource;
use App\Models\OwnTeam;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OwnTeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    Split::make([
                        ImageColumn::make('logo_image')
                            ->disk('public')
                            ->circular()
                            ->imageSize(52)
                            ->defaultImageUrl(fn (OwnTeam $record): string => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&background=f97316&color=fff')
                            ->grow(false),
                        Stack::make([
                            TextColumn::make('name')
                                ->weight(FontWeight::Bold)
                                ->size(TextSize::Large)
                                ->searchable(),
                            Split::make([
                                TextColumn::make('game')
                                    ->badge(),
                                TextColumn::make('short_name')
                                    ->badge()
                                    ->color('gray')
                                    ->searchable(),
                            ])->grow(false),
                        ])->space(1),
                        IconColumn::make('status')
                            ->boolean()
                            ->extraAttributes(['class' => 'icf-card-corner-status'])
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('gender')
                            ->icon('heroicon-m-user-group')
                            ->formatStateUsing(fn (?string $state): string => $state ? 'Division: '.ucfirst($state) : 'Division: Open')
                            ->color('gray')
                            ->size(TextSize::Small),
                        TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->placeholder('No contact email')
                            ->searchable(),
                    ])->space(1),
                ])->space(3),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->label('Game')
                    ->options(GameType::class),
            ])
            ->recordActions([
                EditAction::make('quick_edit')
                    ->label('Quick Edit')
                    ->url(null)
                    ->slideOver(),
                Action::make('manage')
                    ->label('Manage')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->color('warning')
                    ->url(fn (OwnTeam $record): string => OwnTeamResource::getUrl('edit', ['record' => $record])),
                Action::make('view_team_profile')
                    ->label('Profile')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (OwnTeam $record): string => route('team.profile', $record->id), shouldOpenInNewTab: true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
