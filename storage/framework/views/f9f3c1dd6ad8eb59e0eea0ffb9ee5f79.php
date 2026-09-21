<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <?php
            $item = is_string($item)
                ? ['label' => $item, 'description' => 'This workspace is ready for ' . strtolower($item) . ' management.', 'route' => null, 'action' => null]
                : $item;
            $itemUrl = $item['route'] ? route($item['route'], $item['parameters'] ?? []) : null;
            $actionUrl = ! empty($item['action']) ? route($item['action'], $item['action_parameters'] ?? []) : null;
        ?>
        <section class="admin-panel" style="--i: <?php echo e($index); ?>;">
            <p style="margin:0 0 .5rem; color:var(--text-muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.08em;">SIAS Admin</p>
            <h3 style="margin:0 0 .65rem;"><?php echo e($item['label']); ?></h3>
            <p style="margin:0; color:var(--text-muted);"><?php echo e($item['description']); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($itemUrl): ?>
                <div style="display:flex; gap:.55rem; flex-wrap:wrap; margin-top:1rem;">
                    <a href="<?php echo e($itemUrl); ?>" class="btn btn-secondary" style="width:auto;">Open workspace</a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($actionUrl): ?>
                        <a href="<?php echo e($actionUrl); ?>" class="btn" style="width:auto;"><?php echo e($item['action_label'] ?? 'Create new'); ?></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <span style="display:inline-block; margin-top:1rem; color:var(--text-muted); font-size:.85rem;">No admin workspace is registered yet</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>

<section class="admin-card" style="margin-top:1rem;">
    <h3 style="margin-top:0;"><?php echo e($title); ?> workspace</h3>
    <p style="margin-bottom:0; color:var(--text-muted);"><?php echo e($purpose); ?></p>
</section>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\modules\_workspace.blade.php ENDPATH**/ ?>