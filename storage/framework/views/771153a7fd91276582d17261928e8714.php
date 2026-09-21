<?php $__env->startSection('title', 'Evaluate Teacher'); ?>
<?php $__env->startSection('page_title', 'Evaluate Teacher'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .eval-form { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --accent-hover:#2563eb;
               --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes popIn { from{opacity:0;transform:scale(.85)} to{opacity:1;transform:scale(1)} }
    @keyframes shake { 10%,90%{transform:translateX(-1px)} 20%,80%{transform:translateX(2px)} 30%,50%,70%{transform:translateX(-4px)} 40%,60%{transform:translateX(4px)} }
    @keyframes progressGrow { from{width:0} to{width:var(--p, 0%)} }
    .anim { opacity:0; animation:fadeUp .5s var(--ease) forwards; }

    /* ── Header ─────────────────────────────────────── */
    .ef-header { margin-bottom:1.25rem; border-radius:18px; padding:1.75rem 2rem; position:relative; overflow:hidden;
                 background:linear-gradient(135deg,#eff6ff 0%,#f5f3ff 100%); border:1px solid var(--line); }
    .ef-header::before { content:''; position:absolute; inset:0; background:radial-gradient(600px circle at 90% -20%, rgba(59,130,246,.12), transparent 60%); pointer-events:none; }
    .ef-header h2 { margin:0 0 .5rem; font-size:1.6rem; font-weight:800; color:var(--ink); letter-spacing:-0.02em; position:relative; }
    .ef-header p { margin:0; color:var(--sub); font-size:1rem; position:relative; }

    .ef-meta { background:#fff; border:1px solid var(--line); border-radius:12px; padding:1.25rem; display:flex; gap:2rem; margin-top:1.5rem;
               box-shadow:0 4px 14px -6px rgba(15,23,42,0.08); position:relative; }
    .ef-meta-item strong { display:block; font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem; }
    .ef-meta-item span { font-size:1.05rem; font-weight:700; color:var(--ink); }

    /* ── Sticky Progress Bar ─────────────────────────── */
    .ef-progress-wrap { position:sticky; top:0; z-index:20; background:rgba(248,250,252,.9); backdrop-filter:blur(6px);
                         padding:.85rem 0 1.25rem; margin-bottom:.5rem; }
    .ef-progress-label { display:flex; justify-content:space-between; font-size:.8rem; font-weight:600; color:var(--sub); margin-bottom:.5rem; }
    .ef-progress-label #ef-progress-count { color:var(--accent); font-weight:800; }
    .ef-progress-track { width:100%; height:7px; border-radius:999px; background:#e2e8f0; overflow:hidden; }
    .ef-progress-fill { height:100%; width:0%; border-radius:999px; background:linear-gradient(90deg,var(--accent),var(--accent-hover));
                         transition:width .35s var(--ease); }

    /* ── Section & Questions ────────────────────────── */
    .ef-section { background:#fff; border:1px solid var(--line); border-radius:16px; margin-bottom:1.5rem; overflow:hidden;
                  transition:box-shadow .25s ease, border-color .25s ease; }
    .ef-section:hover { box-shadow:0 6px 20px -10px rgba(15,23,42,0.1); }
    .ef-section-title { background:#f8fafc; padding:1rem 1.5rem; border-bottom:1px solid var(--line); font-weight:800; color:var(--ink); font-size:1.05rem;
                         display:flex; align-items:center; gap:.5rem; }
    .ef-section-title::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--accent); flex-shrink:0; }

    .ef-question { padding:1.5rem; border-bottom:1px solid var(--line); transition:background .2s ease; }
    .ef-question:last-child { border-bottom:none; }
    .ef-question.answered { background:#fafdff; }
    .ef-q-text { font-size:1rem; font-weight:600; color:var(--ink); margin:0 0 1rem; line-height:1.5; display:flex; align-items:center; gap:.5rem; }
    .ef-q-check { width:16px; height:16px; color:#16a34a; opacity:0; transform:scale(.6); transition:opacity .2s var(--ease), transform .2s var(--ease); }
    .ef-question.answered .ef-q-check { opacity:1; transform:scale(1); }

    /* ── Segmented Radio Buttons (1-5 Scale) ────────── */
    .ef-scale { display:flex; gap:.5rem; flex-wrap:wrap; }
    .ef-scale label { position:relative; cursor:pointer; flex:1; min-width:80px; }
    .ef-scale input { position:absolute; opacity:0; width:0; height:0; }
    .ef-scale .box { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:.75rem .5rem; background:#f8fafc; border:1px solid var(--line); border-radius:10px;
                      transition:background .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s var(--ease); text-align:center; }
    .ef-scale .val { font-size:1.2rem; font-weight:800; color:var(--ink); margin-bottom:.15rem; }
    .ef-scale .lbl { font-size:.65rem; font-weight:700; text-transform:uppercase; color:var(--muted); line-height:1.2; }

    .ef-scale label:hover .box { background:#f1f5f9; border-color:#cbd5e1; transform:translateY(-1px); }
    .ef-scale input:checked + .box { background:var(--ink); border-color:var(--ink); box-shadow:0 4px 12px -4px rgba(15,23,42,0.4); transform:translateY(-2px); animation:popIn .25s var(--ease); }
    .ef-scale input:checked + .box .val, .ef-scale input:checked + .box .lbl { color:#fff; }
    .ef-scale input:focus-visible + .box { outline:2px solid var(--accent); outline-offset:2px; }

    /* ── Textarea & Toggles ─────────────────────────── */
    .ef-textarea { width:100%; padding:1rem; border:1px solid var(--line); border-radius:12px; font-family:inherit; font-size:.95rem; color:var(--ink);
                   transition:border-color .15s ease, box-shadow .15s ease, background .15s ease; resize:vertical; background:#f8fafc; }
    .ef-textarea:focus { outline:none; border-color:var(--accent); background:#fff; box-shadow:0 0 0 3px rgba(59,130,246,0.1); }
    .ef-char-count { text-align:right; font-size:.75rem; color:var(--muted); margin-top:.4rem; transition:color .15s ease; }

    .ef-toggle { display:flex; align-items:center; gap:.75rem; cursor:pointer; font-size:.95rem; font-weight:600; color:var(--ink); user-select:none; }
    .ef-toggle input { width:18px; height:18px; accent-color:var(--ink); cursor:pointer; }

    /* ── Actions ────────────────────────────────────── */
    .ef-actions { display:flex; justify-content:flex-end; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--line); align-items:center; }
    .btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:10px; font-size:.95rem; font-weight:600; cursor:pointer;
           transition:transform .15s var(--ease), background .15s ease, border-color .15s ease, box-shadow .15s ease; text-decoration:none; border:1px solid transparent; }
    .btn-submit { background:var(--ink); color:#fff; }
    .btn-submit:hover { background:#1e293b; transform:translateY(-2px); box-shadow:0 6px 16px -6px rgba(15,23,42,.45); }
    .btn-submit:active { transform:translateY(0); }
    .btn-cancel { background:#fff; border-color:var(--line); color:var(--ink); }
    .btn-cancel:hover { background:#f8fafc; border-color:#cbd5e1; transform:translateY(-2px); }

    .error-msg { color:#dc2626; font-size:.85rem; font-weight:600; margin-top:.65rem; display:flex; align-items:center; gap:.35rem;
                 animation:shake .4s var(--ease); }
    .error-msg svg { width:14px; height:14px; flex-shrink:0; }

    @media (prefers-reduced-motion: reduce) {
        .anim, .ef-scale input:checked + .box, .error-msg, .ef-q-check { animation:none !important; opacity:1 !important; transform:none !important; }
    }
</style>

<div class="eval-form">

    <div class="ef-header anim" style="animation-delay:.02s;">
        <h2>Evaluate Teacher</h2>
        <p>Your honest feedback is strictly confidential and helps improve academic quality.</p>

        <div class="ef-meta">
            <div class="ef-meta-item">
                <strong>Course</strong>
                <span><?php echo e($course->title); ?></span>
            </div>
            <div class="ef-meta-item">
                <strong>Instructor</strong>
                <span>Prof. <?php echo e($course->instructor->name ?? 'TBA'); ?></span>
            </div>
        </div>
    </div>

    <?php
        $totalScaleQuestions = collect($questions)->sum(fn($section) => count($section['items']));
    ?>

    <div class="ef-progress-wrap anim" style="animation-delay:.03s;">
        <div class="ef-progress-label">
            <span><span id="ef-progress-count">0</span> of <?php echo e($totalScaleQuestions); ?> answered</span>
            <span id="ef-progress-pct">0%</span>
        </div>
        <div class="ef-progress-track">
            <div class="ef-progress-fill" id="ef-progress-fill"></div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('sias.student.teacher_evaluation.store', $enrollment)); ?>" id="ef-form">
        <?php echo csrf_field(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIdx => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="ef-section anim" style="animation-delay:<?php echo e(0.05 + ($sIdx * 0.03)); ?>s;">
                <div class="ef-section-title"><?php echo e($section['title']); ?></div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $isAnswered = old('responses.' . $item['id']) !== null; ?>
                    <div class="ef-question<?php echo e($isAnswered ? ' answered' : ''); ?>" data-ef-question>
                        <h4 class="ef-q-text">
                            <?php echo e($item['label']); ?>

                            <svg class="ef-q-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </h4>

                        <div class="ef-scale">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [1,2,3,4,5]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $lbl = match($value) {
                                        5 => 'Outstanding', 4 => 'Very Satisfy', 3 => 'Satisfactory', 2 => 'Fair', default => 'Poor'
                                    };
                                ?>
                                <label>
                                    <input type="radio" name="responses[<?php echo e($item['id']); ?>]" value="<?php echo e($value); ?>" <?php echo e(old('responses.' . $item['id']) == $value ? 'checked' : ''); ?> required data-ef-radio>
                                    <div class="box">
                                        <span class="val"><?php echo e($value); ?></span>
                                        <span class="lbl"><?php echo e($lbl); ?></span>
                                    </div>
                                </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['responses.' . $item['id']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="error-msg">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                Please select a rating for this question.
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <div class="ef-section anim" style="animation-delay:0.15s;">
            <div class="ef-section-title">Additional Comments</div>
            <div class="ef-question" style="border-bottom:none;">
                <p style="margin:0 0 1rem; color:var(--sub); font-size:.95rem;">Please share any specific strengths, weaknesses, or suggestions for the instructor.</p>
                <textarea name="comments" rows="5" class="ef-textarea" placeholder="Write your feedback here..." maxlength="2000" id="ef-comments"><?php echo e(old('comments')); ?></textarea>
                <div class="ef-char-count"><span id="ef-char-current"><?php echo e(strlen(old('comments', ''))); ?></span> / 2000</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-msg">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="ef-actions anim" style="animation-delay:0.2s;">
            <label class="ef-toggle" style="margin-right:auto;">
                <input type="checkbox" name="anonymous" value="1" checked>
                Submit anonymously (hide my name)
            </label>

            <a href="<?php echo e(route('sias.student.teacher_evaluation')); ?>" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Submit Evaluation
            </button>
        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('ef-form');
    if (!form) return;

    var questions = form.querySelectorAll('[data-ef-question]');
    var total = questions.length;
    var countEl = document.getElementById('ef-progress-count');
    var pctEl = document.getElementById('ef-progress-pct');
    var fillEl = document.getElementById('ef-progress-fill');

    function updateProgress() {
        var answered = 0;
        questions.forEach(function (q) {
            var checked = q.querySelector('input[data-ef-radio]:checked');
            q.classList.toggle('answered', !!checked);
            if (checked) answered++;
        });
        var pct = total > 0 ? Math.round((answered / total) * 100) : 0;
        if (countEl) countEl.textContent = answered;
        if (pctEl) pctEl.textContent = pct + '%';
        if (fillEl) fillEl.style.width = pct + '%';
    }

    form.addEventListener('change', function (e) {
        if (e.target && e.target.matches('input[data-ef-radio]')) {
            updateProgress();
        }
    });

    updateProgress();

    var textarea = document.getElementById('ef-comments');
    var charCurrent = document.getElementById('ef-char-current');
    if (textarea && charCurrent) {
        textarea.addEventListener('input', function () {
            charCurrent.textContent = textarea.value.length;
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\teacher_evaluation\form.blade.php ENDPATH**/ ?>