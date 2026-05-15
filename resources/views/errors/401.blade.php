@extends('errors.layout')

@section('title', '401 - Identity Required')
@section('status', 'UNAUTHENTICATED')

@section('extra_css')
    .id-card {
        width: 300px;
        height: 180px;
        background: rgba(112, 0, 255, 0.05);
        border: 1px solid rgba(112, 0, 255, 0.3);
        margin: 2rem auto;
        position: relative;
        padding: 1rem;
        text-align: left;
        backdrop-filter: blur(10px);
    }
    .photo-placeholder {
        width: 60px;
        height: 70px;
        background: rgba(112, 0, 255, 0.2);
        border: 1px solid var(--primary-violet);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bar-code {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        height: 40px;
        width: 100px;
        background: repeating-linear-gradient(90deg, #7000ff, #7000ff 2px, transparent 2px, transparent 4px);
        opacity: 0.5;
    }
@endsection

@section('content')
    <div class="orbitron text-xs text-[#7000ff] tracking-[10px] mb-8 uppercase">Identity Verification</div>
    
    <div class="id-card border-r-8">
        <div class="flex gap-4">
            <div class="photo-placeholder">
                <svg class="w-8 h-8 text-[#7000ff]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="space-y-2">
                <div class="h-2 w-32 bg-[#7000ff]/20"></div>
                <div class="h-2 w-24 bg-[#7000ff]/20"></div>
                <div class="h-2 w-40 bg-[#7000ff]/20"></div>
            </div>
        </div>
        <div class="mt-4 orbitron text-[10px] text-[#7000ff]">STATUS: UNKNOWN_USER</div>
        <div class="bar-code"></div>
        <div class="absolute top-0 right-0 p-2 bg-[#7000ff] text-[8px] orbitron text-white">REJECTED</div>
    </div>
    
    <h1 class="orbitron text-4xl font-black text-white mt-8 uppercase tracking-widest">Passport Required</h1>
    
    <div class="mt-8 rajdhani text-lg text-[#e0e0ff]/60 max-w-md mx-auto">
        You are trying to enter a member-only sector as an unidentified guest. Please present your credentials to proceed.
    </div>
    
    <div class="mt-12">
        <a href="{{ route('login') }}" class="inline-block px-12 py-4 bg-[#7000ff] text-white orbitron font-bold uppercase tracking-widest hover:bg-white hover:text-[#7000ff] transition-all">
            Identify Yourself
        </a>
    </div>
@endsection
