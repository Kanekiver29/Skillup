
<?php $__env->startSection('title', 'Announcements | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Announcements'); ?>
<?php $__env->startSection('subtitle', 'Allows administrators to publish important school announcements to teachers and students.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Announcements'); ?>
<?php ($purpose = 'Allows administrators to publish important school announcements to teachers and students.'); ?>
<?php ($items = ['Published announcements', 'Drafts', 'Create announcement']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\announcements\index.blade.php ENDPATH**/ ?>