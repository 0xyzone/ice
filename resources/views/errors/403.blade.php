@extends('errors.layout')

@section('title', '403 - Access Denied')
@section('status', 'SECURITY_BREACH')

@section('extra_css')
    .hex-grid {
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(circle at center, transparent 0%, #050510 70%),
            url("data:image/svg+xml,%3Csvg width='60' height='104' viewBox='0 0 60 104' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l30 17.32v34.64L30 69.28 0 51.96V17.32L30 0zM0 104V86.68L30 69.36l30 17.32V104H0z' fill='%23ff0055' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        z-index: 0;
    }
    .security-ring {
        position: absolute;
        width: 400px;
        height: 400px;
        border: 4px dashed #ff0055;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: spin-slow 20s linear infinite;
        opacity: 0.2;
    }
    @keyframes spin-slow {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
    .scanner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: #ff0055;
        box-shadow: 0 0 15px #ff0055;
        animation: scan 3s ease-in-out infinite;
        z-index: 5;
    }
    @keyframes scan {
        0%, 100% { top: 20%; opacity: 0; }
        50% { top: 80%; opacity: 1; }
    }
@endsection

@section('background')
    <div class="hex-grid"></div>
    <div class="security-ring"></div>
    <div class="scanner"></div>
@endsection

@section('content')
    <div class="relative inline-block mb-8">
        <div class="orbitron text-[10rem] font-black text-[#ff0055] leading-none opacity-20">403</div>
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-32 h-32 text-[#ff0055] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
    </div>
    
    <h2 class="orbitron text-4xl uppercase tracking-[10px] text-white">Access Forbidden</h2>
    
    <div class="mt-8 p-4 bg-[#ff0055]/5 border-l-4 border-[#ff0055] text-left max-w-xl mx-auto">
        <p class="orbitron text-xs text-[#ff0055] mb-2 font-bold">[ENCRYPTION_ALERT]</p>
        <p class="rajdhani text-[#e0e0ff]/80">Your biometric signature does not match the required clearance for this sector. Any further attempts to bypass the firewall will be logged and reported to the tournament administrators.</p>
    </div>
    
    <div class="mt-12">
        <a href="{{ url('/') }}" class="inline-block px-12 py-4 bg-[#ff0055] text-white orbitron font-black uppercase tracking-widest hover:bg-white hover:text-[#ff0055] transition-all duration-300">
            Request Clearance
        </a>
    </div>
@endsection
