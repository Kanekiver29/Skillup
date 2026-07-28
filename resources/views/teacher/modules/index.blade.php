@extends('teacher.layouts.master')

@section('title', 'Modules')
@section('page_title', 'Modules')

@section('content')
<style>
/* ── Reset & tokens ───────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; }

:root {
    --bg:           #0F1629;
    --surface:      #1A2540;
    --surface-2:    #212F50;
    --border:       rgba(59,130,246,.18);
    --border-hover: rgba(59,130,246,.45);
    --primary:      #3B82F6;
    --primary-glow: rgba(59,130,246,.25);
    --accent:       #60A5FA;
    --success:      #34D399;
    --warning:      #FBBF24;
    --danger:       #F87171;
    --purple:       #A78BFA;
    --fg:           #F1F5F9;
    --muted:        #94A3B8;
    --radius:       14px;
    --radius-sm:    8px;
    --shadow:       0 4px 24px rgba(0,0,0,.35);
    --shadow-hover: 0 8px 40px rgba(0,0,0,.5);
    --transition:   .25s cubic-bezier(.4,0,.2,1);
}

/* ── Page ─────────────────────────────────────────────────── */
.tm-page {
    padding: 0.25rem 0 2.5rem;
    animation: tmFadeIn .4s ease both;
}
@keyframes tmFadeIn {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Header ───────────────────────────────────────────────── */
.tm-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.tm-header__text h2 {
    margin: 0 0 .3rem;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--fg);
    letter-spacing: -.02em;
}
.tm-header__text p {
    margin: 0;
    color: var(--muted);
    font-size: .93rem;
}

/* ── Breadcrumb ───────────────────────────────────────────── */
.tm-breadcrumb {
    display: flex;
    align-items: center;
    gap: .45rem;
    font-size: .82rem;
    color: var(--muted);
    margin-bottom: .6rem;
}
.tm-breadcrumb a {
    color: var(--accent);
    text-decoration: none;
    transition: color var(--transition);
}
.tm-breadcrumb a:hover { color: var(--fg); }
.tm-breadcrumb svg { opacity: .5; flex-shrink: 0; }

/* ── Summary pills ────────────────────────────────────────── */
.tm-stats {
    display: flex;
    gap: .75rem;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.tm-stat {
    display: flex;
    align-items: center;
    gap: .55rem;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: .45rem 1rem .45rem .65rem;
    font-size: .84rem;
    color: var(--muted);
    animation: tmFadeIn .5s ease both;
}
.tm-stat__dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.tm-stat strong { color: var(--fg); }

/* ── Module list (vertical stack, numbered) ───────────────── */
.tm-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* ── Module card ──────────────────────────────────────────── */
.tm-card {
    position: relative;
    display: flex;
    align-items: stretch;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition:
        transform var(--transition),
        box-shadow var(--transition),
        border-color var(--transition);
    animation: tmCardIn .45s ease both;
}
.tm-card:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-hover);
    border-color: var(--border-hover);
}

/* stagger */
.tm-card:nth-child(1)  { animation-delay:.05s }
.tm-card:nth-child(2)  { animation-delay:.10s }
.tm-card:nth-child(3)  { animation-delay:.15s }
.tm-card:nth-child(4)  { animation-delay:.20s }
.tm-card:nth-child(5)  { animation-delay:.25s }
.tm-card:nth-child(6)  { animation-delay:.30s }
.tm-card:nth-child(7)  { animation-delay:.35s }
.tm-card:nth-child(8)  { animation-delay:.40s }

@keyframes tmCardIn {
    from { opacity:0; transform:translateX(-16px); }
    to   { opacity:1; transform:translateX(0); }
}

/* shimmer */
.tm-card::before {
    content:'';
    position:absolute; inset:0;
    background: linear-gradient(120deg,
        transparent 30%, rgba(59,130,246,.06) 50%, transparent 70%);
    background-size: 200% 100%;
    background-position: -200% 0;
    transition: background-position .65s ease;
    pointer-events: none;
    border-radius: inherit;
}
.tm-card:hover::before { background-position: 200% 0; }

/* left accent stripe (colored per status) */
.tm-card__stripe {
    width: 5px;
    flex-shrink: 0;
    background: var(--stripe, var(--primary));
    border-radius: var(--radius) 0 0 var(--radius);
    opacity: .85;
}

/* order number column */
.tm-card__order {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    flex-shrink: 0;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--muted);
    border-right: 1px solid var(--border);
    background: rgba(0,0,0,.12);
    letter-spacing: -.02em;
    user-select: none;
}

/* body */
.tm-card__body {
    flex: 1;
    min-width: 0;
    padding: 1.15rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: .75rem;
}

/* ── Card top row ─────────────────────────────────────────── */
.tm-card__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.tm-card__title {
    margin: 0 0 .25rem;
    font-size: 1.02rem;
    font-weight: 700;
    color: var(--fg);
    line-height: 1.35;
    letter-spacing: -.01em;
}
.tm-card__desc {
    margin: 0;
    font-size: .865rem;
    color: var(--muted);
    line-height: 1.55;
}
.tm-badge {
    font-size: .73rem;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    padding: .25rem .7rem;
    border-radius: 50px;
    border: 1px solid currentColor;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Tags row ─────────────────────────────────────────────── */
.tm-card__meta {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem;
    align-items: center;
}
.tm-tag {
    font-size: .78rem;
    font-weight: 500;
    color: var(--accent);
    background: rgba(59,130,246,.1);
    border: 1px solid rgba(59,130,246,.2);
    border-radius: 50px;
    padding: .2rem .65rem;
}
.tm-tag--course {
    color: var(--purple);
    background: rgba(167,139,250,.1);
    border-color: rgba(167,139,250,.2);
}
.tm-sep {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--muted);
    opacity:.4;
}

/* ── Metrics row ──────────────────────────────────────────── */
.tm-card__metrics {
    display: flex;
    gap: 1.25rem;
    flex-wrap: wrap;
}
.tm-metric {
    display: flex;
    align-items: center;
    gap: .35rem;
    font-size: .8rem;
    color: var(--muted);
}
.tm-metric svg { opacity: .6; flex-shrink: 0; }
.tm-metric strong { color: var(--fg); }

/* ── Progress bar ─────────────────────────────────────────── */
.tm-card__progress {
    display: flex;
    align-items: center;
    gap: .65rem;
}
.tm-progress-track {
    flex: 1;
    height: 4px;
    background: rgba(255,255,255,.07);
    border-radius: 50px;
    overflow: hidden;
}
.tm-progress-fill {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    width: var(--fill, 0%);
    animation: tmFill .9s cubic-bezier(.4,0,.2,1) both;
    animation-delay: .5s;
}
@keyframes tmFill {
    from { width: 0%; }
    to   { width: var(--fill, 0%); }
}
.tm-progress-pct {
    font-size: .75rem;
    font-weight: 600;
    color: var(--accent);
    white-space: nowrap;
    min-width: 2.5rem;
    text-align: right;
}

/* ── Action row ───────────────────────────────────────────── */
.tm-card__actions {
    display: flex;
    gap: .55rem;
    flex-wrap: wrap;
    align-items: center;
    padding-top: .6rem;
    border-top: 1px solid var(--border);
}
.tm-btn {
    display: inline-flex;
    align-items: center;
    gap: .38rem;
    padding: .5rem .85rem;
    border-radius: var(--radius-sm);
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    background: none;
    transition: all var(--transition);
    white-space: nowrap;
    line-height: 1;
    font-family: inherit;
}
.tm-btn--primary {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 2px 10px var(--primary-glow);
}
.tm-btn--primary:hover {
    background: #2563EB;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px var(--primary-glow);
    color: #fff;
}
.tm-btn--ghost {
    background: var(--surface-2);
    color: var(--fg);
    border: 1px solid var(--border);
}
.tm-btn--ghost:hover {
    background: rgba(255,255,255,.07);
    border-color: var(--border-hover);
    color: var(--fg);
}
.tm-btn--success {
    background: rgba(52,211,153,.12);
    color: var(--success);
    border: 1px solid rgba(52,211,153,.3);
}
.tm-btn--success:hover {
    background: rgba(52,211,153,.2);
    border-color: var(--success);
}
.tm-btn--warning {
    background: rgba(251,191,36,.1);
    color: var(--warning);
    border: 1px solid rgba(251,191,36,.25);
}
.tm-btn--warning:hover {
    background: rgba(251,191,36,.18);
    border-color: var(--warning);
}
.tm-btn--danger {
    background: transparent;
    color: var(--danger);
    border: 1px solid rgba(248,113,113,.22);
    margin-left: auto;
}
.tm-btn--danger:hover {
    background: rgba(248,113,113,.1);
    border-color: var(--danger);
}
.tm-btn svg { flex-shrink: 0; }

/* ── Create button ────────────────────────────────────────── */
.tm-create-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: var(--primary);
    color: #fff;
    padding: .65rem 1.2rem;
    border-radius: var(--radius-sm);
    font-size: .9rem;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 16px var(--primary-glow);
    transition: all var(--transition);
}
.tm-create-btn:hover {
    background: #2563EB;
    transform: translateY(-2px);
    box-shadow: 0 6px 24px var(--primary-glow);
    color: #fff;
}

/* ── Empty state ──────────────────────────────────────────── */
.tm-empty {
    text-align: center;
    padding: 4rem 2rem;
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    background: var(--surface);
    animation: tmFadeIn .5s ease both;
}
.tm-empty__icon { font-size: 3rem; margin-bottom: 1rem; opacity: .5; }
.tm-empty h3 { margin: 0 0 .5rem; font-size: 1.2rem; color: var(--fg); }
.tm-empty p  { margin: 0 0 1.5rem; color: var(--muted); font-size: .93rem; max-width: 360px; margin-inline: auto; }

/* ── Responsive ───────────────────────────────────────────── */
@media (max-width: 600px) {
    .tm-header { flex-direction: column; align-items: flex-start; }
    .tm-card__order { display: none; }
}
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration:.01ms !important; transition-duration:.01ms !important; }
}
</style>

<div class="tm-page">

    {{-- ── Header ── --}}
    <div class="tm-header">
        <div class="tm-header__text">
            @if(isset($course) && $course)
                <div class="tm-breadcrumb">
                    <a href="{{ route('teacher.courses.index') }}">Courses</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>{{ $course->title ?? 'Course' }}</span>
                </div>
            @endif
            <h2>Course Modules</h2>
            <p>Organize lessons and teaching materials for your courses.</p>
        </div>
        <a href="{{ route('teacher.modules.create') }}" class="tm-create-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create module
        </a>
    </div>

    @if(isset($modules) && $modules->count())

        {{-- ── Summary pills ── --}}
        @php
            $published  = $modules->where('is_published', true)->count();
            $drafts     = $modules->where('is_published', false)->count();
            $totalLessons = $modules->sum(fn($m) => $m->lessons_count ?? $m->lessons?->count() ?? 0);
        @endphp
        <div class="tm-stats">
            <div class="tm-stat" style="animation-delay:.05s">
                <span class="tm-stat__dot" style="background:#3B82F6;"></span>
                <strong>{{ $modules->count() }}</strong> {{ Str::plural('module', $modules->count()) }}
            </div>
            <div class="tm-stat" style="animation-delay:.10s">
                <span class="tm-stat__dot" style="background:#34D399;"></span>
                <strong>{{ $published }}</strong> published
            </div>
            <div class="tm-stat" style="animation-delay:.15s">
                <span class="tm-stat__dot" style="background:#94A3B8;"></span>
                <strong>{{ $drafts }}</strong> {{ Str::plural('draft', $drafts) }}
            </div>
            @if($totalLessons > 0)
            <div class="tm-stat" style="animation-delay:.20s">
                <span class="tm-stat__dot" style="background:#FBBF24;"></span>
                <strong>{{ $totalLessons }}</strong> {{ Str::plural('lesson', $totalLessons) }}
            </div>
            @endif
        </div>

        {{-- ── Module list ── --}}
        <div class="tm-list">
            @foreach($modules as $index => $module)
                @php
                    $isPublished  = (bool)($module->is_published ?? false);
                    $lessonCount  = $module->lessons_count ?? $module->lessons?->count() ?? 0;
                    $durationMins = $module->duration_minutes ?? 0;
                    $orderNum     = $module->order ?? ($index + 1);
                    $progress     = min(100, max(0, (int)($module->completion_percent ?? ($lessonCount > 0 ? min(100, $lessonCount * 20) : 0))));
                    $courseName   = $module->course->title ?? (isset($course) ? $course->title : null);

                    $stripe = $isPublished ? '#34D399' : '#3B82F6';
                    $badgeColor = $isPublished ? '#34D399' : '#94A3B8';
                    $badgeLabel = $isPublished ? 'Published' : 'Draft';
                @endphp

                <article class="tm-card" style="--stripe:{{ $stripe }}; --fill:{{ $progress }}%;">
                    <div class="tm-card__stripe"></div>

                    {{-- Order number --}}
                    <div class="tm-card__order">{{ str_pad($orderNum, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="tm-card__body">

                        {{-- Title + badge --}}
                        <div class="tm-card__top">
                            <div style="min-width:0;">
                                <h3 class="tm-card__title">{{ $module->title ?? 'Untitled module' }}</h3>
                                <p class="tm-card__desc">
                                    {{ Str::limit($module->description ?? 'No description added yet.', 130) }}
                                </p>
                            </div>
                            <span class="tm-badge" style="color:{{ $badgeColor }}; border-color:{{ $badgeColor }}33;">
                                {{ $badgeLabel }}
                            </span>
                        </div>

                        {{-- Tags / meta ─ course name + level --}}
                        <div class="tm-card__meta">
                            @if($courseName)
                                <span class="tm-tag tm-tag--course">📚 {{ $courseName }}</span>
                                <span class="tm-sep"></span>
                            @endif
                            @if($module->type ?? false)
                                <span class="tm-tag">{{ $module->type }}</span>
                            @endif
                            @if($module->level ?? false)
                                <span class="tm-tag">{{ $module->level }}</span>
                            @endif
                        </div>

                        {{-- Metrics --}}
                        <div class="tm-card__metrics">
                            <span class="tm-metric">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                <strong>{{ $lessonCount }}</strong>&nbsp;{{ Str::plural('lesson', $lessonCount) }}
                            </span>
                            @if($durationMins > 0)
                            <span class="tm-metric">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <strong>{{ $durationMins }}</strong>&nbsp;min
                            </span>
                            @endif
                            <span class="tm-metric">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                Updated {{ $module->updated_at ? $module->updated_at->diffForHumans(['short'=>true,'parts'=>1]) : '—' }}
                            </span>
                        </div>

                        {{-- Progress bar --}}
                        <div class="tm-card__progress">
                            <div class="tm-progress-track">
                                <div class="tm-progress-fill"></div>
                            </div>
                            <span class="tm-progress-pct">{{ $progress }}%</span>
                        </div>

                        {{-- Actions --}}
                        <div class="tm-card__actions">
                            <a href="{{ route('teacher.modules.edit', $module) }}" class="tm-btn tm-btn--primary">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>

                            @if(Route::has('teacher.lessons.index'))
                            <a href="{{ route('teacher.lessons.index', ['module_id' => $module->id]) }}" class="tm-btn tm-btn--ghost">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                                Lessons
                            </a>
                            @endif

                            @if($isPublished && Route::has('teacher.modules.unpublish'))
                                <form method="POST" action="{{ route('teacher.modules.unpublish', $module) }}" style="display:contents;">
                                    @csrf
                                    <button type="submit" class="tm-btn tm-btn--warning">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                        Unpublish
                                    </button>
                                </form>
                            @elseif(!$isPublished && Route::has('teacher.modules.publish'))
                                <form method="POST" action="{{ route('teacher.modules.publish', $module) }}" style="display:contents;">
                                    @csrf
                                    <button type="submit" class="tm-btn tm-btn--success">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Publish
                                    </button>
                                </form>
                            @endif

                            @if(Route::has('teacher.modules.destroy'))
                            <form method="POST"
                                  action="{{ route('teacher.modules.destroy', $module) }}"
                                  onsubmit="return confirm('Delete \"{{ addslashes($module->title ?? 'this module') }}\"? All lessons inside will be removed.')"
                                  style="display:contents;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tm-btn tm-btn--danger">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>

                    </div>{{-- /.tm-card__body --}}
                </article>
            @endforeach
        </div>

    @else

        {{-- ── Empty state ── --}}
        <div class="tm-empty">
            <div class="tm-empty__icon">🗂️</div>
            <h3>No modules yet</h3>
            <p>Add modules to your courses to start building lessons and assessments.</p>
            <a href="{{ route('teacher.modules.create') }}" class="tm-create-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create your first module
            </a>
        </div>

    @endif
</div>
@endsection