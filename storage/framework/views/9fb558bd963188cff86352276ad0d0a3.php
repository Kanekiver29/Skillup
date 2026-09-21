

<?php $__env->startSection('title', 'Module Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="am-page">
    <header class="am-header">
        <div>
            <h1 class="am-title">Modules</h1>
            <p class="am-subtitle">Manage course modules and their content</p>
        </div>
        <a href="<?php echo e(route('admin.modules.create', request('course_id') ? ['course_id' => request('course_id')] : [])); ?>" class="am-btn-new">
            <i class="fas fa-plus"></i> New Module
        </a>
    </header>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="am-alert am-alert-success">
            <span class="am-alert-icon am-alert-icon-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="am-alert am-alert-error">
            <span class="am-alert-icon am-alert-icon-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </span>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Filter by Course -->
    <div class="am-card am-filter-card">
        <form method="GET" action="<?php echo e(route('admin.modules.index')); ?>" class="am-filter-form">
            <label for="course_id" class="am-filter-label">Filter by Course:</label>
            <div class="am-select-wrap">
                <select name="course_id" id="course_id" class="am-select">
                    <option value="">All Courses</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(request('course_id') == $course->id ? 'selected' : ''); ?>>
                            <?php echo e($course->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <svg class="am-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button type="submit" class="am-btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('course_id')): ?>
                <a href="<?php echo e(route('admin.modules.index')); ?>" class="am-link-clear">
                    <i class="fas fa-times"></i> Clear
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </form>
    </div>

    <!-- Modules Table -->
    <div class="am-card am-table-card">
        <table class="am-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Quizzes</th>
                    <th>Published</th>
                    <th class="am-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="am-row" style="animation-delay: <?php echo e(80 + ($loop->index * 40)); ?>ms;">
                        <td>
                            <span class="am-order-badge"><?php echo e($module->order); ?></span>
                        </td>
                        <td>
                            <div class="am-module-title"><?php echo e($module->title); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->description): ?>
                                <p class="am-module-desc"><?php echo e($module->description); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <span class="am-tag am-tag-blue"><?php echo e($module->course->title ?? 'N/A'); ?></span>
                        </td>
                        <td>
                            <span class="am-tag am-tag-purple">
                                <?php echo e($module->quizzes_count); ?> <?php echo e(Str::plural('quiz', $module->quizzes_count)); ?>

                            </span>
                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->is_published): ?>
                                <span class="am-tag am-tag-green">
                                    <i class="fas fa-check-circle"></i> Yes
                                </span>
                            <?php else: ?>
                                <span class="am-tag am-tag-red">
                                    <i class="fas fa-times-circle"></i> No
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="am-td-actions">
                            <a href="<?php echo e(route('admin.modules.edit', $module)); ?>" class="am-link-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="<?php echo e(route('admin.modules.destroy', $module)); ?>" method="POST" class="am-inline-form" onsubmit="return confirm('Archive module \'<?php echo e($module->title); ?>\'? It can be restored later.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="am-link-archive">
                                    <i class="fas fa-archive"></i> Archive
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="am-empty-state">
                            <i class="fas fa-cubes"></i>
                            <p>No modules found.</p>
                            <a href="<?php echo e(route('admin.modules.create')); ?>" class="am-link-empty-cta">
                                Create your first module
                            </a>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="am-pagination-wrap">
        <?php echo e($modules->appends(request()->query())->links()); ?>

    </div>

    <!-- Archived Modules -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($archivedModules->count() > 0): ?>
    <div class="am-archived-section">
        <h2 class="am-archived-title">
            <i class="fas fa-archive"></i> Archived Modules
        </h2>
        <div class="am-card am-table-card am-archived-card">
            <table class="am-table">
                <thead class="am-archived-thead">
                    <tr>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Archived On</th>
                        <th class="am-th-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $archivedModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="am-row">
                            <td class="am-archived-title-cell"><?php echo e($archived->title); ?></td>
                            <td>
                                <span class="am-tag am-tag-blue"><?php echo e($archived->course->title ?? 'N/A'); ?></span>
                            </td>
                            <td class="am-archived-date"><?php echo e($archived->deleted_at->format('M d, Y')); ?></td>
                            <td class="am-td-actions">
                                <form action="<?php echo e(route('admin.modules.restore', $archived->id)); ?>" method="POST" class="am-inline-form" onsubmit="return confirm('Restore module \'<?php echo e($archived->title); ?>\'?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="am-link-restore">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.modules.force-delete', $archived->id)); ?>" method="POST" class="am-inline-form" onsubmit="return confirm('Permanently delete module \'<?php echo e($archived->title); ?>\'? This cannot be undone and will remove all quizzes, questions, and student attempts.');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="am-link-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="am-footer-actions">
        <a href="<?php echo e(route('admin.courses.index')); ?>" class="am-btn-secondary am-btn-blue">
            View Courses
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="am-btn-secondary am-btn-gray">
            Back to Dashboard
        </a>
    </div>
</div>

<style>
:root {
    --am-primary: #4f46e5;
    --am-primary-dark: #4338ca;
    --am-primary-light: #e0e7ff;
    --am-ink: #1e293b;
    --am-muted: #64748b;
    --am-muted-light: #94a3b8;
    --am-border: #e5e7eb;
    --am-surface: #ffffff;
    --am-surface-soft: #f9fafb;
    --am-amber: #d97706;
    --am-amber-bg: #fef3c7;
    --am-green: #15803d;
    --am-green-bg: #dcfce7;
    --am-red: #b91c1c;
    --am-red-bg: #fee2e2;
    --am-blue: #1d4ed8;
    --am-blue-bg: #dbeafe;
    --am-purple: #6d28d9;
    --am-purple-bg: #f3e8ff;
    --am-radius-md: 0.6rem;
    --am-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --am-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.am-page { max-width: 80rem; margin: 0 auto; padding: 1.5rem; color: var(--am-ink); font-family: inherit; }

/* Header */
.am-header {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;
    animation: amFadeInDown 0.4s ease-out both;
}
.am-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--am-ink); }
.am-subtitle { font-size: 0.875rem; color: var(--am-muted-light); margin: 0.15rem 0 0; }

.am-btn-new {
    display: inline-flex; align-items: center; gap: 0.5rem; border-radius: var(--am-radius-md);
    background: var(--am-primary); color: #fff; font-size: 0.875rem; font-weight: 600;
    padding: 0.55rem 1.1rem; text-decoration: none;
    transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}
.am-btn-new:hover { background: var(--am-primary-dark); box-shadow: var(--am-shadow-md); transform: translateY(-1px); }
.am-btn-new:active { transform: scale(0.97); }

/* Alerts */
.am-alert {
    display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem; padding: 1rem;
    border-radius: var(--am-radius-md); font-size: 0.875rem; box-shadow: var(--am-shadow-sm);
    animation: amToastIn 0.35s ease-out both;
}
.am-alert-success { background: var(--am-green-bg); color: #166534; }
.am-alert-error { background: var(--am-red-bg); color: #991b1b; }
.am-alert-icon {
    width: 1.5rem; height: 1.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; color: #fff; animation: amPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
.am-alert-icon svg { width: 0.875rem; height: 0.875rem; }
.am-alert-icon-success { background: #16a34a; }
.am-alert-icon-error { background: #dc2626; }

/* Cards */
.am-card {
    background: var(--am-surface); border: 1px solid var(--am-border); border-radius: 0.9rem;
    box-shadow: var(--am-shadow-sm); transition: box-shadow 0.3s ease;
}
.am-card:hover { box-shadow: var(--am-shadow-md); }

.am-filter-card { padding: 1.1rem; margin-bottom: 1.5rem; animation: amFadeInUp 0.45s ease-out both; }
.am-filter-form { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; }
.am-filter-label { font-size: 0.875rem; font-weight: 600; color: #374151; }
.am-select-wrap { position: relative; }
.am-select {
    appearance: none; border: 1px solid var(--am-border); border-radius: var(--am-radius-md); background: #fff;
    padding: 0.5rem 2rem 0.5rem 0.85rem; font-size: 0.875rem; color: var(--am-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.am-select:focus { outline: none; border-color: var(--am-primary); box-shadow: 0 0 0 4px var(--am-primary-light); }
.am-select-caret { position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%); width: 0.9rem; height: 0.9rem; color: var(--am-muted-light); pointer-events: none; }

.am-btn-filter {
    display: inline-flex; align-items: center; gap: 0.45rem; border: none; border-radius: var(--am-radius-md);
    background: #4b5563; color: #fff; font-size: 0.875rem; font-weight: 600; padding: 0.5rem 1rem; cursor: pointer;
    transition: background-color 0.2s ease, transform 0.15s ease;
}
.am-btn-filter:hover { background: #374151; transform: translateY(-1px); }
.am-btn-filter:active { transform: scale(0.96); }

.am-link-clear { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.875rem; color: var(--am-muted); text-decoration: none; transition: color 0.15s ease; }
.am-link-clear:hover { color: #1f2937; }

/* Table */
.am-table-card { overflow-x: auto; animation: amFadeInUp 0.45s ease-out 0.1s both; }
.am-table { width: 100%; border-collapse: collapse; }
.am-table thead { background: var(--am-surface-soft); }
.am-table th {
    text-align: left; padding: 0.85rem 1.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.04em; color: #374151; border-bottom: 1px solid var(--am-border);
}
.am-th-right { text-align: right; }
.am-table td { padding: 1rem 1.5rem; font-size: 0.875rem; border-bottom: 1px solid var(--am-border); vertical-align: top; }
.am-row { animation: amFadeInUp 0.4s ease-out both; transition: background-color 0.15s ease; }
.am-row:hover { background: var(--am-surface-soft); }
.am-row:last-child td { border-bottom: none; }

.am-order-badge {
    display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem;
    border-radius: 999px; background: var(--am-surface-soft); color: #374151; font-weight: 700; font-size: 0.75rem;
}
.am-module-title { font-weight: 600; color: #111827; }
.am-module-desc { margin-top: 0.25rem; font-size: 0.75rem; color: var(--am-muted-light); max-width: 20rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.am-tag {
    display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.25rem 0.6rem; border-radius: 0.4rem;
    font-size: 0.75rem; font-weight: 600;
}
.am-tag-blue { background: var(--am-blue-bg); color: var(--am-blue); }
.am-tag-purple { background: var(--am-purple-bg); color: var(--am-purple); }
.am-tag-green { background: var(--am-green-bg); color: var(--am-green); }
.am-tag-red { background: var(--am-red-bg); color: var(--am-red); }

.am-td-actions { text-align: right; white-space: nowrap; }
.am-inline-form { display: inline-block; margin-left: 0.85rem; }
.am-inline-form:first-child { margin-left: 0; }
.am-link-edit { color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.8rem; transition: color 0.15s ease; }
.am-link-edit:hover { color: #1d4ed8; }
.am-link-archive { color: var(--am-amber); background: none; border: none; cursor: pointer; font-weight: 600; font-size: 0.8rem; transition: color 0.15s ease; }
.am-link-archive:hover { color: #92400e; }
.am-link-restore { color: #16a34a; background: none; border: none; cursor: pointer; font-weight: 600; font-size: 0.8rem; transition: color 0.15s ease; }
.am-link-restore:hover { color: #15803d; }
.am-link-delete { color: #dc2626; background: none; border: none; cursor: pointer; font-weight: 600; font-size: 0.8rem; transition: color 0.15s ease; }
.am-link-delete:hover { color: #991b1b; }

.am-empty-state { text-align: center; padding: 3rem 1.5rem; color: var(--am-muted-light); }
.am-empty-state i { font-size: 2.5rem; color: #d1d5db; margin-bottom: 0.75rem; display: block; }
.am-empty-state p { margin: 0 0 0.5rem; }
.am-link-empty-cta { color: var(--am-primary); font-size: 0.875rem; text-decoration: none; font-weight: 600; transition: color 0.15s ease; }
.am-link-empty-cta:hover { color: var(--am-primary-dark); }

/* Pagination failsafe */
.am-pagination-wrap { margin-top: 1rem; animation: amFadeInUp 0.45s ease-out 0.15s both; }
.am-pagination-wrap nav { display: flex; justify-content: center; }
.am-pagination-wrap svg {
    width: 1.1rem !important;
    height: 1.1rem !important;
    display: inline-block !important;
    vertical-align: middle !important;
}

/* Archived section */
.am-archived-section { margin-top: 2rem; animation: amFadeInUp 0.45s ease-out 0.2s both; }
.am-archived-title { display: flex; align-items: center; gap: 0.5rem; font-size: 1.25rem; font-weight: 700; color: #374151; margin: 0 0 1rem; }
.am-archived-title i { color: var(--am-amber); }
.am-archived-card { border-color: #fde68a; }
.am-archived-thead { background: #fffbeb; }
.am-archived-title-cell { font-weight: 600; color: #6b7280; }
.am-archived-date { color: #6b7280; }

/* Footer actions */
.am-footer-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap; }
.am-btn-secondary {
    display: inline-flex; align-items: center; border-radius: var(--am-radius-md); padding: 0.55rem 1.1rem;
    font-size: 0.875rem; font-weight: 600; color: #fff; text-decoration: none;
    transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}
.am-btn-blue { background: #2563eb; }
.am-btn-blue:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: var(--am-shadow-md); }
.am-btn-gray { background: #4b5563; }
.am-btn-gray:hover { background: #374151; transform: translateY(-1px); box-shadow: var(--am-shadow-md); }

/* Animations */
@keyframes amFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes amFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes amToastIn { from { opacity: 0; transform: translateY(-8px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes amPop { 0% { transform: scale(0); } 70% { transform: scale(1.15); } 100% { transform: scale(1); } }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\modules\index.blade.php ENDPATH**/ ?>