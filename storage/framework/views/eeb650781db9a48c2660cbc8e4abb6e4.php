

<?php $__env->startSection('title', 'Add Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="container max-w-4xl py-8">
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Add Schedule</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-700">Please correct the highlighted fields.</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('staff.schedule.store')); ?>" class="rounded border border-slate-200 bg-white p-6 shadow-sm">
        <?php echo $__env->make('staff.schedule._form', ['submitLabel' => 'Add schedule'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\schedule\create.blade.php ENDPATH**/ ?>