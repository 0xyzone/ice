<x-filament-widgets::widget>
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-sm font-bold uppercase tracking-wider opacity-75">Active Game Divisions</h3>
            <span class="text-xs opacity-60">Live Database Breakdown</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($divisions as $division)
                <div class="icf-3d-tilt fi-section p-5 space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-orange-500 block">{{ $division['category'] }}</span>
                            <h4 class="text-sm font-bold leading-snug truncate" title="{{ $division['name'] }}">{{ $division['name'] }}</h4>
                        </div>
                        <x-game-logo :game="$division['gameEnum']" size="md" />
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-white/10 text-center">
                        <div>
                            <div class="text-lg font-extrabold">{{ $division['teams'] }}</div>
                            <div class="text-[11px] opacity-65">Teams</div>
                        </div>
                        <div>
                            <div class="text-lg font-extrabold">{{ $division['accounts'] }}</div>
                            <div class="text-[11px] opacity-65">Accounts</div>
                        </div>
                        <div>
                            <div class="text-lg font-extrabold">{{ $division['tournaments'] }}</div>
                            <div class="text-[11px] opacity-65">Events</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
