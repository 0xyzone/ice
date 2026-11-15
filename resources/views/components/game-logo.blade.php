@props([
    'game' => null,
    'size' => 'md',
])

@php
    $resolvedGame = $game instanceof \App\Enums\GameType
        ? $game
        : (is_string($game) ? \App\Enums\GameType::tryFrom($game) : null);

    $sizeClasses = match ($size) {
        'xs' => 'w-5 h-5',
        'sm' => 'w-6 h-6',
        'lg' => 'w-10 h-10',
        'xl' => 'w-12 h-12',
        default => 'w-7 h-7',
    };
@endphp

@if ($resolvedGame)
    <img
        src="{{ $resolvedGame->getLogoUrl() }}"
        alt="{{ $resolvedGame->getLabel() }}"
        title="{{ $resolvedGame->getLabel() }}"
        {{ $attributes->merge(['class' => "{$sizeClasses} object-contain shrink-0 select-none"]) }}
        loading="lazy"
    />
@endif
