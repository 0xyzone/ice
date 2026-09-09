<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: -0.01em; color: #f8fafc;">
                Roster Timeline & Milestones
            </span>
        </x-slot>

        <style>
            .clean-timeline {
                position: relative;
                padding-left: 28px;
                margin-top: 16px;
                font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            }
            .clean-timeline::before {
                content: '';
                position: absolute;
                left: 8px;
                top: 6px;
                bottom: 6px;
                width: 2px;
                background: #334155;
            }
            .clean-timeline-item {
                position: relative;
                margin-bottom: 22px;
            }
            .clean-timeline-item:last-child {
                margin-bottom: 0;
            }
            .clean-timeline-dot {
                position: absolute;
                left: -24px;
                top: 4px;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: #0f172a;
                border: 2px solid currentColor;
            }
            .clean-timeline-date {
                font-size: 11px;
                font-weight: 600;
                color: #94a3b8;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }
            .clean-timeline-title {
                font-size: 14px;
                font-weight: 700;
                color: #f1f5f9;
                margin-top: 2px;
            }
            .clean-timeline-desc {
                font-size: 12.5px;
                color: #94a3b8;
                margin-top: 3px;
                line-height: 1.5;
            }
            .clean-timeline-desc strong {
                color: #e2e8f0;
            }
            .empty-timeline {
                text-align: center;
                padding: 32px 0;
                color: #94a3b8;
                font-size: 13px;
            }
        </style>

        @if(count($events) > 0)
            <div class="clean-timeline">
                @foreach($events as $event)
                    <div class="clean-timeline-item">
                        <div class="clean-timeline-dot" style="color: {{ $event['color'] }};"></div>
                        <div class="clean-timeline-date">{{ $event['date'] }}</div>
                        <div class="clean-timeline-title">{{ $event['title'] }}</div>
                        <div class="clean-timeline-desc">{!! $event['desc'] !!}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-timeline">
                <svg style="width: 28px; height: 28px; margin: 0 auto 10px; color: #475569;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                No platform milestones or competitive campaigns recorded yet.
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
