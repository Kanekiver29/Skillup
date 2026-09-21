

<?php $__env->startSection('title', 'Assessment Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Assessment Schedule</h1>
            <p class="mt-1 text-slate-500">Manage active assessments and their questionnaires.</p>
        </div>
        <a href="<?php echo e(route('staff.quizzes.create')); ?>" class="px-4 py-2 rounded bg-blue-600 text-white">Create assessment</a>
    </div>

    <div class="bg-white border rounded overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quizzes->isEmpty()): ?>
            <p class="p-6 text-slate-500">No active assessments found.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 font-semibold">Assessment</th>
                            <th class="p-4 font-semibold">Module</th>
                            <th class="p-4 font-semibold">Passing score</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b last:border-b-0">
                                <td class="p-4 font-medium"><?php echo e($quiz->title); ?></td>
                                <td class="p-4 text-slate-600"><?php echo e($quiz->module?->title ?? 'Unassigned'); ?></td>
                                <td class="p-4"><?php echo e($quiz->passing_score ?? 0); ?>%</td>
                                <td class="p-4"><?php echo e($quiz->is_published ? 'Published' : 'Draft'); ?></td>
                                <td class="p-4">
                                    <div class="flex gap-3">
                                        <a class="text-blue-600" href="<?php echo e(route('staff.quizzes.questionnaire', $quiz)); ?>">Questions</a>
                                        <a class="text-slate-600" href="<?php echo e(route('staff.quizzes.edit', $quiz)); ?>">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\quizzes\list.blade.php ENDPATH**/ ?>