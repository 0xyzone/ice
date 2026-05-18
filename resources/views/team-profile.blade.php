<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->name }} // Esports Team Profile</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800;900&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #07060a;
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

        .cyber-card {
            background: linear-gradient(135deg, rgba(20, 16, 28, 0.85) 0%, rgba(10, 8, 15, 0.95) 100%);
            border: 2px solid rgba(139, 92, 246, 0.25);
            position: relative;
            clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .cyber-card:hover {
            border-color: rgba(139, 92, 246, 0.8);
            box-shadow: 
                0 0 20px rgba(139, 92, 246, 0.2),
                0 0 4px rgba(239, 68, 68, 0.3);
            transform: translateY(-4px) scale(1.01);
        }

        .cyber-card::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 10px;
            height: 10px;
            border-top: 2px solid #a78bfa;
            border-left: 2px solid #a78bfa;
        }

        .cyber-card::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            border-bottom: 2px solid #ef4444;
            border-right: 2px solid #ef4444;
        }

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
    </style>
</head>
<body class="text-gray-100 min-h-screen relative scanlines py-10 px-4 md:px-8">

    <!-- Glowing Background blobs -->
    <div class="absolute w-80 h-80 bg-violet-500/20 rounded-full blur-[100px] top-10 left-10 pointer-events-none animate-pulse"></div>
    <div class="absolute w-96 h-96 bg-red-600/15 rounded-full blur-[120px] bottom-10 right-10 pointer-events-none animate-pulse" style="animation-duration: 6s;"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        
        <!-- HEADER PROFILE HERO -->
        <header class="relative mb-8">
            <div class="cyber-card p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-8 overflow-hidden">
                
                <!-- Corner hazard ribbon -->
                <div class="absolute -top-3 -right-3 w-16 h-16 bg-violet-600 rotate-45 flex items-center justify-center shadow-[0_0_15px_rgba(139,92,246,0.5)]">
                    <span class="text-[8px] font-orbitron font-black text-black tracking-widest -mt-4 uppercase">TEAM</span>
                </div>
                
                <!-- Team Logo Holder -->
                <div class="relative shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-xl bg-[#0f0b18] border-2 border-violet-500/40 p-3 flex items-center justify-center shadow-[0_0_20px_rgba(139,92,246,0.15)] relative overflow-hidden">
                        @if($team->logo_image)
                            <img src="{{ asset('storage/' . $team->logo_image) }}" alt="{{ $team->name }}" class="w-full h-full object-contain relative z-10" />
                        @else
                            <div class="text-violet-500 font-orbitron font-black text-5xl relative z-10 uppercase">{{ substr($team->name, 0, 2) }}</div>
                        @endif
                    </div>
                </div>

                <!-- Team Info -->
                <div class="text-center md:text-left flex-grow">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                        <h1 class="text-3xl md:text-5xl font-orbitron font-black tracking-wider text-white uppercase">
                            {{ $team->name }}
                        </h1>
                        <span class="px-2.5 py-0.5 bg-violet-950/60 border border-violet-500/40 text-violet-400 font-orbitron font-bold text-xs uppercase tracking-widest rounded-sm">
                            {{ $team->short_name }}
                        </span>
                    </div>

                    <p class="text-violet-400 font-orbitron font-bold text-sm tracking-wider uppercase mb-4">
                        🎮 {{ $team->game->name }} Division
                    </p>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl text-xs">
                        <div class="bg-[#120f1a] border border-white/5 p-2 rounded">
                            <span class="text-gray-500 font-orbitron font-bold text-[8px] tracking-wider uppercase block">Gender Division</span>
                            <span class="text-white font-bold uppercase">{{ $team->gender ?? 'Any' }}</span>
                        </div>
                        <div class="bg-[#120f1a] border border-white/5 p-2 rounded col-span-2">
                            <span class="text-gray-500 font-orbitron font-bold text-[8px] tracking-wider uppercase block">Contact Email</span>
                            <span class="text-red-400 font-bold truncate block">{{ $team->email ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-[#120f1a] border border-white/5 p-2 rounded">
                            <span class="text-gray-500 font-orbitron font-bold text-[8px] tracking-wider uppercase block">Club Status</span>
                            @if($team->status)
                                <span class="text-green-400 font-bold uppercase flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> Active
                                </span>
                            @else
                                <span class="text-zinc-500 font-bold uppercase">Standby</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- STATS OVERVIEW SECTION -->
        <section class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="cyber-card p-4 text-center">
                <span class="text-gray-500 font-orbitron font-bold text-[9px] tracking-widest uppercase block mb-1">Matches Played</span>
                <span class="text-3xl font-orbitron font-black text-white">{{ $totalPlayed }}</span>
            </div>
            <div class="cyber-card p-4 text-center">
                <span class="text-green-400 font-orbitron font-bold text-[9px] tracking-widest uppercase block mb-1">Matches Won</span>
                <span class="text-3xl font-orbitron font-black text-green-400">{{ $totalWon }}</span>
            </div>
            <div class="cyber-card p-4 text-center">
                <span class="text-red-400 font-orbitron font-bold text-[9px] tracking-widest uppercase block mb-1">Matches Lost</span>
                <span class="text-3xl font-orbitron font-black text-red-400">{{ $totalLost }}</span>
            </div>
            <div class="cyber-card p-4 text-center">
                <span class="text-violet-400 font-orbitron font-bold text-[9px] tracking-widest uppercase block mb-1">Win Rate</span>
                <span class="text-3xl font-orbitron font-black text-violet-400">{{ $winRate }}%</span>
            </div>
            <div class="cyber-card p-4 text-center col-span-2 md:col-span-1">
                <span class="text-yellow-400 font-orbitron font-bold text-[9px] tracking-widest uppercase block mb-1">Total Points</span>
                <span class="text-3xl font-orbitron font-black text-yellow-400">{{ $totalPoints }}</span>
            </div>
        </section>

        <!-- MAIN LAYOUT BODY -->
        <main class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <!-- LEFT COLUMN: ACTIVE ROSTER PLAYERS (SPAN 3) -->
            <section class="lg:col-span-3 flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <h2 class="text-2xl font-orbitron font-extrabold text-white uppercase tracking-wider flex items-center gap-3">
                        <span class="w-2.5 h-6 bg-violet-500 shadow-[0_0_12px_#8b5cf6] block"></span>
                        Active Team Roster
                    </h2>
                    <span class="text-xs font-orbitron text-violet-400 font-black px-2 py-0.5 bg-[#171125] border border-violet-500/20 rounded">
                        {{ $team->members->count() }} PLAYERS
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($team->members as $member)
                        <a href="{{ route('player.profile', $member->user_id) }}" class="cyber-card p-4 flex items-center justify-between gap-4 overflow-hidden relative group/player">
                            <!-- Mini neon stripe on the side -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-violet-500 shadow-[0_0_10px_#8b5cf6] group-hover/player:bg-red-500 group-hover/player:shadow-[0_0_10px_#ef4444] transition-all"></div>

                            <div class="flex items-center gap-3">
                                <!-- Avatar -->
                                <div class="w-10 h-10 rounded-full bg-[#0a0712] border-2 border-violet-500/20 group-hover/player:border-red-500/40 flex items-center justify-center shrink-0 transition-all">
                                    <span class="text-violet-400 group-hover/player:text-red-400 font-orbitron font-black text-sm uppercase transition-colors">{{ substr($member->user->name, 0, 2) }}</span>
                                </div>

                                <div>
                                    <h3 class="font-orbitron font-bold text-white group-hover/player:text-red-400 text-sm tracking-wide transition-colors">
                                        {{ $member->user->name }}
                                    </h3>
                                    <span class="font-orbitron font-black text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-sm inline-block mt-1
                                        @if($member->role === 'captain') bg-yellow-950/40 border border-yellow-500/40 text-yellow-400
                                        @elseif($member->role === 'main_roster') bg-green-950/40 border border-green-500/40 text-green-400
                                        @elseif($member->role === 'substitute') bg-blue-950/40 border border-blue-500/40 text-blue-400
                                        @else bg-red-950/40 border border-red-500/40 text-red-400
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $member->role)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Link Button to Player Profile -->
                            <span class="px-3 py-1 bg-red-950/50 border border-red-500/40 text-red-400 font-orbitron font-bold text-[10px] uppercase tracking-widest rounded-sm group-hover/player:bg-red-500 group-hover/player:text-black transition-all shrink-0">
                                PROFILE
                            </span>
                        </a>
                    @empty
                        <div class="cyber-card p-10 text-center text-gray-500 col-span-2">
                            No active players registered inside this team roster.
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- RIGHT COLUMN: TOURNAMENTS & HISTORICAL CAMPAIGNS (SPAN 2) -->
            <section class="lg:col-span-2 flex flex-col gap-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <h2 class="text-2xl font-orbitron font-extrabold text-white uppercase tracking-wider flex items-center gap-3">
                        <span class="w-2.5 h-6 bg-red-500 shadow-[0_0_12px_#ef4444] block"></span>
                        Tournaments
                    </h2>
                    <span class="text-xs font-orbitron text-red-400 font-black px-2 py-0.5 bg-[#1a0f12] border border-red-500/20 rounded">
                        {{ $team->tournaments->count() }} EVENTS
                    </span>
                </div>

                <div class="relative pl-6 border-l-2 border-red-500/20 flex flex-col gap-6">
                    @forelse($team->tournaments as $tournament)
                        <div class="relative">
                            
                            <!-- Node Bullet -->
                            <div class="absolute -left-[32px] top-1.5 w-4 h-4 rounded-full border-2 border-red-500 bg-[#07060a] shadow-[0_0_8px_#ef4444] z-10"></div>

                            <!-- Timeline Card -->
                            <div class="cyber-card p-5">
                                <h3 class="font-orbitron font-black text-white text-md tracking-wider uppercase mb-1">
                                    {{ $tournament->name }}
                                </h3>
                                <p class="text-red-400 font-orbitron font-bold text-[10px] uppercase tracking-widest mb-3">
                                    🏆 {{ $tournament->pivot->rank ?? 'Participant' }}
                                </p>

                                <div class="grid grid-cols-4 gap-2 text-center text-[10px] bg-[#0a0812]/80 border border-white/5 p-2 rounded">
                                    <div>
                                        <span class="text-gray-500 uppercase block font-orbitron">Played</span>
                                        <span class="text-white font-bold font-orbitron">{{ $tournament->pivot->matches_played }}</span>
                                    </div>
                                    <div>
                                        <span class="text-green-400 uppercase block font-orbitron">Won</span>
                                        <span class="text-green-400 font-bold font-orbitron">{{ $tournament->pivot->matches_won }}</span>
                                    </div>
                                    <div>
                                        <span class="text-red-400 uppercase block font-orbitron">Lost</span>
                                        <span class="text-red-400 font-bold font-orbitron">{{ $tournament->pivot->matches_lost }}</span>
                                    </div>
                                    <div>
                                        <span class="text-yellow-400 uppercase block font-orbitron">Points</span>
                                        <span class="text-yellow-400 font-bold font-orbitron">{{ $tournament->pivot->points }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cyber-card p-6 text-center text-gray-500">
                            No tournament campaigns registered for this team.
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
