<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Vite (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-violet: #7000ff;
            --secondary-violet: #bc13fe;
            --accent-cyan: #00d2ff;
            --error-red: #ff0055;
            --warning-orange: #ffaa00;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }
        .rajdhani { font-family: 'Rajdhani', sans-serif; }

        /* Scanline Overlay */
        .scanlines::before {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            z-index: 50;
            background-size: 100% 4px, 3px 100%;
            pointer-events: none;
        }

        @keyframes pulse-status {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.95); }
        }
        .status-pulse { animation: pulse-status 2s infinite ease-in-out; }

        @yield('extra_css')
    </style>
</head>
<body class="bg-[#050510] text-[#e0e0ff] rajdhani overflow-hidden h-screen w-screen flex items-center justify-center scanlines">
    
    @yield('background')
    
    <!-- HUD Elements -->
    <div class="absolute top-5 left-5 orbitron text-[10px] md:text-xs opacity-40 z-20 space-y-1">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
            <span>NODE_ACTIVE: {{ request()->ip() }}</span>
        </div>
        <div>[PACKET_LOSS: 0%]</div>
        <div>[ENCRYPTION: AES-256]</div>
    </div>

    <div class="absolute top-5 right-5 orbitron text-[10px] md:text-xs opacity-40 z-20 text-right space-y-1">
        <div class="text-[#00d2ff]">ARENA_SEC: {{ strtoupper(request()->segment(1) ?? 'ROOT') }}</div>
        <div>STATUS: @yield('status', 'CRITICAL_ERROR')</div>
        <div id="clock">00:00:00</div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center p-6 md:p-12 max-w-4xl w-full">
        @yield('content')
    </div>

    <!-- HUD Footer -->
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 w-11/12 md:w-4/5 flex justify-between border-t border-white/10 pt-3 z-20 orbitron text-[8px] md:text-[10px] opacity-30">
        <div class="flex gap-4">
            <span>ICE_CREAM_OS v13.7</span>
            <span class="hidden md:inline">// DIST_V: {{ phpversion() }}</span>
        </div>
        <div class="flex gap-4">
            <span class="animate-pulse">RE-ROUTING...</span>
            <span>PORT_ID: {{ $_SERVER['SERVER_PORT'] ?? '80' }}</span>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toTimeString().split(' ')[0];
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @yield('extra_js')
</body>
</html>
