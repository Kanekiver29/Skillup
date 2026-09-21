

<?php $__env->startSection('title', 'Backup & Recovery - SkillUp Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Backup & Recovery</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">Backup & Recovery</span>
                </nav>
            </div>
            <div class="text-sm text-gray-600 bg-cyan-50 border border-cyan-100 rounded-lg px-4 py-3">
                <p class="font-medium text-cyan-700"><?php echo e(strtoupper($driver)); ?> database</p>
                <p class="text-cyan-600">Connected: <?php echo e($connection); ?></p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 space-y-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-5 text-emerald-900">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-emerald-600 mt-1"></i>
                    <div>
                        <p class="font-semibold">Success</p>
                        <p class="text-sm"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Automatic backup</p>
                <p class="mt-2 text-lg font-semibold text-emerald-700">Enabled</p>
                <p class="text-sm text-gray-500">Daily at 02:00, retention <?php echo e((int) env('BACKUP_RETENTION_DAYS', 30)); ?> days</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Last successful backup</p>
                <p class="mt-2 text-lg font-semibold text-gray-900"><?php echo e($lastSuccessfulBackup?->completed_at?->format('M d, Y H:i') ?? 'None yet'); ?></p>
                <p class="text-sm text-gray-500"><?php echo e($lastSuccessfulBackup?->filename ?? 'Create the first backup now'); ?></p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Recovery audit</p>
                <p class="mt-2 text-lg font-semibold text-gray-900"><?php echo e($recentRecoveryLogs->count()); ?> recent events</p>
                <p class="text-sm text-gray-500">Restore, upload, and delete operations are logged.</p>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="bg-rose-50 border border-rose-200 rounded-lg p-5 text-rose-900">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-rose-600 mt-1"></i>
                    <div>
                        <p class="font-semibold">Error</p>
                        <p class="text-sm"><?php echo e(session('error')); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Backup history</h2>
                        <p class="text-sm text-gray-500 mt-1">Create and restore database backups from this page.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <form action="<?php echo e(route('admin.backup.fullBackup')); ?>" method="POST" class="inline-flex items-center gap-3">
                            <?php echo csrf_field(); ?>
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="include_all" value="1" class="h-4 w-4">
                                <span class="text-sm">Include everything (vendor, node_modules)</span>
                            </label>
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                <i class="fas fa-file-archive"></i>
                                Backup Now
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.backup.upload')); ?>" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                            <?php echo csrf_field(); ?>
                            <input type="file" name="backup" accept=".zip,.7z,.tar,.gz,.tgz" required class="max-w-[190px] text-xs">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm font-semibold text-cyan-700 hover:bg-cyan-100"><i class="fas fa-upload"></i> Upload</button>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">File</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Type</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Size</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Modified</th>
                                <th class="px-5 py-4 text-right font-semibold text-gray-600 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 text-gray-900 font-medium">
                                        <i class="fas fa-box text-gray-400 mr-2"></i>
                                        <?php echo e($backup->filename); ?>

                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-cyan-100 text-cyan-800 px-3 py-1 text-xs font-semibold">
                                            <?php echo e(ucfirst($backup->type)); ?> / <?php echo e(ucfirst($backup->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($backup->size > 1024*1024*1024): ?>
                                            <?php echo e(number_format($backup->size / (1024*1024*1024), 2)); ?> GB
                                        <?php elseif($backup->size > 1024*1024): ?>
                                            <?php echo e(number_format($backup->size / (1024*1024), 2)); ?> MB
                                        <?php else: ?>
                                            <?php echo e(number_format($backup->size / 1024, 2)); ?> KB
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-5 py-4 text-gray-700"><?php echo e(optional($backup->completed_at ?? $backup->created_at)->format('M d, Y H:i')); ?></td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        <a href="<?php echo e(route('admin.backup.download', urlencode($backup->filename))); ?>" class="inline-flex items-center gap-2 rounded-lg border border-cyan-100 bg-cyan-50 px-4 py-2 text-xs font-semibold text-cyan-700 hover:bg-cyan-100">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($backup->status === 'success'): ?>
                                            <form action="<?php echo e(route('admin.backup.restore')); ?>" method="POST" class="inline-flex items-center gap-2">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="backup_file" value="<?php echo e($backup->filename); ?>">
                                                <input type="password" name="password" placeholder="Archive password" class="w-32 rounded border border-slate-200 px-2 py-2 text-xs">
                                                <label class="inline-flex items-center gap-1 text-xs"><input type="checkbox" name="confirm" value="1" required> Confirm overwrite</label>
                                                <button type="submit" onclick="return confirm('Restore this backup? Existing database and uploaded files may be replaced.')" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                                    <i class="fas fa-undo"></i>
                                                    Restore
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <form action="<?php echo e(route('admin.backup.delete', $backup)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Delete this backup permanently?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500">No backups have been created yet.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4"><?php echo e($backups->links()); ?></div>
            </div>

            <aside class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Recovery checklist</h3>
                    <p class="text-sm text-gray-500 mt-2">Use this module to create fail-safe snapshots and restore the DB quickly.</p>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($diagnostics)): ?>
                    <div class="rounded-lg border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Diagnostics</p>
                        <ul class="text-sm text-gray-600 mt-2 space-y-2">
                            <li><strong>ZIP extension:</strong> <span class="font-medium"><?php echo e($diagnostics['zip'] ? 'available' : 'missing'); ?></span></li>
                            <li><strong>PharData:</strong> <span class="font-medium"><?php echo e($diagnostics['phar'] ? 'available' : 'missing'); ?></span></li>
                            <li><strong>phar.readonly:</strong> <span class="font-medium"><?php echo e($diagnostics['phar_readonly']); ?></span></li>
                            <li><strong>temp dir:</strong> <span class="font-medium"><?php echo e($diagnostics['temp_dir']); ?></span></li>
                            <li><strong>open_basedir:</strong> <span class="font-medium"><?php echo e($diagnostics['open_basedir']); ?></span></li>
                            <li><strong>backup dir:</strong> <span class="font-medium"><?php echo e($diagnostics['backup_dir']); ?></span></li>
                            <li><strong>backup dir writable:</strong> <span class="font-medium"><?php echo e($diagnostics['backup_dir_writable'] ? 'yes' : 'no'); ?></span></li>
                        </ul>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($diagnostics['log_summary']): ?>
                        <div class="rounded-lg border border-rose-100 bg-rose-50 p-3">
                            <p class="font-semibold text-rose-800">Latest error summary</p>
                            <p class="mt-2 text-xs text-rose-900 break-words"><?php echo e($diagnostics['log_summary']); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="font-semibold text-emerald-700">Full Backup</p>
                        <p class="mt-1">Creates a ZIP archive with all application files and database backup. Perfect for complete system recovery.</p>
                    </div>
                    <div class="rounded-xl border border-cyan-100 bg-cyan-50 p-4">
                        <p class="font-semibold text-cyan-700">Database Only</p>
                        <p class="mt-1">Creates a database backup only. Smaller file size, faster backup process.</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Backup first</p>
                        <p class="mt-1">Always make a fresh backup before restoring an older snapshot.</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Storage location</p>
                        <p class="mt-1">Backups are saved in the local storage disk under <code>storage/app/backups</code>.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\backup.blade.php ENDPATH**/ ?>