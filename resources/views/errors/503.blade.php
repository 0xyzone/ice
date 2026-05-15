@extends('errors.layout')

@section('title', '503 - Respawning')
@section('status', 'MAINTENANCE_MODE')

@section('extra_css')
    .loading-bar-container {
        width: 100%;
        height: 4px;
        background: rgba(112, 0, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    .loading-bar-fill {
        position: absolute;
        height: 100%;
        background: var(--primary-violet);
        box-shadow: 0 0 15px var(--primary-violet);
        width: 30%;
        animation: loading 3s infinite ease-in-out;
    }
    @keyframes loading {
        0% { left: -30%; width: 30%; }
        50% { width: 60%; }
        100% { left: 100%; width: 30%; }
    }
    .respawn-timer {
        font-size: 5rem;
        font-variant-numeric: tabular-nums;
        color: var(--primary-violet);
        text-shadow: 0 0 20px rgba(112, 0, 255, 0.5);
    }
@endsection

@section('background')
    <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
        <svg class="w-[80%] h-[80%] rotate-12" viewBox="0 0 100 100">
            <text x="0" y="50" font-family="Orbitron" font-size="20" fill="currentColor">MAINTENANCE</text>
        </svg>
    </div>
@endsection

@section('content')
    <div class="orbitron text-xs text-[#7000ff] tracking-[10px] mb-4 uppercase">System Calibration</div>
    
    <div class="respawn-timer orbitron font-black mb-8" id="timer">00:59</div>
    
    <div class="max-w-md mx-auto mb-12">
        <div class="loading-bar-container">
            <div class="loading-bar-fill"></div>
        </div>
        <div class="flex justify-between mt-2 orbitron text-[10px] text-[#7000ff]/60 uppercase">
            <span>Updating Assets</span>
            <span>Verifying Shaders</span>
        </div>
    </div>
    
    <h2 class="orbitron text-4xl uppercase tracking-[5px] text-white">Respawn in Progress</h2>
    
    <div class="mt-8 rajdhani text-lg text-[#e0e0ff]/70 max-w-lg mx-auto">
        The arena is undergoing structural reinforcements. All players have been moved to the waiting area. We'll be back online before the next match starts.
    </div>
    
    <div class="mt-12">
        <button onclick="location.reload()" class="px-12 py-4 bg-transparent border border-[#7000ff] text-[#7000ff] orbitron font-bold uppercase hover:bg-[#7000ff] hover:text-white transition-all shadow-[0_0_20px_rgba(112,0,255,0.2)]">
            Check Connection
        </button>
    </div>
@endsection

@section('extra_js')
    <script>
        let seconds = 59;
        function updateTimer() {
            const min = Math.floor(seconds / 60);
            const sec = seconds % 60;
            document.getElementById('timer').innerText = 
                `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
            if (seconds > 0) seconds--;
            else seconds = 59;
        }
        setInterval(updateTimer, 1000);
    </script>
@endsection
