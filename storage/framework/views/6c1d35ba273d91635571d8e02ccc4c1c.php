
<?php $__env->startSection('title', 'Program Schedule'); ?>
<?php $__env->startSection('page_title', 'Program Schedule'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-page"><div class="portal-heading"><div><h2><?php echo e($course->title); ?></h2><p>Training duration, schedule, and practical session planning.</p></div><a class="portal-button" href="<?php echo e(route('teacher.schedule.index')); ?>">View all schedules</a></div><div class="portal-grid"><div class="portal-card"><strong><?php echo e($course->duration_hours ?? 0); ?></strong><span>Training hours</span></div><div class="portal-card"><strong><?php echo e($course->delivery_mode ?? 'Flexible'); ?></strong><span>Delivery mode</span></div><div class="portal-card"><strong><?php echo e($course->level ?? '—'); ?></strong><span>Program level</span></div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\courses\schedule.blade.php ENDPATH**/ ?>