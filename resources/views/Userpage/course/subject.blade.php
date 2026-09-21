@extends('layout.app')

@section('title', 'About SkillUp - Personalized Web Learning for Youth Career Development')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,800&family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --ease-spring: cubic-bezier(.34, 1.56, .64, 1);

        /* book cover / frame */
        --cover: #16223a;
        --cover-edge: #0d1526;

        /* paper */
        --page-bg: #f7f1e2;
        --page-bg-alt: #f1e9d6;
        --page-shadow: 0 30px 60px -25px rgba(15, 15, 10, .55);
        --spine-shadow: rgba(20, 15, 5, .28);

        --ink: #2b2115;
        --ink-muted: #7a6c58;
        --ink-dim: #a89a83;

        --gold: #a9781f;
        --gold-strong: #8a6117;
        --rule: rgba(120, 90, 40, .22);

        --btn-dark-bg: #241a10;
        --btn-dark-bg-hover: #34261a;
        --btn-dark-text: #f7f1e2;
    }

    html.dark-mode {
        --cover: #0b1120;
        --cover-edge: #050810;

        --page-bg: #efe6d0;
        --page-bg-alt: #e8dcc0;
        --page-shadow: 0 34px 70px -25px rgba(0, 0, 0, .75);
        --spine-shadow: rgba(10, 8, 4, .38);

        --ink: #241b10;
        --ink-muted: #6c5f4c;
        --ink-dim: #948673;

        --gold: #96690f;
        --gold-strong: #7a530c;
        --rule: rgba(110, 80, 30, .28);

        --btn-dark-bg: #16110a;
        --btn-dark-bg-hover: #241a10;
        --btn-dark-text: #f2e9d4;
    }

    #skillup-subjects-scope * { box-sizing: border-box; }

    #skillup-subjects-scope {
        position: relative;
        font-family: 'DM Sans', system-ui, sans-serif;
        color: var(--ink);
        isolation: isolate;
    }

    #skillup-subjects-scope .serif-font { font-family: 'Fraunces', Georgia, serif; }

    /* ---------- Ambient background behind the book ---------- */
    #skillup-subjects-scope .ambient-bg {
        position: fixed;
        inset: 0;
        z-index: -2;
        background:
            radial-gradient(ellipse at 50% -10%, rgba(90, 130, 200, .12), transparent 55%),
            var(--cover-edge);
    }

    #skillup-subjects-scope .container {
        position: relative;
        max-width: 1180px;
        margin: 0 auto;
        padding: 40px 20px 60px;
    }

    /* ---------- Breadcrumb ---------- */
    #skillup-subjects-scope .breadcrumb {
        margin-bottom: 22px;
        opacity: 0;
        animation: rise-in .5s var(--ease) forwards;
    }

    #skillup-subjects-scope .breadcrumb a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #cfd9ee;
        text-decoration: none;
        font-weight: 600;
        font-size: .85rem;
        letter-spacing: .02em;
        padding-bottom: 2px;
        background-image: linear-gradient(#cfd9ee, #cfd9ee);
        background-size: 0 1.5px;
        background-repeat: no-repeat;
        background-position: left bottom;
        transition: background-size .3s var(--ease), gap .3s var(--ease);
    }

    #skillup-subjects-scope .breadcrumb a:hover {
        background-size: 100% 1.5px;
        gap: 10px;
    }

    /* ---------- Header ---------- */
    #skillup-subjects-scope .page-header {
        margin-bottom: 28px;
        opacity: 0;
        animation: rise-in .6s var(--ease) .05s forwards;
    }

    #skillup-subjects-scope .eyebrow-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .74rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #d9b45c;
        margin-bottom: 10px;
    }

    #skillup-subjects-scope .page-header h1 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: clamp(1.8rem, 3vw, 2.3rem);
        margin: 0 0 6px;
        color: #f4f1e8;
        font-weight: 700;
    }

    #skillup-subjects-scope .page-header p {
        color: #a9b4cc;
        margin: 0;
        font-size: .98rem;
    }

    /* ---------- The book itself ---------- */
    #skillup-subjects-scope .book {
        position: relative;
        background: var(--cover);
        border-radius: 18px;
        padding: 28px 28px 40px;
        box-shadow: var(--page-shadow), 0 0 0 1px rgba(255,255,255,.03) inset;
        opacity: 0;
        animation: rise-in .6s var(--ease) .1s forwards;
    }

    #skillup-subjects-scope .book::before {
        /* top accent bar like a hardcover spine cap */
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 4px;
        background: linear-gradient(90deg, transparent, #4f6aa8, transparent);
        border-radius: 0 0 4px 4px;
        opacity: .6;
    }

    /* corner fold flourishes on the cover, echoing a physical book */
    #skillup-subjects-scope .book-corner {
        position: absolute;
        width: 26px;
        height: 26px;
        opacity: .5;
        pointer-events: none;
    }
    #skillup-subjects-scope .book-corner-tl { top: 14px; left: 14px; border-top: 2px solid #4f6aa8; border-left: 2px solid #4f6aa8; }
    #skillup-subjects-scope .book-corner-br { bottom: 14px; right: 14px; border-bottom: 2px solid #4f6aa8; border-right: 2px solid #4f6aa8; }

    #skillup-subjects-scope .subjects-list {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
        border-radius: 10px;
        overflow: hidden;
        background: var(--page-bg);
    }

    /* the spine gutter shining down the middle of the spread */
    #skillup-subjects-scope .subjects-list::after {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 50%;
        width: 34px;
        margin-left: -17px;
        background: linear-gradient(90deg, transparent, var(--spine-shadow) 45%, var(--spine-shadow) 55%, transparent);
        pointer-events: none;
        z-index: 3;
    }

    @media (max-width: 860px) {
        #skillup-subjects-scope .subjects-list { grid-template-columns: 1fr; }
        #skillup-subjects-scope .subjects-list::after { display: none; }
    }

    /* ---------- One subject = one page ---------- */
    #skillup-subjects-scope .subject-card {
        position: relative;
        background: var(--page-bg);
        padding: 34px 32px 30px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-height: 480px;
        opacity: 0;
        transform: translateY(16px);
        animation: rise-in .55s var(--ease) forwards;
    }

    /* alternate every second page (right-hand pages) with a faint tint,
       matching the two-page spread look */
    #skillup-subjects-scope .subject-card:nth-child(even) { background: var(--page-bg-alt); }

    #skillup-subjects-scope .subject-card:not(:last-child) {
        border-bottom: 1px solid var(--rule);
    }
    @media (min-width: 861px) {
        #skillup-subjects-scope .subject-card:nth-child(odd):not(:last-child) {
            border-bottom: none;
        }
        #skillup-subjects-scope .subject-card:nth-last-child(2):nth-child(odd) {
            border-bottom: none;
        }
    }

    #skillup-subjects-scope .subject-card:nth-child(1) { animation-delay: .08s; }
    #skillup-subjects-scope .subject-card:nth-child(2) { animation-delay: .14s; }
    #skillup-subjects-scope .subject-card:nth-child(3) { animation-delay: .2s; }
    #skillup-subjects-scope .subject-card:nth-child(4) { animation-delay: .26s; }
    #skillup-subjects-scope .subject-card:nth-child(5) { animation-delay: .32s; }
    #skillup-subjects-scope .subject-card:nth-child(6) { animation-delay: .38s; }

    /* dog-eared corner fold, bottom corners of each page */
    #skillup-subjects-scope .page-fold {
        position: absolute;
        bottom: 0;
        width: 0;
        height: 0;
        border-style: solid;
        opacity: .55;
    }
    #skillup-subjects-scope .page-fold-left {
        left: 0;
        border-width: 0 0 16px 16px;
        border-color: transparent transparent rgba(120, 90, 40, .18) transparent;
    }
    #skillup-subjects-scope .page-fold-right {
        right: 0;
        border-width: 0 16px 16px 0;
        border-color: transparent transparent transparent rgba(120, 90, 40, .18);
    }

    #skillup-subjects-scope .subject-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    #skillup-subjects-scope .subject-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 1.5px solid var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        background: rgba(169, 120, 31, .08);
    }

    #skillup-subjects-scope .subject-info { min-width: 0; }

    #skillup-subjects-scope .subject-eyebrow {
        display: inline-block;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 4px;
    }

    #skillup-subjects-scope .subject-info h3 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 1.4rem;
        margin: 0 0 4px;
        color: var(--ink);
        font-weight: 600;
        line-height: 1.15;
    }

    #skillup-subjects-scope .subject-teacher {
        font-size: .85rem;
        color: var(--ink-muted);
        margin: 0;
    }

    #skillup-subjects-scope .subject-type-tag {
        display: inline-block;
        margin-top: .35rem;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--gold-strong);
    }

    #skillup-subjects-scope .subject-description {
        color: var(--ink-muted);
        font-size: .94rem;
        line-height: 1.65;
        margin: 0;
    }

    #skillup-subjects-scope .subject-meta {
        font-size: .8rem;
        color: var(--ink-muted);
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-weight: 600;
    }

    #skillup-subjects-scope .subject-meta .meta-course { color: var(--gold-strong); }

    /* ---------- Stats row ---------- */
    #skillup-subjects-scope .subject-stats {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-top: 1px solid var(--rule);
        border-bottom: 1px solid var(--rule);
        margin-top: auto;
    }

    #skillup-subjects-scope .stat {
        flex: 1;
        text-align: left;
        position: relative;
    }

    #skillup-subjects-scope .stat:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 2px; right: -8px;
        width: 1px; height: calc(100% - 4px);
        background: var(--rule);
    }

    #skillup-subjects-scope .stat-label {
        display: block;
        color: var(--gold);
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-weight: 700;
        margin-bottom: 4px;
    }

    #skillup-subjects-scope .stat-value {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 700;
        color: var(--ink);
        display: block;
        font-size: 1.6rem;
    }

    /* ---------- Buttons ---------- */
    #skillup-subjects-scope .primary-action {
        display: block;
    }

    #skillup-subjects-scope .btn {
        position: relative;
        border: none;
        border-radius: 999px;
        font-weight: 700;
        cursor: pointer;
        font-size: .88rem;
        transition: transform .25s var(--ease), box-shadow .25s var(--ease), background-color .25s var(--ease), color .25s var(--ease);
        letter-spacing: .01em;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'DM Sans', sans-serif;
    }

    #skillup-subjects-scope .btn-dark {
        width: 100%;
        padding: 13px 20px;
        background: var(--btn-dark-bg);
        color: var(--btn-dark-text);
        box-shadow: 0 10px 22px -8px rgba(20, 15, 5, .5);
    }

    #skillup-subjects-scope .btn-dark:hover {
        background: var(--btn-dark-bg-hover);
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -10px rgba(20, 15, 5, .6);
    }

    #skillup-subjects-scope .secondary-actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    #skillup-subjects-scope .btn-outline {
        padding: 10px 14px;
        background: transparent;
        color: var(--ink);
        border: 1.5px solid var(--rule);
    }

    #skillup-subjects-scope .btn-outline:hover {
        border-color: var(--gold);
        color: var(--gold-strong);
        transform: translateY(-2px);
    }

    #skillup-subjects-scope .meet-link {
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .78rem;
        font-weight: 700;
        color: var(--ink-muted);
        text-decoration: none;
        border-bottom: 1px dashed var(--rule);
        padding-bottom: 2px;
    }

    #skillup-subjects-scope .meet-link:hover { color: var(--gold-strong); border-color: var(--gold); }

    /* ---------- Empty state ---------- */
    #skillup-subjects-scope .no-subjects {
        text-align: center;
        padding: 70px 20px;
        color: var(--ink-muted);
        background: var(--page-bg);
        border-radius: 10px;
        opacity: 0;
        animation: rise-in .6s var(--ease) .1s forwards;
    }

    #skillup-subjects-scope .no-subjects i {
        font-size: 2.4rem;
        color: var(--gold);
        display: inline-block;
        margin-bottom: 16px;
    }

    #skillup-subjects-scope .no-subjects h3 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 1.5rem;
        margin: 0 0 10px;
        color: var(--ink);
        font-weight: 700;
    }

    #skillup-subjects-scope .no-subjects .btn-dark {
        display: inline-flex;
        width: auto;
        margin-top: 22px;
        padding: 12px 30px;
    }

    /* ---------- Shared keyframes ---------- */
    @keyframes rise-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        #skillup-subjects-scope * { animation: none !important; transition: none !important; }
    }

    @media (max-width: 720px) {
        #skillup-subjects-scope .subject-card { min-height: 0; padding: 28px 22px; }
        #skillup-subjects-scope .book { padding: 18px 14px 28px; }
    }
</style>

<div id="skillup-subjects-scope">
    <div class="ambient-bg"></div>

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('courses.index') }}">← Back to Courses</a>
        </div>

        <div class="page-header">
            <span class="eyebrow-tag">📖 Subject Directory</span>
            <h1>Course Subjects</h1>
            <p>Explore the subjects available in this course</p>
        </div>

        @if($subjects && $subjects->count() > 0)
            <div class="book">
                <span class="book-corner book-corner-tl"></span>
                <span class="book-corner book-corner-br"></span>

                <div class="subjects-list">
                    @foreach($subjects as $subject)
                        <div class="subject-card">
                            <span class="page-fold page-fold-left"></span>
                            <span class="page-fold page-fold-right"></span>

                            <div class="subject-header">
                                <div class="subject-icon">
                                    @php
                                        $icons = ['📡', '💠', '🔷', '🧬', '⚡', '🎯', '📊', '🛡️'];
                                        $icon = $icons[($subject->id - 1) % count($icons)] ?? '📡';
                                    @endphp
                                        {{ $icon }}
                                </div>
                                <div class="subject-info">
                                    <span class="subject-eyebrow">Subject Manual</span>
                                    <h3>{{ $subject->title ?? 'Subject' }}</h3>
                                    @if($subject->subject_code)
                                        <span style="font-size: 0.7rem; font-weight: 700; color: var(--gold-strong); letter-spacing:.04em;">
                                            {{ $subject->subject_code }}
                                        </span>
                                    @endif
                                    @if($subject->teacher)
                                        <p class="subject-teacher">👨‍🏫 {{ $subject->teacher->name }}</p>
                                    @else
                                        <p class="subject-teacher">📌 Unassigned</p>
                                    @endif
                                    @if($subject->subject_type)
                                        <span class="subject-type-tag">{{ $subject->subject_type }}</span>
                                    @endif
                                </div>
                            </div>

                            @php
                                $course = $subject->course;
                                $courseModules = $course?->modules ?? collect();
                                $publishedLessons = $courseModules->flatMap(fn ($module) => $module->lessons)
                                    ->where('is_published', true);
                                $publishedQuizzes = $courseModules->flatMap(fn ($module) => $module->quizzes)
                                    ->where('is_published', true)
                                    ->where('is_archived', false);
                                $lessonCount = $publishedLessons->count();
                                $quizCount = $publishedQuizzes->count();
                                $firstLesson = $publishedLessons->first();
                                $firstQuiz = $publishedQuizzes->first();
                                $progress = auth()->check() ? (auth()->user()->enrollments()
                                    ->where('course_id', $course?->id)
                                    ->value('progress') ?? 0) : 0;
                            @endphp

                            <p class="subject-description">
                                {{ $subject->description ?: ('Master the fundamentals and advanced concepts of ' . ($subject->title ?? 'this subject') . ' with comprehensive lessons and assessments.') }}
                            </p>

                            @if($subject->units || $subject->hours || $course)
                                <div class="subject-meta">
                                    @if($subject->units) <span>🎓 {{ $subject->units }} Units</span> @endif
                                    @if($subject->hours) <span>⏱️ {{ $subject->hours }} Hours</span> @endif
                                    @if($course) <span class="meta-course">🔗 {{ $course->title }}</span> @endif
                                </div>
                            @endif

                            <div class="subject-stats">
                                <div class="stat">
                                    <span class="stat-label">Lessons</span>
                                    <span class="stat-value" data-count-to="{{ $lessonCount }}">0</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-label">Quizzes</span>
                                    <span class="stat-value" data-count-to="{{ $quizCount }}">0</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-label">Progress</span>
                                    <span class="stat-value" data-count-to="{{ (int) $progress }}" data-suffix="%">0%</span>
                                </div>
                            </div>

                            <div class="primary-action">
                                <a href="{{ $course ? route('courses.show', $course->slug ?? $course->id) : '#' }}" class="btn btn-dark">
                                    <i class="fa-solid fa-book-open"></i> Open Course
                                </a>
                            </div>

                            <div class="secondary-actions">
                                @if($firstLesson && $firstLesson->slug && $firstLesson->module?->slug && $course?->slug)
                                    <a href="{{ route('lessons.show', [$course->slug, $firstLesson->module->slug, $firstLesson->slug]) }}" class="btn btn-outline">
                                        <i class="fa-solid fa-list-ul"></i> Table of Contents
                                    </a>
                                @else
                                    <a href="{{ $course ? route('courses.show', $course->slug ?? $course->id) : '#' }}" class="btn btn-outline">
                                        <i class="fa-solid fa-list-ul"></i> Table of Contents
                                    </a>
                                @endif

                                @if($firstQuiz && $firstQuiz->slug && $firstQuiz->module?->slug && $course?->slug)
                                    <a href="{{ route('quizzes.show', [$course->slug, $firstQuiz->module->slug, $firstQuiz->slug]) }}" class="btn btn-outline">
                                        <i class="fa-solid fa-question-circle"></i> Quiz
                                    </a>
                                @else
                                    <a href="{{ $course ? route('courses.show', $course->slug ?? $course->id) : '#' }}" class="btn btn-outline">
                                        <i class="fa-solid fa-question-circle"></i> Quiz
                                    </a>
                                @endif

                                <a href="{{ url('/exam') }}" class="btn btn-outline">
                                    <i class="fa-solid fa-clipboard-check"></i> Exam
                                </a>

                                <a href="{{ url('/grades') }}" class="btn btn-outline">
                                    <i class="fa-solid fa-chart-bar"></i> Grades
                                </a>
                            </div>

                            <a href="https://meet.google.com" target="_blank" rel="noopener" class="meet-link">
                                <i class="fa-brands fa-google"></i> Join a Meet session
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="book">
                <span class="book-corner book-corner-tl"></span>
                <span class="book-corner book-corner-br"></span>
                <div class="no-subjects">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                    <h3>No enrolled subjects yet</h3>
                    <p>Enroll in a course to see its subjects here.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-dark">Browse Courses</a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    (function () {
        var scope = document.getElementById('skillup-subjects-scope');
        if (!scope) return;

        var reduceMotion = document.documentElement.dataset.skillupReducedMotion === 'true'
            || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

        // ---- Animated stat count-up ----
        function animateCount(el) {
            var target = parseInt(el.getAttribute('data-count-to'), 10);
            if (isNaN(target)) return;
            var suffix = el.getAttribute('data-suffix') || '';

            if (reduceMotion) {
                el.textContent = target + suffix;
                return;
            }

            var duration = 900;
            var start = null;

            function step(timestamp) {
                if (!start) start = timestamp;
                var progress = Math.min((timestamp - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                var value = Math.round(eased * target);
                el.textContent = value + suffix;
                if (progress < 1) {
                    requestAnimationFrame(step);
                }
            }
            requestAnimationFrame(step);
        }

        var statEls = scope.querySelectorAll('.stat-value[data-count-to]');

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        animateCount(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            statEls.forEach(function (el) { observer.observe(el); });
        } else {
            statEls.forEach(function (el) { animateCount(el); });
        }
    })();
</script>

@endsection