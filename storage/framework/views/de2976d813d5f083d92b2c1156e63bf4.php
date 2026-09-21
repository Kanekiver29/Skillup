
<?php $__env->startSection('title', 'Teacher Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Teacher Management'); ?>
<?php $__env->startSection('subtitle', 'Manages teacher profiles, assigned subjects, teaching loads, and schedules.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Teacher Management'); ?>
<?php ($purpose = 'Manages teacher profiles, assigned subjects, teaching loads, and schedules.'); ?>
<?php ($items = ['Teacher Registration', 'Teacher Profiles', 'Assign Subjects', 'Teaching Load']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\teacher-management\index.blade.php ENDPATH**/ ?>