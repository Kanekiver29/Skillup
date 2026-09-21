

<?php $__env->startSection('title','Contact Support'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Contact Support</h1>

    <form method="POST" action="<?php echo e(route('staff.support.send')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block font-semibold">Subject</label>
            <input name="subject" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Message</label>
            <textarea name="message" class="border p-2 w-full" required></textarea>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Send</button>
        </div>
    </form>

    <hr class="my-6">
    <h2 class="text-lg font-semibold mb-3">Sent messages (session)</h2>
    <?php $msgs = session('staff_support_messages', []); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($msgs)): ?>
        <ul class="space-y-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $msgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li class="p-3 bg-white border rounded"><strong><?php echo e($m['subject']); ?></strong><div class="text-sm text-slate-500"><?php echo e($m['message']); ?></div></li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </ul>
    <?php else: ?>
        <p class="text-slate-500">No messages sent.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\support\index.blade.php ENDPATH**/ ?>