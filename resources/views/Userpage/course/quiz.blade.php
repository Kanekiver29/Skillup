@extends('layout.app')

@section('title', 'About SkillUp - Personalized Web Learning for Youth Career Development')
@section('content')

{{--
    Expected variables from the controller:
      $quiz   -> the Quiz being taken, with $quiz->questions (each Question has
                 ->id, ->question (or ->question_text), and ->options — a collection/array
                 of objects with ->id and ->option_text (or ->text). Correct answers
                 should NOT be sent to this view — grade on the server.
      $result -> (optional) present only after a submitted attempt, with
                 ->score (int correct), ->total (int), ->percentage (int),
                 and optionally ->breakdown (collection of {question, selected_text, is_correct}).
      Route  quiz.submit(quiz)  should accept POST answers[question_id] = option_id
      and redirect back to this view with $result set.

    Backward compatibility: if the controller still passes the old $quizzes
    collection, the first item is used as $quiz so this page doesn't break.
--}}
@php
    $quiz = $quiz ?? ($quizzes ?? collect())->first();
    $questions = $quiz->questions ?? collect();
@endphp

<style>
    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --bg: #f3f5fb;
        --text: #101b2e;
        --text-muted: #5b6b85;
        --card-bg: #ffffff;
        --card-border: rgba(16, 27, 46, .06);
        --accent: #c9973b;
        --accent-strong: #e0b054;
        --success: #16a34a;
        --danger: #dc2626;
    }

    html.dark-mode {
        --bg: #070a13;
        --text: #e7ebf5;
        --text-muted: #8b96b4;
        --card-bg: #0e1526;
        --card-border: rgba(255, 255, 255, .06);
        --accent: #e0b054;
        --accent-strong: #f0c476;
        --success: #4ade80;
        --danger: #f87171;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--bg);
        color: var(--text);
        transition: background-color .4s var(--ease), color .4s var(--ease);
    }

    .container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }

    .quiz-header { text-align: center; margin-bottom: 40px; animation: fadeIn .6s var(--ease) both; }
    .quiz-header h1 { font-size: 2.2rem; margin: 0 0 10px; color: var(--text); font-weight: 700; }
    .quiz-header p { color: var(--text-muted); margin: 0; }

    .quiz-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 24px 48px -18px rgba(16, 27, 46, .18);
        animation: slideUp .5s var(--ease) both;
    }

    /* Progress */
    .progress-track {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: .85rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .progress-bar { width: 100%; height: 6px; background: var(--card-border); border-radius: 3px; margin-bottom: 32px; overflow: hidden; }
    .progress-fill { height: 100%; width: 0%; background: linear-gradient(90deg, var(--accent), var(--accent-strong)); border-radius: 3px; transition: width .4s var(--ease); }

    /* Questions */
    .question-container { display: none; animation: fadeSlide .35s var(--ease) both; }
    .question-container.active { display: block; }

    .question-number { color: var(--accent-strong); font-size: .85rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 8px; }
    .question-text { font-size: 1.3rem; font-weight: 700; margin: 0 0 24px; color: var(--text); line-height: 1.55; }

    .options { display: flex; flex-direction: column; gap: 12px; }

    .option {
        display: flex;
        align-items: center;
        padding: 16px;
        border: 2px solid var(--card-border);
        border-radius: 10px;
        background: rgba(224, 176, 84, .05);
        cursor: pointer;
        transition: border-color .2s var(--ease), background .2s var(--ease), transform .2s var(--ease);
        font-weight: 500;
    }

    .option:hover { border-color: var(--accent-strong); background: rgba(224, 176, 84, .15); transform: translateX(4px); }

    .option input[type="radio"] { margin-right: 12px; cursor: pointer; accent-color: var(--accent-strong); width: 18px; height: 18px; flex-shrink: 0; }

    .option.selected { background: linear-gradient(135deg, rgba(224, 176, 84, .2), rgba(224, 176, 84, .1)); border-color: var(--accent-strong); }

    .quiz-card.shake { animation: shake .4s var(--ease); }
    .validation-hint { display: none; color: var(--danger); font-size: .85rem; font-weight: 600; margin-top: 12px; text-align: center; }
    .validation-hint.visible { display: block; }

    .button-group { display: flex; gap: 16px; margin-top: 40px; justify-content: center; }

    .btn { padding: 14px 32px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 1rem; transition: transform .2s var(--ease), box-shadow .2s var(--ease), opacity .2s var(--ease); text-transform: uppercase; letter-spacing: .02em; display: inline-flex; align-items: center; gap: 8px; }

    .btn-primary { background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%); color: #241a04; box-shadow: 0 8px 20px rgba(224, 176, 84, .25); }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(224, 176, 84, .35); }
    .btn-primary:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

    .btn-secondary { background: var(--card-border); color: var(--text); border: 2px solid var(--card-border); }
    .btn-secondary:hover { border-color: var(--accent-strong); color: var(--accent-strong); }
    .btn-secondary:disabled { opacity: .4; cursor: not-allowed; }

    /* Results */
    .quiz-complete { text-align: center; padding: 20px 10px; }
    .score-display { font-size: 4rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 8px; animation: popIn .5s var(--ease) both .1s; }
    .score-fraction { color: var(--text-muted); font-weight: 600; margin-bottom: 20px; }
    .score-message { font-size: 1.5rem; color: var(--text); margin: 0 0 20px; font-weight: 700; }

    .result-progress { width: 100%; max-width: 360px; margin: 0 auto 32px; height: 10px; background: var(--card-border); border-radius: 5px; overflow: hidden; }
    .result-progress-fill { height: 100%; border-radius: 5px; background: linear-gradient(90deg, var(--accent), var(--accent-strong)); width: 0%; transition: width 1s var(--ease) .2s; }

    .breakdown { text-align: left; margin: 0 0 32px; display: flex; flex-direction: column; gap: 10px; }
    .breakdown-item { display: flex; justify-content: space-between; gap: 12px; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--card-border); font-size: .92rem; animation: fadeSlide .4s var(--ease) both; }
    .breakdown-item.correct { color: var(--success); }
    .breakdown-item.incorrect { color: var(--danger); }

    .no-quiz { text-align: center; padding: 60px 20px; color: var(--text-muted); }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeSlide { from { opacity: 0; transform: translateX(12px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes popIn { from { opacity: 0; transform: scale(.7); } to { opacity: 1; transform: scale(1); } }
    @keyframes shake { 10%, 90% { transform: translateX(-2px); } 20%, 80% { transform: translateX(3px); } 30%, 50%, 70% { transform: translateX(-5px); } 40%, 60% { transform: translateX(5px); } }

    @media (prefers-reduced-motion: reduce) {
        .quiz-header, .quiz-card, .question-container, .score-display, .breakdown-item { animation: none !important; }
    }

    /* Quiz redesign: illuminated storybook — a dark cover holding open cream pages */
    #quiz-page {
        --quiz-bg: #0a1224;
        --quiz-cover: #101c36;
        --quiz-cover-edge: #060b16;
        --quiz-cover-trim: rgba(224, 176, 84, .35);
        --quiz-panel: #f8f0da;
        --quiz-panel-alt: #f2e6c8;
        --quiz-line: rgba(36, 26, 8, .16);
        --quiz-ink: #241a08;
        --quiz-muted: #8a7355;
        --quiz-accent: #c9973b;
        --quiz-accent-strong: #e0b054;
        --quiz-accent-soft: rgba(201, 151, 59, .14);
        min-height: calc(100vh - 7rem);
        padding: 3rem 1.25rem 5rem;
        background:
            radial-gradient(circle at 12% -10%, rgba(224, 176, 84, .10), transparent 32%),
            radial-gradient(circle at 100% 20%, rgba(37, 80, 200, .16), transparent 30%),
            var(--quiz-bg);
        color: var(--quiz-ink);
    }

    html[data-skillup-theme="dark"] #quiz-page {
        --quiz-bg: #04070f;
        --quiz-cover: #0b1526;
        --quiz-cover-edge: #020408;
        --quiz-cover-trim: rgba(224, 176, 84, .28);
        --quiz-panel: #141f38;
        --quiz-panel-alt: #101a30;
        --quiz-line: rgba(224, 176, 84, .16);
        --quiz-ink: #edf1fb;
        --quiz-muted: #93a1c4;
        --quiz-accent: #e0b054;
        --quiz-accent-strong: #f0c476;
        --quiz-accent-soft: rgba(224, 176, 84, .14);
    }

    #quiz-page .quiz-shell { max-width: 1000px; margin: 0 auto; }

    #quiz-page .quiz-header { margin: 0 auto 1.75rem; text-align: left; max-width: 760px; }
    #quiz-page .quiz-kicker {
        display: inline-flex; align-items: center; gap: .55rem; margin-bottom: .8rem;
        color: var(--quiz-accent-strong); font: 700 .7rem/1 'JetBrains Mono', monospace;
        letter-spacing: .18em; text-transform: uppercase;
    }
    #quiz-page .quiz-kicker::before { content: ''; width: .5rem; height: .5rem; border-radius: 50%; background: var(--quiz-accent-strong); box-shadow: 0 0 0 .25rem var(--quiz-accent-soft); }
    #quiz-page .quiz-header h1 { color: #f7f1e0; font-size: clamp(2rem, 4vw, 3.2rem); letter-spacing: -.03em; margin-bottom: .55rem; }
    #quiz-page .quiz-header p { color: rgba(247, 241, 224, .62); font-size: 1rem; }

    /* Book cover: the dark outer frame holding the open pages */
    #quiz-page .quiz-card {
        position: relative;
        background: linear-gradient(160deg, var(--quiz-cover) 0%, var(--quiz-cover-edge) 100%);
        border: 1px solid var(--quiz-cover-trim);
        border-radius: 1.6rem;
        padding: clamp(.85rem, 3vw, 1.75rem);
        box-shadow: 0 30px 80px rgba(0, 0, 0, .45), inset 0 0 0 1px rgba(255, 255, 255, .03);
    }

    /* Page surface: the cream, book-like page the questions sit on, with a center spine */
    #quiz-page .page-surface {
        position: relative;
        background:
            linear-gradient(90deg,
                var(--quiz-panel) 0%, var(--quiz-panel) calc(50% - 1px),
                var(--quiz-line) calc(50% - 1px), var(--quiz-line) calc(50% + 1px),
                var(--quiz-panel-alt) calc(50% + 1px), var(--quiz-panel-alt) 100%);
        border-radius: 1.05rem;
        padding: clamp(1.5rem, 4vw, 3rem);
        box-shadow: inset 0 0 46px rgba(0, 0, 0, .10), 0 18px 40px rgba(0, 0, 0, .22);
        overflow: hidden;
        perspective: 1500px;
    }
    #quiz-page .page-surface::before,
    #quiz-page .page-surface::after {
        content: ''; position: absolute; top: 0; bottom: 0; width: 48px; pointer-events: none; z-index: 0;
    }
    #quiz-page .page-surface::before { left: calc(50% - 48px); background: linear-gradient(to right, transparent, rgba(0, 0, 0, .09)); }
    #quiz-page .page-surface::after { left: 50%; background: linear-gradient(to left, transparent, rgba(0, 0, 0, .09)); }

    #quiz-page .progress-track { position: relative; z-index: 1; color: var(--quiz-muted); margin-bottom: .75rem; }
    #quiz-page .progress-track span:last-child { color: var(--quiz-ink); max-width: 45%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    #quiz-page .progress-bar { position: relative; z-index: 1; height: .5rem; background: var(--quiz-accent-soft); margin-bottom: 2.2rem; }
    #quiz-page .progress-fill { background: linear-gradient(90deg, var(--quiz-accent), var(--quiz-accent-strong)); box-shadow: 0 0 16px var(--quiz-accent-soft); }

    #quiz-page .question-number { position: relative; z-index: 1; color: var(--quiz-accent); font: 700 .72rem/1 'JetBrains Mono', monospace; letter-spacing: .16em; }
    #quiz-page .question-text { position: relative; z-index: 1; color: var(--quiz-ink); font-size: clamp(1.25rem, 3vw, 1.75rem); letter-spacing: -.01em; line-height: 1.4; max-width: 46rem; }

    #quiz-page .option { position: relative; z-index: 1; color: var(--quiz-ink); background: rgba(255, 255, 255, .35); border-color: var(--quiz-line); box-shadow: 0 4px 14px rgba(0, 0, 0, .05); }
    html[data-skillup-theme="dark"] #quiz-page .option { background: rgba(255, 255, 255, .03); }
    #quiz-page .option:hover { background: var(--quiz-accent-soft); border-color: var(--quiz-accent); transform: translateX(5px); }
    #quiz-page .option.selected { background: linear-gradient(100deg, var(--quiz-accent-soft), rgba(224, 176, 84, .10)); border-color: var(--quiz-accent); box-shadow: 0 0 0 3px var(--quiz-accent-soft); }

    #quiz-page .button-group { position: relative; z-index: 1; justify-content: space-between; margin-top: 2.5rem; }
    #quiz-page .btn { border-radius: 999px; padding: .85rem 1.5rem; text-transform: none; letter-spacing: 0; }
    #quiz-page .btn-primary { color: var(--quiz-panel); background: linear-gradient(135deg, #241a08, #3a2a10); box-shadow: 0 10px 24px rgba(0, 0, 0, .28); }
    html[data-skillup-theme="dark"] #quiz-page .btn-primary { color: #10192c; background: linear-gradient(135deg, var(--quiz-accent-strong), var(--quiz-accent)); }
    #quiz-page .btn-secondary { background: var(--quiz-accent-soft); border-color: var(--quiz-line); color: var(--quiz-ink); }
    #quiz-page .btn-secondary:hover { color: var(--quiz-accent); }

    #quiz-page .validation-hint { position: relative; z-index: 1; color: #b03a2e; background: rgba(176, 58, 46, .10); border-radius: .65rem; padding: .65rem; }
    #quiz-page .quiz-complete { position: relative; z-index: 1; padding: 1.5rem .5rem; }
    #quiz-page .score-display { color: var(--quiz-accent); font-size: clamp(3.5rem, 10vw, 6rem); letter-spacing: -.05em; }
    #quiz-page .score-fraction, #quiz-page .no-quiz, #quiz-page .quiz-complete p { color: var(--quiz-muted); }
    #quiz-page .score-message { color: var(--quiz-ink); }
    #quiz-page .breakdown-item { border-color: var(--quiz-line); background: rgba(255, 255, 255, .35); }
    html[data-skillup-theme="dark"] #quiz-page .breakdown-item { background: rgba(255, 255, 255, .03); }

    /* Page-turn sweep: the entering question swings in like a page of a book.
       'sweep-next' hinges from the left (advancing forward through the book);
       'sweep-prev' hinges from the right (turning back). Only the incoming
       question animates — the outgoing one simply disappears, same as before. */
    #quiz-page .question-container { animation: none; transform-style: preserve-3d; }
    #quiz-page .question-container.sweep-next {
        transform-origin: left center;
        animation: quizPageSweepNext .55s var(--ease) both;
    }
    #quiz-page .question-container.sweep-prev {
        transform-origin: right center;
        animation: quizPageSweepPrev .55s var(--ease) both;
    }

    @keyframes quizPageSweepNext {
        0%   { transform: rotateY(-92deg) translateX(-4%); opacity: 0; filter: brightness(.85); }
        55%  { opacity: 1; }
        100% { transform: rotateY(0deg) translateX(0); opacity: 1; filter: brightness(1); }
    }
    @keyframes quizPageSweepPrev {
        0%   { transform: rotateY(92deg) translateX(4%); opacity: 0; filter: brightness(.85); }
        55%  { opacity: 1; }
        100% { transform: rotateY(0deg) translateX(0); opacity: 1; filter: brightness(1); }
    }

    @media (max-width: 560px) {
        #quiz-page { padding-inline: .75rem; }
        #quiz-page .button-group { gap: .65rem; }
        #quiz-page .btn { padding-inline: 1.1rem; font-size: .9rem; }
        #quiz-page .progress-track { align-items: flex-start; gap: .75rem; }
    }

    html[data-skillup-reduced-motion="true"] #quiz-page *,
    html[data-skillup-reduced-motion="true"] #quiz-page *::before,
    html[data-skillup-reduced-motion="true"] #quiz-page *::after {
        animation: none !important; transition: none !important;
    }
</style>

<div id="quiz-page">
<div class="quiz-shell">
    <div class="quiz-header">
        <span class="quiz-kicker">Assessment module // ready</span>
        <h1>🎯 Quiz Assessment</h1>
        <p>Test your knowledge and track your progress</p>
    </div>

    <div class="quiz-card" id="quiz-card">
        <div class="page-surface">
        @if (isset($result))
            @php
                $percentage = (int) ($result->percentage ?? 0);
                $tier = $percentage >= 80 ? 'excellent' : ($percentage >= 60 ? 'good' : 'practice');
                $message = match ($tier) {
                    'excellent' => 'Excellent work!',
                    'good' => 'Good job — almost there!',
                    default => 'Keep practicing, you\'ll get it!',
                };
            @endphp
            <div class="quiz-complete">
                <div class="score-display">{{ $percentage }}%</div>
                <p class="score-fraction">{{ $result->score ?? 0 }} of {{ $result->total ?? 0 }} correct</p>
                <div class="score-message">{{ $message }}</div>

                <div class="result-progress"><div class="result-progress-fill" data-target="{{ $percentage }}"></div></div>

                @if (!empty($result->breakdown))
                    <div class="breakdown">
                        @foreach ($result->breakdown as $index => $row)
                            <div class="breakdown-item {{ $row->is_correct ? 'correct' : 'incorrect' }}" style="animation-delay: {{ $index * 60 }}ms">
                                <span>{{ $row->question }}</span>
                                <span>{{ $row->is_correct ? '✓ Correct' : '✗ ' . ($row->selected_text ?? 'No answer') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="button-group">
                    <a href="{{ route('quiz') }}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i> Retake Quiz</a>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Courses</a>
                </div>
            </div>

        @elseif ($quiz && $questions->isNotEmpty())
            <form method="POST" action="{{ route('quiz.submit', $quiz->id) }}" id="quiz-form">
                @csrf

                <div class="progress-track">
                    <span id="progress-label">Question 1 of {{ $questions->count() }}</span>
                    <span>{{ $quiz->title ?? 'Quiz' }}</span>
                </div>
                <div class="progress-bar"><div class="progress-fill" id="progress-fill"></div></div>

                @foreach ($questions as $index => $question)
                    @php
                        $options = $question->options ?? [];
                        $qText = $question->question ?? $question->question_text ?? 'Question';
                    @endphp
                    <div class="question-container {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <div class="question-number">Question {{ $index + 1 }}</div>
                        <div class="question-text">{{ $qText }}</div>
                        <div class="options">
                            @foreach ($options as $option)
                                @php $optionText = $option->option_text ?? $option->text ?? (string) $option; @endphp
                                <label class="option">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id ?? $optionText }}" required>
                                    <span>{{ $optionText }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <p class="validation-hint" id="validation-hint">Please select an answer before continuing.</p>

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" id="prev-btn" disabled><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary" id="next-btn">Next <i class="fa-solid fa-arrow-right"></i></button>
                    <button type="submit" class="btn btn-primary" id="submit-btn" style="display: none;"><i class="fa-solid fa-check"></i> Submit Quiz</button>
                </div>
            </form>

        @else
            <div class="no-quiz">
                <h3 style="font-size: 1.5rem; margin: 0 0 12px; color: var(--text);">📝 No Quizzes Available</h3>
                <p style="margin: 0 0 30px;">Select a course and subject to begin a quiz.</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Back to Courses</a>
            </div>
        @endif
        </div>
    </div>
</div>
</div>

<script>
    (function () {
        var form = document.getElementById('quiz-form');
        if (!form) {
            var resultFill = document.querySelector('.result-progress-fill');
            if (resultFill) {
                requestAnimationFrame(function () {
                    resultFill.style.width = (resultFill.dataset.target || 0) + '%';
                });
            }
            return;
        }

        var questions = Array.prototype.slice.call(form.querySelectorAll('.question-container'));
        if (!questions.length) {
            return;
        }

        var total = questions.length;
        var current = 0;

        var progressFill = document.getElementById('progress-fill');
        var progressLabel = document.getElementById('progress-label');
        var prevBtn = document.getElementById('prev-btn');
        var nextBtn = document.getElementById('next-btn');
        var submitBtn = document.getElementById('submit-btn');
        var hint = document.getElementById('validation-hint');
        var card = document.getElementById('quiz-card');

        function currentIsAnswered() {
            if (!questions[current]) {
                return false;
            }

            var inputs = questions[current].querySelectorAll('input[type="radio"]');
            return Array.prototype.some.call(inputs, function (i) { return i.checked; });
        }

        function updateSelectedStyles(container) {
            container.querySelectorAll('.option').forEach(function (opt) {
                var input = opt.querySelector('input[type="radio"]');
                opt.classList.toggle('selected', !!(input && input.checked));
            });
        }

        function showValidation() {
            if (!hint) {
                return;
            }
            hint.classList.add('visible');
            if (card) {
                card.classList.remove('shake');
                void card.offsetWidth;
                card.classList.add('shake');
            }
        }

        function updateChrome() {
            if (progressFill) {
                progressFill.style.width = (current / total * 100) + '%';
            }
            if (progressLabel) {
                progressLabel.textContent = 'Question ' + (current + 1) + ' of ' + total;
            }
            if (prevBtn) {
                prevBtn.disabled = current === 0;
            }
            if (nextBtn) {
                nextBtn.style.display = current === total - 1 ? 'none' : 'inline-flex';
            }
            if (submitBtn) {
                submitBtn.style.display = current === total - 1 ? 'inline-flex' : 'none';
            }
            if (hint) {
                hint.classList.remove('visible');
            }
        }

        function render(direction) {
            questions.forEach(function (q, i) {
                q.classList.remove('sweep-next', 'sweep-prev');
                q.classList.toggle('active', i === current);
                updateSelectedStyles(q);
            });

            if ((direction === 'next' || direction === 'prev') && questions[current]) {
                questions[current].classList.add('sweep-' + direction);
            }

            updateChrome();
        }

        questions.forEach(function (q) {
            q.addEventListener('change', function () {
                updateSelectedStyles(q);
                if (hint) {
                    hint.classList.remove('visible');
                }
            });
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                if (!currentIsAnswered()) {
                    showValidation();
                    return;
                }
                if (current < total - 1) {
                    current += 1;
                    render('next');
                }
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                if (current > 0) {
                    current -= 1;
                    render('prev');
                }
            });
        }

        form.addEventListener('submit', function (e) {
            var unanswered = questions.filter(function (q) {
                return !q.querySelector('input[type="radio"]:checked');
            });

            if (unanswered.length) {
                e.preventDefault();
                current = questions.indexOf(unanswered[0]);
                if (current < 0) {
                    current = 0;
                }
                render();
                showValidation();
            }
        });

        render();
    })();
</script>

@endsection