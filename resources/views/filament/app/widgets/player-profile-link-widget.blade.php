<x-filament-widgets::widget>
    <style>
        .esports-widget-card {
            background: linear-gradient(135deg, #100a1c 0%, #1c0e29 50%, #0c0817 100%);
            border: 2px solid #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.15), inset 0 0 15px rgba(239, 68, 68, 0.05);
            border-radius: 16px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .esports-widget-card:hover {
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.3), inset 0 0 20px rgba(239, 68, 68, 0.1);
            transform: translateY(-2px);
        }
        .esports-widget-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .esports-badge {
            background: #ef4444;
            color: #000;
            font-family: 'Orbitron', monospace;
            font-weight: 900;
            font-size: 10px;
            letter-spacing: 2px;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-block;
            text-transform: uppercase;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
        }
        .esports-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 26px;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            margin-top: 14px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .esports-title span {
            background: linear-gradient(90deg, #ef4444, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .esports-desc {
            color: #9ca3af;
            font-size: 14px;
            margin-top: 8px;
            line-height: 1.5;
            max-w: 600px;
        }
        .esports-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 24px;
        }
        @media (max-width: 640px) {
            .esports-stats-grid {
                grid-template-columns: 1fr;
            }
        }
        .esports-stat-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(239, 68, 68, 0.12);
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }
        .esports-stat-box:hover {
            background: rgba(239, 68, 68, 0.04);
            border-color: rgba(239, 68, 68, 0.35);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.1);
        }
        .esports-stat-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }
        .esports-stat-value {
            font-size: 26px;
            font-weight: 900;
            margin-top: 6px;
            display: block;
            font-family: 'Orbitron', sans-serif;
        }
        .val-red { color: #ef4444; text-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
        .val-violet { color: #8b5cf6; text-shadow: 0 0 10px rgba(139, 92, 246, 0.5); }
        .val-emerald { color: #10b981; text-shadow: 0 0 10px rgba(16, 185, 129, 0.5); }

        .esports-btn-wrapper {
            margin-top: 26px;
            display: flex;
            justify-content: flex-start;
        }
        .esports-glow-btn {
            background: #ef4444;
            color: #000 !important;
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            font-size: 13px;
            letter-spacing: 2px;
            padding: 14px 30px;
            border-radius: 8px;
            text-decoration: none;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
            transform: skewX(-8deg);
            border: none;
            cursor: pointer;
        }
        .esports-glow-btn:hover {
            background: #f87171;
            box-shadow: 0 0 35px rgba(239, 68, 68, 0.7);
            transform: skewX(-8deg) translateY(-2px);
        }
        .esports-glow-btn:active {
            transform: skewX(-8deg) translateY(0);
        }
        .esports-glow-btn svg {
            width: 16px;
            height: 16px;
            transform: skewX(8deg);
        }
        .esports-glow-btn span {
            display: inline-block;
            transform: skewX(8deg);
        }
    </style>

    <div class="esports-widget-card">
        <div style="position: relative; z-index: 2;">
            <span class="esports-badge">COMPETITIVE AGGREGATE</span>

            <h2 class="esports-title">
                Welcome back, <span>{{ $player->name }}</span>
            </h2>
            <p class="esports-desc">
                Dominate your matches, track tournament brackets, and showcase your achievements to the gaming community.
            </p>

            <div class="esports-stats-grid">
                <div class="esports-stat-box">
                    <span class="esports-stat-label">WIN RATE</span>
                    <span class="esports-stat-value val-red">{{ $winRate }}%</span>
                </div>
                <div class="esports-stat-box">
                    <span class="esports-stat-label">MATCHES</span>
                    <span class="esports-stat-value val-violet">{{ $totalPlayed }}</span>
                </div>
                <div class="esports-stat-box">
                    <span class="esports-stat-label">WINS</span>
                    <span class="esports-stat-value val-emerald">{{ $totalWon }}</span>
                </div>
            </div>

            <div class="esports-btn-wrapper">
                <a href="{{ $profileUrl }}" target="_blank" class="esports-glow-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>VIEW PUBLIC PROFILE</span>
                </a>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
