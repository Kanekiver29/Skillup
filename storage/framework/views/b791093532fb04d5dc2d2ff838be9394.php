

<?php $__env->startSection('title', 'Audit Logs | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Audit Logs'); ?>
<?php $__env->startSection('subtitle', 'Review security, accountability, and troubleshooting activity recorded by SIAS.'); ?>

<?php $__env->startSection('content'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?><div class="admin-panel" style="margin-bottom:1rem; border-color:#22c55e; color:#15803d;"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?><div class="admin-panel" style="margin-bottom:1rem; border-color:var(--danger); color:var(--danger);"><?php echo e(session('error')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); margin-bottom:1rem;">
    <div class="admin-panel"><span style="color:var(--text-muted);">Total entries</span><strong style="display:block; font-size:1.7rem; margin-top:.3rem;"><?php echo e(number_format($total)); ?></strong></div>
    <div class="admin-panel"><span style="color:var(--text-muted);">Errors</span><strong style="display:block; font-size:1.7rem; margin-top:.3rem; color:var(--danger);"><?php echo e(number_format($levelCounts->get('error', 0))); ?></strong></div>
    <div class="admin-panel"><span style="color:var(--text-muted);">Warnings</span><strong style="display:block; font-size:1.7rem; margin-top:.3rem; color:#d97706;"><?php echo e(number_format($levelCounts->get('warning', 0))); ?></strong></div>
    <div class="admin-panel"><span style="color:var(--text-muted);">Log file</span><strong style="display:block; font-size:1rem; margin-top:.55rem;"><?php echo e($logExists ? number_format($logSize / 1024, 1) . ' KB' : 'Not found'); ?></strong></div>
</div>

<section class="admin-card" style="margin-bottom:1rem;">
    <form method="GET" action="<?php echo e(route('sias.admin.audit-logs')); ?>" style="display:flex; gap:.75rem; flex-wrap:wrap; align-items:end;">
        <label style="display:grid; gap:.35rem; flex:1; min-width:220px;">Search
            <input name="search" value="<?php echo e($filterSearch); ?>" placeholder="Search messages or context" style="padding:.7rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text);">
        </label>
        <label style="display:grid; gap:.35rem; min-width:160px;">Level
            <select name="level" style="padding:.7rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text);">
                <option value="">All levels</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['emergency','alert','critical','error','warning','notice','info','debug']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($level); ?>" <?php if($filterLevel === $level): echo 'selected'; endif; ?>><?php echo e(ucfirst($level)); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </label>
        <button class="btn" type="submit" style="width:auto;">Filter logs</button>
        <a class="btn btn-secondary" href="<?php echo e(route('sias.admin.audit-logs')); ?>" style="width:auto;">Reset</a>
    </form>
</section>

<section class="admin-card" style="padding:0; overflow:hidden;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:1.1rem 1.25rem; border-bottom:1px solid var(--card-border);">
        <div><strong>System activity</strong><div style="color:var(--text-muted); font-size:.82rem;">Page <?php echo e($page); ?> of <?php echo e($totalPages); ?></div></div>
        <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <a class="btn btn-secondary" href="<?php echo e(route('admin.systemlog.download')); ?>" style="width:auto;">Download log</a>
            <form method="POST" action="<?php echo e(route('admin.systemlog.clear')); ?>" onsubmit="return confirm('Clear the Laravel log file?');"><?php echo csrf_field(); ?><button class="btn btn-secondary" type="submit" style="width:auto; color:var(--danger);">Clear log</button></form>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginated->isEmpty()): ?>
        <div style="padding:3rem 1rem; text-align:center; color:var(--text-muted);">No audit entries match the selected filters.</div>
    <?php else: ?>
        <div style="overflow-x:auto;"><table style="width:100%; border-collapse:collapse; min-width:760px;">
            <thead><tr style="text-align:left; color:var(--text-muted); font-size:.75rem; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--card-border);"><th style="padding:.8rem 1rem;">Time</th><th style="padding:.8rem 1rem;">Level</th><th style="padding:.8rem 1rem;">Channel</th><th style="padding:.8rem 1rem;">Message</th></tr></thead>
            <tbody><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paginated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><tr style="border-bottom:1px solid var(--card-border); vertical-align:top;">
                <td style="padding:.85rem 1rem; white-space:nowrap; font-size:.82rem; color:var(--text-muted);"><?php echo e($entry['timestamp']); ?></td>
                <td style="padding:.85rem 1rem;"><span style="display:inline-block; padding:.25rem .5rem; border-radius:999px; font-size:.75rem; background:<?php echo e(in_array($entry['level'], ['error','critical','emergency']) ? 'rgba(224,72,62,.12)' : ($entry['level'] === 'warning' ? 'rgba(217,119,6,.12)' : 'var(--accent-tint)')); ?>; color:<?php echo e(in_array($entry['level'], ['error','critical','emergency']) ? 'var(--danger)' : ($entry['level'] === 'warning' ? '#b45309' : 'var(--accent)')); ?>;"><?php echo e(strtoupper($entry['level'])); ?></span></td>
                <td style="padding:.85rem 1rem; font-size:.85rem;"><?php echo e($entry['channel']); ?></td>
                <td style="padding:.85rem 1rem; white-space:pre-wrap; overflow-wrap:anywhere;"><?php echo e($entry['message']); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry['context']): ?><details style="margin-top:.4rem;"><summary style="cursor:pointer; color:var(--text-muted); font-size:.8rem;">View context</summary><pre style="white-space:pre-wrap; font-size:.75rem; color:var(--text-muted);"><?php echo e(trim($entry['context'])); ?></pre></details><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
            </tr><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></tbody>
        </table></div>
        <div style="display:flex; justify-content:center; gap:.5rem; padding:1rem;"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page > 1): ?><a class="btn btn-secondary" href="<?php echo e(request()->fullUrlWithQuery(['page' => $page - 1])); ?>" style="width:auto;">Previous</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page < $totalPages): ?><a class="btn" href="<?php echo e(request()->fullUrlWithQuery(['page' => $page + 1])); ?>" style="width:auto;">Next</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\audit-logs\index.blade.php ENDPATH**/ ?>