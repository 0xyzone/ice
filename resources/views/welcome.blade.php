<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IceCream Fried Esports — Official Arena Hub</title>

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/filament-motion.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-dvh relative flex flex-col overflow-x-hidden subtle-mesh-bg">

        <!-- =================================================================
             NAVIGATION BAR
             ================================================================= -->
        <header class="sticky top-4 z-50 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto pro-card bg-slate-950/85 backdrop-blur-xl px-5 py-3.5 border border-slate-800/90 flex items-center justify-between shadow-xl">
                
                <!-- Brand Identity -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center p-1.5 shrink-0 overflow-hidden shadow-sm group-hover:border-orange-500/40 transition-colors">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <div>
                        <span class="font-bold tracking-tight text-base sm:text-lg text-white group-hover:text-orange-300 transition-colors">
                            IceCream <span class="text-orange-400">Fried</span>
                        </span>
                        <span class="hidden sm:block text-[11px] text-slate-400 font-medium -mt-0.5">
                            Esports Division &bull; Nepal
                        </span>
                    </div>
                </a>

                <!-- Nav Links -->
                <nav class="hidden md:flex items-center gap-7 text-xs font-semibold text-slate-300 tracking-wide">
                    <a href="#squads" class="hover:text-white transition-colors">Squads</a>
                    <a href="#roster" class="hover:text-white transition-colors">Athletes</a>
                    <a href="#heroes" class="hover:text-white transition-colors">Specialties</a>
                    <a href="#stats" class="hover:text-white transition-colors">Telemetry</a>
                    <a href="#vidanta" class="hover:text-white transition-colors">Vidanta HQ</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('filament.mukhiyas.pages.dashboard') }}" class="px-4 py-2 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-xs transition-all shadow-sm">
                            Command Deck &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-xs transition-all shadow-sm">
                            Portal Login &rarr;
                        </a>
                    @endauth
                </div>

            </div>
        </header>

        <!-- =================================================================
             HERO COMMAND CENTER
             ================================================================= -->
        <main class="flex-grow z-10">

            <section class="relative pt-10 md:pt-16 pb-12 md:pb-18 px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                        <!-- Left Content -->
                        <div class="lg:col-span-7 space-y-5 text-center lg:text-left min-w-0">

                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/25 text-orange-300 text-xs font-medium">
                                <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                                <span>Official Competitive Hub &bull; Vidanta Champions Arena</span>
                            </div>

                            <h1 class="text-[clamp(2.15rem,1.4rem+3.2vw,3.75rem)] font-extrabold tracking-tight text-white leading-[1.08]">
                                Elite Performance, <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-300 to-yellow-200">
                                    Next-Gen Esports
                                </span>
                            </h1>

                            <p class="text-slate-400 text-base sm:text-lg max-w-xl font-normal leading-relaxed mx-auto lg:mx-0">
                                Welcome to the official hub of IceCream Fried Esports. Powered by Vidanta Champions Arena, cultivating tournament-ready athletes across premier competitive titles.
                            </p>

                            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3.5 pt-2">
                                <a href="#squads" class="px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-semibold text-xs sm:text-sm transition-all shadow-sm">
                                    Explore Divisions &rarr;
                                </a>
                                <a href="#roster" class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-200 font-semibold text-xs sm:text-sm transition-all">
                                    Meet The Roster
                                </a>
                            </div>

                        </div>

                        <!-- Right Live Matrix Card -->
                        <div class="lg:col-span-5 min-w-0">
                            <div class="icf-3d-tilt pro-card p-5 sm:p-7 border border-slate-800/80 shadow-xl space-y-5">

                                <div class="flex items-center justify-between border-b border-slate-800 pb-4 gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
                                            <h3 class="font-bold text-sm text-white truncate">System Telemetry</h3>
                                        </div>
                                        <span class="text-xs text-slate-400 font-medium block mt-0.5">Active Season</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-[11px] font-semibold shrink-0">Live</span>
                                </div>

                                <div class="grid grid-cols-2 gap-3.5">
                                    <div class="bg-slate-950/40 border border-slate-800/80 p-4 rounded-xl">
                                        <span class="text-slate-400 text-xs font-medium block">Pro Divisions</span>
                                        <span class="text-2xl font-bold text-white mt-1 block">{{ sprintf("%02d", $squadsCount) }}</span>
                                        <span class="text-[11px] text-emerald-400 mt-1 block">Active Rosters</span>
                                    </div>

                                    <div class="bg-slate-950/40 border border-slate-800/80 p-4 rounded-xl">
                                        <span class="text-slate-400 text-xs font-medium block">Elite Athletes</span>
                                        <span class="text-2xl font-bold text-white mt-1 block">{{ sprintf("%02d", $athletesCount) }}</span>
                                        <span class="text-[11px] text-orange-400 mt-1 block">Active Members</span>
                                    </div>

                                    <div class="bg-slate-950/40 border border-slate-800/80 p-4 rounded-xl">
                                        <span class="text-slate-400 text-xs font-medium block">Tournaments</span>
                                        <span class="text-2xl font-bold text-sky-400 mt-1 block">{{ sprintf("%02d", $tournamentsCount) }}</span>
                                        <span class="text-[11px] text-sky-400/80 mt-1 block">Registered</span>
                                    </div>

                                    <div class="bg-slate-950/40 border border-slate-800/80 p-4 rounded-xl">
                                        <span class="text-slate-400 text-xs font-medium block">Win Rate</span>
                                        <span class="text-2xl font-bold text-amber-400 mt-1 block">{{ $winRate > 0 ? $winRate . '%' : '100%' }}</span>
                                        <span class="text-[11px] text-amber-400/80 mt-1 block">Performance</span>
                                    </div>
                                </div>

                                <div class="p-3 bg-slate-950/40 border border-slate-800/80 rounded-xl flex items-center justify-between text-xs text-slate-400">
                                    <span>Headquarters: Kathmandu &bull; Lalitpur</span>
                                    <span class="text-emerald-400 font-semibold">Ready For Scrims</span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- =================================================================
                 ACTIVE DIVISIONS & SQUADS SECTION
                 ================================================================= -->
            <section id="squads" class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80">
                <div class="max-w-6xl mx-auto space-y-8">
                    
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider block mb-1">Roster Divisions</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                                Active Squads
                            </h2>
                        </div>
                        <p class="text-slate-400 text-sm max-w-md font-normal">
                            Explore our official competitive divisions, starting 5 lineup, and reserves.
                        </p>
                    </div>

                    <!-- Teams Cards Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        @forelse($teams as $team)
                            @php
                                $isWideSquad = $teams->count() === 1 || ($loop->last && $teams->count() % 2 === 1);
                            @endphp
                            <div class="icf-3d-tilt pro-card p-6 md:p-7 border border-slate-800/80 flex flex-col justify-between group transition-all {{ $isWideSquad ? 'lg:col-span-2' : '' }}">

                                <div class="{{ $isWideSquad ? 'grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start' : '' }}">
                                    <!-- Card Header -->
                                    <div class="{{ $isWideSquad ? 'lg:col-span-5 flex flex-col justify-between space-y-5' : '' }}">
                                        <div class="flex items-start justify-between gap-4 {{ $isWideSquad ? '' : 'mb-6' }}">
                                            <div class="flex items-center gap-4 min-w-0">
                                                <div class="w-14 h-14 aspect-square rounded-2xl bg-slate-900 border border-slate-800 p-2 flex items-center justify-center shrink-0">
                                                    @if($team->logo_image)
                                                        <img src="{{ asset('storage/' . $team->logo_image) }}" alt="{{ $team->name }}" class="w-full h-full object-contain">
                                                    @else
                                                        <span class="font-bold text-lg text-orange-400">{{ substr($team->name, 0, 2) }}</span>
                                                    @endif
                                                </div>

                                                <div class="min-w-0">
                                                    <h3 class="font-bold text-lg sm:text-xl text-white group-hover:text-orange-300 transition-colors truncate">
                                                        {{ $team->name }}
                                                    </h3>
                                                    <span class="text-xs text-slate-400 font-medium block mt-0.5">
                                                        {{ $team->gameLabel }}
                                                    </span>
                                                </div>
                                            </div>

                                            <span class="px-2.5 py-1 rounded-full badge-main text-xs font-semibold shrink-0">
                                                {{ $team->short_name ?? 'PRO' }}
                                            </span>
                                        </div>

                                        @if($isWideSquad)
                                            <div class="p-4 rounded-xl bg-slate-950/40 border border-slate-800/60 flex items-center justify-between text-xs text-slate-400">
                                                <span>Active Roster Athletes</span>
                                                <span class="font-bold text-white">{{ $team->members->count() }}</span>
                                            </div>

                                            <a href="{{ route('team.profile', $team->id) }}" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-200 hover:text-white font-semibold text-xs transition-all block text-center">
                                                View Division Dossier &rarr;
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Member List -->
                                    <div class="{{ $isWideSquad ? 'lg:col-span-7' : 'pt-2 border-t border-slate-800/60' }} space-y-2.5">
                                        <div class="flex items-center justify-between text-xs text-slate-400 font-medium pb-1">
                                            <span>Roster Lineup</span>
                                            <span>Role &bull; Status</span>
                                        </div>

                                        <div class="space-y-2">
                                            @forelse($team->members as $member)
                                                @if($member->user)
                                                    <div class="flex flex-wrap items-center justify-between gap-2 bg-slate-950/40 hover:bg-slate-800/60 border border-slate-800/60 hover:border-slate-700 px-3.5 py-2.5 rounded-xl transition-all text-xs">
                                                        <div class="flex items-center gap-2.5 min-w-0">
                                                            <div class="w-2 h-2 rounded-full shrink-0 {{ $member->is_main_roster ? 'bg-orange-500' : 'bg-slate-600' }}"></div>
                                                            <div class="truncate">
                                                                <span class="font-semibold text-slate-200">
                                                                    {{ $member->user->name }}
                                                                </span>
                                                                <span class="text-slate-400 ml-1">
                                                                    {{ $member->user->username ? '@' . $member->user->username : '' }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-2 shrink-0">
                                                            @if($member->is_main_roster)
                                                                <span class="px-2 py-0.5 rounded badge-main text-[10px] font-semibold inline-flex items-center gap-1">
                                                                    ⚡ MAIN ROSTER
                                                                </span>
                                                            @else
                                                                <span class="px-2 py-0.5 rounded badge-reserve text-[10px] font-medium inline-flex items-center gap-1">
                                                                    🛡️ RESERVE
                                                                </span>
                                                            @endif
                                                            <span class="text-slate-400 capitalize">
                                                                {{ $member->role }}
                                                            </span>
                                                            <a href="{{ route('player.profile.username', $member->user->username ?? $member->user->id) }}" class="text-orange-400 hover:text-orange-300 ml-1" title="View Profile">
                                                                &rarr;
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @empty
                                                <p class="text-slate-400 text-xs py-2 text-center">No roster members currently listed.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                @unless($isWideSquad)
                                    <!-- Card Action -->
                                    <div class="pt-6 mt-6 border-t border-slate-800/60">
                                        <a href="{{ route('team.profile', $team->id) }}" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-200 hover:text-white font-semibold text-xs transition-all block text-center">
                                            View Division Dossier &rarr;
                                        </a>
                                    </div>
                                @endunless

                            </div>
                        @empty
                            <div class="col-span-full pro-card p-10 text-center text-slate-400 text-sm">
                                System rosters undergoing synchronization. Please check back shortly.
                            </div>
                        @endforelse
                    </div>

                </div>
            </section>

            <!-- =================================================================
                 MEET THE SQUAD ATHLETES CAROUSEL
                 ================================================================= -->
            <section id="roster" class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80 bg-slate-950/20">
                <div class="max-w-6xl mx-auto space-y-10">
                    
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider block mb-1">Roster Profiles</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                                Meet The Squad
                            </h2>
                            <p class="text-slate-400 text-sm max-w-md font-normal mt-1.5">
                                Profiles of competitive athletes representing IceCream Fried across competitive titles.
                            </p>
                        </div>

                        @if($members->isNotEmpty())
                            <div class="flex items-center gap-2 shrink-0">
                                <button id="carousel-prev" type="button" aria-label="Previous athletes" class="w-10 h-10 rounded-xl bg-slate-900/90 hover:bg-slate-800 border border-slate-700/80 hover:border-orange-500/50 flex items-center justify-center text-slate-200 hover:text-orange-400 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button id="carousel-next" type="button" aria-label="Next athletes" class="w-10 h-10 rounded-xl bg-slate-900/90 hover:bg-slate-800 border border-slate-700/80 hover:border-orange-500/50 flex items-center justify-center text-slate-200 hover:text-orange-400 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        @endif
                    </div>

                    @if($members->isEmpty())
                        <div class="pro-card py-12 text-center text-slate-400 text-sm">
                            Roster profiles loading...
                        </div>
                    @else
                        <div class="relative w-full overflow-hidden px-1 py-3 -my-3">
                            <!-- Carousel Track -->
                            <div id="squad-carousel" class="flex transition-transform duration-500 ease-out gap-5" style="transform: translateX(0px);">
                                @foreach($members as $member)
                                    @php
                                        $user   = $member->user;
                                        $player = $user->player;
                                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0]))->implode('');
                                        $teamGame = $member->team?->game;
                                        $matchedGameInfo = $teamGame
                                            ? $user->gameInfos->firstWhere('game', $teamGame)
                                            : $user->gameInfos->first();
                                        $roleLabels = $matchedGameInfo ? $matchedGameInfo->getRoleLabels() : [];
                                    @endphp
                                    <div class="carousel-item icf-3d-tilt flex-none w-full sm:w-[calc(50%-10px)] lg:w-[calc(33.333%-14px)] pro-card p-5 flex flex-col justify-between border border-slate-800/90 hover:border-orange-500/45 hover:-translate-y-1.5 transition-all relative overflow-hidden group">

                                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-orange-500 via-amber-400 to-sky-400 opacity-75 group-hover:opacity-100 transition-opacity"></div>

                                        <div class="space-y-4 pt-1">
                                            <!-- Avatar & Name -->
                                            <div class="flex items-center gap-4">
                                                @if($user->avatar_url)
                                                    <img src="{{ asset('storage/'.$user->avatar_url) }}" alt="{{ $user->name }}" class="w-16 h-16 aspect-square rounded-2xl object-cover border-2 border-slate-700 group-hover:border-orange-500/60 transition-colors shrink-0 shadow-md">
                                                @elseif($user->google_avatar_url)
                                                    <img src="{{ $user->google_avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 aspect-square rounded-2xl object-cover border-2 border-slate-700 group-hover:border-orange-500/60 transition-colors shrink-0 shadow-md">
                                                @else
                                                    <div class="w-16 h-16 aspect-square rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-slate-700 group-hover:border-orange-500/60 transition-colors flex items-center justify-center shrink-0 shadow-md">
                                                        <span class="font-extrabold text-orange-400 text-lg">{{ $initials }}</span>
                                                    </div>
                                                @endif

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <h3 class="font-bold text-white text-lg tracking-tight truncate group-hover:text-orange-300 transition-colors">
                                                            {{ $user->name }}
                                                        </h3>
                                                        @if($member->role === 'captain')
                                                            <span class="badge-captain px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider shrink-0">Captain</span>
                                                        @endif
                                                    </div>
                                                    @if($user->username)
                                                        <span class="text-xs text-orange-400/90 font-medium block mt-0.5">&#64;{{ $user->username }}</span>
                                                    @endif
                                                    @if($matchedGameInfo?->in_game_username)
                                                        <span class="text-[11px] text-slate-400 font-mono block mt-0.5 truncate">IGN: {{ $matchedGameInfo->in_game_username }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Badges & Tactical Roles -->
                                            <div class="flex flex-wrap gap-1.5 text-xs">
                                                @if($member->is_main_roster)
                                                    <span class="badge-main px-2.5 py-0.5 rounded text-[11px] font-semibold">Main Roster</span>
                                                @else
                                                    <span class="badge-reserve px-2.5 py-0.5 rounded text-[11px] font-medium">Reserve</span>
                                                @endif
                                                @if($member->team)
                                                    <span class="bg-slate-800/90 border border-slate-700/80 text-slate-200 px-2.5 py-0.5 rounded text-[11px] font-medium truncate max-w-full">{{ $member->team->name }}</span>
                                                @endif
                                                @foreach(array_slice($roleLabels, 0, 2) as $roleLabel)
                                                    <span class="bg-sky-500/10 border border-sky-500/25 text-sky-300 px-2 py-0.5 rounded text-[11px] font-semibold">{{ $roleLabel }}</span>
                                                @endforeach
                                            </div>

                                            <!-- Bio Preview -->
                                            <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed font-normal min-h-[2.25rem]">
                                                {{ $player && $player->bio ? $player->bio : 'Active competitive athlete in the IceCream Fried roster.' }}
                                            </p>
                                        </div>

                                        <!-- Action Link -->
                                        <div class="pt-4 mt-4 border-t border-slate-800/60">
                                            <a href="{{ route('player.profile.username', $user->username ?? $user->id) }}" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-orange-600 text-slate-200 hover:text-white font-semibold text-xs transition-all block text-center border border-slate-800 hover:border-orange-500 shadow-sm">
                                                View Athlete Profile &rarr;
                                            </a>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            <!-- Indicators -->
                            <div id="carousel-indicators" class="flex justify-center gap-1.5 mt-6"></div>
                        </div>
                    @endif

                </div>
            </section>

            <!-- =================================================================
                 TACTICAL INTEL & SPECIALTIES
                 ================================================================= -->
            <section id="heroes" class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80">
                <div class="max-w-6xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 items-center">
                        
                        <div class="lg:col-span-5 space-y-5">
                            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider block">Tactical Roles</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                                Squad Roles &amp; Meta
                            </h2>
                            <p class="text-slate-400 text-sm leading-relaxed font-normal">
                                Explore the 5-man tactical structure our rosters drill under. Every role is coordinated for teamfight execution, tempo control, and objective synergy.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs font-semibold pt-2">
                                <button onclick="selectHero('jungler')" id="btn-jungler" class="py-2.5 px-3 rounded-lg bg-orange-600 text-white shadow-sm transition-all">
                                    Jungler
                                </button>
                                <button onclick="selectHero('roamer')" id="btn-roamer" class="py-2.5 px-3 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all">
                                    Roamer
                                </button>
                                <button onclick="selectHero('gold')" id="btn-gold" class="py-2.5 px-3 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all">
                                    Gold Laner
                                </button>
                                <button onclick="selectHero('exp')" id="btn-exp" class="py-2.5 px-3 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all">
                                    EXP Laner
                                </button>
                                <button onclick="selectHero('mid')" id="btn-mid" class="py-2.5 px-3 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all col-span-2 sm:col-span-1">
                                    Mid Laner
                                </button>
                            </div>
                        </div>

                        <!-- Right Panel: Spec Board Display -->
                        <div class="lg:col-span-7">
                            <div class="pro-card p-6 md:p-8 border border-slate-800/80 shadow-xl space-y-5">
                                <div class="flex justify-between items-start pb-3 border-b border-slate-800">
                                    <div>
                                        <span id="hero-tag" class="text-orange-400 text-xs font-semibold uppercase tracking-wider">Tactical Focus</span>
                                        <h3 id="hero-title" class="font-bold text-lg sm:text-xl text-white mt-0.5">Jungler Specialization</h3>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 text-xs font-medium">
                                        Core Meta
                                    </span>
                                </div>

                                <p id="hero-desc" class="text-slate-300 text-sm leading-relaxed font-normal">
                                    The Jungler takes command of key map objectives, securing neutral buffs, farming efficiently, and carrying out tempo-shifting rotations.
                                </p>

                                <div class="space-y-3.5 pt-2">
                                    <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider block">Operational Metric Targets</span>
                                    
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span id="stat-label-1" class="text-slate-400">Objective Securing</span>
                                            <span id="stat-val-1" class="text-orange-400 font-semibold">95%</span>
                                        </div>
                                        <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden border border-slate-800">
                                            <div id="stat-bar-1" class="h-full bg-orange-500 transition-all duration-300" style="width: 95%"></div>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span id="stat-label-2" class="text-slate-400">Rotational Speed</span>
                                            <span id="stat-val-2" class="text-sky-400 font-semibold">92%</span>
                                        </div>
                                        <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden border border-slate-800">
                                            <div id="stat-bar-2" class="h-full bg-sky-500 transition-all duration-300" style="width: 92%"></div>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span id="stat-label-3" class="text-slate-400">Farming Efficiency</span>
                                            <span id="stat-val-3" class="text-amber-400 font-semibold">96%</span>
                                        </div>
                                        <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden border border-slate-800">
                                            <div id="stat-bar-3" class="h-full bg-amber-500 transition-all duration-300" style="width: 96%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- =================================================================
                 STATISTICS OVERVIEW
                 ================================================================= -->
            <section id="stats" class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80 bg-slate-950/20">
                <div class="max-w-6xl mx-auto">
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 md:gap-6">
                        <div class="pro-card p-6 text-center border border-slate-800/80">
                            <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Pro Divisions</span>
                            <span class="text-3xl font-extrabold text-white block my-1">{{ sprintf("%02d", $squadsCount) }}</span>
                            <span class="text-xs text-slate-400 font-medium">Active Squads</span>
                        </div>

                        <div class="pro-card p-6 text-center border border-slate-800/80">
                            <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Elite Athletes</span>
                            <span class="text-3xl font-extrabold text-white block my-1">{{ sprintf("%02d", $athletesCount) }}</span>
                            <span class="text-xs text-slate-400 font-medium">Roster Members</span>
                        </div>

                        <div class="pro-card p-6 text-center border border-slate-800/80">
                            <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Circuits</span>
                            <span class="text-3xl font-extrabold text-sky-400 block my-1">{{ sprintf("%02d", $tournamentsCount) }}</span>
                            <span class="text-xs text-slate-400 font-medium">Tournaments</span>
                        </div>

                        <div class="pro-card p-6 text-center border border-slate-800/80">
                            <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Win Rate</span>
                            <span class="text-3xl font-extrabold text-amber-400 block my-1">{{ $winRate > 0 ? $winRate . '%' : '100%' }}</span>
                            <span class="text-xs text-slate-400 font-medium">Competitive Rate</span>
                        </div>
                    </div>

                </div>
            </section>

            <!-- =================================================================
                 VIDANTA HQ SECTION
                 ================================================================= -->
            <section id="vidanta" class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80">
                <div class="max-w-6xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 items-center">
                        
                        <div class="lg:col-span-6 space-y-5">
                            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider block">Organization</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                                Vidanta Champions Arena
                            </h2>

                            <p class="text-slate-400 text-sm leading-relaxed font-normal">
                                IceCream Fried Esports is owned and powered by <strong class="text-white">Vidanta Champions Arena</strong>, an emerging esports organization in Nepal providing tournament administration, visual broadcasting, and elite player management.
                            </p>

                            <div class="flex flex-wrap gap-2.5 pt-1">
                                <div class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-xs text-slate-300">
                                    Founder: <strong class="text-white">Sumin Shrestha</strong>
                                </div>
                                <div class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-xs text-slate-300">
                                    Founder: <strong class="text-white">Bibek Lama</strong>
                                </div>
                            </div>

                            <div class="space-y-3 pt-2 text-xs">
                                <div class="pro-card p-4 border border-slate-800 flex justify-between items-center gap-4">
                                    <div>
                                        <h4 class="font-bold text-white text-sm">Kathmandu Headquarters</h4>
                                        <p class="text-slate-400 mt-0.5">Corporate Operations &amp; Media</p>
                                    </div>
                                    <a href="tel:+9779802350986" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-200 hover:text-white font-medium transition-colors">
                                        +977 980-2350986
                                    </a>
                                </div>

                                <div class="pro-card p-4 border border-slate-800 flex justify-between items-center gap-4">
                                    <div>
                                        <h4 class="font-bold text-white text-sm">Lalitpur Training Arena</h4>
                                        <p class="text-slate-400 mt-0.5">Satdobato-Godavari Road Bootcamp</p>
                                    </div>
                                    <a href="tel:+9779803507666" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-200 hover:text-white font-medium transition-colors">
                                        +977 980-3507666
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Map Switcher -->
                        <div class="lg:col-span-6 space-y-3">
                            <div class="flex gap-2 text-xs font-semibold">
                                <button onclick="selectMap('kathmandu')" id="btn-map-kathmandu" class="py-2 px-4 rounded-lg bg-orange-600 text-white shadow-sm transition-all">
                                    Kathmandu Map
                                </button>
                                <button onclick="selectMap('lalitpur')" id="btn-map-lalitpur" class="py-2 px-4 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all">
                                    Lalitpur Map
                                </button>
                            </div>

                            <div class="pro-card p-2 border border-slate-800 h-[340px] relative overflow-hidden">
                                <div id="map-frame-kathmandu" class="w-full h-full transition-opacity duration-300 opacity-100 absolute inset-0 p-2">
                                    <iframe 
                                        src="https://maps.google.com/maps?q=Vidanta+Champions+Arena,+King+Birendra+Marg,+Kathmandu+44600,+Nepal&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                        class="w-full h-full border-0 rounded-lg" 
                                        style="filter: invert(0.9) hue-rotate(180deg) saturate(1.4) brightness(0.95);"
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                </div>

                                <div id="map-frame-lalitpur" class="w-full h-full transition-opacity duration-300 opacity-0 absolute inset-0 pointer-events-none p-2">
                                    <iframe 
                                        src="https://maps.google.com/maps?q=Vidanta+Champions+Arena,+Satdobato-Godavari+Rd,+Lalitpur,+Nepal&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                        class="w-full h-full border-0 rounded-lg" 
                                        style="filter: invert(0.9) hue-rotate(180deg) saturate(1.4) brightness(0.95);"
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

        </main>

        <!-- =================================================================
             FOOTER
             ================================================================= -->
        <footer class="border-t border-slate-800/80 py-10 px-4 sm:px-6 lg:px-8 text-center mt-12 text-xs text-slate-400">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <a href="/" class="font-bold text-white text-sm">
                    IceCream <span class="text-orange-400">Fried</span>
                </a>

                <p>
                    &copy; {{ date('Y') }} IceCream Fried Esports &bull; Vidanta Champions Arena. All rights reserved.
                </p>

                <div class="flex items-center gap-4">
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                    <span>&bull;</span>
                    <a href="{{ url('/terms-of-service') }}" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </footer>

        <!-- Specialty and Map scripts -->
        <script>
            const heroData = {
                jungler: {
                    title: 'Jungler Specialization',
                    desc: 'The Jungler takes command of the core map objectives, focusing on securing Turtles and Lords, hyper-farming in the jungle, and carrying out high-impact rotations to snowball the game.',
                    labels: ['Objective Securing', 'Rotational Speed', 'Farming Efficiency'],
                    stats: ['95%', '92%', '96%'],
                    statRaw: [95, 92, 96]
                },
                roamer: {
                    title: 'Roamer Specialization',
                    desc: 'The Roamer controls map vision, initiates crucial teamfights, protects priority allies, and disrupts enemy formations to dictate the overall tempo of the matches.',
                    labels: ['Initiation Timing', 'Vision Dominance', 'Protection & Peel'],
                    stats: ['94%', '98%', '90%'],
                    statRaw: [94, 98, 90]
                },
                gold: {
                    title: 'Gold Laner Specialization',
                    desc: 'The Gold Laner farms aggressively in the early game to secure high-tier damage items, positioning flawlessly behind the frontlines to serve as our ultimate late-game physical carry.',
                    labels: ['Late-Game Carry', 'Positioning', 'Target Priority'],
                    stats: ['98%', '95%', '92%'],
                    statRaw: [98, 95, 92]
                },
                exp: {
                    title: 'EXP Laner Specialization',
                    desc: 'The EXP Laner secures early levels to dominate the solo lane, functioning as a high-sustain frontline bruiser that absorbs enemy damage and zones out opposition damage dealers.',
                    labels: ['Frontline Sustain', 'Sololane Dominance', 'Zoning Ability'],
                    stats: ['96%', '90%', '92%'],
                    statRaw: [96, 90, 92]
                },
                mid: {
                    title: 'Mid Laner Specialization',
                    desc: 'The Mid Laner excels at rapid wave clearing, magery support, and teamfight backup, rotating quickly to side lanes to coordinate crushing early-game ambushes.',
                    labels: ['Magic Burst Damage', 'Wave Clear Velocity', 'Rotation Support'],
                    stats: ['94%', '96%', '90%'],
                    statRaw: [94, 96, 90]
                }
            };

            function selectHero(heroClass) {
                ['jungler', 'roamer', 'gold', 'exp', 'mid'].forEach(c => {
                    const btn = document.getElementById(`btn-${c}`);
                    if (btn) {
                        btn.className = "py-2.5 px-3 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all" + (c === 'mid' ? ' col-span-2 sm:col-span-1' : '');
                    }
                });

                const activeBtn = document.getElementById(`btn-${heroClass}`);
                if (activeBtn) {
                    activeBtn.className = "py-2.5 px-3 rounded-lg bg-orange-600 text-white shadow-sm transition-all" + (heroClass === 'mid' ? ' col-span-2 sm:col-span-1' : '');
                }

                const data = heroData[heroClass];
                if (data) {
                    document.getElementById('hero-title').innerText = data.title;
                    document.getElementById('hero-desc').innerText = data.desc;
                    document.getElementById('stat-label-1').innerText = data.labels[0];
                    document.getElementById('stat-label-2').innerText = data.labels[1];
                    document.getElementById('stat-label-3').innerText = data.labels[2];
                    document.getElementById('stat-val-1').innerText = data.stats[0];
                    document.getElementById('stat-val-2').innerText = data.stats[1];
                    document.getElementById('stat-val-3').innerText = data.stats[2];
                    document.getElementById('stat-bar-1').style.width = `${data.statRaw[0]}%`;
                    document.getElementById('stat-bar-2').style.width = `${data.statRaw[1]}%`;
                    document.getElementById('stat-bar-3').style.width = `${data.statRaw[2]}%`;
                }
            }

            function selectMap(mapName) {
                const btnLalitpur = document.getElementById('btn-map-lalitpur');
                const btnKathmandu = document.getElementById('btn-map-kathmandu');
                const frameLalitpur = document.getElementById('map-frame-lalitpur');
                const frameKathmandu = document.getElementById('map-frame-kathmandu');
                
                if (mapName === 'lalitpur') {
                    btnLalitpur.className = "py-2 px-4 rounded-lg bg-orange-600 text-white shadow-sm transition-all";
                    btnKathmandu.className = "py-2 px-4 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all";
                    frameLalitpur.classList.remove('opacity-0', 'absolute', 'pointer-events-none');
                    frameLalitpur.classList.add('opacity-100');
                    frameKathmandu.classList.remove('opacity-100');
                    frameKathmandu.classList.add('opacity-0', 'absolute', 'pointer-events-none');
                } else {
                    btnKathmandu.className = "py-2 px-4 rounded-lg bg-orange-600 text-white shadow-sm transition-all";
                    btnLalitpur.className = "py-2 px-4 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white transition-all";
                    frameKathmandu.classList.remove('opacity-0', 'absolute', 'pointer-events-none');
                    frameKathmandu.classList.add('opacity-100');
                    frameLalitpur.classList.remove('opacity-100');
                    frameLalitpur.classList.add('opacity-0', 'absolute', 'pointer-events-none');
                }
            }

            // Athlete Carousel
            document.addEventListener('DOMContentLoaded', () => {
                const track = document.getElementById('squad-carousel');
                if (!track) return;

                const cards = Array.from(track.children);
                if (cards.length === 0) return;

                const prevBtn = document.getElementById('carousel-prev');
                const nextBtn = document.getElementById('carousel-next');
                const indicatorsContainer = document.getElementById('carousel-indicators');

                let currentIndex = 0;
                let autoPlayInterval = null;
                const autoPlayDelay = 4500;

                function getGap() {
                    const style = window.getComputedStyle(track);
                    const gapVal = parseFloat(style.gap);
                    return isNaN(gapVal) ? 20 : gapVal;
                }

                function getVisibleCardsCount() {
                    const containerWidth = track.parentElement.offsetWidth;
                    const cardWidth = cards[0].offsetWidth;
                    if (!cardWidth) return 1;
                    return Math.max(1, Math.round(containerWidth / cardWidth));
                }

                function getMaxIndex() {
                    const visibleCount = getVisibleCardsCount();
                    return Math.max(0, cards.length - visibleCount);
                }

                function updateControlsVisibility() {
                    const maxIndex = getMaxIndex();
                    const displayStyle = maxIndex <= 0 ? 'none' : '';
                    if (prevBtn) prevBtn.style.display = displayStyle;
                    if (nextBtn) nextBtn.style.display = displayStyle;
                    if (indicatorsContainer) indicatorsContainer.style.display = displayStyle;
                }

                function updateCarousel(transition = true) {
                    const cardWidth = cards[0].offsetWidth;
                    const gap = getGap();
                    const maxIndex = getMaxIndex();

                    if (currentIndex > maxIndex) {
                        currentIndex = 0;
                    } else if (currentIndex < 0) {
                        currentIndex = maxIndex;
                    }

                    track.style.transition = transition ? 'transform 0.5s ease-out' : 'none';
                    const translateX = -currentIndex * (cardWidth + gap);
                    track.style.transform = `translateX(${translateX}px)`;

                    updateIndicators();
                    updateControlsVisibility();
                }

                function setupIndicators() {
                    if (!indicatorsContainer) return;
                    indicatorsContainer.innerHTML = '';
                    
                    const maxIndex = getMaxIndex();
                    if (maxIndex <= 0) return;
                    
                    for (let i = 0; i <= maxIndex; i++) {
                        const dot = document.createElement('button');
                        dot.className = `h-1.5 rounded-full transition-all ${i === currentIndex ? 'bg-orange-500 w-5' : 'bg-slate-700 w-1.5'}`;
                        dot.setAttribute('aria-label', `Slide ${i + 1}`);
                        dot.addEventListener('click', () => {
                            currentIndex = i;
                            updateCarousel();
                            resetAutoPlay();
                        });
                        indicatorsContainer.appendChild(dot);
                    }
                }

                function updateIndicators() {
                    if (!indicatorsContainer) return;
                    const dots = Array.from(indicatorsContainer.children);
                    dots.forEach((dot, idx) => {
                        if (idx === currentIndex) {
                            dot.className = 'h-1.5 rounded-full transition-all bg-orange-500 w-5';
                        } else {
                            dot.className = 'h-1.5 rounded-full transition-all bg-slate-700 w-1.5';
                        }
                    });
                }

                function nextSlide() {
                    const maxIndex = getMaxIndex();
                    if (maxIndex <= 0) return;
                    currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;
                    updateCarousel();
                }

                function prevSlide() {
                    const maxIndex = getMaxIndex();
                    if (maxIndex <= 0) return;
                    currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;
                    updateCarousel();
                }

                function startAutoPlay() {
                    if (getMaxIndex() <= 0) return;
                    if (!autoPlayInterval) {
                        autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
                    }
                }

                function stopAutoPlay() {
                    if (autoPlayInterval) {
                        clearInterval(autoPlayInterval);
                        autoPlayInterval = null;
                    }
                }

                function resetAutoPlay() {
                    stopAutoPlay();
                    startAutoPlay();
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        nextSlide();
                        resetAutoPlay();
                    });
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        prevSlide();
                        resetAutoPlay();
                    });
                }

                const hoverContainer = track.parentElement;
                if (hoverContainer) {
                    hoverContainer.addEventListener('mouseenter', stopAutoPlay);
                    hoverContainer.addEventListener('mouseleave', startAutoPlay);
                }

                let resizeTimeout;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        const maxIndex = getMaxIndex();
                        if (currentIndex > maxIndex) {
                            currentIndex = maxIndex;
                        }
                        setupIndicators();
                        updateCarousel(false);
                    }, 150);
                });

                setupIndicators();
                updateCarousel(false);
                resetAutoPlay();
                window.addEventListener('load', () => {
                    setupIndicators();
                    updateCarousel(false);
                });
            });
        </script>

    </body>
</html>
