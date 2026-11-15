@props([
    'nested' => false,
])

@php
    $version = app(\App\Services\ChangelogService::class)->currentVersion();
    $changelogUrl = route('changelog');
    $baseClasses = 'fi-version-pill inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold tracking-wide bg-orange-500/15 text-orange-500 dark:text-orange-300 border border-orange-500/30 backdrop-blur-md shadow-sm hover:bg-orange-500/25 hover:border-orange-500/50 transition-all duration-200 whitespace-nowrap cursor-pointer';
@endphp

@if ($nested)
    <span
        role="link"
        tabindex="0"
        title="View Changelog ({{ $version }})"
        onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ $changelogUrl }}';"
        onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); event.stopPropagation(); window.location.href='{{ $changelogUrl }}'; }"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        <span class="fi-version-pill-dot w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
        <span>{{ $version }}</span>
    </span>
@else
    <a
        href="{{ $changelogUrl }}"
        title="View Changelog ({{ $version }})"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        <span class="fi-version-pill-dot w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
        <span>{{ $version }}</span>
    </a>
@endif
