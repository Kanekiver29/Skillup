
<?php $__env->startSection('title', 'Assessment Details'); ?>
<?php $__env->startSection('page_title', 'Assessment Details'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-page"><div class="portal-card"><h2><?php echo e($assessment->title); ?></h2><p><?php echo e($assessment->description ?? 'No description available.'); ?></p><p>Passing score: <?php echo e($assessment->passing_score ?? 'Not set'); ?></p><a class="portal-button" href="<?php echo e(route('teacher.assessments.index')); ?>">Back to assessments</a></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\assessments\show.blade.php ENDPATH**/ ?>