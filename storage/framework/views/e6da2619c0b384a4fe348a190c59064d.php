

<?php $__env->startSection('title', $definition['title'] . ' | SIAS Admin'); ?>
<?php $__env->startSection('page_title', $definition['title']); ?>
<?php $__env->startSection('subtitle', $definition['purpose']); ?>

<?php $__env->startSection('content'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="admin-panel" style="margin-bottom:1rem; border-color:#22c55e; color:#15803d;"><?php echo e(session('success')); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section === 'maintenance'): ?>
    <div class="admin-card" style="max-width:900px; display:grid; gap:1rem;">
        <div>
            <h3 style="margin:0 0 .4rem;">Application maintenance</h3>
            <p style="margin:0; color:var(--text-muted);">Clear application caches or temporarily place SIAS in maintenance mode.</p>
        </div>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <form method="POST" action="<?php echo e(route('admin.settings.cache.clear')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="type" value="all">
                <button class="btn" type="submit">Clear all caches</button>
            </form>
            <form method="POST" action="<?php echo e(route('admin.settings.maintenance')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-secondary" type="submit"><?php echo e(app()->isDownForMaintenance() ? 'Disable maintenance mode' : 'Enable maintenance mode'); ?></button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card" style="max-width:900px;">
        <form method="POST" action="<?php echo e(route('sias.admin.settings.section.update', ['section' => $section])); ?>" style="display:grid; gap:1rem;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $definition['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div style="display:grid; gap:.4rem;">
                    <label for="<?php echo e($field['name']); ?>" style="font-weight:600;"><?php echo e(__('sias.settings_field_' . $field['name'])); ?></label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field['type'] === 'textarea'): ?>
                        <textarea id="<?php echo e($field['name']); ?>" name="<?php echo e($field['name']); ?>" rows="3" style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);"><?php echo e(old($field['name'], $values[$field['name']] ?? '')); ?></textarea>
                    <?php elseif($field['type'] === 'select'): ?>
                        <select id="<?php echo e($field['name']); ?>" name="<?php echo e($field['name']); ?>" style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($option); ?>" <?php if(old($field['name'], $values[$field['name']] ?? '') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    <?php else: ?>
                        <input id="<?php echo e($field['name']); ?>" type="<?php echo e($field['type']); ?>" name="<?php echo e($field['name']); ?>" value="<?php echo e(old($field['name'], $values[$field['name']] ?? '')); ?>" <?php if(isset($field['step'])): ?> step="<?php echo e($field['step']); ?>" <?php endif; ?> style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = [$field['name']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:var(--danger); font-size:.85rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div style="display:flex; justify-content:flex-end; margin-top:.5rem;">
                <button class="btn" type="submit" style="width:auto;">Save <?php echo e($definition['title']); ?></button>
            </div>
        </form>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\settings\_form.blade.php ENDPATH**/ ?>