<?php

declare(strict_types=1);

namespace App\Filament\Resources\Admins\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class AdminsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->with('roles')->whereHas('roles', function (Builder $query) {
                    $query->whereIn('name', ['admin', 'super_admin']);
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
                            TextColumn::make('roles.name')
                                ->badge()
                                ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', (string) $state)))
                                ->color(fn ($state) => in_array($state, ['admin', 'super_admin']) ? 'success' : 'gray'),
                        ])->space(1),
                        ToggleColumn::make('is_active')
                            ->label('Active')
                            ->disabled(fn (User $record): bool => $record->id === auth()->id())
                            ->extraAttributes(['class' => 'icf-card-corner-status'])
                            ->grow(false),
                    ]),
                    Stack::make([
                        TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->searchable(),
                        TextColumn::make('email_verified_at')
                            ->icon('heroicon-m-check-badge')
                            ->dateTime('M d, Y')
                            ->placeholder('Unverified')
                            ->color('gray')
                            ->size(TextSize::Small),
                    ])->space(1),
                ])->space(3),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Account Status')
                    ->placeholder('All administrators')
                    ->trueLabel('Active Admins')
                    ->falseLabel('Deactivated Admins'),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
