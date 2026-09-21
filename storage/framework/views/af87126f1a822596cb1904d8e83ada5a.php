

<?php $__env->startSection('title', 'Staff Tasks'); ?>

<?php $__env->startSection('content'); ?>
<div class="cr-page" style="padding:24px;display:grid;gap:20px;">
    <div class="cr-card" style="padding:24px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;border:1px solid var(--border);background:var(--surface);border-radius:12px;box-shadow:0 10px 30px -18px rgba(15,23,42,0.25);color:var(--text);">
        <div>
            <div class="cr-header__eyebrow">
                <span class="cr-header__eyebrow-dot"></span>
                Staff Portal
            </div>
            <h1 class="cr-header__title" style="margin:4px 0 0;color:var(--text);">Tasks</h1>
            <p class="cr-header__subtitle" style="margin-top:6px;color:var(--muted);">Review your current task list and add new work items.</p>
        </div>
        <a href="<?php echo e(route('staff.tasks.create')); ?>" class="cr-btn cr-btn--primary">Create Task</a>
    </div>

    <div class="cr-card" style="padding:24px;border:1px solid var(--border);background:var(--surface);border-radius:12px;box-shadow:0 10px 30px -18px rgba(15,23,42,0.25);color:var(--text);">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($tasks)): ?>
            <p style="margin:0;color:var(--muted);">No tasks yet.</p>
        <?php else: ?>
            <div style="display:grid;gap:12px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="border:1px solid var(--border);background:var(--surface);border-radius:12px;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                        <div>
                            <div style="font-weight:700;color:var(--text);"><?php echo e($task['title'] ?? 'Untitled task'); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($task['due'])): ?>
                                <div style="color:var(--muted);font-size:13px;margin-top:4px;">Due: <?php echo e($task['due']); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div style="color:var(--muted);font-size:13px;">Added <?php echo e(!empty($task['created_at']) ? \
                            \\Illuminate\\Support\\Carbon::parse($task['created_at'])->diffForHumans() : 'recently'); ?></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\tasks\index.blade.php ENDPATH**/ ?>