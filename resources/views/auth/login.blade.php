<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Athlete & Team Portal Login | IceCream Fried Esports</title>
        <meta name="description" content="Sign in to the IceCream Fried Esports player and team portal.">

        <!-- Google Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f17] text-slate-100 font-sans antialiased min-h-screen flex items-center justify-center relative p-4 selection:bg-orange-500/30 selection:text-white">

        <!-- Subtle Ambient Background Glows -->
        <div class="fixed top-1/4 -left-24 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="fixed bottom-1/4 -right-24 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <!-- Main Card Wrapper -->
        <div class="relative z-10 w-full max-w-md my-8">
            
            <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl p-6 sm:p-10 border border-slate-800/80 shadow-2xl shadow-black/60">
                
                <!-- Brand Header -->
                <div class="flex flex-col items-center text-center pb-6 border-b border-slate-800/80 mb-6">
                    <a href="/" class="w-16 h-16 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-center p-2.5 mb-4 shadow-md hover:border-slate-700 transition-colors">
                        <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="max-w-full max-h-full object-contain">
                    </a>
                    <div class="flex flex-wrap items-center justify-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-400 border border-orange-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            ICECREAM FRIED PORTAL
                        </span>
                        <x-version-pill />
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white mt-1">
                        Welcome Back
                    </h1>
                    <p class="text-xs text-slate-400 mt-1.5 max-w-xs">
                        Sign in to access your roster dashboard, match analytics, and tournament credentials.
                    </p>
                </div>

                <!-- Session Status / Errors -->
                @if (session('status'))
                    <div class="mb-5 bg-emerald-950/40 border border-emerald-500/30 rounded-xl p-3.5 text-emerald-300 text-xs font-medium flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-5 bg-red-950/40 border border-red-500/30 rounded-xl p-3.5 text-red-300 text-xs font-medium flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ url('/login') }}" class="space-y-4">
                    @csrf

                    <!-- Identity Login input -->
                    <div>
                        <label for="login" class="text-xs font-semibold text-slate-300 block mb-1.5">
                            Email or Username
                        </label>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            value="{{ old('login') }}" 
                            required 
                            autofocus 
                            placeholder="player@icecream.gg or handle"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-orange-500 text-white rounded-xl px-4 py-3 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition-all shadow-inner"
                        >
                        @error('login')
                            <div class="mt-1.5 text-xs text-red-400 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="text-xs font-semibold text-slate-300 block">
                                Password
                            </label>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="••••••••••••"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-orange-500 text-white rounded-xl px-4 py-3 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition-all shadow-inner"
                        >
                        @error('password')
                            <div class="mt-1.5 text-xs text-red-400 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between text-xs text-slate-400 pt-1 pb-1">
                        <label class="flex items-center gap-2 cursor-pointer hover:text-slate-300 transition-colors select-none">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-900"
                            >
                            <span>Remember this device</span>
                        </label>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-semibold text-sm shadow-lg shadow-orange-950/30 transition-all active:scale-[0.99] cursor-pointer tracking-wider"
                        >
                            SIGN IN &amp; DECRYPT
                        </button>
                    </div>

                </form>

                <!-- Divider -->
                <div class="relative flex py-5 items-center my-1">
                    <div class="flex-grow border-t border-slate-800"></div>
                    <span class="flex-shrink mx-3 text-xs font-medium text-slate-500">Or continue with</span>
                    <div class="flex-grow border-t border-slate-800"></div>
                </div>

                <!-- Google OAuth Button -->
                <div>
                    <a 
                        href="{{ route('auth.google.redirect') }}" 
                        class="w-full py-3 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-200 hover:text-white font-medium text-sm flex items-center justify-center gap-3 transition-all cursor-pointer shadow-sm"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.02h3.86c2.26-2.09 3.68-5.17 3.68-9.12z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3.02c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.29v3.12C3.26 21.36 7.37 24 12 24z"/>
                            <path fill="#FBBC05" d="M5.27 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.61H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.39l3.98-3.12z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.37 0 3.26 2.64 1.29 6.61l3.98 3.12c.95-2.85 3.6-4.98 6.73-4.98z"/>
                        </svg>
                        <span>Sign In with Google</span>
                    </a>
                </div>

                <!-- Footer back-links -->
                <div class="mt-8 pt-6 border-t border-slate-800/80 flex flex-col items-center justify-center gap-2.5 text-center">
                    <a href="/" class="text-xs font-medium text-slate-400 hover:text-white transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Official Homepage
                    </a>
                    <div class="flex items-center gap-3 text-xs text-slate-500">
                        <a href="{{ url('/privacy-policy') }}" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                        <span>&bull;</span>
                        <a href="{{ url('/terms-of-service') }}" class="hover:text-slate-400 transition-colors">Terms of Service</a>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
