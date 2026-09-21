

<?php $__env->startSection('title', 'Edit Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="container max-w-4xl py-8">
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Edit Schedule</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-700">Please correct the highlighted fields.</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('staff.schedule.update', $schedule)); ?>" class="rounded border border-slate-200 bg-white p-6 shadow-sm">
        <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('staff.schedule._form', ['submitLabel' => 'Save changes'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>

    <form method="POST" action="<?php echo e(route('staff.schedule.destroy', $schedule)); ?>" class="mt-4" onsubmit="return confirm('Delete this schedule?');">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="rounded border border-red-300 px-4 py-2 font-semibold text-red-700 hover:bg-red-50">Delete schedule</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\schedule\edit.blade.php ENDPATH**/ ?>