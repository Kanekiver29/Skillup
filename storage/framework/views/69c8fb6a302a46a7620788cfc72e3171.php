
<?php $__env->startSection('title', 'System Settings | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'System Settings'); ?>
<?php $__env->startSection('subtitle', 'Controls SIAS configuration, academic settings, grading rules, backups, and maintenance.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'System Settings'); ?>
<?php ($purpose = 'Controls the overall configuration of the SIAS, including school information, academic settings, grading rules, backups, and maintenance.'); ?>
<?php ($items = ['School Information', 'Academic Settings', 'Grading Settings', 'Language', 'Backup & Restore', 'System Maintenance']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\system-settings\index.blade.php ENDPATH**/ ?>