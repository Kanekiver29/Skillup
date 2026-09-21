

<?php $__env->startSection('title', 'Teacher Account'); ?>
<?php $__env->startSection('page_title', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .page-card {
        animation: fadeSlideUp 0.5s ease-out;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .account-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        animation: fadeIn 0.6s ease-out 0.1s both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .account-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1f1f1f, #4a4a4a);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    .account-avatar:hover {
        transform: scale(1.05) rotate(3deg);
    }

    .account-info-grid {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .section-block {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        background: #f8f9fa;
        border: 1px solid #eee;
        opacity: 0;
        animation: fadeSlideUp 0.45s ease-out forwards;
        transition: background 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
    }

    .section-block:nth-child(1) { animation-delay: 0.15s; }
    .section-block:nth-child(2) { animation-delay: 0.25s; }
    .section-block:nth-child(3) { animation-delay: 0.35s; }

    .section-block:hover {
        background: #f0f1f3;
        transform: translateX(4px);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .section-block i {
        width: 20px;
        color: #6b6b6b;
        text-align: center;
    }

    .section-block strong {
        min-width: 60px;
        color: #333;
    }

    .btn-black {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        opacity: 0;
        animation: fadeSlideUp 0.45s ease-out 0.5s forwards;
    }

    .btn-black:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    }

    .btn-black:active {
        transform: translateY(0);
    }

    .btn-black i {
        transition: transform 0.2s ease;
    }

    .btn-black:hover i {
        transform: rotate(-8deg);
    }
</style>

<div class="page-card">
    <div class="account-header">
        <div class="account-avatar">
            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'T', 0, 1))); ?>

        </div>
        <div>
            <h2 data-i18n="teacher_account_settings" style="margin-bottom:0.25rem;">Teacher Account Settings</h2>
            <p data-i18n="manage_teacher_account" style="margin:0; color:#666;">
                Manage your teacher account details and contact information.
            </p>
        </div>
    </div>

    <div class="account-info-grid">
        <div class="section-block">
            <i class="fa-solid fa-user"></i>
            <strong data-i18n="name">Name</strong>: <?php echo e(auth()->user()->name ?? 'Instructor Name'); ?>

        </div>
        <div class="section-block">
            <i class="fa-solid fa-envelope"></i>
            <strong data-i18n="email">Email</strong>: <?php echo e(auth()->user()->email ?? 'teacher@example.com'); ?>

        </div>
        <div class="section-block">
            <i class="fa-solid fa-chalkboard-user"></i>
            <strong data-i18n="role">Role</strong>: <span data-i18n="teacher">Teacher</span>
        </div>
    </div>

    <div style="margin-top:1.5rem;">
        <a href="<?php echo e(route('sias.teacher.account.password')); ?>" class="btn btn-black">
            <i class="fa-solid fa-lock"></i> Change Password
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\account\index.blade.php ENDPATH**/ ?>