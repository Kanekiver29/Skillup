@extends('layout.app')

@section('title', 'Quiz: ' . $quiz->title . ' - SkillUp')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<div class="qz-root">

    <!-- Ambient background layer -->
    <canvas id="qzCanvas" class="qz-canvas" aria-hidden="true"></canvas>
    <div class="qz-grid-overlay" aria-hidden="true"></div>
    <div class="qz-vignette" aria-hidden="true"></div>

    <!-- Quiz Header -->
    <header class="qz-hero">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="qz-hero-top">
                <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" class="qz-exit">
                    <span class="qz-exit-icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Exit Quiz</span>
                </a>

                @if($quiz->time_limit_minutes)
                    <div class="qz-main-timer" id="mainTimerWrap">
                        <svg class="qz-ring" viewBox="0 0 84 84" aria-hidden="true">
                            <circle class="qz-ring-track" cx="42" cy="42" r="36"></circle>
                            <circle class="qz-ring-progress" id="mainRingProgress" cx="42" cy="42" r="36"></circle>
                        </svg>
                        <div class="qz-main-timer-inner">
                            <span id="timer" class="qz-timer-value">{{ $quiz->time_limit_minutes }}:00</span>
                            <span class="qz-timer-label">Remaining</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="qz-hero-title-row">
                <div class="qz-hero-eyebrow">
                    <span class="qz-eyebrow-dot"></span>
                    Attempt {{ $attempt->attempt_number }} / {{ $quiz->attempt_limit }}
                </div>
                <h1 class="qz-title" data-text="{{ $quiz->title }}">{{ $quiz->title }}</h1>
            </div>
        </div>
    </header>

    <!-- Quiz Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 qz-body">
        <form id="quizForm" action="{{ route('quizzes.submit', [$course->slug, $module->slug, $quiz->slug]) }}" method="POST">
            @csrf
            <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

            <!-- Progress Bar -->
            <div class="qz-progress-wrap" role="group" aria-label="Quiz progress">
                <div class="qz-progress-labels">
                    <span class="qz-progress-caption">Progress</span>
                    <span class="qz-progress-count" id="progressText" aria-live="polite">1 of {{ $quiz->questions()->count() }}</span>
                </div>
                <div class="qz-progress-track">
                    <div id="progressBar" class="qz-progress-fill" style="width: 0%">
                        <span class="qz-progress-glow"></span>
                    </div>
                </div>
            </div>

            <!-- Questions Container -->
            <div id="questionsContainer" class="qz-questions">
                @foreach($questions as $index => $question)
                    <div class="qz-card qz-question-item hidden" id="question-{{ $question->id }}" data-question-index="{{ $index }}">

                        <div class="qz-card-glow" aria-hidden="true"></div>

                        <!-- Question Number and Text -->
                        <div class="qz-question-head">
                            <div class="qz-question-head-row">
                                <div class="qz-question-number">
                                    <span class="qz-question-number-tag">Q</span>
                                    <span class="qz-question-number-value">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="qz-question-meta">
                                    <span class="qz-points-chip">
                                        {{ $question->points }} point{{ $question->points !== 1 ? 's' : '' }}
                                    </span>
                                    @if($quiz->time_limit_minutes)
                                        <div class="qz-qtimer" id="questionTimerContainer-{{ $question->id }}">
                                            <svg class="qz-qring" viewBox="0 0 40 40" aria-hidden="true">
                                                <circle class="qz-qring-track" cx="20" cy="20" r="16"></circle>
                                                <circle class="qz-qring-progress" id="qringProgress-{{ $question->id }}" cx="20" cy="20" r="16"></circle>
                                            </svg>
                                            <span class="qz-qtimer-value" id="qtimerValue-{{ $question->id }}">2:00</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <p class="qz-question-text">{{ $question->question_text }}</p>
                        </div>

                        <!-- Answer Options -->
                        <div class="qz-options" role="group" aria-label="Answer options">
                            @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                                @foreach($question->answers()->get() as $answer)
                                    <label class="qz-option" id="answer-label-{{ $answer->id }}" style="--stagger: {{ $loop->index }}">
                                        <input type="radio"
                                               name="responses[{{ $question->id }}]"
                                               value="{{ $answer->id }}"
                                               class="qz-option-input answer-radio"
                                               data-question-id="{{ $question->id }}"
                                               data-is-correct="{{ $answer->is_correct ? 1 : 0 }}"
                                               onchange="updateQuestionStatus({{ $question->id }}, this)">
                                        <span class="qz-option-shell">
                                            <span class="qz-option-marker" aria-hidden="true">
                                                <span class="qz-option-marker-dot"></span>
                                            </span>
                                            <span class="qz-option-text">{{ $answer->answer_text }}</span>
                                            <span class="qz-option-result" aria-hidden="true">
                                                <i class="fas fa-check qz-icon-correct"></i>
                                                <i class="fas fa-xmark qz-icon-incorrect"></i>
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            @elseif($question->type === 'short_answer')
                                <div class="qz-textarea-wrap">
                                    <textarea name="responses[{{ $question->id }}]"
                                              class="qz-textarea"
                                              rows="4"
                                              placeholder="Type your answer here..."
                                              onchange="updateQuestionStatus({{ $question->id }})"></textarea>
                                    <span class="qz-textarea-corner qz-tc-tl" aria-hidden="true"></span>
                                    <span class="qz-textarea-corner qz-tc-br" aria-hidden="true"></span>
                                </div>
                            @endif
                        </div>

                        <!-- Explanation (if available, shown after answering) -->
                        @if($question->explanation)
                            <div id="explanation-{{ $question->id }}" class="qz-explanation hidden">
                                <h4 class="qz-explanation-title">
                                    <i class="fas fa-lightbulb"></i>Explanation
                                </h4>
                                <p class="qz-explanation-text">{{ $question->explanation }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="qz-navbar">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 qz-navbar-inner">
                    <button type="button" id="prevBtn" onclick="previousQuestion()" class="qz-btn qz-btn-ghost">
                        <i class="fas fa-chevron-left"></i><span>Previous</span>
                    </button>

                    <div class="qz-answered-pill" aria-live="polite">
                        <span id="answeredNumber">0</span><span class="qz-answered-sep">/</span><span id="totalNumber">{{ $quiz->questions()->count() }}</span>
                        <span class="qz-answered-label">Answered</span>
                    </div>

                    <div class="qz-navbar-right">
                        <button type="button" id="nextBtn" onclick="nextQuestion()" class="qz-btn qz-btn-ghost">
                            <span>Next</span><i class="fas fa-chevron-right"></i>
                        </button>

                        <button type="button" id="submitBtn" onclick="submitQuiz(event)" class="qz-btn qz-btn-submit hidden">
                            <i class="fas fa-check"></i><span>Submit Quiz</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Question Indicators -->
            <div class="qz-indicators-wrap">
                <h3 class="qz-indicators-title">Question Review</h3>
                <div class="qz-indicators-grid" id="questionIndicators" role="group" aria-label="Jump to question">
                    @foreach($questions as $index => $question)
                        <button type="button"
                                class="qz-indicator"
                                onclick="goToQuestion({{ $index }})"
                                id="indicator-{{ $index }}"
                                data-question-index="{{ $index }}"
                                title="Question {{ $index + 1 }}"
                                aria-label="Go to question {{ $index + 1 }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        let currentQuestionIndex = 0;
        const totalQuestions = {{ $quiz->questions()->count() }};
        const timeLimit = {{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes * 60 : 'null' }};
        const answeredQuestions = new Set();
        const questionTimers = {};
        const QUESTION_SECONDS = 120;

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const MAIN_RING_CIRCUMFERENCE = 2 * Math.PI * 36;
        const Q_RING_CIRCUMFERENCE = 2 * Math.PI * 16;

        function setRing(el, circumference, fraction) {
            if (!el) return;
            const clamped = Math.max(0, Math.min(1, fraction));
            el.style.strokeDasharray = `${circumference}`;
            el.style.strokeDashoffset = `${circumference * (1 - clamped)}`;
        }

        // ---------- Init ----------
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('mainRingProgress') && (document.getElementById('mainRingProgress').style.strokeDasharray = MAIN_RING_CIRCUMFERENCE);
            showQuestion(0);
            initializeTimer();
            updateIndicators();
            initParticles();
        });

        // ---------- Question navigation ----------
        function showQuestion(index) {
            document.querySelectorAll('.qz-question-item').forEach(q => q.classList.add('hidden'));

            const currentQ = document.getElementById(`question-${getQuestionIdByIndex(index)}`);
            if (currentQ) {
                currentQ.classList.remove('hidden');
                currentQ.classList.remove('qz-enter');
                // restart entrance animation
                void currentQ.offsetWidth;
                currentQ.classList.add('qz-enter');
            }

            currentQuestionIndex = index;
            updateNavigationButtons();
            updateProgressBar();
            updateProgressText();
            updateIndicators();
            startPerQuestionTimer(index);
        }

        function startPerQuestionTimer(index) {
            Object.values(questionTimers).forEach(t => clearInterval(t.interval));
            if (!timeLimit) return;

            const qId = getQuestionIdByIndex(index);
            if (!qId) return;
            const valueEl = document.getElementById(`qtimerValue-${qId}`);
            const ringEl = document.getElementById(`qringProgress-${qId}`);
            const wrap = document.getElementById(`questionTimerContainer-${qId}`);
            if (!valueEl || !ringEl) return;

            let remaining = QUESTION_SECONDS;
            valueEl.textContent = formatTime(remaining);
            setRing(ringEl, Q_RING_CIRCUMFERENCE, remaining / QUESTION_SECONDS);
            wrap && wrap.classList.remove('qz-qtimer-danger');

            const interval = setInterval(() => {
                remaining--;
                setRing(ringEl, Q_RING_CIRCUMFERENCE, remaining / QUESTION_SECONDS);
                if (remaining <= 30) wrap && wrap.classList.add('qz-qtimer-danger');
                valueEl.textContent = formatTime(Math.max(remaining, 0));

                if (remaining <= 0) {
                    clearInterval(interval);
                    answeredQuestions.add(parseInt(qId));
                    updateIndicators();
                    updateAnsweredCount();
                    if (currentQuestionIndex < totalQuestions - 1) nextQuestion();
                    else submitQuiz();
                }
            }, 1000);

            questionTimers[qId] = { interval };
        }

        function formatTime(sec) {
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return `${m}:${s.toString().padStart(2, '0')}`;
        }

        function nextQuestion() {
            if (currentQuestionIndex < totalQuestions - 1) {
                showQuestion(currentQuestionIndex + 1);
                scrollToTop();
            }
        }

        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                showQuestion(currentQuestionIndex - 1);
                scrollToTop();
            }
        }

        function goToQuestion(index) {
            showQuestion(index);
            scrollToTop();
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
        }

        function getQuestionIdByIndex(index) {
            const items = document.querySelectorAll('.qz-question-item');
            return items[index] ? items[index].id.replace('question-', '') : null;
        }

        // ---------- Answer handling ----------
        function updateQuestionStatus(questionId, inputEl) {
            answeredQuestions.add(questionId);
            updateIndicators();
            updateAnsweredCount();

            if (inputEl) {
                const isCorrect = inputEl.dataset.isCorrect === '1';
                const labels = document.querySelectorAll(`#question-${questionId} .qz-option`);
                labels.forEach(lbl => lbl.classList.remove('qz-option-correct', 'qz-option-incorrect', 'qz-option-selected'));

                const chosenLabel = inputEl.closest('.qz-option');
                if (chosenLabel) {
                    chosenLabel.classList.add('qz-option-selected');
                    chosenLabel.classList.add(isCorrect ? 'qz-option-correct' : 'qz-option-incorrect');
                }

                const expl = document.getElementById(`explanation-${questionId}`);
                if (expl) {
                    expl.classList.remove('hidden');
                    void expl.offsetWidth;
                    expl.classList.add('qz-enter');
                }

                window.clearTimeout(updateQuestionStatus._advanceTimeout);
                updateQuestionStatus._advanceTimeout = setTimeout(() => {
                    if (currentQuestionIndex < totalQuestions - 1) nextQuestion();
                    else submitQuiz();
                }, prefersReducedMotion ? 400 : 900);
            }
        }

        // ---------- UI state ----------
        function updateIndicators() {
            document.querySelectorAll('.qz-indicator').forEach((btn, index) => {
                const questionId = getQuestionIdByIndex(index);
                const isAnswered = questionId && answeredQuestions.has(parseInt(questionId));

                btn.classList.remove('qz-indicator-current', 'qz-indicator-answered');

                if (index === currentQuestionIndex) {
                    btn.classList.add('qz-indicator-current');
                } else if (isAnswered) {
                    btn.classList.add('qz-indicator-answered');
                }
            });
        }

        function updateNavigationButtons() {
            document.getElementById('prevBtn').disabled = currentQuestionIndex === 0;
            document.getElementById('nextBtn').classList.toggle('hidden', currentQuestionIndex === totalQuestions - 1);
            document.getElementById('submitBtn').classList.toggle('hidden', currentQuestionIndex !== totalQuestions - 1);
        }

        function updateProgressBar() {
            const percentage = ((currentQuestionIndex + 1) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = percentage + '%';
        }

        function updateProgressText() {
            document.getElementById('progressText').textContent = (currentQuestionIndex + 1) + ' of ' + totalQuestions;
        }

        function updateAnsweredCount() {
            document.getElementById('answeredNumber').textContent = answeredQuestions.size;
        }

        // ---------- Main timer ----------
        function initializeTimer() {
            if (!timeLimit) return;

            let timeRemaining = timeLimit;
            const ringEl = document.getElementById('mainRingProgress');
            const timerEl = document.getElementById('timer');

            const updateTimer = () => {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                if (timerEl) timerEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                setRing(ringEl, MAIN_RING_CIRCUMFERENCE, timeRemaining / timeLimit);

                const wrap = document.getElementById('mainTimerWrap');
                if (timeRemaining < 300 && wrap) {
                    wrap.classList.add('qz-timer-danger');
                }

                if (timeRemaining <= 0) {
                    submitQuiz();
                    return;
                }

                timeRemaining--;
            };

            updateTimer();
            setInterval(updateTimer, 1000);
        }

        // ---------- Submit ----------
        function submitQuiz(event) {
            if (event) event.preventDefault();

            let allAnswered = true;
            for (let i = 0; i < totalQuestions; i++) {
                const questionId = getQuestionIdByIndex(i);
                if (!answeredQuestions.has(parseInt(questionId))) {
                    allAnswered = false;
                    break;
                }
            }

            if (!allAnswered) {
                if (!confirm('You have not answered all questions. Submit anyway?')) {
                    return;
                }
            }

            document.getElementById('quizForm').submit();
        }

        // ---------- Keyboard navigation ----------
        document.addEventListener('keydown', function (e) {
            const tag = (e.target.tagName || '').toLowerCase();
            if (tag === 'textarea' || tag === 'input') return;

            if (e.key === 'ArrowRight') nextQuestion();
            if (e.key === 'ArrowLeft') previousQuestion();
        });

        // ---------- Ambient particle field ----------
        function initParticles() {
            const canvas = document.getElementById('qzCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let width, height, particles;

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }

            function createParticles() {
                const count = Math.min(70, Math.floor((width * height) / 22000));
                particles = Array.from({ length: count }, () => ({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.25,
                    vy: (Math.random() - 0.5) * 0.25,
                    r: Math.random() * 1.6 + 0.6
                }));
            }

            function draw() {
                ctx.clearRect(0, 0, width, height);

                particles.forEach(p => {
                    if (!prefersReducedMotion) {
                        p.x += p.vx;
                        p.y += p.vy;
                        if (p.x < 0 || p.x > width) p.vx *= -1;
                        if (p.y < 0 || p.y > height) p.vy *= -1;
                    }
                });

                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const a = particles[i], b = particles[j];
                        const dx = a.x - b.x, dy = a.y - b.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 130) {
                            ctx.strokeStyle = `rgba(124, 145, 255, ${0.14 * (1 - dist / 130)})`;
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(a.x, a.y);
                            ctx.lineTo(b.x, b.y);
                            ctx.stroke();
                        }
                    }
                }

                particles.forEach(p => {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(159, 178, 255, 0.55)';
                    ctx.fill();
                });

                if (!prefersReducedMotion) requestAnimationFrame(draw);
            }

            resize();
            createParticles();
            draw();

            window.addEventListener('resize', () => {
                resize();
                createParticles();
                if (prefersReducedMotion) draw();
            });
        }

        // expose functions used by inline handlers
        window.previousQuestion = previousQuestion;
        window.nextQuestion = nextQuestion;
        window.goToQuestion = goToQuestion;
        window.submitQuiz = submitQuiz;
        window.updateQuestionStatus = updateQuestionStatus;
    })();
</script>

<style>
    :root {
        --qz-bg: #05060f;
        --qz-bg-alt: #0a0e1f;
        --qz-surface: rgba(19, 22, 41, 0.6);
        --qz-surface-solid: #10132a;
        --qz-border: rgba(124, 145, 255, 0.18);
        --qz-violet: #8b7bff;
        --qz-cyan: #4fe3d0;
        --qz-magenta: #ff5fb0;
        --qz-green: #37e6a0;
        --qz-red: #ff5470;
        --qz-text: #eef0ff;
        --qz-muted: #9aa2c7;
        --qz-font-display: 'Syne', sans-serif;
        --qz-font-body: 'DM Sans', sans-serif;
        --qz-font-mono: 'JetBrains Mono', monospace;
    }

    .qz-root {
        position: relative;
        background: radial-gradient(120% 90% at 15% -10%, #1a1f3f 0%, var(--qz-bg) 55%),
                    radial-gradient(100% 80% at 100% 0%, rgba(255, 95, 176, 0.12) 0%, transparent 55%),
                    var(--qz-bg);
        color: var(--qz-text);
        font-family: var(--qz-font-body);
        min-height: 100vh;
        overflow-x: hidden;
        isolation: isolate;
    }

    .qz-canvas {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        opacity: 0.8;
    }

    .qz-grid-overlay {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background-image:
            linear-gradient(rgba(124, 145, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(124, 145, 255, 0.05) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: radial-gradient(80% 60% at 50% 0%, black, transparent 80%);
    }

    .qz-vignette {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        box-shadow: inset 0 0 220px rgba(0, 0, 0, 0.65);
    }

    .qz-root > * {
        position: relative;
        z-index: 1;
    }

    /* ---------- Hero ---------- */
    .qz-hero {
        padding: 2.5rem 0 2.75rem;
        border-bottom: 1px solid var(--qz-border);
        background: linear-gradient(180deg, rgba(139, 123, 255, 0.08), transparent 70%);
    }

    .qz-hero-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }

    .qz-exit {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--qz-muted);
        font-family: var(--qz-font-mono);
        font-size: 0.85rem;
        letter-spacing: 0.03em;
        text-decoration: none;
        padding: 0.5rem 0.9rem 0.5rem 0.6rem;
        border: 1px solid var(--qz-border);
        border-radius: 999px;
        background: rgba(10, 12, 26, 0.4);
        transition: color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }

    .qz-exit-icon {
        display: inline-flex;
        width: 1.6rem;
        height: 1.6rem;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(124, 145, 255, 0.12);
    }

    .qz-exit:hover {
        color: var(--qz-text);
        border-color: var(--qz-violet);
        transform: translateX(-2px);
    }

    .qz-main-timer {
        position: relative;
        width: 84px;
        height: 84px;
        flex-shrink: 0;
    }

    .qz-ring {
        width: 84px;
        height: 84px;
        transform: rotate(-90deg);
    }

    .qz-ring-track, .qz-qring-track {
        fill: none;
        stroke: rgba(124, 145, 255, 0.14);
        stroke-width: 5;
    }

    .qz-ring-progress {
        fill: none;
        stroke: url(#none);
        stroke: var(--qz-cyan);
        stroke-width: 5;
        stroke-linecap: round;
        transition: stroke-dashoffset 1s linear, stroke 0.3s ease;
    }

    .qz-main-timer-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .qz-timer-value {
        font-family: var(--qz-font-mono);
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--qz-text);
    }

    .qz-timer-label {
        font-family: var(--qz-font-mono);
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--qz-muted);
    }

    .qz-timer-danger .qz-ring-progress { stroke: var(--qz-red); }
    .qz-timer-danger .qz-timer-value { color: var(--qz-red); }
    .qz-timer-danger { animation: qzPulseSoft 1s ease-in-out infinite; }

    .qz-hero-title-row {
        margin-top: 1.75rem;
    }

    .qz-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--qz-font-mono);
        font-size: 0.75rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--qz-cyan);
        margin-bottom: 0.6rem;
    }

    .qz-eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--qz-cyan);
        box-shadow: 0 0 10px var(--qz-cyan);
    }

    .qz-title {
        font-family: var(--qz-font-display);
        font-weight: 800;
        font-size: clamp(1.9rem, 4vw, 2.9rem);
        line-height: 1.1;
        letter-spacing: -0.01em;
        background: linear-gradient(100deg, #ffffff 10%, var(--qz-cyan) 50%, var(--qz-violet) 90%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* ---------- Body ---------- */
    .qz-body {
        padding-top: 2.75rem;
        padding-bottom: 8rem;
    }

    .qz-progress-wrap { margin-bottom: 2.5rem; }

    .qz-progress-labels {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.6rem;
        font-family: var(--qz-font-mono);
        font-size: 0.8rem;
    }

    .qz-progress-caption {
        color: var(--qz-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .qz-progress-count { color: var(--qz-text); font-weight: 600; }

    .qz-progress-track {
        position: relative;
        width: 100%;
        height: 6px;
        border-radius: 999px;
        background: rgba(124, 145, 255, 0.12);
        overflow: hidden;
    }

    .qz-progress-fill {
        position: relative;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--qz-violet), var(--qz-cyan));
        transition: width 0.4s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .qz-progress-glow {
        position: absolute;
        right: -3px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--qz-cyan);
        box-shadow: 0 0 12px 3px var(--qz-cyan);
    }

    /* ---------- Question card ---------- */
    .qz-questions { position: relative; }

    .qz-card {
        position: relative;
        background: var(--qz-surface);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid var(--qz-border);
        border-radius: 20px;
        padding: 2.25rem;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .qz-card-glow {
        position: absolute;
        top: -60%;
        right: -20%;
        width: 60%;
        height: 220%;
        background: radial-gradient(closest-side, rgba(139, 123, 255, 0.18), transparent 70%);
        pointer-events: none;
    }

    .qz-question-item.qz-enter {
        animation: qzCardIn 0.55s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }

    .qz-question-head-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .qz-question-number {
        display: flex;
        align-items: baseline;
        gap: 0.35rem;
        font-family: var(--qz-font-display);
    }

    .qz-question-number-tag {
        font-size: 1.1rem;
        color: var(--qz-cyan);
        font-weight: 700;
    }

    .qz-question-number-value {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--qz-text);
        letter-spacing: -0.02em;
    }

    .qz-question-meta {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex-shrink: 0;
    }

    .qz-points-chip {
        font-family: var(--qz-font-mono);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        border: 1px solid rgba(79, 227, 208, 0.35);
        background: rgba(79, 227, 208, 0.08);
        color: var(--qz-cyan);
        white-space: nowrap;
    }

    .qz-qtimer {
        position: relative;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qz-qring { width: 40px; height: 40px; transform: rotate(-90deg); }

    .qz-qring-progress {
        fill: none;
        stroke: var(--qz-violet);
        stroke-width: 3.5;
        stroke-linecap: round;
        transition: stroke-dashoffset 1s linear, stroke 0.3s ease;
    }

    .qz-qtimer-value {
        position: absolute;
        font-family: var(--qz-font-mono);
        font-size: 0.55rem;
        color: var(--qz-muted);
    }

    .qz-qtimer-danger .qz-qring-progress { stroke: var(--qz-red); }
    .qz-qtimer-danger .qz-qtimer-value { color: var(--qz-red); }

    .qz-question-text {
        font-size: 1.2rem;
        line-height: 1.6;
        color: var(--qz-text);
        font-weight: 500;
    }

    /* ---------- Options ---------- */
    .qz-options {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        margin: 1.75rem 0 1rem;
    }

    .qz-option {
        position: relative;
        display: block;
        cursor: pointer;
        animation: qzOptionIn 0.4s ease both;
        animation-delay: calc(var(--stagger, 0) * 60ms);
    }

    .qz-option-input {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
        pointer-events: none;
    }

    .qz-option-shell {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.15rem;
        border-radius: 14px;
        border: 1.5px solid rgba(124, 145, 255, 0.16);
        background: rgba(12, 15, 32, 0.5);
        transition: border-color 0.2s ease, background 0.2s ease, transform 0.15s ease;
    }

    .qz-option:hover .qz-option-shell {
        border-color: var(--qz-violet);
        background: rgba(139, 123, 255, 0.08);
        transform: translateX(3px);
    }

    .qz-option-marker {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid rgba(124, 145, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.2s ease;
    }

    .qz-option-marker-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: transparent;
        transition: background 0.2s ease, box-shadow 0.2s ease;
    }

    .qz-option-text {
        flex: 1;
        color: var(--qz-text);
        font-size: 1rem;
    }

    .qz-option-result {
        display: none;
        font-size: 1rem;
    }

    .qz-icon-correct { color: var(--qz-green); }
    .qz-icon-incorrect { color: var(--qz-red); }

    .qz-option-input:focus-visible ~ .qz-option-shell {
        outline: 2px solid var(--qz-cyan);
        outline-offset: 2px;
    }

    .qz-option-selected .qz-option-marker { border-color: var(--qz-violet); }
    .qz-option-selected .qz-option-marker-dot { background: var(--qz-violet); }

    .qz-option-correct .qz-option-shell {
        border-color: var(--qz-green);
        background: rgba(55, 230, 160, 0.08);
        box-shadow: 0 0 24px rgba(55, 230, 160, 0.15);
    }
    .qz-option-correct .qz-option-marker { border-color: var(--qz-green); }
    .qz-option-correct .qz-option-marker-dot { background: var(--qz-green); }
    .qz-option-correct .qz-icon-correct { display: inline-block; }
    .qz-option-correct .qz-option-result { display: inline-flex; }

    .qz-option-incorrect .qz-option-shell {
        border-color: var(--qz-red);
        background: rgba(255, 84, 112, 0.08);
        box-shadow: 0 0 24px rgba(255, 84, 112, 0.15);
    }
    .qz-option-incorrect .qz-option-marker { border-color: var(--qz-red); }
    .qz-option-incorrect .qz-option-marker-dot { background: var(--qz-red); }
    .qz-option-incorrect .qz-icon-incorrect { display: inline-block; }
    .qz-option-incorrect .qz-option-result { display: inline-flex; }

    /* ---------- Textarea ---------- */
    .qz-textarea-wrap { position: relative; }

    .qz-textarea {
        width: 100%;
        border-radius: 14px;
        border: 1.5px solid rgba(124, 145, 255, 0.2);
        background: rgba(12, 15, 32, 0.5);
        color: var(--qz-text);
        font-family: var(--qz-font-body);
        font-size: 1rem;
        padding: 1rem 1.15rem;
        resize: vertical;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .qz-textarea:focus {
        outline: none;
        border-color: var(--qz-cyan);
        box-shadow: 0 0 0 3px rgba(79, 227, 208, 0.14);
    }

    .qz-textarea::placeholder { color: var(--qz-muted); }

    .qz-textarea-corner {
        position: absolute;
        width: 16px;
        height: 16px;
        border-color: var(--qz-cyan);
        pointer-events: none;
        opacity: 0.7;
    }
    .qz-tc-tl { top: -1px; left: -1px; border-top: 2px solid; border-left: 2px solid; border-top-left-radius: 10px; }
    .qz-tc-br { bottom: -1px; right: -1px; border-bottom: 2px solid; border-right: 2px solid; border-bottom-right-radius: 10px; }

    /* ---------- Explanation ---------- */
    .qz-explanation {
        margin-top: 1.25rem;
        padding: 1.1rem 1.25rem;
        border-radius: 14px;
        border: 1px solid rgba(79, 227, 208, 0.3);
        background: rgba(79, 227, 208, 0.06);
    }

    .qz-explanation.qz-enter { animation: qzSlideDown 0.4s ease both; }

    .qz-explanation-title {
        font-family: var(--qz-font-mono);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--qz-cyan);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .qz-explanation-text {
        color: var(--qz-muted);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    /* ---------- Bottom nav ---------- */
    .qz-navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 40;
        background: rgba(8, 10, 22, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid var(--qz-border);
    }

    .qz-navbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
    }

    .qz-navbar-right { display: flex; gap: 0.75rem; }

    .qz-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-family: var(--qz-font-mono);
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        border-radius: 12px;
        padding: 0.75rem 1.3rem;
        border: 1.5px solid transparent;
        cursor: pointer;
        transition: transform 0.15s ease, border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    }

    .qz-btn:disabled { opacity: 0.35; cursor: not-allowed; }

    .qz-btn-ghost {
        color: var(--qz-text);
        background: rgba(124, 145, 255, 0.08);
        border-color: rgba(124, 145, 255, 0.25);
    }

    .qz-btn-ghost:hover:not(:disabled) {
        border-color: var(--qz-violet);
        transform: translateY(-1px);
    }

    .qz-btn-submit {
        color: #05060f;
        background: linear-gradient(100deg, var(--qz-cyan), var(--qz-green));
        box-shadow: 0 0 22px rgba(79, 227, 208, 0.35);
    }

    .qz-btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 0 30px rgba(79, 227, 208, 0.5);
    }

    .qz-answered-pill {
        font-family: var(--qz-font-mono);
        font-size: 0.85rem;
        color: var(--qz-text);
        background: rgba(124, 145, 255, 0.08);
        border: 1px solid var(--qz-border);
        border-radius: 999px;
        padding: 0.6rem 1.1rem;
        white-space: nowrap;
    }

    .qz-answered-sep { color: var(--qz-muted); margin: 0 0.15rem; }
    .qz-answered-label { color: var(--qz-muted); margin-left: 0.4rem; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.06em; }

    /* ---------- Indicators ---------- */
    .qz-indicators-wrap { margin-top: 2.5rem; padding-bottom: 6.5rem; }

    .qz-indicators-title {
        font-family: var(--qz-font-display);
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--qz-text);
        margin-bottom: 1rem;
    }

    .qz-indicators-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.6rem;
    }

    @media (min-width: 768px) { .qz-indicators-grid { grid-template-columns: repeat(8, 1fr); } }
    @media (min-width: 1024px) { .qz-indicators-grid { grid-template-columns: repeat(10, 1fr); } }

    .qz-indicator {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 10px;
        border: 1.5px solid rgba(124, 145, 255, 0.2);
        background: rgba(12, 15, 32, 0.5);
        color: var(--qz-muted);
        font-family: var(--qz-font-mono);
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease, transform 0.15s ease;
    }

    .qz-indicator:hover { transform: translateY(-2px); border-color: var(--qz-violet); }

    .qz-indicator-current {
        color: #05060f;
        background: linear-gradient(120deg, var(--qz-violet), var(--qz-cyan));
        border-color: transparent;
        box-shadow: 0 0 16px rgba(139, 123, 255, 0.5);
    }

    .qz-indicator-answered {
        color: var(--qz-green);
        border-color: rgba(55, 230, 160, 0.4);
        background: rgba(55, 230, 160, 0.08);
    }

    /* ---------- Utility ---------- */
    .hidden { display: none !important; }

    /* ---------- Animations ---------- */
    @keyframes qzCardIn {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes qzOptionIn {
        from { opacity: 0; transform: translateX(-8px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes qzSlideDown {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes qzPulseSoft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    @media (prefers-reduced-motion: reduce) {
        .qz-question-item.qz-enter,
        .qz-option,
        .qz-explanation.qz-enter,
        .qz-timer-danger {
            animation: none !important;
        }
        .qz-btn, .qz-indicator, .qz-option-shell {
            transition: none !important;
        }
    }
</style>

@endsection