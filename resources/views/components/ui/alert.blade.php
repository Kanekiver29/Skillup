{{-- Reusable Alert Component
    Usage:
    <x-ui.alert type="success">Profile saved successfully!</x-ui.alert>
    <x-ui.alert type="error">Something went wrong.</x-ui.alert>
    <x-ui.alert type="warning" icon="fas fa-exclamation-triangle">Be careful!</x-ui.alert>
    <x-ui.alert type="info" dismissible>This can be dismissed.</x-ui.alert>
    <x-ui.alert type="errors" :errors="$errors" />  {{-- Validation errors --}}
--}}

@props([
    'type' => 'info',
    'icon' => null,
    'dismissible' => false,
    'errors' => null,
])

@php
    $styles = [
        'success' => ['bg' => 'bg-green-50 border-green-200', 'text' => 'text-green-700', 'icon' => 'fas fa-check-circle'],
        'error'   => ['bg' => 'bg-red-50 border-red-200',     'text' => 'text-red-700',   'icon' => 'fas fa-times-circle'],
        'warning' => ['bg' => 'bg-yellow-50 border-yellow-200','text' => 'text-yellow-700','icon' => 'fas fa-exclamation-triangle'],
        'info'    => ['bg' => 'bg-blue-50 border-blue-200',    'text' => 'text-blue-700',  'icon' => 'fas fa-info-circle'],
        'errors'  => ['bg' => 'bg-red-50 border-red-200',      'text' => 'text-red-700',   'icon' => 'fas fa-exclamation-circle'],
    ];

    $style = $styles[$type] ?? $styles['info'];
    $iconClass = $icon ?? $style['icon'];
@endphp

{{-- Validation Errors Variant --}}
@if($type === 'errors' && $errors && $errors->any())
    <div {{ $attributes->merge(['class' => 'mb-6 p-4 border rounded-lg ' . $style['bg']]) }}>
        <p class="font-semibold text-red-800 mb-2">
            <i class="{{ $iconClass }} mr-1"></i>Please fix the following errors:
        </p>
        <ul class="text-red-700 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>&bull; {{ $error }}</li>
            @endforeach
        </ul>
    </div>

{{-- Standard Alert --}}
@elseif($type !== 'errors')
    <div
        {{ $attributes->merge(['class' => 'mb-6 p-4 border rounded-lg flex items-start gap-3 ' . $style['bg']]) }}
        @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif
    >
        <i class="{{ $iconClass }} mt-0.5 {{ $style['text'] }}"></i>
        <div class="flex-1 {{ $style['text'] }}">{{ $slot }}</div>
        @if($dismissible)
            <button @click="show = false" class="{{ $style['text'] }} hover:opacity-70 transition">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
@endif
