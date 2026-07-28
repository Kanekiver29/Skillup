

<?php $__env->startSection('title', 'Edit Module - ' . $module->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-semibold">Edit Module</h1>
        <p class="text-sm text-slate-500">Editing: <span class="font-medium"><?php echo e($module->title); ?></span></p>
    </header>

    <div class="rounded-lg bg-white p-6 shadow">
        <form action="<?php echo e(route('staff.modules.update', $module)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('Admin.modules.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-white transition hover:bg-indigo-700">
                    Save Module
                </button>
                <a href="<?php echo e(route('staff.modules.index', ['course_id' => $module->course_id])); ?>" class="rounded-lg bg-slate-200 px-6 py-2 text-slate-700 transition hover:bg-slate-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/modules/edit.blade.php ENDPATH**/ ?>