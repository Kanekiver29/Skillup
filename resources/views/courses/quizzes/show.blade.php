@extends('layout.app')

@section('title', $quiz->title . ' - ' . $module->title . ' - SkillUp')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --quiz-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --quiz-void: #050b16;
        --quiz-navy-deep: #0c0a24;
        --quiz-navy: #1b1140;
        --quiz-purple: #6d28d9;
        --quiz-pink: #db2777;
        --quiz-cyan: #00e0ff;
        --quiz-violet: #a78bfa;
        --quiz-emerald: #34e8b0;
        --quiz-rose: #f43f5e;
        --font-display: 'Space Grotesk', 'Inter', sans-serif;
        --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    .quiz-mono { font-family: var(--font-mono); letter-spacing: 0.03em; }
    .quiz-display { font-family: var(--font-display); }

    /* ---------- Hero / console header ---------- */
    .quiz-hero {
        background:
            radial-gradient(ellipse 70% 60% at 100% 0%, rgba(0, 224, 255, 0.16), transparent 55%),
            radial-gradient(ellipse 60% 60% at 0% 100%, rgba(219, 39, 119, 0.18), transparent 55%),
            linear-gradient(150deg, var(--quiz-navy-deep) 0%, var(--quiz-navy) 45%, var(--quiz-purple) 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        border-bottom: 1px solid rgba(0, 224, 255, 0.14);
    }

    .quiz-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0, 224, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 224, 255, 0.05) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: radial-gradient(ellipse 90% 90% at 50% 10%, black 10%, transparent 78%);
        pointer-events: none;
        z-index: 0;
    }

    .quiz-scan {
        position: absolute;
        left: 0; right: 0;
        height: 100px;
        background: linear-gradient(180deg, transparent, rgba(0, 224, 255, 0.10), transparent);
        pointer-events: none;
        z-index: 0;
        animation: quizScanSweep 7s linear infinite;
    }

    @keyframes quizScanSweep {
        0%   { top: -120px; opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    #quizNetCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.5;
        pointer-events: none;
    }

    .quiz-hero-inner { position: relative; z-index: 2; }

    .quiz-back-link {
        color: #e9d5ff !important;
        transition: color 0.2s ease, transform 0.25s var(--quiz-ease);
    }
    .quiz-back-link:hover { color: #fff !important; }

    .quiz-eyebrow {
        color: var(--quiz-cyan);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .quiz-eyebrow .quiz-cursor::after {
        content: '_';
        animation: quizBlink 1s step-end infinite;
    }
    @keyframes quizBlink { 50% { opacity: 0; } }

    .quiz-media-frame {
        position: relative;
        border-radius: 1rem;
        padding: 3px;
        background: linear-gradient(135deg, var(--quiz-cyan), var(--quiz-violet));
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
    }
    .quiz-media-frame > * { border-radius: 0.85rem; overflow: hidden; }

    /* ---------- Cards ---------- */
    .quiz-card {
        position: relative;
        background: #fff;
        overflow: hidden;
        transition: box-shadow 0.3s var(--quiz-ease), transform 0.3s var(--quiz-ease);
    }
    .quiz-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--quiz-cyan), var(--quiz-violet), var(--quiz-pink));
        opacity: 0.85;
    }

    .quiz-stat-tile {
        position: relative;
        border-radius: 0.9rem;
        padding: 1.1rem;
        overflow: hidden;
        transition: transform 0.3s var(--quiz-ease), box-shadow 0.3s var(--quiz-ease);
        animation: quizTileIn 0.5s var(--quiz-ease) backwards;
    }
    .quiz-stat-tile:nth-child(1) { animation-delay: .05s; }
    .quiz-stat-tile:nth-child(2) { animation-delay: .12s; }
    .quiz-stat-tile:nth-child(3) { animation-delay: .19s; }

    @keyframes quizTileIn {
        from { opacity: 0; transform: translateY(10px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .quiz-stat-tile:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .quiz-stat-val { font-family: var(--font-mono); }

    .quiz-detail-icon {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(109, 40, 217, 0.10), rgba(0, 224, 255, 0.10));
        color: var(--quiz-purple);
        flex-shrink: 0;
        transition: transform 0.3s var(--quiz-ease);
    }
    .quiz-detail-row:hover .quiz-detail-icon { transform: scale(1.08) rotate(-4deg); }

    /* ---------- Attempt history ---------- */
    .quiz-attempt-row {
        position: relative;
        border-left: 3px solid transparent;
        transition: transform 0.3s var(--quiz-ease), border-color 0.3s ease, box-shadow 0.3s ease;
        animation: quizRowIn 0.5s var(--quiz-ease) backwards;
    }
    .quiz-attempt-row.is-pass { border-left-color: var(--quiz-emerald); }
    .quiz-attempt-row.is-fail { border-left-color: var(--quiz-rose); }

    .quiz-attempt-row:hover {
        transform: translateX(4px);
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
    }

    @keyframes quizRowIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ---------- Sidebar ---------- */
    .quiz-action-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(109, 40, 217, 0.12);
    }
    .quiz-hud-corner {
        position: absolute;
        width: 16px;
        height: 16px;
        border-color: var(--quiz-violet);
        opacity: 0.55;
        pointer-events: none;
        animation: quizHudPulse 3.4s ease-in-out infinite;
    }
    .quiz-hud-corner.tl { top: 6px; left: 6px; border-top: 2px solid; border-left: 2px solid; border-top-left-radius: 0.5rem; }
    .quiz-hud-corner.br { bottom: 6px; right: 6px; border-bottom: 2px solid; border-right: 2px solid; border-bottom-right-radius: 0.5rem; animation-delay: 1.2s; }

    @keyframes quizHudPulse {
        0%, 100% { opacity: 0.25; }
        50%      { opacity: 0.75; }
    }

    .quiz-start-btn {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, var(--quiz-purple), var(--quiz-pink));
        transition: transform 0.25s var(--quiz-ease), box-shadow 0.25s ease, filter 0.25s ease;
    }
    .quiz-start-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, 0.35) 50%, transparent 60%);
        background-size: 220% 100%;
        animation: quizBtnShine 3.5s linear infinite;
    }
    @keyframes quizBtnShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .quiz-start-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(109, 40, 217, 0.35);
        filter: brightness(1.05);
    }

    .quiz-attempt-meter {
        width: 100%;
        height: 6px;
        border-radius: 999px;
        background: rgba(109, 40, 217, 0.10);
        overflow: hidden;
        margin-top: 0.65rem;
    }
    .quiz-attempt-meter-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--quiz-cyan), var(--quiz-violet));
        transition: width 0.6s var(--quiz-ease);
    }

    .quiz-tips-card {
        position: relative;
        background: linear-gradient(160deg, #eff6ff, #f5f3ff);
        border: 1px solid rgba(109, 40, 217, 0.12);
    }
    .quiz-tips-card li { display: flex; align-items: flex-start; gap: 0.5rem; }
    .quiz-tips-card li i { color: var(--quiz-emerald); margin-top: 0.2rem; }

    .quiz-locked-card {
        background: linear-gradient(160deg, #fef2f2, #fff1f2);
        border: 1px solid rgba(244, 63, 94, 0.18);
    }

    @media (prefers-reduced-motion: reduce) {
        .quiz-scan, .quiz-hud-corner, .quiz-start-btn::after,
        .quiz-stat-tile, .quiz-attempt-row, .quiz-eyebrow .quiz-cursor::after {
            animation: none !important;
        }
        .quiz-stat-tile, .quiz-attempt-row { opacity: 1 !important; transform: none !important; }
        #quizNetCanvas { display: none; }
    }
</style>
@endpush

@section('content')
    <!-- Quiz Header -->
    <div class="pt-6 quiz-hero">
        <canvas id="quizNetCanvas" aria-hidden="true"></canvas>
        <div class="quiz-scan" aria-hidden="true"></div>

        <div class="quiz-hero-inner max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-4">
                <a href="{{ route('modules.show', [$course->slug, $module->slug]) }}" class="quiz-back-link flex items-center group">
                    <i class="fas fa-arrow-left mr-2 text-xs transition-transform group-hover:-translate-x-1"></i>
                    Back to {{ $module->title }}
                </a>
            </div>
            <p class="quiz-eyebrow quiz-mono text-xs font-semibold uppercase tracking-[0.3em] mb-3">
                <i class="fas fa-brain"></i> <span class="quiz-cursor">MODULE::QUIZ</span>
            </p>
            <h1 class="quiz-display text-4xl md:text-5xl font-bold mb-4">{{ $quiz->title }}</h1>
            <p class="text-lg text-purple-100/90">{{ $quiz->description }}</p>
            @if($quiz->media_type && $quiz->media_url)
                <div class="mt-8">
                    @if($quiz->media_type === 'video')
                        @if(str_contains($quiz->media_url, 'youtube.com') || str_contains($quiz->media_url, 'youtu.be'))
                            <div class="quiz-media-frame aspect-w-16 aspect-h-9">
                                <iframe src="{{ $quiz->media_url }}" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
                            </div>
                        @else
                            <div class="quiz-media-frame aspect-w-16 aspect-h-9 bg-black">
                                <video controls class="w-full h-full object-cover">
                                    <source src="{{ $quiz->media_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    @elseif($quiz->media_type === 'image')
                        <div class="quiz-media-frame">
                            <img src="{{ $quiz->media_url }}" alt="{{ $quiz->title }} media" class="w-full">
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Quiz Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quiz Overview -->
                <section class="quiz-card rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="quiz-display text-2xl font-bold text-gray-800 mb-6">Quiz Overview</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 mb-6">
                        <p>{{ $quiz->description ?? 'Test your knowledge on this module topic.' }}</p>
                    </div>

                    <!-- Quiz Statistics -->
                    @if($userAttempts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-8">
                            <div class="quiz-stat-tile bg-gradient-to-br from-emerald-50 to-emerald-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="quiz-mono text-xs uppercase tracking-wider text-gray-500">Best Score</p>
                                        <p class="quiz-stat-val mt-1 text-3xl font-bold text-emerald-600">{{ $bestScore }}%</p>
                                    </div>
                                    <i class="fas fa-star text-emerald-500 text-3xl opacity-20"></i>
                                </div>
                            </div>

                            <div class="quiz-stat-tile bg-gradient-to-br from-sky-50 to-sky-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="quiz-mono text-xs uppercase tracking-wider text-gray-500">Attempts Used</p>
                                        <p class="quiz-stat-val mt-1 text-3xl font-bold text-sky-600">{{ $attemptCount }}/{{ $quiz->attempt_limit }}</p>
                                    </div>
                                    <i class="fas fa-edit text-sky-500 text-3xl opacity-20"></i>
                                </div>
                            </div>

                            <div class="quiz-stat-tile bg-gradient-to-br from-violet-50 to-violet-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="quiz-mono text-xs uppercase tracking-wider text-gray-500">Status</p>
                                        <p class="text-xl font-bold">
                                            @if($hasUserPassed)
                                                <span class="text-emerald-600">✓ Passed</span>
                                            @else
                                                <span class="text-rose-600">Need Improvement</span>
                                            @endif
                                        </p>
                                    </div>
                                    <i class="fas fa-check-circle text-violet-500 text-3xl opacity-20"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <!-- Attempt History -->
                @if($userAttempts->count() > 0)
                    <section class="quiz-card rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="quiz-display text-2xl font-bold text-gray-800 mb-6">Attempt History</h2>
                        <div class="space-y-4">
                            @foreach($userAttempts as $index => $attempt)
                                <div class="quiz-attempt-row {{ $attempt->passed ? 'is-pass' : 'is-fail' }} border border-gray-200 rounded-lg p-4"
                                     style="animation-delay: {{ min($index * 70, 350) }}ms">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Attempt #{{ $attempt->attempt_number }}</h4>
                                            <p class="quiz-mono text-xs text-gray-500">{{ $attempt->completed_at?->format('M d, Y H:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="quiz-stat-val text-2xl font-bold @if($attempt->passed) text-emerald-600 @else text-rose-600 @endif">
                                                {{ $attempt->score_percentage }}%
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }} correct</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 mt-4 text-sm">
                                        <span class="flex items-center text-gray-600">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ $attempt->getFormattedTimeSpent() }}
                                        </span>
                                        @if($attempt->passed)
                                            <span class="flex items-center text-emerald-600">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Passed ({{ $quiz->passing_score }}% required)
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('quizzes.results', [$course->slug, $module->slug, $quiz->slug, $attempt->id]) }}"
                                           class="text-violet-600 hover:text-violet-800 font-semibold text-sm">
                                            View Results <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Quiz Details -->
                <section class="quiz-card rounded-lg shadow-lg p-8">
                    <h2 class="quiz-display text-2xl font-bold text-gray-800 mb-6">Quiz Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="quiz-detail-row flex items-start space-x-4">
                            <div class="quiz-detail-icon text-lg">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Questions</h4>
                                <p class="text-gray-600">{{ $quiz->questions()->count() }} questions in this quiz</p>
                            </div>
                        </div>

                        <div class="quiz-detail-row flex items-start space-x-4">
                            <div class="quiz-detail-icon text-lg">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Passing Score</h4>
                                <p class="text-gray-600">{{ $quiz->passing_score }}% required to pass</p>
                            </div>
                        </div>

                        <div class="quiz-detail-row flex items-start space-x-4">
                            <div class="quiz-detail-icon text-lg">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Time Limit</h4>
                                <p class="text-gray-600">
                                    @if($quiz->time_limit_minutes)
                                        {{ $quiz->time_limit_minutes }} minutes
                                    @else
                                        No time limit
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="quiz-detail-row flex items-start space-x-4">
                            <div class="quiz-detail-icon text-lg">
                                <i class="fas fa-redo"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Attempts</h4>
                                <p class="text-gray-600">{{ $quiz->attempt_limit }} attempts allowed</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Action Card -->
                <div class="quiz-action-card bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                    <div class="quiz-hud-corner tl"></div>
                    <div class="quiz-hud-corner br"></div>
                    @if($canRetry || $attemptCount === 0)
                        <h3 class="quiz-display text-lg font-bold text-gray-800 mb-4">Ready to Start?</h3>
                        <p class="text-gray-600 text-sm mb-2">
                            @if($attemptCount === 0)
                                You haven't started this quiz yet. Click below to begin!
                            @else
                                You can still retry this quiz. {{ $quiz->attempt_limit - $attemptCount }} attempt(s) remaining.
                            @endif
                        </p>
                        <div class="quiz-attempt-meter">
                            <div class="quiz-attempt-meter-fill" style="width: {{ $quiz->attempt_limit > 0 ? min(100, ($attemptCount / $quiz->attempt_limit) * 100) : 0 }}%"></div>
                        </div>
                        <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}"
                           class="quiz-start-btn w-full block text-white font-bold rounded-lg px-6 py-3 text-center mt-6">
                            {{ $attemptCount > 0 ? 'Retry Quiz' : 'Start Quiz' }}
                        </a>
                    @else
                        <div class="quiz-locked-card rounded-lg p-6 text-center">
                            <i class="fas fa-lock text-3xl text-rose-500 mb-3"></i>
                            <h3 class="quiz-display text-lg font-bold text-rose-600 mb-2">No Attempts Left</h3>
                            <p class="text-rose-600 text-sm">You've used all {{ $quiz->attempt_limit }} attempts for this quiz.</p>
                            @if(!$hasUserPassed)
                                <p class="text-rose-600 text-sm mt-2">Contact your instructor for more attempts.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Info Card -->
                <div class="quiz-tips-card rounded-lg p-6">
                    <h3 class="quiz-display font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-sky-500 mr-2"></i>
                        Tips
                    </h3>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li><i class="fas fa-check"></i> Review all material before starting</li>
                        <li><i class="fas fa-check"></i> Read each question carefully</li>
                        <li><i class="fas fa-check"></i> You can review your answers before submitting</li>
                        @if($quiz->show_correct_answers)
                            <li><i class="fas fa-check"></i> Correct answers will be shown after completion</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canvas = document.getElementById('quizNetCanvas');
    if (!canvas) return;

    var hero = canvas.closest('.quiz-hero');
    var ctx = canvas.getContext('2d');
    var width, height, nodes;
    var LINK_DIST = 130;

    function resize() {
        width = canvas.width = hero.offsetWidth;
        height = canvas.height = hero.offsetHeight;
        var count = Math.min(46, Math.floor((width * height) / 15000));
        nodes = Array.from({ length: count }, function () {
            return {
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.22,
                vy: (Math.random() - 0.5) * 0.22
            };
        });
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);
        for (var i = 0; i < nodes.length; i++) {
            var n = nodes[i];
            n.x += n.vx;
            n.y += n.vy;
            if (n.x < 0 || n.x > width) n.vx *= -1;
            if (n.y < 0 || n.y > height) n.vy *= -1;
        }
        for (var a = 0; a < nodes.length; a++) {
            for (var b = a + 1; b < nodes.length; b++) {
                var dx = nodes[a].x - nodes[b].x, dy = nodes[a].y - nodes[b].y;
                var dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < LINK_DIST) {
                    ctx.strokeStyle = 'rgba(0, 224, 255, ' + (0.15 * (1 - dist / LINK_DIST)) + ')';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(nodes[a].x, nodes[a].y);
                    ctx.lineTo(nodes[b].x, nodes[b].y);
                    ctx.stroke();
                }
            }
        }
        for (var j = 0; j < nodes.length; j++) {
            ctx.fillStyle = 'rgba(219, 39, 119, 0.55)';
            ctx.beginPath();
            ctx.arc(nodes[j].x, nodes[j].y, 1.5, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    resize();
    window.addEventListener('resize', resize);

    if (prefersReducedMotion) {
        draw();
        return;
    }

    (function loop() {
        draw();
        requestAnimationFrame(loop);
    })();
})();
</script>
@endpush