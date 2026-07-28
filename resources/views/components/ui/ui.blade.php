{{-- UI Container / Section Wrapper
    Usage:
    <x-ui.ui>Simple wrapper</x-ui.ui>
    <x-ui.ui variant="form" title="Login" subtitle="Welcome back">Form fields...</x-ui.ui>
    <x-ui.ui variant="section" title="Featured Courses" icon="fas fa-graduation-cap">Grid of cards...</x-ui.ui>
--}}

@props([
    'variant' => 'default',
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'padding' => 'p-8',
])

@if($variant === 'form')
    {{-- Form Card with Gradient Header --}}
    <div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-xl overflow-hidden']) }}>
        @if($title)
            <div class="gradient-primary p-8 text-center">
                @if($icon)<i class="{{ $icon }} text-white text-3xl mb-3"></i>@endif
                <h1 class="text-3xl font-bold text-white mb-2">{{ $title }}</h1>
                @if($subtitle)<p class="text-purple-100">{{ $subtitle }}</p>@endif
            </div>
        @endif
        <div class="{{ $padding }}">
            {{ $slot }}
        </div>
        @isset($footer)
            <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600">
                {{ $footer }}
            </div>
        @endisset
    </div>

@elseif($variant === 'section')
    {{-- Page Section --}}
    <section {{ $attributes->merge(['class' => 'py-16 px-4']) }}>
        <div class="max-w-6xl mx-auto">
            @if($title)
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        @if($icon)<i class="{{ $icon }} text-purple-600 mr-2"></i>@endif
                        {{ $title }}
                    </h2>
                    @if($subtitle)<p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ $subtitle }}</p>@endif
                </div>
            @endif
            {{ $slot }}
        </div>
    </section>

@else
    {{-- Default Wrapper --}}
    <div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-100 ' . $padding]) }}>
        @if($title)
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                @if($icon)<i class="{{ $icon }} text-purple-600 mr-2"></i>@endif
                {{ $title }}
            </h2>
        @endif
        {{ $slot }}
    </div>
@endif
