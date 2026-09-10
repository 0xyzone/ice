<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Suspended | IceCream Fried Esports</title>
        <meta name="description" content="Notice regarding deactivated athlete account on IceCream Fried Esports portal.">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-screen flex items-center justify-center relative p-4 selection:bg-orange-500/30 selection:text-white">

        <!-- Ambient Background Glows -->
        <div class="fixed top-1/4 -left-24 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="fixed bottom-1/4 -right-24 w-96 h-96 bg-slate-800/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <!-- Main Wrapper -->
        <div class="relative z-10 w-full max-w-lg my-8">
            
            <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-slate-800/80 shadow-2xl shadow-black/60">

                <!-- Brand Header / Logo -->
                <div class="flex flex-col items-center text-center pb-6 border-b border-slate-800/80 mb-6">
                    <a href="/" class="w-16 h-16 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-center p-2.5 mb-4 shadow-md hover:border-slate-700 transition-colors">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </a>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20 mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        ACCOUNT DEACTIVATED
                    </span>
                    <h1 class="text-2xl font-bold tracking-tight text-white mt-1">
                        Access Denied by Administrator
                    </h1>
                    <p class="text-xs text-slate-400 mt-1.5 max-w-sm">
                        This account is temporarily inactive per organization administrative settings.
                    </p>
                </div>

                <!-- Warning Alert Box -->
                <div class="bg-red-950/20 border border-red-500/20 rounded-2xl p-5 mb-6 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-red-500/10 border border-red-500/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-red-400 block">Status: Inactive</span>
                            <span class="text-sm font-bold text-white">Access Denied by Administrator</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-300 leading-relaxed pt-1">
                        Your account has been set to <strong class="text-red-300 font-medium">inactive</strong> by an administrator. Access to administrative controls, roster management, and player dashboards is paused.
                    </p>
                </div>

                <!-- Explanation / Next Steps -->
                <div class="space-y-3 text-xs text-slate-400 leading-relaxed mb-8 bg-slate-950/40 border border-slate-800/80 rounded-2xl p-5">
                    <h2 class="text-xs font-bold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Reactivation Information
                    </h2>
                    <p class="text-slate-300">
                        If you believe this suspension is in error or you have recently been reinstated, please reach out to the organization head administrator to have your profile restored.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a 
                        href="{{ url('/login') }}" 
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold text-xs tracking-wider uppercase flex items-center justify-center gap-2 shadow-lg shadow-orange-950/30 transition-all text-center"
                    >
                        <span>Return to Login</span>
                    </a>

                    <a 
                        href="mailto:support@vidantaca.com.np?subject=Account%20Reactivation%20Request" 
                        class="w-full py-3 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-medium text-xs tracking-wider uppercase flex items-center justify-center gap-2 transition-all text-center"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Contact Administration</span>
                    </a>
                </div>

                <!-- Footer back-links -->
                <div class="mt-8 pt-6 border-t border-slate-800/80 flex justify-between items-center text-center text-xs text-slate-500">
                    <a href="/" class="hover:text-slate-300 transition-colors flex items-center gap-1">
                        &larr; Back to Homepage
                    </a>
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-slate-300 transition-colors">
                        Privacy Policy
                    </a>
                </div>

            </div>
        </div>

    </body>
</html>
