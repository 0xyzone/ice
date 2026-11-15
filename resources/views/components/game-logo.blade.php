@props([
    'game' => null,
    'size' => 'md',
])

@php
    $resolvedGame = $game instanceof \App\Enums\GameType
        ? $game
        : (is_string($game) ? \App\Enums\GameType::tryFrom($game) : null);

    $sizeConfig = match ($size) {
        'xs' => ['class' => 'h-[18px] w-auto max-w-[84px]', 'style' => 'height: 18px; width: auto; max-width: 84px;'],
        'sm' => ['class' => 'h-[22px] w-auto max-w-[100px]', 'style' => 'height: 22px; width: auto; max-width: 100px;'],
        'lg' => ['class' => 'h-[30px] w-auto max-w-[136px]', 'style' => 'height: 30px; width: auto; max-width: 136px;'],
        'xl' => ['class' => 'h-[38px] w-auto max-w-[164px]', 'style' => 'height: 38px; width: auto; max-width: 164px;'],
        default => ['class' => 'h-[26px] w-auto max-w-[118px]', 'style' => 'height: 26px; width: auto; max-width: 118px;'],
    };
@endphp

@if ($resolvedGame)
    <img
        src="{{ $resolvedGame->getLogoUrl() }}"
        alt="{{ $resolvedGame->getLabel() }}"
        title="{{ $resolvedGame->getLabel() }}"
        style="{{ $sizeConfig['style'] }} object-fit: contain; display: block;"
        {{ $attributes->merge(['class' => "{$sizeConfig['class']} object-contain shrink-0 select-none"]) }}
        loading="lazy"
    />
@endif
