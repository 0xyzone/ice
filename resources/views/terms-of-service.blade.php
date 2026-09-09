<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Terms of Service | IceCream Fried Esports</title>
        <meta name="description" content="Terms of Service for IceCream Fried Esports athlete platform, detailing user responsibilities, platform access, fair play, and account terms.">

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
                color: #e5e7eb;
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
                background: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.15) 0%, transparent 65%);
            }

            .neon-text-red {
                text-shadow: 0 0 10px rgba(239, 68, 68, 0.8), 0 0 20px rgba(239, 68, 68, 0.3);
            }

            .clip-cyber {
                clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 20px 100%, 0 calc(100% - 20px));
            }

            .clip-cyber-sm {
                clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));
            }
        </style>
    </head>
    <body class="min-h-screen relative selection:bg-red-600 selection:text-white flex flex-col">

        <!-- Background Ambient Glow Nodes -->
        <div class="fixed top-0 left-0 w-[500px] h-[500px] glow-red pointer-events-none -translate-x-1/4 -translate-y-1/4 z-0"></div>
        <div class="fixed bottom-0 right-0 w-[600px] h-[600px] glow-red pointer-events-none translate-x-1/4 translate-y-1/4 z-0"></div>
        <div class="fixed inset-0 cyber-grid pointer-events-none z-0"></div>

        <!-- Top Navigation -->
        <header class="sticky top-0 z-50 bg-[#070101]/90 backdrop-blur-md border-b border-red-500/10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg bg-red-950/40 border border-red-500/30 flex items-center justify-center p-1.5 shadow-[0_0_10px_rgba(239,68,68,0.3)]">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-header font-black tracking-wider text-lg text-white group-hover:text-red-400 transition-colors">
                            ICECREAM <span class="text-red-500 neon-text-red">FRIED</span>
                        </span>
                        <span class="font-tech text-xs tracking-widest text-gray-500 uppercase -mt-1">LEGAL PROTOCOL SPECIFICATION</span>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    <a href="{{ url('/privacy-policy') }}" class="font-tech text-md font-semibold tracking-wider text-gray-400 hover:text-red-400 transition-colors hidden sm:inline-block">
                        PRIVACY POLICY
                    </a>
                    <a href="{{ url('/login') }}" class="clip-cyber-sm px-5 py-2 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white font-header font-bold text-xs tracking-widest transition-all shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                        PORTAL LOGIN
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="relative z-10 flex-grow max-w-4xl mx-auto px-4 sm:px-6 py-12">

            <!-- Title & Metadata Card -->
            <div class="clip-cyber bg-[#0c0303]/90 border border-red-500/20 p-8 mb-10 shadow-[0_0_25px_rgba(239,68,68,0.08)]">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-red-500/10 pb-6 mb-6">
                    <div>
                        <span class="font-header text-xs text-orange-400 font-bold tracking-widest uppercase block mb-1">TERMS OF OPERATION & USAGE</span>
                        <h1 class="font-header text-3xl sm:text-4xl font-black text-white uppercase tracking-wider">
                            TERMS OF <span class="text-red-500 neon-text-red">SERVICE</span>
                        </h1>
                    </div>
                    <div class="text-left sm:text-right font-tech text-sm text-gray-400">
                        <div>PLATFORM: <span class="text-white font-semibold">IceCream Fried Esports</span></div>
                        <div>OPERATOR: <span class="text-white font-semibold">Vidanta Champions Arena</span></div>
                        <div>EFFECTIVE DATE: <span class="text-orange-400 font-semibold">September 10, 2026</span></div>
                    </div>
                </div>

                <p class="text-gray-300 leading-relaxed font-sans text-sm sm:text-base">
                    Welcome to <strong class="text-white">IceCream Fried Esports</strong> (available at <a href="https://ice.vidantaca.com.np" class="text-red-400 hover:underline">https://ice.vidantaca.com.np</a>). By accessing our website, registering an athlete account, or logging into our portal via Google OAuth, you signify your agreement to these Terms of Service. Please read them thoroughly.
                </p>
            </div>

            <!-- Content Sections -->
            <div class="space-y-8 text-gray-300 text-sm sm:text-base leading-relaxed">

                <!-- Section 1 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        1. Acceptance of Terms & Eligibility
                    </h2>
                    <p class="mb-3">
                        By accessing, browsing, or creating an account on IceCream Fried Esports, you represent and warrant that:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li>You have read, understood, and agreed to be bound by these Terms of Service and our <a href="{{ url('/privacy-policy') }}" class="text-red-400 hover:underline font-semibold">Privacy Policy</a>.</li>
                        <li>You are at least 13 years of age, or have obtained verified parental/guardian consent where required by esports governing bodies and local law.</li>
                        <li>All information provided during registration (including in-game handles, contact numbers, and legal verification data) is accurate and truthful.</li>
                    </ul>
                </section>

                <!-- Section 2 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        2. Account Security & Google Authentication
                    </h2>
                    <p class="mb-3">
                        Athletes and administrators can authenticate into the portal via credentials or through Google OAuth 2.0:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li><strong>Credential Confidentiality:</strong> You are strictly responsible for maintaining the confidentiality of your credentials and for all activities that occur under your account handle.</li>
                        <li><strong>Google OAuth Integration:</strong> When connecting your Google account, you authorize us to verify your identity and associate your Google email and avatar with your profile. You may disconnect your Google account at any time within your portal profile settings.</li>
                        <li><strong>Unauthorized Access:</strong> You must promptly notify team administration if you suspect any unauthorized breach or access to your athlete account.</li>
                    </ul>
                </section>

                <!-- Section 3 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        3. Code of Conduct & Competitive Fair Play
                    </h2>
                    <p class="mb-3">
                        As an esports organization, integrity, sportsmanship, and fair play are foundational. You expressly agree NOT to engage in:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li><strong>Cheating & Exploits:</strong> Using third-party unauthorized software, map hacks, aimbots, scripts, or exploiting game glitches during official scrims, ranked matches, or sanctioned tournaments.</li>
                        <li><strong>Match-Fixing:</strong> Participating in match manipulation, betting fraud, intentional feeding, or colluding with opposing squads.</li>
                        <li><strong>Toxic Conduct & Harassment:</strong> Hate speech, harassment, defamation, or derogatory comments targeted at teammates, tournament staff, or competitors.</li>
                        <li><strong>Impersonation:</strong> Creating false accounts or masquerading as another athlete, captain, or Vidanta Arena official.</li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        4. Intellectual Property
                    </h2>
                    <p class="mb-3">
                        All visual assets, proprietary software, cyberpunk graphics, team logos, branding, and match telemetry analytics displayed on IceCream Fried Esports are the intellectual property of IceCream Fried Esports and Vidanta Champions Arena or their respective game publishers.
                    </p>
                    <p>
                        Game titles, character names, and registered game trademarks (such as Mobile Legends: Bang Bang, CS2, Valorant, PUBG Mobile) belong to their respective copyright holders and are referenced for esports descriptive purposes under fair use.
                    </p>
                </section>

                <!-- Section 5 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        5. Termination & Suspension
                    </h2>
                    <p class="mb-3">
                        We reserve the right to suspend or terminate player accounts, revoke portal access, or bench roster members without prior notice if:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li>You violate these Terms of Service or official tournament rules.</li>
                        <li>You engage in conduct that damages the competitive reputation of IceCream Fried Esports or Vidanta Champions Arena.</li>
                        <li>Requested by official esports publishers or anti-cheat bodies.</li>
                    </ul>
                </section>

                <!-- Section 6 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        6. Disclaimers & Limitation of Liability
                    </h2>
                    <p class="mb-3">
                        The platform and services are provided on an "AS IS" and "AS AVAILABLE" basis. While we endeavor to maintain 100% uptime and high security, we make no express warranties that services will be uninterrupted or error-free.
                    </p>
                    <p>
                        To the maximum extent permitted by applicable law, IceCream Fried Esports and its directors, coordinators, and sponsors will not be held liable for indirect, incidental, or consequential damages resulting from your use of the platform.
                    </p>
                </section>

                <!-- Section 7 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        7. Governing Law & Contact Information
                    </h2>
                    <p class="mb-4">
                        These Terms shall be governed by and construed in accordance with the laws of the Federal Democratic Republic of Nepal. Any legal questions or inquiries should be directed to:
                    </p>
                    <div class="bg-black/50 border border-red-500/20 rounded-lg p-5 font-tech text-md space-y-1.5">
                        <div>ORGANIZATION: <span class="text-white font-semibold">IceCream Fried Esports / Vidanta Champions Arena</span></div>
                        <div>WEBSITE: <a href="https://ice.vidantaca.com.np" class="text-red-400 hover:underline">https://ice.vidantaca.com.np</a></div>
                        <div>LEGAL & SUPPORT EMAIL: <a href="mailto:support@vidantaca.com.np" class="text-orange-400 hover:underline font-semibold">support@vidantaca.com.np</a></div>
                        <div>JURISDICTION: <span class="text-gray-300">Kathmandu, Nepal</span></div>
                    </div>
                </section>

            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-black/90 border-t border-red-500/15 py-8 px-6 text-center relative z-20 mt-12">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-tech text-gray-500 text-sm font-medium tracking-wider">
                    &copy; {{ date('Y') }} ICECREAM FRIED x <a href="https://vidantaca.com.np" target="_blank" class="hover:text-red-400 transition-colors underline decoration-red-500/30">VIDANTA CHAMPIONS ARENA</a>. ALL RIGHTS RESERVED.
                </p>
                <div class="flex gap-6 font-tech text-sm font-semibold tracking-wider text-gray-400">
                    <a href="{{ url('/') }}" class="hover:text-red-400 transition-colors">HOME ARENA</a>
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-red-400 transition-colors">PRIVACY POLICY</a>
                    <a href="{{ url('/terms-of-service') }}" class="text-red-400 hover:underline">TERMS OF SERVICE</a>
                </div>
            </div>
        </footer>

    </body>
</html>
