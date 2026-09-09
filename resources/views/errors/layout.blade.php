<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-violet: #8b5cf6;
            --accent-cyan: #38bdf8;
            --error-red: #ef4444;
            --warning-orange: #f59e0b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .orbitron, .font-header {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            font-weight: 700;
        }
        
        .rajdhani, .font-tech {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        @yield('extra_css')
    </style>
</head>
<body class="bg-[#0b0f17] text-slate-200 antialiased overflow-x-hidden min-h-screen flex items-center justify-center relative p-6 selection:bg-orange-500/30 selection:text-white">
    
    <!-- Ambient Background Glow -->
    <div class="fixed top-1/4 -left-20 w-96 h-96 bg-orange-500/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-1/4 -right-20 w-96 h-96 bg-sky-500/5 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    @yield('background')
    
    <!-- Status Bar Top Left -->
    <div class="absolute top-6 left-6 text-xs text-slate-400 z-20 space-y-1 hidden sm:block">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
            <span>IceCream Fried Esports</span>
        </div>
    </div>

    <!-- Status Bar Top Right -->
    <div class="absolute top-6 right-6 text-xs text-slate-400 z-20 text-right space-y-1 hidden sm:block">
        <div>STATUS: <span class="text-orange-400 font-semibold">@yield('status', 'ERROR')</span></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center p-6 md:p-12 max-w-2xl w-full">
        <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl p-8 md:p-12 border border-slate-800/80 shadow-2xl">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-11/12 md:w-4/5 flex justify-between border-t border-slate-800/80 pt-4 z-20 text-xs text-slate-400">
        <div>
            <span>&copy; {{ date('Y') }} IceCream Fried Esports</span>
        </div>
        <div>
            <a href="{{ url('/') }}" class="hover:text-white transition-colors">Return to Home</a>
        </div>
    </div>

    @yield('extra_js')
</body>
</html>
