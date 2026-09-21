

<?php $__env->startSection('title', 'Enrollments for ' . $course->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">Enrollments - <?php echo e($course->title); ?></h1>

    <div class="bg-white shadow rounded">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Enrolled On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium"><?php echo e($e->user->name); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($e->user->email); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($e->progress ?? 0); ?>%</td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($e->completed ? 'Yes' : 'No'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($e->created_at->format('M d, Y')); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No enrollments yet.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <?php echo e($enrollments->links()); ?>

    </div>

    <div class="mt-6">
        <a href="<?php echo e(route('admin.courses.index')); ?>" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Courses</a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\courses\enrollments.blade.php ENDPATH**/ ?>