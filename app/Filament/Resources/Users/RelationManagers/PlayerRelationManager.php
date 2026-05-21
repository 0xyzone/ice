<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerRelationManager extends RelationManager
{
    protected static string $relationship = 'player';

    protected static ?string $title = 'Personal Information';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default($this->ownerRecord->id),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other']),
                DatePicker::make('date_of_birth'),
                TextInput::make('personal_contact_number'),
                TextInput::make('alt_personal_contact_number'),
                TextInput::make('emergency_contact_name'),
                TextInput::make('emergency_contact_number'),
                TextInput::make('emergency_contact_relationship'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('gender')
                    ->badge()
                    ->color(fn ($state) => $state == 'male' ? 'info' : ($state == 'female' ? 'warning' : 'danger'))
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                TextColumn::make('date_of_birth')->date(),
                TextColumn::make('personal_contact_number'),
                TextColumn::make('alt_personal_contact_number'),
                TextColumn::make('emergency_contact_name'),
                TextColumn::make('emergency_contact_number'),
                TextColumn::make('emergency_contact_relationship'),
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
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
