

<?php $__env->startSection('title', __('sias.teacher_settings')); ?>
<?php $__env->startSection('page_title', __('sias.teacher_settings')); ?>

<?php $__env->startSection('content'); ?>
<style>
    .teacher-settings {
        --settings-ink: var(--ink, #16213A);
        --settings-muted: #667085;
        --settings-line: var(--border, #E8E2D3);
        --settings-brass: var(--brass, #B08D57);
        --settings-brass-light: var(--brass-light, #D8BC85);
        animation: settings-enter .65s var(--ease, cubic-bezier(.22,1,.36,1)) both;
    }

    .settings-hero {
        position: relative;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.25rem;
        overflow: hidden;
        padding: clamp(1.25rem, 3vw, 2rem);
        margin-bottom: 1.25rem;
        border: 1px solid var(--settings-line);
        border-radius: 18px;
        background: linear-gradient(135deg, #fff 0%, #faf8f2 58%, #f3ead9 100%);
        box-shadow: var(--shadow-soft, 0 10px 22px rgba(11,18,32,.06));
    }

    .settings-hero::after {
        content: '';
        position: absolute;
        width: 190px;
        height: 190px;
        right: -70px;
        top: -90px;
        border: 1px solid rgba(176, 141, 87, .25);
        border-radius: 50%;
        box-shadow: 0 0 0 20px rgba(176, 141, 87, .05), 0 0 0 42px rgba(176, 141, 87, .035);
        pointer-events: none;
    }

    .settings-kicker {
        margin: 0 0 .45rem;
        color: var(--settings-brass);
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .settings-hero h2 { margin: 0 0 .45rem; color: var(--settings-ink); }
    .settings-hero p { max-width: 620px; margin: 0; color: var(--settings-muted); }

    .settings-status {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        flex: 0 0 auto;
        padding: .55rem .8rem;
        border: 1px solid rgba(176, 141, 87, .28);
        border-radius: 999px;
        background: rgba(255,255,255,.7);
        color: var(--settings-ink);
        font-size: .78rem;
        font-weight: 700;
    }

    .settings-status i { color: #3f8f68; animation: status-pulse 2.4s ease-in-out infinite; }

    .settings-alert {
        padding: .85rem 1rem;
        margin-bottom: 1rem;
        border-radius: 12px;
        animation: settings-enter .45s var(--ease, ease) both;
    }

    .settings-alert.success { border: 1px solid #bbdcca; background: #f1faf4; color: #27633f; }
    .settings-alert.error { border: 1px solid #eccaca; background: #fff5f5; color: #8a3030; }
    .settings-alert ul { margin: .45rem 0 0 1.2rem; }

    .settings-form { display: grid; gap: 1rem; }

    .settings-section {
        position: relative;
        padding: clamp(1rem, 2.5vw, 1.5rem);
        border: 1px solid var(--settings-line);
        border-radius: 16px;
        background: var(--card-bg, #fff);
        box-shadow: var(--shadow-soft, 0 10px 22px rgba(11,18,32,.06));
        animation: settings-enter .55s var(--ease, ease) both;
        transition: transform .25s var(--ease, ease), box-shadow .25s ease, border-color .25s ease;
    }

    .settings-section:nth-child(2) { animation-delay: .07s; }
    .settings-section:nth-child(3) { animation-delay: .14s; }
    .settings-section:hover { transform: translateY(-2px); border-color: rgba(176,141,87,.42); box-shadow: var(--shadow, 0 20px 46px rgba(11,18,32,.08)); }

    .settings-section legend {
        display: flex;
        align-items: center;
        gap: .6rem;
        width: 100%;
        padding: 0 0 1rem;
        margin: 0 0 1rem;
        border-bottom: 1px solid var(--settings-line);
        color: var(--settings-ink);
        font-family: var(--font-display, Georgia, serif);
        font-size: 1.2rem;
        font-weight: 600;
    }

    .settings-section legend i { color: var(--settings-brass); font-size: .95rem; }
    .settings-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
    .settings-field { display: grid; gap: .4rem; color: var(--settings-muted); font-size: .78rem; font-weight: 700; }
    .settings-field input, .settings-field select {
        width: 100%;
        min-height: 42px;
        padding: .65rem .75rem;
        border: 1px solid var(--settings-line);
        border-radius: 9px;
        background: #fff;
        color: var(--settings-ink);
        font: inherit;
        font-weight: 500;
        outline: 0;
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .settings-field input:focus, .settings-field select:focus { border-color: var(--settings-brass); box-shadow: 0 0 0 4px rgba(176,141,87,.14); transform: translateY(-1px); }
    .settings-toggle { display: flex; align-items: center; justify-content: space-between; gap: .75rem; min-height: 42px; padding: .65rem .75rem; border: 1px solid var(--settings-line); border-radius: 9px; color: var(--settings-ink); font-size: .8rem; font-weight: 600; cursor: pointer; transition: background .2s ease, border-color .2s ease; }
    .settings-toggle:hover { border-color: var(--settings-brass-light); background: #fcfaf5; }
    .settings-toggle input { width: 1.05rem; height: 1.05rem; accent-color: var(--settings-brass); }
    .settings-actions { display: flex; align-items: center; justify-content: flex-end; gap: .75rem; padding-top: .25rem; animation: settings-enter .55s .2s var(--ease, ease) both; }
    .settings-actions .btn { border: 0; cursor: pointer; }

    @keyframes settings-enter { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes status-pulse { 0%, 100% { opacity: 1; } 50% { opacity: .45; } }
    .dark-mode .settings-hero { background: linear-gradient(135deg, #17243b 0%, #111b2d 58%, #2a2630 100%); }
    .dark-mode .settings-hero h2, .dark-mode .settings-section legend, .dark-mode .settings-toggle { color: #f7f3e8; }
    .dark-mode .settings-hero p, .dark-mode .settings-field { color: #b9c2d2; }
    .dark-mode .settings-status { background: rgba(11,18,32,.7); color: #f7f3e8; }
    .dark-mode .settings-section { background: #16233d; border-color: #31415e; }
    .dark-mode .settings-section legend { border-color: #31415e; }
    .dark-mode .settings-field input, .dark-mode .settings-field select, .dark-mode .settings-toggle { background: #0f192c; border-color: #3a4b68; color: #f7f3e8; }
    .dark-mode .settings-toggle:hover { background: #1d2b45; }
    .dark-mode .settings-field input::placeholder { color: #8996ab; }
    @media (max-width: 700px) { .settings-hero { align-items: flex-start; flex-direction: column; } .settings-status { align-self: flex-start; } .settings-grid { grid-template-columns: 1fr; } }
    @media (prefers-reduced-motion: reduce) { .teacher-settings, .settings-section, .settings-actions, .settings-alert { animation: none; } .settings-section, .settings-field input, .settings-field select { transition: none; } .settings-status i { animation: none; } }
</style>
<?php
    $account = $settings['account'] ?? [];
    $appearance = $settings['appearance'] ?? [];
    $notifications = $settings['notifications'] ?? [];
    $privacy = $settings['privacy'] ?? [];
    $activeLanguage = app()->getLocale() === 'tl' ? 'Filipino' : 'English';
?>

<div class="teacher-settings page-card">
    <div class="settings-hero">
        <div>
            <p class="settings-kicker"><?php echo e(__('sias.faculty_workspace')); ?></p>
            <h2><?php echo e(__('sias.teacher_settings')); ?></h2>
            <p><?php echo e(__('sias.update_teacher_preferences')); ?></p>
        </div>
        <div class="settings-status"><i class="fa-solid fa-circle-check"></i> <?php echo e(__('sias.account_active')); ?></div>
        <a class="btn" href="<?php echo e(route('sias.teacher.account.password')); ?>" aria-label="Change password">
            <i class="fa-solid fa-lock"></i> Change password
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="settings-alert success" role="status">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="settings-alert error" role="alert">
            <strong>Please correct the following:</strong>
            <ul style="margin:0.5rem 0 0 1.2rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('sias.teacher.settings.update')); ?>" class="settings-form">
        <?php echo csrf_field(); ?>

        <fieldset class="settings-section">
            <legend><i class="fa-solid fa-user"></i> <?php echo e(__('sias.account')); ?></legend>
            <div class="settings-grid">
                <label class="settings-field"><?php echo e(__('sias.name')); ?>

                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                </label>
                <label class="settings-field"><?php echo e(__('sias.email')); ?>

                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                </label>
                <label class="settings-field"><?php echo e(__('sias.phone')); ?>

                    <input type="tel" name="account[phone]" value="<?php echo e(old('account.phone', $account['phone'] ?? '')); ?>">
                </label>
                <label class="settings-field"><?php echo e(__('sias.language')); ?>

                    <select name="account[language]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['English', 'Filipino']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($language); ?>" <?php if(old('account.language', $account['language'] ?? $activeLanguage) === $language): echo 'selected'; endif; ?>><?php echo e($language); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </label>
            </div>
        </fieldset>

        <fieldset class="settings-section">
            <legend><i class="fa-solid fa-sliders"></i> <?php echo e(__('sias.appearance_notifications')); ?></legend>
            <div class="settings-grid">
                <label class="settings-field"><?php echo e(__('sias.theme')); ?>

                    <select id="appearance_theme" name="appearance[theme]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['light' => 'Light', 'dark' => 'Dark', 'system' => 'System']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($value); ?>" <?php if(old('appearance.theme', $appearance['theme'] ?? 'light') === $value): echo 'selected'; endif; ?>><?php echo e(__('sias.' . $value)); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </label>
                <label class="settings-field"><?php echo e(__('sias.font_size')); ?>

                    <select name="appearance[font_size]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['small', 'medium', 'large']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($value); ?>" <?php if(old('appearance.font_size', $appearance['font_size'] ?? 'medium') === $value): echo 'selected'; endif; ?>><?php echo e(__('sias.' . $value)); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </label>
                <label class="settings-toggle">
                    <input type="checkbox" name="appearance[reduced_motion]" value="1" <?php if(old('appearance.reduced_motion', $appearance['reduced_motion'] ?? false)): echo 'checked'; endif; ?>>
                    <?php echo e(__('sias.reduce_animations')); ?>

                </label>
                <label class="settings-toggle">
                    <input type="checkbox" name="notifications[email]" value="1" <?php if(old('notifications.email', $notifications['email'] ?? true)): echo 'checked'; endif; ?>>
                    <?php echo e(__('sias.email_notifications')); ?>

                </label>
                <label class="settings-toggle">
                    <input type="checkbox" name="notifications[push]" value="1" <?php if(old('notifications.push', $notifications['push'] ?? true)): echo 'checked'; endif; ?>>
                    <?php echo e(__('sias.push_notifications')); ?>

                </label>
                <label class="settings-toggle">
                    <input type="checkbox" name="notifications[weekly_digest]" value="1" <?php if(old('notifications.weekly_digest', $notifications['weekly_digest'] ?? false)): echo 'checked'; endif; ?>>
                    <?php echo e(__('sias.weekly_digest')); ?>

                </label>
            </div>
        </fieldset>

        <fieldset class="settings-section">
            <legend><i class="fa-solid fa-shield-halved"></i> <?php echo e(__('sias.privacy')); ?></legend>
            <div class="settings-grid">
                <label class="settings-field"><?php echo e(__('sias.profile_visibility')); ?>

                    <select name="privacy[profile_visibility]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['public', 'students_only', 'private']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($value); ?>" <?php if(old('privacy.profile_visibility', $privacy['profile_visibility'] ?? 'public') === $value): echo 'selected'; endif; ?>><?php echo e(__('sias.' . $value)); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </label>
                <label class="settings-toggle">
                    <input type="checkbox" name="privacy[show_contact]" value="1" <?php if(old('privacy.show_contact', $privacy['show_contact'] ?? false)): echo 'checked'; endif; ?>>
                    <?php echo e(__('sias.show_contact')); ?>

                </label>
            </div>
        </fieldset>

        <div class="settings-actions">
            <button type="submit" class="btn"><i class="fa-solid fa-floppy-disk"></i> <?php echo e(__('sias.save_settings')); ?></button>
        </div>
    </form>
</div>
<script>
    (function () {
        var themeSelect = document.getElementById('appearance_theme');
        if (!themeSelect || typeof window.siasApplyTheme !== 'function') return;

        themeSelect.addEventListener('change', function () {
            window.siasApplyTheme(themeSelect.value, true);
        });
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\setting.blade.php ENDPATH**/ ?>