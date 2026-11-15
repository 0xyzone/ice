<x-filament-widgets::widget>
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-sm font-bold uppercase tracking-wider opacity-75">My Registered Game Accounts</h3>
            <a href="{{ \App\Filament\App\Resources\GameInfos\GameInfoResource::getUrl('index', panel: 'app') }}" class="text-xs font-semibold text-orange-500 hover:underline">
                Manage Games &rarr;
            </a>
        </div>

        @if (count($accounts))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($accounts as $account)
                    <div class="icf-3d-tilt fi-section p-5 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-500/15 text-orange-500 border border-orange-500/30">
                                {{ $account['short'] }}
                            </span>
                            <span class="text-xs opacity-65 font-mono">ID: {{ $account['uid'] }}</span>
                        </div>

                        <div>
                            <div class="text-base font-bold">{{ $account['ign'] }}</div>
                            <div class="text-xs opacity-70">{{ $account['game'] }}</div>
                        </div>

                        @if (count($account['roles']))
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                @foreach ($account['roles'] as $role)
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-white/5 border border-white/10">
                                        {{ $role }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="fi-section p-6 text-center text-sm opacity-70">
                No active game accounts linked yet. Add your MLBB, PUBG Mobile, or Free Fire credentials under <strong>My Games</strong>.
            </div>
        @endif
    </div>
</x-filament-widgets::widget>
