

<?php $__env->startSection('title', 'Edit Module - ' . $module->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-semibold">Edit Module</h1>
        <p class="text-sm text-gray-600">Editing: <span class="font-medium"><?php echo e($module->title); ?></span></p>
    </header>

    <div class="bg-white shadow rounded p-6 max-w-2xl">
        <form action="<?php echo e(route('admin.modules.update', $module)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('Admin.modules.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="mt-6 flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    <i class="fas fa-save mr-2"></i> Update Module
                </button>
                <a href="<?php echo e(route('admin.modules.index', ['course_id' => $module->course_id])); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Archive Zone -->
    <div class="mt-8 max-w-2xl bg-amber-50 border border-amber-200 rounded p-6">
        <h3 class="text-lg font-semibold text-amber-800 mb-2">Archive Module</h3>
        <p class="text-sm text-amber-600 mb-4">Archiving this module will hide it from students. You can restore it later.</p>
        <form action="<?php echo e(route('admin.modules.destroy', $module)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to archive this module?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition text-sm">
                <i class="fas fa-archive mr-2"></i> Archive Module
            </button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="mt-4 max-w-2xl bg-red-50 border border-red-200 rounded p-6">
        <h3 class="text-lg font-semibold text-red-800 mb-2">Danger Zone</h3>
        <p class="text-sm text-red-600 mb-4">Permanently deleting this module will remove all quizzes, questions, and student attempts. This action cannot be undone.</p>
        <form action="<?php echo e(route('admin.modules.force-delete', $module)); ?>" method="POST" onsubmit="return confirm('Are you sure? This will PERMANENTLY delete this module and all its data. This cannot be undone.');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                <i class="fas fa-trash mr-2"></i> Delete Permanently
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\modules\edit.blade.php ENDPATH**/ ?>