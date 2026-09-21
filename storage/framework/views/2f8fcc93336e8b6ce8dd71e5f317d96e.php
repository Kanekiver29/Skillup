

<?php $__env->startSection('title', 'Create Course'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">New Course</h1>

    <form action="<?php echo e(route('admin.courses.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('Admin.courses.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Course</button>
            <a href="<?php echo e(route('admin.courses.index')); ?>" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\courses\create.blade.php ENDPATH**/ ?>