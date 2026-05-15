@extends('errors.layout')

@section('title', '419 - Session Expired')
@section('status', 'IDLE_TIMEOUT')

@section('extra_css')
    .wifi-icon {
        width: 100px;
        height: 100px;
        position: relative;
        margin: 0 auto 2rem;
    }
    .wifi-icon span {
        display: block;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid transparent;
        border-top-color: #bc13fe;
        border-radius: 50%;
        animation: wifi-pulse 2s infinite;
    }
    .wifi-icon span:nth-child(1) { width: 20px; height: 20px; animation-delay: 0s; }
    .wifi-icon span:nth-child(2) { width: 50px; height: 50px; animation-delay: 0.2s; }
    .wifi-icon span:nth-child(3) { width: 80px; height: 80px; animation-delay: 0.4s; }
    
    @keyframes wifi-pulse {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 1; }
    }
    .status-text::after {
        content: '...';
        animation: dots 1.5s infinite;
    }
    @keyframes dots {
        0%, 20% { content: ''; }
        40% { content: '.'; }
        60% { content: '..'; }
        80% { content: '...'; }
    }
@endsection

@section('content')
    <div class="wifi-icon">
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <h1 class="orbitron text-6xl font-black text-[#bc13fe] mb-2">419</h1>
    <h2 class="orbitron text-2xl uppercase tracking-[8px] text-white">AFK KICKED</h2>
    
    <div class="mt-8 mb-12">
        <p class="rajdhani text-2xl text-[#e0e0ff]/80">Your session has timed out due to inactivity.</p>
        <div class="mt-4 orbitron text-sm text-[#bc13fe] status-text">Re-authenticating connection</div>
    </div>
    
    <div class="flex flex-col gap-4 items-center">
        <a href="{{ url()->previous() }}" class="px-10 py-4 bg-[#bc13fe] text-white orbitron font-bold uppercase tracking-widest hover:bg-white hover:text-[#bc13fe] transition-all">
            Join Match Again
        </a>
        <button onclick="location.reload()" class="orbitron text-xs opacity-50 hover:opacity-100 transition-opacity">
            REFRESH_TOKEN_V2
        </button>
    </div>
@endsection
