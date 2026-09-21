

<?php $__env->startSection('title', $quiz->title . ' - Attempt'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quiz->is_trivia && $quiz->question_time_limit_seconds): ?>
        <div id="trivia-timer" style="background:#fff3cd;color:#854d0e;padding:.75rem 1rem;border-radius:8px;text-align:center;font-weight:800;margin-bottom:1rem;">Time remaining: <?php echo e($quiz->question_time_limit_seconds); ?> seconds</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <form id="quiz-attempt-form" method="POST" action="<?php echo e(route('quizzes.submit', [$course->slug, $module->slug, $quiz->slug])); ?>" style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="attempt_id" value="<?php echo e($attempt->id); ?>">
        <h1 style="margin:0 0 1.5rem;color:#0b1730;font-size:2rem;font-weight:800;"><?php echo e($quiz->title); ?></h1>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <fieldset style="border:0;border-top:1px solid #e8eef7;padding:1.25rem 0;margin:0;">
                <legend style="font-weight:800;font-size:1.05rem;margin-bottom:.8rem;"><?php echo e($index + 1); ?>. <?php echo e($question->question_text); ?> <small style="color:#64748b;">(<?php echo e($question->points); ?> pt)</small></legend>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($question->type === 'short_answer'): ?>
                    <input type="text" name="responses[<?php echo e($question->id); ?>]" required style="width:100%;padding:.75rem;border:1px solid #cbd7e9;border-radius:8px;">
                <?php else: ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <label style="display:block;padding:.7rem;border:1px solid #e1e8f3;border-radius:8px;margin:.4rem 0;cursor:pointer;"><input type="radio" name="responses[<?php echo e($question->id); ?>]" value="<?php echo e($answer->id); ?>" required> <?php echo e($answer->answer_text); ?></label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </fieldset>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <button type="submit" style="border:0;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;font-weight:800;cursor:pointer;">Submit Quiz</button>
    </form>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quiz->is_trivia && $quiz->question_time_limit_seconds): ?>
<script>
    (() => { let seconds = <?php echo e($quiz->question_time_limit_seconds); ?>; const timer = document.getElementById('trivia-timer'); const form = document.getElementById('quiz-attempt-form'); const interval = setInterval(() => { seconds -= 1; timer.textContent = `Time remaining: ${seconds} seconds`; if (seconds <= 0) { clearInterval(interval); form.noValidate = true; form.submit(); } }, 1000); })();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\courses\quizzes\attempt.blade.php ENDPATH**/ ?>