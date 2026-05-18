<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <span style="font-family: 'Orbitron', sans-serif; font-weight: 900; letter-spacing: 1px; color: #ef4444;">
                ROSTER TIMELINE & CAMPAIGN MILESTONES
            </span>
        </x-slot>

        <style>
            .cyber-timeline {
                position: relative;
                padding-left: 30px;
                margin-top: 15px;
            }
            .cyber-timeline::before {
                content: '';
                position: absolute;
                left: 9px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: linear-gradient(to bottom, #ef4444 0%, #8b5cf6 50%, rgba(239, 68, 68, 0.1) 100%);
            }
            .cyber-timeline-item {
                position: relative;
                margin-bottom: 24px;
            }
            .cyber-timeline-item:last-child {
                margin-bottom: 0;
            }
            .cyber-timeline-dot {
                position: absolute;
                left: -26px;
                top: 4px;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                box-shadow: 0 0 10px currentColor;
                background: #000;
                border: 2px solid currentColor;
            }
            .cyber-timeline-date {
                font-family: 'Orbitron', monospace;
                font-size: 11px;
                font-weight: 700;
                color: #9ca3af;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .cyber-timeline-title {
                font-size: 14px;
                font-weight: 800;
                color: #fff;
                margin-top: 2px;
            }
            .cyber-timeline-desc {
                font-size: 12px;
                color: #9ca3af;
                margin-top: 4px;
                line-height: 1.4;
            }
            .cyber-timeline-desc strong {
                color: #fff;
            }
            .empty-timeline {
                text-align: center;
                padding: 30px 0;
                color: #9ca3af;
                font-size: 13px;
            }
        </style>

        @if(count($events) > 0)
            <div class="cyber-timeline">
                @foreach($events as $event)
                    <div class="cyber-timeline-item">
                        <div class="cyber-timeline-dot" style="color: {{ $event['color'] }};"></div>
                        <div class="cyber-timeline-date">{{ $event['date'] }}</div>
                        <div class="cyber-timeline-title">{{ $event['title'] }}</div>
                        <div class="cyber-timeline-desc">{!! $event['desc'] !!}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-timeline">
                <svg style="width: 32px; height: 32px; margin: 0 auto 10px; color: #4b5563;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                No platform milestones or competitive campaigns recorded yet.
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
