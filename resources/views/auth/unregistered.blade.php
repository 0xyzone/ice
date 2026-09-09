<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Account Not Created | IceCream Fried Esports</title>

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
                background: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.18) 0%, transparent 65%);
            }

            .neon-text-red {
                text-shadow: 0 0 10px rgba(239, 68, 68, 0.8), 0 0 20px rgba(239, 68, 68, 0.3);
            }

            .neon-text-orange {
                text-shadow: 0 0 10px rgba(249, 115, 22, 0.8), 0 0 20px rgba(249, 115, 22, 0.3);
            }

            @keyframes cyberFloat {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }

            .animate-cyber-float {
                animation: cyberFloat 6s ease-in-out infinite;
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
        <div class="relative z-10 w-full max-w-[480px] animate-cyber-float my-8">
            
            <!-- Glow background overlay -->
            <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-red-600 to-orange-500 opacity-25 blur-lg z-0"></div>

            <!-- Card Container -->
            <div class="relative clip-cyber bg-[#0c0303]/95 border border-red-500/25 p-6 sm:p-8 z-10 shadow-[0_0_30px_rgba(239,68,68,0.15)]">

                <!-- Brand Header / Logo -->
                <div class="flex flex-col items-center text-center pb-5 border-b border-red-500/15 mb-6">
                    <div class="w-18 h-18 rounded-xl bg-red-950/40 border border-red-500/30 flex items-center justify-center p-2 mb-3 shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <span class="font-header font-black tracking-widest text-xs text-orange-400 neon-text-orange uppercase">IDENTITY REJECTED // ACCESS DENIED</span>
                    <h1 class="font-header font-black text-xl text-white uppercase tracking-wider mt-1 leading-none">
                        ACCOUNT <span class="text-red-500 neon-text-red">NOT FOUND</span>
                    </h1>
                </div>

                <!-- Warning Alert Box -->
                <div class="bg-red-950/30 border border-red-500/40 rounded-xl p-4 sm:p-5 mb-6 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500/20 border border-red-500/40 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-tech text-xs uppercase tracking-widest text-orange-400 font-bold block">SECURITY NOTICE</span>
                            <span class="font-header text-sm font-bold text-white">Profile Not Yet Provisioned</span>
                        </div>
                    </div>

                    @if (!empty($email))
                        <div class="bg-black/60 border border-red-500/20 rounded-lg px-3.5 py-2 font-tech text-sm tracking-wider text-gray-300 flex items-center justify-between gap-2 break-all">
                            <span class="text-gray-500 text-xs uppercase">Attempted Email:</span>
                            <span class="text-orange-400 font-semibold">{{ $email }}</span>
                        </div>
                    @endif

                    <p class="font-sans text-xs sm:text-sm text-gray-300 leading-relaxed pt-1">
                        An administrator has <strong class="text-white">not created an account</strong> for this email address yet. Our esports player portal is invite-only for rostered athletes and team staff.
                    </p>
                </div>

                <!-- Instructions / Next steps -->
                <div class="space-y-3 text-xs sm:text-sm text-gray-400 font-sans leading-relaxed mb-6 bg-black/40 border border-white/5 rounded-lg p-4">
                    <h3 class="font-header text-xs font-bold text-gray-200 uppercase tracking-wider mb-1 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 shadow-[0_0_6px_#f97316]"></span>
                        What Should You Do?
                    </h3>
                    <ul class="space-y-2 list-disc list-inside pl-1 text-gray-300">
                        <li>If you are a rostered player, please notify your <strong class="text-white">Team Captain</strong> or <strong class="text-white">Admin</strong> to register your player handle.</li>
                        <li>Once the admin creates your profile using this email, you can instantly log in here with Google.</li>
                        <li>If you used the wrong Google account, switch to the Gmail registered with management below.</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3 pt-1">
                    <!-- Try Different Google Account -->
                    <a 
                        href="{{ route('auth.google.redirect', ['prompt' => 'select_account']) }}" 
                        class="clip-cyber-sm w-full py-3.5 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white font-header font-black tracking-widest text-xs sm:text-sm transition-all duration-300 shadow-[0_0_20px_rgba(239,68,68,0.4)] flex items-center justify-center gap-2.5 cursor-pointer text-center"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#fff" d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
                        </svg>
                        <span>TRY DIFFERENT GOOGLE ACCOUNT</span>
                    </a>

                    <!-- Return to Login -->
                    <a 
                        href="{{ url('/login') }}" 
                        class="clip-cyber-sm w-full py-3 bg-white/5 hover:bg-white/10 border border-white/15 hover:border-red-500/40 text-gray-300 hover:text-white font-tech font-bold tracking-widest text-sm transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer text-center"
                    >
                        <span>RETURN TO LOGIN PORTAL</span>
                    </a>
                </div>

                <!-- Footer back-links -->
                <div class="mt-6 pt-5 border-t border-red-500/10 flex justify-between items-center text-center font-tech text-xs tracking-wider text-gray-500">
                    <a href="/" class="hover:text-red-400 transition-colors">
                        &larr; MAIN ARENA
                    </a>
                    <a href="mailto:support@vidantaca.com.np" class="text-orange-400 hover:underline">
                        CONTACT SUPPORT
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
