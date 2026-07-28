{{-- Reusable Button Component
    Usage:
    <x-ui.button>Default</x-ui.button>
    <x-ui.button variant="primary" icon="fas fa-save">Save</x-ui.button>
    <x-ui.button variant="secondary" size="sm">Small</x-ui.button>
    <x-ui.button variant="outline" href="/link">Link Button</x-ui.button>
    <x-ui.button variant="danger" type="submit">Delete</x-ui.button>
    <x-ui.button variant="filter" :active="true">Active Filter</x-ui.button>
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'href' => null,
    'active' => false,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center font-semibold rounded-lg transition transform focus:outline-none focus:ring-2 focus:ring-purple-200';

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];

    $variants = [
        'primary'   => 'gradient-primary text-white hover:shadow-lg hover:scale-105',
        'secondary' => 'gradient-secondary text-white hover:opacity-90 shadow-md',
        'success'   => 'gradient-success text-white hover:shadow-lg hover:scale-105',
        'danger'    => 'bg-red-600 text-white hover:bg-red-700 hover:shadow-lg',
        'outline'   => 'bg-white border border-gray-300 text-gray-700 hover:border-purple-400 hover:text-purple-600',
        'ghost'     => 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800',
        'filter'    => $active
            ? 'bg-purple-600 text-white'
            : 'bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600',
        'admin'     => 'gradient-admin text-white hover:shadow-lg hover:scale-105',
    ];

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);

    // Filter buttons use rounded-full
    if ($variant === 'filter') {
        $classes .= ' rounded-full text-sm font-medium';
    }
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<i class="{{ $icon }} mr-2"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<i class="{{ $icon }} mr-2"></i>@endif
        {{ $slot }}
    </button>
@endif
