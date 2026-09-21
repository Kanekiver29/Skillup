<?php $__env->startSection('title', 'Teacher Evaluation'); ?>
<?php $__env->startSection('page_title', 'Teacher Evaluation'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .eval-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --accent-dark:#2563eb; --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes popIn { from{opacity:0;transform:scale(.85)} to{opacity:1;transform:scale(1)} }
    @keyframes slideIn { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }
    @keyframes pulseSoft { 0%,100%{opacity:1} 50%{opacity:.55} }
    .anim { opacity:0; animation:fadeUp .5s var(--ease) forwards; }

    /* ── Header ─────────────────────────────────────── */
    .eval-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;
                   padding:1.5rem 1.75rem; border-radius:16px; position:relative; overflow:hidden;
                   background:linear-gradient(135deg,#eff6ff 0%,#f5f3ff 100%); border:1px solid var(--line); }
    .eval-header::before { content:''; position:absolute; inset:0; background:radial-gradient(560px circle at 92% -30%, rgba(59,130,246,.14), transparent 60%); pointer-events:none; }
    .eval-header .title { margin:0; font-size:1.4rem; font-weight:800; color:var(--ink); letter-spacing:-0.02em; position:relative; }
    .eval-header .desc { margin:.25rem 0 0; color:var(--sub); font-size:.95rem; position:relative; }

    /* ── Alerts ─────────────────────────────────────── */
    .alert { padding:1rem 1.25rem; border-radius:12px; font-size:.95rem; margin-bottom:1.5rem; display:flex; gap:.75rem; align-items:flex-start;
             animation:slideIn .4s var(--ease) forwards; }
    .alert svg { width:20px; height:20px; flex-shrink:0; margin-top:.1rem; }
    .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .alert-info { background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; }

    /* ── Callout Card ───────────────────────────────── */
    .callout { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.5rem; display:flex; gap:1.25rem; margin-bottom:2rem;
               box-shadow:0 4px 12px -8px rgba(15,23,42,0.05); transition:box-shadow .25s ease, border-color .25s ease; }
    .callout:hover { box-shadow:0 8px 20px -8px rgba(15,23,42,0.1); border-color:#dbe2ea; }
    .callout-icon { width:48px; height:48px; border-radius:12px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--accent);
                     animation:popIn .5s var(--ease) .1s both; }
    .callout-icon svg { width:24px; height:24px; }
    .callout-content h3 { margin:0 0 .5rem; font-size:1.05rem; font-weight:700; color:var(--ink); }
    .callout-content p { margin:0; font-size:.95rem; color:var(--sub); line-height:1.6; }
    .callout-content ul { margin:.75rem 0 0; padding-left:1.25rem; color:var(--sub); font-size:.95rem; }
    .callout-content li { margin-bottom:.35rem; opacity:0; animation:fadeUp .4s var(--ease) forwards; }
    .callout-content li:nth-child(1){animation-delay:.2s} .callout-content li:nth-child(2){animation-delay:.28s} .callout-content li:nth-child(3){animation-delay:.36s}

    .courses-heading { margin:2.5rem 0 1.25rem; font-size:1.15rem; font-weight:800; color:var(--ink); }

    /* ── Course Grid ────────────────────────────────── */
    .course-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:1.25rem; }
    .course-card { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.25rem;
        transition:border-color .2s ease, box-shadow .2s ease, transform .2s ease; display:flex; flex-direction:column; }
    .course-card:hover { border-color:#cbd5e1; box-shadow:0 10px 24px -12px rgba(15,23,42,.15); transform:translateY(-3px); }

    .course-card .badge { display:inline-flex; align-items:center; padding:.25rem .75rem; border-radius:999px; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-bottom:1rem; align-self:flex-start; }
    .badge-pending { background:#fffbeb; color:#b45309; border:1px solid #fde68a; }
    .badge-pending::before { content:''; display:inline-block; width:6px; height:6px; border-radius:50%; background:#f59e0b; margin-right:.4rem; animation:pulseSoft 1.6s ease-in-out infinite; }
    .badge-done { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }

    .course-card h4 { margin:0 0 .35rem; font-size:1.1rem; font-weight:700; color:var(--ink); line-height:1.3; }
    .course-card .prof { font-size:.9rem; color:var(--sub); display:flex; align-items:center; gap:.4rem; margin-bottom:1.5rem; }
    .course-card .prof svg { width:16px; height:16px; opacity:.6; }

    .course-card .actions { margin-top:auto; display:flex; justify-content:space-between; align-items:center; padding-top:1.25rem; border-top:1px solid var(--line); }
    .course-card .status-text { font-size:.85rem; font-weight:600; color:var(--muted); }
    .course-card .status-text.done { color:#15803d; }

    .btn-action { display:inline-flex; align-items:center; gap:.4rem; padding:.55rem 1.1rem; border-radius:8px; font-size:.85rem; font-weight:600; text-decoration:none;
                  transition:transform .15s var(--ease), background .15s ease, border-color .15s ease, box-shadow .15s ease; border:1px solid transparent; }
    .btn-action.primary { background:var(--ink); color:#fff; }
    .btn-action.primary:hover { background:#1e293b; transform:translateY(-2px); box-shadow:0 6px 14px -6px rgba(15,23,42,.45); }
    .btn-action.primary:active { transform:translateY(0); }
    .btn-action.secondary { background:#fff; border-color:var(--line); color:var(--ink); }
    .btn-action.secondary:hover { background:#f8fafc; border-color:#cbd5e1; transform:translateY(-2px); }

    /* ── Empty State ────────────────────────────────── */
    .empty-state { padding:4rem 1rem; text-align:center; color:var(--muted); font-size:.95rem; background:#fff; border:1px dashed var(--line); border-radius:16px; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 1rem; opacity:.3; display:block; animation:fadeUp .6s var(--ease) both; }

    @media (prefers-reduced-motion: reduce) {
        .anim, .alert, .callout-icon, .callout-content li, .badge-pending::before, .empty-state svg { animation:none !important; opacity:1 !important; }
    }
</style>

<div class="eval-page">

    <div class="eval-header anim" style="animation-delay:.02s;">
        <div>
            <h2 class="title">Teacher Evaluation</h2>
            <p class="desc">Help us improve instruction by rating your teachers and sharing your feedback.</p>
        </div>

        <?php
            $firstPending = $enrollments->first(function ($enrollment) use ($completedEnrollmentIds) {
                return !in_array($enrollment->id, $completedEnrollmentIds);
            });
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstPending): ?>
            <a href="<?php echo e(route('sias.student.teacher_evaluation.create', $firstPending)); ?>" class="btn-action primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Evaluate Next Class
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success" style="animation-delay:.04s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
        <div class="alert alert-info" style="animation-delay:.04s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <?php echo e(session('info')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="callout anim" style="animation-delay:.06s;">
        <div class="callout-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </div>
        <div class="callout-content">
            <h3>Why your voice matters</h3>
            <p>Your honest, constructive feedback directly helps instructors refine their teaching methods and improves the overall learning experience for future students. When evaluating, please consider:</p>
            <ul>
                <li><strong>Clarity & Delivery:</strong> Were concepts explained clearly?</li>
                <li><strong>Engagement:</strong> Did the instructor foster a supportive environment?</li>
                <li><strong>Responsiveness:</strong> Was the instructor available and helpful?</li>
            </ul>
        </div>
    </div>

    <h3 class="courses-heading anim" style="animation-delay:.08s;">
        Your Courses
    </h3>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isEmpty()): ?>
        <div class="empty-state anim" style="animation-delay:.1s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            No enrolled courses found. Complete enrollment to evaluate your teachers.
        </div>
    <?php else: ?>
        <div class="course-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $isDone = in_array($enrollment->id, $completedEnrollmentIds);
                    $delay = 0.1 + ($index * 0.04);
                ?>
                <div class="course-card anim" style="animation-delay:<?php echo e($delay); ?>s;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDone): ?>
                        <span class="badge badge-done">Completed</span>
                    <?php else: ?>
                        <span class="badge badge-pending">Pending</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <h4><?php echo e($enrollment->course->title ?? 'Untitled Course'); ?></h4>
                    <div class="prof">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Prof. <?php echo e($enrollment->course->instructor->name ?? $enrollment->course->instructor_name ?? 'TBA'); ?>

                    </div>

                    <div class="actions">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDone): ?>
                            <span class="status-text done">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;display:inline-block;margin-right:.25rem;vertical-align:-2px;"><polyline points="20 6 9 17 4 12"/></svg>
                                Submitted
                            </span>
                            <a href="<?php echo e(route('sias.student.teacher_evaluation.show', $enrollment)); ?>" class="btn-action secondary">Review Answers</a>
                        <?php else: ?>
                            <span class="status-text">Awaiting evaluation</span>
                            <a href="<?php echo e(route('sias.student.teacher_evaluation.create', $enrollment)); ?>" class="btn-action primary">Evaluate</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\teacher_evaluation\index.blade.php ENDPATH**/ ?>