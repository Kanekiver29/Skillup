

<?php $__env->startSection('title', 'Student Account'); ?>
<?php $__env->startSection('page_title', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2>Student Account Settings</h2>
    <p>Manage your student account information and security settings.</p>
    <div class="section-block"><strong>Name:</strong> <?php echo e(auth()->user()->name ?? 'Student Name'); ?></div>
    <div class="section-block"><strong>Email:</strong> <?php echo e(auth()->user()->email ?? 'student@example.com'); ?></div>
    <div class="section-block"><strong>Role:</strong> Student</div>
    <div class="section-block">
        <a href="<?php echo e(route('sias.student.account.password')); ?>" class="btn-black">Change Password</a>
        <a href="<?php echo e(route('sias.student.account.mfa')); ?>" class="btn-white">Multi-Factor Authentication</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\account\index.blade.php ENDPATH**/ ?>