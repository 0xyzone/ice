<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Not Found | IceCream Fried Esports</title>
        <meta name="description" content="Notice regarding unregistered athlete account on IceCream Fried Esports portal.">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-screen flex items-center justify-center relative p-4 selection:bg-orange-500/30 selection:text-white">

        <!-- Ambient Background Glows -->
        <div class="fixed top-1/4 -left-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="fixed bottom-1/4 -right-24 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <!-- Main Wrapper -->
        <div class="relative z-10 w-full max-w-lg my-8">
            
            <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-slate-800/80 shadow-2xl shadow-black/60">

                <!-- Brand Header / Logo -->
                <div class="flex flex-col items-center text-center pb-6 border-b border-slate-800/80 mb-6">
                    <a href="/" class="w-16 h-16 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-center p-2.5 mb-4 shadow-md hover:border-slate-700 transition-colors">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </a>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        ACCOUNT NOT FOUND
                    </span>
                    <h1 class="text-2xl font-bold tracking-tight text-white mt-1">
                        Profile Not Yet Provisioned
                    </h1>
                    <p class="text-xs text-slate-400 mt-1.5 max-w-sm">
                        This email address is not associated with an existing athlete or staff profile in our roster database.
                    </p>
                </div>

                <!-- Warning Alert Box -->
                <div class="bg-amber-950/20 border border-amber-500/20 rounded-2xl p-5 mb-6 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-amber-400 block">Roster Verification</span>
                            <span class="text-sm font-bold text-white">Invitation & Roster Required</span>
                        </div>
                    </div>

                    @if (!empty($email))
                        <div class="bg-slate-950/60 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-300 flex items-center justify-between gap-2 break-all">
                            <span class="text-slate-400 text-xs">Attempted Account:</span>
                            <span class="text-amber-300 font-medium font-mono text-xs">{{ $email }}</span>
                        </div>
                    @endif

                    <p class="text-xs text-slate-300 leading-relaxed pt-1">
                        Our athlete management portal is restricted to active team members and staff. An administrator must create your profile before you can sign in.
                    </p>
                </div>

                <!-- Instructions / Next steps -->
                <div class="space-y-3 text-xs text-slate-400 leading-relaxed mb-8 bg-slate-950/40 border border-slate-800/80 rounded-2xl p-5">
                    <h2 class="text-xs font-bold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Next Steps
                    </h2>
                    <ul class="space-y-2 list-disc list-inside text-slate-300">
                        <li>If you are a newly signed player, notify your <strong class="text-white font-medium">Team Captain</strong> or <strong class="text-white font-medium">Admin</strong> to add your email to the roster.</li>
                        <li>Once added, you will be able to log in immediately with your Google account.</li>
                        <li>If you selected the wrong Google account, click below to choose a different one.</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a 
                        href="{{ route('auth.google.redirect', ['prompt' => 'select_account']) }}" 
                        class="w-full py-3.5 rounded-xl bg-linear-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold text-xs tracking-wider uppercase flex items-center justify-center gap-2.5 shadow-lg shadow-orange-950/30 transition-all text-center"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#fff" d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
                        </svg>
                        <span>Select Different Google Account</span>
                    </a>

                    <a 
                        href="{{ url('/login') }}" 
                        class="w-full py-3 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-medium text-xs tracking-wider uppercase flex items-center justify-center gap-2 transition-all text-center"
                    >
                        <span>Return to Login</span>
                    </a>
                </div>

                <!-- Footer back-links -->
                <div class="mt-8 pt-6 border-t border-slate-800/80 flex justify-between items-center text-center text-xs text-slate-500">
                    <a href="/" class="hover:text-slate-300 transition-colors flex items-center gap-1">
                        &larr; Back to Homepage
                    </a>
                    <a href="mailto:support@vidantaca.com.np" class="text-orange-400 hover:text-orange-300 transition-colors font-medium">
                        Contact Support
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
