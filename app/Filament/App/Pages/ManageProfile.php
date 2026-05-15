<?php

namespace App\Filament\App\Pages;

use App\Models\PlayerDetail;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */

class ManageProfile extends Page
{
    protected string $view = 'filament.app.pages.manage-profile';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedUser;
    protected static string | BackedEnum | null $activeNavigationIcon = Heroicon::User;
    protected static ?string $navigationLabel = 'Profile';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Hidden::make('user_id')
                        ->default(auth()->user()->id),

                    Section::make('Account Overview')
                        ->schema([
                            TextEntry::make('user_name')
                                ->label('Player Name')
                                ->state(auth()->user()->name),
                            TextEntry::make('user_email')
                                ->label('Email Address')
                                ->state(auth()->user()->email),
                            TextEntry::make('user_id')
                                ->label('Player ID')
                                ->state(auth()->user()->id),
                        ])
                        ->columns(3)
                        ->columnSpanFull(),
                    
                    Grid::make([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Section::make('Personal Information')
                            ->description('Manage your basic personal details.')
                            ->icon('heroicon-m-user-circle')
                            ->columns(2)
                            ->schema([
                                Select::make('gender')
                                    ->prefixIcon('heroicon-m-user')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                        'other' => 'Other',
                                    ])
                                    ->required()
                                    ->native(false),
                                DatePicker::make('date_of_birth')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->required()
                                    ->native(false),
                                TextInput::make('personal_contact_number')
                                    ->prefixIcon('heroicon-m-phone')
                                    ->required(),
                                TextInput::make('alt_personal_contact_number')
                                    ->prefixIcon('heroicon-m-device-phone-mobile')
                                    ->label('Alternative Contact')
                                    ->required(),
                            ]),

                        Section::make('Emergency Contact')
                            ->description('Who should we contact in case of emergency?')
                            ->icon('heroicon-m-shield-check')
                            ->columns(1)
                            ->schema([
                                TextInput::make('emergency_contact_name')
                                    ->prefixIcon('heroicon-m-identification')
                                    ->required(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('emergency_contact_number')
                                            ->prefixIcon('heroicon-m-phone-arrow-up-right')
                                            ->required(),
                                        TextInput::make('emergency_contact_relationship')
                                            ->prefixIcon('heroicon-m-users')
                                            ->required(),
                                    ]),
                            ]),
                    ]),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $record = $this->getRecord();
        
        if (! $record) {
            $record = new PlayerDetail();
        }
        
        $record->fill($data);
        $record->save();
        
        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title('Saved')
            ->send();
    }

    public function getRecord(): ?PlayerDetail
    {
        return PlayerDetail::query()
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
