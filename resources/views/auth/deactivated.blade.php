<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Account Deactivated | IceCream Fried Esports</title>

        <!-- Futuristic Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Tailwind CSS -->
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
                overflow-x: hidden;
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
                background: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.22) 0%, transparent 65%);
            }

            .neon-text-red {
                text-shadow: 0 0 10px rgba(239, 68, 68, 0.9), 0 0 20px rgba(239, 68, 68, 0.4);
            }

            .neon-text-orange {
                text-shadow: 0 0 10px rgba(249, 115, 22, 0.8), 0 0 20px rgba(249, 115, 22, 0.3);
            }

            @keyframes cyberPulse {
                0%, 100% { transform: scale(1); opacity: 0.9; }
                50% { transform: scale(1.02); opacity: 1; }
            }

            .animate-cyber-pulse {
                animation: cyberPulse 4s ease-in-out infinite;
            }

            .clip-cyber {
                clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 20px 100%, 0 calc(100% - 20px));
            }

            .clip-cyber-sm {
                clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));
            }
        </style>
    </head>
    <body class="text-gray-100 antialiased selection:bg-red-600 selection:text-white min-h-screen flex items-center justify-center relative p-4">

        <!-- Background Ambient Glow Nodes -->
        <div class="fixed top-0 left-0 w-[500px] h-[500px] glow-red pointer-events-none -translate-x-1/4 -translate-y-1/4 z-0"></div>
        <div class="fixed bottom-0 right-0 w-[600px] h-[600px] glow-red pointer-events-none translate-x-1/4 translate-y-1/4 z-0"></div>
        <div class="absolute inset-0 cyber-grid z-0"></div>

        <!-- Main Wrapper -->
        <div class="relative z-10 w-full max-w-[480px] animate-cyber-pulse my-8">
            
            <!-- Glow background overlay -->
            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-700 via-red-600 to-orange-600 opacity-30 blur-xl z-0"></div>

            <!-- Card Container -->
            <div class="relative clip-cyber bg-[#0c0303]/95 border-2 border-red-600/40 p-6 sm:p-8 z-10 shadow-[0_0_40px_rgba(239,68,68,0.25)]">

                <!-- Brand Header / Logo -->
                <div class="flex flex-col items-center text-center pb-5 border-b border-red-500/15 mb-6">
                    <div class="w-18 h-18 rounded-xl bg-red-950/60 border border-red-500/40 flex items-center justify-center p-2 mb-3 shadow-[0_0_20px_rgba(239,68,68,0.4)]">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <span class="font-header font-black tracking-widest text-xs text-red-500 neon-text-red uppercase">CRITICAL ACCESS SUSPENSION</span>
                    <h1 class="font-header font-black text-xl sm:text-2xl text-white uppercase tracking-wider mt-1.5 leading-none">
                        ACCOUNT <span class="text-red-500 neon-text-red">DEACTIVATED</span>
                    </h1>
                </div>

                <!-- Warning Alert Box -->
                <div class="bg-red-950/40 border border-red-500/50 rounded-xl p-5 mb-6 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-red-600/30 border border-red-500/50 flex items-center justify-center shrink-0 shadow-[0_0_10px_#ef4444]">
                            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-tech text-xs uppercase tracking-widest text-red-400 font-bold block">STATUS CODE // INACTIVE</span>
                            <span class="font-header text-sm font-bold text-white">Access Denied by Administrator</span>
                        </div>
                    </div>

                    <p class="font-sans text-xs sm:text-sm text-gray-200 leading-relaxed pt-1">
                        Your player account has been <strong class="text-red-400 font-semibold">deactivated by an administrator</strong>. Access to the IceCream Fried Esports portal, team rosters, and competition telemetry is currently suspended.
                    </p>
                </div>

                <!-- Explanation / Next Steps -->
                <div class="space-y-2 text-xs sm:text-sm text-gray-400 font-sans leading-relaxed mb-6 bg-black/40 border border-white/5 rounded-lg p-4">
                    <h3 class="font-header text-xs font-bold text-gray-200 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_6px_#ef4444]"></span>
                        Next Protocol
                    </h3>
                    <p class="text-gray-300">
                        If you are an active roster athlete or team staff member and believe this suspension is in error, please reach out directly to your <strong class="text-white">Team Manager</strong> or <strong class="text-white">Head Admin</strong> to have your account status reinstated.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3 pt-1">
                    <!-- Return to Login -->
                    <a 
                        href="{{ url('/login') }}" 
                        class="clip-cyber-sm w-full py-3.5 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white font-header font-black tracking-widest text-xs sm:text-sm transition-all duration-300 shadow-[0_0_20px_rgba(239,68,68,0.4)] flex items-center justify-center gap-2 cursor-pointer text-center"
                    >
                        <span>RETURN TO LOGIN PORTAL</span>
                    </a>

                    <!-- Contact Support -->
                    <a 
                        href="mailto:support@vidantaca.com.np?subject=Account%20Reactivation%20Request" 
                        class="clip-cyber-sm w-full py-3 bg-white/5 hover:bg-white/10 border border-white/15 hover:border-red-500/40 text-gray-300 hover:text-white font-tech font-bold tracking-widest text-sm transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer text-center"
                    >
                        <svg class="w-4 h-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>CONTACT ADMINISTRATION</span>
                    </a>
                </div>

                <!-- Footer back-links -->
                <div class="mt-6 pt-5 border-t border-red-500/10 flex justify-between items-center text-center font-tech text-xs tracking-wider text-gray-500">
                    <a href="/" class="hover:text-red-400 transition-colors">
                        &larr; MAIN ARENA
                    </a>
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-gray-400 transition-colors">
                        PRIVACY POLICY
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
