

<?php $__env->startSection('title', 'Edit Profile - SkillUp'); ?>

<?php $__env->startPush('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --fx-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --fx-void: #030712;
        --fx-panel: #0d1428;
        --fx-panel-light: #121b38;
        --fx-line: rgba(126, 176, 255, 0.14);
        --fx-line-soft: rgba(126, 176, 255, 0.07);
        --fx-cyan: #22d3ee;
        --fx-cyan-soft: #7dd8f0;
        --fx-violet: #8b7bff;
        --fx-violet-soft: #c4b5fd;
        --fx-amber: #fbbf24;
        --fx-rose: #fb7185;
        --fx-emerald: #34d399;
        --fx-text: #e9edfb;
        --fx-text-body: #a8b3d1;
        --fx-text-dim: #6c7797;
        --fx-font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;
        --fx-font-body: 'Inter', system-ui, sans-serif;
        --fx-font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    /* ============ PAGE / AMBIENT FIELD ============ */
    .ep-page {
        position: relative;
        background: var(--fx-void) !important;
        font-family: var(--fx-font-body);
        isolation: isolate;
    }

    .ep-page::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -2;
        background:
            radial-gradient(ellipse 55% 45% at 10% 0%, rgba(34, 211, 238, 0.10), transparent 60%),
            radial-gradient(ellipse 50% 40% at 90% 15%, rgba(139, 123, 255, 0.10), transparent 55%),
            var(--fx-void);
    }

    .ep-page::after {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background-image:
            linear-gradient(var(--fx-line-soft) 1px, transparent 1px),
            linear-gradient(90deg, var(--fx-line-soft) 1px, transparent 1px);
        background-size: 56px 56px;
        mask-image: radial-gradient(ellipse 75% 60% at 50% 0%, #000 0%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse 75% 60% at 50% 0%, #000 0%, transparent 75%);
        animation: epDrift 40s linear infinite;
        pointer-events: none;
    }

    @keyframes epDrift {
        0% { background-position: 0 0, 0 0; }
        100% { background-position: 56px 56px, 56px 56px; }
    }

    .ep-page h1, .ep-page h2 { font-family: var(--fx-font-display); letter-spacing: -0.01em; }
    .ep-mono { font-family: var(--fx-font-mono); letter-spacing: 0.05em; }

    .ep-text-strong { color: var(--fx-text) !important; }
    .ep-text-body   { color: var(--fx-text-body) !important; }
    .ep-text-dim    { color: var(--fx-text-dim) !important; }
    .ep-link { color: var(--fx-cyan-soft) !important; }
    .ep-link:hover { color: #fff !important; }

    @keyframes epEnter {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .ep-enter { animation: epEnter 0.6s var(--fx-ease) forwards; opacity: 0; }
    .ep-enter-1 { animation-delay: 0.06s; }
    .ep-enter-2 { animation-delay: 0.12s; }
    .ep-enter-3 { animation-delay: 0.18s; }
    .ep-enter-4 { animation-delay: 0.24s; }
    .ep-enter-5 { animation-delay: 0.30s; }
    .ep-enter-6 { animation-delay: 0.36s; }

    /* ============ CARD SHELL ============ */
    .ep-card {
        background: linear-gradient(180deg, rgba(18, 27, 56, 0.75), rgba(10, 16, 34, 0.75));
        border: 1px solid var(--fx-line);
        border-radius: 1.25rem;
        box-shadow: 0 4px 28px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        position: relative;
        overflow: hidden;
    }
    .ep-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(125, 211, 252, 0.5), rgba(139, 123, 255, 0.4), transparent);
    }

    .ep-subcard {
        border-radius: 1rem;
        border: 1px solid var(--fx-line);
        background: rgba(255, 255, 255, 0.025);
    }
    .ep-subcard-violet {
        border: 1px solid rgba(139, 123, 255, 0.28);
        background: linear-gradient(160deg, rgba(139, 123, 255, 0.12), rgba(34, 211, 238, 0.06));
    }
    .ep-subcard-gray {
        border: 1px solid var(--fx-line);
        background: rgba(255, 255, 255, 0.02);
    }

    .ep-icon-chip {
        width: 2.5rem; height: 2.5rem;
        border-radius: 0.85rem;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .chip-cyan    { background: rgba(34, 211, 238, 0.14);  color: var(--fx-cyan-soft);   box-shadow: 0 0 18px rgba(34, 211, 238, 0.22); }
    .chip-violet  { background: rgba(139, 123, 255, 0.16); color: var(--fx-violet-soft); box-shadow: 0 0 18px rgba(139, 123, 255, 0.24); }
    .chip-rose    { background: rgba(251, 113, 133, 0.16); color: var(--fx-rose);        box-shadow: 0 0 18px rgba(251, 113, 133, 0.2); }
    .chip-amber   { background: rgba(251, 191, 36, 0.16);  color: var(--fx-amber);       box-shadow: 0 0 18px rgba(251, 191, 36, 0.2); }
    .chip-gray    { background: rgba(255, 255, 255, 0.08); color: var(--fx-text-body);   box-shadow: none; }

    /* ============ ALERTS ============ */
    .ep-alert-error {
        background: rgba(251, 113, 133, 0.08);
        border: 1px solid rgba(251, 113, 133, 0.3);
        border-radius: 0.85rem;
    }
    .ep-alert-success {
        background: rgba(52, 211, 153, 0.08);
        border: 1px solid rgba(52, 211, 153, 0.3);
        border-radius: 0.85rem;
        animation: epEnter 0.5s var(--fx-ease) forwards;
    }

    /* ============ AVATAR / ORBIT RING ============ */
    .ep-avatar-wrap { position: relative; width: 10rem; height: 10rem; }
    .ep-avatar-ring {
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.15), 0 16px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(34, 211, 238, 0.18);
        position: relative; z-index: 2;
        transition: transform 0.4s var(--fx-ease);
    }
    .ep-avatar-ring:hover { transform: scale(1.03); }
    .ep-orbit {
        position: absolute; inset: -12px;
        border-radius: 9999px;
        border: 1.5px dashed rgba(139, 123, 255, 0.5);
        animation: epOrbitSpin 16s linear infinite;
        z-index: 1;
    }
    .ep-orbit::after {
        content: '';
        position: absolute; top: -4px; left: calc(50% - 4px);
        width: 8px; height: 8px; border-radius: 9999px;
        background: var(--fx-violet);
        box-shadow: 0 0 10px 3px rgba(139, 123, 255, 0.8);
    }
    @keyframes epOrbitSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    /* ============ DROPZONE ============ */
    .ep-dropzone {
        border: 2px dashed rgba(125, 211, 252, 0.35);
        border-radius: 0.85rem;
        background: rgba(255, 255, 255, 0.02);
        transition: border-color 0.3s ease, background 0.3s ease, transform 0.3s var(--fx-ease);
        cursor: pointer;
    }
    .ep-dropzone:hover, .ep-dropzone.is-dragover {
        border-color: rgba(125, 211, 252, 0.75);
        background: rgba(34, 211, 238, 0.06);
        transform: translateY(-2px);
    }

    /* ============ FORM FIELDS ============ */
    .ep-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--fx-text-body);
        margin-bottom: 0.5rem;
        letter-spacing: 0.02em;
    }
    .ep-hint {
        font-family: var(--fx-font-mono);
        font-size: 0.7rem;
        color: var(--fx-text-dim);
        margin-top: 0.4rem;
    }
    .ep-error-text {
        color: var(--fx-rose);
        font-size: 0.75rem;
        margin-top: 0.4rem;
    }

    .ep-input, .ep-textarea {
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--fx-line);
        color: var(--fx-text);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-family: var(--fx-font-body);
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }
    .ep-input::placeholder, .ep-textarea::placeholder { color: var(--fx-text-dim); }
    .ep-input:focus, .ep-textarea:focus {
        outline: none;
        border-color: rgba(34, 211, 238, 0.6);
        box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.16);
        background: rgba(255, 255, 255, 0.045);
    }
    .ep-input-error { border-color: rgba(251, 113, 133, 0.6) !important; }
    .ep-input-error:focus { box-shadow: 0 0 0 3px rgba(251, 113, 133, 0.18) !important; }
    .ep-textarea { resize: none; }

    /* ============ BUTTONS ============ */
    .ep-btn-primary {
        background: linear-gradient(135deg, var(--fx-cyan), var(--fx-violet));
        color: #04121c;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(34, 211, 238, 0.25);
        transition: transform 0.3s var(--fx-ease), box-shadow 0.3s ease;
        border-radius: 0.75rem;
    }
    .ep-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(34, 211, 238, 0.35); }

    .ep-btn-emerald {
        background: linear-gradient(135deg, #34d399, #10b981);
        color: #04160f;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(52, 211, 153, 0.25);
        transition: transform 0.3s var(--fx-ease), box-shadow 0.3s ease;
        border-radius: 0.75rem;
    }
    .ep-btn-emerald:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(52, 211, 153, 0.35); }

    .ep-btn-violet {
        background: linear-gradient(135deg, var(--fx-violet), #6d28d9);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 8px 22px rgba(139, 123, 255, 0.25);
        transition: transform 0.3s var(--fx-ease), box-shadow 0.3s ease;
        border-radius: 0.75rem;
    }
    .ep-btn-violet:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(139, 123, 255, 0.35); }

    .ep-btn-ghost {
        background: rgba(255, 255, 255, 0.04);
        border: 2px solid var(--fx-line);
        color: var(--fx-text-body);
        font-weight: 700;
        border-radius: 0.75rem;
        transition: all 0.3s var(--fx-ease);
    }
    .ep-btn-ghost:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(125, 211, 252, 0.4);
        color: var(--fx-text);
    }

    /* ============ SKILL CHIPS ============ */
    .ep-skill-chip {
        background: linear-gradient(150deg, rgba(34, 211, 238, 0.12), rgba(139, 123, 255, 0.12));
        border: 1px solid rgba(139, 123, 255, 0.32);
        color: var(--fx-text);
        transition: transform 0.25s var(--fx-ease), box-shadow 0.25s ease, border-color 0.25s ease;
        animation: epEnter 0.35s var(--fx-ease) forwards;
    }
    .ep-skill-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 123, 255, 0.22);
        border-color: rgba(139, 123, 255, 0.6);
    }
    .ep-skill-chip .remove-skill-btn { color: var(--fx-text-dim); transition: color 0.2s ease, transform 0.2s ease; }
    .ep-skill-chip .remove-skill-btn:hover { color: var(--fx-rose); transform: scale(1.15); }

    /* ============ CHECKBOX ============ */
    .ep-checkbox { accent-color: var(--fx-cyan); width: 1.1rem; height: 1.1rem; }

    /* ============ STICKY SAVE BAR ============ */
    #sticky-save-bar {
        background: rgba(6, 11, 26, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid var(--fx-line);
        box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.4);
    }
    #sticky-save-bar.flex { display: flex !important; }

    @media (prefers-reduced-motion: reduce) {
        .ep-page::after, .ep-enter, .ep-orbit, .ep-alert-success, .ep-skill-chip {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="ep-page min-h-screen pt-20">
    <div class="max-w-4xl mx-auto px-4 pb-16">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="ep-enter">
                <a href="<?php echo e(route('userpage.profile')); ?>" class="ep-link ep-mono inline-flex items-center text-sm uppercase tracking-wide mb-4 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Profile
                </a>
                <h1 class="text-3xl font-bold ep-text-strong">Edit Profile</h1>
                <p class="ep-text-body mt-2">Keep your profile up-to-date to attract mentors and opportunities</p>
            </div>
            <button type="submit" form="profile-form" class="ep-btn-primary ep-enter ep-enter-1 mt-4 md:mt-0 px-8 py-3 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>

        <div class="ep-card ep-enter ep-enter-1 p-8">
            <form id="profile-form" action="<?php echo e(route('userpage.profile-update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <?php if($errors->any()): ?>
                    <div class="ep-alert-error mb-6 p-4">
                        <p class="font-semibold text-rose-300 mb-2">Please fix the following errors:</p>
                        <ul class="text-rose-200 text-sm space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>&bull; <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="ep-alert-success mb-6 p-4">
                        <p class="text-emerald-300"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Profile Picture Section -->
                <div class="ep-subcard-violet mb-8 p-6">
                    <h2 class="text-2xl font-bold ep-text-strong mb-6 flex items-center gap-3">
                        <span class="ep-icon-chip chip-violet"><i class="fas fa-camera"></i></span> Profile Picture
                    </h2>

                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Current Profile Picture -->
                        <div class="flex flex-col items-center">
                            <div class="ep-avatar-wrap">
                                <div class="ep-orbit"></div>
                                <div class="ep-avatar-ring w-40 h-40 bg-white rounded-full overflow-hidden flex items-center justify-center">
                                    <?php if(auth()->user()->profile_image): ?>
                                        <img src="<?php echo e(asset('uploads/profiles/' . auth()->user()->profile_image)); ?>" alt="Profile Picture" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="text-center text-gray-400">
                                            <i class="fas fa-user text-6xl"></i>
                                            <p class="text-sm mt-2">No Photo</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if(auth()->user()->profile_image): ?>
                                <p class="text-xs ep-text-dim mt-3 text-center ep-mono">Current Photo</p>
                            <?php endif; ?>
                        </div>

                        <!-- Upload Section -->
                        <div class="flex-1 w-full">
                            <label class="ep-label">Upload New Photo</label>
                            <input type="file" id="profile-image-input" name="profile_image" accept="image/*"
                                class="hidden"
                                onchange="previewImage(event)">
                            <div class="ep-dropzone p-6 text-center"
                                onclick="document.getElementById('profile-image-input').click()">
                                <i class="fas fa-cloud-upload-alt text-4xl mb-3 block" style="color: var(--fx-cyan-soft);"></i>
                                <p class="ep-text-strong font-semibold">Click to upload or drag and drop</p>
                                <p class="ep-text-dim text-sm mt-2">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            <button type="button" onclick="document.getElementById('profile-image-input').click()"
                                class="ep-btn-violet mt-4 w-full px-4 py-3 flex items-center justify-center gap-2">
                                <i class="fas fa-upload"></i> Choose File to Upload
                            </button>
                            <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ep-error-text"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <!-- Preview -->
                            <div id="image-preview-container" class="mt-6 hidden">
                                <p class="ep-label mb-3">Preview</p>
                                <img id="image-preview" src="" alt="Preview" class="w-40 h-40 object-cover rounded-lg" style="border: 2px solid rgba(139,123,255,0.4); box-shadow: 0 0 20px rgba(139,123,255,0.25);">
                                <button type="button" onclick="clearImagePreview()" class="mt-3 text-sm font-semibold transition" style="color: var(--fx-rose);">
                                    <i class="fas fa-times mr-2"></i> Remove Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold ep-text-strong mb-6 flex items-center gap-3">
                        <span class="ep-icon-chip chip-cyan"><i class="fas fa-user"></i></span> Basic Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="ep-label">Full Name *</label>
                            <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required
                                class="ep-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ep-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ep-error-text"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="ep-label">Email Address *</label>
                            <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required
                                class="ep-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ep-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ep-error-text"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- LRN Number -->
                        <div>
                            <label class="ep-label">LRN Number</label>
                            <input type="text" name="lrn" placeholder="e.g., 123456789012" value="<?php echo e(old('lrn', auth()->user()->lrn ?? '')); ?>"
                                class="ep-input <?php $__errorArgs = ['lrn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ep-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="ep-hint">Learner Reference Number</p>
                            <?php $__errorArgs = ['lrn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ep-error-text"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="ep-label">Location</label>
                            <input type="text" name="location" placeholder="e.g., San Francisco, CA"
                                value="<?php echo e(old('location', auth()->user()->location ?? '')); ?>"
                                class="ep-input">
                        </div>

                        <!-- Headline -->
                        <div>
                            <label class="ep-label">Professional Headline</label>
                            <input type="text" name="headline" placeholder="e.g., Full Stack Developer in Progress"
                                value="<?php echo e(old('headline', auth()->user()->headline ?? '')); ?>"
                                class="ep-input">
                        </div>
                    </div>
                </div>

                <!-- Bio Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold ep-text-strong mb-6 flex items-center gap-3">
                        <span class="ep-icon-chip chip-cyan"><i class="fas fa-pen"></i></span> About You
                    </h2>

                    <div>
                        <label class="ep-label">Bio</label>
                        <textarea name="bio" rows="6" placeholder="Tell us about yourself, your goals, and what you're passionate about..."
                            class="ep-textarea <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> ep-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('bio', auth()->user()->bio ?? '')); ?></textarea>
                        <p class="ep-hint">Maximum 500 characters</p>
                        <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="ep-error-text"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Social Links Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold ep-text-strong mb-6 flex items-center gap-3">
                        <span class="ep-icon-chip chip-violet"><i class="fas fa-share-alt"></i></span> Social Links
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- GitHub -->
                        <div>
                            <label class="ep-label">
                                <i class="fab fa-github mr-2"></i> GitHub
                            </label>
                            <input type="url" name="github_url" placeholder="https://github.com/yourprofile"
                                value="<?php echo e(old('github_url', auth()->user()->github_url ?? '')); ?>"
                                class="ep-input">
                        </div>

                        <!-- Portfolio -->
                        <div>
                            <label class="ep-label">
                                <i class="fas fa-globe mr-2"></i> Portfolio Website
                            </label>
                            <input type="url" name="portfolio_url" placeholder="https://yourportfolio.com"
                                value="<?php echo e(old('portfolio_url', auth()->user()->portfolio_url ?? '')); ?>"
                                class="ep-input">
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold ep-text-strong mb-6 flex items-center gap-3">
                        <span class="ep-icon-chip chip-amber"><i class="fas fa-star"></i></span> Skills
                    </h2>

                    <div>
                        <label class="ep-label mb-3">Add Your Skills</label>
                        <p class="ep-text-dim text-sm mb-3">Type a skill and press Enter or click Add to add it</p>
                        <div class="flex gap-2 mb-4">
                            <input type="text" id="skill-input" placeholder="e.g., JavaScript, React, Node.js"
                                class="ep-input flex-1">
                            <button type="button" onclick="addSkill()" class="ep-btn-primary px-6 py-3">
                                Add
                            </button>
                        </div>

                        <!-- Skills Tags -->
                        <div id="skills-container" class="flex flex-wrap gap-2 mb-4">
                            <?php if(auth()->user()->skills && count(auth()->user()->skills) > 0): ?>
                                <?php $__currentLoopData = auth()->user()->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="ep-skill-chip px-4 py-2 rounded-full flex items-center gap-2 skill-tag">
                                        <span class="skill-name"><?php echo e($skill); ?></span>
                                        <input type="hidden" name="skills[]" value="<?php echo e($skill); ?>">
                                        <button type="button" class="remove-skill-btn" onclick="removeSkillTag(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" id="skills-input" name="skills" value="<?php echo e(auth()->user()->skills ? json_encode(auth()->user()->skills) : '[]'); ?>">
                    </div>
                </div>

                <script>
                    function addSkill() {
                        const input = document.getElementById('skill-input');
                        const skill = input.value.trim();

                        if (skill === '') return;

                        const container = document.getElementById('skills-container');
                        const skillTag = document.createElement('span');
                        skillTag.className = 'ep-skill-chip px-4 py-2 rounded-full flex items-center gap-2 skill-tag';
                        skillTag.innerHTML = `
                            <span class="skill-name">${skill}</span>
                            <button type="button" class="remove-skill-btn" onclick="removeSkillTag(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        `;

                        container.appendChild(skillTag);
                        updateSkillsInput();
                        input.value = '';
                        input.focus();
                    }

                    function removeSkillTag(btn) {
                        btn.closest('.skill-tag').remove();
                        updateSkillsInput();
                    }

                    function updateSkillsInput() {
                        const skills = Array.from(document.querySelectorAll('.skill-name')).map(el => el.textContent);
                        document.getElementById('skills-input').value = JSON.stringify(skills);
                    }

                    // Allow Enter key to add skill
                    document.getElementById('skill-input').addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            addSkill();
                        }
                    });
                </script>

                <!-- Privacy Section -->
                <div class="ep-subcard-gray mb-8 p-6">
                    <h2 class="text-xl font-bold ep-text-strong mb-4 flex items-center gap-3">
                        <span class="ep-icon-chip chip-gray"><i class="fas fa-lock"></i></span> Privacy
                    </h2>

                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="profile_public" value="1"
                                <?php echo e(auth()->user()->profile_public ? 'checked' : ''); ?>

                                class="ep-checkbox rounded">
                            <span class="ml-3 ep-text-body">Make my profile public</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons (bottom of form) -->
                <div class="flex gap-4">
                    <button id="save-btn" type="submit" form="profile-form" class="ep-btn-emerald px-8 py-3">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                    <a href="<?php echo e(route('userpage.profile')); ?>" class="ep-btn-ghost px-8 py-3 inline-flex items-center">
                        Cancel
                    </a>
                </div>
                <!-- sticky bar shown when scrolling -->
                <div id="sticky-save-bar" class="fixed bottom-0 left-0 right-0 p-4 hidden justify-center z-50">
                    <button type="submit" form="profile-form" class="ep-btn-emerald px-8 py-3">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                    <a href="<?php echo e(route('userpage.profile')); ?>" class="ep-btn-ghost ml-4 px-8 py-3 inline-flex items-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('profile-image-input');
        const dropZone = document.querySelector('div[onclick*="profile-image-input"]');

        // Image preview functionality
        window.previewImage = function(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must not exceed 2MB');
                    fileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        };

        window.clearImagePreview = function() {
            fileInput.value = '';
            document.getElementById('image-preview-container').classList.add('hidden');
            document.getElementById('image-preview').src = '';
        };

        // Drag and drop functionality
        if (dropZone) {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop zone when dragging over
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, function() {
                    dropZone.classList.add('is-dragover');
                }, false);
            });

            // Remove highlight when leaving or dropping
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, function() {
                    dropZone.classList.remove('is-dragover');
                }, false);
            });

            // Handle file drop
            dropZone.addEventListener('drop', function(e) {
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    // Trigger the preview manually
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }, false);
        }

        // Allow Enter key to submit form
        document.getElementById('skill-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });

        // sticky save bar behavior
        const form = document.querySelector('form');
        const sticky = document.getElementById('sticky-save-bar');
        let touched = false;
        form.addEventListener('input', () => {
            touched = true;
            sticky.classList.remove('hidden');
            sticky.classList.add('flex');
        });
        window.addEventListener('scroll', () => {
            if (!touched) return;
            const rect = form.getBoundingClientRect();
            if (rect.bottom < window.innerHeight) {
                sticky.classList.add('hidden');
                sticky.classList.remove('flex');
            } else {
                sticky.classList.remove('hidden');
                sticky.classList.add('flex');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Userpage/profile-edit.blade.php ENDPATH**/ ?>