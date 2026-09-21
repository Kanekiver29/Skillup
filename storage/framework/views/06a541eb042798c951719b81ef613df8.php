

<?php $__env->startSection('title', 'Admin Dashboard - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e($slot ?? ''); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\layout\Admin\app.blade.php ENDPATH**/ ?>