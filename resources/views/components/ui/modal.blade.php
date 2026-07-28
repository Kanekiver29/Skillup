{{-- Reusable Modal Component (Alpine.js required)
    Usage:
    <x-ui.modal name="confirm-delete" title="Confirm Delete" maxWidth="md">
        <p>Are you sure you want to delete this item?</p>
        <x-slot:footer>
            <x-ui.button variant="ghost" @click="$dispatch('close-modal', 'confirm-delete')">Cancel</x-ui.button>
            <x-ui.button variant="danger">Delete</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>

    Trigger with: <button @click="$dispatch('open-modal', 'confirm-delete')">Open</button>
--}}

@props([
    'name',
    'title' => null,
    'maxWidth' => 'lg',
    'footer' => null,
])

@php
    $widths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    $width = $widths[$maxWidth] ?? $widths['lg'];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center"
    {{ $attributes }}
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
    ></div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-xl overflow-hidden w-full {{ $width }} mx-4"
    >
        {{-- Header --}}
        @if($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Body --}}
        <div class="p-6">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @if($footer)
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
