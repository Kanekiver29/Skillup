@extends('layout.app')

@section('title', ($newsItem->title ?? 'Announcement') . ' — SkillUp')

@section('content')

@php
    $category  = strtolower($newsItem->category ?? 'update');
    $isUrgent  = $category === 'alert' || $category === 'urgent';

    /* ── colour + icon map — identical to news.blade.php ── */
    $colorName = 'cyan';
    $iconPath  = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    $label     = 'Update';

    if ($isUrgent) {
        $colorName = 'rose';
        $iconPath  = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
        $label     = 'Urgent Alert';
    } elseif ($category === 'event') {
        $colorName = 'violet';
        $iconPath  = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
        $label     = 'Event';
    } elseif ($category === 'academic') {
        $colorName = 'blue';
        $iconPath  = 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z';
        $label     = 'Academic';
    }
@endphp

{{-- ══════════════════════════════════════════
     SIGNAL DESIGN SYSTEM — same CSS as news.blade.php
     (tokens, motifs, animations all match the list view)
══════════════════════════════════════════ --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

    .signal-board { --ink: #0B1120; --ink-line: #1E293B; --paper: #F5F6F8; --paper-line: #E4E7EC; }
    .signal-board .font-display { font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif; }
    .signal-board .font-body    { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    .signal-board .font-mono    { font-family: 'JetBrains Mono', ui-monospace, monospace; }

    /* Grid texture — hero backdrop */
    .signal-grid {
        background-image:
            linear-gradient(rgba(148,163,184,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148,163,184,0.06) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 40%, transparent 90%);
    }

    /* Signal bars — shared motif */
    .signal-bars { display: inline-flex; align-items: flex-end; gap: 2.5px; height: 12px; }
    .signal-bars span { display: block; width: 2.5px; border-radius: 1px; background: currentColor; animation: signal-bounce 1.1s ease-in-out infinite; }
    .signal-bars span:nth-child(1) { height: 40%; animation-delay: -0.9s; }
    .signal-bars span:nth-child(2) { height: 100%; animation-delay: -0.6s; }
    .signal-bars span:nth-child(3) { height: 65%;  animation-delay: -0.3s; }
    .signal-bars span:nth-child(4) { height: 85%;  animation-delay:    0s; }
    @keyframes signal-bounce {
        0%, 100% { transform: scaleY(0.35); opacity: 0.6; }
        50%       { transform: scaleY(1);   opacity: 1;   }
    }

    /* Scroll-reveal */
    .reveal { opacity: 0; transform: translateY(18px); transition: opacity 0.6s cubic-bezier(.22,.61,.36,1), transform 0.6s cubic-bezier(.22,.61,.36,1); transition-delay: calc(var(--i, 0) * 80ms); }
    .reveal.is-visible { opacity: 1; transform: translateY(0); }

    /* Accent bar grows in on reveal */
    .accent-bar { transform: scaleY(0); transform-origin: top; transition: transform 0.5s cubic-bezier(.22,.61,.36,1) 0.15s; }
    .reveal.is-visible .accent-bar { transform: scaleY(1); }

    /* Urgent pulse ring */
    @media (prefers-reduced-motion: no-preference) {
        .urgent-pulse::before {
            content: ''; position: absolute; inset: -1px; border-radius: inherit;
            border: 1.5px solid rgba(244,63,94,0.5);
            animation: pulse-ring 2.6s cubic-bezier(.4,0,.6,1) infinite;
            pointer-events: none;
        }
    }
    @keyframes pulse-ring {
        0%   { opacity: 0.55; transform: scale(1);     }
        70%  { opacity: 0;    transform: scale(1.015); }
        100% { opacity: 0;    transform: scale(1.015); }
    }

    /* Arrow link */
    .arrow-link svg { transition: transform 0.25s ease; }
    .arrow-link:hover svg { transform: translateX(3px); }

    /* Back link */
    .back-link { transition: color 0.2s ease, gap 0.2s ease; }
    .back-link svg { transition: transform 0.25s ease; }
    .back-link:hover svg { transform: translateX(-3px); }

    /* Prose content area */
    .article-prose {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 1.0625rem;
        line-height: 1.8;
        color: #374151;
    }
    .article-prose p { margin-bottom: 1.25rem; }

    /* Copy link feedback */
    .copy-btn { transition: background 0.2s, color 0.2s, border-color 0.2s; }
    .copy-btn.copied { background: #f0fdf4; border-color: #86efac; color: #166534; }

    /* Related card hover */
    .related-card { transition: transform 0.3s cubic-bezier(.22,.61,.36,1), box-shadow 0.3s ease; }
    .related-card:hover { transform: translateY(-3px); box-shadow: 0 16px 32px -16px rgba(15,23,42,0.2); }

    @media (prefers-reduced-motion: reduce) {
        .reveal, .accent-bar, .arrow-link svg, .back-link svg, .related-card { transition: none !important; animation: none !important; transform: none !important; opacity: 1 !important; }
        .signal-bars span { animation: none !important; height: 70% !important; }
    }
</style>

<div class="signal-board">

    {{-- ── HERO ── --}}
    <section class="pt-32 pb-20 bg-[var(--ink)] text-white relative overflow-hidden">
        <div class="absolute inset-0 signal-grid"></div>

        <div class="max-w-3xl mx-auto px-4 relative z-10">

            {{-- Back to board --}}
            <a href="{{ route('news.index') }}"
               class="back-link inline-flex items-center gap-2 text-slate-400 hover:text-cyan-300 text-sm font-mono uppercase tracking-wider mb-8 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Announcement Board
            </a>

            {{-- Category badge (matches list-view badge style exactly) --}}
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-{{ $colorName }}-100/10 border border-{{ $colorName }}-500/25 px-3 py-1 text-xs font-bold font-mono text-{{ $colorName }}-300 tracking-wide uppercase">
                    @if($isUrgent)
                        <span class="signal-bars text-{{ $colorName }}-300" style="height:8px;"><span></span><span></span><span></span><span></span></span>
                    @else
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                        </svg>
                    @endif
                    {{ $label }}
                </span>

                @if($newsItem->is_featured)
                <span class="inline-flex items-center gap-1 rounded-full bg-yellow-400/10 border border-yellow-400/25 px-2.5 py-1 text-xs font-bold font-mono text-yellow-300 uppercase tracking-wide">
                    ⭐ Featured
                </span>
                @endif

                {{-- "On Air" indicator --}}
                <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-300 text-xs font-mono uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    On Air
                    <span class="signal-bars text-cyan-300"><span></span><span></span><span></span><span></span></span>
                </span>
            </div>

            {{-- Title --}}
            <h1 class="font-display text-3xl md:text-5xl font-bold tracking-tight leading-tight mb-6">
                {{ $newsItem->title }}
            </h1>

            {{-- Meta row —font-mono, same style as list timestamp --}}
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 font-mono text-xs text-slate-400">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ $newsItem->author->name ?? 'SkillUp Team' }}
                </span>
                @if($newsItem->published_at)
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $newsItem->published_at->format('M d, Y') }}
                    <span class="text-slate-600">({{ $newsItem->published_at->diffForHumans() }})</span>
                </span>
                @endif
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($newsItem->view_count ?? 0) }} views
                </span>
                @if($newsItem->target_audience && $newsItem->target_audience !== 'all')
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ str_replace('_', ' ', ucfirst($newsItem->target_audience)) }}
                </span>
                @else
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                    All Students
                </span>
                @endif
            </div>
        </div>
    </section>

    {{-- ── ARTICLE BODY ── --}}
    <section class="py-14 bg-[var(--paper)] min-h-screen">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Urgent alert banner — matching list-view rose urgent style --}}
            @if($isUrgent)
            <div class="relative overflow-hidden urgent-pulse reveal is-visible flex items-start gap-4 bg-white border-2 border-rose-200 rounded-3xl p-5 mb-8 shadow-sm" style="--i:0">
                <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-rose-500 rounded-l-3xl" style="transform:scaleY(1)"></div>
                <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-rose-50 text-rose-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                    </svg>
                </div>
                <div>
                    <p class="font-display font-bold text-rose-700 text-sm">This is an urgent broadcast.</p>
                    <p class="font-body text-rose-600 text-sm mt-0.5 leading-relaxed">Please read carefully and take any required action immediately.</p>
                </div>
            </div>
            @endif

            {{-- Photos gallery --}}
            @if($newsItem->images->isNotEmpty())
            <div class="reveal relative overflow-hidden mb-8" style="--i:1">
                @if($newsItem->images->count() === 1)
                    <div class="relative overflow-hidden rounded-3xl border border-[var(--paper-line)] shadow-sm">
                        <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500"></div>
                        <img src="{{ asset('storage/' . $newsItem->images->first()->file_path) }}"
                             alt="{{ $newsItem->title }}"
                             class="w-full object-cover max-h-[480px]">
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($newsItem->images as $photo)
                            <div class="relative overflow-hidden rounded-3xl border border-[var(--paper-line)] shadow-sm group" style="aspect-ratio: 4/3;">
                                <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500 z-10"></div>
                                <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank" class="block w-full h-full">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @elseif($newsItem->featured_image)
            {{-- Featured image (backward compatibility) --}}
            <div class="reveal relative overflow-hidden rounded-3xl border border-[var(--paper-line)] mb-8 shadow-sm" style="--i:1">
                <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500"></div>
                <img src="{{ asset('storage/' . $newsItem->featured_image) }}"
                     alt="{{ $newsItem->title }}"
                     class="w-full object-cover max-h-[480px]">
            </div>
            @endif

            {{-- Content card — matches the white card with accent bar from list view --}}
            <div class="reveal relative overflow-hidden rounded-3xl border border-[var(--paper-line)] bg-white shadow-sm" style="--i:{{ $newsItem->featured_image || $newsItem->images->isNotEmpty() ? 2 : 1 }}">
                <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500"></div>
                <div class="px-8 sm:px-10 pt-8 pb-10">

                    {{-- Category chip inside card —— mirrors list-view badge --}}
                    <div class="flex items-center gap-3 mb-6">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-{{ $colorName }}-100 px-2.5 py-0.5 text-xs font-bold text-{{ $colorName }}-700 font-mono tracking-wide uppercase">
                            @if($isUrgent)
                                <span class="signal-bars text-{{ $colorName }}-700" style="height:8px;"><span></span><span></span><span></span><span></span></span>
                            @endif
                            {{ ucfirst($newsItem->category ?? 'Update') }}
                        </span>
                        @if($newsItem->published_at)
                        <span class="text-xs font-mono text-slate-400">{{ $newsItem->published_at->diffForHumans() }}</span>
                        @endif
                    </div>

                    {{-- Body text --}}
                    <div class="article-prose">
                        {!! nl2br(e(strip_tags($newsItem->content))) !!}
                    </div>
                </div>
            </div>

            {{-- Video attachments --}}
            @if($newsItem->videos->isNotEmpty())
                @foreach($newsItem->videos as $index => $video)
                <div class="reveal mt-8" style="--i:{{ 3 + $index * 0.5 }}">
                    <div class="relative overflow-hidden rounded-3xl border border-[var(--paper-line)] bg-white shadow-sm">
                        <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500"></div>
                        <div class="px-8 pt-6 pb-2">
                            <h2 class="font-display text-base font-semibold text-slate-700 flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-{{ $colorName }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Attached Video #{{ $index + 1 }}
                            </h2>
                        </div>
                        <div class="rounded-b-3xl overflow-hidden bg-black">
                            <video controls class="w-full max-h-96 object-contain">
                                <source src="{{ asset('storage/' . $video->file_path) }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
                @endforeach
            @elseif(!empty($newsItem->video_file))
            {{-- Backward compatibility --}}
            <div class="reveal mt-8" style="--i:3">
                <div class="relative overflow-hidden rounded-3xl border border-[var(--paper-line)] bg-white shadow-sm">
                    <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-{{ $colorName }}-500"></div>
                    <div class="px-8 pt-6 pb-2">
                        <h2 class="font-display text-base font-semibold text-slate-700 flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-{{ $colorName }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Attached Video
                        </h2>
                    </div>
                    <div class="rounded-b-3xl overflow-hidden bg-black">
                        <video controls class="w-full max-h-96 object-contain">
                            <source src="{{ asset('storage/' . $newsItem->video_file) }}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            @endif

            {{-- Reaction Bar --}}
            <div class="flex items-center gap-2 mt-8 pt-6 border-t border-[var(--paper-line)]">
                <span class="text-sm font-semibold text-slate-700 mr-2">Reactions:</span>
                @php
                    $userReaction = auth()->check() ? $newsItem->reactions->where('user_id', auth()->id())->first()?->type : null;
                    $reactionCounts = $newsItem->reactions->groupBy('type')->map->count();
                @endphp
                
                <button type="button" onclick="toggleReaction(this, {{ $newsItem->id }}, 'like')" class="reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors {{ $userReaction === 'like' ? 'text-blue-600 bg-blue-50 ring-1 ring-blue-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span class="text-lg">👍</span>
                    <span class="count">{{ $reactionCounts['like'] ?? 0 }}</span>
                </button>
                <button type="button" onclick="toggleReaction(this, {{ $newsItem->id }}, 'heart')" class="reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors {{ $userReaction === 'heart' ? 'text-rose-600 bg-rose-50 ring-1 ring-rose-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span class="text-lg">❤️</span>
                    <span class="count">{{ $reactionCounts['heart'] ?? 0 }}</span>
                </button>
                <button type="button" onclick="toggleReaction(this, {{ $newsItem->id }}, 'care')" class="reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors {{ $userReaction === 'care' ? 'text-amber-600 bg-amber-50 ring-1 ring-amber-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span class="text-lg">🥰</span>
                    <span class="count">{{ $reactionCounts['care'] ?? 0 }}</span>
                </button>
                <button type="button" onclick="toggleReaction(this, {{ $newsItem->id }}, 'sad')" class="reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors {{ $userReaction === 'sad' ? 'text-indigo-600 bg-indigo-50 ring-1 ring-indigo-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span class="text-lg">😢</span>
                    <span class="count">{{ $reactionCounts['sad'] ?? 0 }}</span>
                </button>
            </div>

            {{-- Comments Section --}}
            <div class="reveal mt-12 pt-8 border-t border-[var(--paper-line)]" style="--i:3.5">
                <h3 class="font-display text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Discussion ({{ $newsItem->comments->count() }})
                </h3>

                {{-- Post a comment form --}}
                @auth
                    <form action="{{ route('news.comment', $newsItem->id) }}" method="POST" class="mb-8">
                        @csrf
                        <div class="rounded-2xl border border-[var(--paper-line)] bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-900 focus-within:border-slate-900 transition-all duration-300">
                            <textarea name="body" rows="3" required placeholder="Add to the broadcast..." class="w-full resize-none border-0 p-0 text-slate-800 placeholder-slate-400 focus:ring-0 font-body text-sm" style="outline: none; box-shadow: none;"></textarea>
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-100">
                                <span class="text-xs text-slate-400 font-mono">Posting as {{ auth()->user()->name }}</span>
                                <button type="submit" class="px-4 py-1.5 rounded-full bg-slate-900 text-white font-body text-xs font-semibold hover:bg-slate-850 active:scale-95 transition-all duration-200">
                                    Broadcast Comment
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="rounded-2xl border border-[var(--paper-line)] bg-slate-50 p-6 text-center mb-8">
                        <p class="font-body text-sm text-slate-500">Please <a href="{{ route('login') }}" class="font-semibold text-slate-900 underline hover:text-slate-800">log in</a> to participate in the discussion.</p>
                    </div>
                @endauth

                {{-- Comment List --}}
                <div class="space-y-4">
                    @forelse($newsItem->comments()->with('user')->latest()->get() as $comment)
                        <div class="bg-white p-5 rounded-2xl border border-[var(--paper-line)] shadow-sm">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xs font-mono">
                                        {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-body text-sm font-semibold text-slate-900">{{ $comment->user->name }}</div>
                                        <div class="font-mono text-[10px] text-slate-400">
                                            @if($comment->user->role === 'admin' || $comment->user->is_admin)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-700 ring-1 ring-rose-200/50 uppercase tracking-wider mr-1">Admin</span>
                                            @elseif($comment->user->staff_type)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700 ring-1 ring-amber-200/50 uppercase tracking-wider mr-1">Staff</span>
                                            @endif
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="font-body text-sm text-slate-700 leading-relaxed pl-10 whitespace-pre-line">
                                {{ $comment->body }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-8 rounded-2xl border border-dashed border-slate-200 bg-white">
                            <p class="font-body text-sm text-slate-400">No signals in this discussion yet. Be the first to comment!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ── Footer actions row ── --}}
            <div class="reveal mt-10 flex flex-wrap items-center justify-between gap-4 pt-7 border-t border-[var(--paper-line)]" style="--i:4">

                {{-- Back to board --}}
                <a href="{{ route('news.index') }}"
                   class="arrow-link back-link inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[var(--ink)] text-white font-body text-sm font-medium hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    All Announcements
                </a>

                {{-- Share / copy --}}
                <div class="flex items-center gap-3">
                    <span class="font-mono text-xs text-slate-400 uppercase tracking-wider">Share</span>
                    <button id="copy-btn"
                            onclick="copyLink()"
                            class="copy-btn inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[var(--paper-line)] bg-white text-slate-600 font-body text-sm font-medium hover:border-slate-300 hover:bg-slate-50 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Copy link
                    </button>
                </div>
            </div>

            {{-- ── Related announcements ── --}}
            @if(isset($related) && $related->count())
            <div class="reveal mt-14" style="--i:5">
                <div class="flex items-center gap-3 mb-6">
                    <span class="font-mono text-xs text-slate-400 uppercase tracking-widest">More on this channel</span>
                    <div class="flex-1 h-px bg-[var(--paper-line)]"></div>
                </div>
                <div class="space-y-4">
                    @foreach($related as $rel)
                    @php
                        $relCat    = strtolower($rel->category ?? 'update');
                        $relUrgent = $relCat === 'alert' || $relCat === 'urgent';
                        $relColor  = $relUrgent ? 'rose' : ($relCat === 'event' ? 'violet' : ($relCat === 'academic' ? 'blue' : 'cyan'));
                    @endphp
                    <a href="{{ route('news.show', $rel->id) }}"
                       class="related-card group flex items-center gap-4 bg-white border border-[var(--paper-line)] rounded-2xl px-5 py-4 shadow-sm relative overflow-hidden">
                        <div class="accent-bar absolute top-0 left-0 w-1 h-full bg-{{ $relColor }}-400" style="transform:scaleY(1); transform-origin:top;"></div>
                        <div class="flex-shrink-0 w-9 h-9 rounded-full bg-{{ $relColor }}-50 text-{{ $relColor }}-500 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-display font-semibold text-slate-900 text-sm truncate group-hover:text-{{ $relColor }}-600 transition-colors">{{ $rel->title }}</p>
                            <p class="font-mono text-xs text-slate-400 mt-0.5">{{ optional($rel->published_at ?? $rel->created_at)->diffForHumans() }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-{{ $relColor }}-400 transition-colors arrow-link flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>

</div>

<script>
(function () {
    var reduceMotion = document.documentElement.dataset.skillupReducedMotion === 'true'
        || window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Scroll-reveal — same logic as news.blade.php */
    var revealEls = document.querySelectorAll('.reveal');
    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealEls.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(function (el) { io.observe(el); });
    }
})();

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function () {
        var btn = document.getElementById('copy-btn');
        btn.classList.add('copied');
        btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied!';
        setTimeout(function () {
            btn.classList.remove('copied');
            btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg> Copy link';
        }, 2500);
    });
}

async function toggleReaction(btn, newsId, type) {
    const isGuest = {{ auth()->check() ? 'false' : 'true' }};
    if (isGuest) {
        alert('Please login to react to announcements.');
        return;
    }

    const originalHtml = btn.innerHTML;
    btn.style.opacity = '0.5';

    try {
        const response = await fetch(`/news/${newsId}/react`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ type: type })
        });

        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        // Update counts and styles for all buttons in this row
        const row = btn.closest('.flex');
        const buttons = row.querySelectorAll('.reaction-btn');
        
        const typeMap = {
            'like': { activeClass: 'text-blue-600 bg-blue-50 ring-1 ring-blue-200' },
            'heart': { activeClass: 'text-rose-600 bg-rose-50 ring-1 ring-rose-200' },
            'care': { activeClass: 'text-amber-600 bg-amber-50 ring-1 ring-amber-200' },
            'sad': { activeClass: 'text-indigo-600 bg-indigo-50 ring-1 ring-indigo-200' }
        };

        buttons.forEach(b => {
            // Reset all to default first
            b.className = 'reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors text-slate-500 hover:bg-slate-100 hover:text-slate-800';
            
            // Re-apply active class if needed
            const bType = b.getAttribute('onclick').split("'")[1]; // extract type
            if (data.action !== 'removed' && bType === type) {
                b.className = `reaction-btn p-2 px-3 rounded-full flex items-center gap-2 text-sm font-mono transition-colors ${typeMap[bType].activeClass}`;
            }

            // Update counts
            const countSpan = b.querySelector('.count');
            if (countSpan && data.counts[bType] !== undefined) {
                countSpan.textContent = data.counts[bType];
            }
        });

    } catch (error) {
        console.error('Error toggling reaction:', error);
        alert('An error occurred. Please try again.');
    } finally {
        btn.style.opacity = '1';
    }
}
</script>

@endsection
