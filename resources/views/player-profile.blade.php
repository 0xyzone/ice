<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $player->name }} — Athlete Profile</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JSZip Library for multi-select compression downloads -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
</head>
<body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-screen py-8 md:py-12 px-4 sm:px-6 lg:px-8 subtle-mesh-bg overflow-x-hidden">

    <div class="max-w-6xl mx-auto space-y-10">

        <!-- Top Navigation -->
        <nav class="flex items-center justify-between flex-wrap gap-4">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900/60 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white text-xs font-semibold tracking-wide transition-all group shadow-sm">
                <svg class="w-4 h-4 text-orange-400 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to Homepage</span>
            </a>

            <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Verified Athlete Profile</span>
            </div>
        </nav>

        <!-- =================================================================
             ATHLETE HERO DOSSIER
             ================================================================= -->
        <header class="pro-card p-6 md:p-10 border border-slate-800/80 shadow-xl relative overflow-hidden">
            
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-10">
                
                <!-- Avatar Frame -->
                <div class="relative shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl bg-slate-900 border-2 border-slate-800 p-1.5 flex items-center justify-center overflow-hidden shadow-xl">
                        @if($player->avatar_url)
                            <img src="{{ asset('storage/' . $player->avatar_url) }}" alt="{{ $player->name }}" class="w-full h-full object-cover rounded-xl">
                        @elseif($player->google_avatar_url)
                            <img src="{{ $player->google_avatar_url }}" alt="{{ $player->name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="text-orange-400 font-bold text-4xl uppercase select-none">
                                {{ strtoupper(substr($player->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Block -->
                <div class="flex-grow text-center md:text-left space-y-4">
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                        @if($player->username)
                            <span class="px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/25 text-orange-300 text-xs font-semibold">
                                @ {{ $player->username }}
                            </span>
                        @endif
                        @if($player->player?->gender)
                            <span class="px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300 text-xs font-medium capitalize">
                                {{ $player->player->gender }}
                            </span>
                        @endif
                        @if($player->player?->date_of_birth)
                            <span class="px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300 text-xs font-medium">
                                Age: {{ \Carbon\Carbon::parse($player->player->date_of_birth)->age }}
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">
                            {{ $player->name }}
                        </h1>
                        <p class="text-slate-400 text-sm sm:text-base mt-2 max-w-2xl font-normal leading-relaxed">
                            {{ $player->player?->bio ?? 'Active competitive esports athlete in the IceCream Fried roster. Specializing in mechanical execution, team coordination, and tournament synergy.' }}
                        </p>
                    </div>

                    <!-- Quick Stats Pill Bar -->
                    @if($totalPlayed > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-800/80 max-w-2xl">
                            <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl text-center md:text-left">
                                <span class="text-slate-400 text-[11px] font-medium uppercase tracking-wider block">Win Rate</span>
                                <span class="text-lg font-bold text-sky-400 mt-0.5 block">{{ $winRate }}%</span>
                            </div>
                            <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl text-center md:text-left">
                                <span class="text-slate-400 text-[11px] font-medium uppercase tracking-wider block">Matches</span>
                                <span class="text-lg font-bold text-white mt-0.5 block">{{ $totalPlayed }}</span>
                            </div>
                            <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl text-center md:text-left">
                                <span class="text-slate-400 text-[11px] font-medium uppercase tracking-wider block">Wins / Losses</span>
                                <span class="text-lg font-bold text-emerald-400 mt-0.5 block">{{ $totalWon }}W / {{ $totalLost }}L</span>
                            </div>
                            <div class="bg-slate-900/70 border border-slate-800/80 p-3 rounded-xl text-center md:text-left">
                                <span class="text-slate-400 text-[11px] font-medium uppercase tracking-wider block">KDA Ratio</span>
                                <span class="text-lg font-bold text-orange-400 mt-0.5 block">{{ number_format($kda, 2) }}</span>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </header>

        <!-- SOCIAL MEDIA CHANNELS -->
        @if($player->socials)
            <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                @foreach(['facebook', 'instagram', 'snapchat', 'discord', 'linkedin'] as $social)
                    @if($player->socials->$social)
                        @php
                            $socialUrl = $player->socials->$social;
                            $isDiscordUsername = false;
                            
                            if (!str_starts_with($socialUrl, 'http://') && !str_starts_with($socialUrl, 'https://')) {
                                if ($social === 'facebook') {
                                    $socialUrl = 'https://facebook.com/' . ltrim($socialUrl, '/');
                                } elseif ($social === 'instagram') {
                                    $socialUrl = 'https://instagram.com/' . ltrim($socialUrl, '/');
                                } elseif ($social === 'snapchat') {
                                    $socialUrl = 'https://snapchat.com/add/' . ltrim($socialUrl, '/');
                                } elseif ($social === 'linkedin') {
                                    $socialUrl = 'https://linkedin.com/in/' . ltrim($socialUrl, '/');
                                } elseif ($social === 'discord') {
                                    $isDiscordUsername = true;
                                }
                            }
                        @endphp

                        <a href="{{ $isDiscordUsername ? 'javascript:void(0)' : $socialUrl }}" 
                           @if($isDiscordUsername)
                             onclick="copyDiscordToClipboard('{{ e($player->socials->discord) }}', this, event)"
                           @else
                             target="_blank" 
                           @endif
                           class="pro-card p-3.5 flex items-center gap-3 border border-slate-800 hover:border-slate-700 transition-all group">
                            
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-300 group-hover:text-white group-hover:bg-slate-700 transition-colors shrink-0">
                                @if($social === 'facebook')
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                                @elseif($social === 'instagram')
                                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/></svg>
                                @elseif($social === 'snapchat')
                                    <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c-3.87 0-7 3.13-7 7 0 1.25.33 2.41.9 3.43-.88.62-1.9 1.4-1.9 2.57 0 .52.33 1.05.9 1.48C3.33 17.59 2 19.34 2 21c0 .55.45 1 1 1h18c.55 0 1-.45 1-1 0-1.66-1.33-3.41-1.9-4.52.57-.43.9-.96.9-1.48 0-1.17-1.02-1.95-1.9-2.57.57-1.02.9-2.18.9-3.43 0-3.87-3.13-7-7-7z"/></svg>
                                @elseif($social === 'discord')
                                    <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.094 13.094 0 01-1.873-.894.077.077 0 01-.008-.128c.126-.093.252-.19.372-.287a.075.075 0 01.077-.011c3.92 1.793 8.18 1.793 12.061 0a.073.073 0 01.078.009c.12.099.246.195.373.289a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.894.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z"/></svg>
                                @elseif($social === 'linkedin')
                                    <svg class="w-4 h-4 text-sky-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                @endif
                            </div>

                            <span class="text-xs font-semibold text-slate-200 capitalize truncate">
                                {{ $social }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </section>
        @endif

        <!-- =================================================================
             MAIN CONTENT GRID: METRICS & CAMPAIGNS
             ================================================================= -->
        <main class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-10">
            
            <!-- LEFT COLUMN: COMBAT METRICS & TOURNAMENTS (SPAN 7) -->
            <section class="lg:col-span-7 space-y-8">
                
                @if($totalPlayed > 0)
                    <!-- Metrics Summary -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <div class="flex items-center gap-3">
                                <span class="w-2.5 h-6 rounded-md bg-orange-500 block"></span>
                                <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                                    Combat Specification &amp; Metrics
                                </h2>
                            </div>
                            <span class="text-xs font-medium text-slate-400">
                                Cumulative Totals
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="pro-card p-4 border border-slate-800/80">
                                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">KDA RATIO</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-white">{{ number_format($kda, 2) }}</span>
                                    <span class="text-xs text-orange-400 font-semibold uppercase">Ratio</span>
                                </div>
                                <span class="text-xs text-slate-400 mt-2 block font-mono">
                                    {{ $totalKills }} K / {{ $totalDeaths }} D / {{ $totalAssists }} A
                                </span>
                            </div>

                            <div class="pro-card p-4 border border-slate-800/80">
                                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">Battle Win Rate</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-white">{{ $winRate }}%</span>
                                    <span class="text-xs text-sky-400 font-semibold uppercase">Rate</span>
                                </div>
                                <span class="text-xs text-slate-400 mt-2 block">
                                    Outcomes: {{ $totalWon }}W &bull; {{ $totalLost }}L
                                </span>
                            </div>

                            <div class="pro-card p-4 border border-slate-800/80">
                                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider block mb-1">MVP Awards</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-white">{{ $totalMvps }}</span>
                                    <span class="text-xs text-amber-400 font-semibold uppercase">Awards</span>
                                </div>
                                <span class="text-xs text-amber-300 mt-2 flex items-center gap-1">
                                    <span>★</span> Most Valuable Player
                                </span>
                            </div>
                        </div>

                        <!-- Tournament Breakdown List -->
                        <div class="pro-card p-5 border border-slate-800/80 space-y-4">
                            <span class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-2 block">
                                Tournament Performance Records
                            </span>

                            <div class="space-y-4">
                                @foreach($tournamentStats as $stat)
                                    @php
                                        $tGame = $stat->tournament->game;
                                        $isBr = $stat->tournament->isBattleRoyale();
                                        $tKda = $stat->matches_played > 0 ? round(($stat->kills + $stat->assists) / max(1, $stat->deaths), 2) : 0.00;
                                        $tWinRate = $stat->matches_played > 0 ? round(($stat->matches_won / $stat->matches_played) * 100, 1) : 0.0;
                                    @endphp
                                    <div class="p-4 bg-slate-900/70 border border-slate-800/80 rounded-xl space-y-3">
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-800/60 pb-3">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                                        {{ $tGame?->getShortName() ?? 'GAME' }}
                                                    </span>
                                                    <h4 class="font-bold text-sm text-white">
                                                        {{ $stat->tournament->name }}
                                                    </h4>
                                                </div>
                                                <p class="text-xs text-slate-400">
                                                    @if($isBr)
                                                        {{ $stat->matches_played }} Rounds &bull; {{ $stat->matches_won }} Wins (WWCD/Booyah) &bull; {{ $stat->total_points ?? 0 }} Total Pts
                                                    @else
                                                        {{ $stat->matches_played }} Matches &bull; {{ $stat->matches_won }} Won &bull; {{ $stat->matches_lost }} Lost
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                                @if($isBr)
                                                    <span class="bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700 text-slate-300 font-mono">
                                                        Kills: {{ $stat->kills }}
                                                    </span>
                                                    <span class="bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700 text-amber-400 font-mono">
                                                        Dmg: {{ number_format($stat->damage ?? 0) }}
                                                    </span>
                                                    <span class="bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700 text-emerald-400 font-semibold">
                                                        {{ $stat->matches_won }} WWCD/Booyah
                                                    </span>
                                                @else
                                                    <span class="bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700 text-slate-300 font-mono">
                                                        KDA: {{ $stat->kills }}/{{ $stat->deaths }}/{{ $stat->assists }} ({{ number_format($tKda, 2) }})
                                                    </span>
                                                    <span class="bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700 text-sky-400 font-semibold">
                                                        {{ $tWinRate }}% Win
                                                    </span>
                                                @endif
                                                @if($stat->mvps > 0)
                                                    <span class="badge-captain px-2 py-0.5 rounded-md text-xs font-semibold">
                                                        {{ $stat->mvps }} MVPs
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Matches Inside Tournament -->
                                        <div class="space-y-2 pl-2 border-l border-slate-800">
                                            @foreach($stat->matches as $mInfo)
                                                @php
                                                    $match = $mInfo->match;
                                                    if ($isBr) {
                                                        $isWon = $match->is_winner || $match->placement === 1;
                                                        $outcomeText = $isWon ? 'WWCD / Winner' : ($match->placement ? "#{$match->placement} Place" : 'Completed');
                                                        $outcomeBadge = $isWon ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' : 'bg-slate-800 text-slate-300 border-slate-700';
                                                        $scoreDisplay = ($match->total_points ?? 0) . ' pts';
                                                    } else {
                                                        $isWon = $match->our_score > $match->opponent_score;
                                                        $isLost = $match->our_score < $match->opponent_score;
                                                        $outcomeText = $isWon ? 'Won' : ($isLost ? 'Lost' : 'Draw');
                                                        $outcomeBadge = $isWon ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' : ($isLost ? 'bg-red-500/10 text-red-300 border-red-500/20' : 'bg-slate-800 text-slate-300 border-slate-700');
                                                        $scoreDisplay = "{$match->our_score}-{$match->opponent_score}";
                                                    }
                                                @endphp
                                                <div class="bg-slate-950/40 border border-slate-800/60 rounded-lg p-3 space-y-2">
                                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                                                        <div class="flex items-center gap-2">
                                                            @if($match->opponent_logo)
                                                                <img src="{{ asset('storage/' . $match->opponent_logo) }}" alt="{{ $match->opponent_name }}" class="w-5 h-5 object-contain rounded bg-slate-900 border border-slate-800">
                                                            @else
                                                                <div class="w-5 h-5 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-[9px] font-bold text-slate-400">
                                                                    {{ $isBr ? 'BR' : 'VS' }}
                                                                </div>
                                                            @endif
                                                            <span class="font-semibold text-white">
                                                                {{ $isBr ? ($match->opponent_name ?: 'Lobby Round') : 'vs ' . $match->opponent_name }}
                                                            </span>
                                                            @if($match->stage)
                                                                <span class="text-slate-400 text-[11px]">({{ $match->stage }})</span>
                                                            @endif
                                                        </div>

                                                        <div class="flex items-center gap-2">
                                                            <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}</span>
                                                            <span class="px-2 py-0.5 border rounded text-[11px] font-semibold {{ $outcomeBadge }}">
                                                                {{ $outcomeText }} ({{ $scoreDisplay }})
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Maps in Match -->
                                                    <div class="space-y-1.5 pt-1 border-t border-slate-800/40 text-xs">
                                                        @foreach($mInfo->series as $sInfo)
                                                            @php
                                                                $map = $sInfo->map;
                                                                $pStat = $sInfo->player_stat;
                                                                $mapWon = $map->result === 'won' || ($isBr && $map->placement === 1);
                                                                $mapColor = $mapWon ? 'text-emerald-400' : 'text-slate-400';
                                                            @endphp
                                                            <div class="py-1.5 px-2 rounded bg-slate-900/40 space-y-1">
                                                                <div class="flex items-center justify-between flex-wrap gap-2">
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="text-slate-400 font-medium">
                                                                            {{ $isBr ? 'R' . $map->game_number . ($map->map_name ? ' (' . $map->map_name . ')' : '') : 'G' . $map->game_number }}:
                                                                        </span>
                                                                        <span class="{{ $mapColor }} font-semibold capitalize">
                                                                            @if($isBr)
                                                                                {{ $map->placement ? '#' . $map->placement . ' Place' : 'Completed' }}
                                                                            @else
                                                                                {{ $map->result }}
                                                                            @endif
                                                                        </span>
                                                                        @if($pStat->hero)
                                                                            <span class="text-slate-300 font-medium">({{ $pStat->hero }})</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="flex items-center gap-2 text-xs">
                                                                        @if($isBr)
                                                                            <span class="text-slate-300 font-mono font-semibold">{{ $pStat->kills }} Kills</span>
                                                                            @if($pStat->damage_dealt)
                                                                                <span class="text-slate-400 font-mono text-[11px]">{{ number_format($pStat->damage_dealt) }} Dmg</span>
                                                                            @endif
                                                                            @if($pStat->formatted_survival_time)
                                                                                <span class="text-slate-400 font-mono text-[11px]">⏱ {{ $pStat->formatted_survival_time }}</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="text-slate-400 font-mono">{{ $pStat->kills }}/{{ $pStat->deaths }}/{{ $pStat->assists }}</span>
                                                                        @endif
                                                                        @if($pStat->is_mvp)
                                                                            <span class="badge-captain px-1.5 py-0.2 rounded text-[9px] font-bold">MVP</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                @if($pStat->total_gold || $pStat->turret_damage || $pStat->knockdowns || $pStat->revives || $pStat->headshots || (!empty($pStat->extra_stats) && is_array($pStat->extra_stats)))
                                                                    <div class="flex items-center gap-2 flex-wrap text-[11px] text-slate-400 pt-0.5">
                                                                        @if($pStat->total_gold)
                                                                            <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                Gold: <strong class="text-amber-300">{{ number_format($pStat->total_gold) }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        @if($pStat->turret_damage)
                                                                            <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                Push Dmg: <strong class="text-slate-200">{{ number_format($pStat->turret_damage) }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        @if($pStat->knockdowns)
                                                                            <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                Knocks: <strong class="text-slate-200">{{ $pStat->knockdowns }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        @if($pStat->revives)
                                                                            <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                Revives: <strong class="text-slate-200">{{ $pStat->revives }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        @if($pStat->headshots)
                                                                            <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                Headshots: <strong class="text-red-300">{{ $pStat->headshots }}</strong>
                                                                            </span>
                                                                        @endif
                                                                        @if(!empty($pStat->extra_stats) && is_array($pStat->extra_stats))
                                                                            @foreach($pStat->extra_stats as $statKey => $statVal)
                                                                                <span class="bg-slate-950/60 px-1.5 py-0.5 rounded border border-slate-800">
                                                                                    <span class="text-slate-400">{{ $statKey }}:</span> <strong class="text-slate-200">{{ $statVal }}</strong>
                                                                                </span>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Active Game Accounts -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-6 rounded-md bg-sky-500 block"></span>
                            <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                                Game Accounts &amp; Credentials
                            </h2>
                        </div>
                        <span class="text-xs font-medium text-slate-400">
                            {{ $player->gameInfos->count() }} Profiles
                        </span>
                    </div>

                    @forelse($player->gameInfos as $gameInfo)
                        <div class="pro-card p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border border-slate-800/80">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center p-2 shrink-0">
                                    <span class="text-sky-400 font-extrabold text-sm tracking-wider uppercase">
                                        {{ $gameInfo->game?->getShortName() ?? 'GAME' }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-bold text-white text-base">
                                            {{ $gameInfo->gameLabel }}
                                        </h3>
                                        @if($gameInfo->roleLabel)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                                {{ $gameInfo->roleLabel }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2 text-xs">
                                        <span class="text-slate-300 font-medium">IGN: <strong class="text-white">{{ $gameInfo->in_game_username ?? 'Unspecified' }}</strong></span>
                                        <span class="text-slate-400">&bull;</span>
                                        <span class="text-slate-400 font-mono">ID: #{{ $gameInfo->in_game_id ?? 'N/A' }}</span>
                                        @if($gameInfo->server_id)
                                            <span class="text-slate-400">&bull;</span>
                                            <span class="text-slate-400 font-mono">Zone: ({{ $gameInfo->server_id }})</span>
                                        @endif
                                        @if($gameInfo->device_type)
                                            <span class="text-slate-400">&bull;</span>
                                            <span class="text-slate-400">{{ $gameInfo->device_type }}</span>
                                        @endif
                                    </div>

                                    @if(!empty($gameInfo->main_heroes) && is_array($gameInfo->main_heroes))
                                        <div class="flex items-center gap-1.5 flex-wrap pt-1 text-[11px]">
                                            <span class="text-slate-400">Signature:</span>
                                            @foreach($gameInfo->main_heroes as $heroName)
                                                <span class="px-1.5 py-0.5 rounded bg-slate-900 border border-slate-800 text-slate-300">
                                                    {{ $heroName }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                @if($gameInfo->status)
                                    <span class="px-2.5 py-1 rounded-full badge-main text-xs font-semibold">Active Roster</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 text-xs font-medium">Standby</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="pro-card p-6 text-center text-slate-400 text-sm">
                            No active game accounts registered to this player.
                        </div>
                    @endforelse
                </div>

            </section>

            <!-- RIGHT COLUMN: TEAM ROSTER CAMPAIGNS (SPAN 5) -->
            <section class="lg:col-span-5 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-6 rounded-md bg-amber-500 block"></span>
                        <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                            Team Affiliations &amp; Roster History
                        </h2>
                    </div>
                    <span class="text-xs font-medium text-slate-400">
                        {{ $player->teamMemberships->count() }} Teams
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($player->teamMemberships as $membership)
                        <a href="{{ route('team.profile', $membership->team) }}" class="pro-card p-5 block border border-slate-800 hover:border-slate-700 transition-all group">
                            
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center p-2 shrink-0">
                                    @if($membership->team->logo_image)
                                        <img src="{{ asset('storage/' . $membership->team->logo_image) }}" alt="{{ $membership->team->name }}" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-amber-400 font-bold text-sm">T</span>
                                    @endif
                                </div>
                                
                                <div>
                                    <h3 class="font-bold text-white text-base group-hover:text-orange-300 transition-colors">
                                        {{ $membership->team->name }}
                                    </h3>
                                    <p class="text-slate-400 text-xs font-medium mt-0.5">
                                        {{ $membership->team->gameLabel }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 text-xs border-t border-slate-800 pt-3">
                                <div class="space-y-1">
                                    <span class="text-slate-400 text-[11px] block">Role &amp; Lineup</span>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($membership->is_main_roster)
                                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded badge-main inline-flex items-center gap-1">
                                                ⚡ MAIN ROSTER
                                            </span>
                                        @else
                                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded badge-reserve inline-flex items-center gap-1">
                                                🛡️ RESERVE
                                            </span>
                                        @endif
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded bg-slate-800 text-slate-300 capitalize">
                                            {{ ucwords(str_replace('_', ' ', $membership->role)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-right space-y-1">
                                    <span class="text-slate-400 text-[11px] block">Campaign Duration</span>
                                    <span class="text-slate-200 text-xs font-semibold block">
                                        {{ \Carbon\Carbon::parse($membership->joined_at)->format('M Y') }} 
                                        &bull; 
                                        @if($membership->status)
                                            <span class="text-emerald-400">Present</span>
                                        @else
                                            {{ $membership->left_at ? \Carbon\Carbon::parse($membership->left_at)->format('M Y') : 'Past' }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                        </a>
                    @empty
                        <div class="pro-card p-6 text-center text-slate-400 text-sm">
                            No team affiliations recorded for this player.
                        </div>
                    @endforelse
                </div>
            </section>

        </main>
        
        <!-- PHOTOSHOOT GALLERY SHOWCASE -->
        @if($player->galleries->isNotEmpty())
            <section class="space-y-6 pt-6 border-t border-slate-800">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-6 rounded-md bg-orange-500 block"></span>
                        <div>
                            <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">
                                Official Athlete Photoshoot Gallery
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                High-resolution media captures, tournament stage portraits, and official roster press assets.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs">
                        <button id="btn-select-all" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium transition-colors">
                            Select All
                        </button>
                        <button id="btn-deselect-all" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium transition-colors hidden">
                            Deselect All
                        </button>
                        <button id="btn-download-selected" disabled class="px-3.5 py-1.5 rounded-lg bg-orange-500 hover:bg-orange-600 disabled:bg-slate-800 text-white disabled:text-slate-500 text-xs font-semibold cursor-not-allowed opacity-60 disabled:opacity-40 transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download Selected</span>
                        </button>
                    </div>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($player->galleries as $image)
                        <div class="gallery-item pro-card p-2.5 flex flex-col gap-2 relative group overflow-hidden border border-slate-800 hover:border-orange-500/40 transition-all">
                            
                            <!-- Selection Checkbox Overlay -->
                            <div class="absolute top-4 left-4 z-20">
                                <input type="checkbox" id="gallery-chk-{{ $image->id }}" value="{{ asset('storage/' . $image->image_path) }}" data-filename="{{ basename($image->image_path) }}" class="gallery-checkbox hidden">
                                <label for="gallery-chk-{{ $image->id }}" class="gallery-label flex items-center justify-center w-6 h-6 rounded-md border border-slate-700 bg-slate-900/90 cursor-pointer hover:border-orange-400 transition-all">
                                    <svg class="w-3.5 h-3.5 text-orange-400 opacity-0 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </label>
                            </div>

                            <!-- Image Card -->
                            <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden bg-slate-950/60 flex items-center justify-center">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $player->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 pointer-events-none">
                                    <button class="btn-gallery-preview p-2.5 bg-orange-500 text-white rounded-full pointer-events-auto shadow-lg hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between px-1 text-[11px] text-slate-400">
                                <span class="truncate">{{ $image->caption ?? 'Official Roster' }}</span>
                                <a href="{{ asset('storage/' . $image->image_path) }}" download class="hover:text-orange-400 transition-colors" title="Download">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Lightbox Modal -->
            <div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-slate-950/95 backdrop-blur-md hidden items-center justify-center p-4">
                <button id="lightbox-close" class="absolute top-6 right-6 p-2.5 text-slate-400 hover:text-white bg-slate-900 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <img id="lightbox-image" src="" alt="Enlarged view" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
            </div>
        @endif

        <!-- Footer -->
        <footer class="mt-16 text-center border-t border-slate-800/80 pt-8 text-slate-500 text-xs tracking-wider">
            &copy; {{ date('Y') }} IceCream Fried Esports &bull; Vidanta Champions Arena. All Rights Reserved.
        </footer>

    </div>

    <!-- Scripts for Discord copy, Gallery, and Lightbox -->
    <script>
        function copyDiscordToClipboard(username, element, event) {
            event.preventDefault();
            navigator.clipboard.writeText(username).then(() => {
                const originalText = element.innerText;
                element.innerText = 'Copied!';
                setTimeout(() => { element.innerText = originalText; }, 2000);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.gallery-checkbox');
            const selectAllBtn = document.getElementById('btn-select-all');
            const deselectAllBtn = document.getElementById('btn-deselect-all');
            const downloadBtn = document.getElementById('btn-download-selected');
            const lightbox = document.getElementById('gallery-lightbox');
            const lightboxImg = document.getElementById('lightbox-image');
            const lightboxClose = document.getElementById('lightbox-close');

            function updateSelectionUI() {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                if (downloadBtn) {
                    downloadBtn.disabled = selected.length === 0;
                    downloadBtn.innerText = `Download Selected (${selected.length})`;
                    downloadBtn.style.opacity = selected.length > 0 ? '1' : '0.5';
                    downloadBtn.style.cursor = selected.length > 0 ? 'pointer' : 'not-allowed';
                }
                if (deselectAllBtn) {
                    deselectAllBtn.classList.toggle('hidden', selected.length === 0);
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    const tick = cb.nextElementSibling.querySelector('svg');
                    if (tick) tick.style.opacity = cb.checked ? '1' : '0';
                    updateSelectionUI();
                });
            });

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', () => {
                    checkboxes.forEach(cb => {
                        cb.checked = true;
                        const tick = cb.nextElementSibling.querySelector('svg');
                        if (tick) tick.style.opacity = '1';
                    });
                    updateSelectionUI();
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', () => {
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                        const tick = cb.nextElementSibling.querySelector('svg');
                        if (tick) tick.style.opacity = '0';
                    });
                    updateSelectionUI();
                });
            }

            // Preview clicks
            document.querySelectorAll('.btn-gallery-preview').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const img = btn.closest('.gallery-item').querySelector('img');
                    if (img && lightbox && lightboxImg) {
                        lightboxImg.src = img.src;
                        lightbox.classList.remove('hidden');
                        lightbox.classList.add('flex');
                    }
                });
            });

            if (lightboxClose) {
                lightboxClose.addEventListener('click', () => {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                });
            }

            if (lightbox) {
                lightbox.addEventListener('click', (e) => {
                    if (e.target === lightbox) {
                        lightbox.classList.add('hidden');
                        lightbox.classList.remove('flex');
                    }
                });
            }
        });
    </script>

</body>
</html>
