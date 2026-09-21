
<?php $__env->startSection('title', 'Enrollment | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Enrollment'); ?>
<?php $__env->startSection('subtitle', 'Handles student enrollment from registration through approval, section assignment, and enrollment history.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Enrollment'); ?>
<?php ($purpose = 'Handles student enrollment from registration through approval, section assignment, and enrollment history.'); ?>
<?php ($items = ['New Enrollment', 'Enrollment List', 'Enrollment Approval', 'Section Assignment', 'Enrollment History']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\enrollment\index.blade.php ENDPATH**/ ?>