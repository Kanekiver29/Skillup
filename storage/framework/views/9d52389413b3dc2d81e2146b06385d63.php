
<?php $__env->startSection('title', 'Notifications | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Notifications'); ?>
<?php $__env->startSection('subtitle', 'Sends system reminders and alerts such as enrollment approval, announcements, grades, and updates.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Notifications'); ?>
<?php ($purpose = 'Sends system reminders and alerts such as enrollment approval, announcements, grades, and other updates.'); ?>
<?php ($items = ['Notification center', 'Unread alerts', 'Notification history']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\notifications\index.blade.php ENDPATH**/ ?>