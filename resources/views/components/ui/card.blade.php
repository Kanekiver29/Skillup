{{-- Reusable Card Component
    Usage:
    <x-ui.card>Simple content</x-ui.card>
    <x-ui.card hover>Hoverable card</x-ui.card>
    <x-ui.card title="My Card" icon="fas fa-star" padding="p-8">Content</x-ui.card>
    <x-ui.card variant="stat" title="Total Users" value="1,234" icon="fas fa-users" color="blue" />
--}}

@props([
    'variant' => 'default',
    'hover' => false,
    'title' => null,
    'icon' => null,
    'padding' => 'p-6',
    'value' => null,
    'subtitle' => null,
    'color' => 'purple',
])

@php
    $base = 'bg-white rounded-lg shadow-sm border border-gray-100';

    if ($hover) {
        $base .= ' card-hover';
    }

    if ($variant === 'stat') {
        $base .= ' hover:shadow-md transition-shadow';
    }
@endphp

@if($variant === 'stat')
    {{-- Dashboard Stat Card --}}
    <div {{ $attributes->merge(['class' => $base]) }}>
        <div class="{{ $padding }}">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600">{{ $title }}</h3>
                @if($icon)
                    <div class="p-2 bg-{{ $color }}-100 rounded-lg">
                        <i class="{{ $icon }} text-{{ $color }}-600"></i>
                    </div>
                @endif
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $value }}</div>
            @if($subtitle)
                <p class="text-xs text-gray-500 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

@else
    {{-- Default Card --}}
    <div {{ $attributes->merge(['class' => $base]) }}>
        @if($title)
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">
                    @if($icon)<i class="{{ $icon }} text-purple-600 mr-2"></i>@endif
                    {{ $title }}
                </h3>
            </div>
        @endif
        <div class="{{ $padding }}">
            {{ $slot }}
        </div>
    </div>
@endif
