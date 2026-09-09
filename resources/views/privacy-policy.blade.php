<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Privacy Policy | IceCream Fried Esports</title>
        <meta name="description" content="Privacy Policy for IceCream Fried Esports, including Google OAuth user data handling, data protection policies, and user rights.">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-200 font-sans antialiased min-h-screen selection:bg-orange-500/30 selection:text-white flex flex-col">

        <!-- Subtle Ambient Background Glows -->
        <div class="fixed top-0 left-1/4 w-[600px] h-[600px] bg-orange-500/5 rounded-full blur-[140px] pointer-events-none -z-10"></div>
        <div class="fixed bottom-0 right-1/4 w-[600px] h-[600px] bg-sky-500/5 rounded-full blur-[140px] pointer-events-none -z-10"></div>

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
                    <a href="{{ url('/terms-of-service') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors hidden sm:inline-block">
                        Terms of Service
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
                            PRIVACY &amp; DATA PROTECTION
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                            Privacy Policy
                        </h1>
                    </div>
                    <div class="text-left sm:text-right text-xs text-slate-400 space-y-1">
                        <div>Platform: <span class="text-white font-medium">IceCream Fried Esports</span></div>
                        <div>Partner: <span class="text-white font-medium">Vidanta Champions Arena</span></div>
                        <div>Effective Date: <span class="text-orange-400 font-semibold">September 10, 2026</span></div>
                    </div>
                </div>

                <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                    At <strong class="text-white font-semibold">IceCream Fried Esports</strong> (available at <a href="https://ice.vidantaca.com.np" class="text-orange-400 hover:underline">https://ice.vidantaca.com.np</a>, operated in partnership with <strong class="text-white font-semibold">Vidanta Champions Arena</strong>), we take the security, privacy, and integrity of our athletes', players', and visitors' personal data seriously. This Privacy Policy details the exact types of information we collect, how we securely store and process it, and how your rights are strictly respected—including our adherence to the <strong class="text-white font-semibold">Google API Services User Data Policy</strong>.
                </p>
            </div>

            <!-- Content Sections -->
            <div class="space-y-8 text-slate-300 text-sm sm:text-base leading-relaxed">

                <!-- Section 1 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        1. Information We Collect
                    </h2>
                    <p class="mb-4 text-slate-300">
                        We collect personal information when you interact with our esports platform, register as an athlete, or authenticate using single sign-on:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300">
                        <li><strong class="text-white">Account Information:</strong> Full name, player handle/username, email address, password hash, and assigned team roles (e.g. Player, Captain, Admin).</li>
                        <li><strong class="text-white">Esports & Gaming Telemetry:</strong> In-game player ID (IGN), tournament participations, match statistics (kills, deaths, assists, heroes picked), team membership records, and awards.</li>
                        <li><strong class="text-white">Player Verification Data:</strong> For official roster contracts and tournament compliance in Nepal, verified legal identification records (e.g. citizenship or passport details) provided confidentially by rostered athletes.</li>
                        <li><strong class="text-white">Technical & Session Data:</strong> IP address, browser user-agent, session timestamps, and login cookies necessary to sustain secure authenticated sessions.</li>
                    </ul>
                </section>

                <!-- Section 2: Google OAuth SPECIFIC SECTION (CRITICAL FOR GOOGLE VERIFICATION) -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8 relative overflow-hidden">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-500/10 border border-orange-500/20 rounded-full text-xs font-semibold text-orange-400 mb-3">
                        <span>OAuth 2.0 Integration Disclosure</span>
                    </div>

                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        2. Information Collected via Google OAuth 2.0 Services
                    </h2>

                    <p class="mb-5 text-slate-300">
                        IceCream Fried Esports provides a seamless "Login with Google" option allowing players to link their Google account for unified authentication. When you choose to authenticate via Google OAuth, we strictly request access only to your basic Google profile and email address. Specifically, we access and store:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-5">
                            <span class="text-[11px] font-semibold text-orange-400 uppercase tracking-wider block mb-1">Data Point 01</span>
                            <h3 class="text-sm font-bold text-white mb-1.5">Google Email</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">Used to identify your player profile, match registered email handles, and deliver essential account security notices.</p>
                        </div>
                        <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-5">
                            <span class="text-[11px] font-semibold text-orange-400 uppercase tracking-wider block mb-1">Data Point 02</span>
                            <h3 class="text-sm font-bold text-white mb-1.5">Display Name & Avatar</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">Used to populate your public athlete avatar and player card if no custom photoshoot image has been uploaded.</p>
                        </div>
                        <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-5">
                            <span class="text-[11px] font-semibold text-orange-400 uppercase tracking-wider block mb-1">Data Point 03</span>
                            <h3 class="text-sm font-bold text-white mb-1.5">Unique Google ID</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">A cryptographic identifier allowing one-click recurring authentication without storing your Google password.</p>
                        </div>
                    </div>

                    <!-- Explicit Google Policy statement required by Google Review -->
                    <div class="bg-slate-950/80 border border-orange-500/30 rounded-xl p-5">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Google API Services User Data Policy Compliance Statement
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            IceCream Fried Esports' use and transfer to any other app of information received from Google APIs will adhere to the <a href="https://developers.google.com/terms/api-services-user-data-policy" target="_blank" rel="noopener noreferrer" class="text-orange-400 font-semibold underline hover:text-orange-300">Google API Services User Data Policy</a>, including the <strong>Limited Use</strong> requirements.
                        </p>
                    </div>
                </section>

                <!-- Section 3 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        3. How We Use Your Data
                    </h2>
                    <p class="mb-3 text-slate-300">All collected data is exclusively used for the operation, administration, and integrity of the esports platform:</p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li>To authenticate authorized athletes, team captains, and match coordinators into the team management portal.</li>
                        <li>To display team lineups, official match history, tournament standings, and verified public athlete profiles.</li>
                        <li>To maintain fair play, prevent identity fraud, and verify eligible tournament rosters.</li>
                        <li>To communicate important administrative schedules, match times, and legal notifications.</li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        4. Data Sharing, Disclosure, & No-Sale Commitment
                    </h2>
                    <div class="space-y-3 text-slate-300">
                        <p>
                            <strong class="text-white font-semibold">Absolute No-Sale Guarantee:</strong> We do <strong class="text-white">NOT</strong> sell, rent, monetize, or trade your personal data or Google user data to data brokers, advertisers, or third-party marketing companies under any circumstances.
                        </p>
                        <p>
                            We only disclose data under the following strictly confined conditions:
                        </p>
                        <ul class="list-disc list-inside space-y-1.5 pl-2 text-slate-300">
                            <li><strong>Authorized Tournament Organizers:</strong> Roster verification data (IGN, player name, photo) shared with recognized esports league administrators strictly for tournament registration.</li>
                            <li><strong>Legal Obligations:</strong> Where mandated by applicable national laws, subpoenas, or judicial orders in the Federal Democratic Republic of Nepal.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 5 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        5. Data Storage, Security, & Retention
                    </h2>
                    <p class="mb-3 text-slate-300">
                        Your data is secured through enterprise-standard technical safeguards:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-slate-300">
                        <li>All communications are encrypted in transit using Transport Layer Security (TLS/HTTPS).</li>
                        <li>Passwords and secret credentials are encrypted using industry-standard bcrypt hashing algorithms with high cost factors.</li>
                        <li>Confidential player legal documents are stored in protected, restricted-access storage partitions accessible only by authorized team administrators.</li>
                        <li>Account data is retained for the active duration of your player affiliation and can be purged upon request.</li>
                    </ul>
                </section>

                <!-- Section 6 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        6. User Rights, Data Deletion, & Google Disconnection
                    </h2>
                    <p class="mb-3 text-slate-300">
                        You maintain full control over your personal information:
                    </p>
                    <ul class="list-disc list-inside space-y-2.5 pl-2 text-slate-300 mb-4">
                        <li><strong class="text-white">Unlinking Google Account:</strong> You can disconnect your Google account at any time by logging into the player portal (<a href="{{ url('/app/manage-profile') }}" class="text-orange-400 hover:underline">/app/manage-profile</a>) and clicking "Disconnect Google".</li>
                        <li><strong class="text-white">Revoking Google Permissions:</strong> You may also unilaterally revoke IceCream Fried Esports' access to your Google account at any time via your <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener noreferrer" class="text-orange-400 hover:underline">Google Security Permissions Console</a>.</li>
                        <li><strong class="text-white">Right of Erasure / Account Deletion:</strong> You may request complete erasure of your player record and stored telemetry by contacting our privacy compliance desk.</li>
                    </ul>
                </section>

                <!-- Section 7 -->
                <section class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight mb-4 flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        7. Contact & Privacy Inquiries
                    </h2>
                    <p class="mb-4 text-slate-300">
                        For any questions regarding this Privacy Policy, your personal data, or Google OAuth integration, please contact our data governance team:
                    </p>
                    <div class="bg-slate-950/60 border border-slate-800 rounded-xl p-5 text-sm space-y-2 text-slate-300">
                        <div><strong class="text-white">Entity:</strong> IceCream Fried Esports / Vidanta Champions Arena</div>
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
                    <a href="{{ url('/privacy-policy') }}" class="text-orange-400 font-semibold">Privacy Policy</a>
                    <a href="{{ url('/terms-of-service') }}" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </footer>

    </body>
</html>
