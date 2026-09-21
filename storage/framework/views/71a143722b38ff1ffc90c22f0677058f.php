

<?php $__env->startSection('title', 'User & Role Management'); ?>
<?php $__env->startSection('page_title', 'User & Role Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
  <p>Manage user accounts, administrators, and roles.</p>
  <div class="admin-actions"><a href="<?php echo e(url('/admin/users/create')); ?>">Add user</a></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\users\index.blade.php ENDPATH**/ ?>