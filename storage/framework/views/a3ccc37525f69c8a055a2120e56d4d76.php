
<?php $__env->startSection('title', 'Student Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Student Management'); ?>
<?php $__env->startSection('subtitle', 'Maintains complete student information, records, documents, and current status.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Student Management'); ?>
<?php ($purpose = 'Maintains complete student information, records, documents, and current status.'); ?>
<?php ($items = ['Student Registration', 'Student Records', 'Student Profiles', 'Documents', 'Student Status']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\student-management\index.blade.php ENDPATH**/ ?>