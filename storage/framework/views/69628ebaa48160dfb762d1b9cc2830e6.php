<?php $__env->startSection('title', 'Assessment'); ?>
<?php $__env->startSection('page_title', 'Assessment'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .as-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --pass:#16a34a; --fail:#dc2626; --warn:#d97706;
               --accent:#3b82f6; --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .anim { opacity:0; animation:fadeUp .4s var(--ease) forwards; }

    /* ── Print button ────────────────────────────────── */
    .btn-print {
        display:inline-flex; align-items:center; gap:.45rem;
        padding:.65rem 1.25rem; border-radius:999px;
        background:#0f172a; color:#fff; font-size:.88rem; font-weight:600;
        border:none; cursor:pointer;
        transition:background .15s ease, transform .12s ease, box-shadow .12s ease;
    }
    .btn-print:hover { background:#1e293b; transform:translateY(-1px); box-shadow:0 6px 16px -8px rgba(15,23,42,.5); }
    .btn-print:active { transform:translateY(0); }
    .btn-print svg { width:15px; height:15px; }

    /* ── Stats bar ───────────────────────────────────── */
    .as-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:.75rem; }
    .as-stat { background:#fff; border:1px solid var(--line); border-radius:14px; padding:1rem 1.1rem; }
    .as-stat .label { font-size:.72rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase; color:var(--muted); }
    .as-stat .value { font-size:1.65rem; font-weight:800; color:var(--ink); line-height:1.2; margin-top:.2rem; }
    .as-stat .value.pass { color:var(--pass); }
    .as-stat .value.warn { color:var(--warn); }

    /* ── Section headers ─────────────────────────────── */
    .as-section-title { font-size:.78rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
        color:var(--muted); margin:1.4rem 0 .55rem; display:flex; align-items:center; gap:.5rem; }
    .as-section-title::after { content:''; flex:1; height:1px; background:var(--line); }

    /* ── Cards ───────────────────────────────────────── */
    .as-card { background:#fff; border:1px solid var(--line); border-radius:14px; overflow:hidden;
        transition:border-color .15s ease; }
    .as-card:hover { border-color:#cbd5e1; }

    /* ── Table ───────────────────────────────────────── */
    .as-table { width:100%; border-collapse:collapse; font-size:.9rem; }
    .as-table th { padding:.65rem .85rem; font-size:.75rem; font-weight:700; letter-spacing:.06em;
        text-transform:uppercase; color:var(--muted); background:#f8fafc;
        border-bottom:1px solid var(--line); text-align:left; white-space:nowrap; }
    .as-table td { padding:.8rem .85rem; border-bottom:1px solid var(--line); color:var(--ink); vertical-align:middle; }
    .as-table tbody tr:last-child td { border-bottom:none; }
    .as-table tbody tr { transition:background .1s ease; }
    .as-table tbody tr:hover { background:#f8fafc; }

    /* ── Score bar ───────────────────────────────────── */
    .score-bar-wrap { display:flex; align-items:center; gap:.6rem; min-width:120px; }
    .score-bar { flex:1; height:6px; border-radius:99px; background:#e2e8f0; overflow:hidden; }
    .score-bar-fill { height:100%; border-radius:99px; transition:width .4s var(--ease); }
    .score-bar-fill.pass { background:var(--pass); }
    .score-bar-fill.fail { background:var(--fail); }
    .score-pct { font-size:.82rem; font-weight:700; min-width:38px; text-align:right; }
    .score-pct.pass { color:var(--pass); }
    .score-pct.fail { color:var(--fail); }

    /* ── Badge ───────────────────────────────────────── */
    .badge { display:inline-flex; align-items:center; gap:.28rem; padding:.22rem .6rem;
        border-radius:999px; font-size:.72rem; font-weight:700; white-space:nowrap; }
    .badge.pass { background:#dcfce7; color:#15803d; }
    .badge.fail { background:#fee2e2; color:#b91c1c; }
    .badge.prog { background:#fef3c7; color:#b45309; }
    .badge.blue { background:#dbeafe; color:#1d4ed8; }

    /* ── Upcoming card ───────────────────────────────── */
    .upcoming-row { display:flex; align-items:center; justify-content:space-between;
        gap:.75rem; padding:.85rem 1.1rem; border-bottom:1px solid var(--line); flex-wrap:wrap; }
    .upcoming-row:last-child { border-bottom:none; }
    .upcoming-row .info { flex:1; min-width:0; }
    .upcoming-row .title { font-weight:600; font-size:.93rem; color:var(--ink); }
    .upcoming-row .meta { font-size:.8rem; color:var(--muted); margin-top:.15rem; }

    /* ── Empty state ─────────────────────────────────── */
    .as-empty { padding:2.5rem 1rem; text-align:center; color:var(--muted); font-size:.92rem; }
    .as-empty svg { width:40px; height:40px; margin:0 auto .75rem; opacity:.35; display:block; }

    /* ── Print styles ────────────────────────────────── */
    @media print {
        .no-print, .page-header-actions, .nav-panel, nav, .btn-print { display:none !important; }
        .page-card { box-shadow:none !important; border:none !important; padding:0 !important; }
        .as-card { border:1px solid #ccc !important; break-inside:avoid; }
        .as-table td, .as-table th { font-size:.8rem !important; }
        body { background:#fff !important; }
        .print-header { display:block !important; }
    }
    .print-header { display:none; }
</style>

<div class="as-page" style="display:grid;gap:1.2rem;">

    
    <div class="print-header" style="border-bottom:2px solid #0f172a;padding-bottom:.75rem;margin-bottom:.5rem;">
        <strong style="font-size:1.1rem;"><?php echo e($user->name ?? 'Student'); ?></strong> &mdash;
        Assessment Report &mdash; Printed <?php echo e(now()->format('F d, Y')); ?>

    </div>

    
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;" class="no-print anim" style="animation-delay:.02s;">
        <p style="color:var(--sub);margin:0;font-size:.95rem;">
            Track your quiz performance, scores, and upcoming assessments.
        </p>
        <button class="btn-print" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print / Save PDF
        </button>
    </div>

    
    <div class="as-stats anim" style="animation-delay:.06s;">
        <div class="as-stat">
            <div class="label">Total Attempts</div>
            <div class="value"><?php echo e($totalAttempts); ?></div>
        </div>
        <div class="as-stat">
            <div class="label">Passed</div>
            <div class="value pass"><?php echo e($passed); ?></div>
        </div>
        <div class="as-stat">
            <div class="label">Failed</div>
            <div class="value" style="color:var(--fail);"><?php echo e($totalAttempts - $passed); ?></div>
        </div>
        <div class="as-stat">
            <div class="label">Avg Score</div>
            <div class="value warn"><?php echo e($avgScore !== null ? $avgScore . '%' : '—'); ?></div>
        </div>
        <div class="as-stat">
            <div class="label">Total XP</div>
            <div class="value" style="color:var(--accent);"><?php echo e(number_format($totalXp)); ?></div>
        </div>
        <div class="as-stat">
            <div class="label">In Progress</div>
            <div class="value" style="color:var(--warn);"><?php echo e($inProgress->count()); ?></div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inProgress->count()): ?>
    <div class="anim" style="animation-delay:.1s;">
        <div class="as-section-title">In Progress</div>
        <div class="as-card">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $inProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="upcoming-row">
                <div class="info">
                    <div class="title"><?php echo e($item['quiz_title']); ?></div>
                    <div class="meta"><?php echo e($item['module_title']); ?> &middot; Started <?php echo e($item['started_at']); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['time_limit']): ?> &middot; <?php echo e($item['time_limit']); ?>min limit <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['course_slug'] && $item['module_slug'] && $item['quiz_slug']): ?>
                <a href="<?php echo e(route('quizzes.start', [$item['course_slug'], $item['module_slug'], $item['quiz_slug']])); ?>"
                   class="btn-black no-print" style="font-size:.82rem;padding:.5rem 1rem;">Continue</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span class="badge prog">In Progress</span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="anim" style="animation-delay:.14s;">
        <div class="as-section-title">Completed Assessments</div>
        <div class="as-card" style="overflow-x:auto;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completedAttempts->count()): ?>
            <table class="as-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Quiz</th>
                        <th>Module</th>
                        <th>Score</th>
                        <th>Correct</th>
                        <th>Time</th>
                        <th>XP</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $completedAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td style="color:var(--muted);font-size:.8rem;"><?php echo e($i + 1); ?></td>
                        <td style="font-weight:600;"><?php echo e($a['quiz_title']); ?></td>
                        <td style="color:var(--sub);font-size:.85rem;"><?php echo e($a['module_title']); ?></td>
                        <td>
                            <div class="score-bar-wrap">
                                <div class="score-bar">
                                    <div class="score-bar-fill <?php echo e($a['passed'] ? 'pass' : 'fail'); ?>"
                                         style="width:<?php echo e(min($a['score'],100)); ?>%"></div>
                                </div>
                                <span class="score-pct <?php echo e($a['passed'] ? 'pass' : 'fail'); ?>"><?php echo e($a['score']); ?>%</span>
                            </div>
                        </td>
                        <td style="font-size:.85rem;"><?php echo e($a['correct']); ?>/<?php echo e($a['total']); ?></td>
                        <td style="font-size:.82rem;color:var(--muted);"><?php echo e($a['time_spent']); ?></td>
                        <td style="font-size:.85rem;font-weight:600;color:var(--accent);">+<?php echo e($a['xp']); ?></td>
                        <td><span class="badge <?php echo e($a['passed'] ? 'pass' : 'fail'); ?>">
                            <?php echo e($a['passed'] ? '✓ Passed' : '✗ Failed'); ?>

                        </span></td>
                        <td style="font-size:.8rem;color:var(--muted);white-space:nowrap;"><?php echo e($a['completed_at']); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="as-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                No completed assessments yet. Take a quiz to see your results here.
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="anim" style="animation-delay:.18s;">
        <div class="as-section-title">Available Quizzes</div>
        <div class="as-card">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcoming->count()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="upcoming-row">
                    <div class="info">
                        <div class="title"><?php echo e($q['quiz_title']); ?></div>
                        <div class="meta">
                            <?php echo e($q['module_title']); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($q['time_limit']): ?> &middot; <?php echo e($q['time_limit']); ?>min <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            &middot; Pass at <?php echo e($q['passing_score'] ?? 75); ?>%
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($q['attempt_limit']): ?> &middot; <?php echo e($q['attempt_limit']); ?> attempt(s) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($q['course_slug'] && $q['module_slug'] && $q['quiz_slug']): ?>
                    <a href="<?php echo e(route('quizzes.start', [$q['course_slug'], $q['module_slug'], $q['quiz_slug']])); ?>"
                       class="btn-black no-print" style="font-size:.82rem;padding:.5rem 1rem;">Start</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="badge blue">Not Taken</span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php else: ?>
            <div class="as-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                No new quizzes available right now. Enroll in a course to unlock assessments.
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\assessment\index.blade.php ENDPATH**/ ?>