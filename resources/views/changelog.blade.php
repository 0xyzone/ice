<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changelog ({{ $currentVersion }}) | IceCream Fried Esports</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#07070c] text-slate-100 font-['Poppins',sans-serif] antialiased selection:bg-orange-500/30 selection:text-orange-200">
    <!-- Ambient Glass Background Glows -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 left-1/4 w-130 h-130 rounded-full bg-orange-500/15 blur-[130px]"></div>
        <div class="absolute top-1/3 -right-32 w-110 h-110 rounded-full bg-amber-500/10 blur-[130px]"></div>
        <div class="absolute -bottom-40 left-1/3 w-120 h-120 rounded-full bg-indigo-500/10 blur-[140px]"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <!-- Top Navigation Bar -->
        <header class="flex flex-wrap items-center justify-between gap-3 px-4 sm:px-5 py-3 sm:py-3.5 rounded-2xl bg-white/4 backdrop-blur-xl border border-white/10 shadow-xl mb-8 sm:mb-10">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="IceCream Fried Esports Logo" class="h-8 sm:h-9 object-contain">
                <span class="hidden sm:inline text-sm sm:text-base font-bold tracking-tight text-white group-hover:text-orange-400 transition-colors">
                    IceCream Fried
                </span>
            </a>

            <div class="flex items-center gap-2 sm:gap-2.5">
                <x-version-pill />
                <a href="{{ url('/') }}" class="px-3 py-1.5 rounded-xl text-xs font-medium bg-white/5 hover:bg-white/10 border border-white/10 text-slate-200 transition-all">
                    Home
                </a>
                <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-linear-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 text-white shadow-lg shadow-orange-500/25 transition-all">
                    Portal
                </a>
            </div>
        </header>

        <!-- Hero Card -->
        <section class="relative overflow-hidden rounded-3xl bg-white/4.5 backdrop-blur-2xl border border-white/10 p-7 sm:p-9 shadow-2xl mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/15 text-orange-300 border border-orange-500/30 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                        Release History &amp; Updates
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                        System Changelog
                    </h1>
                    <p class="mt-2 text-sm text-slate-400 max-w-xl">
                        Every platform upgrade, UI refinement, and competitive feature synced directly from <code class="px-1.5 py-0.5 rounded bg-white/10 text-orange-300 text-xs">CHANGELOG.md</code>.
                    </p>
                </div>

                <div class="shrink-0 flex flex-col items-start sm:items-end justify-center px-5 py-4 rounded-2xl bg-white/4 border border-white/10">
                    <span class="text-[11px] uppercase tracking-widest text-slate-400 font-semibold">Current Version</span>
                    <span class="mt-1 text-2xl font-extrabold text-orange-400">{{ $currentVersion }}</span>
                    @if (! empty($releases[0]['date']))
                        <span class="mt-0.5 text-xs text-slate-400">Released {{ $releases[0]['date'] }}</span>
                    @endif
                </div>
            </div>
        </section>

        <!-- Releases Timeline -->
        <main class="space-y-6">
            @forelse ($releases as $release)
                <article class="rounded-3xl bg-white/4 backdrop-blur-xl border {{ $release['is_latest'] ? 'border-orange-500/35 shadow-lg shadow-orange-500/10' : 'border-white/10' }} p-6 sm:p-8 transition-all hover:border-white/20">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-5 mb-5 border-b border-white/10">
                        <div class="flex items-center gap-3">
                            <span class="px-3.5 py-1 rounded-full text-sm font-bold {{ $release['is_latest'] ? 'bg-linear-to-r from-orange-600 to-orange-500 text-white shadow-md shadow-orange-500/25' : 'bg-white/10 text-slate-200 border border-white/10' }}">
                                {{ $release['version'] }}
                            </span>
                            @if ($release['is_latest'])
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                                    Latest
                                </span>
                            @endif
                        </div>

                        @if ($release['date'])
                            <time class="text-xs font-medium text-slate-400">
                                {{ \Illuminate\Support\Carbon::parse($release['date'])->format('F j, Y') }}
                            </time>
                        @endif
                    </div>

                    <div class="space-y-5">
                        @foreach ($release['sections'] as $section)
                            @php
                                $badgeClass = match (strtolower($section['type'])) {
                                    'added' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
                                    'changed' => 'bg-amber-500/15 text-amber-300 border-amber-500/30',
                                    'fixed' => 'bg-sky-500/15 text-sky-300 border-sky-500/30',
                                    'removed' => 'bg-rose-500/15 text-rose-300 border-rose-500/30',
                                    default => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
                                };
                            @endphp
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold uppercase tracking-wider border {{ $badgeClass }} mb-2.5">
                                    {{ $section['type'] }}
                                </span>
                                <ul class="space-y-2">
                                    @foreach ($section['items'] as $item)
                                        <li class="flex items-start gap-2.5 text-sm text-slate-300 leading-relaxed">
                                            <span class="mt-2 w-1.5 h-1.5 rounded-full bg-orange-400/80 shrink-0"></span>
                                            <span>{!! $changelog->formatInlineMarkdown($item) !!}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </article>
            @empty
                <div class="rounded-3xl bg-white/[0.04] backdrop-blur-xl border border-white/10 p-10 text-center text-slate-400">
                    No changelog entries found.
                </div>
            @endforelse
        </main>
    </div>
</body>
</html>
