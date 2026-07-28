
<?php $__env->startSection('title', 'Edit Enrollment'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ============================================================
       FUTURISTIC ENROLLMENT EDITOR — DESIGN SYSTEM
       ============================================================ */
    .em-fx {
        --fx-bg: #070a14;
        --fx-surface: rgba(18, 24, 42, 0.55);
        --fx-surface-solid: #0e1424;
        --fx-border: rgba(120, 170, 255, 0.16);
        --fx-border-strong: rgba(120, 190, 255, 0.4);
        --fx-primary: #5eead4;
        --fx-primary-2: #60a5fa;
        --fx-accent: #a78bfa;
        --fx-danger: #fb7185;
        --fx-warn: #fbbf24;
        --fx-success: #34d399;
        --fx-text: #eaf2ff;
        --fx-text-dim: #93a4c3;
        --fx-radius: 18px;
        position: relative;
        isolation: isolate;
        color: var(--fx-text);
    }

    /* Animated ambient background */
    .em-fx__bg {
        position: absolute;
        inset: -40px;
        z-index: -1;
        overflow: hidden;
        border-radius: 28px;
        background:
            radial-gradient(600px circle at 15% 10%, rgba(96, 165, 250, 0.18), transparent 60%),
            radial-gradient(500px circle at 85% 30%, rgba(167, 139, 250, 0.14), transparent 60%),
            radial-gradient(700px circle at 50% 100%, rgba(94, 234, 212, 0.10), transparent 60%),
            var(--fx-bg);
    }
    .em-fx__bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(120,170,255,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(120,170,255,0.06) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 20%, black 40%, transparent 90%);
        animation: fxGridDrift 22s linear infinite;
    }
    @keyframes fxGridDrift {
        0%   { transform: translate(0, 0); }
        100% { transform: translate(-42px, -42px); }
    }
    .em-fx__orb {
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.35;
        animation: fxOrbFloat 12s ease-in-out infinite;
    }
    .em-fx__orb--1 { background: var(--fx-primary-2); top: -60px; left: 5%; animation-delay: 0s; }
    .em-fx__orb--2 { background: var(--fx-accent); bottom: -80px; right: 8%; animation-delay: -4s; }
    .em-fx__orb--3 { background: var(--fx-primary); top: 40%; right: 30%; animation-delay: -8s; }
    @keyframes fxOrbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(20px, -30px) scale(1.08); }
    }

    @keyframes fxFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fxFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes fxScaleIn {
        from { opacity: 0; transform: scale(0.96); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes fxPulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(94, 234, 212, 0.35); }
        50%      { box-shadow: 0 0 0 6px rgba(94, 234, 212, 0); }
    }
    @keyframes fxShimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes fxSpin { to { transform: rotate(360deg); } }
    @keyframes fxDotBlink {
        0%, 100% { opacity: 1; }
        50%      { opacity: 0.25; }
    }

    /* Header */
    .em-fx__header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
        animation: fxFadeUp 0.5s ease both;
    }
    .em-fx__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--fx-primary);
        margin-bottom: 8px;
    }
    .em-fx__eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--fx-primary);
        box-shadow: 0 0 10px 2px rgba(94, 234, 212, 0.7);
        animation: fxDotBlink 1.8s ease-in-out infinite;
    }
    .em-fx__title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 0 0 4px;
        background: linear-gradient(90deg, #ffffff, #b9d6ff 60%, var(--fx-primary));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .em-fx__subtitle {
        margin: 0;
        color: var(--fx-text-dim);
        font-size: 14.5px;
    }
    .em-fx__actions { display: flex; gap: 10px; }

    /* Buttons */
    .em-fx-btn {
        --btn-glow: rgba(96, 165, 250, 0.35);
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.01em;
        cursor: pointer;
        border: 1px solid var(--fx-border);
        background: rgba(255,255,255,0.03);
        color: var(--fx-text);
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        overflow: hidden;
        white-space: nowrap;
    }
    .em-fx-btn:hover {
        transform: translateY(-2px);
        border-color: var(--fx-border-strong);
        box-shadow: 0 8px 24px -8px var(--btn-glow);
    }
    .em-fx-btn:active { transform: translateY(0); }
    .em-fx-btn--primary {
        background: linear-gradient(135deg, var(--fx-primary-2), var(--fx-accent));
        border-color: transparent;
        color: #06111f;
        box-shadow: 0 6px 20px -6px rgba(96, 165, 250, 0.5);
    }
    .em-fx-btn--primary:hover { box-shadow: 0 10px 30px -6px rgba(96, 165, 250, 0.65); }
    .em-fx-btn--primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .em-fx-btn--ghost { background: transparent; }
    .em-fx-btn__spinner {
        width: 14px; height: 14px;
        border-radius: 50%;
        border: 2px solid rgba(6,17,31,0.35);
        border-top-color: #06111f;
        animation: fxSpin 0.7s linear infinite;
        display: none;
    }
    .em-fx-btn--loading .em-fx-btn__spinner { display: inline-block; }
    .em-fx-btn--loading .em-fx-btn__label { opacity: 0.85; }

    /* Card */
    .em-fx__card {
        position: relative;
        max-width: 760px;
        border-radius: var(--fx-radius);
        padding: 28px;
        background: var(--fx-surface);
        border: 1px solid var(--fx-border);
        backdrop-filter: blur(18px) saturate(140%);
        -webkit-backdrop-filter: blur(18px) saturate(140%);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.05) inset,
            0 30px 60px -30px rgba(0,0,0,0.6);
        animation: fxFadeUp 0.6s 0.05s ease both;
        overflow: hidden;
    }
    .em-fx__card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--fx-primary), var(--fx-primary-2), var(--fx-accent), transparent);
        background-size: 200% 100%;
        animation: fxShimmer 5s linear infinite;
    }

    /* Progress / completion meter */
    .em-fx__progress-wrap {
        margin-bottom: 22px;
        animation: fxFadeUp 0.5s 0.1s ease both;
    }
    .em-fx__progress-top {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--fx-text-dim);
        margin-bottom: 7px;
        letter-spacing: 0.02em;
    }
    .em-fx__progress-top span:last-child { color: var(--fx-primary); font-weight: 700; }
    .em-fx__progress-track {
        height: 6px;
        border-radius: 999px;
        background: rgba(255,255,255,0.06);
        overflow: hidden;
        position: relative;
    }
    .em-fx__progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--fx-primary), var(--fx-primary-2), var(--fx-accent));
        width: 0%;
        transition: width 0.45s cubic-bezier(.4,0,.2,1);
        position: relative;
    }
    .em-fx__progress-fill::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        width: 40%;
        animation: fxShimmer 1.6s linear infinite;
    }

    /* Flash messages */
    .em-fx__flash {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 13.5px;
        margin-bottom: 18px;
        animation: fxScaleIn 0.3s ease both;
        border: 1px solid transparent;
    }
    .em-fx__flash--success {
        background: rgba(52, 211, 153, 0.1);
        border-color: rgba(52, 211, 153, 0.35);
        color: #bdf7e2;
    }
    .em-fx__flash--error {
        background: rgba(251, 113, 133, 0.1);
        border-color: rgba(251, 113, 133, 0.35);
        color: #ffd7dd;
    }
    .em-fx__flash ul { margin: 0; padding-left: 18px; }
    .em-fx__flash-icon { flex-shrink: 0; margin-top: 1px; }

    /* Fields */
    .em-fx__row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 560px) {
        .em-fx__row { grid-template-columns: 1fr; }
    }
    .em-fx__field {
        position: relative;
        margin-top: 16px;
        animation: fxFadeUp 0.45s ease both;
    }
    .em-fx__field:nth-of-type(1) { animation-delay: 0.08s; }
    .em-fx__field:nth-of-type(2) { animation-delay: 0.14s; }
    .em-fx__field:nth-of-type(3) { animation-delay: 0.2s; }

    .em-fx__label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        color: var(--fx-text-dim);
        margin-bottom: 8px;
        transition: color 0.2s ease;
    }

    .em-fx__control-wrap { position: relative; }
    .em-fx__input,
    .em-fx__select {
        width: 100%;
        appearance: none;
        -webkit-appearance: none;
        box-sizing: border-box;
        padding: 12px 14px;
        font-size: 14.5px;
        color: var(--fx-text);
        background: rgba(8, 12, 24, 0.55);
        border: 1px solid var(--fx-border);
        border-radius: 12px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .em-fx__select { padding-right: 38px; cursor: pointer; }
    .em-fx__input::placeholder { color: #5c6a8a; }
    .em-fx__input:hover,
    .em-fx__select:hover { border-color: var(--fx-border-strong); }
    .em-fx__input:focus,
    .em-fx__select:focus {
        border-color: var(--fx-primary-2);
        background: rgba(8, 12, 24, 0.85);
        box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.14), 0 0 20px -6px rgba(96, 165, 250, 0.4);
    }
    .em-fx__field:focus-within .em-fx__label { color: var(--fx-primary-2); }

    .em-fx__chevron {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 10px; height: 10px;
        border-right: 2px solid var(--fx-text-dim);
        border-bottom: 2px solid var(--fx-text-dim);
        transform: translateY(-65%) rotate(45deg);
        pointer-events: none;
        transition: border-color 0.2s ease;
    }
    .em-fx__field:focus-within .em-fx__chevron { border-color: var(--fx-primary-2); }

    .em-fx__hint {
        margin-top: 6px;
        font-size: 12.5px;
        display: flex;
        align-items: center;
        gap: 5px;
        animation: fxFadeIn 0.25s ease both;
    }
    .em-fx__hint--error { color: var(--fx-danger); }

    /* Status live preview pills */
    .em-fx__status-preview {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
    }
    .em-fx__pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        border: 1px solid var(--fx-border);
        color: var(--fx-text-dim);
        opacity: 0.5;
        transition: all 0.25s ease;
    }
    .em-fx__pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .em-fx__pill.is-active {
        opacity: 1;
        transform: translateY(-1px);
    }
    .em-fx__pill[data-status="active"].is-active   { color: var(--fx-success); border-color: rgba(52,211,153,0.5); background: rgba(52,211,153,0.08); box-shadow: 0 0 14px -4px rgba(52,211,153,0.6); }
    .em-fx__pill[data-status="pending"].is-active   { color: var(--fx-warn); border-color: rgba(251,191,36,0.5); background: rgba(251,191,36,0.08); box-shadow: 0 0 14px -4px rgba(251,191,36,0.6); }
    .em-fx__pill[data-status="dropped"].is-active   { color: var(--fx-danger); border-color: rgba(251,113,133,0.5); background: rgba(251,113,133,0.08); box-shadow: 0 0 14px -4px rgba(251,113,133,0.6); }
    .em-fx__pill[data-status="complete"].is-active  { color: var(--fx-primary-2); border-color: rgba(96,165,250,0.5); background: rgba(96,165,250,0.08); box-shadow: 0 0 14px -4px rgba(96,165,250,0.6); }

    /* Footer actions */
    .em-fx__footer {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 26px;
        padding-top: 18px;
        border-top: 1px solid var(--fx-border);
        animation: fxFadeUp 0.5s 0.25s ease both;
    }
    .em-fx__dirty-flag {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--fx-text-dim);
        opacity: 0;
        transform: translateY(4px);
        transition: opacity 0.25s ease, transform 0.25s ease;
    }
    .em-fx__dirty-flag.is-visible { opacity: 1; transform: translateY(0); }
    .em-fx__dirty-flag-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--fx-warn);
        animation: fxPulseGlow 1.6s ease-in-out infinite;
    }

    /* Toast (custom cancel confirmation) */
    .em-fx__toast-backdrop {
        position: fixed; inset: 0;
        background: rgba(4, 7, 15, 0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    .em-fx__toast-backdrop.is-open { opacity: 1; pointer-events: auto; }
    .em-fx__toast {
        width: 340px;
        max-width: 90vw;
        padding: 22px;
        border-radius: 16px;
        background: var(--fx-surface-solid);
        border: 1px solid var(--fx-border-strong);
        box-shadow: 0 30px 80px -20px rgba(0,0,0,0.7);
        transform: scale(0.92) translateY(10px);
        transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
        color: var(--fx-text);
    }
    .em-fx__toast-backdrop.is-open .em-fx__toast { transform: scale(1) translateY(0); }
    .em-fx__toast h3 { margin: 0 0 8px; font-size: 16px; }
    .em-fx__toast p { margin: 0 0 18px; font-size: 13.5px; color: var(--fx-text-dim); }
    .em-fx__toast-actions { display: flex; gap: 8px; justify-content: flex-end; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="em-page em-fx">
    <div class="em-fx__bg">
        <span class="em-fx__orb em-fx__orb--1"></span>
        <span class="em-fx__orb em-fx__orb--2"></span>
        <span class="em-fx__orb em-fx__orb--3"></span>
    </div>

    <div class="em-fx__header">
        <div>
            <div class="em-fx__eyebrow">
                <span class="em-fx__eyebrow-dot"></span>
                Staff Portal · Enrollment Systems
            </div>
            <h1 class="em-fx__title">Edit Enrollment</h1>
            <p class="em-fx__subtitle">Update enrollment details for the student.</p>
        </div>
        <div class="em-fx__actions">
            <a href="<?php echo e(route('staff.enrollments.index')); ?>" class="em-fx-btn em-fx-btn--ghost">
                ← Back
            </a>
            <a href="<?php echo e(route('staff.enrollments.show', $enrollment->id)); ?>" class="em-fx-btn">
                View Details
            </a>
        </div>
    </div>

    <div class="em-fx__card">

        <?php if(session('success')): ?>
            <div class="em-fx__flash em-fx__flash--success" role="alert">
                <span class="em-fx__flash-icon">✓</span>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="em-fx__flash em-fx__flash--error" role="alert">
                <span class="em-fx__flash-icon">⚠</span>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="em-fx__progress-wrap">
            <div class="em-fx__progress-top">
                <span>Form completion</span>
                <span id="fxProgressLabel">0%</span>
            </div>
            <div class="em-fx__progress-track">
                <div class="em-fx__progress-fill" id="fxProgressFill"></div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('staff.enrollments.update', $enrollment->id)); ?>" id="fxEnrollForm" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="em-fx__row">
                <div class="em-fx__field">
                    <label class="em-fx__label" for="year_level">Year Level</label>
                    <div class="em-fx__control-wrap">
                        <select id="year_level" name="year_level" class="em-fx__select" data-fx-field>
                            <option value="">Select…</option>
                            <?php for($i=1;$i<=6;$i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e((string)($enrollment->year_level ?? '') === (string)$i ? 'selected' : ''); ?>>Year <?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                        <span class="em-fx__chevron"></span>
                    </div>
                    <?php $__errorArgs = ['year_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="em-fx__hint em-fx__hint--error"><span>⚠</span><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="em-fx__field">
                    <label class="em-fx__label" for="section">Section</label>
                    <div class="em-fx__control-wrap">
                        <input id="section" name="section" class="em-fx__input" data-fx-field
                               value="<?php echo e(old('section', $enrollment->section ?? '')); ?>"
                               placeholder="e.g. A, B, Morning" autocomplete="off">
                    </div>
                    <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="em-fx__hint em-fx__hint--error"><span>⚠</span><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="em-fx__field">
                <label class="em-fx__label" for="status">Status</label>
                <div class="em-fx__control-wrap">
                    <select id="status" name="status" class="em-fx__select" data-fx-field>
                        <option value="active" <?php echo e(($enrollment->status ?? 'active') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="pending" <?php echo e(($enrollment->status ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="dropped" <?php echo e(($enrollment->status ?? '') === 'dropped' ? 'selected' : ''); ?>>Dropped</option>
                        <option value="complete" <?php echo e(($enrollment->status ?? '') === 'complete' ? 'selected' : ''); ?>>Completed</option>
                    </select>
                    <span class="em-fx__chevron"></span>
                </div>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="em-fx__hint em-fx__hint--error"><span>⚠</span><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="em-fx__status-preview" id="fxStatusPreview">
                    <span class="em-fx__pill" data-status="active"><span class="em-fx__pill-dot"></span>Active</span>
                    <span class="em-fx__pill" data-status="pending"><span class="em-fx__pill-dot"></span>Pending</span>
                    <span class="em-fx__pill" data-status="dropped"><span class="em-fx__pill-dot"></span>Dropped</span>
                    <span class="em-fx__pill" data-status="complete"><span class="em-fx__pill-dot"></span>Completed</span>
                </div>
            </div>

            <div class="em-fx__footer">
                <button type="submit" class="em-fx-btn em-fx-btn--primary" id="fxSubmitBtn">
                    <span class="em-fx-btn__spinner"></span>
                    <span class="em-fx-btn__label">Save changes</span>
                </button>
                <button type="button" id="cancelEditBtn" class="em-fx-btn em-fx-btn--ghost">Cancel</button>

                <div class="em-fx__dirty-flag" id="fxDirtyFlag">
                    <span class="em-fx__dirty-flag-dot"></span>
                    Unsaved changes
                </div>
            </div>
        </form>
    </div>
</div>

<div class="em-fx__toast-backdrop" id="fxToastBackdrop">
    <div class="em-fx__toast">
        <h3>Discard unsaved changes?</h3>
        <p>You have unsaved changes to this enrollment. Leaving now will discard them.</p>
        <div class="em-fx__toast-actions">
            <button type="button" class="em-fx-btn em-fx-btn--ghost" id="fxToastStay">Keep editing</button>
            <button type="button" class="em-fx-btn em-fx-btn--primary" id="fxToastLeave" style="background:linear-gradient(135deg,#fb7185,#f43f5e);">Discard &amp; leave</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('fxEnrollForm');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const submitBtn = document.getElementById('fxSubmitBtn');
    const dirtyFlag = document.getElementById('fxDirtyFlag');
    const progressFill = document.getElementById('fxProgressFill');
    const progressLabel = document.getElementById('fxProgressLabel');
    const statusSelect = document.getElementById('status');
    const statusPills = document.querySelectorAll('#fxStatusPreview .em-fx__pill');
    const toastBackdrop = document.getElementById('fxToastBackdrop');
    const toastStay = document.getElementById('fxToastStay');
    const toastLeave = document.getElementById('fxToastLeave');

    if (!form || !cancelBtn) return;

    const leaveUrl = '<?php echo e(route('staff.enrollments.index')); ?>';

    // ---- Snapshot / dirty tracking ----
    function snapshotForm(f) {
        const data = {};
        new FormData(f).forEach((v, k) => {
            if (data.hasOwnProperty(k)) {
                if (!Array.isArray(data[k])) data[k] = [data[k]];
                data[k].push(v);
            } else {
                data[k] = v;
            }
        });
        return JSON.stringify(data);
    }

    const initial = snapshotForm(form);
    let isDirty = false;

    function updateDirtyState() {
        isDirty = (snapshotForm(form) !== initial);
        dirtyFlag.classList.toggle('is-visible', isDirty);
    }

    // ---- Live completion progress ----
    const trackedFields = Array.from(form.querySelectorAll('[data-fx-field]'));
    function updateProgress() {
        const filled = trackedFields.filter(f => f.value && f.value.trim() !== '').length;
        const pct = trackedFields.length ? Math.round((filled / trackedFields.length) * 100) : 0;
        progressFill.style.width = pct + '%';
        progressLabel.textContent = pct + '%';
    }

    // ---- Live status pill preview ----
    function updateStatusPreview() {
        const val = statusSelect.value;
        statusPills.forEach(p => p.classList.toggle('is-active', p.dataset.status === val));
    }

    function syncAll() {
        updateDirtyState();
        updateProgress();
        updateStatusPreview();
    }

    form.addEventListener('change', syncAll);
    form.addEventListener('input', syncAll);
    syncAll(); // initial paint

    // ---- Before unload warning ----
    function beforeUnloadHandler(e) {
        if (!isDirty) return;
        e.preventDefault();
        e.returnValue = '';
        return '';
    }
    window.addEventListener('beforeunload', beforeUnloadHandler);

    // ---- Custom confirmation toast instead of native confirm() ----
    function openToast() { toastBackdrop.classList.add('is-open'); }
    function closeToast() { toastBackdrop.classList.remove('is-open'); }

    cancelBtn.addEventListener('click', function () {
        if (isDirty) {
            openToast();
            return;
        }
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        window.location.href = leaveUrl;
    });

    toastStay.addEventListener('click', closeToast);
    toastBackdrop.addEventListener('click', function (e) {
        if (e.target === toastBackdrop) closeToast();
    });
    toastLeave.addEventListener('click', function () {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        window.location.href = leaveUrl;
    });

    // ---- Submit loading state ----
    form.addEventListener('submit', function () {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        submitBtn.classList.add('em-fx-btn--loading');
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.querySelector('.em-fx-btn__label').textContent = 'Saving…';
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/enrollments/edit.blade.php ENDPATH**/ ?>