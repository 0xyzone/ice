<?php

namespace App\Filament\App\Pages;

use App\Models\PlayerDetail;
use App\Models\UserSocial;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Support\Arr;

/**
 * @property-read Schema $form
 */
class ManageProfile extends Page
{
    protected string $view = 'filament.app.pages.manage-profile';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::User;

    protected static ?string $navigationLabel = 'Profile';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $playerDetail = $this->getRecord()?->attributesToArray() ?? [];
        $socials = auth()->user()->socials?->attributesToArray() ?? [];

        $this->form->fill(array_merge($playerDetail, $socials));
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
                                        ->hint('(Optional)'),
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
                                            Select::make('emergency_contact_relationship')
                                                ->prefixIcon('heroicon-m-users')
                                                ->options([
                                                    'father' => 'Father',
                                                    'mother' => 'Mother',
                                                    'brother' => 'Brother',
                                                    'sister' => 'Sister',
                                                    'friend' => 'Friend',
                                                    'other' => 'Other',
                                                ])
                                                ->required()
                                                ->native(false),
                                        ]),
                                ]),
                        ]),

                    Section::make('Social Media Profiles')
                        ->description('Add your social profiles and gaming handles.')
                        ->icon('heroicon-m-share')
                        ->columns(2)
                        ->schema([
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

        // Separate data for each model to avoid QueryException with unguarded models
        $playerDetailKeys = [
            'gender', 'date_of_birth', 'personal_contact_number', 'alt_personal_contact_number',
            'emergency_contact_name', 'emergency_contact_number', 'emergency_contact_relationship',
        ];
        $playerDetailData = Arr::only($data, $playerDetailKeys);

        $socialKeys = [
            'facebook', 'instagram', 'snapchat', 'discord', 'linkedin',
        ];
        $socialData = Arr::only($data, $socialKeys);

        // Save Player Details
        $record = $this->getRecord();
        if (! $record) {
            $record = new PlayerDetail;
            $record->user_id = auth()->user()->id;
        }
        $record->fill($playerDetailData);
        $record->save();

        // Save Socials
        $socials = auth()->user()->socials;
        if (! $socials) {
            $socials = new UserSocial;
            $socials->user_id = auth()->user()->id;
        }
        $socials->fill($socialData);
        $socials->save();

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
