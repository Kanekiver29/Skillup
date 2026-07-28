

<?php $__env->startSection('title', 'Quiz Results - ' . $quiz->title . ' - SkillUp'); ?>

<?php $__env->startPush('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --res-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --res-navy-deep: #0c0a24;
        --res-navy: #1b1140;
        --res-purple: #6d28d9;
        --res-pink: #db2777;
        --res-cyan: #00e0ff;
        --res-violet: #a78bfa;
        --res-emerald: #34e8b0;
        --res-rose: #f43f5e;
        --res-amber: #f59e0b;
        --font-display: 'Space Grotesk', 'Inter', sans-serif;
        --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    .res-mono { font-family: var(--font-mono); letter-spacing: 0.03em; }
    .res-display { font-family: var(--font-display); }

    /* ---------- Hero ---------- */
    .res-hero {
        background:
            radial-gradient(ellipse 70% 60% at 100% 0%, rgba(0, 224, 255, 0.16), transparent 55%),
            radial-gradient(ellipse 60% 60% at 0% 100%, rgba(219, 39, 119, 0.18), transparent 55%),
            linear-gradient(150deg, var(--res-navy-deep) 0%, var(--res-navy) 45%, var(--res-purple) 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        border-bottom: 1px solid rgba(0, 224, 255, 0.14);
    }
    .res-hero::before {
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
    .res-scan {
        position: absolute;
        left: 0; right: 0;
        height: 100px;
        background: linear-gradient(180deg, transparent, rgba(0, 224, 255, 0.10), transparent);
        pointer-events: none;
        z-index: 0;
        animation: resScanSweep 7s linear infinite;
    }
    @keyframes resScanSweep {
        0%   { top: -120px; opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    #resNetCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.5;
        pointer-events: none;
    }
    .res-hero-inner { position: relative; z-index: 2; }
    .res-back-link { color: #e9d5ff !important; transition: color 0.2s ease, transform 0.25s var(--res-ease); }
    .res-back-link:hover { color: #fff !important; }
    .res-eyebrow { color: var(--res-cyan); display: inline-flex; align-items: center; gap: 0.4rem; }
    .res-eyebrow .res-cursor::after { content: '_'; animation: resBlink 1s step-end infinite; }
    @keyframes resBlink { 50% { opacity: 0; } }

    /* ---------- Score console ---------- */
    .res-score-card {
        position: relative;
        overflow: hidden;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.14);
    }
    .res-score-gauge {
        position: relative;
        width: 168px;
        height: 168px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: conic-gradient(var(--res-cyan) calc(var(--pct, 0) * 1%), rgba(255,255,255,0.18) 0);
        animation: resGaugeIn 1.1s var(--res-ease) both;
    }
    .res-score-gauge::before {
        content: '';
        position: absolute;
        inset: 10px;
        border-radius: 50%;
        background: linear-gradient(160deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
        backdrop-filter: blur(2px);
    }
    .res-score-gauge-inner { position: relative; z-index: 1; text-align: center; }

    @keyframes resGaugeIn {
        from { filter: brightness(0.6); transform: scale(0.9); opacity: 0; }
        to   { filter: brightness(1); transform: scale(1); opacity: 1; }
    }

    .res-stat-block { animation: resFadeUp 0.5s var(--res-ease) backwards; }
    .res-stat-block:nth-child(1) { animation-delay: .08s; }
    .res-stat-block:nth-child(2) { animation-delay: .16s; }
    @keyframes resFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .res-val-mono { font-family: var(--font-mono); }

    /* ---------- Certificate banner ---------- */
    .res-cert-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #fffbeb, #fef3c7);
        border: 1px solid rgba(245, 158, 11, 0.35);
    }
    .res-cert-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.5) 50%, transparent 60%);
        background-size: 220% 100%;
        animation: resShine 4.5s linear infinite;
        pointer-events: none;
    }
    @keyframes resShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .res-cert-icon {
        width: 3rem; height: 3rem;
        border-radius: 0.9rem;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--res-amber), #fbbf24);
        color: #fff;
        box-shadow: 0 10px 24px rgba(245, 158, 11, 0.35);
    }

    /* ---------- Detailed review ---------- */
    .res-question-card {
        position: relative;
        transition: transform 0.3s var(--res-ease), box-shadow 0.3s var(--res-ease);
        animation: resFadeUp 0.5s var(--res-ease) backwards;
    }
    .res-question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 46px rgba(15, 23, 42, 0.12);
    }
    .res-answer-box {
        border-radius: 0.75rem;
        padding: 1rem;
        transition: transform 0.25s var(--res-ease);
    }
    .res-answer-box:hover { transform: translateY(-2px); }

    /* ---------- Action buttons ---------- */
    .res-action-btn {
        position: relative;
        overflow: hidden;
        transition: transform 0.25s var(--res-ease), box-shadow 0.25s ease, filter 0.2s ease;
    }
    .res-action-btn:hover {
        transform: translateY(-3px);
        filter: brightness(1.05);
    }
    .res-action-btn.is-emerald { background: linear-gradient(120deg, #059669, var(--res-emerald)); }
    .res-action-btn.is-amber   { background: linear-gradient(120deg, #d97706, var(--res-amber)); }
    .res-action-btn.is-violet  { background: linear-gradient(120deg, var(--res-purple), var(--res-violet)); }
    .res-action-btn.is-slate   { background: #e2e8f0; color: #1e293b; }
    .res-action-btn.is-indigo  { background: linear-gradient(120deg, #4338ca, #6366f1); }

    /* ---------- Performance summary ---------- */
    .res-summary-card { position: relative; overflow: hidden; }
    .res-summary-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--res-cyan), var(--res-violet), var(--res-pink));
        opacity: 0.85;
    }
    .res-accuracy-bar {
        width: 100%;
        height: 8px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 0.5rem;
    }
    .res-accuracy-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--res-cyan), var(--res-emerald));
        transition: width 0.8s var(--res-ease);
    }

    @media (prefers-reduced-motion: reduce) {
        .res-scan, .res-score-gauge, .res-stat-block, .res-cert-banner::before,
        .res-question-card, .res-eyebrow .res-cursor::after {
            animation: none !important;
        }
        .res-score-gauge, .res-stat-block, .res-question-card { opacity: 1 !important; transform: none !important; }
        #resNetCanvas { display: none; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Results Header -->
    <div class="pt-6 res-hero">
        <canvas id="resNetCanvas" aria-hidden="true"></canvas>
        <div class="res-scan" aria-hidden="true"></div>

        <div class="res-hero-inner max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-4">
                <a href="<?php echo e(route('quizzes.show', [$course->slug, $module->slug, $quiz->slug])); ?>" class="res-back-link flex items-center group">
                    <i class="fas fa-arrow-left mr-2 text-xs transition-transform group-hover:-translate-x-1"></i>
                    Back to Quiz
                </a>
            </div>
            <p class="res-eyebrow res-mono text-xs font-semibold uppercase tracking-[0.3em] mb-3">
                <i class="fas fa-chart-line"></i> <span class="res-cursor">QUIZ::RESULTS</span>
            </p>
            <h1 class="res-display text-4xl md:text-5xl font-bold mb-4">Quiz Results</h1>
            <p class="text-lg text-purple-100/90"><?php echo e($quiz->title); ?> - Attempt #<?php echo e($attempt->attempt_number); ?></p>
        </div>
    </div>

    <!-- Results Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Score Card -->
        <div class="mb-12">
            <div class="res-score-card bg-white rounded-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <!-- Score Display -->
                    <div class="bg-gradient-to-br from-purple-600 to-pink-600 text-white p-10 flex flex-col items-center justify-center">
                        <div class="res-score-gauge" style="--pct: <?php echo e($attempt->score_percentage); ?>">
                            <div class="res-score-gauge-inner">
                                <div class="res-val-mono text-4xl font-bold"><?php echo e($attempt->score_percentage); ?>%</div>
                            </div>
                        </div>
                        <div class="text-xl font-semibold mt-5">
                            <?php if($attempt->passed): ?>
                                <span class="flex items-center gap-2 text-emerald-200">
                                    <i class="fas fa-check-circle"></i> Passed!
                                </span>
                            <?php else: ?>
                                <span class="flex items-center gap-2 text-rose-200">
                                    <i class="fas fa-times-circle"></i> Not Passed
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="text-purple-100 text-sm mt-3 res-mono">PASS::<?php echo e($quiz->passing_score); ?>%</p>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gray-50 p-10 flex flex-col justify-center gap-8 border-l border-gray-200">
                        <div class="res-stat-block">
                            <p class="text-gray-600 text-xs font-semibold mb-2 uppercase tracking-wider res-mono">Correct Answers</p>
                            <p class="res-val-mono text-4xl font-bold text-emerald-600"><?php echo e($attempt->correct_answers); ?>/<?php echo e($attempt->total_questions); ?></p>
                        </div>
                        <div class="res-stat-block">
                            <p class="text-gray-600 text-xs font-semibold mb-2 uppercase tracking-wider res-mono">Time Spent</p>
                            <p class="res-val-mono text-2xl font-bold text-gray-800"><?php echo e($attempt->getFormattedTimeSpent()); ?></p>
                        </div>
                    </div>

                    <!-- Attempt Info -->
                    <div class="bg-gray-50 p-10 flex flex-col justify-center gap-8 border-l border-gray-200">
                        <div class="res-stat-block">
                            <p class="text-gray-600 text-xs font-semibold mb-2 uppercase tracking-wider res-mono">Attempt Number</p>
                            <p class="res-val-mono text-4xl font-bold text-violet-600"><?php echo e($attempt->attempt_number); ?>/<?php echo e($quiz->attempt_limit); ?></p>
                        </div>
                        <div class="res-stat-block">
                            <p class="text-gray-600 text-xs font-semibold mb-2 uppercase tracking-wider res-mono">Completed At</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($attempt->completed_at->format('M d, Y')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!empty($isCourseCompleted)): ?>
            <div class="res-cert-banner mb-10 p-6 rounded-3xl text-amber-900">
                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="res-cert-icon">
                            <i class="fas fa-certificate text-lg"></i>
                        </div>
                        <div>
                            <p class="res-display font-semibold text-lg">Course Completed!</p>
                            <p class="text-sm text-amber-700">Your certificate is now available to view, print, or save as a PDF.</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('certificates.show', [$course->slug])); ?>"
                           class="res-action-btn is-amber inline-flex items-center justify-center px-5 py-3 rounded-lg text-white font-semibold">
                            <i class="fas fa-print mr-2"></i>View / Print Certificate
                        </a>
                        <a href="<?php echo e(route('badges.index')); ?>"
                           class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-white border border-amber-500 text-amber-700 font-semibold hover:bg-amber-50 transition">
                            <i class="fas fa-award mr-2"></i>See Badge Earned
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Detailed Review -->
        <div class="mb-12">
            <h2 class="res-display text-3xl font-bold text-gray-800 mb-8">Detailed Review</h2>
            <div class="space-y-6">
                <?php $__currentLoopData = $responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $question = $response->question;
                        $answer = $response->answer;
                        $isCorrect = $response->is_correct;
                    ?>
                    <div class="res-question-card bg-white rounded-lg shadow-lg overflow-hidden border-l-4 <?php echo e($isCorrect ? 'border-emerald-500' : 'border-rose-500'); ?>"
                         style="animation-delay: <?php echo e(min($index * 60, 400)); ?>ms">
                        <div class="p-6">
                            <!-- Question -->
                            <div class="mb-4">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="res-display text-lg font-bold text-gray-800">
                                        Question <?php echo e($index + 1); ?>

                                    </h3>
                                    <?php if($isCorrect): ?>
                                        <span class="inline-block bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-check-circle mr-2"></i>Correct
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-block bg-rose-100 text-rose-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-times-circle mr-2"></i>Incorrect
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-gray-700 text-lg"><?php echo e($question->question_text); ?></p>
                            </div>

                            <!-- User's Answer and Correct Answer -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- User's Answer -->
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-3">Your Answer</h4>
                                    <?php if($question->type === 'short_answer'): ?>
                                        <div class="res-answer-box bg-sky-50 border border-sky-200">
                                            <p class="text-gray-700"><?php echo e($response->answer_text ?? 'No answer provided'); ?></p>
                                            <p class="text-sm text-sky-600 mt-2">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                Pending instructor review
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <div class="res-answer-box bg-sky-50 border-2 border-sky-300">
                                            <p class="text-gray-800 font-semibold"><?php echo e($answer?->answer_text ?? 'No answer selected'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Correct Answer (show if enabled) -->
                                <?php if($showCorrectAnswers && !$isCorrect): ?>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">Correct Answer</h4>
                                        <?php
                                            $correctAnswer = $question->getCorrectAnswer();
                                        ?>
                                        <?php if($correctAnswer): ?>
                                            <div class="res-answer-box bg-emerald-50 border-2 border-emerald-300">
                                                <p class="text-gray-800 font-semibold"><?php echo e($correctAnswer->answer_text); ?></p>
                                            </div>
                                        <?php else: ?>
                                            <div class="res-answer-box bg-gray-50 border border-gray-200">
                                                <p class="text-gray-600">Answer unavailable</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Explanation (if available) -->
                            <?php if($question->explanation && $showCorrectAnswers): ?>
                                <div class="res-answer-box bg-amber-50 border border-amber-200 mt-4">
                                    <h4 class="font-semibold text-amber-900 mb-2">
                                        <i class="fas fa-lightbulb mr-2"></i>Explanation
                                    </h4>
                                    <p class="text-amber-800 text-sm"><?php echo e($question->explanation); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <?php if($attempt->passed): ?>
                <a href="<?php echo e(route('modules.show', [$course->slug, $module->slug])); ?>"
                   class="res-action-btn is-emerald text-white font-bold rounded-lg px-6 py-4 text-center">
                    <i class="fas fa-arrow-right mr-2"></i>Continue to Next
                </a>
                <?php if(!empty($isCourseCompleted) && $isCourseCompleted): ?>
                    <a href="<?php echo e(route('certificates.show', [$course->slug])); ?>"
                       class="res-action-btn is-amber text-white font-bold rounded-lg px-6 py-4 text-center">
                        <i class="fas fa-certificate mr-2"></i>View Certificate
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <?php
                    $canRetry = $attempt->quiz->canUserRetry(auth()->id());
                ?>
                <?php if($canRetry): ?>
                    <a href="<?php echo e(route('quizzes.start', [$course->slug, $module->slug, $quiz->slug])); ?>"
                       class="res-action-btn is-violet text-white font-bold rounded-lg px-6 py-4 text-center">
                        <i class="fas fa-redo mr-2"></i>Retry Quiz
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="<?php echo e(route('quizzes.show', [$course->slug, $module->slug, $quiz->slug])); ?>"
               class="res-action-btn is-slate font-bold rounded-lg px-6 py-4 text-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Quiz
            </a>

            <a href="<?php echo e(route('modules.show', [$course->slug, $module->slug])); ?>"
               class="res-action-btn is-indigo text-white font-bold rounded-lg px-6 py-4 text-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Module
            </a>
        </div>

        <!-- Performance Summary -->
        <div class="res-summary-card bg-white rounded-lg shadow-lg p-8">
            <h2 class="res-display text-2xl font-bold text-gray-800 mb-6">Performance Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Score Breakdown</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Questions Answered</span>
                            <span class="res-val-mono font-semibold"><?php echo e($attempt->total_questions); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Correct Answers</span>
                            <span class="res-val-mono font-semibold text-emerald-600"><?php echo e($attempt->correct_answers); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Incorrect Answers</span>
                            <span class="res-val-mono font-semibold text-rose-600"><?php echo e($attempt->total_questions - $attempt->correct_answers); ?></span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                            <span class="text-gray-800 font-semibold">Accuracy Rate</span>
                            <span class="res-val-mono text-lg font-bold"><?php echo e($attempt->score_percentage); ?>%</span>
                        </div>
                        <div class="res-accuracy-bar">
                            <div class="res-accuracy-fill" style="width: <?php echo e($attempt->score_percentage); ?>%"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Quiz Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Passing Score</span>
                            <span class="res-val-mono font-semibold"><?php echo e($quiz->passing_score); ?>%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Time Limit</span>
                            <span class="res-val-mono font-semibold">
                                <?php if($quiz->time_limit_minutes): ?>
                                    <?php echo e($quiz->time_limit_minutes); ?> min
                                <?php else: ?>
                                    Unlimited
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold">
                                <?php if($attempt->passed): ?>
                                    <span class="text-emerald-600">✓ Passed</span>
                                <?php else: ?>
                                    <span class="text-rose-600">✗ Not Passed</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canvas = document.getElementById('resNetCanvas');
    if (!canvas) return;

    var hero = canvas.closest('.res-hero');
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/courses/quizzes/results.blade.php ENDPATH**/ ?>