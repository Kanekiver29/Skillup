

<?php $__env->startSection('title', 'Create Module'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-semibold">Create Module</h1>
        <p class="text-sm text-gray-600">Add a new module to a course</p>
    </header>

    <div class="bg-white shadow rounded p-6 max-w-2xl">
        <form action="<?php echo e(route('admin.modules.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('Admin.modules.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="mt-6 flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    <i class="fas fa-save mr-2"></i> Create Module
                </button>
                <a href="<?php echo e(route('admin.modules.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\modules\create.blade.php ENDPATH**/ ?>