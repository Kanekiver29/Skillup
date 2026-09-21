

<?php $__env->startSection('title', $quiz->title . ' - Results'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <p style="color:#64748b;margin:0 0 .5rem;"><?php echo e($course->title); ?> / <?php echo e($module->title); ?></p>
        <h1 style="margin:0;color:#0b1730;font-size:2rem;font-weight:800;"><?php echo e($quiz->title); ?> Results</h1>
        <div style="font-size:3rem;font-weight:800;color:#315bd6;margin:1rem 0;"><?php echo e($attempt->score_percentage); ?>%</div>
        <p><?php echo e($attempt->passed ? 'Passed' : 'Keep practicing'); ?> · <?php echo e($attempt->correct_answers); ?> correct answers</p>
        <a href="<?php echo e(route('quizzes.show', [$course->slug, $module->slug, $quiz->slug])); ?>" style="display:inline-block;margin-top:1rem;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:800;">Back to Quiz</a>
    </div>

    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;margin-top:1.25rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <h2 style="margin:0 0 1rem;color:#0b1730;font-size:1.35rem;font-weight:800;">Answer review</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="padding:1rem 0;border-top:1px solid #e8eef7;">
                <strong style="color:#0b1730;"><?php echo e($response->question?->question_text); ?></strong>
                <p style="margin:.45rem 0 0;color:<?php echo e($response->is_correct ? '#15803d' : '#b91c1c'); ?>;font-weight:700;">
                    <?php echo e($response->is_correct ? 'Correct' : 'Incorrect'); ?>: <?php echo e($response->answer?->answer_text ?? $response->answer_text ?? 'No answer'); ?>

                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$response->is_correct): ?>
                    <p style="margin:.25rem 0 0;color:#64768f;">Correct answer: <?php echo e($response->question?->getCorrectAnswer()?->answer_text ?? 'Not available'); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($response->question?->explanation): ?>
                    <p style="margin:.25rem 0 0;color:#64768f;"><?php echo e($response->question->explanation); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="color:#64768f;">No answer details are available for this attempt.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\courses\quizzes\results.blade.php ENDPATH**/ ?>