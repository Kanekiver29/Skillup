

<?php $__env->startSection('title', $lesson->title ?? 'Lesson Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?php echo e($lesson->title ?? 'Lesson Details'); ?></h1>
            <p class="text-slate-500"><?php echo e($lesson->module->title ?? 'Module'); ?></p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('teacher.lessons.edit', $lesson->id)); ?>" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
            <a href="<?php echo e(route('teacher.lessons.index')); ?>" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Back</a>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="prose max-w-none text-slate-700">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->video_url): ?>
                <div class="mb-6 overflow-hidden rounded-xl border border-slate-200">
                    <iframe src="<?php echo e($lesson->video_url); ?>" class="aspect-video w-full" allowfullscreen></iframe>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="space-y-4">
                <p><?php echo nl2br(e($lesson->content ?? 'No content available.')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\lesson\show.blade.php ENDPATH**/ ?>