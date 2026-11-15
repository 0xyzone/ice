<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->name }} — Esports Team Profile</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/filament-motion.js'])
</head>
<body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-dvh py-6 sm:py-10 px-4 sm:px-6 lg:px-8 subtle-mesh-bg overflow-x-hidden">

    <div class="relative z-10 max-w-6xl mx-auto space-y-8 sm:space-y-10">

        <!-- Top Navigation -->
        <nav class="flex items-center justify-between flex-wrap gap-4">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900/60 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white text-xs font-semibold tracking-wide transition-all group shadow-sm">
                <svg class="w-4 h-4 text-orange-400 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to Homepage</span>
            </a>

            <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Active Division Profile</span>
            </div>
        </nav>

        <!-- =================================================================
             TEAM HERO BANNER
             ================================================================= -->
        <header class="icf-3d-tilt pro-card p-5 sm:p-8 lg:p-10 border border-slate-800/80 shadow-xl relative overflow-hidden">

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8">

                <!-- Team Crest / Logo -->
                <div class="w-28 h-28 md:w-36 md:h-36 aspect-square rounded-2xl bg-slate-900 border border-slate-800 p-3 flex items-center justify-center shrink-0 shadow-lg relative overflow-hidden">
                    @if($team->logo_image)
                        <img src="{{ asset('storage/' . $team->logo_image) }}" alt="{{ $team->name }}" class="w-full h-full object-contain" />
                    @else
                        <div class="text-orange-400 font-bold text-4xl uppercase">{{ substr($team->name, 0, 2) }}</div>
                    @endif
                </div>

                <!-- Team Information -->
                <div class="flex-1 min-w-0 text-center md:text-left space-y-4">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <h1 class="text-[clamp(1.75rem,1.2rem+2.2vw,2.75rem)] font-extrabold tracking-tight text-white leading-tight">
                            {{ $team->name }}
                        </h1>
                        @if($team->short_name)
                            <span class="px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/25 text-orange-300 text-xs font-semibold uppercase tracking-wider">
                                {{ $team->short_name }}
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <x-game-logo :game="$team->game" size="md" />
                        <span class="sr-only">{{ $team->gameLabel }}</span>
                    </div>

                    <!-- Key Metadata Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                        <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl">
                            <span class="text-slate-400 font-medium text-[11px] block">Division Bracket</span>
                            <span class="text-white font-semibold text-sm mt-0.5 block capitalize">{{ $team->gender ?? 'Open Division' }}</span>
                        </div>
                        <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl min-w-0">
                            <span class="text-slate-400 font-medium text-[11px] block">Team Communications</span>
                            <span class="text-slate-200 font-semibold text-sm mt-0.5 block truncate">{{ $team->email ?? 'management@vidantaca.com.np' }}</span>
                        </div>
                        <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl">
                            <span class="text-slate-400 font-medium text-[11px] block">Roster Status</span>
                            @if($team->status)
                                <span class="text-emerald-400 font-semibold text-sm mt-0.5 inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                </span>
                            @else
                                <span class="text-slate-400 font-semibold text-sm mt-0.5 block">Standby</span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </header>

        <!-- =================================================================
             STATISTICS SUMMARY STRIP (BALANCED 4-CARD GRID)
             ================================================================= -->
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="pro-card p-5 text-center border border-slate-800/80">
                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Matches Played</span>
                <span class="text-2xl md:text-3xl font-bold text-white">{{ $totalPlayed }}</span>
            </div>
            <div class="pro-card p-5 text-center border border-slate-800/80">
                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Record (W / L)</span>
                <div class="text-2xl md:text-3xl font-bold">
                    <span class="text-emerald-400">{{ $totalWon }}W</span>
                    <span class="text-slate-600 mx-1">/</span>
                    <span class="text-red-400">{{ $totalLost }}L</span>
                </div>
            </div>
            <div class="pro-card p-5 text-center border border-slate-800/80">
                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Win Rate</span>
                <span class="text-2xl md:text-3xl font-bold text-sky-400">{{ $winRate }}%</span>
            </div>
            <div class="pro-card p-5 text-center border border-slate-800/80">
                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Total Points</span>
                <span class="text-2xl md:text-3xl font-bold text-amber-400">{{ $totalPoints }}</span>
            </div>
        </section>

        <!-- =================================================================
             MAIN CONTENT: ROSTER & CAMPAIGNS
             ================================================================= -->
        <main class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-10">
            
            <!-- LEFT COLUMN: ACTIVE ROSTER (SPAN 7) -->
            <section class="lg:col-span-7 space-y-8">
                @php
                    $mainLineup = $team->members->where('is_main_roster', true);
                    $reserveLineup = $team->members->where('is_main_roster', false);
                @endphp

                <!-- 1. MAIN ROSTER (STARTING LINEUP) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-6 rounded-md bg-orange-500 block"></span>
                            <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                                Main Roster Lineup
                            </h2>
                        </div>
                        <span class="px-3 py-1 rounded-full badge-main text-xs font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                            {{ $mainLineup->count() }} Starting Athletes
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($mainLineup as $member)
                            <a href="{{ route('player.profile', $member->user_id) }}" class="pro-card p-4 flex items-center justify-between gap-4 border border-slate-800 hover:border-orange-500/40 group transition-all">
                                
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <!-- Avatar -->
                                    <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                                        @if($member->user->avatar_url)
                                            <img src="{{ asset('storage/'.$member->user->avatar_url) }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @elseif($member->user->google_avatar_url)
                                            <img src="{{ $member->user->google_avatar_url }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-orange-400 font-bold text-sm uppercase">{{ substr($member->user->name, 0, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-white group-hover:text-orange-300 text-sm tracking-tight truncate transition-colors">
                                            {{ $member->user->name }}
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                            <span class="text-[11px] font-medium px-2 py-0.5 rounded capitalize
                                                @if($member->role === 'captain') badge-captain
                                                @else bg-slate-800 text-slate-300 border border-slate-700
                                                @endif">
                                                {{ ucwords(str_replace('_', ' ', $member->role)) }}
                                            </span>
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded badge-main inline-flex items-center gap-1">
                                                ⚡ MAIN LINEUP
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="px-3 py-1.5 rounded-lg bg-slate-800/80 border border-slate-700 text-slate-300 text-xs font-semibold group-hover:bg-orange-500 group-hover:border-orange-500 group-hover:text-white transition-all shrink-0">
                                    Profile &rarr;
                                </span>
                            </a>
                        @empty
                            <div class="pro-card p-6 text-center text-slate-400 col-span-2 text-sm">
                                No main roster players currently assigned.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 2. RESERVES & SUBSTITUTES -->
                <div class="space-y-4 pt-2">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-5 rounded-md bg-sky-500 block"></span>
                            <h2 class="text-base md:text-lg font-bold text-slate-200 tracking-tight">
                                Reserves &amp; Normal Squad
                            </h2>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full badge-reserve text-xs font-semibold">
                            {{ $reserveLineup->count() }} Reserves
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($reserveLineup as $member)
                            <a href="{{ route('player.profile', $member->user_id) }}" class="pro-card p-3.5 flex items-center justify-between gap-4 border border-slate-800 hover:border-sky-500/40 group transition-all">
                                
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 overflow-hidden">
                                        @if($member->user->avatar_url)
                                            <img src="{{ asset('storage/'.$member->user->avatar_url) }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @elseif($member->user->google_avatar_url)
                                            <img src="{{ $member->user->google_avatar_url }}" alt="{{ $member->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sky-400 font-bold text-xs uppercase">{{ substr($member->user->name, 0, 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-slate-200 group-hover:text-sky-300 text-sm tracking-tight truncate transition-colors">
                                            {{ $member->user->name }}
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded badge-reserve inline-flex items-center gap-1">
                                                🛡️ RESERVE
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium capitalize">
                                                {{ ucwords(str_replace('_', ' ', $member->role)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-medium group-hover:bg-sky-600 group-hover:text-white transition-all shrink-0">
                                    View
                                </span>
                            </a>
                        @empty
                            <div class="pro-card p-6 text-center text-slate-400 col-span-2 text-xs">
                                No reserve players currently listed for this team.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- RIGHT COLUMN: TOURNAMENTS & CAMPAIGNS (SPAN 5) -->
            <section class="lg:col-span-5 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-6 rounded-md bg-amber-500 block"></span>
                        <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                            Tournaments
                        </h2>
                    </div>
                    <span class="px-3 py-1 rounded-full badge-captain text-xs font-semibold">
                        {{ count($tournaments) }} Campaigns
                    </span>
                </div>

                <div class="max-h-[640px] overflow-y-auto overscroll-contain px-2 py-3 -mx-2 -my-3 space-y-4" style="scrollbar-gutter: stable;">
                    @forelse($tournaments as $tournament)
                        <details class="group pro-card p-5 border border-slate-800/80" @if($loop->first) open @endif>
                            <summary class="list-none cursor-pointer flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="font-bold text-white text-base tracking-tight mb-1 truncate">
                                        {{ $tournament->name }}
                                    </h3>
                                    <p class="text-amber-400 text-xs font-semibold flex items-center gap-1.5">
                                        <span>🏆</span>
                                        <span>{{ $tournament->rank }}</span>
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-1 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </summary>

                            <div class="space-y-4 mt-4">

                            <!-- Tournament Stat Matrix -->
                            <div class="grid grid-cols-4 gap-2 text-center text-xs bg-slate-900/90 border border-slate-800 p-2.5 rounded-xl">
                                <div>
                                    <span class="text-slate-400 text-[11px] block">Played</span>
                                    <span class="text-white font-bold text-sm">{{ $tournament->matches_played }}</span>
                                </div>
                                <div>
                                    <span class="text-emerald-400 text-[11px] block">Won</span>
                                    <span class="text-emerald-400 font-bold text-sm">{{ $tournament->matches_won }}</span>
                                </div>
                                <div>
                                    <span class="text-red-400 text-[11px] block">Lost</span>
                                    <span class="text-red-400 font-bold text-sm">{{ $tournament->matches_lost }}</span>
                                </div>
                                <div>
                                    <span class="text-amber-400 text-[11px] block">Points</span>
                                    <span class="text-amber-400 font-bold text-sm">{{ $tournament->points }}</span>
                                </div>
                            </div>

                            <!-- Match Campaigns Breakdown -->
                            @if(!empty($tournament->matches) && $tournament->matches->isNotEmpty())
                                <div class="space-y-3 pt-3 border-t border-slate-800">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Match History</span>
                                    
                                    <div class="space-y-2.5">
                                        @foreach($tournament->matches as $match)
                                            @php
                                                $matchWon = $match->our_score > $match->opponent_score;
                                                $isBr = $match->isBattleRoyale();
                                                if ($isBr) {
                                                    $matchWon = $match->is_winner || $match->placement === 1;
                                                    $matchResultText = $matchWon ? 'WWCD / Winner' : ($match->placement ? "#{$match->placement} Place" : 'Completed');
                                                    $matchResultBadge = $matchWon ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' : 'bg-slate-800 text-slate-300 border-slate-700';
                                                    $scoreText = ($match->total_points ?? 0) . ' pts';
                                                } else {
                                                    $matchWon = $match->our_score > $match->opponent_score;
                                                    $matchLost = $match->our_score < $match->opponent_score;
                                                    $matchResultText = $matchWon ? 'Victory' : ($matchLost ? 'Defeat' : 'Draw');
                                                    $matchResultBadge = $matchWon ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' : ($matchLost ? 'bg-red-500/10 text-red-300 border-red-500/20' : 'bg-slate-800 text-slate-300 border-slate-700');
                                                    $scoreText = "{$match->our_score} - {$match->opponent_score}";
                                                }
                                            @endphp
                                            <div class="bg-slate-900/60 border border-slate-800/80 rounded-xl p-3 space-y-2">
                                                
                                                <div class="flex items-center justify-between gap-2 flex-wrap text-xs">
                                                    <div class="flex items-center gap-2">
                                                        @if($match->opponent_logo)
                                                            <img src="/storage/{{ $match->opponent_logo }}" alt="{{ $match->opponent_name }}" class="w-6 h-6 object-contain rounded-md border border-slate-800 p-0.5 shrink-0 bg-slate-900">
                                                        @else
                                                            <div class="w-6 h-6 rounded-md border border-slate-800 flex items-center justify-center bg-slate-900 text-[9px] font-bold text-slate-400 shrink-0">
                                                                {{ $isBr ? 'BR' : 'VS' }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <span class="font-semibold text-white block">
                                                                {{ $isBr ? ($match->opponent_name ?: 'Lobby Round') : 'VS ' . $match->opponent_name }}
                                                            </span>
                                                            @if($match->stage)
                                                                <span class="text-[11px] text-slate-400">{{ $match->stage }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded border {{ $matchResultBadge }}">
                                                            {{ $matchResultText }}
                                                        </span>
                                                        <span class="text-xs font-bold text-white px-2 py-0.5 bg-slate-800 border border-slate-700 rounded-md">
                                                            {{ $scoreText }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Games In Match Series -->
                                                @if($match->series->isNotEmpty())
                                                    <div class="space-y-1.5 border-t border-slate-800/60 pt-2 text-xs">
                                                        @foreach($match->series->sortBy('game_number') as $game)
                                                            @php
                                                                $gameWon = $game->result === 'won';
                                                                $gameLost = $game->result === 'lost';
                                                                $gameColor = $gameWon ? 'text-emerald-400' : ($gameLost ? 'text-red-400' : 'text-slate-400');
                                                            @endphp
                                                            <div class="bg-slate-950/40 border border-slate-800/60 p-2 rounded-lg space-y-1.5">
                                                                <div class="flex items-center justify-between text-[11px] font-medium">
                                                                    <span class="text-slate-300">Game {{ $game->game_number }}</span>
                                                                    <span class="{{ $gameColor }} font-semibold capitalize">
                                                                        {{ $game->result }} ({{ $game->our_score }}-{{ $game->opponent_score }})
                                                                    </span>
                                                                </div>

                                                                @if($game->playerStats->isNotEmpty())
                                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 pt-1 border-t border-slate-800/40">
                                                                        @foreach($game->playerStats as $pStat)
                                                                            <div class="flex items-center justify-between bg-slate-900/50 border border-slate-800/50 px-2 py-1 rounded text-[11px]">
                                                                                <div class="flex items-center gap-1.5 truncate">
                                                                                    @if($pStat->hero)
                                                                                        @php
                                                                                            $teamHeroIcon = app(\App\Services\MlbbHeroService::class)->getHeroIcon($pStat->hero);
                                                                                        @endphp
                                                                                        @if($teamHeroIcon)
                                                                                            <img src="{{ $teamHeroIcon }}" alt="{{ $pStat->hero }}" title="{{ $pStat->hero }}" class="w-4 h-4 rounded-full border border-slate-700 object-cover shrink-0">
                                                                                        @endif
                                                                                    @endif
                                                                                    <span class="text-slate-200 font-medium truncate">
                                                                                        {{ $pStat->user->name ?? 'Unknown' }}
                                                                                    </span>
                                                                                    @if($pStat->is_mvp)
                                                                                        <span class="badge-captain px-1 py-0.2 rounded text-[9px] font-bold">MVP</span>
                                                                                    @endif
                                                                                </div>
                                                                                <span class="text-slate-400 text-xs font-mono ml-2 shrink-0">
                                                                                    {{ $pStat->kills }}/{{ $pStat->deaths }}/{{ $pStat->assists }}
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            </div>
                        </details>
                    @empty
                        <div class="pro-card p-6 text-center text-slate-400 text-sm">
                            No tournament campaigns registered for this team.
                        </div>
                    @endforelse
                </div>
            </section>

        </main>
        
        <!-- Footer -->
        <footer class="mt-16 text-center border-t border-slate-800/80 pt-8 text-slate-500 text-xs tracking-wider">
            &copy; {{ date('Y') }} IceCream Fried Esports &bull; Vidanta Champions Arena. All Rights Reserved.
        </footer>

    </div>

</body>
</html>
