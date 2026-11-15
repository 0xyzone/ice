@props([
    'game' => null,
    'size' => 'md',
])

@php
    $resolvedGame = $game instanceof \App\Enums\GameType
        ? $game
        : (is_string($game) ? \App\Enums\GameType::tryFrom($game) : null);

    $sizeClasses = match ($size) {
        'xs' => 'h-4 w-auto max-w-[100px]',
        'sm' => 'h-5 w-auto max-w-[120px]',
        'lg' => 'h-7 w-auto max-w-[150px]',
        'xl' => 'h-9 w-auto max-w-[180px]',
        default => 'h-6 w-auto max-w-[135px]',
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
