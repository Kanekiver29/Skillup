

<?php $__env->startSection('title', 'All Enrollments'); ?>

<?php $__env->startSection('content'); ?>
<div class="en-page">
    <header class="en-header">
        <div>
            <h1 class="en-title">Enrollments</h1>
            <p class="en-subtitle">Track student progress across every course.</p>
        </div>
        <span class="en-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3c0-1.657-2.686-3-6-3s-6 1.343-6 3" />
            </svg>
            <?php echo e($enrollments->total()); ?> total
        </span>
    </header>

    <div class="en-card">
        <table class="en-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Student</th>
                    <th>Progress</th>
                    <th>Completed</th>
                    <th>Enrolled On</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="en-row" style="animation-delay: <?php echo e(60 + ($loop->index * 35)); ?>ms;">
                        <td class="en-td-course"><?php echo e($e->course->title ?? 'Deleted Course'); ?></td>
                        <td>
                            <div class="en-student-name"><?php echo e($e->user->name ?? 'Deleted User'); ?></div>
                            <div class="en-student-email"><?php echo e($e->user->email ?? '-'); ?></div>
                        </td>
                        <td class="en-td-progress">
                            <div class="en-progress-row">
                                <div class="en-progress-track">
                                    <div class="en-progress-fill" style="width: <?php echo e(min(100, max(0, $e->progress ?? 0))); ?>%;"></div>
                                </div>
                                <span class="en-progress-label"><?php echo e($e->progress ?? 0); ?>%</span>
                            </div>
                        </td>
                        <td>
                            <?php if($e->completed): ?>
                                <span class="en-badge en-badge-success">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Yes
                                </span>
                            <?php else: ?>
                                <span class="en-badge en-badge-pending">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3" />
                                        <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    </svg>
                                    No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="en-td-date"><?php echo e($e->created_at->format('M d, Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="en-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 3c0-1.657-2.686-3-6-3s-6 1.343-6 3" />
                            </svg>
                            <span>No enrollments found.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="en-pagination-wrap">
        <?php echo e($enrollments->links()); ?>

    </div>
</div>

<style>
:root {
    --en-primary: #0284c7;
    --en-primary-dark: #0369a1;
    --en-primary-light: #e0f2fe;
    --en-ink: #0f172a;
    --en-body: #334155;
    --en-muted: #64748b;
    --en-muted-light: #94a3b8;
    --en-border: #e2e8f0;
    --en-surface: #ffffff;
    --en-surface-soft: #f8fafc;
    --en-success: #15803d;
    --en-success-bg: #dcfce7;
    --en-pending: #b45309;
    --en-pending-bg: #fef3c7;
    --en-radius-md: 0.75rem;
    --en-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --en-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.en-page { max-width: 80rem; margin: 0 auto; padding: 1.5rem; color: var(--en-ink); font-family: inherit; }

/* Header */
.en-header {
    display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;
    animation: enFadeInDown 0.4s ease-out both;
}
@media (min-width: 640px) { .en-header { flex-direction: row; align-items: center; justify-content: space-between; } }
.en-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--en-ink); }
.en-subtitle { font-size: 0.875rem; color: var(--en-muted); margin: 0.15rem 0 0; }
.en-pill {
    display: inline-flex; align-items: center; gap: 0.4rem; width: fit-content;
    padding: 0.35rem 0.85rem; border-radius: 999px; background: var(--en-primary-light);
    color: var(--en-primary-dark); font-size: 0.75rem; font-weight: 700;
}
.en-pill svg { width: 0.9rem; height: 0.9rem; }

/* Card + table */
.en-card {
    background: var(--en-surface); border: 1px solid var(--en-border); border-radius: 1.1rem;
    box-shadow: var(--en-shadow-sm); overflow-x: auto; transition: box-shadow 0.3s ease;
    animation: enFadeInUp 0.45s ease-out both;
}
.en-card:hover { box-shadow: var(--en-shadow-md); }
.en-table { width: 100%; border-collapse: collapse; }
.en-table thead { background: var(--en-surface-soft); }
.en-table th {
    text-align: left; padding: 0.85rem 1.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: #334155; border-bottom: 1px solid var(--en-border);
}
.en-table td { padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--en-body); border-bottom: 1px solid var(--en-border); vertical-align: middle; }
.en-row { animation: enFadeInUp 0.4s ease-out both; transition: background-color 0.15s ease; }
.en-row:hover { background: var(--en-surface-soft); }
.en-row:last-child td { border-bottom: none; }

.en-td-course { font-weight: 700; color: var(--en-ink); }
.en-student-name { font-weight: 600; color: #1e293b; }
.en-student-email { margin-top: 0.15rem; font-size: 0.75rem; color: var(--en-muted); }
.en-td-date { color: var(--en-muted); white-space: nowrap; }

.en-td-progress { min-width: 12rem; }
.en-progress-row { display: flex; align-items: center; gap: 0.65rem; }
.en-progress-track { flex: 1; height: 0.5rem; border-radius: 999px; background: var(--en-border); overflow: hidden; }
.en-progress-fill {
    height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--en-primary), #38bdf8);
    transition: width 0.6s ease;
}
.en-progress-label { font-weight: 700; color: #1e293b; font-size: 0.8rem; min-width: 2.5rem; text-align: right; }

.en-badge {
    display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.3rem 0.7rem; border-radius: 999px;
    font-size: 0.75rem; font-weight: 700;
}
.en-badge svg { width: 0.8rem; height: 0.8rem; }
.en-badge-success { background: var(--en-success-bg); color: var(--en-success); }
.en-badge-pending { background: var(--en-pending-bg); color: var(--en-pending); }

.en-empty-state {
    text-align: center; padding: 3rem 1.5rem; color: var(--en-muted);
    display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
}
.en-empty-state svg { width: 2.5rem; height: 2.5rem; color: var(--en-muted-light); }
.en-empty-state span { font-size: 0.875rem; font-weight: 500; }

/* Pagination failsafe: caps SVGs from Laravel's default pagination view in case its
   own Tailwind classes are not compiled on this project. */
.en-pagination-wrap { margin-top: 1.25rem; animation: enFadeInUp 0.45s ease-out 0.1s both; }
.en-pagination-wrap nav { display: flex; justify-content: center; }
.en-pagination-wrap svg {
    width: 1.1rem !important;
    height: 1.1rem !important;
    display: inline-block !important;
    vertical-align: middle !important;
}
.en-pagination-wrap a, .en-pagination-wrap span {
    color: var(--en-body) !important;
}

/* Animations */
@keyframes enFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes enFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Admin/enrollments/index.blade.php ENDPATH**/ ?>