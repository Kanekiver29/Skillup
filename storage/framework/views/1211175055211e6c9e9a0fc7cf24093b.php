

<?php $__env->startSection('title', 'Create Quiz'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo $__env->make('staff.quizzes._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
    /* Page-specific small overrides for create */
    .form-grid { grid-template-columns: 1.6fr 0.9fr; gap:1.5rem; }
    .quiz-form-card { padding:1.5rem; border-radius:1.5rem; }
    .quiz-info-panel .help-card { padding:1rem; border-radius:12px; }
    .quiz-page-header { border-radius:1rem; padding:1rem 1.25rem; background:linear-gradient(135deg, rgba(2,132,199,0.08), rgba(14,165,233,0.03)); border:1px solid rgba(14,165,233,0.06); margin-bottom:1rem; }
    .quiz-page-header .quiz-pill { background:rgba(14,165,233,0.06); }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="create-layout">
    <div class="quiz-page-header">
        <p class="quiz-pill">New quiz</p>
        <h1 class="text-3xl font-extrabold mt-3">Create a polished quiz</h1>
        <p class="text-sm text-slate-600 mt-2">Quickly create an assessment, assign it to a module, and build questions.</p>
        <div class="mt-4">
            <a href="<?php echo e(route('staff.quizzes.list')); ?>" class="quiz-button is-primary" aria-label="Back to quizzes">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to quiz list
            </a>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="quiz-alert mb-4 rounded-2xl border border-rose-100 bg-rose-50 p-4 text-rose-800">
            <strong>Please fix the highlighted fields.</strong>
            <ul class="mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-grid">
        <div class="quiz-form-card">
            <div class="quiz-progress-rail"><div class="quiz-progress-fill" id="quiz_progress_fill"></div></div>
            <form method="POST" action="<?php echo e(route('staff.quizzes.store')); ?>" id="quiz_form" novalidate>
                <?php echo csrf_field(); ?>

                <div class="field-block">
                    <label class="field-label" for="course_id">Course</label>
                    <select id="course_id" name="course_id" required data-quiz-track class="field-select <?php echo e($errors->has('course_id') ? 'has-error' : ''); ?>">
                        <option value="">Select a course</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field-block">
                    <label class="field-label" for="module_id">Module</label>
                    <select id="module_id" name="module_id" required data-quiz-track class="field-select <?php echo e($errors->has('module_id') ? 'has-error' : ''); ?>">
                        <option value="">Select a module</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>" <?php echo e(old('module_id') == $module->id ? 'selected' : ''); ?>><?php echo e($module->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['module_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field-block">
                    <label class="field-label" for="title">Quiz title</label>
                    <input id="title" type="text" name="title" value="<?php echo e(old('title')); ?>" required data-quiz-track class="field-input <?php echo e($errors->has('title') ? 'has-error' : ''); ?>" placeholder="e.g. Fundamentals checkpoint">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field-block">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <label class="field-label" for="quiz_description">Description</label>
                        <span id="quiz_desc_count" class="text-sm text-slate-500">0 / 500</span>
                    </div>
                    <textarea id="quiz_description" name="description" rows="5" maxlength="500" class="field-textarea <?php echo e($errors->has('description') ? 'has-error' : ''); ?>" placeholder="Optional guidance for learners"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="score-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <div style="font-weight:700;">Passing score</div>
                                <div class="text-sm text-slate-500">Minimum correct percentage</div>
                            </div>
                            <span id="quiz_score_badge" class="score-badge"><?php echo e(old('passing_score', 70)); ?>%</span>
                        </div>
                        <div style="margin-top:0.8rem;position:relative;">
                            <input id="quiz_passing_score_number" type="number" name="passing_score" value="<?php echo e(old('passing_score', 70)); ?>" min="0" max="100" required class="field-input <?php echo e($errors->has('passing_score') ? 'has-error' : ''); ?>" style="padding-right:3rem;">
                            <span style="position:absolute;right:0.9rem;top:0.8rem;color:#64748b;font-size:0.9rem;">%</span>
                        </div>
                        <input type="range" min="0" max="100" value="<?php echo e(old('passing_score', 70)); ?>" id="quiz_passing_score_range" class="quiz-range" aria-hidden="true" tabindex="-1" style="margin-top:0.8rem;width:100%;">
                        <?php $__errorArgs = ['passing_score'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="time-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <div style="font-weight:700;">Time limit</div>
                                <div class="text-sm text-slate-500">Optional timer in minutes</div>
                            </div>
                            <span class="score-badge" style="background:#eef2ff;color:#1e293b;">Optional</span>
                        </div>
                        <div style="margin-top:0.8rem;">
                            <input type="number" name="time_limit_minutes" value="<?php echo e(old('time_limit_minutes')); ?>" min="0" class="field-input <?php echo e($errors->has('time_limit_minutes') ? 'has-error' : ''); ?>" placeholder="Minutes (optional)">
                        </div>
                        <?php $__errorArgs = ['time_limit_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="field-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="submit-group">
                    <button type="submit" id="quiz_submit_btn" class="submit-button" aria-live="polite">
                        <i id="quiz_submit_icon" class="fas fa-check" aria-hidden="true"></i>
                        <span id="quiz_submit_label">Create Quiz</span>
                        <svg class="quiz-spinner" id="quiz_submit_spinner" viewBox="0 0 24 24" fill="none" style="margin-left:0.6rem;display:none;">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"></circle>
                            <path fill="currentColor" opacity="0.85" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                    <a href="<?php echo e(route('staff.quizzes.list')); ?>" class="cancel-button" role="button"> 
                        <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to list
                    </a>
                </div>
            </form>
        </div>

        <aside class="quiz-info-panel">
            <div class="help-card">
                <strong>Quiz tips</strong>
                <p class="mt-2 text-sm text-slate-600">Assign to the module learners are in. Keep titles concise and provide helpful descriptions.</p>
            </div>
            <div class="help-card">
                <strong>Passing score advice</strong>
                <p class="mt-2 text-sm text-slate-600">70% is a sensible default; adjust for difficulty.</p>
            </div>
            <div class="help-card">
                <strong>Next step</strong>
                <p class="mt-2 text-sm text-slate-600">After creating, click the Questions button to add questions and build your bank.</p>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';
    var form = document.getElementById('quiz_form');
    var submitBtn = document.getElementById('quiz_submit_btn');
    var submitIcon = document.getElementById('quiz_submit_icon');
    var submitSpinner = document.getElementById('quiz_submit_spinner');
    var submitLabel = document.getElementById('quiz_submit_label');

    var numberInput = document.getElementById('quiz_passing_score_number');
    var rangeInput = document.getElementById('quiz_passing_score_range');
    var scoreBadge = document.getElementById('quiz_score_badge');

    var description = document.getElementById('quiz_description');
    var descCount = document.getElementById('quiz_desc_count');

    var progressFill = document.getElementById('quiz_progress_fill');
    var trackedFields = document.querySelectorAll('[data-quiz-track]');

    function clamp(value, min, max) { return Math.min(Math.max(value, min), max); }

    function syncScore(value) {
        var clamped = clamp(parseInt(value, 10) || 0, 0, 100);
        if (numberInput) numberInput.value = clamped;
        if (rangeInput) rangeInput.value = clamped;
        if (scoreBadge) {
            scoreBadge.textContent = clamped + '%';
            scoreBadge.classList.add('is-updating');
            setTimeout(function () { scoreBadge.classList.remove('is-updating'); }, 140);
        }
    }

    if (numberInput && rangeInput) {
        syncScore(numberInput.value);
        numberInput.addEventListener('input', function () { syncScore(numberInput.value); updateProgress(); });
        rangeInput.addEventListener('input', function () { syncScore(rangeInput.value); updateProgress(); });
    }

    function updateDescCount() {
        if (!description || !descCount) return;
        var len = description.value.length;
        descCount.textContent = len + ' / 500';
        descCount.style.color = len > 450 ? '#ef4444' : '';
    }

    if (description) { updateDescCount(); description.addEventListener('input', updateDescCount); }

    function updateProgress() {
        if (!progressFill || !trackedFields.length) return;
        var filled = 0;
        trackedFields.forEach(function (field) { if (field.value && field.value.trim() !== '') filled += 1; });
        var pct = Math.round((filled / trackedFields.length) * 100);
        progressFill.style.width = pct + '%';
    }

    if (trackedFields.length) {
        updateProgress();
        trackedFields.forEach(function (field) { field.addEventListener('input', updateProgress); field.addEventListener('change', updateProgress); });
    }

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            if (submitIcon) submitIcon.style.display = 'none';
            if (submitSpinner) { submitSpinner.style.display = 'inline-block'; submitSpinner.classList.add('quiz-spin'); }
            if (submitLabel) submitLabel.textContent = 'Creating…';
        });
    }

    var firstError = document.querySelector('.field-error');
    if (firstError) setTimeout(function () { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); if (firstError.focus) firstError.focus(); }, 120);
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/quizzes/create.blade.php ENDPATH**/ ?>