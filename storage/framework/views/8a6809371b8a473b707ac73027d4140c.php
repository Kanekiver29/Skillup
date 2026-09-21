
<?php $__env->startSection('title', 'Admin & Staff Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Admin & Staff Management'); ?>
<?php $__env->startSection('subtitle', 'Creates administrative and staff accounts and controls their roles and permissions.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Admin & Staff Management'); ?>
<?php ($purpose = 'Creates administrative/staff accounts and controls their roles and permissions.'); ?>
<?php ($items = ['Add Admin', 'Add Staff', 'Roles', 'Permissions']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\admin-staff-management\index.blade.php ENDPATH**/ ?>