

<?php $__env->startSection('title', 'Teacher Grades'); ?>
<?php $__env->startSection('page_title', 'Gradebook'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2>Gradebook</h2>
    <p>Manage student grades and assessment status.</p>
    <p><a href="<?php echo e(route('sias.teacher.grades.index')); ?>" class="btn">Open grade entry</a></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\grades\index.blade.php ENDPATH**/ ?>