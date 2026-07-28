{{-- Reusable Badge Component
    Usage:
    <x-ui.badge>Default</x-ui.badge>
    <x-ui.badge color="green">Active</x-ui.badge>
    <x-ui.badge color="red" icon="fas fa-shield-alt">Admin</x-ui.badge>
    <x-ui.badge variant="dot" color="green">Online</x-ui.badge>
    <x-ui.badge variant="count" color="red">5</x-ui.badge>
--}}

@props([
    'color' => 'indigo',
    'icon' => null,
    'variant' => 'default',
])

@php
    $colorMap = [
        'indigo'  => 'bg-indigo-50 text-indigo-700',
        'purple'  => 'bg-purple-100 text-purple-700',
        'blue'    => 'bg-blue-100 text-blue-700',
        'green'   => 'bg-green-100 text-green-700',
        'red'     => 'bg-red-100 text-red-700',
        'yellow'  => 'bg-yellow-100 text-yellow-700',
        'gray'    => 'bg-gray-100 text-gray-600',
        'pink'    => 'bg-pink-100 text-pink-700',
    ];

    $solidColorMap = [
        'indigo'  => 'bg-indigo-600 text-white',
        'purple'  => 'bg-purple-600 text-white',
        'blue'    => 'bg-blue-600 text-white',
        'green'   => 'bg-green-600 text-white',
        'red'     => 'bg-red-600 text-white',
        'yellow'  => 'bg-yellow-500 text-white',
        'gray'    => 'bg-gray-500 text-white',
    ];

    $dotColors = [
        'green'  => 'bg-green-500',
        'red'    => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'blue'   => 'bg-blue-500',
        'gray'   => 'bg-gray-400',
    ];

    $base = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold';

    $classes = match($variant) {
        'count' => $base . ' ' . ($solidColorMap[$color] ?? $solidColorMap['indigo']),
        default => $base . ' ' . ($colorMap[$color] ?? $colorMap['indigo']),
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($variant === 'dot')
        <span class="w-2 h-2 rounded-full {{ $dotColors[$color] ?? $dotColors['gray'] }}"></span>
    @endif
    @if($icon)
        <i class="{{ $icon }} text-[10px]"></i>
    @endif
    {{ $slot }}
</span>
