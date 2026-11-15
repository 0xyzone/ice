<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('roles')->whereHas('roles', function (Builder $query) {
                    $query->where('name', 'player');
                });
            })
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    Split::make([
                        ImageColumn::make('avatar_full_url')
                            ->circular()
                            ->imageSize(48)
                            ->grow(false),
                        Stack::make([
                            TextColumn::make('name')
                                ->weight(FontWeight::Bold)
                                ->size(TextSize::Medium)
                                ->searchable(),
                            TextColumn::make('username')
                                ->prefix('@')
                                ->color('primary')
                                ->size(TextSize::Small)
                                ->searchable(),
                        ])->space(1),
                        ToggleColumn::make('is_active')
                            ->label('Active')
                            ->extraAttributes(['class' => 'icf-card-corner-status'])
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->searchable(),
                        Split::make([
                            TextColumn::make('roles.name')
                                ->badge()
                                ->formatStateUsing(fn ($state) => ucfirst($state))
                                ->color('info'),
                            TextColumn::make('created_at')
                                ->since()
                                ->color('gray')
                                ->size(TextSize::Small)
                                ->grow(false),
                        ]),
                    ])->space(1),
                ])->space(3),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Account Status')
                    ->placeholder('All players')
                    ->trueLabel('Active Players')
                    ->falseLabel('Deactivated Players'),
            ])
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make('quick_edit')
                    ->label('Quick Edit')
                    ->url(null)
                    ->slideOver(),
                Action::make('manage')
                    ->label('Manage')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->color('warning')
                    ->url(fn (User $record): string => UserResource::getUrl('edit', ['record' => $record])),
                Impersonate::make()
                    ->label('Impersonate')
                    ->color('info')
                    ->redirectTo(fn (): string => filament()->getPanel('app')->getUrl())
                    ->backTo(fn (): string => UserResource::getUrl('index', panel: 'mukhiyas')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
