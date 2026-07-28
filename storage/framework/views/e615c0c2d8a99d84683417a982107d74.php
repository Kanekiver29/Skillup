

<?php $__env->startSection('title', 'Quiz Questionnaire'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .questionnaire-shell {
        padding: 2rem 1rem 3rem;
        min-height: 100vh;
        background: #f8fafc;
    }

    .questionnaire-card {
        background: white;
        border: 1px solid rgba(148, 163, 184, .18);
        border-radius: 1.75rem;
        box-shadow: 0 24px 70px -52px rgba(15, 23, 42, 0.2);
        padding: 2rem;
    }

    .question-block {
        border-radius: 1.5rem;
        border: 1px solid rgba(148, 163, 184, .16);
        background: #f8fafc;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .question-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
    }

    .field-label {
        display: block;
        margin-bottom: 0.65rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
    }

    .field-input,
    .field-textarea,
    .field-select {
        width: 100%;
        border-radius: 1rem;
        border: 1px solid #cbd5e1;
        background: white;
        color: #0f172a;
        padding: 0.95rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .field-input:focus,
    .field-textarea:focus,
    .field-select:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
    }

    .radio-grid {
        display: grid;
        gap: 0.75rem;
    }

    .radio-option {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0.85rem;
        align-items: flex-start;
        padding: 1rem;
        border-radius: 1rem;
        background: white;
        border: 1px solid rgba(148, 163, 184, .16);
    }

    .radio-option.selected {
        border-color: #38bdf8;
        background: rgba(14, 165, 233, 0.08);
    }

    .radio-option input[type="radio"] {
        margin-top: 0.3rem;
    }

    .radio-label {
        font-size: 0.95rem;
        color: #0f172a;
        line-height: 1.5;
    }

    .question-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .button-primary,
    .button-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        border-radius: 1.25rem;
        padding: 0.95rem 1.4rem;
        font-weight: 700;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .button-primary {
        background: #0ea5e9;
        color: white;
        border: 1px solid transparent;
    }

    .button-primary:hover {
        background: #0284c7;
        transform: translateY(-1px);
    }

    .button-secondary {
        background: #f1f5f9;
        color: #0f172a;
        border: 1px solid rgba(15, 23, 42, 0.08);
    }

    .button-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .flash-success {
        border: 1px solid #d1fae5;
        background: #ecfdf5;
        color: #166534;
        padding: 1rem 1.25rem;
        border-radius: 1.25rem;
        margin-bottom: 1.5rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto max-w-6xl py-10 px-4 questionnaire-shell">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-sky-600">Quiz questionnaire</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Edit quiz questions & answers</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Manage up to 10 questions for this quiz and mark the correct answer for each.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('staff.quizzes.edit', $quiz)); ?>" class="button-secondary">Edit quiz details</a>
                <a href="<?php echo e(route('staff.quizzes.list')); ?>" class="button-secondary">Back to quizzes</a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="flash-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="flash-success" style="background: #fee2e2; border-color: #fecaca; color: #991b1b;">
                <p class="font-semibold">We could not save the questionnaire. Review each question and answer field.</p>
            </div>
        <?php endif; ?>

        <div class="questionnaire-card">
            <form method="POST" action="<?php echo e(route('staff.quizzes.questionnaire.store', $quiz)); ?>">
                <?php echo csrf_field(); ?>

                <?php $__currentLoopData = range(0, 9); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $question = $quiz->questions->firstWhere('order', $index);
                        $existingAnswers = $question?->answers->keyBy('order') ?? collect();
                    ?>

                    <div class="question-block">
                        <div class="question-title">Question <?php echo e($index + 1); ?></div>

                        <div class="grid gap-4 lg:grid-cols-[1fr_120px]">
                            <div>
                                <label class="field-label" for="questions_<?php echo e($index); ?>_question_text">Question text</label>
                                <textarea id="questions_<?php echo e($index); ?>_question_text" name="questions[<?php echo e($index); ?>][question_text]" rows="3" class="field-textarea"><?php echo e(old('questions.'.$index.'.question_text', $question?->question_text ?? '')); ?></textarea>
                            </div>
                            <div>
                                <label class="field-label" for="questions_<?php echo e($index); ?>_points">Points</label>
                                <input id="questions_<?php echo e($index); ?>_points" type="number" min="1" max="20" name="questions[<?php echo e($index); ?>][points]" value="<?php echo e(old('questions.'.$index.'.points', $question?->points ?? 1)); ?>" class="field-input" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="mb-3 text-sm font-semibold text-slate-700">Answer options</div>
                            <div class="radio-grid">
                                <?php $__currentLoopData = range(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $answer = $existingAnswers->get($answerIndex);
                                        $answerText = old('questions.'.$index.'.answers.'.$answerIndex.'.answer_text', $answer?->answer_text ?? '');
                                        $correctValue = old('questions.'.$index.'.correct', $question?->answers->firstWhere('is_correct', true)?->order ?? null);
                                        $isCorrect = (string)$correctValue === (string)$answerIndex;
                                    ?>

                                    <label class="radio-option <?php echo e($isCorrect ? 'selected' : ''); ?>">
                                        <input type="radio" name="questions[<?php echo e($index); ?>][correct]" value="<?php echo e($answerIndex); ?>" <?php echo e($isCorrect ? 'checked' : ''); ?>>
                                        <div class="w-full">
                                            <div class="radio-label">Answer <?php echo e(chr(65 + $answerIndex)); ?></div>
                                            <input type="text" name="questions[<?php echo e($index); ?>][answers][<?php echo e($answerIndex); ?>][answer_text]" value="<?php echo e($answerText); ?>" placeholder="Answer text" class="field-input mt-2" />
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="question-actions">
                    <a href="<?php echo e(route('staff.quizzes.list')); ?>" class="button-secondary">Cancel</a>
                    <button type="submit" class="button-primary">Save questionnaire</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/quizzes/questionnaire.blade.php ENDPATH**/ ?>