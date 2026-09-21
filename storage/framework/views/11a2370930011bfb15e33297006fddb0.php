

<?php $__env->startSection('title', $quiz->title . ' - Quiz'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <p style="color:#64748b;margin:0 0 .5rem;"><?php echo e($course->title); ?> / <?php echo e($module->title); ?></p>
        <h1 style="margin:0;color:#0b1730;font-size:2rem;font-weight:800;"><?php echo e($quiz->title); ?></h1>
        <p style="color:#52627c;line-height:1.7;margin:1rem 0 1.5rem;"><?php echo e($quiz->description ?: 'Test your understanding of this module.'); ?></p>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;color:#52627c;margin-bottom:1.5rem;">
            <span><?php echo e($quiz->questions()->count()); ?> questions</span>
            <span>Passing score: <?php echo e($quiz->passing_score); ?>%</span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quiz->time_limit_minutes): ?><span><?php echo e($quiz->time_limit_minutes); ?> minutes</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span>Attempts: <?php echo e($attemptCount); ?> / <?php echo e($quiz->attempt_limit); ?></span>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?><div style="color:#b91c1c;background:#fff1f2;padding:.8rem;border-radius:8px;margin-bottom:1rem;"><?php echo e(session('error')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canRetry): ?>
            <a href="<?php echo e(route('quizzes.start', [$course->slug, $module->slug, $quiz->slug])); ?>" style="display:inline-block;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:800;">Start Quiz</a>
        <?php else: ?>
            <strong style="color:#b91c1c;">Attempt limit reached.</strong>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\courses\quizzes\show.blade.php ENDPATH**/ ?>