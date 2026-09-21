<?php $__env->startSection('title', $item->title ?? 'View News'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-6xl px-4 pb-16 pt-10 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="<?php echo e(route('admin.news.index')); ?>" class="text-sm font-semibold text-cyan-300 hover:text-cyan-200">← Back to news</a>
        <h1 class="mt-3 text-3xl font-black text-white"><?php echo e($item->title); ?></h1>
        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-400">
            <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-cyan-200">
                <?php echo e(ucfirst($item->category)); ?>

            </span>
            <span><?php echo e(optional($item->published_at ?? $item->created_at)->format('M d, Y')); ?></span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->is_featured): ?>
                <span class="text-emerald-400">Featured</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->featured_image): ?>
        <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-700/80">
            <img src="<?php echo e(asset('storage/' . $item->featured_image)); ?>" alt="<?php echo e($item->title); ?>" class="h-auto w-full object-cover" />
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->video_file): ?>
        <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-700/80">
            <video class="h-auto w-full" controls>
                <source src="<?php echo e(asset('storage/' . $item->video_file)); ?>">
                Your browser does not support the video tag.
            </video>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="prose prose-slate max-w-none text-base leading-8 text-slate-300">
        <?php echo nl2br(e($item->content)); ?>

    </div>

    <div class="mt-10 flex items-center gap-4 border-t border-slate-800 pt-6">
        <a href="<?php echo e(route('admin.news.edit', $item->id)); ?>" class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
            Edit post
        </a>
        <form action="<?php echo e(route('admin.news.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Delete “<?php echo e($item->title); ?>”? This can’t be undone.');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="rounded-xl px-5 py-3 text-sm font-semibold text-rose-400 hover:text-rose-300">
                Delete this post
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\news\view.blade.php ENDPATH**/ ?>