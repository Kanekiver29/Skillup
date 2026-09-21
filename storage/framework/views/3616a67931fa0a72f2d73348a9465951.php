

<?php $__env->startSection('title', 'Admin Change Password'); ?>
<?php $__env->startSection('page_title', 'Change Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <h2 data-i18n="change_password">Change Password</h2>
    <p data-i18n="update_password_secure">Update your admin account password to keep SIAS secure.</p>
    <div class="admin-panel"><strong data-i18n="password_note">Note</strong>: <span data-i18n="password_note">Use a strong password and do not share your credentials.</span></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\account\password.blade.php ENDPATH**/ ?>