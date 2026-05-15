@extends('errors.layout')

@section('title', '500 - System Overload')
@section('status', 'HARDWARE_FAILURE')

@section('extra_css')
    @keyframes glitch-bg {
        0% { transform: translate(0); }
        20% { transform: translate(-5px, 5px); }
        40% { transform: translate(-5px, -5px); }
        60% { transform: translate(5px, 5px); }
        80% { transform: translate(5px, -5px); }
        100% { transform: translate(0); }
    }
    .glitch-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 170, 0, 0.05);
        z-index: 1;
        animation: glitch-bg 0.2s infinite;
        pointer-events: none;
        opacity: 0.3;
    }
    .warning-triangle {
        width: 0;
        height: 0;
        border-left: 50px solid transparent;
        border-right: 50px solid transparent;
        border-bottom: 86px solid #ffaa00;
        position: relative;
        margin: 0 auto;
    }
    .warning-triangle::after {
        content: '!';
        position: absolute;
        bottom: -80px;
        left: -5px;
        font-family: 'Orbitron';
        font-weight: 900;
        font-size: 50px;
        color: #050510;
    }
@endsection

@section('background')
    <div class="glitch-overlay"></div>
    <div class="absolute inset-0 overflow-hidden opacity-10">
        @for($i=0; $i<20; $i++)
            <div class="absolute text-[8px] orbitron whitespace-nowrap text-[#ffaa00]" style="top: {{ $i*5 }}%; left: {{ rand(0, 100) }}%; animation: slide {{ rand(5, 15) }}s linear infinite;">
                FATAL_ERROR_AT_OFFSET_0x{{ dechex(rand(1000, 9999)) }} // SYSTEM_HALTED // CORE_DUMP_START...
            </div>
        @endfor
    </div>
    <style>
        @keyframes slide { from { transform: translateX(100%); } to { transform: translateX(-100%); } }
    </style>
@endsection

@section('content')
    <div class="warning-triangle mb-8 scale-150"></div>
    
    <h1 class="orbitron text-7xl font-black text-[#ffaa00] mb-4">500</h1>
    <h2 class="orbitron text-3xl uppercase tracking-widest text-white">Critical Server Defeat</h2>
    
    <div class="mt-8 bg-[#ffaa00]/10 p-6 border border-[#ffaa00]/30 rounded-lg max-w-2xl mx-auto">
        <p class="rajdhani text-xl text-[#e0e0ff]">The server has encountered a hardware malfunction. Our mechanics are currently in a high-stakes clutch to restore the power grid.</p>
        <div class="mt-4 flex gap-2 justify-center">
            @for($i=0; $i<5; $i++)
                <div class="w-12 h-1 bg-[#ffaa00] animate-pulse" style="animation-delay: {{ $i*0.2 }}s"></div>
            @endfor
        </div>
    </div>
    
    <div class="mt-12 flex gap-4 justify-center">
        <a href="{{ url('/') }}" class="px-8 py-3 bg-transparent border-2 border-[#ffaa00] text-[#ffaa00] orbitron font-bold uppercase hover:bg-[#ffaa00] hover:text-[#050510] transition-all">
            Initiate Reboot
        </a>
    </div>
@endsection
