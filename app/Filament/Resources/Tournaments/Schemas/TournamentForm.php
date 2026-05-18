<?php

namespace App\Filament\Resources\Tournaments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TournamentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])
                    ->columnSpanFull()
                    ->schema([
                        Section::make('General Information')
                            ->description('Manage core details of this tournament.')
                            ->icon('heroicon-m-trophy')
                            ->columnSpan(2)
                            ->columns(1)
                            ->schema([
                                TextInput::make('name')
                                    ->prefixIcon('heroicon-m-ticket')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g. Icecream Fried Championship v1'),
                                Textarea::make('description')
                                    ->rows(5)
                                    ->placeholder('Add rules, formats, and description...')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Campaign Rules & Status')
                            ->description('Configure schedules and rewards.')
                            ->icon('heroicon-m-cog-6-tooth')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('prize_pool')
                                    ->label('Prize Pool')
                                    ->prefixIcon('heroicon-m-currency-dollar')
                                    ->placeholder('e.g. $10,000 USD')
                                    ->maxLength(255),
                                Select::make('status')
                                    ->prefixIcon('heroicon-m-arrow-path')
                                    ->options([
                                        'upcoming' => 'Upcoming',
                                        'ongoing' => 'Ongoing',
                                        'completed' => 'Completed',
                                    ])
                                    ->required()
                                    ->default('upcoming')
                                    ->native(false),
                                DatePicker::make('start_date')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->native(false),
                                DatePicker::make('end_date')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->native(false),
                            ]),
                    ]),
            ]);
    }
}
