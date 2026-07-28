
<?php $__env->startSection('title','Staff Reports'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --ink:       #0d1117;
        --surface:   #ffffff;
        --muted:     #6b7280;
        --border:    #e5e7eb;
        --accent:    #0ea5e9;
        --accent-2:  #06b6d4;
        --accent-bg: #f0f9ff;
        --success:   #10b981;
        --warning:   #f59e0b;
        --danger:    #ef4444;
        --radius:    12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
        --shadow-lg: 0 12px 40px rgba(0,0,0,.10), 0 4px 12px rgba(0,0,0,.06);
    }

    /* ── Base ─────────────────────────────── */
    .rp-wrap * { box-sizing: border-box; }
    .rp-wrap {
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Page Header ──────────────────────── */
    .rp-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2.5rem;
        animation: slideDown .5s cubic-bezier(.16,1,.3,1) both;
    }
    .rp-header__title {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1;
        margin: 0 0 .35rem;
    }
    .rp-header__sub {
        color: var(--muted);
        font-size: .85rem;
        margin: 0;
    }
    .rp-header__actions { display: flex; gap: .6rem; flex-shrink: 0; }

    /* ── Buttons ──────────────────────────── */
    .rp-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.1rem;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all .18s ease;
        text-decoration: none;
        border: 1.5px solid transparent;
        white-space: nowrap;
    }
    .rp-btn--primary {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        box-shadow: 0 2px 8px rgba(14,165,233,.3);
    }
    .rp-btn--primary:hover {
        background: #0284c7;
        box-shadow: 0 4px 14px rgba(14,165,233,.4);
        transform: translateY(-1px);
    }
    .rp-btn--outline {
        background: transparent;
        color: var(--ink);
        border-color: var(--border);
    }
    .rp-btn--outline:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: var(--accent-bg);
    }

    /* ── Card ─────────────────────────────── */
    .rp-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        animation: fadeUp .5s .08s cubic-bezier(.16,1,.3,1) both;
    }

    /* ── Tab Nav ──────────────────────────── */
    .rp-tabs {
        display: flex;
        gap: 0;
        padding: 1rem 1rem 0;
        border-bottom: 1px solid var(--border);
        overflow-x: auto;
        scrollbar-width: none;
    }
    .rp-tabs::-webkit-scrollbar { display: none; }
    .rp-tab {
        position: relative;
        padding: .7rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        color: var(--muted);
        background: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: color .2s ease;
        outline: none;
    }
    .rp-tab::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        height: 2px;
        background: var(--accent);
        border-radius: 2px 2px 0 0;
        transform: scaleX(0);
        transition: transform .22s cubic-bezier(.34,1.56,.64,1);
    }
    .rp-tab:hover { color: var(--ink); }
    .rp-tab.is-active { color: var(--accent); font-weight: 600; }
    .rp-tab.is-active::after { transform: scaleX(1); }

    /* ── Tab Panels ───────────────────────── */
    .rp-panels { padding: 1.75rem; }
    .rp-panel {
        display: none;
        animation: panelIn .35s cubic-bezier(.16,1,.3,1) both;
    }
    .rp-panel.is-active { display: block; }

    /* ── Stat Grid ────────────────────────── */
    .rp-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .rp-stat {
        background: var(--accent-bg);
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 1.1rem 1.25rem;
        position: relative;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .rp-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .rp-stat::before {
        content: '';
        position: absolute;
        top: -20px; right: -20px;
        width: 70px; height: 70px;
        background: rgba(14,165,233,.1);
        border-radius: 50%;
    }
    .rp-stat--success { background: #f0fdf4; border-color: #bbf7d0; }
    .rp-stat--success::before { background: rgba(16,185,129,.1); }
    .rp-stat--warning { background: #fffbeb; border-color: #fde68a; }
    .rp-stat--warning::before { background: rgba(245,158,11,.1); }
    .rp-stat--danger  { background: #fef2f2; border-color: #fecaca; }
    .rp-stat--danger::before  { background: rgba(239,68,68,.1); }

    .rp-stat__label {
        font-size: .75rem;
        font-weight: 500;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .4rem;
    }
    .rp-stat__value {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        color: var(--ink);
    }
    .rp-stat__icon {
        position: absolute;
        top: 1rem; right: 1.1rem;
        font-size: 1.25rem;
        opacity: .45;
    }

    /* ── Section title ────────────────────── */
    .rp-section-title {
        font-family: 'Syne', sans-serif;
        font-size: .95rem;
        font-weight: 700;
        letter-spacing: -.01em;
        margin: 0 0 .75rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .rp-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Table ────────────────────────────── */
    .rp-table-wrap {
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }
    .rp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }
    .rp-table thead th {
        background: #f8fafc;
        padding: .6rem 1rem;
        text-align: left;
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
    }
    .rp-table tbody tr {
        transition: background .14s ease;
    }
    .rp-table tbody tr:hover { background: var(--accent-bg); }
    .rp-table tbody td {
        padding: .7rem 1rem;
        border-bottom: 1px solid var(--border);
        color: var(--ink);
    }
    .rp-table tbody tr:last-child td { border-bottom: none; }

    /* number cells */
    .rp-table td.num {
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        color: var(--accent);
    }

    /* ── Month list ───────────────────────── */
    .rp-month-list { list-style: none; padding: 0; margin: .5rem 0 0; }
    .rp-month-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .8rem;
        padding: .3rem 0;
        border-bottom: 1px solid var(--border);
        color: var(--muted);
    }
    .rp-month-list li:last-child { border-bottom: none; }
    .rp-month-list li strong {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        color: var(--ink);
        font-size: .88rem;
    }

    /* ── Info banner ──────────────────────── */
    .rp-info {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        padding: .9rem 1.1rem;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        margin-top: 1.25rem;
        font-size: .83rem;
        color: #0369a1;
    }
    .rp-info__icon { font-size: 1rem; flex-shrink: 0; margin-top: .05rem; }

    /* ── Progress bar ─────────────────────── */
    .rp-bar-wrap {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex: 1;
    }
    .rp-bar {
        flex: 1;
        height: 6px;
        background: var(--border);
        border-radius: 99px;
        overflow: hidden;
    }
    .rp-bar__fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent), var(--accent-2));
        border-radius: 99px;
        width: 0;
        transition: width .7s .2s cubic-bezier(.34,1.2,.64,1);
    }
    .rp-bar__pct {
        font-size: .72rem;
        font-weight: 600;
        color: var(--muted);
        width: 2.5rem;
        text-align: right;
    }

    /* ── Keyframes ────────────────────────── */
    @keyframes slideDown {
        from { opacity:0; transform: translateY(-18px); }
        to   { opacity:1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity:0; transform: translateY(14px); }
        to   { opacity:1; transform: translateY(0); }
    }
    @keyframes panelIn {
        from { opacity:0; transform: translateX(10px); }
        to   { opacity:1; transform: translateX(0); }
    }
    @keyframes countUp {
        from { opacity:0; transform: translateY(6px); }
        to   { opacity:1; transform: translateY(0); }
    }

    /* stat value entrance */
    .rp-stat__value { animation: countUp .4s ease both; }

    /* stagger stat cards */
    .rp-stats .rp-stat:nth-child(1) { animation-delay: .05s; }
    .rp-stats .rp-stat:nth-child(2) { animation-delay: .12s; }
    .rp-stats .rp-stat:nth-child(3) { animation-delay: .19s; }

    /* ── Responsive ───────────────────────── */
    @media(max-width: 640px) {
        .rp-wrap { padding: 1rem; }
        .rp-header { flex-direction: column; }
        .rp-header__actions { flex-wrap: wrap; }
        .rp-stat__value { font-size: 1.6rem; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="rp-wrap">

    
    <div class="rp-header">
        <div>
            <h1 class="rp-header__title">Reports</h1>
            <p class="rp-header__sub">Enrollment · Trainee · Assessment · Certificate · Trainer · Course · Financial · System</p>
        </div>
        <div class="rp-header__actions">
            <a href="<?php echo e(route('staff.enrollments.export')); ?>" class="rp-btn rp-btn--primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                Export CSV
            </a>
            <a href="<?php echo e(route('staff.settings.index')); ?>" class="rp-btn rp-btn--outline">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Settings
            </a>
        </div>
    </div>

    
    <div class="rp-card">

        
        <div class="rp-tabs" role="tablist" id="rp-tablist">
            <?php
                $tabs = [
                    'enrollments' => ['label'=>'Enrollments','icon'=>'📋'],
                    'trainees'    => ['label'=>'Trainees',   'icon'=>'👥'],
                    'assessments' => ['label'=>'Assessments','icon'=>'📝'],
                    'certificates'=> ['label'=>'Certificates','icon'=>'🏅'],
                    'trainers'    => ['label'=>'Trainers',   'icon'=>'🎓'],
                    'courses'     => ['label'=>'Courses',    'icon'=>'📚'],
                    'financial'   => ['label'=>'Financial',  'icon'=>'💰'],
                    'system'      => ['label'=>'System',     'icon'=>'⚙️'],
                ];
            ?>
            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    class="rp-tab<?php echo e($loop->first ? ' is-active' : ''); ?>"
                    role="tab"
                    data-target="<?php echo e($key); ?>"
                    aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                ><?php echo e($meta['label']); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="rp-panels">

            
            <div class="rp-panel is-active" id="panel-enrollments" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat">
                        <div class="rp-stat__icon">📋</div>
                        <div class="rp-stat__label">Total Enrollees</div>
                        <div class="rp-stat__value"><?php echo e($reports['total_enrollees'] ?? 0); ?></div>
                    </div>
                    <div class="rp-stat rp-stat--success">
                        <div class="rp-stat__icon">🆕</div>
                        <div class="rp-stat__label">New (Last 30 days)</div>
                        <div class="rp-stat__value"><?php echo e($reports['new_enrollees_30d'] ?? 0); ?></div>
                    </div>
                    <div class="rp-stat rp-stat--warning">
                        <div class="rp-stat__icon">📅</div>
                        <div class="rp-stat__label">Monthly Trend</div>
                        <div class="rp-stat__value" style="font-size:1.1rem;padding-top:.25rem">
                            <?php $months = $reports['enrollment_by_month'] ?? collect(); ?>
                            <ul class="rp-month-list">
                                <?php $__empty_1 = true; $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li><span><?php echo e($m->month); ?></span> <strong><?php echo e($m->total); ?></strong></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li style="justify-content:center;color:var(--muted)">No data</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <p class="rp-section-title">Enrollment by Course</p>
                <div class="rp-table-wrap">
                    <table class="rp-table">
                        <thead><tr><th>Course</th><th>Enrolled</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = ($reports['enrollment_by_course'] ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($c->title); ?></td>
                                    <td class="num"><?php echo e($c->enrollments_count ?? $c->count ?? 0); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="2" style="text-align:center;color:var(--muted);padding:1.5rem">No enrollment data available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-trainees" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat rp-stat--success">
                        <div class="rp-stat__icon">✅</div>
                        <div class="rp-stat__label">Active Trainees</div>
                        <div class="rp-stat__value"><?php echo e($reports['active_trainees'] ?? 0); ?></div>
                    </div>
                    <div class="rp-stat">
                        <div class="rp-stat__icon">🎯</div>
                        <div class="rp-stat__label">Completed</div>
                        <div class="rp-stat__value"><?php echo e($reports['completed_trainees'] ?? 0); ?></div>
                    </div>
                    <div class="rp-stat rp-stat--danger">
                        <div class="rp-stat__icon">⛔</div>
                        <div class="rp-stat__label">Dropped</div>
                        <div class="rp-stat__value"><?php echo e($reports['dropped_trainees'] ?? 0); ?></div>
                    </div>
                </div>

                <p class="rp-section-title">Attendance (Recent)</p>
                <div class="rp-table-wrap">
                    <table class="rp-table">
                        <thead><tr><th>Date</th><th>Present</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = ($reports['attendance_summary'] ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->date); ?></td>
                                    <td class="num"><?php echo e($r->present_count); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="2" style="text-align:center;color:var(--muted);padding:1.5rem">No attendance records found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-assessments" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat">
                        <div class="rp-stat__icon">📝</div>
                        <div class="rp-stat__label">Total Assessments</div>
                        <div class="rp-stat__value"><?php echo e($reports['assessments_total'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="rp-info">
                    <span class="rp-info__icon">ℹ️</span>
                    <span>Detailed assessment results and pass/fail breakdowns are available once the assessments module is integrated.</span>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-certificates" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat rp-stat--success">
                        <div class="rp-stat__icon">🏅</div>
                        <div class="rp-stat__label">Issued</div>
                        <div class="rp-stat__value"><?php echo e($reports['certificates_issued'] ?? 0); ?></div>
                    </div>
                    <div class="rp-stat rp-stat--warning">
                        <div class="rp-stat__icon">⏳</div>
                        <div class="rp-stat__label">Pending</div>
                        <div class="rp-stat__value"><?php echo e($reports['certificates_pending'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-trainers" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat">
                        <div class="rp-stat__icon">🎓</div>
                        <div class="rp-stat__label">Total Trainers</div>
                        <div class="rp-stat__value"><?php echo e($reports['trainers_count'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="rp-info">
                    <span class="rp-info__icon">ℹ️</span>
                    <span>Trainer performance metrics and attendance records require integration with the grading and attendance modules.</span>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-courses" role="tabpanel">
                <p class="rp-section-title">Course Completion (Top 10)</p>
                <div class="rp-table-wrap">
                    <table class="rp-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Completed</th>
                                <th>Enrolled</th>
                                <th style="min-width:140px">Completion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = ($reports['course_completion'] ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $pct = $c->total_enrolled > 0
                                        ? round(($c->completed_count / $c->total_enrolled) * 100)
                                        : 0;
                                ?>
                                <tr>
                                    <td><?php echo e($c->title); ?></td>
                                    <td class="num"><?php echo e($c->completed_count); ?></td>
                                    <td class="num" style="color:var(--muted)"><?php echo e($c->total_enrolled); ?></td>
                                    <td>
                                        <div class="rp-bar-wrap">
                                            <div class="rp-bar">
                                                <div class="rp-bar__fill" data-pct="<?php echo e($pct); ?>"></div>
                                            </div>
                                            <span class="rp-bar__pct"><?php echo e($pct); ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:1.5rem">No course data available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-financial" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat rp-stat--success">
                        <div class="rp-stat__icon">💰</div>
                        <div class="rp-stat__label">Training Fees Collected</div>
                        <div class="rp-stat__value" style="font-size:1.6rem">
                            ₱<?php echo e(number_format($reports['total_fees_collected'] ?? 0, 2)); ?>

                        </div>
                    </div>
                </div>
                <div class="rp-info">
                    <span class="rp-info__icon">ℹ️</span>
                    <span>Detailed payment reports and scholarship breakdowns are available once the payments module is integrated.</span>
                </div>
            </div>

            
            <div class="rp-panel" id="panel-system" role="tabpanel">
                <div class="rp-stats">
                    <div class="rp-stat">
                        <div class="rp-stat__icon">⚙️</div>
                        <div class="rp-stat__label">Login History Records</div>
                        <div class="rp-stat__value"><?php echo e($reports['login_history_count'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="rp-info">
                    <span class="rp-info__icon">ℹ️</span>
                    <span>Full audit trails and activity logs are available once an activity logging package is integrated.</span>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    /* ── Tab switching ── */
    const tablist  = document.getElementById('rp-tablist');
    const tabs     = tablist.querySelectorAll('.rp-tab');
    const panels   = document.querySelectorAll('.rp-panel');

    function activate(btn) {
        tabs.forEach(t => { t.classList.remove('is-active'); t.setAttribute('aria-selected','false'); });
        panels.forEach(p => p.classList.remove('is-active'));

        btn.classList.add('is-active');
        btn.setAttribute('aria-selected','true');

        const panel = document.getElementById('panel-' + btn.dataset.target);
        if (panel) {
            panel.classList.add('is-active');
            animateBars(panel);
        }
    }

    tabs.forEach(btn => btn.addEventListener('click', () => activate(btn)));

    /* ── Animate progress bars when panel becomes visible ── */
    function animateBars(panel) {
        panel.querySelectorAll('.rp-bar__fill').forEach(bar => {
            bar.style.width = '0';
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    bar.style.width = bar.dataset.pct + '%';
                });
            });
        });
    }

    /* init bars on first visible panel */
    const firstPanel = document.querySelector('.rp-panel.is-active');
    if (firstPanel) animateBars(firstPanel);

    /* ── Keyboard navigation ── */
    tablist.addEventListener('keydown', e => {
        const current = tablist.querySelector('.rp-tab.is-active');
        const all = [...tabs];
        const idx = all.indexOf(current);
        if (e.key === 'ArrowRight') { e.preventDefault(); activate(all[(idx + 1) % all.length]); }
        if (e.key === 'ArrowLeft')  { e.preventDefault(); activate(all[(idx - 1 + all.length) % all.length]); }
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/reports/staff.blade.php ENDPATH**/ ?>