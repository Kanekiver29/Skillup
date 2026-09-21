

<?php $__env->startSection('title', 'Create Module'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-cyan-700">
                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                New module
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Create Module</h1>
            <p class="mt-1 text-sm text-slate-500">Add a new module to a course and prepare its learning content.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('staff.modules.index')); ?>" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                Back to Modules
            </a>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="<?php echo e(route('staff.modules.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('Admin.modules.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                    <i class="fas fa-save mr-2"></i>
                    Create Module
                </button>
                <a href="<?php echo e(route('staff.modules.index')); ?>" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\modules\create.blade.php ENDPATH**/ ?>