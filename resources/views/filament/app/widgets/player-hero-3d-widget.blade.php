<x-filament-widgets::widget>
    <div class="icf-hero-3d icf-3d-tilt relative overflow-hidden rounded-2xl p-4 sm:p-6 lg:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-6 items-center">
            <div class="lg:col-span-8 space-y-3 sm:space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/15 text-orange-500 dark:text-orange-300 border border-orange-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                        <span>Athlete Portal</span>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/5 border border-white/10">
                        {{ $teamName }}
                    </span>
                </div>

                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Ready to compete, {{ $playerName }}
                    </h2>
                    @if ($username)
                        <p class="mt-1 text-sm opacity-70">{{ '@' . $username }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    @foreach ($metrics as $metric)
                        <div class="rounded-xl px-4 py-3 bg-white/5 border border-white/10 backdrop-blur-md">
                            <div class="text-[11px] uppercase tracking-wider opacity-65 font-semibold">{{ $metric['label'] }}</div>
                            <div class="mt-1 text-xl font-extrabold text-orange-500">{{ $metric['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="hidden lg:flex lg:col-span-4 items-center justify-center">
                <div class="icf-3d-crest-canvas w-44 h-44 sm:w-52 sm:h-52 cursor-grab active:cursor-grabbing" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
