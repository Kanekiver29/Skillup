{{-- Reusable Input Component
    Usage:
    <x-ui.input name="email" label="Email Address" type="email" icon="fas fa-envelope" placeholder="you@example.com" />
    <x-ui.input name="password" label="Password" type="password" icon="fas fa-lock" required />
    <x-ui.input name="bio" label="Bio" type="textarea" rows="4" />
    <x-ui.input name="role" label="Role" type="select" :options="['admin' => 'Admin', 'student' => 'Student']" />
--}}

@props([
    'name',
    'label' => null,
    'type' => 'text',
    'icon' => null,
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'rows' => 3,
    'options' => [],
    'selected' => null,
])

@php
    $inputClasses = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition';
    $displayValue = old($name, $value);
@endphp

<div>
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
            @if($icon)<i class="{{ $icon }} text-purple-600 mr-2"></i>@endif
            {{ $label }}
            @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    {{-- Textarea --}}
    @if($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
        >{{ $displayValue }}</textarea>

    {{-- Select --}}
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
        >
            <option value="">{{ $placeholder ?: '-- Select --' }}</option>
            @foreach($options as $optVal => $optLabel)
                <option value="{{ $optVal }}" {{ old($name, $selected) == $optVal ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>

    {{-- Standard Input --}}
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $displayValue }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
        >
    @endif

    {{-- Validation Error --}}
    @error($name)
        <p class="text-red-500 text-sm mt-2">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
        </p>
    @enderror
</div>
