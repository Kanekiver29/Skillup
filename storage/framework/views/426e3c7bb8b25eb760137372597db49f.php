

<?php $__env->startSection('title', 'Admin Account'); ?>
<?php $__env->startSection('page_title', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <h2 data-i18n="admin_account_settings">Admin Account Settings</h2>
    <p data-i18n="manage_account_details">Manage your SIAS administrator account details and login information.</p>
    <div class="admin-panel"><strong data-i18n="name">Name</strong>: <?php echo e(auth()->user()->name ?? 'Admin Name'); ?></div>
    <div class="admin-panel"><strong data-i18n="email">Email</strong>: <?php echo e(auth()->user()->email ?? 'admin@example.com'); ?></div>
    <div class="admin-panel"><strong data-i18n="role">Role</strong>: <span data-i18n="admin">Admin</span></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\account\index.blade.php ENDPATH**/ ?>