<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Privacy Policy | IceCream Fried Esports</title>
        <meta name="description" content="Privacy Policy for IceCream Fried Esports, including Google OAuth user data handling, data protection policies, and user rights.">

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
                    <a href="{{ url('/terms-of-service') }}" class="font-tech text-md font-semibold tracking-wider text-gray-400 hover:text-red-400 transition-colors hidden sm:inline-block">
                        TERMS OF SERVICE
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
                        <span class="font-header text-xs text-orange-400 font-bold tracking-widest uppercase block mb-1">DATA PROTECTION DIRECTIVE</span>
                        <h1 class="font-header text-3xl sm:text-4xl font-black text-white uppercase tracking-wider">
                            PRIVACY <span class="text-red-500 neon-text-red">POLICY</span>
                        </h1>
                    </div>
                    <div class="text-left sm:text-right font-tech text-sm text-gray-400">
                        <div>APPLICATION: <span class="text-white font-semibold">IceCream Fried Esports</span></div>
                        <div>OPERATOR: <span class="text-white font-semibold">Vidanta Champions Arena</span></div>
                        <div>EFFECTIVE DATE: <span class="text-orange-400 font-semibold">September 10, 2026</span></div>
                    </div>
                </div>

                <p class="text-gray-300 leading-relaxed font-sans text-sm sm:text-base">
                    At <strong class="text-white">IceCream Fried Esports</strong> (available at <a href="https://ice.vidantaca.com.np" class="text-red-400 hover:underline">https://ice.vidantaca.com.np</a>, operated in partnership with <strong class="text-white">Vidanta Champions Arena</strong>), we take the security, privacy, and integrity of our athletes', players', and visitors' personal data seriously. This Privacy Policy details the exact types of information we collect, how we securely store and process it, and how your rights are strictly respected—including our compliance with the <strong class="text-white">Google API Services User Data Policy</strong>.
                </p>
            </div>

            <!-- Content Sections -->
            <div class="space-y-8 text-gray-300 text-sm sm:text-base leading-relaxed">

                <!-- Section 1 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        1. Information We Collect
                    </h2>
                    <p class="mb-3">
                        We collect personal information when you interact with our esports platform, register as an athlete, or authenticate using single sign-on:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li><strong class="text-white">Account Information:</strong> Full name, player handle/username, email address, password hash, and assigned team roles (e.g. Player, Captain, Admin).</li>
                        <li><strong class="text-white">Esports & Gaming Telemetry:</strong> In-game player ID (IGN), tournament participations, match statistics (kills, deaths, assists, heroes picked), team membership records, and awards.</li>
                        <li><strong class="text-white">Player Verification Data:</strong> For official roster contracts and tournament compliance in Nepal, verified legal identification records (e.g. citizenship or passport details) provided confidentially by rostered athletes.</li>
                        <li><strong class="text-white">Technical & Session Data:</strong> IP address, browser user-agent, session timestamps, and login cookies necessary to sustain secure authenticated sessions.</li>
                    </ul>
                </section>

                <!-- Section 2: Google OAuth SPECIFIC SECTION (CRITICAL FOR GOOGLE VERIFICATION) -->
                <section class="bg-[#0c0303]/70 border border-red-500/30 rounded-xl p-6 sm:p-8 relative overflow-hidden shadow-[0_0_20px_rgba(239,68,68,0.1)]">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-950/40 border border-red-500/30 rounded-full text-xs font-tech font-bold text-orange-400 tracking-wider uppercase mb-3">
                        <span>OAUTH 2.0 INTEGRATION DISCLOSURE</span>
                    </div>

                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        2. Information Collected via Google OAuth 2.0 Services
                    </h2>

                    <p class="mb-4">
                        IceCream Fried Esports provides a seamless "Login with Google" option allowing players to link their Google account for unified authentication. When you choose to authenticate via Google OAuth, we strictly request access only to your basic Google profile and email address. Specifically, we access and store:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                        <div class="bg-black/50 border border-red-500/20 rounded-lg p-4">
                            <span class="font-tech text-xs text-orange-400 font-bold uppercase block">DATA POINT 01</span>
                            <h3 class="font-header text-sm font-bold text-white mb-1">Google Email</h3>
                            <p class="text-xs text-gray-400">Used to identify your player profile, match registered email handles, and deliver essential account security notices.</p>
                        </div>
                        <div class="bg-black/50 border border-red-500/20 rounded-lg p-4">
                            <span class="font-tech text-xs text-orange-400 font-bold uppercase block">DATA POINT 02</span>
                            <h3 class="font-header text-sm font-bold text-white mb-1">Display Name & Avatar</h3>
                            <p class="text-xs text-gray-400">Used to populate your public athlete avatar and player card if no custom photoshoot image has been uploaded.</p>
                        </div>
                        <div class="bg-black/50 border border-red-500/20 rounded-lg p-4">
                            <span class="font-tech text-xs text-orange-400 font-bold uppercase block">DATA POINT 03</span>
                            <h3 class="font-header text-sm font-bold text-white mb-1">Unique Google ID</h3>
                            <p class="text-xs text-gray-400">A cryptographic identifier allowing one-click recurring authentication without storing your Google password.</p>
                        </div>
                    </div>

                    <!-- Explicit Google Policy statement required by Google Review -->
                    <div class="bg-red-950/30 border border-red-500/40 rounded-lg p-4 sm:p-5 mt-4">
                        <h4 class="font-header text-xs font-bold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Google API Services User Data Policy Compliance Statement
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                            IceCream Fried Esports' use and transfer to any other app of information received from Google APIs will adhere to the <a href="https://developers.google.com/terms/api-services-user-data-policy" target="_blank" rel="noopener noreferrer" class="text-orange-400 font-semibold underline hover:text-orange-300">Google API Services User Data Policy</a>, including the <strong>Limited Use</strong> requirements.
                        </p>
                    </div>
                </section>

                <!-- Section 3 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        3. How We Use Your Data
                    </h2>
                    <p class="mb-3">All collected data is exclusively used for the operation, administration, and integrity of the esports platform:</p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li>To authenticate authorized athletes, team captains, and match coordinators into the team management portal.</li>
                        <li>To display team lineups, official match history, tournament standings, and verified public athlete profiles.</li>
                        <li>To maintain fair play, prevent identity fraud, and verify eligible tournament rosters.</li>
                        <li>To communicate important administrative schedules, match times, and legal notifications.</li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        4. Data Sharing, Disclosure, & No-Sale Commitment
                    </h2>
                    <div class="space-y-3">
                        <p>
                            <strong class="text-white uppercase tracking-wider font-tech text-base">Absolute No-Sale Guarantee:</strong> We do <strong>NOT</strong> sell, rent, monetize, or trade your personal data or Google user data to data brokers, advertisers, or third-party marketing companies under any circumstances.
                        </p>
                        <p>
                            We only disclose data under the following strictly confined conditions:
                        </p>
                        <ul class="list-disc list-inside space-y-1.5 pl-2 text-gray-300">
                            <li><strong>Authorized Tournament Organizers:</strong> Roster verification data (IGN, player name, photo) shared with recognized esports league administrators strictly for tournament registration.</li>
                            <li><strong>Legal Obligations:</strong> Where mandated by applicable national laws, subpoenas, or judicial orders in the Federal Democratic Republic of Nepal.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 5 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        5. Data Storage, Security, & Retention
                    </h2>
                    <p class="mb-3">
                        Your data is secured through enterprise-standard technical safeguards:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300">
                        <li>All communications are encrypted in transit using Transport Layer Security (TLS/HTTPS).</li>
                        <li>Passwords and secret credentials are encrypted using industry-standard bcrypt hashing algorithms with high cost factors.</li>
                        <li>Confidential player legal documents are stored in protected, restricted-access storage partitions accessible only by authorized team administrators.</li>
                        <li>Account data is retained for the active duration of your player affiliation and can be purged upon request.</li>
                    </ul>
                </section>

                <!-- Section 6 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        6. User Rights, Data Deletion, & Google Disconnection
                    </h2>
                    <p class="mb-3">
                        You maintain full control over your personal information:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-gray-300 mb-4">
                        <li><strong class="text-white">Unlinking Google Account:</strong> You can disconnect your Google account at any time by logging into the player portal (<a href="{{ url('/app/manage-profile') }}" class="text-red-400 hover:underline">/app/manage-profile</a>) and clicking "Disconnect Google".</li>
                        <li><strong class="text-white">Revoking Google Permissions:</strong> You may also unilaterally revoke IceCream Fried Esports' access to your Google account at any time via your <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener noreferrer" class="text-orange-400 hover:underline">Google Security Permissions Console</a>.</li>
                        <li><strong class="text-white">Right of Erasure / Account Deletion:</strong> You may request complete erasure of your player record and stored telemetry by contacting our privacy compliance desk.</li>
                    </ul>
                </section>

                <!-- Section 7 -->
                <section class="bg-[#0c0303]/70 border border-red-500/15 rounded-xl p-6 sm:p-8">
                    <h2 class="font-header text-xl font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                        7. Contact & Privacy Inquiries
                    </h2>
                    <p class="mb-4">
                        For any questions regarding this Privacy Policy, your personal data, or Google OAuth integration, please contact our data governance team:
                    </p>
                    <div class="bg-black/50 border border-red-500/20 rounded-lg p-5 font-tech text-md space-y-1.5">
                        <div>ENTITY: <span class="text-white font-semibold">IceCream Fried Esports / Vidanta Champions Arena</span></div>
                        <div>WEBSITE: <a href="https://ice.vidantaca.com.np" class="text-red-400 hover:underline">https://ice.vidantaca.com.np</a></div>
                        <div>SUPPORT & PRIVACY EMAIL: <a href="mailto:support@vidantaca.com.np" class="text-orange-400 hover:underline font-semibold">support@vidantaca.com.np</a></div>
                        <div>LOCATION: <span class="text-gray-300">Kathmandu, Nepal</span></div>
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
                    <a href="{{ url('/privacy-policy') }}" class="text-red-400 hover:underline">PRIVACY POLICY</a>
                    <a href="{{ url('/terms-of-service') }}" class="hover:text-red-400 transition-colors">TERMS OF SERVICE</a>
                </div>
            </div>
        </footer>

    </body>
</html>
