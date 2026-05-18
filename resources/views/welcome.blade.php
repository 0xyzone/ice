<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IceCream Fried Esports | Official Team Arena</title>

        <!-- Vite CSS & JS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Cyberpunk Esports Red Theme Styling -->
        <style>
            :root {
                --color-cyber-red: #ef4444;
                --color-cyber-crimson: #dc2626;
                --color-cyber-dark: #070101;
                --color-cyber-glow: rgba(239, 68, 68, 0.25);
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--color-cyber-dark);
            }

            .font-header {
                font-family: 'Orbitron', sans-serif;
            }

            .font-tech {
                font-family: 'Rajdhani', sans-serif;
            }

            /* Neon Cyber Red Grid */
            .cyber-grid {
                background-image: 
                    linear-gradient(rgba(239, 68, 68, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(239, 68, 68, 0.03) 1px, transparent 1px);
                background-size: 40px 40px;
                background-position: center;
            }

            /* Neon red glow */
            .neon-text-red {
                text-shadow: 0 0 10px rgba(239, 68, 68, 0.7), 0 0 20px rgba(239, 68, 68, 0.3);
            }

            .neon-border-red {
                box-shadow: 0 0 15px rgba(239, 68, 68, 0.3), inset 0 0 15px rgba(239, 68, 68, 0.1);
            }

            /* Tech Clip-path card wrappers */
            .clip-cyber {
                clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 20px 100%, 0 calc(100% - 20px));
            }

            .clip-cyber-sm {
                clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));
            }

            .clip-cyber-top-right {
                clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 30px, 100% 100%, 0 100%);
            }

            /* Ambient Glow Nodes */
            .glow-node-red {
                background: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.15) 0%, transparent 65%);
            }

            /* Floating Keyframes */
            @keyframes floatAnim {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-12px) rotate(0.5deg); }
            }

            .animate-float {
                animation: floatAnim 6s ease-in-out infinite;
            }

            /* Vertical Scanning Laser Beam */
            @keyframes scanLine {
                0% { top: 0%; opacity: 0.3; }
                50% { opacity: 0.7; }
                100% { top: 100%; opacity: 0.3; }
            }

            .cyber-scanner::after {
                content: '';
                position: absolute;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #ef4444, #f97316, #ef4444, transparent);
                box-shadow: 0 0 10px #ef4444;
                animation: scanLine 5s linear infinite;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #070101;
            }
            ::-webkit-scrollbar-thumb {
                background: #ef4444;
                border-radius: 3px;
            }
        </style>
    </head>
    <body class="text-gray-100 antialiased selection:bg-red-600 selection:text-white min-h-screen relative flex flex-col overflow-x-hidden">

        <!-- Background Ambient Glow Nodes -->
        <div class="fixed top-0 left-0 w-[600px] h-[600px] glow-node-red pointer-events-none -translate-x-1/4 -translate-y-1/4 z-0"></div>
        <div class="fixed bottom-0 right-0 w-[700px] h-[700px] glow-node-red pointer-events-none translate-x-1/4 translate-y-1/4 z-0"></div>
        
        <!-- Interactive Tech Cyber Grid Overlay -->
        <div class="absolute inset-0 cyber-grid z-0 pointer-events-none"></div>

        <!-- MAIN HEADER / NAVIGATION -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-black/60 border-b border-red-500/15 py-4 px-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                
                <!-- Brand Identity -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-600 to-orange-500 p-[1px] shadow-[0_0_15px_rgba(239,68,68,0.4)] transition-transform duration-300 group-hover:scale-105">
                        <div class="w-full h-full bg-[#070101] rounded-lg flex items-center justify-center p-1.5">
                            <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                    <span class="font-header font-black tracking-widest text-lg md:text-xl text-white group-hover:text-red-500 transition-colors">
                        ICECREAM <span class="text-red-500 neon-text-red">FRIED</span>
                    </span>
                </a>

                <!-- Nav Links -->
                <nav class="hidden md:flex items-center gap-8 font-tech text-lg font-semibold tracking-wider text-gray-300">
                    <a href="#squads" class="hover:text-red-400 transition-colors duration-300">ACTIVE SQUADS</a>
                    <a href="#heroes" class="hover:text-red-400 transition-colors duration-300">HERO ROSTER</a>
                    <a href="#stats" class="hover:text-red-400 transition-colors duration-300">TELEMETRY</a>
                    <a href="#tournaments" class="hover:text-red-400 transition-colors duration-300">CHAMPIONSHIPS</a>
                </nav>

                <!-- Command Portal CTA -->
                <a href="{{ url('/login') }}" class="clip-cyber-sm font-header font-extrabold text-xs tracking-widest bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-500 hover:to-orange-500 text-white px-5 py-2.5 shadow-[0_0_15px_rgba(239,68,68,0.3)] transition-all duration-300">
                    PORTAL LOGIN
                </a>

            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-grow">

            <!-- HERO SECTION: THE TEAM ARENA -->
            <section class="relative min-h-[90vh] flex items-center justify-center py-20 px-6 z-10 overflow-hidden">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left: Gamer Pitch -->
                    <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-950/40 border border-red-500/30 rounded-full font-tech text-red-400 tracking-wider text-sm">
                            <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444] animate-pulse"></span>
                            ACTIVE ESPORTS ROSTERS DEPLOYED
                        </div>

                        <h1 class="font-header font-black text-4xl md:text-6xl text-white uppercase tracking-tight leading-none">
                            DOMINATING <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 neon-text-red">THE CYBER FIELD</span>
                        </h1>

                        <p class="text-gray-300 text-base md:text-lg max-w-xl mx-auto lg:mx-0 leading-relaxed font-light">
                            Welcome to the official arena of <strong>IceCream Fried Esports</strong>. We are a recently formed, high-potential esports squad on the verge of rising to dominate tournaments and conquer the leaderboards. Built on passion, raw talent, and relentless grind, we are ready to make our mark.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                            <a href="#squads" class="clip-cyber w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white font-header font-extrabold tracking-wider transition-all duration-300 text-center shadow-[0_0_20px_rgba(239,68,68,0.4)]">
                                MEET THE ROSTER
                            </a>
                            <a href="{{ url('/login') }}" class="clip-cyber w-full sm:w-auto px-8 py-4 bg-[#0a0202] hover:bg-[#150404] text-gray-300 hover:text-white font-header font-extrabold tracking-wider border border-red-500/30 hover:border-red-500/60 transition-all duration-300 text-center">
                                ACCESS COMMAND
                            </a>
                        </div>
                    </div>

                    <!-- Right: Dynamic Cyber Hologram Art -->
                    <div class="lg:col-span-6 flex justify-center relative animate-float">
                        <div class="absolute -inset-1.5 rounded-full bg-gradient-to-r from-red-600 to-orange-500 opacity-20 blur-xl"></div>
                        <div class="relative w-full max-w-[450px] clip-cyber-top-right bg-gradient-to-br from-[#120404] to-[#050101] border border-red-500/20 p-4 shadow-[0_0_40px_rgba(239,68,68,0.15)]">
                            <div class="absolute inset-0 cyber-scanner overflow-hidden pointer-events-none"></div>
                            
                            <!-- Breathtaking Graphic Portrait -->
                            <img src="{{ asset('images/hero-mlbb.png') }}" alt="Pro Esports Champion Hologram" class="w-full h-auto object-cover rounded-tr-[30px] border border-red-500/10">
                            
                            <!-- Overlay Roster Spec Grid -->
                            <div class="absolute bottom-6 left-6 right-6 backdrop-blur-md bg-black/70 border border-red-500/20 p-4 clip-cyber-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-header font-black text-xs text-red-500 tracking-wider">ROSTER ACTIVE</span>
                                    <span class="font-tech text-orange-400 font-bold text-sm">WINRATE 78.4%</span>
                                </div>
                                <h3 class="font-header font-black text-white text-md">SQUAD INTEL // DEPLOYED</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- SQUADS & ACTIVE ROSTERS SECTION -->
            <section id="squads" class="py-20 px-6 bg-gradient-to-b from-black/80 to-[#070101]/95 relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Section Header -->
                    <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                        <span class="font-tech text-red-500 font-bold tracking-widest text-md uppercase block">OUR ELITE WARRIORS</span>
                        <h2 class="font-header font-black text-3xl md:text-5xl text-white uppercase tracking-tight">
                            ACTIVE SQUADS & <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 neon-text-red">ROSTERS</span>
                        </h2>
                        <div class="w-20 h-1 bg-red-600 mx-auto"></div>
                        <p class="text-gray-400 font-light text-md">
                            Meet the initial active lineups of IceCream Fried Esports. Each squad is locked in, daily honing their skills to make an impactful debut on the competitive scene.
                        </p>
                    </div>

                    <!-- Dynamic Teams Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($teams as $team)
                            <div class="clip-cyber bg-gradient-to-br from-[#120303] to-[#070101] border border-red-500/20 hover:border-red-500/50 p-6 shadow-[0_0_20px_rgba(239,68,68,0.05)] hover:shadow-[0_0_30px_rgba(239,68,68,0.15)] transition-all duration-300 flex flex-col justify-between">
                                
                                <div>
                                    <!-- Team Logo & Title -->
                                    <div class="flex items-center gap-4 pb-4 border-b border-red-500/10 mb-6">
                                        <div class="w-14 h-14 rounded-lg bg-red-950/40 border border-red-500/30 flex items-center justify-center p-1.5 shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                                            @if($team->logo_image)
                                                <img src="{{ asset('storage/' . $team->logo_image) }}" alt="{{ $team->name }}" class="max-w-full max-h-full object-contain">
                                            @else
                                                <img src="{{ asset('images/logo.png') }}" alt="{{ $team->name }}" class="max-w-full max-h-full object-contain">
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-header font-black text-lg text-white uppercase leading-tight tracking-wider">
                                                {{ $team->name }}
                                            </h3>
                                            <span class="font-tech text-orange-400 font-bold text-sm tracking-widest uppercase block mt-0.5">
                                                {{ $team->game->name ?? 'Mobile Legends' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Active Roster Roster Details -->
                                    <div class="space-y-4">
                                        <span class="font-tech text-gray-500 font-bold tracking-widest text-xs uppercase block">DECODED ACTIVE ROSTER</span>
                                        
                                        <div class="space-y-2.5">
                                            @forelse($team->members as $member)
                                                @if($member->user)
                                                    <div class="flex items-center justify-between bg-black/40 border border-red-500/5 px-3.5 py-2.5 clip-cyber-sm">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_6px_#ef4444]"></div>
                                                            <div>
                                                                <span class="font-header font-bold text-sm text-gray-200">
                                                                    {{ $member->user->name }}
                                                                </span>
                                                                <span class="font-tech text-gray-500 font-bold text-xs uppercase block">
                                                                    {{ $member->user->username ? '@' . $member->user->username : 'NO HANDLE' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <span class="px-2 py-0.5 bg-red-950/60 border border-red-500/20 rounded font-tech text-red-400 text-xs font-bold uppercase tracking-wider">
                                                                {{ $member->role }}
                                                            </span>
                                                            <a href="{{ route('player.profile.username', $member->user->username ?? $member->user->id) }}" class="font-tech text-xs text-orange-400 hover:text-red-400 underline block mt-0.5 font-bold transition-colors">
                                                                VIEW SPEC
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @empty
                                                <p class="text-gray-500 text-sm italic font-tech tracking-wider">No active roster members registered.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="pt-6 mt-6 border-t border-red-500/10">
                                    <a href="{{ route('team.profile.slug', $team->slug ?? $team->id) }}" class="clip-cyber-sm w-full py-3 bg-red-950/20 hover:bg-red-950/60 border border-red-500/30 hover:border-red-500/60 text-white font-header font-black tracking-widest text-xs transition-all duration-300 block text-center uppercase">
                                        VIEW DIVISION DOSSIER
                                    </a>
                                </div>

                            </div>
                        @empty
                            <!-- Seed Fallback Roster -->
                            <div class="col-span-full flex flex-col items-center justify-center bg-gradient-to-br from-[#120303] to-[#070101] border border-red-500/20 p-12 clip-cyber">
                                <span class="font-header font-black text-red-500 text-xl tracking-widest uppercase mb-2">TELEMETRY OFFLINE</span>
                                <p class="text-gray-400 text-md font-tech max-w-md text-center">
                                    Active system rosters are undergoing deep server synchronization. Check back shortly to view our deployed teams.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </section>

            <!-- ACTIVE ROSTER: PLAYERS SECTION -->
            <section id="roster" class="py-20 px-6 bg-[#070101] relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto">

                    <div class="text-center mb-14">
                        <span class="font-tech text-red-500 font-bold tracking-widest text-md uppercase block mb-2">DEPLOYED ATHLETES</span>
                        <h2 class="font-header font-black text-3xl md:text-5xl text-white uppercase tracking-tight leading-none">
                            MEET THE <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500">SQUAD</span>
                        </h2>
                        <div class="w-16 h-1 bg-red-600 mx-auto mt-4"></div>
                    </div>

                    @if($members->isEmpty())
                        <div class="text-center py-16 font-tech text-gray-600 uppercase tracking-widest">
                            <p>ROSTER LOADING... PLAYERS INCOMING</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($members as $member)
                                @php
                                    $user   = $member->user;
                                    $player = $user->player;
                                    $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0]))->implode('');
                                @endphp
                                <div class="group relative clip-cyber bg-gradient-to-br from-[#120303] to-[#070101] border border-red-500/15 hover:border-red-500/40 transition-all duration-300 p-6 flex flex-col gap-4 shadow-[0_0_20px_rgba(239,68,68,0.05)] hover:shadow-[0_0_30px_rgba(239,68,68,0.15)]">

                                    <!-- Scan line effect -->
                                    <div class="absolute inset-0 cyber-scanner overflow-hidden pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                    <!-- Avatar -->
                                    <div class="flex items-center gap-4">
                                        @if($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-red-500/40 shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                                        @else
                                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-red-900 to-black border-2 border-red-500/40 flex items-center justify-center shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                                                <span class="font-header font-black text-red-400 text-lg">{{ $initials }}</span>
                                            </div>
                                        @endif

                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-header font-black text-white text-md tracking-wide truncate">{{ $user->name }}</h3>
                                            @if($user->username)
                                                <span class="font-tech text-red-500 text-xs font-bold tracking-wider">@{{ $user->username }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-2">
                                        @if($member->role === 'captain')
                                            <span class="font-tech text-[10px] font-black tracking-widest uppercase px-2 py-1 bg-red-600/20 border border-red-500/40 text-red-400 rounded">⚡ CAPTAIN</span>
                                        @endif
                                        @if($member->team)
                                            <span class="font-tech text-[10px] font-bold tracking-widest uppercase px-2 py-1 bg-black/40 border border-red-500/10 text-gray-400 rounded truncate max-w-full">{{ Str::upper($member->team->name) }}</span>
                                        @endif
                                    </div>

                                    <!-- Player Details -->
                                    <div class="space-y-1.5 border-t border-red-500/10 pt-3">
                                        @if($player && $player->bio)
                                            <p class="font-tech text-gray-500 text-xs leading-relaxed line-clamp-2">{{ $player->bio }}</p>
                                        @else
                                            <p class="font-tech text-gray-600 text-xs italic">No bio provided yet.</p>
                                        @endif
                                    </div>

                                    <!-- Profile Link -->
                                    <div class="mt-auto pt-2">
                                        @if($user->username)
                                            <a href="{{ route('player.profile.username', $user->username) }}" class="block w-full text-center font-header font-black text-xs tracking-widest uppercase py-2.5 clip-cyber-sm border border-red-500/30 text-red-400 hover:bg-red-600 hover:text-white hover:border-red-500 transition-all duration-300">
                                                VIEW PROFILE
                                            </a>
                                        @else
                                            <a href="{{ route('player.profile', $user->id) }}" class="block w-full text-center font-header font-black text-xs tracking-widest uppercase py-2.5 clip-cyber-sm border border-red-500/30 text-red-400 hover:bg-red-600 hover:text-white hover:border-red-500 transition-all duration-300">
                                                VIEW PROFILE
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </section>

            <!-- INTERACTIVE HERO CLASS ROSTER SECTION -->
            <section id="heroes" class="py-20 px-6 bg-[#070101] relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        
                        <!-- Left Panel: Class Selector Info -->
                        <div class="lg:col-span-5 space-y-6">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-md uppercase block font-header">TACTICAL DIVISION INTEL</span>
                            <h2 class="font-header font-black text-3xl md:text-5xl text-white uppercase tracking-tight">
                                MLBB SQUAD <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 neon-text-red">ROLES & SPECS</span>
                            </h2>
                            <div class="w-16 h-1 bg-red-600"></div>
                            <p class="text-gray-400 font-light text-md leading-relaxed">
                                Explore the exact 5-man meta framework our team trains under. Every role is coordinated for high-tempo competitive executions and strategic synergy.
                            </p>

                            <!-- Interactive Button Roster Selector -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 font-header text-xs tracking-widest font-black pt-4">
                                <button onclick="selectHero('jungler')" id="btn-jungler" class="clip-cyber-sm py-3 text-center border transition-all duration-300 bg-red-600 border-red-500 text-white shadow-[0_0_10px_rgba(239,68,68,0.3)]">
                                    JUNGLER
                                </button>
                                <button onclick="selectHero('roamer')" id="btn-roamer" class="clip-cyber-sm py-3 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white">
                                    ROAMER
                                </button>
                                <button onclick="selectHero('gold')" id="btn-gold" class="clip-cyber-sm py-3 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white">
                                    GOLD LANER
                                </button>
                                <button onclick="selectHero('exp')" id="btn-exp" class="clip-cyber-sm py-3 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white">
                                    EXP LANER
                                </button>
                                <button onclick="selectHero('mid')" id="btn-mid" class="clip-cyber-sm py-3 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white col-span-2 sm:col-span-1">
                                    MID LANER
                                </button>
                            </div>
                        </div>

                        <!-- Right Panel: Spec Board Display -->
                        <div class="lg:col-span-7">
                            <div class="clip-cyber bg-gradient-to-br from-[#120303] to-[#070101] border border-red-500/20 p-8 shadow-[0_0_30px_rgba(239,68,68,0.1)] relative min-h-[400px] flex flex-col justify-between">
                                <div class="absolute inset-0 cyber-scanner overflow-hidden pointer-events-none"></div>

                                <!-- Dynamic Specs content -->
                                <div id="hero-display" class="relative z-10 space-y-6">
                                    <!-- Dynamic header injected here -->
                                    <div class="flex justify-between items-start pb-4 border-b border-red-500/10">
                                        <div>
                                            <span id="hero-tag" class="font-tech text-red-500 font-bold tracking-widest text-xs uppercase">TACTICAL FOCUS</span>
                                            <h3 id="hero-title" class="font-header font-black text-2xl text-white uppercase tracking-wider mt-0.5">JUNGLER SPECIALIZATION</h3>
                                        </div>
                                        <div class="px-3 py-1 bg-red-950/60 border border-red-500/30 rounded font-tech text-orange-400 text-sm font-bold uppercase tracking-widest">
                                            TACTICAL ROLE
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p id="hero-desc" class="text-gray-300 font-light text-md leading-relaxed">
                                        The Jungler takes command of the core map objectives, focusing on securing Turtles and Lords, hyper-farming in the jungle, and carrying out high-impact rotations to snowball the game.
                                    </p>

                                    <!-- Tactical Rating specifications -->
                                    <div class="space-y-4 pt-4">
                                        <span class="font-tech text-gray-500 font-bold tracking-widest text-xs uppercase block">OPERATIONAL RATING SPECIFICATIONS</span>
                                        
                                        <!-- Spec Item 1 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-tech font-bold uppercase tracking-widest">
                                                <span id="stat-label-1" class="text-gray-400">OBJECTIVE SECURING</span>
                                                <span id="stat-val-1" class="text-red-500">95%</span>
                                            </div>
                                            <div class="h-1.5 w-full bg-black/40 border border-red-500/10 rounded-full overflow-hidden">
                                                <div id="stat-bar-1" class="h-full bg-gradient-to-r from-red-600 to-orange-500 transition-all duration-500" style="width: 95%"></div>
                                            </div>
                                        </div>

                                        <!-- Spec Item 2 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-tech font-bold uppercase tracking-widest">
                                                <span id="stat-label-2" class="text-gray-400">ROTATIONAL SPEED</span>
                                                <span id="stat-val-2" class="text-orange-400">92%</span>
                                            </div>
                                            <div class="h-1.5 w-full bg-black/40 border border-red-500/10 rounded-full overflow-hidden">
                                                <div id="stat-bar-2" class="h-full bg-gradient-to-r from-red-600 to-orange-500 transition-all duration-500" style="width: 92%"></div>
                                            </div>
                                        </div>

                                        <!-- Spec Item 3 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-tech font-bold uppercase tracking-widest">
                                                <span id="stat-label-3" class="text-gray-400">HYPER FARM EFFICIENCY</span>
                                                <span id="stat-val-3" class="text-yellow-500">96%</span>
                                            </div>
                                            <div class="h-1.5 w-full bg-black/40 border border-red-500/10 rounded-full overflow-hidden">
                                                <div id="stat-bar-3" class="h-full bg-gradient-to-r from-red-600 to-orange-500 transition-all duration-500" style="width: 96%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- STATS SHOWCASE: DYNAMIC TEAM SPECIFICATIONS -->
            <section id="stats" class="py-20 px-6 bg-gradient-to-b from-[#070101] to-black relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        
                        <!-- Telemetry Stat Card 1 -->
                        <div class="clip-cyber bg-[#120303]/40 border border-red-500/15 hover:border-red-500/30 p-8 text-center transition-all duration-300">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-xs uppercase block mb-1">PRO DIVISIONS</span>
                            <h3 class="font-header font-black text-4xl text-white tracking-widest neon-text-red mb-2">
                                {{ sprintf("%02d", $squadsCount) }}
                            </h3>
                            <p class="font-tech text-gray-500 font-bold text-sm uppercase tracking-wider">ACTIVE DEPLOYED SQUADS</p>
                        </div>

                        <!-- Telemetry Stat Card 2 -->
                        <div class="clip-cyber bg-[#120303]/40 border border-red-500/15 hover:border-red-500/30 p-8 text-center transition-all duration-300">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-xs uppercase block mb-1">ELITE ATHLETES</span>
                            <h3 class="font-header font-black text-4xl text-white tracking-widest neon-text-red mb-2">
                                {{ sprintf("%02d", $athletesCount) }}
                            </h3>
                            <p class="font-tech text-gray-500 font-bold text-sm uppercase tracking-wider">ACTIVE ROSTER MEMBERS</p>
                        </div>

                        <!-- Telemetry Stat Card 3 -->
                        <div class="clip-cyber bg-[#120303]/40 border border-red-500/15 hover:border-red-500/30 p-8 text-center transition-all duration-300">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-xs uppercase block mb-1">PRO CIRCUITS</span>
                            <h3 class="font-header font-black text-4xl text-white tracking-widest neon-text-red mb-2">
                                {{ sprintf("%02d", $tournamentsCount) }}
                            </h3>
                            <p class="font-tech text-gray-500 font-bold text-sm uppercase tracking-wider">TOURNAMENTS REGISTERED</p>
                        </div>

                        <!-- Telemetry Stat Card 4 -->
                        <div class="clip-cyber bg-[#120303]/40 border border-red-500/15 hover:border-red-500/30 p-8 text-center transition-all duration-300">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-xs uppercase block mb-1">TEAM ETHOS</span>
                            <h3 class="font-header font-black text-4xl text-white tracking-widest neon-text-red mb-2">
                                {{ $winRate > 0 ? $winRate . '%' : '100%' }}
                            </h3>
                            <p class="font-tech text-gray-500 font-bold text-sm uppercase tracking-wider">
                                {{ $winRate > 0 ? 'COMPETITIVE WINRATE' : 'DEDICATION & FIRE' }}
                            </p>
                        </div>

                    </div>

                </div>
            </section>

            <!-- TOURNAMENTS & CHAMPIONSHIPS SHOWCASE -->
            <section id="tournaments" class="py-20 px-6 bg-[#070101] relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Graphic Left: Champion Trophy Showcase -->
                    <div class="lg:col-span-5 flex justify-center relative order-last lg:order-first">
                        <div class="absolute -inset-1.5 rounded-full bg-gradient-to-r from-red-600 to-orange-500 opacity-25 blur-xl"></div>
                        <div class="relative w-full max-w-[400px] clip-cyber bg-[#120303]/60 border border-red-500/30 p-6 shadow-[0_0_30px_rgba(239,68,68,0.2)]">
                            <img src="{{ asset('images/trophy.png') }}" alt="Championship Trophy" class="w-full h-auto object-contain rounded border border-red-500/10">
                        </div>
                    </div>

                    <!-- Details right -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <span class="font-tech text-red-500 font-bold tracking-widest text-md uppercase block">OUR ROAD TO GLORY</span>
                        <h2 class="font-header font-black text-3xl md:text-5xl text-white uppercase tracking-tight leading-none">
                            ON THE VERGE OF <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 neon-text-red">RISING TO DEBUT</span>
                        </h2>
                        <p class="text-gray-400 font-light text-md leading-relaxed">
                            As a recently formed, hungry esports squad, our focus is locked on intense preparation and daily team synergy. We are actively training to debut in regional qualifiers, community cups, and pro-circuits very soon.
                        </p>

                        <!-- Cyber list -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-tech text-lg text-gray-300">
                            <div class="flex items-center gap-3 bg-black/40 border border-red-500/10 p-3 rounded clip-cyber-sm">
                                <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                <span>PRO CIRCUITS READY</span>
                            </div>
                            <div class="flex items-center gap-3 bg-black/40 border border-red-500/10 p-3 rounded clip-cyber-sm">
                                <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                <span>DAILY SCRIMS & TRAINING</span>
                            </div>
                            <div class="flex items-center gap-3 bg-black/40 border border-red-500/10 p-3 rounded clip-cyber-sm">
                                <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                <span>DEDICATED VOICE COMMS</span>
                            </div>
                            <div class="flex items-center gap-3 bg-black/40 border border-red-500/10 p-3 rounded clip-cyber-sm">
                                <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                <span>TACTICAL GAMEPLAY SYNERGY</span>
                            </div>
                        </div>
                    </div>

                </div>
            </section>


            <!-- HQ SHOWCASE: VIDANTA CHAMPIONS ARENA -->
            <section id="vidanta" class="py-20 px-6 bg-gradient-to-b from-black to-[#070101] relative z-10 border-t border-red-500/10">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        
                        <!-- Left Panel: Brand Details & Info -->
                        <div class="lg:col-span-6 space-y-6 text-left">
                            <span class="font-tech text-red-500 font-bold tracking-widest text-md uppercase block">OUR PARENT ORGANIZATION</span>
                            
                            <div class="flex items-center gap-4">
                                <!-- Glowing Cyber SVG Logo for Vidanta Champions Arena -->
                                <div class="relative w-16 h-16 flex items-center justify-center bg-black border border-red-500/30 rounded-xl p-2 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                                    <svg viewBox="0 0 100 100" class="w-12 h-12 text-red-500 drop-shadow-[0_0_8px_#ef4444]" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Outer Hexagon -->
                                        <polygon points="50,5 90,25 90,75 50,95 10,75 10,25" stroke="currentColor" stroke-width="4" stroke-linejoin="round" fill="rgba(239,68,68,0.05)"/>
                                        <!-- Sleek Cyber V wing monogram -->
                                        <path d="M25,25 L45,75 L50,75 L70,25 L58,25 L48,60 L38,25 Z" fill="currentColor"/>
                                        <path d="M50,15 L78,29 L78,40 L50,26 Z" fill="rgba(239,68,68,0.5)"/>
                                        <path d="M50,85 L22,71 L22,60 L50,74 Z" fill="rgba(239,68,68,0.5)"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="font-header font-black text-2xl md:text-4xl text-white uppercase tracking-tight leading-none">
                                        VIDANTA <br>
                                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500 neon-text-red">CHAMPIONS ARENA</span>
                                    </h2>
                                </div>
                            </div>
                            
                            <div class="w-16 h-1 bg-red-600"></div>
                            
                            <p class="text-gray-400 font-light text-md leading-relaxed">
                                IceCream Fried Esports is proudly owned and powered by <strong class="text-white">Vidanta Champions Arena</strong>, a premier esports organization in Nepal. Vidanta offers top-tier tournament management services, high-end graphical content support for live matches, professional broadcasting services, and elite player management services — driving both the competitive operations and visual excellence of our team.
                            </p>

                            <p class="text-gray-400 font-light text-md leading-relaxed">
                                Discover their emerging digital headquarters at <a href="http://vidantaca.com.np" target="_blank" class="text-red-500 font-bold hover:underline tracking-wider font-tech">vidantaca.com.np</a>. Operating across two premium Nepalese hubs, they cultivate next-generation gaming talents.
                            </p>

                            <!-- Founders Row -->
                            <div class="flex flex-wrap gap-3 pt-1">
                                <div class="flex items-center gap-2 bg-black/40 border border-red-500/10 px-3 py-2 rounded clip-cyber-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_6px_#ef4444]"></span>
                                    <span class="font-tech text-xs text-gray-400 uppercase tracking-widest">FOUNDER</span>
                                    <span class="font-header font-black text-white text-xs tracking-wider">SUMIN SHRESTHA</span>
                                </div>
                                <div class="flex items-center gap-2 bg-black/40 border border-red-500/10 px-3 py-2 rounded clip-cyber-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_6px_#ef4444]"></span>
                                    <span class="font-tech text-xs text-gray-400 uppercase tracking-widest">FOUNDER</span>
                                    <span class="font-header font-black text-white text-xs tracking-wider">BIBEK LAMA</span>
                                </div>
                            </div>

                            <!-- Two Locations Details -->
                            <div class="space-y-4 pt-4 border-t border-red-500/10">
                                <span class="font-tech text-gray-500 font-bold tracking-widest text-xs uppercase block">GROUND LOCATIONS</span>
                                
                                <!-- Location 1: Kathmandu -->
                                <div class="bg-black/40 border border-red-500/10 p-4 rounded clip-cyber-sm flex justify-between items-start gap-4">
                                    <div>
                                        <h4 class="font-header font-black text-red-500 text-sm tracking-widest uppercase">KATHMANDU</h4>
                                        <p class="text-gray-400 text-xs font-tech mt-1">Vidanta Champions Arena, Kathmandu, Nepal</p>
                                        <p class="text-gray-500 text-xs font-tech mt-1 font-bold">CORPORATE HQ & OPERATIONS</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-tech text-orange-400 text-xs font-bold block uppercase tracking-widest">CONTACT</span>
                                        <a href="tel:+9779802350986" class="text-white text-xs font-tech font-bold hover:text-red-400">+977 980-2350986</a>
                                    </div>
                                </div>

                                <!-- Location 2: Lalitpur -->
                                <div class="bg-black/40 border border-red-500/10 p-4 rounded clip-cyber-sm flex justify-between items-start gap-4">
                                    <div>
                                        <h4 class="font-header font-black text-red-500 text-sm tracking-widest uppercase">LALITPUR</h4>
                                        <p class="text-gray-400 text-xs font-tech mt-1">Vidanta Champions Arena, Satdobato-Godavari Road, Lalitpur, Nepal</p>
                                        <p class="text-gray-500 text-xs font-tech mt-1 font-bold">BOOTCAMP & ESPORTS EVENT VENUE</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-tech text-orange-400 text-xs font-bold block uppercase tracking-widest">CONTACT</span>
                                        <a href="tel:+9779803507666" class="text-white text-xs font-tech font-bold hover:text-red-400">+977 980-3507666</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Neon Google Maps Switcher -->
                        <div class="lg:col-span-6 space-y-6">
                            <!-- Toggle Buttons -->
                            <div class="flex gap-3 justify-center lg:justify-start font-header text-xs tracking-widest font-black">
                                <button onclick="selectMap('kathmandu')" id="btn-map-kathmandu" class="clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 bg-red-600 border-red-500 text-white shadow-[0_0_10px_rgba(239,68,68,0.3)]">
                                    KATHMANDU MAP
                                </button>
                                <button onclick="selectMap('lalitpur')" id="btn-map-lalitpur" class="clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white">
                                    LALITPUR MAP
                                </button>
                            </div>

                            <!-- Map Frames Container -->
                            <div class="relative clip-cyber bg-[#120303]/40 border border-red-500/20 p-4 shadow-[0_0_30px_rgba(239,68,68,0.15)] h-[350px] overflow-hidden">
                                <!-- Cyber scan effects overlay -->
                                <div class="absolute inset-0 pointer-events-none z-10 border border-red-500/10"></div>
                                
                                <!-- Kathmandu Map Frame -->
                                <div id="map-frame-kathmandu" class="w-full h-full transition-opacity duration-500 opacity-100">
                                    <iframe 
                                        src="https://maps.google.com/maps?q=Vidanta+Champions+Arena+Kathmandu+Nepal&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                        class="w-full h-full border-0 rounded transition-all duration-300" 
                                        style="filter: invert(0.9) hue-rotate(180deg) saturate(1.8) brightness(0.95) contrast(1.2);"
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                </div>

                                <!-- Lalitpur Map Frame -->
                                <div id="map-frame-lalitpur" class="w-full h-full transition-opacity duration-500 opacity-0 absolute inset-0 pointer-events-none p-4">
                                    <iframe 
                                        src="https://maps.google.com/maps?q=Vidanta+Champions+Arena+Satdobato+Lalitpur+Nepal&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                        class="w-full h-full border-0 rounded transition-all duration-300" 
                                        style="filter: invert(0.9) hue-rotate(180deg) saturate(1.8) brightness(0.95) contrast(1.2);"
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                </div>
                            </div>
                            
                            <!-- Interactive Map Indicator -->
                            <div class="flex items-center justify-between font-tech text-xs text-gray-500 uppercase tracking-widest bg-black/40 border border-red-500/10 p-3 rounded clip-cyber-sm">
                                <span>TELEMETRY: MAP FEED STABLE</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444] animate-pulse"></span>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

        </main>

        <!-- FOOTER & STATIC PAGES LINKS -->
        <footer class="bg-black/80 border-t border-red-500/10 py-10 px-6 text-center relative z-20">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Brand logo footer -->
                <a href="/" class="flex items-center gap-3">
                    <span class="font-header font-black tracking-widest text-md text-white">
                        ICECREAM <span class="text-red-500 neon-text-red">FRIED</span>
                    </span>
                </a>

                <!-- Copyright -->
                <p class="font-tech text-gray-500 text-md font-medium tracking-wider">
                    &copy; {{ date('Y') }} ICECREAM FRIED ESPORTS SQUADS. ALL TELEMETRY LOGS SECURED.
                </p>

                <!-- Roster & Portal Links -->
                <div class="flex gap-6 font-tech text-md font-semibold tracking-wider text-gray-500">
                    <a href="#squads" class="hover:text-red-400 transition-colors">SQUADS</a>
                    <a href="#roster" class="hover:text-red-400 transition-colors">ROSTER</a>
                    <a href="#heroes" class="hover:text-red-400 transition-colors">SPECIALTIES</a>
                    <a href="#stats" class="hover:text-red-400 transition-colors">OUR VISION</a>
                    <a href="#vidanta" class="hover:text-red-400 transition-colors">VIDANTA ARENA</a>
                </div>

            </div>
        </footer>

        <!-- JAVASCRIPT SPECIALTY ANIMATION INTERACTIVITY -->
        <script>
            const heroData = {
                jungler: {
                    title: 'JUNGLER SPECIALIZATION',
                    desc: 'The Jungler takes command of the core map objectives, focusing on securing Turtles and Lords, hyper-farming in the jungle, and carrying out high-impact rotations to snowball the game.',
                    labels: ['OBJECTIVE SECURING', 'ROTATIONAL SPEED', 'HYPER FARM EFFICIENCY'],
                    stats: ['95%', '92%', '96%'],
                    statRaw: [95, 92, 96]
                },
                roamer: {
                    title: 'ROAMER SPECIALIZATION',
                    desc: 'The Roamer controls map vision, initiates crucial teamfights, protects priority allies, and disrupts enemy formations to dictate the overall tempo of the matches.',
                    labels: ['INITIATION TIMING', 'VISION DOMINANCE', 'PEEL & PROTECTION'],
                    stats: ['94%', '98%', '90%'],
                    statRaw: [94, 98, 90]
                },
                gold: {
                    title: 'GOLD LANER SPECIALIZATION',
                    desc: 'The Gold Laner farms aggressively in the early game to secure high-tier damage items, positioning flawlessly behind the frontlines to serve as our ultimate late-game physical carry.',
                    labels: ['LATE-GAME CARRY CAPABILITY', 'POSITIONING DEXTERITY', 'TARGET ACQUISITION'],
                    stats: ['98%', '95%', '92%'],
                    statRaw: [98, 95, 92]
                },
                exp: {
                    title: 'EXP LANER SPECIALIZATION',
                    desc: 'The EXP Laner secures early levels to dominate the solo lane, functioning as a high-sustain frontline bruiser that absorbs enemy damage and zones out opposition damage dealers.',
                    labels: ['FRONTLINE SUSTAINABILITY', 'SOLOLANE DOMINANCE', 'ZONING & ENGAGEMENT'],
                    stats: ['96%', '90%', '92%'],
                    statRaw: [96, 90, 92]
                },
                mid: {
                    title: 'MID LANER SPECIALIZATION',
                    desc: 'The Mid Laner excels at rapid wave clearing, magery support, and teamfight backup, rotating quickly to side lanes to coordinate crushing early-game ambushes.',
                    labels: ['MAGICAL BURST DAMAGE', 'LANE CLEAR VELOCITY', 'MAP ROTATION AID'],
                    stats: ['94%', '96%', '90%'],
                    statRaw: [94, 96, 90]
                }
            };

            function selectHero(heroClass) {
                // Remove active classes
                ['jungler', 'roamer', 'gold', 'exp', 'mid'].forEach(c => {
                    const btn = document.getElementById(`btn-${c}`);
                    if (btn) {
                        btn.className = "clip-cyber-sm py-3 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white" + (c === 'mid' ? ' col-span-2 sm:col-span-1' : '');
                    }
                });

                // Set active class
                const activeBtn = document.getElementById(`btn-${heroClass}`);
                if (activeBtn) {
                    activeBtn.className = "clip-cyber-sm py-3 text-center border transition-all duration-300 bg-red-600 border-red-500 text-white shadow-[0_0_10px_rgba(239,68,68,0.3)]" + (heroClass === 'mid' ? ' col-span-2 sm:col-span-1' : '');
                }

                // Update info on display
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
                // Toggle buttons
                const btnLalitpur = document.getElementById('btn-map-lalitpur');
                const btnKathmandu = document.getElementById('btn-map-kathmandu');
                
                // Toggle frames
                const frameLalitpur = document.getElementById('map-frame-lalitpur');
                const frameKathmandu = document.getElementById('map-frame-kathmandu');
                
                if (mapName === 'lalitpur') {
                    btnLalitpur.className = "clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 bg-red-600 border-red-500 text-white shadow-[0_0_10px_rgba(239,68,68,0.3)]";
                    btnKathmandu.className = "clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white";
                    
                    frameLalitpur.classList.remove('opacity-0', 'absolute', 'pointer-events-none');
                    frameLalitpur.classList.add('opacity-100');
                    
                    frameKathmandu.classList.remove('opacity-100');
                    frameKathmandu.classList.add('opacity-0', 'absolute', 'pointer-events-none');
                } else {
                    btnKathmandu.className = "clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 bg-red-600 border-red-500 text-white shadow-[0_0_10px_rgba(239,68,68,0.3)]";
                    btnLalitpur.className = "clip-cyber-sm py-3 px-6 text-center border transition-all duration-300 border-red-500/20 text-gray-400 hover:border-red-500 hover:text-white";
                    
                    frameKathmandu.classList.remove('opacity-0', 'absolute', 'pointer-events-none');
                    frameKathmandu.classList.add('opacity-100');
                    
                    frameLalitpur.classList.remove('opacity-100');
                    frameLalitpur.classList.add('opacity-0', 'absolute', 'pointer-events-none');
                }
            }
        </script>

    </body>
</html>
