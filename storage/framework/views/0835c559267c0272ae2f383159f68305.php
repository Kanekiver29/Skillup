

<?php $__env->startSection('title', 'Backup & Restore | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Backup & Restore'); ?>
<?php $__env->startSection('subtitle', 'Create, download, and safely restore SIAS database and application backups.'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .backup-page { display:grid; gap:1rem; }
    .backup-hero { position:relative; overflow:hidden; padding:1.35rem 1.5rem; border:1px solid var(--card-border); border-radius:16px; background:linear-gradient(120deg, rgba(8,145,178,.12), var(--card-bg) 58%, rgba(34,211,238,.08)); }
    .backup-hero::after { content:''; position:absolute; width:180px; height:180px; right:-55px; top:-80px; border:1px solid var(--accent-tint); border-radius:50%; box-shadow:0 0 0 18px rgba(8,145,178,.035), 0 0 0 38px rgba(8,145,178,.025); animation:backup-orbit 9s linear infinite; pointer-events:none; }
    .backup-hero h3 { position:relative; z-index:1; margin:0; font-family:var(--font-display); font-size:1.35rem; }
    .backup-hero p { position:relative; z-index:1; max-width:650px; margin:.4rem 0 0; color:var(--text-muted); }
    .backup-status-grid { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:1rem; }
    .backup-stat { position:relative; overflow:hidden; animation:backup-rise .45s var(--ease) both; }
    .backup-stat:nth-child(2) { animation-delay:.06s; } .backup-stat:nth-child(3) { animation-delay:.12s; }
    .backup-stat::before { content:''; position:absolute; inset:0 auto 0 0; width:3px; background:var(--accent); }
    .backup-stat strong { font-variant-numeric:tabular-nums; }
    .backup-actions { display:flex; gap:.5rem; flex-wrap:wrap; align-items:center; }
    .backup-actions .btn { transition:transform var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease); }
    .backup-actions .btn:hover { transform:translateY(-2px); }
    .backup-primary { background:linear-gradient(135deg, #0891b2, #22d3ee); box-shadow:0 10px 22px -12px rgba(8,145,178,.8); }
    .backup-primary::before { content:'↗'; font-size:1rem; line-height:1; }
    .backup-table tbody tr { transition:background var(--dur-fast) var(--ease), transform var(--dur-fast) var(--ease); }
    .backup-table tbody tr:hover { background:var(--accent-tint); }
    .backup-table th { white-space:nowrap; }
    .backup-diagnostics { animation:backup-rise .5s var(--ease) .16s both; }
    .backup-warning { border:1px solid rgba(245,158,11,.25); }
    @keyframes backup-rise { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    @keyframes backup-orbit { to { transform:rotate(360deg); } }
    @media (max-width:760px) { .backup-status-grid { grid-template-columns:1fr; } .backup-hero { padding:1.1rem; } }
    @media (prefers-reduced-motion:reduce) { .backup-hero::after, .backup-stat, .backup-diagnostics { animation:none; } }
</style>
<div class="backup-page">
<section class="backup-hero">
    <h3>Recovery control center</h3>
    <p>Keep a verified copy of the complete Laravel system before deployments, migrations, or major configuration changes.</p>
    <p style="margin-top:.7rem; color:var(--text-muted);"><strong>Automatic policy:</strong> a full system backup runs every day at 02:00, and backup files older than 30 days are removed automatically.</p>
</section>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?><div class="admin-panel" style="margin-bottom:1rem; border-color:#22c55e; color:#15803d;"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?><div class="admin-panel" style="margin-bottom:1rem; border-color:var(--danger); color:var(--danger);"><?php echo e(session('error')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); margin-bottom:1rem;">
    <div class="admin-panel backup-stat"><span style="color:var(--text-muted);">Database</span><strong style="display:block; margin-top:.35rem;"><?php echo e(strtoupper($driver)); ?></strong><small style="color:var(--text-muted);"><?php echo e($databaseName); ?></small></div>
    <div class="admin-panel backup-stat"><span style="color:var(--text-muted);">Backup files</span><strong style="display:block; font-size:1.7rem; margin-top:.3rem;"><?php echo e($backupFiles->count()); ?></strong></div>
    <div class="admin-panel backup-stat"><span style="color:var(--text-muted);">Storage</span><strong style="display:block; margin-top:.35rem; color:<?php echo e($diagnostics['backup_dir_writable'] ? '#15803d' : 'var(--danger)'); ?>;"><?php echo e($diagnostics['backup_dir_writable'] ? 'Writable' : 'Not writable'); ?></strong></div>
</div>

<div class="admin-grid" style="grid-template-columns:minmax(0, 2fr) minmax(260px, 1fr); align-items:start;">
    <section class="admin-card" style="padding:0; overflow:hidden;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; padding:1.2rem 1.25rem; border-bottom:1px solid var(--card-border);">
            <div><h3 style="margin:0;">Backup history</h3><p style="margin:.35rem 0 0; color:var(--text-muted); font-size:.85rem;">Create snapshots, download files, or restore a selected backup.</p></div>
            <div class="backup-actions">
                <form method="POST" action="<?php echo e(route('admin.backup.store')); ?>"><?php echo csrf_field(); ?><button class="btn" type="submit" style="width:auto;">Database backup</button></form>
                <form method="POST" action="<?php echo e(route('sias.admin.backup.whole-system')); ?>"><?php echo csrf_field(); ?><input type="hidden" name="include_all" value="1"><button class="btn backup-primary" type="submit" style="width:auto;">Whole system backup</button></form>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="backup-table" style="width:100%; border-collapse:collapse; min-width:800px;">
                <thead><tr style="text-align:left; color:var(--text-muted); font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--card-border);"><th style="padding:.8rem 1rem;">File</th><th style="padding:.8rem 1rem;">Type</th><th style="padding:.8rem 1rem;">Size</th><th style="padding:.8rem 1rem;">Modified</th><th style="padding:.8rem 1rem;">Actions</th></tr></thead>
                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $backupFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr style="border-bottom:1px solid var(--card-border); vertical-align:top;">
                        <td style="padding:.85rem 1rem; font-weight:600; overflow-wrap:anywhere;"><?php echo e($file['name']); ?></td>
                        <td style="padding:.85rem 1rem;"><span style="padding:.25rem .5rem; border-radius:999px; font-size:.72rem; background:<?php echo e($file['type'] === 'Full Backup' ? 'rgba(34,197,94,.12)' : 'var(--accent-tint)'); ?>; color:<?php echo e($file['type'] === 'Full Backup' ? '#15803d' : 'var(--accent)'); ?>;"><?php echo e($file['type']); ?></span></td>
                        <td style="padding:.85rem 1rem; color:var(--text-muted);"><?php echo e($file['size'] >= 1048576 ? number_format($file['size'] / 1048576, 2) . ' MB' : number_format($file['size'] / 1024, 2) . ' KB'); ?></td>
                        <td style="padding:.85rem 1rem; white-space:nowrap; color:var(--text-muted);"><?php echo e(\Carbon\Carbon::createFromTimestamp($file['modified'])->format('M d, Y H:i')); ?></td>
                        <td style="padding:.85rem 1rem;">
                            <div style="display:flex; gap:.4rem; flex-wrap:wrap;">
                                <a class="btn btn-secondary" style="width:auto; padding:.55rem .7rem; font-size:.78rem;" href="<?php echo e(route('admin.backup.download', urlencode($file['name']))); ?>">Download</a>
                                <form method="POST" action="<?php echo e(route('admin.backup.restore')); ?>" onsubmit="return confirm('Restore <?php echo e($file['name']); ?>? This may overwrite current data.');"><?php echo csrf_field(); ?><input type="hidden" name="backup_file" value="<?php echo e($file['name']); ?>"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($file['type'] === 'Full Backup'): ?><input type="hidden" name="confirm" value="yes"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><button class="btn btn-secondary" style="width:auto; padding:.55rem .7rem; font-size:.78rem; color:var(--danger);" type="submit">Restore</button></form>
                            </div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="5" style="padding:3rem 1rem; text-align:center; color:var(--text-muted);">No backups have been created yet.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <aside class="admin-card backup-diagnostics">
        <h3 style="margin-top:0;">Backup diagnostics</h3>
        <div style="display:grid; gap:.65rem; font-size:.85rem;">
            <div><strong>ZIP:</strong> <?php echo e($diagnostics['zip'] ? 'Available' : 'Missing'); ?></div>
            <div><strong>PharData:</strong> <?php echo e($diagnostics['phar'] ? 'Available' : 'Missing'); ?></div>
            <div><strong>Backup directory:</strong><br><span style="color:var(--text-muted); overflow-wrap:anywhere;"><?php echo e($diagnostics['backup_dir']); ?></span></div>
            <div><strong>Writable:</strong> <?php echo e($diagnostics['backup_dir_writable'] ? 'Yes' : 'No'); ?></div>
        </div>
        <div class="backup-warning" style="margin-top:1rem; padding:1rem; border-radius:10px; background:rgba(245,158,11,.1); color:#92400e; font-size:.85rem;">Whole system backups include the database, application code, public uploads, storage files, configuration, vendor, and node_modules. A full backup runs automatically every day at 02:00, and old backups are pruned after 30 days. Always create a fresh backup before restoring an older file.</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($diagnostics['log_tail']): ?><details style="margin-top:1rem;"><summary style="cursor:pointer; font-weight:600;">Recent backup log</summary><pre style="white-space:pre-wrap; max-height:220px; overflow:auto; font-size:.72rem; color:var(--text-muted);"><?php echo e($diagnostics['log_tail']); ?></pre></details><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </aside>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\settings\backup-restore\index.blade.php ENDPATH**/ ?>