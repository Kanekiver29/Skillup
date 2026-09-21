
<?php $__env->startSection('title', 'User Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'User Management'); ?>
<?php $__env->startSection('subtitle', 'Manages all system accounts and their access: Admin, Staff, Teacher, and Student.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'User Management'); ?>
<?php ($purpose = 'Manages all system accounts and their access: Admin, Staff, Teacher, and Student.'); ?>
<?php ($items = ['Admins', 'Staff', 'Teachers', 'Students']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\user-management\index.blade.php ENDPATH**/ ?>