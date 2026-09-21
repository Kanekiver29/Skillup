@extends('layout.app')

@section('title', ($newsItem->title ?? 'Announcement') . ' — SkillUp')

@section('content')

@php
    $category  = strtolower($newsItem->category ?? 'update');
    $isUrgent  = $category === 'alert' || $category === 'urgent';

    $colorName = 'cyan';
    $iconClass = 'fa-info-circle';
    $label     = 'Update';

    if ($isUrgent) {
        $colorName = 'red';
        $iconClass = 'fa-exclamation-triangle';
        $label     = 'Urgent Alert';
    } elseif ($category === 'event') {
        $colorName = 'violet';
        $iconClass = 'fa-calendar-alt';
        $label     = 'Event';
    } elseif ($category === 'academic') {
        $colorName = 'blue';
        $iconClass = 'fa-graduation-cap';
        $label     = 'Academic';
    }

    $colorMap = [
        'cyan'   => ['bg' => 'bg-cyan-500',   'text' => 'text-cyan-400',   'badge' => 'bg-cyan-500/10 text-cyan-300 border-cyan-500/20',   'bar' => 'bg-cyan-500'],
        'red'    => ['bg' => 'bg-red-500',    'text' => 'text-red-400',    'badge' => 'bg-red-500/10 text-red-300 border-red-500/20',       'bar' => 'bg-red-500'],
        'violet' => ['bg' => 'bg-violet-500', 'text' => 'text-violet-400', 'badge' => 'bg-violet-500/10 text-violet-300 border-violet-500/20','bar' => 'bg-violet-500'],
        'blue'   => ['bg' => 'bg-blue-500',   'text' => 'text-blue-400',   'badge' => 'bg-blue-500/10 text-blue-300 border-blue-500/20',     'bar' => 'bg-blue-500'],
    ];
    $colors = $colorMap[$colorName];
@endphp

{{-- ── Hero ── --}}
<section class="pt-32 pb-16 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 text-white relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-1/2 -right-1/4 w-[900px] h-[900px] rounded-full bg-gradient-to-b from-{{ $colorName }}-500/8 to-transparent blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/4 w-[700px] h-[700px] rounded-full bg-gradient-to-t from-slate-800/30 to-transparent blur-3xl"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 relative z-10">

        {{-- Back link --}}
        <a href="{{ url()->previous() === url()->current() ? route('news.index') : url()->previous() }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Announcements
        </a>

        {{-- Category badge --}}
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-sm font-semibold mb-5 {{ $colors['badge'] }}">
            <i class="fas {{ $iconClass }} text-xs"></i>
            {{ $label }}
            @if($newsItem->is_featured)
                <span class="ml-1 px-1.5 py-0.5 rounded-full bg-yellow-500/15 text-yellow-300 border border-yellow-500/20 text-xs font-bold">⭐ Featured</span>
            @endif
        </span>

        {{-- Title --}}
        <h1 class="text-3xl md:text-4xl font-extrabold leading-tight tracking-tight mb-5">
            {{ $newsItem->title }}
        </h1>

        {{-- Meta row --}}
        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-user-circle"></i>
                SkillUp Team
            </span>
            @if($newsItem->published_at)
            <span class="flex items-center gap-1.5">
                <i class="fas fa-clock"></i>
                {{ $newsItem->published_at->format('F d, Y • h:i A') }}
                <span class="text-slate-600 ml-1">({{ $newsItem->published_at->diffForHumans() }})</span>
            </span>
            @endif
            @if($newsItem->target_audience && $newsItem->target_audience !== 'all')
            <span class="flex items-center gap-1.5">
                <i class="fas fa-users"></i>
                {{ str_replace('_', ' ', ucfirst($newsItem->target_audience)) }}
            </span>
            @else
            <span class="flex items-center gap-1.5">
                <i class="fas fa-globe"></i>
                All Students
            </span>
            @endif
            <span class="flex items-center gap-1.5">
                <i class="fas fa-eye"></i>
                {{ number_format($newsItem->view_count ?? 0) }} views
            </span>
        </div>

    </div>
</section>

{{-- ── Article Body ── --}}
<section class="py-14 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">

        {{-- Urgent alert banner --}}
        @if($isUrgent)
        <div class="flex items-start gap-3 bg-red-50 border-l-4 border-red-500 rounded-xl p-5 mb-8 shadow-sm">
            <i class="fas fa-exclamation-triangle text-red-500 text-lg mt-0.5 flex-shrink-0"></i>
            <div>
                <p class="font-bold text-red-800 text-sm">This is an urgent alert.</p>
                <p class="text-red-700 text-sm mt-0.5">Please read carefully and take any required action immediately.</p>
            </div>
        </div>
        @endif

        {{-- Featured image --}}
        @if($newsItem->featured_image)
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-md border border-slate-200">
            <div class="absolute top-0 left-0 w-1 h-full {{ $colors['bar'] }}"></div>
            <img src="{{ asset('storage/' . $newsItem->featured_image) }}"
                 alt="{{ $newsItem->title }}"
                 class="w-full object-cover max-h-[480px]">
        </div>
        @endif

        {{-- Content card --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Colour accent bar --}}
            <div class="h-1 w-full {{ $colors['bar'] }}"></div>
            <div class="p-8 sm:p-10">
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
                    {!! nl2br(e(strip_tags($newsItem->content))) !!}
                </div>
            </div>
        </div>

        {{-- Video attachment --}}
        @if(!empty($newsItem->video_file))
        <div class="mt-8">
            <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                <i class="fas fa-play-circle {{ $colors['text'] }}"></i> Attached Video
            </h2>
            <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-black">
                <video controls class="w-full max-h-96 object-contain">
                    <source src="{{ asset('storage/' . $newsItem->video_file) }}">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        @endif

        {{-- Share / Actions row --}}
        <div class="mt-10 flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-200">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                All Announcements
            </a>
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <span>Share:</span>
                <button onclick="navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'))"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-200 hover:bg-slate-50 transition text-slate-600 hover:text-slate-900">
                    <i class="fas fa-link text-xs"></i> Copy link
                </button>
            </div>
        </div>

    </div>
</section>

@endsection
