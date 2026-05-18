<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IceCream Fried Esports | Decryption Portal</title>

        <!-- Futuristic Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Tailwind CSS v4 CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Cyberpunk Styling Spec -->
        <style>
            :root {
                --color-cyber-red: #ef4444;
                --color-cyber-orange: #f97316;
                --color-cyber-dark: #070101;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--color-cyber-dark);
                overflow: hidden;
            }

            .font-header {
                font-family: 'Orbitron', sans-serif;
            }

            .font-tech {
                font-family: 'Rajdhani', sans-serif;
            }

            .cyber-grid {
                background-image: 
                    linear-gradient(rgba(239, 68, 68, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(239, 68, 68, 0.03) 1px, transparent 1px);
                background-size: 35px 35px;
                background-position: center;
            }

            .glow-red {
                background: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.18) 0%, transparent 65%);
            }

            /* Neon text */
            .neon-text-red {
                text-shadow: 0 0 10px rgba(239, 68, 68, 0.8), 0 0 20px rgba(239, 68, 68, 0.3);
            }

            .neon-text-orange {
                text-shadow: 0 0 10px rgba(249, 115, 22, 0.8), 0 0 20px rgba(249, 115, 22, 0.3);
            }

            /* Floating animation */
            @keyframes cyberFloat {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .animate-cyber-float {
                animation: cyberFloat 6s ease-in-out infinite;
            }

            /* Tech Clip paths */
            .clip-cyber {
                clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 20px 100%, 0 calc(100% - 20px));
            }

            .clip-cyber-sm {
                clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));
            }

            /* Scanning laser lines */
            @keyframes scannerScan {
                0% { top: 0%; opacity: 0.5; }
                50% { opacity: 0.8; }
                100% { top: 100%; opacity: 0.5; }
            }

            .tech-scanner::after {
                content: '';
                position: absolute;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #ef4444, #f97316, #ef4444, transparent);
                box-shadow: 0 0 8px #ef4444, 0 0 16px #f97316;
                animation: scannerScan 4s linear infinite;
            }
        </style>
    </head>
    <body class="text-gray-100 antialiased selection:bg-red-600 selection:text-white min-h-screen flex items-center justify-center relative p-4">

        <!-- Background Ambient Glow Nodes -->
        <div class="fixed top-0 left-0 w-[500px] h-[500px] glow-red pointer-events-none -translate-x-1/4 -translate-y-1/4 z-0"></div>
        <div class="fixed bottom-0 right-0 w-[600px] h-[600px] glow-red pointer-events-none translate-x-1/4 translate-y-1/4 z-0"></div>

        <div class="absolute inset-0 cyber-grid z-0"></div>

        <!-- Main Wrapper -->
        <div class="relative z-10 w-full max-w-[420px] animate-cyber-float">
            
            <!-- Glow background overlay -->
            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-600 to-orange-500 opacity-25 blur-lg z-0"></div>

            <!-- Login Container -->
            <div class="relative clip-cyber bg-[#0c0303]/95 border border-red-500/20 p-6 md:p-8 z-10">
                
                <!-- Scanner Effect -->
                <div class="absolute inset-0 tech-scanner overflow-hidden pointer-events-none rounded-2xl"></div>

                <!-- Brand Header / Logo -->
                <div class="flex flex-col items-center text-center pb-6 border-b border-red-500/10 mb-6">
                    <div class="w-20 h-20 rounded-xl bg-red-950/40 border border-red-500/30 flex items-center justify-center p-2 mb-3 shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <span class="font-header font-black tracking-widest text-xs text-orange-400 neon-text-orange uppercase">IDENTITY SECURITY INJECTION</span>
                    <h1 class="font-header font-black text-xl text-white uppercase tracking-wider mt-1.5 leading-none">
                        ICECREAM <span class="text-red-500 neon-text-red">FRIED</span>
                    </h1>
                </div>

                <!-- Session Status / Errors -->
                @if (session('status'))
                    <div class="mb-4 bg-red-950/20 border border-red-500/30 rounded-lg p-3 text-red-400 font-tech text-md tracking-wider">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                    @csrf

                    <!-- Identity Login input -->
                    <div class="space-y-1.5">
                        <label for="login" class="font-tech text-sm font-semibold tracking-wider text-red-400 uppercase block">
                            Email or Username
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="login" 
                                name="login" 
                                value="{{ old('login') }}" 
                                required 
                                autofocus 
                                placeholder="Enter system handle..."
                                class="w-full bg-black/40 border border-red-500/20 focus:border-red-400 text-white rounded-lg px-4 py-3 font-tech text-md tracking-wider placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-red-400 transition-all duration-300"
                            >
                        </div>
                        @error('login')
                            <div class="mt-2 text-xs font-semibold text-red-500 tracking-wider font-tech flex items-center gap-1.5 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="font-tech text-sm font-semibold tracking-wider text-red-400 uppercase">
                                Access Password
                            </label>
                        </div>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="Enter cyber-key..."
                                class="w-full bg-black/40 border border-red-500/20 focus:border-red-400 text-white rounded-lg px-4 py-3 font-tech text-md tracking-wider placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-red-400 transition-all duration-300"
                            >
                        </div>
                        @error('password')
                            <div class="mt-2 text-xs font-semibold text-red-500 tracking-wider font-tech flex items-center gap-1.5 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between font-tech text-md font-semibold tracking-wider text-gray-400 py-1">
                        <label class="flex items-center gap-2.5 cursor-pointer hover:text-gray-300 transition-colors">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 rounded border-red-500/30 bg-black/40 text-red-600 focus:ring-red-500 focus:ring-offset-black"
                            >
                            <span>PERSIST SESSION</span>
                        </label>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="clip-cyber-sm w-full py-3.5 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white font-header font-black tracking-widest text-sm transition-all duration-300 shadow-[0_0_20px_rgba(239,68,68,0.4)] cursor-pointer"
                        >
                            DECRYPT & ENTER
                        </button>
                    </div>

                </form>

                <!-- Footer back-links -->
                <div class="mt-6 pt-5 border-t border-red-500/10 flex justify-center text-center">
                    <a href="/" class="font-tech text-md font-bold tracking-widest text-gray-500 hover:text-red-400 transition-colors duration-300">
                        &larr; BACK TO ARENA COMMAND
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
