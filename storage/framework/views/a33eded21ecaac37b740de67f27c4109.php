<?php $__env->startSection('title', 'Teacher Evaluation Review'); ?>
<?php $__env->startSection('page_title', 'Teacher Evaluation Review'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .eval-show { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --accent-dark:#2563eb; --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes popIn { from{opacity:0;transform:scale(.85)} to{opacity:1;transform:scale(1)} }
    @keyframes fillBar { from{width:0} to{width:var(--fill, 0%)} }
    .anim { opacity:0; animation:fadeUp .5s var(--ease) forwards; }

    /* ── Header ─────────────────────────────────────── */
    .es-header { margin-bottom:2rem; border-radius:18px; padding:1.75rem 2rem; position:relative; overflow:hidden;
                 background:linear-gradient(135deg,#eff6ff 0%,#f5f3ff 100%); border:1px solid var(--line); }
    .es-header::before { content:''; position:absolute; inset:0; background:radial-gradient(600px circle at 90% -20%, rgba(59,130,246,.12), transparent 60%); pointer-events:none; }
    .es-header h2 { margin:0 0 .5rem; font-size:1.6rem; font-weight:800; color:var(--ink); letter-spacing:-0.02em; display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; }
    .es-header p { margin:0; color:var(--sub); font-size:1rem; position:relative; }
    .status-badge { display:inline-flex; align-items:center; gap:.35rem; padding:.3rem .8rem; border-radius:999px; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em;
                     background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; vertical-align:middle; animation:popIn .4s var(--ease) .1s both; }
    .status-badge svg { animation:popIn .5s var(--ease) .3s both; }

    .es-meta { background:#fff; border:1px solid var(--line); border-radius:12px; padding:1.25rem; display:flex; flex-wrap:wrap; gap:2rem; margin-top:1.5rem;
               box-shadow:0 4px 14px -6px rgba(15,23,42,0.08); position:relative; transition:box-shadow .25s ease; }
    .es-meta:hover { box-shadow:0 8px 22px -6px rgba(15,23,42,0.12); }
    .es-meta-item strong { display:block; font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem; }
    .es-meta-item span { font-size:1.05rem; font-weight:700; color:var(--ink); }

    .es-stars { display:inline-flex; gap:2px; vertical-align:middle; margin-left:.5rem; }
    .es-stars svg { width:15px; height:15px; opacity:0; animation:popIn .35s var(--ease) forwards; }
    .es-stars svg:nth-child(1){animation-delay:.15s} .es-stars svg:nth-child(2){animation-delay:.22s}
    .es-stars svg:nth-child(3){animation-delay:.29s} .es-stars svg:nth-child(4){animation-delay:.36s}
    .es-stars svg:nth-child(5){animation-delay:.43s}

    /* ── Section & Questions ────────────────────────── */
    .es-section { background:#fff; border:1px solid var(--line); border-radius:16px; margin-bottom:1.5rem; overflow:hidden;
                  transition:box-shadow .25s ease, border-color .25s ease; }
    .es-section:hover { box-shadow:0 6px 20px -10px rgba(15,23,42,0.12); }
    .es-section-title { background:#f8fafc; padding:1rem 1.5rem; border-bottom:1px solid var(--line); font-weight:800; color:var(--ink); font-size:1.05rem;
                         display:flex; align-items:center; gap:.5rem; }
    .es-section-title::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--accent); flex-shrink:0; }

    .es-question { padding:1.25rem 1.5rem; border-bottom:1px solid var(--line); display:flex; justify-content:space-between; align-items:center; gap:2rem;
                   transition:background .2s ease; }
    .es-question:hover { background:#fafbff; }
    .es-question:last-child { border-bottom:none; }
    .es-q-text { flex:1; font-size:1rem; font-weight:600; color:var(--ink); margin:0; line-height:1.5; }

    /* ── Answer Display ─────────────────────────────── */
    .es-ans { display:flex; align-items:center; gap:.85rem; flex-shrink:0; background:#f8fafc; padding:.5rem 1rem; border-radius:10px; border:1px solid var(--line); min-width:190px; }
    .es-ans .val { font-size:1.25rem; font-weight:800; color:var(--ink); min-width:1.2ch; text-align:center; }
    .es-ans .lbl-wrap { display:flex; flex-direction:column; gap:.3rem; border-left:1px solid #cbd5e1; padding-left:.75rem; flex:1; }
    .es-ans .lbl { font-size:.75rem; font-weight:600; color:var(--sub); text-transform:uppercase; letter-spacing:.05em; }
    .es-ans .bar-track { width:100%; height:5px; border-radius:999px; background:#e2e8f0; overflow:hidden; }
    .es-ans .bar-fill { height:100%; border-radius:999px; width:0; animation:fillBar .7s var(--ease) .1s forwards;
                         background:linear-gradient(90deg,var(--accent),var(--accent-dark)); }
    .es-ans.rating-1 .bar-fill, .es-ans.rating-2 .bar-fill { background:linear-gradient(90deg,#f87171,#ef4444); }
    .es-ans.rating-3 .bar-fill { background:linear-gradient(90deg,#fbbf24,#f59e0b); }
    .es-ans.rating-na { opacity:.6; }

    /* ── Textarea Display ───────────────────────────── */
    .es-comment { padding:1.5rem; background:#fff; font-size:.95rem; color:var(--ink); line-height:1.7; white-space:pre-line; }
    .es-comment.empty { color:var(--muted); font-style:italic; }

    /* ── Actions ────────────────────────────────────── */
    .es-actions { display:flex; justify-content:flex-end; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--line); }
    .btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:10px; font-size:.95rem; font-weight:600; cursor:pointer;
           transition:transform .15s var(--ease), background .15s ease, border-color .15s ease, box-shadow .15s ease; text-decoration:none; border:1px solid transparent; }
    .btn-secondary { background:#fff; border-color:var(--line); color:var(--ink); }
    .btn-secondary:hover { background:#f8fafc; border-color:#cbd5e1; transform:translateY(-2px); box-shadow:0 6px 16px -8px rgba(15,23,42,0.18); }
    .btn-secondary:active { transform:translateY(0); }
    .btn-secondary svg { transition:transform .2s ease; }
    .btn-secondary:hover svg { transform:translateX(-3px); }

    @media (prefers-reduced-motion: reduce) {
        .anim, .status-badge, .status-badge svg, .es-stars svg, .es-ans .bar-fill { animation:none !important; opacity:1 !important; }
    }
</style>

<div class="eval-show">

    <div class="es-header anim" style="animation-delay:.02s;">
        <h2>
            Evaluation Review
            <span class="status-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;"><polyline points="20 6 9 17 4 12"/></svg> Submitted</span>
        </h2>
        <p>Review the answers you provided for this course's teacher evaluation.</p>

        <div class="es-meta">
            <div class="es-meta-item">
                <strong>Course</strong>
                <span><?php echo e($course->title); ?></span>
            </div>
            <div class="es-meta-item">
                <strong>Instructor</strong>
                <span>Prof. <?php echo e($course->instructor->name ?? 'TBA'); ?></span>
            </div>
            <div class="es-meta-item">
                <strong>Anonymity</strong>
                <span><?php echo e($evaluation->anonymous ? 'Yes, submitted anonymously' : 'No, name included'); ?></span>
            </div>
            <div class="es-meta-item">
                <strong>Overall Rating</strong>
                <span style="color:var(--accent); display:inline-flex; align-items:center;">
                    <?php echo e($evaluation->rating); ?> / 5
                    <span class="es-stars">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg viewBox="0 0 24 24" fill="<?php echo e($i <= round($evaluation->rating) ? '#3b82f6' : 'none'); ?>" stroke="<?php echo e($i <= round($evaluation->rating) ? '#3b82f6' : '#cbd5e1'); ?>" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </span>
                </span>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIdx => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="es-section anim" style="animation-delay:<?php echo e(0.05 + ($sIdx * 0.04)); ?>s;">
            <div class="es-section-title"><?php echo e($section['title']); ?></div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="es-question">
                    <p class="es-q-text"><?php echo e($item['label']); ?></p>

                    <?php
                        $value = $evaluation->responses[$item['id']] ?? null;
                        $lbl = match($value) {
                            5 => 'Outstanding', 4 => 'Very Satisfy', 3 => 'Satisfactory', 2 => 'Fair', 1 => 'Poor', default => 'N/A'
                        };
                        $ratingClass = match($value) {
                            5, 4 => '', 3 => 'rating-3', 2, 1 => 'rating-1', default => 'rating-na'
                        };
                        $fillPct = $value ? ($value / 5) * 100 : 0;
                    ?>
                    <div class="es-ans <?php echo e($ratingClass); ?>">
                        <span class="val"><?php echo e($value ?? '-'); ?></span>
                        <span class="lbl-wrap">
                            <span class="lbl"><?php echo e($lbl); ?></span>
                            <span class="bar-track">
                                <span class="bar-fill" style="--fill: <?php echo e($fillPct); ?>%;"></span>
                            </span>
                        </span>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    <div class="es-section anim" style="animation-delay:0.2s;">
        <div class="es-section-title">Additional Comments</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($evaluation->comments): ?>
            <div class="es-comment"><?php echo e($evaluation->comments); ?></div>
        <?php else: ?>
            <div class="es-comment empty">No comments provided.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="es-actions anim" style="animation-delay:0.25s;">
        <a href="<?php echo e(route('sias.student.teacher_evaluation')); ?>" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Evaluations
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\teacher_evaluation\show.blade.php ENDPATH**/ ?>