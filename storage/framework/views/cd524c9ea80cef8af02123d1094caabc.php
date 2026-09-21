
<?php $__env->startSection('title', 'Subjects | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Subjects'); ?>
<?php $__env->startSection('subtitle', 'Creates subjects under a course and manages teacher assignments and schedules.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Subjects'); ?>
<?php ($purpose = 'Creates subjects under a course and manages teacher assignments and schedules.'); ?>
<?php ($items = ['Subject List', 'Add Subject', 'Assign Teacher', 'Subject Schedule']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\subjects\index.blade.php ENDPATH**/ ?>