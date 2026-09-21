

<?php $__env->startSection('title', 'Competency Status'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Competency Status</h1>
        <p class="mt-1 text-slate-500">Review module coverage and assessment readiness.</p>
    </div>

    <div class="bg-white border rounded overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modules->isEmpty()): ?>
            <p class="p-6 text-slate-500">No competency modules are available.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 font-semibold">Module</th>
                            <th class="p-4 font-semibold">Course</th>
                            <th class="p-4 font-semibold">Assessment coverage</th>
                            <th class="p-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b last:border-b-0">
                                <td class="p-4 font-medium"><?php echo e($module->title); ?></td>
                                <td class="p-4 text-slate-600"><?php echo e($module->course?->title ?? 'Unassigned'); ?></td>
                                <td class="p-4"><?php echo e($module->quizzes_count ?? 0); ?> assessment(s)</td>
                                <td class="p-4 <?php echo e(($module->quizzes_count ?? 0) > 0 ? 'text-emerald-600' : 'text-amber-600'); ?>">
                                    <?php echo e(($module->quizzes_count ?? 0) > 0 ? 'Assessment ready' : 'Needs assessment'); ?>

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

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\modules\competency.blade.php ENDPATH**/ ?>