@extends('teacher.layouts.master')

@section('title', 'My Courses')
@section('page_title', 'Courses')

@section('content')
<style>
/* ── Reset & tokens ───────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; }

:root {
    --bg:          #0F1629;
    --surface:     #1A2540;
    --surface-2:   #212F50;
    --border:      rgba(59,130,246,.18);
    --border-hover:rgba(59,130,246,.45);
    --primary:     #3B82F6;
    --primary-glow:rgba(59,130,246,.25);
    --accent:      #60A5FA;
    --success:     #34D399;
    --warning:     #FBBF24;
    --danger:      #F87171;
    --fg:          #F1F5F9;
    --muted:       #94A3B8;
    --muted-2:     #64748B;
    --radius:      14px;
    --radius-sm:   8px;
    --shadow:      0 4px 24px rgba(0,0,0,.35);
    --shadow-hover:0 8px 40px rgba(0,0,0,.5);
    --transition:  .25s cubic-bezier(.4,0,.2,1);
}

/* ── Page wrapper ─────────────────────────────────────────── */
.tc-page {
    padding: 0.25rem 0 2.5rem;
    animation: tcFadeIn .45s ease both;
}
@keyframes tcFadeIn {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Top header row ───────────────────────────────────────── */
.tc-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.tc-header__text h2 {
    margin: 0 0 .3rem;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--fg);
    letter-spacing: -.02em;
}
.tc-header__text p {
    margin: 0;
    color: var(--muted);
    font-size: .93rem;
}

/* ── Summary pill row ─────────────────────────────────────── */
.tc-stats {
    display: flex;
    gap: .75rem;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.tc-stat {
    display: flex;
    align-items: center;
    gap: .55rem;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: .45rem 1rem .45rem .65rem;
    font-size: .84rem;
    color: var(--muted);
    animation: tcFadeIn .5s ease both;
}
.tc-stat__dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.tc-stat strong { color: var(--fg); }

/* ── Course grid ──────────────────────────────────────────── */
.tc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 1.25rem;
}

/* ── Course card ──────────────────────────────────────────── */
.tc-card {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.4rem 1.4rem 1.15rem;
    display: flex;
    flex-direction: column;
    gap: .9rem;
    box-shadow: var(--shadow);
    overflow: hidden;
    transition:
        transform var(--transition),
        box-shadow var(--transition),
        border-color var(--transition);
    animation: tcCardIn .45s ease both;
}
.tc-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
    border-color: var(--border-hover);
}

/* stagger children */
.tc-card:nth-child(1)  { animation-delay:.05s }
.tc-card:nth-child(2)  { animation-delay:.1s  }
.tc-card:nth-child(3)  { animation-delay:.15s }
.tc-card:nth-child(4)  { animation-delay:.2s  }
.tc-card:nth-child(5)  { animation-delay:.25s }
.tc-card:nth-child(6)  { animation-delay:.3s  }

@keyframes tcCardIn {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}

/* shimmer on hover */
.tc-card::before {
    content:'';
    position:absolute;
    inset:0;
    background: linear-gradient(120deg,
        transparent 30%,
        rgba(59,130,246,.07) 50%,
        transparent 70%);
    background-size: 200% 100%;
    background-position: -200% 0;
    transition: background-position .6s ease;
    pointer-events: none;
    border-radius: inherit;
}
.tc-card:hover::before {
    background-position: 200% 0;
}

/* left accent stripe */
.tc-card::after {
    content:'';
    position:absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    border-radius: var(--radius) 0 0 var(--radius);
    background: var(--stripe-color, var(--primary));
    opacity: .85;
}

/* ── Card top row ─────────────────────────────────────────── */
.tc-card__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
}
.tc-card__icon {
    width: 44px; height: 44px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    background: var(--icon-bg, rgba(59,130,246,.15));
}
.tc-card__status-badge {
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: .28rem .7rem;
    border-radius: 50px;
    border: 1px solid currentColor;
    white-space: nowrap;
}

/* ── Card body ────────────────────────────────────────────── */
.tc-card__title {
    margin: 0;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--fg);
    line-height: 1.35;
    letter-spacing: -.01em;
}
.tc-card__desc {
    margin: .25rem 0 0;
    font-size: .875rem;
    color: var(--muted);
    line-height: 1.55;
}

/* ── Tags ─────────────────────────────────────────────────── */
.tc-card__tags {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
}
.tc-tag {
    font-size: .78rem;
    font-weight: 500;
    color: var(--accent);
    background: rgba(59,130,246,.12);
    border: 1px solid rgba(59,130,246,.2);
    border-radius: 50px;
    padding: .22rem .65rem;
}

/* ── Metrics row ──────────────────────────────────────────── */
.tc-card__metrics {
    display: flex;
    gap: 1.1rem;
    padding: .85rem 0;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}
.tc-metric {
    display: flex;
    flex-direction: column;
    gap: .15rem;
}
.tc-metric__val {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--fg);
    line-height: 1;
}
.tc-metric__lbl {
    font-size: .73rem;
    color: var(--muted);
    letter-spacing: .03em;
    text-transform: uppercase;
}

/* ── Progress bar ─────────────────────────────────────────── */
.tc-card__progress { display: flex; flex-direction: column; gap: .45rem; }
.tc-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: .78rem;
    color: var(--muted);
}
.tc-progress-label span:last-child { color: var(--accent); font-weight: 600; }
.tc-progress-track {
    height: 5px;
    background: rgba(255,255,255,.07);
    border-radius: 50px;
    overflow: hidden;
}
.tc-progress-fill {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    width: var(--fill, 0%);
    animation: tcFillGrow .8s cubic-bezier(.4,0,.2,1) both;
    animation-delay: .4s;
}
@keyframes tcFillGrow {
    from { width: 0%; }
    to   { width: var(--fill, 0%); }
}

/* ── Action row ───────────────────────────────────────────── */
.tc-card__actions {
    display: flex;
    gap: .6rem;
    flex-wrap: wrap;
    margin-top: auto;
}
.tc-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .55rem .9rem;
    border-radius: var(--radius-sm);
    font-size: .84rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all var(--transition);
    white-space: nowrap;
}
.tc-btn--primary {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 2px 12px var(--primary-glow);
}
.tc-btn--primary:hover {
    background: #2563EB;
    transform: translateY(-1px);
    box-shadow: 0 4px 18px var(--primary-glow);
    color: #fff;
}
.tc-btn--ghost {
    background: var(--surface-2);
    color: var(--fg);
    border: 1px solid var(--border);
}
.tc-btn--ghost:hover {
    background: rgba(255,255,255,.07);
    border-color: var(--border-hover);
    color: var(--fg);
}
.tc-btn--danger {
    background: transparent;
    color: var(--danger);
    border: 1px solid rgba(248,113,113,.25);
    margin-left: auto;
}
.tc-btn--danger:hover {
    background: rgba(248,113,113,.1);
    border-color: var(--danger);
}
.tc-btn svg { flex-shrink: 0; }

/* ── Empty state ──────────────────────────────────────────── */
.tc-empty {
    text-align: center;
    padding: 4rem 2rem;
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    background: var(--surface);
    animation: tcFadeIn .5s ease both;
}
.tc-empty__icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: .55;
}
.tc-empty h3 {
    margin: 0 0 .5rem;
    font-size: 1.2rem;
    color: var(--fg);
}
.tc-empty p {
    margin: 0 0 1.5rem;
    color: var(--muted);
    font-size: .93rem;
    max-width: 340px;
    margin-inline: auto;
}

/* ── "Create course" button ───────────────────────────────── */
.tc-create-btn {
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
.tc-create-btn:hover {
    background: #2563EB;
    transform: translateY(-2px);
    box-shadow: 0 6px 24px var(--primary-glow);
    color: #fff;
}
.tc-create-btn svg { flex-shrink: 0; }

/* ── Responsive ───────────────────────────────────────────── */
@media (max-width: 600px) {
    .tc-header { flex-direction: column; align-items: flex-start; }
    .tc-grid   { grid-template-columns: 1fr; }
}
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration:.01ms !important; transition-duration:.01ms !important; }
}
</style>

<div class="tc-page">

    {{-- ── Header ── --}}
    <div class="tc-header">
        <div class="tc-header__text">
            <h2>Your Courses</h2>
            <p>Create, edit, and manage every course you teach.</p>
        </div>
        <a href="{{ route('teacher.courses.create') }}" class="tc-create-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create course
        </a>
    </div>

    @if(isset($courses) && $courses->count())

        {{-- ── Summary pills ── --}}
        @php
            $totalModules   = $courses->sum(fn($c) => $c->modules_count  ?? $c->modules?->count()  ?? 0);
            $totalStudents  = $courses->sum(fn($c) => $c->students_count ?? $c->enrollments?->count() ?? 0);
            $published      = $courses->where('status', 'published')->count();
        @endphp
        <div class="tc-stats">
            <div class="tc-stat" style="animation-delay:.05s">
                <span class="tc-stat__dot" style="background:#3B82F6;"></span>
                <strong>{{ $courses->count() }}</strong> {{ Str::plural('course', $courses->count()) }}
            </div>
            <div class="tc-stat" style="animation-delay:.1s">
                <span class="tc-stat__dot" style="background:#34D399;"></span>
                <strong>{{ $totalModules }}</strong> {{ Str::plural('module', $totalModules) }}
            </div>
            <div class="tc-stat" style="animation-delay:.15s">
                <span class="tc-stat__dot" style="background:#FBBF24;"></span>
                <strong>{{ $totalStudents }}</strong> {{ Str::plural('student', $totalStudents) }}
            </div>
            @if($published > 0)
            <div class="tc-stat" style="animation-delay:.2s">
                <span class="tc-stat__dot" style="background:#A78BFA;"></span>
                <strong>{{ $published }}</strong> published
            </div>
            @endif
        </div>

        {{-- ── Course grid ── --}}
        <div class="tc-grid">
            @foreach($courses as $course)
                @php
                    // ── Derive display values safely ──────────────────────
                    $status     = $course->status ?? 'draft';
                    $moduleCount= $course->modules_count  ?? $course->modules?->count()  ?? 0;
                    $studentCnt = $course->students_count ?? $course->enrollments?->count() ?? 0;
                    $lessonCnt  = $course->lessons_count  ?? 0;
                    $progress   = min(100, max(0, (int)($course->completion_percent ?? ($moduleCount > 0 ? min(100, $moduleCount * 15) : 0))));
                    $category   = $course->category ?? 'General';
                    $level      = $course->level    ?? 'Beginner';

                    // ── Status styling ────────────────────────────────────
                    $statusMap = [
                        'published' => ['color'=>'#34D399', 'label'=>'Published', 'stripe'=>'#34D399', 'iconBg'=>'rgba(52,211,153,.15)', 'emoji'=>'🎓'],
                        'draft'     => ['color'=>'#94A3B8', 'label'=>'Draft',     'stripe'=>'#3B82F6', 'iconBg'=>'rgba(59,130,246,.15)', 'emoji'=>'📝'],
                        'archived'  => ['color'=>'#F87171', 'label'=>'Archived',  'stripe'=>'#F87171', 'iconBg'=>'rgba(248,113,113,.15)','emoji'=>'📦'],
                        'review'    => ['color'=>'#FBBF24', 'label'=>'In Review', 'stripe'=>'#FBBF24', 'iconBg'=>'rgba(251,191,36,.15)',  'emoji'=>'🔍'],
                    ];
                    $s = $statusMap[$status] ?? $statusMap['draft'];
                @endphp

                <article
                    class="tc-card"
                    style="--stripe-color:{{ $s['stripe'] }}; --icon-bg:{{ $s['iconBg'] }}; --fill:{{ $progress }}%;">

                    {{-- Top: icon + status badge --}}
                    <div class="tc-card__top">
                        <div class="tc-card__icon">{{ $s['emoji'] }}</div>
                        <span class="tc-card__status-badge" style="color:{{ $s['color'] }}; border-color:{{ $s['color'] }}33;">
                            {{ $s['label'] }}
                        </span>
                    </div>

                    {{-- Title + description --}}
                    <div>
                        <h3 class="tc-card__title">{{ $course->title ?? 'Untitled course' }}</h3>
                        <p class="tc-card__desc">
                            {{ Str::limit($course->short_description ?? $course->description ?? 'No description added yet.', 115) }}
                        </p>
                    </div>

                    {{-- Category / level tags --}}
                    <div class="tc-card__tags">
                        <span class="tc-tag">{{ $category }}</span>
                        <span class="tc-tag">{{ $level }}</span>
                    </div>

                    {{-- Metrics --}}
                    <div class="tc-card__metrics">
                        <div class="tc-metric">
                            <span class="tc-metric__val">{{ $moduleCount }}</span>
                            <span class="tc-metric__lbl">{{ Str::plural('Module', $moduleCount) }}</span>
                        </div>
                        <div class="tc-metric">
                            <span class="tc-metric__val">{{ $studentCnt }}</span>
                            <span class="tc-metric__lbl">{{ Str::plural('Student', $studentCnt) }}</span>
                        </div>
                        @if($lessonCnt > 0)
                        <div class="tc-metric">
                            <span class="tc-metric__val">{{ $lessonCnt }}</span>
                            <span class="tc-metric__lbl">{{ Str::plural('Lesson', $lessonCnt) }}</span>
                        </div>
                        @endif
                        <div class="tc-metric">
                            <span class="tc-metric__val">
                                {{ $course->updated_at ? $course->updated_at->diffForHumans(['short'=>true, 'parts'=>1]) : '—' }}
                            </span>
                            <span class="tc-metric__lbl">Updated</span>
                        </div>
                    </div>

                    {{-- Completion progress --}}
                    <div class="tc-card__progress">
                        <div class="tc-progress-label">
                            <span>Course completion</span>
                            <span>{{ $progress }}%</span>
                        </div>
                        <div class="tc-progress-track">
                            <div class="tc-progress-fill"></div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="tc-card__actions">
                        <a href="{{ route('teacher.courses.edit', $course) }}" class="tc-btn tc-btn--primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('teacher.modules.index', ['course_id' => $course->id]) }}" class="tc-btn tc-btn--ghost">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Modules
                        </a>
                        @if(Route::has('teacher.courses.show'))
                        <a href="{{ route('teacher.courses.show', $course) }}" class="tc-btn tc-btn--ghost">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            Preview
                        </a>
                        @endif
                        @if(Route::has('teacher.courses.destroy'))
                        <form method="POST"
                              action="{{ route('teacher.courses.destroy', $course) }}"
                              onsubmit="return confirm('Delete "{{ addslashes($course->title ?? 'this course') }}"? This cannot be undone.')"
                              style="margin-left:auto;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tc-btn tc-btn--danger">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>

                </article>
            @endforeach
        </div>

    @else

        {{-- ── Empty state ── --}}
        <div class="tc-empty">
            <div class="tc-empty__icon">📚</div>
            <h3>No courses yet</h3>
            <p>You haven't created any courses. Build your first one and start adding modules and lessons.</p>
            <a href="{{ route('teacher.courses.create') }}" class="tc-create-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create your first course
            </a>
        </div>

    @endif
</div>
@endsection