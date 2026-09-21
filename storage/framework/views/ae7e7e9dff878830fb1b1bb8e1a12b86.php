<?php $__env->startSection('title', 'Page Not Found'); ?>

<?php $__env->startSection('content'); ?>
<div class="error-page" style="text-align:center; margin-top:3rem;">
    <h1 style="font-size:4rem; color:#e63946;">404 - Not Found</h1>
    <p style="font-size:1.25rem; margin:1rem 0;">Sorry, the page you are looking for could not be found.</p>
    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-primary" style="padding:0.75rem 1.5rem; font-size:1rem;">Go to Dashboard</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\errors\404.blade.php ENDPATH**/ ?>