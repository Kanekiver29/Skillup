
<?php $__env->startSection('title', 'Create Assessment'); ?>
<?php $__env->startSection('page_title', 'Create Assessment'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-page"><div class="portal-heading"><h2>Create Assessment</h2><p>Assessments are created inside a competency module.</p></div><div class="portal-card"><a class="portal-button" href="<?php echo e(route('teacher.quizzes.create')); ?>">Open assessment builder</a></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\assessments\create.blade.php ENDPATH**/ ?>