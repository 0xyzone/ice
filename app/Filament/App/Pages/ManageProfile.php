<?php

namespace App\Filament\App\Pages;

use App\Models\PlayerDetail;
use App\Models\UserLegalInfo;
use App\Models\UserSocial;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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
        $user = auth()->user();
        $userAvatar = ['avatar_url' => $user->avatar_url];

        $legalInfo = $user->legalInfo?->attributesToArray() ?? [];

        $galleries = $user->galleries()->pluck('image_path')->toArray();

        $this->form->fill(array_merge($playerDetail, $socials, $userAvatar, $legalInfo, ['galleries' => $galleries]));
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
                                ->description('Manage your basic personal details and avatar.')
                                ->icon('heroicon-m-user-circle')
                                ->columns(2)
                                ->schema([
                                    FileUpload::make('avatar_url')
                                        ->label('Profile Avatar')
                                        ->image()
                                        ->avatar()
                                        ->disk('public')
                                        ->visibility('public')
                                        ->directory('avatars')
                                        ->columnSpanFull()
                                        ->alignCenter(),
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
                                    Textarea::make('bio')
                                        ->maxLength(300)
                                        ->rows(3)
                                        ->placeholder('Tell us about yourself, your gaming style, custom tactics...')
                                        ->hint('Max 300 characters')
                                        ->columnSpanFull(),
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

                    Section::make('Photoshoot Gallery')
                        ->description('Upload multiple photos from your photoshoot to showcase on your public profile.')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            FileUpload::make('galleries')
                                ->label('')
                                ->multiple()
                                ->image()
                                ->disk('public')
                                ->visibility('public')
                                ->panelLayout('grid')
                                ->reorderable()
                                ->appendFiles()
                                ->directory('galleries')
                                ->previewable()
                                ->openable()
                                ->downloadable()
                                ->extraAttributes(['class' => 'compact-file-upload'])
                                ->columnSpanFull(),
                        ]),

                    Section::make('Legal Information (Nepal)')
                        ->description('This information is strictly confidential and will not be displayed on your public profile.')
                        ->icon('heroicon-m-document-text')
                        ->schema([
                            Fieldset::make('Citizenship Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('citizenship_number')
                                                ->label('Citizenship Number')
                                                ->prefixIcon('heroicon-m-identification'),
                                            Grid::make(2)
                                                ->schema([
                                                    DatePicker::make('citizenship_issued_date')
                                                        ->label('Issued Date')
                                                        ->native(false)
                                                        ->prefixIcon('heroicon-m-calendar'),
                                                    TextInput::make('citizenship_issued_place')
                                                        ->label('Issued Place')
                                                        ->prefixIcon('heroicon-m-map-pin'),
                                                ]),
                                            Grid::make(2)
                                                ->schema([
                                                    FileUpload::make('citizenship_front_image')
                                                        ->label('Citizenship (Front)')
                                                        ->image()
                                                        ->openable()
                                                        ->downloadable()
                                                        ->disk('public')
                                                        ->visibility('private')
                                                        ->directory('legal_docs'),
                                                    FileUpload::make('citizenship_back_image')
                                                        ->label('Citizenship (Back)')
                                                        ->image()
                                                        ->openable()
                                                        ->downloadable()
                                                        ->disk('public')
                                                        ->visibility('private')
                                                        ->directory('legal_docs'),
                                                ])->columnSpanFull(),
                                        ]),
                                ]),

                            Fieldset::make('Passport Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            Group::make()
                                                ->schema([
                                                    TextInput::make('passport_number')
                                                        ->label('Passport Number')
                                                        ->prefixIcon('heroicon-m-identification'),
                                                    FileUpload::make('passport_image')
                                                        ->label('Passport Image')
                                                        ->image()
                                                        ->openable()
                                                        ->downloadable()
                                                        ->disk('public')
                                                        ->visibility('private')
                                                        ->directory('legal_docs'),
                                                ]),
                                            Grid::make(2)
                                                ->schema([
                                                    DatePicker::make('passport_issued_date')
                                                        ->label('Issued Date')
                                                        ->native(false)
                                                        ->prefixIcon('heroicon-m-calendar'),
                                                    DatePicker::make('passport_expiry_date')
                                                        ->label('Expiry Date')
                                                        ->native(false)
                                                        ->prefixIcon('heroicon-m-calendar'),
                                                    TextInput::make('passport_issued_place')
                                                        ->label('Issued Place')
                                                        ->prefixIcon('heroicon-m-map-pin')
                                                        ->columnSpanFull(),
                                                ]),
                                        ]),
                                ]),

                            Fieldset::make('National ID (NID) Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('nid_number')
                                                ->label('National ID (NID) Number')
                                                ->prefixIcon('heroicon-m-identification'),
                                            Grid::make(2)
                                                ->schema([
                                                    DatePicker::make('nid_issued_date')
                                                        ->label('Issued Date')
                                                        ->native(false)
                                                        ->prefixIcon('heroicon-m-calendar'),
                                                    TextInput::make('nid_issued_place')
                                                        ->label('Issued Place')
                                                        ->prefixIcon('heroicon-m-map-pin'),
                                                ]),
                                            FileUpload::make('nid_image')
                                                ->label('NID Image')
                                                ->image()
                                                ->openable()
                                                ->downloadable()
                                                ->disk('public')
                                                ->visibility('private')
                                                ->directory('legal_docs')
                                                ->columnSpanFull(),
                                        ]),
                                ]),

                            Fieldset::make('PAN Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('pan_number')
                                                ->label('PAN Number')
                                                ->prefixIcon('heroicon-m-credit-card'),
                                            FileUpload::make('pan_image')
                                                ->label('PAN Card Image')
                                                ->image()
                                                ->openable()
                                                ->downloadable()
                                                ->disk('public')
                                                ->visibility('private')
                                                ->directory('legal_docs'),
                                        ]),
                                ]),

                            Fieldset::make('SSF Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('ssf_number')
                                                ->label('SSF Number')
                                                ->prefixIcon('heroicon-m-briefcase'),
                                            FileUpload::make('ssf_image')
                                                ->label('SSF Document Image')
                                                ->image()
                                                ->openable()
                                                ->downloadable()
                                                ->disk('public')
                                                ->visibility('private')
                                                ->directory('legal_docs'),
                                        ]),
                                ]),

                            Fieldset::make('Driving License Details')
                                ->schema([
                                    Grid::make(2)
                                        ->columnSpanFull()
                                        ->schema([
                                            TextInput::make('driving_license_number')
                                                ->label('Driving License Number')
                                                ->prefixIcon('heroicon-m-truck'),
                                            FileUpload::make('driving_license_image')
                                                ->label('Driving License Image')
                                                ->image()
                                                ->openable()
                                                ->downloadable()
                                                ->disk('public')
                                                ->visibility('private')
                                                ->directory('legal_docs'),
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

        // Separate data for each model to avoid QueryException with unguarded models
        $playerDetailKeys = [
            'gender',
            'date_of_birth',
            'personal_contact_number',
            'alt_personal_contact_number',
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_contact_relationship',
            'bio',
        ];
        $playerDetailData = Arr::only($data, $playerDetailKeys);

        $socialKeys = [
            'facebook',
            'instagram',
            'snapchat',
            'discord',
            'linkedin',
        ];
        $socialData = Arr::only($data, $socialKeys);

        $legalKeys = [
            'citizenship_number',
            'citizenship_front_image',
            'citizenship_back_image',
            'citizenship_issued_date',
            'citizenship_issued_place',
            'passport_number',
            'passport_image',
            'passport_issued_date',
            'passport_expiry_date',
            'passport_issued_place',
            'nid_number',
            'nid_image',
            'nid_issued_date',
            'nid_issued_place',
            'pan_number',
            'pan_image',
            'ssf_number',
            'ssf_image',
            'driving_license_number',
            'driving_license_image',
        ];
        $legalData = Arr::only($data, $legalKeys);

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

        // Save Legal Info
        $legalInfo = auth()->user()->legalInfo;
        if (! $legalInfo) {
            $legalInfo = new UserLegalInfo;
            $legalInfo->user_id = auth()->user()->id;
        }
        $legalInfo->fill($legalData);
        $legalInfo->save();

        // Save User Avatar
        $user = auth()->user();
        $user->avatar_url = $data['avatar_url'] ?? null;
        $user->save();

        // Save Galleries
        $galleriesData = $data['galleries'] ?? [];

        // Find deleted images (exist in DB but not in new data)
        $existingGalleries = $user->galleries()->pluck('image_path')->toArray();
        $deletedImages = array_diff($existingGalleries, $galleriesData);
        foreach ($deletedImages as $deletedImage) {
            Storage::disk('public')->delete($deletedImage);
        }

        $user->galleries()->delete();
        foreach ($galleriesData as $path) {
            if (! empty($path) && is_string($path)) {
                $user->galleries()->create([
                    'image_path' => $path,
                    'caption' => null,
                ]);
            }
        }

        Notification::make()
            ->success()
            ->title('Saved')
            ->send();

        $this->js('window.location.reload()');
    }

    public function getRecord(): ?PlayerDetail
    {
        return PlayerDetail::query()
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
