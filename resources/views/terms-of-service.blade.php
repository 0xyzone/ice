<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Terms of Service | IceCream Fried Esports</title>
        <meta name="description" content="Terms of Service for IceCream Fried Esports athlete platform, detailing user responsibilities, platform access, fair play, and account terms.">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-200 font-sans antialiased min-h-screen selection:bg-orange-500/30 selection:text-white flex flex-col">

        <!-- Subtle Ambient Background Glows -->
        <div class="fixed top-0 left-1/4 w-150 h-150 bg-orange-500/5 rounded-full blur-[140px] pointer-events-none -z-10"></div>
        <div class="fixed bottom-0 right-1/4 w-150 h-150 bg-sky-500/5 rounded-full blur-[140px] pointer-events-none -z-10"></div>

        <!-- Top Navigation -->
        <header class="sticky top-0 z-50 bg-[#0b0f17]/90 backdrop-blur-md border-b border-slate-800/80">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center p-2 shadow-sm group-hover:border-slate-700 transition-colors">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold tracking-tight text-lg text-white group-hover:text-orange-400 transition-colors">
                            IceCream <span class="text-orange-500 font-extrabold">Fried</span>
                        </span>
                        <span class="text-[11px] font-medium tracking-wide text-slate-400">Legal Documentation</span>
                    </div>
                </a>

                <nav class="flex items-center gap-6">
                    <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors hidden sm:inline-block">
                        Home
                    </a>
                    <a href="{{ url('/privacy-policy') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors hidden sm:inline-block">
                        Privacy Policy
                    </a>
                    <a href="{{ url('/login') }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-white font-semibold text-xs tracking-wide transition-all shadow-sm">
                        Portal Sign In
                    </a>
                </nav>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="relative z-10 flex-grow max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

            <!-- Title & Metadata Card -->
            <div class="bg-slate-900/70 border border-slate-800/80 rounded-3xl p-8 sm:p-10 mb-10 shadow-xl backdrop-blur-md">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800/80 pb-6 mb-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-400 border border-orange-500/20 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            TERMS OF SERVICE
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                            Terms of Service
                        </h1>
                    </div>
                    <div class="text-left sm:text-right text-xs text-slate-400 space-y-1">
                        <div>Platform: <span class="text-white font-medium">IceCream Fried Esports</span></div>
                        <div>Partner: <span class="text-white font-medium">Vidanta Champions Arena</span></div>
                        <div>Effective Date: <span class="text-orange-400 font-semibold">September 10, 2026</span></div>
                    </div>
                </div>

                <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                    Welcome to <strong class="text-white font-semibold">IceCream Fried Esports</strong> (available at <a href="https://ice.vidantaca.com.np" class="text-orange-400 hover:underline">https://ice.vidantaca.com.np</a>). By accessing our website, registering an athlete profile, or signing in via Google OAuth, you signify your agreement to these Terms of Service. Please read them thoroughly.
                </p>
            </div>

            <!-- Content Sections -->
            <div class="space-y-8 text-slate-300 text-sm sm:text-base leading-relaxed">

                <!-- Section 1 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        1. Acceptance of Terms & Eligibility
                    </h2>
                    <p class="mb-4 text-slate-300">
                        By accessing, browsing, or creating an account on IceCream Fried Esports, you represent and warrant that:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300">
                        <li>You have read, understood, and agreed to be bound by these Terms of Service and our <a href="{{ url('/privacy-policy') }}" class="text-orange-400 hover:underline font-semibold">Privacy Policy</a>.</li>
                        <li>You are at least 13 years of age, or have obtained verified parental/guardian consent where required by esports governing bodies and local law.</li>
                        <li>All information provided during registration (including in-game handles, contact numbers, and legal verification data) is accurate and truthful.</li>
                    </ul>
                </section>

                <!-- Section 2 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        2. Account Security & Google Authentication
                    </h2>
                    <p class="mb-4 text-slate-300">
                        Athletes and administrators can authenticate into the portal via credentials or through Google OAuth 2.0:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300">
                        <li><strong class="text-white">Credential Confidentiality:</strong> You are strictly responsible for maintaining the confidentiality of your credentials and for all activities that occur under your account handle.</li>
                        <li><strong class="text-white">Google OAuth Integration:</strong> When connecting your Google account, you authorize us to verify your identity and associate your Google email and avatar with your profile. You may disconnect your Google account at any time within your portal profile settings.</li>
                        <li><strong class="text-white">Unauthorized Access:</strong> You must promptly notify team administration if you suspect any unauthorized breach or access to your athlete account.</li>
                    </ul>
                </section>

                <!-- Section 3 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        3. Code of Conduct & Competitive Fair Play
                    </h2>
                    <p class="mb-4 text-slate-300">
                        As an esports organization, integrity, sportsmanship, and fair play are foundational. You expressly agree NOT to engage in:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300">
                        <li><strong class="text-white">Cheating & Exploits:</strong> Using third-party unauthorized software, map hacks, aimbots, scripts, or exploiting game glitches during official scrims, ranked matches, or sanctioned tournaments.</li>
                        <li><strong class="text-white">Match-Fixing:</strong> Participating in match manipulation, betting fraud, intentional feeding, or colluding with opposing squads.</li>
                        <li><strong class="text-white">Toxic Conduct & Harassment:</strong> Hate speech, harassment, defamation, or derogatory comments targeted at teammates, tournament staff, or competitors.</li>
                        <li><strong class="text-white">Impersonation:</strong> Creating false accounts or masquerading as another athlete, captain, or tournament official.</li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        4. Intellectual Property
                    </h2>
                    <p class="mb-3 text-slate-300">
                        All visual assets, proprietary software, team logos, branding, and match telemetry analytics displayed on IceCream Fried Esports are the intellectual property of IceCream Fried Esports and Vidanta Champions Arena or their respective game publishers.
                    </p>
                    <p class="text-slate-300">
                        Game titles, character names, and registered game trademarks (such as Mobile Legends: Bang Bang, CS2, Valorant, PUBG Mobile) belong to their respective copyright holders and are referenced for esports descriptive purposes under fair use.
                    </p>
                </section>

                <!-- Section 5 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        5. Termination & Suspension
                    </h2>
                    <p class="mb-4 text-slate-300">
                        We reserve the right to suspend or terminate player accounts, revoke portal access, or bench roster members without prior notice if:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300">
                        <li>You violate these Terms of Service or official tournament rules.</li>
                        <li>You engage in conduct that damages the competitive reputation of IceCream Fried Esports or Vidanta Champions Arena.</li>
                        <li>Requested by official esports publishers or anti-cheat governing bodies.</li>
                    </ul>
                </section>

                <!-- Section 6 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        6. Disclaimers & Limitation of Liability
                    </h2>
                    <p class="mb-3 text-slate-300">
                        The platform and services are provided on an "AS IS" and "AS AVAILABLE" basis. While we endeavor to maintain high reliability and security, we make no express warranties that services will be uninterrupted or error-free.
                    </p>
                    <p class="text-slate-300">
                        To the maximum extent permitted by applicable law, IceCream Fried Esports and its directors, coordinators, and sponsors will not be held liable for indirect, incidental, or consequential damages resulting from your use of the platform.
                    </p>
                </section>

                <!-- Section 7 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        7. Governing Law & Contact Information
                    </h2>
                    <p class="mb-4 text-slate-300">
                        These Terms shall be governed by and construed in accordance with the laws of the Federal Democratic Republic of Nepal. Any legal questions or inquiries should be directed to:
                    </p>
                    <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-5 text-sm space-y-2 text-slate-300">
                        <div><strong class="text-white">Organization:</strong> IceCream Fried Esports / Vidanta Champions Arena</div>
                        <div><strong class="text-white">Website:</strong> <a href="https://ice.vidantaca.com.np" class="text-orange-400 hover:underline">https://ice.vidantaca.com.np</a></div>
                        <div><strong class="text-white">Email:</strong> <a href="mailto:support@vidantaca.com.np" class="text-orange-400 hover:underline font-medium">support@vidantaca.com.np</a></div>
                        <div><strong class="text-white">Location:</strong> Kathmandu, Nepal</div>
                    </div>
                </section>

            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-slate-950 border-t border-slate-800/80 py-8 px-6 text-center relative z-20 mt-16">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-slate-400 text-xs font-medium">
                    &copy; {{ date('Y') }} IceCream Fried Esports &times; <a href="https://vidantaca.com.np" target="_blank" class="hover:text-white transition-colors underline decoration-slate-700">Vidanta Champions Arena</a>. All rights reserved.
                </p>
                <div class="flex gap-6 text-xs font-medium text-slate-400">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="{{ url('/terms-of-service') }}" class="text-orange-400 font-semibold">Terms of Service</a>
                </div>
            </div>
        </footer>

    </body>
</html>
