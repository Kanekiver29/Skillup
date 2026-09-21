
<?php $__env->startSection('title', 'Courses | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Courses'); ?>
<?php $__env->startSection('subtitle', 'Creates and manages programs and courses offered by the institution.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Courses'); ?>
<?php ($purpose = 'Creates and manages programs and courses offered by the institution.'); ?>
<?php ($items = ['Course List', 'Add Course', 'Edit Course', 'Course Status']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\courses\index.blade.php ENDPATH**/ ?>