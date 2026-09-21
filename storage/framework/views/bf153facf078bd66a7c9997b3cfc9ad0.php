

<?php $__env->startSection('title','Help Center'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <h1 class="text-2xl font-bold">Help Center</h1>
    <p class="mt-2">Documentation and support resources will appear here. This is a placeholder page.</p>
    <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
        <h2 class="text-xl font-semibold mb-3">Career support</h2>
        <p class="text-slate-600 leading-relaxed mb-4">If you need guidance on career pathways, relevant courses, or how to prepare for a job-ready skill set, visit the career help page.</p>
        <a href="<?php echo e(route('help.career')); ?>" class="inline-flex items-center rounded-full bg-cyan-600 px-5 py-3 text-sm font-semibold text-white hover:bg-cyan-700 transition">Go to Career Help</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\help\index.blade.php ENDPATH**/ ?>