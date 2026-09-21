<?php $__env->startSection('title', 'Teacher Change Password'); ?>
<?php $__env->startSection('page_title', 'Change Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="max-width:720px">
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.25rem;">
        <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,var(--brass),var(--brass-light));display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-lock" style="color:#fff;font-size:1.1rem;"></i>
        </div>
        <div>
            <h2 style="margin:0;font-family:var(--font-display);font-size:1.4rem;">Change Password</h2>
            <p style="margin:0;font-size:.88rem;color:#7C8AA0;">Update your teacher account password to keep your account secure.</p>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="section-block" style="border-left:4px solid #16a34a;background:#ecfdf5;color:#166534;margin-top:1rem;display:flex;align-items:center;gap:.6rem;">
            <i class="fa-solid fa-circle-check" style="font-size:1.1rem;"></i>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="section-block" style="border-left:4px solid #dc2626;background:#fee2e2;color:#991b1b;margin-top:1rem;">
            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.35rem;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:1rem;"></i>
                <strong style="font-size:.9rem;">Please correct the following errors:</strong>
            </div>
            <ul style="margin:0;padding-left:1.25rem;font-size:.88rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('sias.teacher.account.password.update')); ?>" style="display:grid;gap:1.1rem;margin-top:1.25rem;" id="changePasswordForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.82rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--ink);">
                <i class="fa-solid fa-key" style="margin-right:.3rem;color:var(--brass);font-size:.75rem;"></i>Current Password
            </span>
            <div style="position:relative;">
                <input type="password" name="current_password" required
                       class="form-input" autocomplete="current-password"
                       placeholder="Enter your current password"
                       id="currentPassword"
                       style="width:100%;padding:.75rem 2.8rem .75rem 1rem;border:2px solid var(--border);border-radius:10px;font-size:.95rem;font-family:var(--font-body);transition:border-color .2s var(--ease),box-shadow .2s var(--ease);background:var(--paper);">
                <button type="button" class="toggle-pw" data-target="currentPassword"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--brass);cursor:pointer;padding:4px;font-size:1rem;"
                        aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color:#dc2626;font-size:.8rem;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </label>

        <hr style="border:none;border-top:1px solid var(--border);margin:.15rem 0;">

        
        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.82rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--ink);">
                <i class="fa-solid fa-shield-halved" style="margin-right:.3rem;color:var(--brass);font-size:.75rem;"></i>New Password
            </span>
            <div style="position:relative;">
                <input type="password" name="password" required minlength="8"
                       class="form-input" autocomplete="new-password"
                       placeholder="Minimum 8 characters"
                       id="newPassword"
                       style="width:100%;padding:.75rem 2.8rem .75rem 1rem;border:2px solid var(--border);border-radius:10px;font-size:.95rem;font-family:var(--font-body);transition:border-color .2s var(--ease),box-shadow .2s var(--ease);background:var(--paper);">
                <button type="button" class="toggle-pw" data-target="newPassword"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--brass);cursor:pointer;padding:4px;font-size:1rem;"
                        aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            
            <div id="strengthMeter" style="height:4px;border-radius:4px;background:#e5e7eb;overflow:hidden;margin-top:2px;">
                <div id="strengthBar" style="height:100%;width:0;border-radius:4px;transition:width .3s var(--ease),background .3s var(--ease);"></div>
            </div>
            <span id="strengthText" style="font-size:.78rem;color:#7C8AA0;transition:color .3s;"></span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color:#dc2626;font-size:.8rem;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </label>

        
        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.82rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--ink);">
                <i class="fa-solid fa-check-double" style="margin-right:.3rem;color:var(--brass);font-size:.75rem;"></i>Confirm New Password
            </span>
            <div style="position:relative;">
                <input type="password" name="password_confirmation" required minlength="8"
                       class="form-input" autocomplete="new-password"
                       placeholder="Re-enter your new password"
                       id="confirmPassword"
                       style="width:100%;padding:.75rem 2.8rem .75rem 1rem;border:2px solid var(--border);border-radius:10px;font-size:.95rem;font-family:var(--font-body);transition:border-color .2s var(--ease),box-shadow .2s var(--ease);background:var(--paper);">
                <button type="button" class="toggle-pw" data-target="confirmPassword"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--brass);cursor:pointer;padding:4px;font-size:1rem;"
                        aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <span id="matchText" style="font-size:.78rem;color:#7C8AA0;transition:color .3s;"></span>
        </label>

        
        <div class="section-block" style="background:rgba(176,141,87,.06);border-color:var(--brass-light);padding:14px 16px;">
            <strong style="font-size:.82rem;letter-spacing:.04em;text-transform:uppercase;color:var(--brass);display:flex;align-items:center;gap:.4rem;">
                <i class="fa-solid fa-info-circle"></i> Password Requirements
            </strong>
            <ul style="margin:.5rem 0 0;padding-left:1.2rem;font-size:.85rem;color:#7C8AA0;line-height:1.6;" id="reqList">
                <li id="reqLength"><span>At least 8 characters long</span></li>
                <li id="reqUpper"><span>Contains an uppercase letter</span></li>
                <li id="reqLower"><span>Contains a lowercase letter</span></li>
                <li id="reqNumber"><span>Contains a number</span></li>
            </ul>
        </div>

        
        <div style="display:flex;align-items:center;gap:.75rem;margin-top:.25rem;flex-wrap:wrap;">
            <button type="submit" class="btn btn-black" id="submitBtn">
                <i class="fa-solid fa-floppy-disk"></i> Save New Password
            </button>
            <a href="<?php echo e(route('sias.teacher.account')); ?>" class="btn btn-white">
                <i class="fa-solid fa-arrow-left"></i> Back to Account
            </a>
        </div>
    </form>
</div>

<style>
    /* Focus state for inputs */
    .form-input:focus {
        outline: none;
        border-color: var(--brass) !important;
        box-shadow: 0 0 0 3px rgba(176,141,87,.15) !important;
    }

    /* Dark mode adjustments */
    .dark-mode .form-input {
        background: #0E1728 !important;
        color: #E4E8F0 !important;
        border-color: #1C2A44 !important;
    }
    .dark-mode .form-input:focus {
        border-color: var(--brass) !important;
        box-shadow: 0 0 0 3px rgba(176,141,87,.2) !important;
    }
    .dark-mode .form-input::placeholder {
        color: #4B5975;
    }

    /* Requirement item checked state */
    .req-pass { color: #16a34a !important; }
    .req-pass span { text-decoration: line-through; opacity: .7; }
    .req-fail { color: #7C8AA0 !important; }

    /* Subtle shake on validation error */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-4px); }
        40%, 80% { transform: translateX(4px); }
    }
    .shake { animation: shake .4s var(--ease); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-pw').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = document.getElementById(this.dataset.target);
            var icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Password strength meter
    var newPw = document.getElementById('newPassword');
    var confirmPw = document.getElementById('confirmPassword');
    var strengthBar = document.getElementById('strengthBar');
    var strengthText = document.getElementById('strengthText');
    var matchText = document.getElementById('matchText');
    var reqLength = document.getElementById('reqLength');
    var reqUpper = document.getElementById('reqUpper');
    var reqLower = document.getElementById('reqLower');
    var reqNumber = document.getElementById('reqNumber');

    function checkStrength(pw) {
        var score = 0;
        var hasLength = pw.length >= 8;
        var hasUpper = /[A-Z]/.test(pw);
        var hasLower = /[a-z]/.test(pw);
        var hasNumber = /[0-9]/.test(pw);
        var hasSpecial = /[^A-Za-z0-9]/.test(pw);

        if (hasLength) score++;
        if (hasUpper) score++;
        if (hasLower) score++;
        if (hasNumber) score++;
        if (hasSpecial) score++;
        if (pw.length >= 12) score++;

        // Update requirement indicators
        reqLength.className = hasLength ? 'req-pass' : 'req-fail';
        reqUpper.className = hasUpper ? 'req-pass' : 'req-fail';
        reqLower.className = hasLower ? 'req-pass' : 'req-fail';
        reqNumber.className = hasNumber ? 'req-pass' : 'req-fail';

        return score;
    }

    if (newPw) {
        newPw.addEventListener('input', function() {
            var pw = this.value;
            if (!pw) {
                strengthBar.style.width = '0';
                strengthText.textContent = '';
                reqLength.className = reqUpper.className = reqLower.className = reqNumber.className = 'req-fail';
                checkMatch();
                return;
            }

            var score = checkStrength(pw);
            var pct, color, label;

            if (score <= 2) {
                pct = '25%'; color = '#dc2626'; label = 'Weak';
            } else if (score <= 3) {
                pct = '50%'; color = '#f59e0b'; label = 'Fair';
            } else if (score <= 4) {
                pct = '75%'; color = '#3b82f6'; label = 'Good';
            } else {
                pct = '100%'; color = '#16a34a'; label = 'Strong';
            }

            strengthBar.style.width = pct;
            strengthBar.style.background = color;
            strengthText.textContent = label;
            strengthText.style.color = color;

            checkMatch();
        });
    }

    function checkMatch() {
        if (!confirmPw || !confirmPw.value) {
            matchText.textContent = '';
            return;
        }
        if (newPw.value === confirmPw.value) {
            matchText.textContent = '✓ Passwords match';
            matchText.style.color = '#16a34a';
        } else {
            matchText.textContent = '✗ Passwords do not match';
            matchText.style.color = '#dc2626';
        }
    }

    if (confirmPw) {
        confirmPw.addEventListener('input', checkMatch);
    }

    // Client-side validation before submit
    var form = document.getElementById('changePasswordForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (newPw.value.length < 8) {
                e.preventDefault();
                newPw.focus();
                newPw.parentElement.parentElement.classList.add('shake');
                setTimeout(function() { newPw.parentElement.parentElement.classList.remove('shake'); }, 400);
                return;
            }
            if (newPw.value !== confirmPw.value) {
                e.preventDefault();
                confirmPw.focus();
                matchText.textContent = '✗ Passwords do not match';
                matchText.style.color = '#dc2626';
                confirmPw.parentElement.parentElement.classList.add('shake');
                setTimeout(function() { confirmPw.parentElement.parentElement.classList.remove('shake'); }, 400);
                return;
            }
        });
    }
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\account\password.blade.php ENDPATH**/ ?>