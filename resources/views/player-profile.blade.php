<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $player->name }} // Esports Player Profile</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800;900&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets (compiled with Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #07060a;
            /* Cyberpunk high-energy grid overlay & colorful lighting dots */
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(239, 68, 68, 0.18) 0%, transparent 35%),
                radial-gradient(circle at 100% 0%, rgba(139, 92, 246, 0.15) 0%, transparent 35%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.08) 0%, transparent 40%),
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 30px 30px, 30px 30px;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* Playful Cyberpunk Corner Cuts with custom borders */
        .cyber-card {
            background: linear-gradient(135deg, rgba(20, 16, 28, 0.85) 0%, rgba(10, 8, 15, 0.95) 100%);
            border: 2px solid rgba(239, 68, 68, 0.25);
            position: relative;
            clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .cyber-card:hover {
            border-color: rgba(239, 68, 68, 0.8);
            box-shadow: 
                0 0 20px rgba(239, 68, 68, 0.2),
                0 0 4px rgba(139, 92, 246, 0.3);
            transform: translateY(-4px) scale(1.01);
        }

        /* Corner brackets indicator */
        .cyber-card::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 10px;
            height: 10px;
            border-top: 2px solid #ef4444;
            border-left: 2px solid #ef4444;
        }

        .cyber-card::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            border-bottom: 2px solid #a78bfa;
            border-right: 2px solid #a78bfa;
        }

        /* Hazard stripe accent */
        .hazard-stripes {
            background: repeating-linear-gradient(
                45deg,
                #ef4444,
                #ef4444 8px,
                #000000 8px,
                #000000 16px
            );
        }

        /* Ambient scanline glow */
        .scanlines::before {
            content: " ";
            display: block;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.2) 50%);
            z-index: 2;
            background-size: 100% 3px;
            pointer-events: none;
        }

        /* Playful button style */
        .playful-badge {
            clip-path: polygon(0 0, 90% 0, 100% 100%, 10% 100%);
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen relative scanlines py-10 px-4 md:px-8">

    <!-- Glowing Background blobs for premium playfulness -->
    <div class="absolute w-80 h-80 bg-red-500/20 rounded-full blur-[100px] top-10 left-10 pointer-events-none animate-pulse"></div>
    <div class="absolute w-96 h-96 bg-violet-600/15 rounded-full blur-[120px] bottom-10 right-10 pointer-events-none animate-pulse" style="animation-duration: 6s;"></div>
    <div class="absolute w-72 h-72 bg-pink-500/10 rounded-full blur-[90px] top-[40%] right-[10%] pointer-events-none animate-pulse" style="animation-duration: 8s;"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        
        <!-- HEADER PROFILE HERO -->
        <header class="relative mb-8">
            <!-- Main Cyber Hero Card -->
            <div class="cyber-card p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-8 overflow-hidden">
                
                <!-- Corner branding hazard ribbon -->
                <div class="absolute -top-3 -right-3 w-16 h-16 bg-red-500 rotate-45 flex items-center justify-center shadow-[0_0_15px_rgba(239,68,68,0.5)]">
                    <span class="text-[8px] font-orbitron font-black text-black tracking-widest -mt-4 uppercase">LIVE</span>
                </div>
                
                <!-- Profile Avatar Holder with Gaming Shield Border -->
                <div class="relative group shrink-0">
                    <!-- Spinning glowing gradient ring -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-red-500 via-pink-500 to-violet-600 rounded-full blur-md opacity-80 group-hover:opacity-100 group-hover:animate-spin transition duration-1000" style="animation-duration: 8s;"></div>
                    <div class="relative w-36 h-36 md:w-40 md:h-40 rounded-full bg-[#120f1a] border-4 border-red-500/80 flex items-center justify-center overflow-hidden">
                        @if($player->gameInfos->first()?->profile_image)
                            <img src="{{ asset('storage/' . $player->gameInfos->first()->profile_image) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-transparent bg-clip-text bg-gradient-to-tr from-red-500 to-pink-500 font-orbitron font-black text-5xl tracking-widest select-none">
                                {{ strtoupper(substr($player->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Block -->
                <div class="flex-grow text-center md:text-left">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-3">
                        <span class="px-3 py-1 bg-red-500 text-black text-[10px] font-orbitron font-black uppercase tracking-widest rounded-sm transform -skew-x-12">
                            PRO PLAYER
                        </span>
                        @if($player->player?->gender)
                            <span class="px-3 py-1 bg-[#1d152b] border border-violet-500/30 text-violet-300 text-[10px] font-orbitron font-bold uppercase tracking-widest rounded-sm">
                                {{ strtoupper($player->player->gender) }}
                            </span>
                        @endif
                        @if($player->player?->date_of_birth)
                            <span class="px-3 py-1 bg-[#2b1522] border border-pink-500/30 text-pink-300 text-[10px] font-orbitron font-bold uppercase tracking-widest rounded-sm">
                                AGE: {{ \Carbon\Carbon::parse($player->player->date_of_birth)->age }}
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-orbitron font-black tracking-tight text-white uppercase drop-shadow-[0_2px_15px_rgba(239,68,68,0.4)]">
                        {{ $player->name }}
                    </h1>
                    
                    <p class="text-gray-300 font-outfit text-md md:text-lg mt-2 max-w-xl font-light">
                        {{ $player->player?->bio ?? 'Elite competitor dominating the leaderboards. Fueled by cold ice-creams, intense custom tactics, and zero-latency reflexes.' }}
                    </p>
                    
                    <!-- Quick stats summary block for playfulness -->
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 mt-4 pt-4 border-t border-white/5 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-red-400 font-bold font-orbitron text-md">WIN RATE:</span>
                            <span class="text-white font-black font-orbitron text-md">{{ $winRate }}%</span>
                        </div>
                        <div class="w-1.5 h-1.5 rounded-full bg-white/20 hidden md:block"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-violet-400 font-bold font-orbitron text-md">MATCHES:</span>
                            <span class="text-white font-black font-orbitron text-md">{{ $totalPlayed }}</span>
                        </div>
                        <div class="w-1.5 h-1.5 rounded-full bg-white/20 hidden md:block"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold font-orbitron text-md">WINS:</span>
                            <span class="text-white font-black font-orbitron text-md">{{ $totalWon }}</span>
                        </div>
                        <div class="w-1.5 h-1.5 rounded-full bg-white/20 hidden md:block"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-pink-400 font-bold font-orbitron text-md">LOSSES:</span>
                            <span class="text-white font-black font-orbitron text-md">{{ $totalLost }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- SOCIAL MEDIA LINKS -->
        @if($player->socials)
            <section class="mb-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    @foreach(['facebook', 'instagram', 'snapchat', 'discord', 'linkedin'] as $social)
                        @if($player->socials->$social)
                            <a href="{{ str_contains($player->socials->$social, 'http') ? $player->socials->$social : '#' }}" 
                               target="_blank" 
                               class="cyber-card p-4 flex flex-col items-center justify-center text-center group">
                                
                                <!-- Icon Selection with vibrant gradients -->
                                <div class="w-10 h-10 rounded-lg bg-[#181223] flex items-center justify-center border border-white/5 group-hover:border-red-500/50 group-hover:bg-red-500/10 transition-colors">
                                    @if($social === 'facebook')
                                        <svg class="w-6 h-6 text-blue-400 group-hover:text-red-400 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                                    @elseif($social === 'instagram')
                                        <svg class="w-6 h-6 text-pink-400 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/></svg>
                                    @elseif($social === 'snapchat')
                                        <svg class="w-6 h-6 text-yellow-300 group-hover:text-red-400 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c-3.87 0-7 3.13-7 7 0 1.25.33 2.41.9 3.43-.88.62-1.9 1.4-1.9 2.57 0 .52.33 1.05.9 1.48C3.33 17.59 2 19.34 2 21c0 .55.45 1 1 1h18c.55 0 1-.45 1-1 0-1.66-1.33-3.41-1.9-4.52.57-.43.9-.96.9-1.48 0-1.17-1.02-1.95-1.9-2.57.57-1.02.9-2.18.9-3.43 0-3.87-3.13-7-7-7z"/></svg>
                                    @elseif($social === 'discord')
                                        <svg class="w-6 h-6 text-indigo-400 group-hover:text-red-400 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.094 13.094 0 01-1.873-.894.077.077 0 01-.008-.128c.126-.093.252-.19.372-.287a.075.075 0 01.077-.011c3.92 1.793 8.18 1.793 12.061 0a.073.073 0 01.078.009c.12.099.246.195.373.289a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.894.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z"/></svg>
                                    @elseif($social === 'linkedin')
                                        <svg class="w-6 h-6 text-sky-400 group-hover:text-red-400 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    @endif
                                </div>

                                <span class="font-orbitron font-bold text-xs text-white uppercase mt-3 tracking-wider">
                                    {{ $social }}
                                </span>
                                
                                <span class="text-xs text-gray-400 font-outfit mt-1 max-w-[120px] truncate">
                                    {{ str_contains($player->socials->$social, 'http') ? explode('/', rtrim($player->socials->$social, '/'))[count(explode('/', rtrim($player->socials->$social, '/')))-1] : $player->socials->$social }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- MAIN LAYOUT BODY -->
        <main class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <!-- LEFT COLUMN: ACTIVE GAME PROFILES (SPAN 3) -->
            <section class="lg:col-span-3 flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <h2 class="text-2xl font-orbitron font-extrabold text-white uppercase tracking-wider flex items-center gap-3">
                        <span class="w-2.5 h-6 bg-red-500 shadow-[0_0_12px_#ef4444] block"></span>
                        Active Game Profiles
                    </h2>
                    <span class="text-xs font-orbitron text-violet-400 font-black px-2 py-0.5 bg-[#171125] border border-violet-500/20 rounded">
                        {{ $player->gameInfos->count() }} PROFILES
                    </span>
                </div>

                @forelse($player->gameInfos as $gameInfo)
                    <div class="cyber-card p-6 flex flex-col md:flex-row items-center md:items-start justify-between gap-6 overflow-hidden">
                        
                        <!-- Mini neon stripe on the side -->
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 shadow-[0_0_10px_#ef4444]"></div>
                        
                        <div class="flex flex-col md:flex-row items-center gap-5 text-center md:text-left w-full">
                            
                            <!-- Game Logo Frame with colorful retro tilt -->
                            <div class="relative w-16 h-16 shrink-0 bg-[#0f0b18] border-2 border-violet-500/30 flex items-center justify-center p-2 rounded-lg transform -rotate-3 hover:rotate-0 transition-transform">
                                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></div>
                                @if($gameInfo->game->game_logo)
                                    <img src="{{ asset('storage/' . $gameInfo->game->game_logo) }}" alt="{{ $gameInfo->game->name }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-red-500 font-orbitron font-black text-2xl">G</span>
                                @endif
                            </div>

                            <div class="flex-grow">
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5 mb-3">
                                    <span class="font-orbitron font-black text-xl text-white tracking-wide uppercase">
                                        {{ $gameInfo->game->name }}
                                    </span>
                                    
                                    @if($gameInfo->server_id)
                                        <span class="px-2.5 py-0.5 bg-red-950/60 border border-red-500/40 text-red-400 font-orbitron font-bold text-[10px] uppercase tracking-widest rounded-sm">
                                            {{ $gameInfo->server_id }}
                                        </span>
                                    @endif
                                    
                                    <!-- Playful genre badge -->
                                    <span class="px-2 py-0.5 bg-[#171125] border border-violet-500/20 text-violet-400 font-orbitron font-bold text-[9px] uppercase tracking-widest rounded-sm">
                                        COMPETITIVE
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm max-w-md">
                                    <div class="bg-[#120f1a] border border-white/5 p-2 rounded-md">
                                        <span class="text-gray-500 font-orbitron font-bold text-[9px] tracking-wider uppercase block mb-0.5">IN GAME NAME</span>
                                        <span class="text-white font-black font-orbitron tracking-wider text-sm">{{ $gameInfo->in_game_username ?? 'UNSPECIFIED' }}</span>
                                    </div>
                                    <div class="bg-[#120f1a] border border-white/5 p-2 rounded-md">
                                        <span class="text-gray-500 font-orbitron font-bold text-[9px] tracking-wider uppercase block mb-0.5">GAMER TAG ID</span>
                                        <span class="text-red-400 font-black font-orbitron tracking-wider text-sm">#{{ $gameInfo->in_game_id ?? 'UNSPECIFIED' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status badge -->
                        <div class="shrink-0">
                            @if($gameInfo->status)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-950/50 border border-green-500/40 text-green-400 text-[10px] font-orbitron font-black tracking-wider uppercase rounded-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-ping"></span>
                                    ACTIVE ROSTER
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-zinc-900/60 border border-zinc-700 text-zinc-500 text-[10px] font-orbitron font-black tracking-wider uppercase rounded-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-600"></span>
                                    STANDBY
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="cyber-card p-10 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        No active game accounts registered to this player.
                    </div>
                @endforelse
            </section>

            <!-- RIGHT COLUMN: ROSTER CAMPAIGNS (SPAN 2) -->
            <section class="lg:col-span-2 flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <h2 class="text-2xl font-orbitron font-extrabold text-white uppercase tracking-wider flex items-center gap-3">
                        <span class="w-2.5 h-6 bg-violet-500 shadow-[0_0_12px_#8b5cf6] block"></span>
                        Roster Campaigns
                    </h2>
                    <span class="text-xs font-orbitron text-red-400 font-black px-2 py-0.5 bg-[#1a0f12] border border-red-500/20 rounded">
                        {{ $player->teamMemberships->count() }} TEAMS
                    </span>
                </div>

                <div class="relative pl-6 border-l-2 border-red-500/20 flex flex-col gap-6">
                    @forelse($player->teamMemberships as $membership)
                        <!-- Timeline Node -->
                        <div class="relative">
                            
                            <!-- Node Bullet with custom outer pulse -->
                            <div class="absolute -left-[32px] top-1.5 w-4 h-4 rounded-full border-2 border-red-500 bg-[#07060a] shadow-[0_0_8px_#ef4444] z-10 flex items-center justify-center">
                                @if($membership->status)
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-ping"></span>
                                @endif
                            </div>

                            <!-- Cyber Timeline Card -->
                            <div class="cyber-card p-5 overflow-hidden">
                                
                                <div class="flex items-center gap-4 mb-3">
                                    <!-- Team Logo frame with bright pink accent -->
                                    <div class="w-12 h-12 bg-[#0d0a14] border-2 border-pink-500/30 rounded flex items-center justify-center p-1.5 transform rotate-2">
                                        @if($membership->team->logo_image)
                                            <img src="{{ asset('storage/' . $membership->team->logo_image) }}" alt="{{ $membership->team->name }}" class="w-full h-full object-contain">
                                        @else
                                            <span class="text-pink-500 font-orbitron font-black text-sm">T</span>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <h3 class="font-orbitron font-black text-white text-md tracking-wider uppercase">
                                            {{ $membership->team->name }}
                                        </h3>
                                        <p class="text-gray-400 font-outfit text-xs font-bold uppercase tracking-wider mt-0.5">
                                            {{ $membership->team->game->name }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-3 text-xs border-t border-white/5 pt-3 mt-3">
                                    <div>
                                        <span class="text-gray-500 font-orbitron font-bold text-[8px] tracking-wider uppercase block mb-0.5">TEAM ROLE</span>
                                        <span class="font-orbitron font-black text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-sm
                                            @if($membership->role === 'captain') bg-yellow-950/40 border border-yellow-500/40 text-yellow-400
                                            @elseif($membership->role === 'main_roster') bg-green-950/40 border border-green-500/40 text-green-400
                                            @elseif($membership->role === 'substitute') bg-blue-950/40 border border-blue-500/40 text-blue-400
                                            @else bg-red-950/40 border border-red-500/40 text-red-400
                                            @endif">
                                            {{ ucwords(str_replace('_', ' ', $membership->role)) }}
                                        </span>
                                    </div>

                                    <div class="text-right">
                                        <span class="text-gray-500 font-orbitron font-bold text-[8px] tracking-wider uppercase block mb-0.5">CAMPAIGN PERIOD</span>
                                        <span class="text-gray-200 text-xs font-orbitron font-bold">
                                            {{ \Carbon\Carbon::parse($membership->joined_at)->format('M Y') }} 
                                            - 
                                            @if($membership->status)
                                                <span class="text-red-400 font-black tracking-widest text-[9px] px-1.5 py-0.5 bg-red-950/40 border border-red-500/30 rounded-sm ml-1 uppercase">PRESENT</span>
                                            @else
                                                {{ $membership->left_at ? \Carbon\Carbon::parse($membership->left_at)->format('M Y') : 'PAST' }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cyber-card p-6 text-center text-gray-500">
                            No team roster timelines recorded for this user.
                        </div>
                    @endforelse
                </div>
            </section>

        </main>
        
        <!-- FOOTER BRANDING -->
        <footer class="mt-16 text-center border-t border-white/10 pt-8 text-gray-600 font-orbitron text-[10px] tracking-widest uppercase">
            &copy; {{ date('Y') }} Icecream Fried Esports // High-Latency Eradication Division
        </footer>

    </div>

</body>
</html>
