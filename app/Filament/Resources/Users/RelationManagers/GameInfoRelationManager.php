<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
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
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default($this->ownerRecord->id),
                TextInput::make('in_game_id')
                    ->label('In‑Game ID'),
                TextInput::make('in_game_username')
                    ->label('In‑Game Username'),
                TextInput::make('server_id')
                    ->label('Server ID'),
                FileUpload::make('profile_image')
                    ->label('Profile Image URL')
                    ->image()
                    ->optimize('webp')
                    ->downloadable()
                    ->disk('public')
                    ->directory('game-infos/profile')
                    ->visibility('public')
                    ->previewable(),
                // status boolean toggle could be added here if needed
            ]);
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
                        TextEntry::make('in_game_id')
                            ->label('In‑Game ID'),
                        TextEntry::make('in_game_username')
                            ->label('In‑Game Username'),
                        TextEntry::make('server_id')
                            ->label('Server ID'),
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
                TextColumn::make('in_game_id'),
                TextColumn::make('in_game_username'),
                TextColumn::make('server_id'),
                HoverImageColumn::make('profile_image'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->headerActions([
                // CreateAction::make(),
            ])
            ->actions([
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
