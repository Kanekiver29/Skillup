

<?php $__env->startSection('title','New Task'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Create Task</h1>

    <form method="POST" action="<?php echo e(route('staff.tasks.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block font-semibold">Title</label>
            <input name="title" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Due</label>
            <input name="due" class="border p-2 w-full" placeholder="e.g. Today, 5:00 PM">
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Create Task</button>
        </div>
    </form>

    <hr class="my-6">

    <h2 class="text-lg font-semibold mb-3">My Tasks (session)</h2>
    <?php $tasks = session('staff_tasks', []); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tasks)): ?>
        <ul class="space-y-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li class="p-3 bg-white border rounded"><?php echo e($t['title']); ?> <span class="text-sm text-slate-500">— <?php echo e($t['due'] ?? ''); ?></span></li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </ul>
    <?php else: ?>
        <p class="text-slate-500">No tasks yet.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\tasks\create.blade.php ENDPATH**/ ?>