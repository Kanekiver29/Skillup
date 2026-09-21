

<?php $__env->startSection('title', 'Admin Accounts'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <header data-admin-animate class="admin-page-hero p-6 md:p-8 text-white relative z-[1]">
        <div class="relative z-[2] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-sky-200 mb-2">
                    <i class="fas fa-user-shield"></i> Administrator access
                </span>
                <h1 class="text-2xl md:text-3xl font-bold">Admin accounts</h1>
                <p class="text-slate-300 text-sm mt-1">Manage users with full administrator privileges.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="admin-btn admin-btn-secondary !bg-white/10 !text-white !border-white/20 hover:!bg-white/20">
                    <i class="fas fa-user-tie"></i> Staff admin
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="admin-btn admin-btn-primary">
                    <i class="fas fa-users"></i> All users
                </a>
            </div>
        </div>
    </header>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="admin-alert p-4 bg-emerald-50 text-emerald-800 border border-emerald-200" data-admin-animate>
            <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="admin-alert p-4 bg-red-50 text-red-800 border border-red-200" data-admin-animate>
            <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div data-admin-animate class="admin-delay-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="admin-stat-card p-5 text-center sm:text-left">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total admins</p>
            <p class="text-3xl font-bold text-slate-900 mt-1" data-admin-count="<?php echo e($admins->count()); ?>"><?php echo e($admins->count()); ?></p>
        </div>
        <div class="admin-stat-card p-5 flex items-center gap-4 sm:col-span-2">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <i class="fas fa-shield-halved text-[#003a8f] text-xl"></i>
            </div>
            <div>
                <p class="font-semibold text-slate-900">Protected accounts</p>
                <p class="text-sm text-slate-500">Your own account cannot be demoted from this screen.</p>
            </div>
        </div>
    </div>

    <div data-admin-animate class="admin-delay-2 admin-card admin-table-wrap">
        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow" style="background: linear-gradient(135deg, #003a8f, #0a2540);">
                                        <?php echo e(strtoupper(substr($admin->name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900"><?php echo e($admin->name); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($admin->id === auth()->id()): ?>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#003a8f]">You</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?php echo e($admin->email); ?></td>
                            <td class="px-6 py-4 text-sm text-slate-600"><?php echo e($admin->created_at->format('M d, Y')); ?></td>
                            <td class="px-6 py-4 text-right text-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($admin->id !== auth()->id()): ?>
                                    <form action="<?php echo e(route('admin.remove-admin', $admin)); ?>" method="POST" class="inline" onsubmit="return confirm('Remove admin privileges from this user?');">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-red-600 hover:bg-red-50 rounded-lg text-xs font-semibold transition">
                                            <i class="fas fa-user-minus mr-1"></i> Remove admin
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-lock mr-1"></i> Current session
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <i class="fas fa-user-shield text-4xl text-slate-300 mb-3 block"></i>
                                No admin accounts found.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div data-admin-animate class="flex flex-wrap gap-2">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-btn admin-btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to dashboard
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\users\admins.blade.php ENDPATH**/ ?>