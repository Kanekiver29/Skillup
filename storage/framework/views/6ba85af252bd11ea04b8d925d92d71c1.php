
<?php $__env->startSection('title', 'Dashboard | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>
<?php $__env->startSection('subtitle', 'Gives the admin an overview of students, teachers, enrollment, courses, attendance, grades, and system activity.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Dashboard'); ?>
<?php ($purpose = 'Gives the admin an overview of students, teachers, enrollment, courses, attendance, grades, and system activity.'); ?>
<?php ($items = ['Student overview', 'Enrollment activity', 'System activity']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\dashboard\index.blade.php ENDPATH**/ ?>