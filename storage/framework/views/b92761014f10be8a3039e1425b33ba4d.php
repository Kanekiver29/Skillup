

<?php $__env->startSection('title', 'Student Dashboard'); ?>
<?php $__env->startSection('page_title', 'Student Dashboard'); ?>

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

    .page-card > h2 {
        animation: fadeIn 0.6s ease-out 0.1s both;
    }

    .page-card > p {
        animation: fadeIn 0.6s ease-out 0.15s both;
        color: #666;
        margin-bottom: 1.5rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .dashboard-card {
        position: relative;
        display: block;
        padding: 1.25rem 1.4rem;
        border-radius: 14px;
        background: #f8f9fa;
        border: 1px solid #ececec;
        overflow: hidden;
        opacity: 0;
        animation: fadeSlideUp 0.45s ease-out forwards;
        transition: transform 0.28s ease, box-shadow 0.28s ease, background 0.28s ease, border-color 0.28s ease;
    }

    .dashboard-grid .dashboard-card:nth-child(1) { animation-delay: 0.15s; }
    .dashboard-grid .dashboard-card:nth-child(2) { animation-delay: 0.25s; }
    .dashboard-grid .dashboard-card:nth-child(3) { animation-delay: 0.35s; }
    .dashboard-grid .dashboard-card:nth-child(4) { animation-delay: 0.45s; }

    .dashboard-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1f1f1f;
        transform: scaleY(0);
        transform-origin: top;
        transition: transform 0.28s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
        background: #ffffff;
        border-color: #e0e0e0;
    }

    .dashboard-card:hover::before {
        transform: scaleY(1);
    }

    .dashboard-card-head {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.35rem;
    }

    .dashboard-card-head i {
        width: 20px;
        text-align: center;
        color: #6b6b6b;
        transition: color 0.28s ease, transform 0.28s ease;
    }

    .dashboard-card:hover .dashboard-card-head i {
        color: #1f1f1f;
        transform: scale(1.1);
    }

    .dashboard-card strong {
        font-size: 0.98rem;
        color: #222;
    }

    .dashboard-card > p {
        margin: 0.15rem 0 0;
        font-size: 0.92rem;
        color: #555;
    }

    .dashboard-card ul {
        margin-top: 0.6rem;
        padding-left: 1.1rem;
        font-size: 0.88rem;
        color: #444;
    }

    .dashboard-card ul li {
        margin-bottom: 0.25rem;
    }

    .dashboard-card ul li small {
        color: #888;
    }
</style>

<div class="page-card">
    <h2><span data-i18n="welcome_back">Welcome back</span>, <?php echo e($user->name); ?></h2>
    <p data-i18n="quick_academic_status">Quick view of your current academic status.</p>

    <div class="dashboard-grid">
        <a href="<?php echo e(route('sias.student.subjects')); ?>" class="dashboard-card" style="text-decoration:none;color:inherit;">
            <div class="dashboard-card-head">
                <i class="fa-solid fa-book"></i>
                <strong data-i18n="enrolled_subjects">Enrolled Subjects</strong>
            </div>
            <p><?php echo e($enrolledCount); ?> <span data-i18n="active_enrollments">active enrollment(s)</span></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrolledCount > 0): ?>
                <ul>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($en->course->title ?? 'Course'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($en->status): ?> <small>(<?php echo e($en->status); ?>)</small> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </a>

        <a href="<?php echo e(route('sias.student.attendance')); ?>" class="dashboard-card" style="text-decoration:none;color:inherit;">
            <div class="dashboard-card-head">
                <i class="fa-solid fa-calendar-check"></i>
                <strong data-i18n="attendance_today">Attendance Today</strong>
            </div>
            <p><?php echo e($attendanceToday); ?> <span data-i18n="records_logged">record(s) logged</span></p>
        </a>

        <a href="<?php echo e(route('sias.student.reports')); ?>" class="dashboard-card" style="text-decoration:none;color:inherit;">
            <div class="dashboard-card-head">
                <i class="fa-solid fa-chart-line"></i>
                <strong data-i18n="general_weighted_average">General Weighted Average</strong>
            </div>
            <p><?php echo e($gwa !== null ? $gwa . '%' : __('sias.no_grades_yet')); ?></p>
        </a>

        <a href="<?php echo e(route('sias.student.announcements')); ?>" class="dashboard-card" style="text-decoration:none;color:inherit;">
            <div class="dashboard-card-head">
                <i class="fa-solid fa-bullhorn"></i>
                <strong data-i18n="recent_announcements">Recent Announcements</strong>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($announcements->isEmpty()): ?>
                <p data-i18n="no_announcements">No announcements yet.</p>
            <?php else: ?>
                <ul>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php echo $__env->make('sias.students.dashboard._announcement', ['announcement' => $announcement], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\dashboard\index.blade.php ENDPATH**/ ?>