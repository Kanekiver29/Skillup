
<?php $__env->startSection('title', 'Edit Assessment'); ?>
<?php $__env->startSection('page_title', 'Edit Assessment'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-page"><div class="portal-card"><h2>Edit <?php echo e($assessment->title); ?></h2><p>Use the assessment builder to update questions, timing, and passing requirements.</p><a class="portal-button" href="<?php echo e(route('teacher.quizzes.edit', $assessment->id)); ?>">Open editor</a></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\assessments\edit.blade.php ENDPATH**/ ?>