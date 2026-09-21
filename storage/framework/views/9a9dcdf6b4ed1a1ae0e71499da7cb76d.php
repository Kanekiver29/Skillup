

<?php
    $course       = $course ?? null;
    $title        = $course->title ?? 'Untitled course';
    $tagline      = $course->tagline ?? $course->description ?? '';
    $modulesCount = $course->modules_count ?? ($course?->modules?->count() ?? 0);
    $lessonsCount = $course->lessons_count ?? ($course?->modules?->sum(fn ($m) => $m->lessons->count()) ?? 0);
    $progress     = (int) round($course->progress ?? $userProgress ?? 0);
    $progress     = max(0, min(100, $progress));

    $tocRouteName    = 'courses.contents';
    $openRouteName   = 'courses.show';
    $hasTocRoute     = $course && \Illuminate\Support\Facades\Route::has($tocRouteName);
    $hasOpenRoute    = $course && \Illuminate\Support\Facades\Route::has($openRouteName);
    $tocUrl          = $hasTocRoute ? route($tocRouteName, $course->slug) : '#';
    $openUrl         = $hasOpenRoute ? route($openRouteName, $course->slug) : '#';
?>

<?php $__env->startSection('title', $title . ' — SkillUp'); ?>
<?php $__env->startSection('content'); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=DM+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

<style>
    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --ease-spring: cubic-bezier(.34, 1.56, .64, 1);

        --stage-bg: #eef1f6;
        --cover: #17264f;
        --cover-edge: #0f1a3a;
        --page: #f6f0e0;
        --page-shade: #efe7d2;
        --ink: #241c0c;
        --ink-muted: #6b6250;
        --gold: #c08a2e;
        --gold-strong: #a97423;
        --btn-dark: #241c0c;
        --btn-dark-hover: #33280f;

        --font-display: 'Fraunces', Georgia, serif;
        --font-ui: 'DM Sans', system-ui, sans-serif;
        --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    html.dark-mode {
        --stage-bg: #0a0d16;
        --cover: #0c1530;
        --cover-edge: #060b1c;
        --page: #16110a;
        --page-shade: #1c150c;
        --ink: #f1e8d4;
        --ink-muted: #a89a7c;
        --gold: #e0ac52;
        --gold-strong: #f0c476;
        --btn-dark: #f1e8d4;
        --btn-dark-hover: #ffffff;
    }

    * { box-sizing: border-box; }

    .manual-stage {
        max-width: 1180px;
        margin: 0 auto;
        padding: 56px 20px 70px;
        display: flex;
        justify-content: center;
    }

    /* ============ Cover frame ============ */
    .manual-cover {
        position: relative;
        width: 100%;
        background: linear-gradient(160deg, var(--cover), var(--cover-edge));
        border-radius: 26px;
        padding: 22px;
        box-shadow:
            0 40px 80px -30px rgba(10, 15, 35, .5),
            0 4px 16px rgba(10, 15, 35, .25),
            inset 0 1px 0 rgba(255, 255, 255, .06);
        opacity: 0;
        animation: cover-in .6s var(--ease) .05s both;
    }

    @keyframes cover-in {
        from { opacity: 0; transform: translateY(22px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ============ Page spread ============ */
    .manual-spread {
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: var(--page);
        border-radius: 14px;
        overflow: hidden;
        min-height: 420px;
    }

    /* Center spine: a soft crease with a shadow gutter on each side */
    .manual-spread::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 34px;
        transform: translateX(-50%);
        background: linear-gradient(90deg,
            transparent,
            rgba(0, 0, 0, .07) 42%,
            rgba(0, 0, 0, .1) 50%,
            rgba(0, 0, 0, .07) 58%,
            transparent);
        pointer-events: none;
        z-index: 3;
    }

    /* Faint paper texture per page */
    .manual-page {
        position: relative;
        padding: 46px 48px;
        background: radial-gradient(140% 90% at 0% 0%, var(--page) 60%, var(--page-shade) 100%);
    }
    .manual-page.right {
        background: radial-gradient(140% 90% at 100% 0%, var(--page) 60%, var(--page-shade) 100%);
    }

    /* Corner fold hint, bottom outer corners — matches the reference */
    .manual-page::after {
        content: '';
        position: absolute;
        bottom: 14px;
        width: 15px;
        height: 15px;
        opacity: .35;
    }
    .manual-page.left::after {
        left: 16px;
        border-left: 1.5px solid var(--ink-muted);
        border-bottom: 1.5px solid var(--ink-muted);
        border-radius: 0 0 0 3px;
    }
    .manual-page.right::after {
        right: 16px;
        border-right: 1.5px solid var(--ink-muted);
        border-bottom: 1.5px solid var(--ink-muted);
        border-radius: 0 0 3px 0;
    }

    .manual-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-mono);
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 14px;
        animation: fade-up .5s var(--ease) .25s both;
    }

    .manual-title {
        font-family: var(--font-display);
        font-size: clamp(1.6rem, 2.6vw, 2.15rem);
        font-weight: 600;
        color: var(--ink);
        line-height: 1.2;
        margin: 0 0 12px;
        letter-spacing: -.01em;
        animation: fade-up .5s var(--ease) .3s both;
    }

    .manual-tagline {
        font-family: var(--font-ui);
        font-size: .92rem;
        color: var(--ink-muted);
        margin: 0 0 30px;
        max-width: 34ch;
        line-height: 1.6;
        animation: fade-up .5s var(--ease) .35s both;
    }

    /* ============ Stats row ============ */
    .manual-stats {
        display: flex;
        gap: 34px;
        padding-top: 20px;
        margin-bottom: 26px;
        border-top: 1px dashed rgba(36, 28, 12, .18);
        animation: fade-up .5s var(--ease) .4s both;
    }
    html.dark-mode .manual-stats { border-top-color: rgba(241, 232, 212, .16); }

    .manual-stat-label {
        font-family: var(--font-mono);
        font-size: .66rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 6px;
    }
    .manual-stat-value {
        font-family: var(--font-ui);
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--ink);
        font-variant-numeric: tabular-nums;
    }

    /* ============ Actions ============ */
    .manual-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        animation: fade-up .5s var(--ease) .45s both;
    }

    .manual-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 9px;
        font-family: var(--font-ui);
        font-size: .87rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1.5px solid rgba(36, 28, 12, .16);
        background: transparent;
        color: var(--ink);
        transition: transform .22s var(--ease), box-shadow .22s var(--ease), background .22s var(--ease), border-color .22s var(--ease);
    }
    html.dark-mode .manual-btn { border-color: rgba(241, 232, 212, .2); }

    .manual-btn:hover { transform: translateY(-2px); border-color: var(--gold); background: rgba(192, 138, 46, .08); }
    .manual-btn:active { transform: translateY(0); }

    .manual-btn.primary {
        background: var(--btn-dark);
        color: var(--page);
        border-color: var(--btn-dark);
        box-shadow: 0 10px 22px -12px rgba(36, 28, 12, .5);
    }
    .manual-btn.primary:hover { background: var(--btn-dark-hover); border-color: var(--btn-dark-hover); box-shadow: 0 14px 28px -12px rgba(36, 28, 12, .6); }
    html.dark-mode .manual-btn.primary { color: var(--cover); }

    .manual-btn.disabled { opacity: .45; pointer-events: none; }

    @keyframes fade-up { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    @media (prefers-reduced-motion: reduce) {
        .manual-cover, .manual-eyebrow, .manual-title, .manual-tagline, .manual-stats, .manual-actions {
            animation: none !important; opacity: 1 !important; transform: none !important;
        }
    }

    /* ============ Responsive: stack pages on narrow screens ============ */
    @media (max-width: 760px) {
        .manual-spread { grid-template-columns: 1fr; }
        .manual-spread::before { display: none; }
        .manual-page.right { display: none; }
        .manual-page { padding: 34px 26px; }
        .manual-stats { gap: 24px; flex-wrap: wrap; }
        .manual-cover { border-radius: 20px; padding: 14px; }
    }
</style>

<div class="manual-stage">
    <div class="manual-cover">
        <div class="manual-spread">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['left', 'right']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="manual-page <?php echo e($side); ?>">
                    <span class="manual-eyebrow">Course manual</span>
                    <h1 class="manual-title"><?php echo e($title); ?></h1>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tagline): ?>
                        <p class="manual-tagline"><?php echo e($tagline); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="manual-stats">
                        <div>
                            <div class="manual-stat-label">Modules</div>
                            <div class="manual-stat-value"><?php echo e($modulesCount); ?></div>
                        </div>
                        <div>
                            <div class="manual-stat-label">Lessons</div>
                            <div class="manual-stat-value"><?php echo e($lessonsCount); ?></div>
                        </div>
                        <div>
                            <div class="manual-stat-label">Progress</div>
                            <div class="manual-stat-value"><?php echo e($progress); ?>%</div>
                        </div>
                    </div>

                    <div class="manual-actions">
                        <a href="<?php echo e($tocUrl); ?>" class="manual-btn <?php echo e($hasTocRoute ? '' : 'disabled'); ?>">Table of contents</a>
                        <a href="<?php echo e($openUrl); ?>" class="manual-btn primary <?php echo e($hasOpenRoute ? '' : 'disabled'); ?>">Open course</a>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\course\lesson.blade.php ENDPATH**/ ?>