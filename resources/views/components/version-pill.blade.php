@php
    $version = app(\App\Services\ChangelogService::class)->currentVersion();
@endphp

<a
    href="{{ route('changelog') }}"
    title="View Changelog ({{ $version }})"
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-orange-500/15 text-orange-500 dark:text-orange-300 border border-orange-500/30 backdrop-blur-md shadow-sm hover:bg-orange-500/25 hover:border-orange-500/50 transition-all duration-200 whitespace-nowrap',
    ]) }}
>
    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
    <span>{{ $version }}</span>
</a>
