@extends('errors.layout')

@section('title', '404 - Map Not Found')
@section('status', 'OBJECTIVE_LOST')

@section('extra_css')
    .radar {
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        border: 2px solid rgba(0, 210, 255, 0.1);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
    .radar::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(from 0deg, rgba(0, 210, 255, 0.4) 0deg, transparent 90deg);
        animation: rotate 4s linear infinite;
    }
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .glitch-code {
        font-size: 12rem;
        font-weight: 900;
        color: transparent;
        -webkit-text-stroke: 2px #00d2ff;
        text-shadow: 0 0 20px rgba(0, 210, 255, 0.5);
    }
@endsection

@section('background')
    <div class="radar"></div>
    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#00d2ff 1px, transparent 1px); background-size: 30px 30px;"></div>
@endsection

@section('content')
    <div class="relative inline-block">
        <h1 class="orbitron glitch-code leading-none">404</h1>
        <div class="absolute -top-4 -right-4 bg-[#00d2ff] text-[#050510] px-2 py-1 orbitron text-xs font-bold">SIGNAL_LOST</div>
    </div>
    
    <h2 class="orbitron text-4xl mt-6 uppercase tracking-widest text-white">Map Location Unknown</h2>
    
    <div class="mt-8 text-lg text-[#b0b0d0] rajdhani max-w-lg mx-auto leading-relaxed">
        Our satellite scans are coming up empty. The coordinates you provided lead to a dead-zone outside the competitive arena.
    </div>
    
    <div class="mt-12 flex flex-col md:flex-row gap-6 justify-center items-center">
        <a href="{{ url('/') }}" class="group relative px-10 py-4 bg-transparent border-2 border-[#00d2ff] text-[#00d2ff] orbitron font-black uppercase tracking-tighter hover:bg-[#00d2ff] hover:text-[#050510] transition-all duration-300">
            <span class="relative z-10">Return to HQ</span>
            <div class="absolute top-0 left-0 w-2 h-2 bg-[#00d2ff]"></div>
            <div class="absolute bottom-0 right-0 w-2 h-2 bg-[#00d2ff]"></div>
        </a>
        <button onclick="window.history.back()" class="orbitron text-xs text-[#00d2ff]/60 hover:text-[#00d2ff] underline underline-offset-4 tracking-widest">
            RE-TRACE_LAST_COORDS
        </button>
    </div>
@endsection
