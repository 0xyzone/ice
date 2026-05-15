@extends('errors.layout')

@section('title', '429 - Cooling Down')
@section('status', 'APM_LIMIT_EXCEEDED')

@section('extra_css')
    .snow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
    .frost-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 210, 255, 0.1) 100%);
        box-shadow: inset 0 0 100px rgba(0, 210, 255, 0.2);
        z-index: 2;
    }
    .ice-bar {
        width: 300px;
        height: 10px;
        background: rgba(0, 210, 255, 0.1);
        border: 1px solid #00d2ff;
        margin: 2rem auto;
        position: relative;
        overflow: hidden;
    }
    .ice-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: #00d2ff;
        box-shadow: 0 0 20px #00d2ff;
        animation: cooldown 60s linear forwards;
    }
    @keyframes cooldown {
        from { width: 100%; }
        to { width: 0%; }
    }
@endsection

@section('background')
    <div class="frost-overlay"></div>
    <div class="snow" id="snow"></div>
@endsection

@section('content')
    <div class="orbitron text-7xl font-black text-[#00d2ff] mb-4">429</div>
    <h2 class="orbitron text-3xl uppercase tracking-widest text-white">System Overheating</h2>
    
    <div class="mt-8 max-w-lg mx-auto">
        <p class="rajdhani text-xl text-[#e0e0ff]/80">Your APM (Actions Per Minute) is too high. The server is overheating from your requests.</p>
        
        <div class="ice-bar">
            <div class="ice-fill"></div>
        </div>
        <div class="orbitron text-[10px] text-[#00d2ff] uppercase tracking-widest">Cooling Down...</div>
    </div>
    
    <div class="mt-12">
        <a href="{{ url('/') }}" class="inline-block px-10 py-4 bg-transparent border-2 border-[#00d2ff] text-[#00d2ff] orbitron font-bold uppercase hover:bg-[#00d2ff] hover:text-[#050510] transition-all">
            Slow Down
        </a>
    </div>
@endsection

@section('extra_js')
    <script>
        const snow = document.getElementById('snow');
        for (let i = 0; i < 50; i++) {
            const flake = document.createElement('div');
            flake.style.position = 'absolute';
            flake.style.width = '2px';
            flake.style.height = '2px';
            flake.style.background = '#00d2ff';
            flake.style.top = Math.random() * 100 + '%';
            flake.style.left = Math.random() * 100 + '%';
            flake.style.opacity = Math.random();
            flake.style.boxShadow = '0 0 5px #00d2ff';
            snow.appendChild(flake);
        }
    </script>
@endsection
