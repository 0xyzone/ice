<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialsRelationManager extends RelationManager
{
    protected static string $relationship = 'socials';

    protected static ?string $title = 'Social Profiles';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default($this->ownerRecord->id),
                TextInput::make('facebook')
                    ->prefixIcon('heroicon-m-globe-alt')
                    ->placeholder('https://facebook.com/username')
                    ->url(),
                TextInput::make('instagram')
                    ->prefixIcon('heroicon-m-globe-alt')
                    ->placeholder('https://instagram.com/username')
                    ->url(),
                TextInput::make('snapchat')
                    ->prefixIcon('heroicon-m-globe-alt')
                    ->placeholder('Snapchat username'),
                TextInput::make('discord')
                    ->prefixIcon('heroicon-m-chat-bubble-left-right')
                    ->placeholder('Discord Username or ID'),
                TextInput::make('linkedin')
                    ->prefixIcon('heroicon-m-globe-alt')
                    ->placeholder('https://linkedin.com/in/username')
                    ->url(),
            ]);
    }

    public function table(Table $table): Table
    {
        $parseHandle = function (?string $url, string $platform): ?string {
            if (! $url) {
                return null;
            }
            $path = parse_url($url, PHP_URL_PATH);
            if (! $path) {
                return $url;
            }
            $path = trim($path, '/');
            if ($platform === 'linkedin' && str_starts_with($path, 'in/')) {
                $path = substr($path, 3);
            }

            return $platform === 'instagram' ? "@{$path}" : $path;
        };

        return $table
            ->recordTitleAttribute('facebook')
            ->columns([
                TextColumn::make('facebook')
                    ->label('Facebook')
                    ->icon('heroicon-m-globe-alt')
                    ->url(fn ($record) => $record->facebook)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $parseHandle($state, 'facebook'))
                    ->placeholder('N/A'),
                TextColumn::make('instagram')
                    ->label('Instagram')
                    ->icon('heroicon-m-globe-alt')
                    ->url(fn ($record) => $record->instagram)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $parseHandle($state, 'instagram'))
                    ->placeholder('N/A'),
                TextColumn::make('snapchat')
                    ->label('Snapchat')
                    ->icon('heroicon-m-globe-alt')
                    ->formatStateUsing(fn ($state) => $state ? "@{$state}" : null)
                    ->placeholder('N/A'),
                TextColumn::make('discord')
                    ->label('Discord ID')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->placeholder('N/A'),
                TextColumn::make('linkedin')
                    ->label('LinkedIn')
                    ->icon('heroicon-m-globe-alt')
                    ->url(fn ($record) => $record->linkedin)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $parseHandle($state, 'linkedin'))
                    ->placeholder('N/A'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (RelationManager $livewire) => $livewire->ownerRecord->socials()->count() === 0),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
