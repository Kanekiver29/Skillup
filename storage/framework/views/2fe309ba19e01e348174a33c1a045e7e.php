
<?php $__env->startSection('title','System Settings'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --ss-ink:        var(--text);
        --ss-surface:    var(--surface);
        --ss-muted:      var(--muted);
        --ss-border:     var(--border);
        --ss-soft-bg:    var(--topbar-control-bg);
        --ss-soft-border: rgba(14,165,233,.22);
        --accent:        #0ea5e9;
        --accent-2:      #06b6d4;
        --accent-bg:     rgba(14,165,233,.08);
        --accent-bdr:    rgba(14,165,233,.22);
        --success:       #10b981;
        --warning:       #f59e0b;
        --danger:        #ef4444;
        --radius:        12px;
        --shadow-sm:     0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow-md:     0 4px 16px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
    }

    /* ── Reset & Base ─────────────────────── */
    .ss-wrap *, .ss-wrap *::before, .ss-wrap *::after { box-sizing: border-box; }
    .ss-wrap {
        font-family: 'DM Sans', sans-serif;
        color: var(--ss-ink);
        background: transparent;
        padding: 2rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── Page Header ──────────────────────── */
    .ss-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
        animation: ss-slideDown .5s cubic-bezier(.16,1,.3,1) both;
    }
    .ss-header__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--accent);
        margin-bottom: .4rem;
    }
    .ss-header__eyebrow-dot {
        width: 6px; height: 6px;
        background: var(--accent);
        border-radius: 50%;
        animation: ss-pulse 2s ease infinite;
    }
    .ss-header__title {
        font-family: 'Syne', sans-serif;
        font-size: 1.9rem;
        font-weight: 800;
        letter-spacing: -.025em;
        line-height: 1;
        margin: 0 0 .35rem;
    }
    .ss-header__sub {
        color: var(--ss-muted);
        font-size: .84rem;
        margin: 0;
    }
    .ss-header__actions {
        display: flex;
        gap: .6rem;
        flex-shrink: 0;
        align-items: center;
    }

    /* ── Buttons ──────────────────────────── */
    .ss-btn {
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
        line-height: 1;
    }
    .ss-btn--primary {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        box-shadow: 0 2px 8px rgba(14,165,233,.28);
    }
    .ss-btn--primary:hover:not(:disabled) {
        background: #0284c7;
        box-shadow: 0 4px 14px rgba(14,165,233,.4);
        transform: translateY(-1px);
    }
    .ss-btn--outline {
        background: transparent;
        color: var(--ss-ink);
        border-color: var(--ss-border);
    }
    .ss-btn--outline:hover:not(:disabled) {
        border-color: var(--accent);
        color: var(--accent);
        background: var(--accent-bg);
    }
    .ss-btn--danger {
        background: #fef2f2;
        color: var(--danger);
        border-color: #fecaca;
    }
    .ss-btn--danger:hover:not(:disabled) {
        background: var(--danger);
        color: #fff;
    }
    .ss-btn:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    /* ── Card ─────────────────────────────── */
    .ss-card {
        background: var(--ss-surface);
        border: 1px solid var(--ss-border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        animation: ss-fadeUp .5s .07s cubic-bezier(.16,1,.3,1) both;
    }

    /* ── Tab Nav ──────────────────────────── */
    .ss-tabs {
        display: flex;
        padding: 0 1rem;
        border-bottom: 1px solid var(--border);
        overflow-x: auto;
        scrollbar-width: none;
        background: var(--ss-soft-bg);
    }
    .ss-tabs::-webkit-scrollbar { display: none; }
    .ss-tab {
        position: relative;
        display: flex;
        align-items: center;
        gap: .35rem;
        padding: .8rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .81rem;
        font-weight: 500;
        color: var(--ss-muted);
        background: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: color .18s ease;
        outline: none;
    }
    .ss-tab__icon { font-size: .9rem; }
    .ss-tab::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        height: 2.5px;
        background: var(--accent);
        border-radius: 2px 2px 0 0;
        transform: scaleX(0);
        transition: transform .22s cubic-bezier(.34,1.56,.64,1);
    }
    .ss-tab:hover { color: var(--ss-ink); }
    .ss-tab.is-active { color: var(--accent); font-weight: 600; }
    .ss-tab.is-active::after { transform: scaleX(1); }

    /* ── Panels ───────────────────────────── */
    .ss-panels { padding: 1.75rem; }
    .ss-panel {
        display: none;
        animation: ss-panelIn .32s cubic-bezier(.16,1,.3,1) both;
    }
    .ss-panel.is-active { display: block; }

    /* ── Section heading ──────────────────── */
    .ss-section-title {
        font-family: 'Syne', sans-serif;
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.01em;
        margin: 0 0 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        color: var(--ss-ink);
    }
    .ss-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--ss-border);
    }
    .ss-divider {
        border: none;
        border-top: 1px solid var(--ss-border);
        margin: 1.5rem 0;
    }

    /* ── Form Elements ────────────────────── */
    .ss-label {
        display: block;
        font-size: .78rem;
        font-weight: 500;
        color: var(--ss-muted);
        margin-bottom: .35rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .ss-input {
        width: 100%;
        padding: .6rem .85rem;
        border: 1.5px solid var(--ss-border);
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .87rem;
        color: var(--ss-ink);
        background: var(--ss-surface);
        transition: border-color .18s ease, box-shadow .18s ease;
        outline: none;
        appearance: none;
    }
    .ss-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(14,165,233,.12);
    }
    textarea.ss-input { resize: vertical; min-height: 80px; }
    .ss-grid { display: grid; gap: 1rem; }
    .ss-grid--2 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .ss-grid--3 { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
    .ss-field { display: flex; flex-direction: column; }
    .ss-field--span2 { grid-column: 1 / -1; }

    /* Checkbox toggle */
    .ss-check {
        display: flex;
        align-items: center;
        gap: .65rem;
        cursor: pointer;
        font-size: .87rem;
        font-weight: 400;
        color: var(--ss-ink);
        padding: .6rem .85rem;
        border: 1.5px solid var(--ss-border);
        border-radius: 8px;
        transition: border-color .18s, background .18s;
        user-select: none;
    }
    .ss-check:hover { border-color: var(--accent); background: var(--accent-bg); }
    .ss-check input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--accent);
        cursor: pointer;
        flex-shrink: 0;
    }

    .ss-form-footer {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-top: 1.25rem;
    }

    /* ── Stat grid ────────────────────────── */
    .ss-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .ss-stat {
        background: var(--accent-bg);
        border: 1px solid var(--accent-bdr);
        border-radius: 10px;
        padding: 1rem 1.1rem;
        position: relative;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .ss-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .ss-stat::before {
        content: '';
        position: absolute;
        top: -18px; right: -18px;
        width: 60px; height: 60px;
        background: rgba(14,165,233,.1);
        border-radius: 50%;
    }
    .ss-stat__label {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--ss-muted);
        margin-bottom: .3rem;
    }
    .ss-stat__value {
        font-family: 'Syne', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.1;
        color: var(--ss-ink);
        word-break: break-all;
    }

    /* ── Info grid (app info / storage) ───── */
    .ss-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .ss-info-item {}
    .ss-info-item__label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--ss-muted);
        margin-bottom: .2rem;
    }
    .ss-info-item__value {
        font-family: 'Syne', sans-serif;
        font-size: .95rem;
        font-weight: 700;
        color: var(--ss-ink);
    }
    .ss-badge {
        display: inline-flex;
        align-items: center;
        padding: .15rem .5rem;
        border-radius: 99px;
        font-size: .72rem;
        font-weight: 600;
    }
    .ss-badge--on  { background: #dcfce7; color: #16a34a; }
    .ss-badge--off { background: var(--ss-soft-bg); color: var(--ss-muted); }
    .ss-badge--env-local  { background: #fef9c3; color: #854d0e; }
    .ss-badge--env-production { background: #dcfce7; color: #15803d; }

    /* ── Sub-card ─────────────────────────── */
    .ss-sub-card {
        border: 1px solid var(--ss-border);
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .ss-sub-card__title {
        font-family: 'Syne', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        margin: 0 0 1rem;
        color: var(--ss-ink);
    }

    /* ── Activity pre ─────────────────────── */
    .ss-pre {
        background: var(--ss-soft-bg);
        border: 1px solid var(--ss-border);
        border-radius: 8px;
        padding: 1rem;
        font-size: .78rem;
        font-family: 'Courier New', monospace;
        color: var(--ss-ink);
        overflow-x: auto;
        line-height: 1.6;
        max-height: 400px;
        overflow-y: auto;
    }

    /* ── Info banner ──────────────────────── */
    .ss-info-banner {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        padding: .85rem 1rem;
        background: var(--accent-bg);
        border: 1px solid var(--accent-bdr);
        border-radius: 8px;
        font-size: .82rem;
        color: #0369a1;
        margin-top: .75rem;
    }

    /* ── Keyframes ────────────────────────── */
    @keyframes ss-slideDown {
        from { opacity:0; transform:translateY(-18px); }
        to   { opacity:1; transform:translateY(0); }
    }
    @keyframes ss-fadeUp {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }
    @keyframes ss-panelIn {
        from { opacity:0; transform:translateX(10px); }
        to   { opacity:1; transform:translateX(0); }
    }
    @keyframes ss-pulse {
        0%,100% { opacity:1; transform:scale(1); }
        50%      { opacity:.5; transform:scale(1.5); }
    }

    /* ── Responsive ───────────────────────── */
    @media(max-width:640px) {
        .ss-wrap { padding: 1rem; }
        .ss-header { flex-direction:column; }
        .ss-header__actions { flex-wrap:wrap; }
        .ss-stat__value { font-size:1.1rem; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="ss-wrap">

    
    <div class="ss-header">
        <div>
            <div class="ss-header__eyebrow">
                <span class="ss-header__eyebrow-dot"></span>
                System
            </div>
            <h1 class="ss-header__title">System Settings</h1>
            <p class="ss-header__sub">Read-only system information and administrative actions (admin-only).</p>
        </div>
        <div class="ss-header__actions">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->isAdmin()): ?>
                <form method="POST" action="<?php echo e(route('admin.settings.cache.clear')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="type" value="all">
                    <button class="ss-btn ss-btn--outline" type="submit">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.85"/></svg>
                        Clear All Caches
                    </button>
                </form>
                <form method="POST" action="<?php echo e(route('admin.settings.maintenance')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="ss-btn ss-btn--danger" type="submit">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Toggle Maintenance
                    </button>
                </form>
            <?php else: ?>
                <button class="ss-btn ss-btn--outline" disabled title="Admin only">Clear All Caches</button>
                <button class="ss-btn ss-btn--outline" disabled title="Admin only">Toggle Maintenance</button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="ss-card">

        
        <div class="ss-tabs" role="tablist" id="ss-tablist">
            <?php
                $ssTabs = [
                    'profile'       => ['label'=>'Profile',       'icon'=>'👤'],
                    'account'       => ['label'=>'Account',       'icon'=>'🔧'],
                    'organization'  => ['label'=>'Organization',  'icon'=>'🏫'],
                    'courses'       => ['label'=>'Courses',       'icon'=>'📚'],
                    'certificates'  => ['label'=>'Certificates',  'icon'=>'🏅'],
                    'notifications' => ['label'=>'Notifications', 'icon'=>'🔔'],
                    'security'      => ['label'=>'Security',      'icon'=>'🔐'],
                    'activity'      => ['label'=>'Activity',      'icon'=>'📋'],
                    'system'        => ['label'=>'System',        'icon'=>'⚙️'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ssTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <button
                    class="ss-tab<?php echo e($key === 'system' ? ' is-active' : ''); ?>"
                    role="tab"
                    data-target="<?php echo e($key); ?>"
                    aria-selected="<?php echo e($key === 'system' ? 'true' : 'false'); ?>"
                >
                    <span class="ss-tab__icon"><?php echo e($meta['icon']); ?></span>
                    <?php echo e($meta['label']); ?>

                </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="ss-panels">

            
            <div class="ss-panel" id="ss-panel-profile" role="tabpanel">

                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Profile Information</div>
                    <form action="<?php echo e(route('staff.settings.profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <div class="ss-field">
                                <label class="ss-label" for="p_name">Full Name</label>
                                <input id="p_name" class="ss-input" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label" for="p_email">Email Address</label>
                                <input id="p_email" class="ss-input" name="email" type="email" value="<?php echo e(old('email', auth()->user()->email)); ?>">
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Profile</button>
                        </div>
                    </form>
                </div>

                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Change Password</div>
                    <form action="<?php echo e(route('staff.settings.password.change')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--3">
                            <div class="ss-field">
                                <label class="ss-label">Current Password</label>
                                <input class="ss-input" name="current_password" placeholder="••••••••" type="password">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">New Password</label>
                                <input class="ss-input" name="password" placeholder="••••••••" type="password">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Confirm Password</label>
                                <input class="ss-input" name="password_confirmation" placeholder="••••••••" type="password">
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--outline" type="submit">Update Password</button>
                        </div>
                    </form>
                </div>

                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Profile Picture</div>
                    <form action="<?php echo e(route('staff.settings.avatar.upload')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap">
                            <input class="ss-input" style="max-width:320px" type="file" name="avatar" accept="image/*">
                            <button class="ss-btn ss-btn--primary" type="submit">Upload Avatar</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-account" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Account Preferences</div>
                    <form action="<?php echo e(route('staff.settings.account.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <label class="ss-check">
                                <input type="checkbox" name="receive_notifications" value="1"
                                    <?php echo e(session('staff_account_settings.receive_notifications') ? 'checked' : ''); ?>>
                                Receive Notifications
                            </label>
                            <div class="ss-field">
                                <label class="ss-label" for="acc_status">Account Status</label>
                                <select id="acc_status" class="ss-input" name="account_status">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Account Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-organization" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Organization Information</div>
                    <form action="<?php echo e(route('staff.settings.organization.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <div class="ss-field">
                                <label class="ss-label">School / Training Center Name</label>
                                <input class="ss-input" name="org_name"
                                    value="<?php echo e(old('org_name', session('staff_org_info.org_name'))); ?>">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Contact</label>
                                <input class="ss-input" name="org_contact"
                                    value="<?php echo e(old('org_contact', session('staff_org_info.org_contact'))); ?>">
                            </div>
                            <div class="ss-field ss-field--span2">
                                <label class="ss-label">Address</label>
                                <textarea class="ss-input" name="org_address"><?php echo e(old('org_address', session('staff_org_info.org_address'))); ?></textarea>
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Organization</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-courses" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Course Defaults</div>
                    <form action="<?php echo e(route('staff.settings.courses.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <div class="ss-field">
                                <label class="ss-label">Default Category</label>
                                <input class="ss-input" name="default_category"
                                    value="<?php echo e(old('default_category', session('staff_course_settings.default_category'))); ?>">
                            </div>
                            <label class="ss-check" style="align-self:flex-end">
                                <input type="checkbox" name="certificate_required" value="1"
                                    <?php echo e(session('staff_course_settings.certificate_required') ? 'checked' : ''); ?>>
                                Certificate required by default
                            </label>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Course Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-certificates" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Certificate Configuration</div>
                    <form action="<?php echo e(route('staff.settings.certificates.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <div class="ss-field">
                                <label class="ss-label">Certificate Prefix / Number Format</label>
                                <input class="ss-input" name="certificate_prefix"
                                    value="<?php echo e(old('certificate_prefix', session('staff_certificate_settings.certificate_prefix'))); ?>"
                                    placeholder="e.g. CERT-2025-">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Signature / Approver Name</label>
                                <input class="ss-input" name="signature_name"
                                    value="<?php echo e(old('signature_name', session('staff_certificate_settings.signature_name'))); ?>"
                                    placeholder="Full name of signatory">
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Certificate Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-notifications" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Notification Channels</div>
                    <form action="<?php echo e(route('staff.settings.notifications.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2" style="gap:.75rem">
                            <label class="ss-check">
                                <input type="checkbox" name="email_notifications" value="1"
                                    <?php echo e(session('staff_notification_settings.email_notifications') ? 'checked' : ''); ?>>
                                📧 Email Notifications
                            </label>
                            <label class="ss-check">
                                <input type="checkbox" name="sms_notifications" value="1"
                                    <?php echo e(session('staff_notification_settings.sms_notifications') ? 'checked' : ''); ?>>
                                📱 SMS Notifications
                            </label>
                            <label class="ss-check">
                                <input type="checkbox" name="announcements_enabled" value="1"
                                    <?php echo e(session('staff_notification_settings.announcements_enabled') ? 'checked' : ''); ?>>
                                📢 Announcements
                            </label>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Notification Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-security" role="tabpanel">
                <div class="ss-sub-card">
                    <div class="ss-sub-card__title">Password & Lockout Policy</div>
                    <form action="<?php echo e(route('staff.settings.security.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="ss-grid ss-grid--2">
                            <div class="ss-field">
                                <label class="ss-label">Minimum Password Length</label>
                                <input class="ss-input" name="password_policy_min_length" type="number" min="6" max="128"
                                    value="<?php echo e(session('staff_security_settings.password_policy_min_length', 8)); ?>">
                            </div>
                            <div class="ss-field">
                                <label class="ss-label">Lockout Attempts Before Block</label>
                                <input class="ss-input" name="lockout_attempts" type="number" min="1" max="20"
                                    value="<?php echo e(session('staff_security_settings.lockout_attempts', 5)); ?>">
                            </div>
                        </div>
                        <div class="ss-form-footer">
                            <button class="ss-btn ss-btn--primary" type="submit">Save Security Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="ss-panel" id="ss-panel-activity" role="tabpanel">
                <p class="ss-section-title">Activity &amp; Logs</p>
                <div class="ss-info-banner">
                    <span>ℹ️</span>
                    <span>Showing recent session state (development demo). Integrate an activity-logging package for production audit trails.</span>
                </div>
                <pre class="ss-pre" style="margin-top:1rem"><?php echo e(json_encode([
                    'account'         => session('staff_account_settings'),
                    'organization'    => session('staff_org_info'),
                    'course_settings' => session('staff_course_settings'),
                    'notifications'   => session('staff_notification_settings'),
                    'security'        => session('staff_security_settings'),
                ], JSON_PRETTY_PRINT)); ?></pre>
            </div>

            
            <div class="ss-panel is-active" id="ss-panel-system" role="tabpanel">

                <p class="ss-section-title">Server Environment</p>
                <div class="ss-stats">
                    <div class="ss-stat">
                        <div class="ss-stat__label">PHP Version</div>
                        <div class="ss-stat__value"><?php echo e(PHP_VERSION); ?></div>
                    </div>
                    <div class="ss-stat">
                        <div class="ss-stat__label">Laravel</div>
                        <div class="ss-stat__value"><?php echo e(app()->version()); ?></div>
                    </div>
                    <div class="ss-stat">
                        <div class="ss-stat__label">Server OS</div>
                        <div class="ss-stat__value"><?php echo e(PHP_OS); ?></div>
                    </div>
                    <div class="ss-stat">
                        <div class="ss-stat__label">Memory Limit</div>
                        <div class="ss-stat__value"><?php echo e(ini_get('memory_limit')); ?></div>
                    </div>
                </div>

                <p class="ss-section-title">Application Info</p>
                <div class="ss-sub-card">
                    <div class="ss-info-grid">
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">App Name</div>
                            <div class="ss-info-item__value"><?php echo e($settings['app_name'] ?? config('app.name')); ?></div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Environment</div>
                            <div class="ss-info-item__value">
                                <?php $env = $settings['app_env'] ?? config('app.env'); ?>
                                <span class="ss-badge ss-badge--env-<?php echo e($env); ?>"><?php echo e(ucfirst($env)); ?></span>
                            </div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">App URL</div>
                            <div class="ss-info-item__value" style="font-size:.82rem;word-break:break-all"><?php echo e($settings['app_url'] ?? config('app.url')); ?></div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Debug Mode</div>
                            <div class="ss-info-item__value">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings['app_debug'] ?? config('app.debug')): ?>
                                    <span class="ss-badge ss-badge--on">ON</span>
                                <?php else: ?>
                                    <span class="ss-badge ss-badge--off">OFF</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="ss-section-title">Storage &amp; Queue</p>
                <div class="ss-sub-card">
                    <div class="ss-info-grid">
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Cache Driver</div>
                            <div class="ss-info-item__value"><?php echo e($settings['cache_driver'] ?? 'file'); ?></div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Session Driver</div>
                            <div class="ss-info-item__value"><?php echo e($settings['session_driver'] ?? 'file'); ?></div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Queue Connection</div>
                            <div class="ss-info-item__value"><?php echo e($settings['queue_connection'] ?? 'sync'); ?></div>
                        </div>
                        <div class="ss-info-item">
                            <div class="ss-info-item__label">Filesystem</div>
                            <div class="ss-info-item__value"><?php echo e($settings['filesystems'] ?? 'local'); ?></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const tablist = document.getElementById('ss-tablist');
    const tabs    = tablist.querySelectorAll('.ss-tab');
    const panels  = document.querySelectorAll('.ss-panel');

    function activate(btn) {
        tabs.forEach(t => {
            t.classList.remove('is-active');
            t.setAttribute('aria-selected', 'false');
        });
        panels.forEach(p => p.classList.remove('is-active'));

        btn.classList.add('is-active');
        btn.setAttribute('aria-selected', 'true');

        const panel = document.getElementById('ss-panel-' + btn.dataset.target);
        if (panel) panel.classList.add('is-active');
    }

    tabs.forEach(btn => btn.addEventListener('click', () => activate(btn)));

    /* Arrow-key navigation */
    tablist.addEventListener('keydown', e => {
        const all = [...tabs];
        const idx = all.indexOf(tablist.querySelector('.ss-tab.is-active'));
        if (e.key === 'ArrowRight') { e.preventDefault(); activate(all[(idx + 1) % all.length]); }
        if (e.key === 'ArrowLeft')  { e.preventDefault(); activate(all[(idx - 1 + all.length) % all.length]); }
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\settings\index.blade.php ENDPATH**/ ?>