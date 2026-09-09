<x-filament-widgets::widget>
    <style>
        .pro-widget-card {
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.9) 0%, rgba(11, 15, 23, 0.95) 100%);
            border: 1px solid rgba(51, 65, 85, 0.7);
            border-radius: 20px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .pro-badge {
            background: rgba(249, 115, 22, 0.1);
            color: #fb923c;
            border: 1px solid rgba(249, 115, 22, 0.25);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .pro-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #f97316;
        }
        .pro-title {
            font-size: 24px;
            font-weight: 800;
            color: #f8fafc;
            margin-top: 14px;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }
        .pro-title span {
            color: #f97316;
        }
        .pro-desc {
            color: #94a3b8;
            font-size: 13.5px;
            margin-top: 8px;
            line-height: 1.5;
            max-width: 580px;
        }
        .pro-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 24px;
        }
        @media (max-width: 640px) {
            .pro-stats-grid {
                grid-template-columns: 1fr;
            }
        }
        .pro-stat-box {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(51, 65, 85, 0.6);
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            transition: all 0.2s ease;
        }
        .pro-stat-box:hover {
            border-color: rgba(100, 116, 139, 0.6);
            background: rgba(30, 41, 59, 0.4);
        }
        .pro-stat-label {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
        }
        .pro-stat-value {
            font-size: 24px;
            font-weight: 800;
            margin-top: 4px;
            display: block;
            letter-spacing: -0.02em;
        }
        .val-flame { color: #f97316; }
        .val-sky { color: #38bdf8; }
        .val-emerald { color: #34d399; }

        .pro-btn-wrapper {
            margin-top: 24px;
            display: flex;
            justify-content: flex-start;
        }
        .pro-action-btn {
            background: #f97316;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 22px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.3);
            border: none;
            cursor: pointer;
        }
        .pro-action-btn:hover {
            background: #ea580c;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.45);
        }
        .pro-action-btn svg {
            width: 16px;
            height: 16px;
        }
    </style>

    <div class="pro-widget-card">
        <div style="position: relative; z-index: 2;">
            <span class="pro-badge">Athlete Overview</span>

            <h2 class="pro-title">
                Welcome back, <span>{{ $player->name }}</span>
            </h2>
            <p class="pro-desc">
                Review your tournament records, match stats, and manage your public athlete dossier.
            </p>

            <div class="pro-stats-grid">
                <div class="pro-stat-box">
                    <span class="pro-stat-label">Win Rate</span>
                    <span class="pro-stat-value val-flame">{{ $winRate }}%</span>
                </div>
                <div class="pro-stat-box">
                    <span class="pro-stat-label">Matches</span>
                    <span class="pro-stat-value val-sky">{{ $totalPlayed }}</span>
                </div>
                <div class="pro-stat-box">
                    <span class="pro-stat-label">Victories</span>
                    <span class="pro-stat-value val-emerald">{{ $totalWon }}</span>
                </div>
            </div>

            <div class="pro-btn-wrapper">
                <a href="{{ $profileUrl }}" target="_blank" class="pro-action-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>View Public Profile</span>
                </a>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
