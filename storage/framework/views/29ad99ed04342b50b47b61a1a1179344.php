

<?php $__env->startSection('content'); ?>
<div class="sm-page">
    <header class="sm-header">
        <div>
            <h1 class="sm-title">Staff Management</h1>
            <p class="sm-subtitle">Manage platform staff, assign staff roles, and review staff accounts.</p>
        </div>
        <div class="sm-header-actions">
            <a href="<?php echo e(route('admin.staff.create')); ?>" class="sm-btn sm-btn-emerald">
                <i class="fas fa-user-plus"></i> Create Staff
            </a>
            <a href="<?php echo e(route('admin.staff.register')); ?>" class="sm-btn sm-btn-blue">
                <i class="fas fa-id-badge"></i> Register Account
            </a>
        </div>
    </header>

    <div class="sm-stats-grid">
        <div class="sm-stat-card sm-stat-primary">
            <p class="sm-stat-label">Total Staff</p>
            <p class="sm-stat-value"><?php echo e(number_format($totalStaff ?? 0)); ?></p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $staffByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="sm-stat-card">
                <p class="sm-stat-label"><?php echo e($info['label']); ?></p>
                <p class="sm-stat-value"><?php echo e(number_format($info['count'] ?? 0)); ?></p>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="sm-card sm-filter-card">
        <form method="GET" action="<?php echo e(route('admin.staff.index')); ?>" class="sm-filter-form">
            <div class="sm-filter-field">
                <label class="sm-label">Filter by staff type</label>
                <div class="sm-select-wrap">
                    <select name="staff_type" class="sm-select">
                        <option value="">All Staff Types</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $staffTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(request('staff_type') == $key ? 'selected' : ''); ?>><?php echo e($type['label']); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <svg class="sm-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            <div class="sm-filter-buttons">
                <button type="submit" class="sm-btn sm-btn-dark">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="sm-btn sm-btn-outline">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="sm-card sm-table-card">
        <div class="sm-table-header">
            <h2 class="sm-table-title">Staff List</h2>
            <span class="sm-table-count"><?php echo e($staff->total()); ?> <?php echo e(Str::plural('member', $staff->total())); ?></span>
        </div>
        <table class="sm-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th class="sm-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="sm-row" style="animation-delay: <?php echo e(60 + ($loop->index * 35)); ?>ms;">
                        <td class="sm-td-name">
                            <div class="sm-avatar"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                            <span><?php echo e($user->name); ?></span>
                        </td>
                        <td class="sm-td-email"><?php echo e($user->email); ?></td>
                        <td>
                            <span class="sm-type-badge"><?php echo e($staffTypes[$user->staff_type]['label'] ?? '—'); ?></span>
                        </td>
                        <td class="sm-td-actions">
                            <a href="<?php echo e(route('admin.staff.transfer', $user)); ?>" class="sm-link-transfer">
                                <i class="fas fa-right-left"></i> Transfer
                            </a>
                            <form action="<?php echo e(route('admin.staff.demote', $user)); ?>" method="POST" class="sm-inline-form" onsubmit="return confirm('Demote this staff member to student?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="sm-link-demote">
                                    <i class="fas fa-user-minus"></i> Demote
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="4" class="sm-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3c0-1.657-2.686-3-6-3s-6 1.343-6 3" />
                            </svg>
                            <span>No staff found.</span>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        <div class="sm-pagination-wrap"><?php echo e($staff->links()); ?></div>
    </div>
</div>

<style>
:root {
    --sm-primary: #0f766e;
    --sm-primary-dark: #115e59;
    --sm-primary-light: #ccfbf1;
    --sm-ink: #0f172a;
    --sm-body: #334155;
    --sm-muted: #64748b;
    --sm-muted-light: #94a3b8;
    --sm-border: #e2e8f0;
    --sm-surface: #ffffff;
    --sm-surface-soft: #f8fafc;
    --sm-emerald: #059669;
    --sm-emerald-dark: #047857;
    --sm-blue: #2563eb;
    --sm-blue-dark: #1d4ed8;
    --sm-dark: #334155;
    --sm-dark-hover: #1e293b;
    --sm-red: #dc2626;
    --sm-red-dark: #b91c1c;
    --sm-indigo: #4f46e5;
    --sm-indigo-dark: #4338ca;
    --sm-radius-md: 0.85rem;
    --sm-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --sm-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.sm-page { max-width: 80rem; margin: 0 auto; padding: 1.5rem; color: var(--sm-body); font-family: inherit; display: flex; flex-direction: column; gap: 1.5rem; }

/* Header */
.sm-header {
    display: flex; flex-direction: column; gap: 1rem;
    animation: smFadeInDown 0.4s ease-out both;
}
@media (min-width: 1024px) { .sm-header { flex-direction: row; align-items: flex-end; justify-content: space-between; } }
.sm-title { font-size: 1.5rem; font-weight: 700; margin: 0; color: var(--sm-ink); }
.sm-subtitle { font-size: 0.875rem; color: var(--sm-body); margin: 0.25rem 0 0; }
.sm-header-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; }

.sm-btn {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.55rem 1.1rem; border-radius: var(--sm-radius-md);
    font-size: 0.875rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer;
    transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease, color 0.2s ease;
    color: #fff;
}
.sm-btn:active { transform: scale(0.96); }
.sm-btn-emerald { background: var(--sm-emerald); box-shadow: var(--sm-shadow-sm); }
.sm-btn-emerald:hover { background: var(--sm-emerald-dark); box-shadow: var(--sm-shadow-md); transform: translateY(-1px); }
.sm-btn-blue { background: var(--sm-blue); box-shadow: var(--sm-shadow-sm); }
.sm-btn-blue:hover { background: var(--sm-blue-dark); box-shadow: var(--sm-shadow-md); transform: translateY(-1px); }
.sm-btn-dark { background: var(--sm-dark); }
.sm-btn-dark:hover { background: var(--sm-dark-hover); transform: translateY(-1px); }
.sm-btn-outline { background: #fff; color: var(--sm-body); border: 1px solid var(--sm-border); }
.sm-btn-outline:hover { background: var(--sm-surface-soft); color: var(--sm-ink); }

/* Stat cards */
.sm-stats-grid {
    display: grid; grid-template-columns: 1fr; gap: 1rem;
    animation: smFadeInUp 0.45s ease-out both;
}
@media (min-width: 768px) { .sm-stats-grid { grid-template-columns: repeat(auto-fit, minmax(11rem, 1fr)); } }
.sm-stat-card {
    background: var(--sm-surface); border: 1px solid var(--sm-border); border-radius: 1.1rem; padding: 1rem 1.1rem;
    box-shadow: var(--sm-shadow-sm); transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.sm-stat-card:hover { box-shadow: var(--sm-shadow-md); transform: translateY(-2px); }
.sm-stat-primary { background: linear-gradient(160deg, #ecfeff, #ffffff); border-color: #a5f3fc; }
.sm-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--sm-muted); margin: 0; }
.sm-stat-value { font-size: 1.6rem; font-weight: 700; color: var(--sm-ink); margin: 0.4rem 0 0; }

/* Cards */
.sm-card {
    background: var(--sm-surface); border: 1px solid var(--sm-border); border-radius: 1.1rem;
    box-shadow: var(--sm-shadow-sm); transition: box-shadow 0.3s ease;
}
.sm-card:hover { box-shadow: var(--sm-shadow-md); }

.sm-filter-card { padding: 1.25rem; animation: smFadeInUp 0.45s ease-out 0.05s both; }
.sm-filter-form { display: flex; flex-direction: column; gap: 1rem; }
@media (min-width: 768px) { .sm-filter-form { flex-direction: row; align-items: flex-end; } }
.sm-filter-field { flex: 1; }
.sm-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--sm-ink); margin-bottom: 0.4rem; }
.sm-select-wrap { position: relative; max-width: 20rem; }
.sm-select {
    width: 100%; appearance: none; border: 1px solid var(--sm-border); border-radius: 0.6rem; background: #fff;
    padding: 0.6rem 2rem 0.6rem 0.85rem; font-size: 0.875rem; color: var(--sm-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.sm-select:focus { outline: none; border-color: var(--sm-primary); box-shadow: 0 0 0 4px var(--sm-primary-light); }
.sm-select-caret { position: absolute; right: 0.7rem; top: 50%; transform: translateY(-50%); width: 0.9rem; height: 0.9rem; color: var(--sm-muted-light); pointer-events: none; }
.sm-filter-buttons { display: flex; gap: 0.6rem; }

/* Table card */
.sm-table-card { overflow: hidden; animation: smFadeInUp 0.45s ease-out 0.1s both; }
.sm-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.25rem; border-bottom: 1px solid var(--sm-border); }
.sm-table-title { font-size: 1.1rem; font-weight: 700; color: var(--sm-ink); margin: 0; }
.sm-table-count { font-size: 0.75rem; font-weight: 600; color: var(--sm-muted); background: var(--sm-surface-soft); padding: 0.3rem 0.7rem; border-radius: 999px; }

.sm-table { width: 100%; border-collapse: collapse; }
.sm-table thead { background: var(--sm-surface-soft); }
.sm-table th {
    text-align: left; padding: 0.85rem 1.25rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: #334155; border-bottom: 1px solid var(--sm-border);
}
.sm-th-right { text-align: right; }
.sm-table td { padding: 1rem 1.25rem; font-size: 0.875rem; color: var(--sm-body); border-bottom: 1px solid var(--sm-border); vertical-align: middle; }
.sm-row { animation: smFadeInUp 0.4s ease-out both; transition: background-color 0.15s ease; }
.sm-row:hover { background: var(--sm-surface-soft); }
.sm-row:last-child td { border-bottom: none; }

.sm-td-name { display: flex; align-items: center; gap: 0.65rem; font-weight: 600; color: var(--sm-ink); }
.sm-avatar {
    width: 2rem; height: 2rem; border-radius: 999px; background: linear-gradient(135deg, #0f766e, #0284c7);
    color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
}
.sm-td-email { color: var(--sm-body); }
.sm-type-badge {
    display: inline-flex; align-items: center; padding: 0.25rem 0.65rem; border-radius: 999px;
    background: #eef2ff; color: var(--sm-indigo-dark); font-size: 0.75rem; font-weight: 700;
}

.sm-td-actions { text-align: right; white-space: nowrap; }
.sm-inline-form { display: inline-block; margin-left: 0.9rem; }
.sm-link-transfer { display: inline-flex; align-items: center; gap: 0.35rem; color: var(--sm-indigo); font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: color 0.15s ease; }
.sm-link-transfer:hover { color: var(--sm-indigo-dark); }
.sm-link-demote { display: inline-flex; align-items: center; gap: 0.35rem; color: var(--sm-red); background: none; border: none; cursor: pointer; font-weight: 600; font-size: 0.85rem; transition: color 0.15s ease; }
.sm-link-demote:hover { color: var(--sm-red-dark); }

.sm-empty-state {
    text-align: center; padding: 3rem 1.5rem; color: var(--sm-muted);
    display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
}
.sm-empty-state svg { width: 2.25rem; height: 2.25rem; color: var(--sm-muted-light); }
.sm-empty-state span { font-size: 0.875rem; font-weight: 500; }

/* Pagination failsafe: caps SVGs from Laravel's default pagination view in case its
   own Tailwind classes are not compiled on this project, and forces readable link color. */
.sm-pagination-wrap { padding: 1rem 1.25rem; }
.sm-pagination-wrap nav { display: flex; justify-content: center; }
.sm-pagination-wrap svg {
    width: 1.1rem !important;
    height: 1.1rem !important;
    display: inline-block !important;
    vertical-align: middle !important;
}
.sm-pagination-wrap a, .sm-pagination-wrap span {
    color: var(--sm-body) !important;
}

/* Animations */
@keyframes smFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes smFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\staff\index.blade.php ENDPATH**/ ?>