<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\App\Resources\GameInfos\Schemas\GameInfoForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\Card;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use TinusG\FilamentHoverImageColumn\HoverImageColumn;

class GameInfoRelationManager extends RelationManager
{
    protected static string $relationship = 'gameInfos';

    public function form(Schema $schema): Schema
    {
        return GameInfoForm::configure($schema, $this->ownerRecord->id);
    }

    /**
     * Show a card style view of a single GameInfo record.
     */
    public function view(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('game')
                            ->label('Game')
                            ->badge(),
                        TextEntry::make('roleLabel')
                            ->label('Role')
                            ->badge(),
                        TextEntry::make('in_game_id')
                            ->label('In‑Game ID'),
                        TextEntry::make('in_game_username')
                            ->label('In‑Game Username'),
                        TextEntry::make('server_id')
                            ->label('Server ID')
                            ->placeholder('-'),
                        TextEntry::make('device_type')
                            ->label('Device')
                            ->placeholder('-'),
                        ImageEntry::make('profile_image')
                            ->label('Profile Image'),
                        TextEntry::make('status')
                            ->label('Active')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('in_game_username')
            ->columns([
                TextColumn::make('game')
                    ->badge()
                    ->sortable(),
                TextColumn::make('in_game_username')
                    ->label('IGN')
                    ->searchable(),
                TextColumn::make('in_game_id')
                    ->label('ID / UID')
                    ->searchable(),
                TextColumn::make('roleLabel')
                    ->label('Role')
                    ->badge()
                    ->placeholder('-'),
                HoverImageColumn::make('profile_image'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
