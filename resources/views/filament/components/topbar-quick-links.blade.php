@php
    $panel = filament()->getCurrentPanel();
    $panelId = $panel?->getId();
    $links = [];

    if ($panelId === 'mukhiyas') {
        $links[] = [
            'label' => 'Dashboard',
            'url' => $panel->getUrl(),
            'active' => request()->routeIs('filament.mukhiyas.pages.dashboard'),
        ];

        if (\App\Filament\Resources\OwnTeams\OwnTeamResource::canViewAny()) {
            $links[] = [
                'label' => 'Teams',
                'url' => \App\Filament\Resources\OwnTeams\OwnTeamResource::getUrl('index', panel: 'mukhiyas'),
                'active' => request()->routeIs('filament.mukhiyas.resources.own-teams.*'),
            ];
        }

        if (\App\Filament\Resources\Tournaments\TournamentResource::canViewAny()) {
            $links[] = [
                'label' => 'Tournaments',
                'url' => \App\Filament\Resources\Tournaments\TournamentResource::getUrl('index', panel: 'mukhiyas'),
                'active' => request()->routeIs('filament.mukhiyas.resources.tournaments.*'),
            ];
        }

        if (\App\Filament\Resources\Users\UserResource::canViewAny()) {
            $links[] = [
                'label' => 'Players',
                'url' => \App\Filament\Resources\Users\UserResource::getUrl('index', panel: 'mukhiyas'),
                'active' => request()->routeIs('filament.mukhiyas.resources.users.*'),
            ];
        }

        if (\App\Filament\App\Pages\ManageProfile::canAccess()) {
            $links[] = [
                'label' => 'Manage Profile',
                'url' => \App\Filament\App\Pages\ManageProfile::getUrl(panel: 'mukhiyas'),
                'active' => request()->routeIs('filament.mukhiyas.pages.manage-profile'),
            ];
        }
    } elseif ($panelId === 'app') {
        $links[] = [
            'label' => 'Dashboard',
            'url' => $panel->getUrl(),
            'active' => request()->routeIs('filament.app.pages.dashboard'),
        ];

        if (\App\Filament\App\Resources\GameInfos\GameInfoResource::canViewAny()) {
            $links[] = [
                'label' => 'My Games',
                'url' => \App\Filament\App\Resources\GameInfos\GameInfoResource::getUrl('index', panel: 'app'),
                'active' => request()->routeIs('filament.app.resources.game-infos.*'),
            ];
        }

        if (\App\Filament\App\Pages\ManageProfile::canAccess()) {
            $links[] = [
                'label' => 'Manage Profile',
                'url' => \App\Filament\App\Pages\ManageProfile::getUrl(panel: 'app'),
                'active' => request()->routeIs('filament.app.pages.manage-profile'),
            ];
        }
    }
@endphp

<div class="fi-topbar-nav-group">
    @if (count($links))
        <nav aria-label="Quick navigation" class="fi-topbar-quick-links hidden lg:flex items-center">
            @foreach ($links as $link)
                <a
                    href="{{ $link['url'] }}"
                    wire:navigate
                    class="fi-topbar-quick-link {{ $link['active'] ? 'is-active' : '' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    @endif

    <a
        href="{{ route('home') }}"
        title="Go to Public Homepage"
        class="fi-topbar-home-btn"
    >
        <x-filament::icon
            icon="heroicon-m-home"
            class="w-4 h-4"
        />
        <span class="hidden sm:inline">Homepage</span>
    </a>
</div>
