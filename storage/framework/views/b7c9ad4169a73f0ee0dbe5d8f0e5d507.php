

<?php $__env->startSection('title', 'My Certificates - SkillUp'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* ===== Futuristic Design System (Certificates) ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(20px, -30px) scale(1.08); }
    }
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes shimmerSweep {
        0%   { transform: translateX(-120%) skewX(-20deg); }
        100% { transform: translateX(220%) skewX(-20deg); }
    }
    @keyframes sealPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.35); }
        50%      { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
    }
    @keyframes spinSlow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    @keyframes ribbonWave {
        0%, 100% { transform: rotate(-2deg); }
        50%      { transform: rotate(2deg); }
    }

    .cert-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #4c1d95, #6d28d9, #4338ca, #7c3aed);
        background-size: 300% 300%;
        animation: gradientShift 14s ease infinite;
    }
    .cert-hero::before,
    .cert-hero::after {
        content: '';
        position: absolute;
        border-radius: 9999px;
        filter: blur(60px);
        opacity: 0.35;
        pointer-events: none;
        animation: floatOrb 10s ease-in-out infinite;
    }
    .cert-hero::before {
        width: 260px; height: 260px;
        background: #fbbf24;
        top: -60px; left: 8%;
    }
    .cert-hero::after {
        width: 220px; height: 220px;
        background: #38bdf8;
        bottom: -70px; right: 12%;
        animation-delay: 3s;
    }
    .cert-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 36px 36px;
        mask-image: radial-gradient(ellipse at top, black 40%, transparent 80%);
    }

    .fade-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        transition: transform 0.35s cubic-bezier(.2,.8,.2,1), box-shadow 0.35s ease, border-color 0.35s ease;
    }

    /* Certificate card styled like an actual certificate */
    .cert-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(217, 119, 6, 0.15);
    }
    .cert-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 44px -14px rgba(180, 83, 9, 0.28);
        border-color: rgba(251, 191, 36, 0.55);
    }
    .cert-card::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            repeating-linear-gradient(45deg, rgba(217,119,6,0.035) 0, rgba(217,119,6,0.035) 1px, transparent 1px, transparent 14px);
    }
    .cert-card::after {
        content: '';
        position: absolute;
        top: 10px; left: 10px; right: 10px; bottom: 10px;
        border: 1px dashed rgba(217, 119, 6, 0.25);
        border-radius: 1.25rem;
        pointer-events: none;
    }

    .cert-shine {
        position: absolute;
        top: 0;
        left: 0;
        width: 40%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.55), transparent);
        opacity: 0;
        pointer-events: none;
    }
    .cert-card:hover .cert-shine {
        opacity: 1;
        animation: shimmerSweep 1.1s ease;
    }

    .seal {
        animation: sealPulse 2.6s ease-in-out infinite;
    }

    .ribbon {
        animation: ribbonWave 3.5s ease-in-out infinite;
        transform-origin: top center;
    }

    .cta-button {
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(124, 58, 237, 0.45);
    }
    .cta-button.amber:hover {
        box-shadow: 0 12px 24px -8px rgba(217, 119, 6, 0.45);
    }
    .cta-button::after {
        content: '';
        position: absolute;
        top: 0; left: -75%;
        width: 50%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }
    .cta-button:hover::after {
        left: 125%;
    }

    .empty-orb {
        animation: spinSlow 18s linear infinite;
    }

    .badge-pill {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .badge-pill:hover {
        transform: translateY(-2px);
    }

    @media (prefers-reduced-motion: reduce) {
        .cert-hero, .cert-hero::before, .cert-hero::after, .fade-up, .cert-shine,
        .seal, .ribbon, .empty-orb, .cta-button {
            animation: none !important;
            transition: none !important;
        }
    }
</style>


<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:-translate-x-0.5 transition-all">
        <i class="fas fa-arrow-left mr-2"></i> Back
    </a>
</div>

<div class="pt-8 pb-14 cert-hero text-white relative">
    <div class="cert-hero-grid"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 fade-up">
            <div>
                <p class="text-sm text-purple-100/90 mb-2 tracking-wide uppercase flex items-center gap-2">
                    <i class="fas fa-chevron-right text-[10px]" aria-hidden="true"></i>
                    Dashboard / Certificates
                </p>
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight flex items-center gap-3">
                    <i class="fas fa-award text-amber-300 drop-shadow-lg"></i>
                    My Certificates
                </h1>
                <p class="text-purple-100/90 mt-3 max-w-md">View, celebrate, and print your earned certificates for every completed course.</p>
            </div>
            <a href="<?php echo e(route('courses.index')); ?>" class="cta-button inline-flex items-center justify-center bg-white text-purple-700 px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-purple-50">
                <i class="fas fa-book-open mr-2" aria-hidden="true"></i>
                Browse Courses
            </a>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-10">
    <?php if($completedEnrollments->isEmpty()): ?>
        <section class="glass-card rounded-2xl shadow-sm p-10 text-center fade-up relative overflow-hidden">
            <div class="empty-orb absolute -top-10 -right-10 w-40 h-40 rounded-full bg-gradient-to-br from-amber-200 to-purple-200 opacity-40 blur-2xl"></div>
            <div class="mx-auto w-16 h-16 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mb-4 relative z-10 shadow-inner">
                <i class="fas fa-certificate text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2 relative z-10">No certificates yet</h2>
            <p class="text-gray-600 max-w-xl mx-auto mb-6 relative z-10">
                You have not completed any courses yet. Finish a course to unlock your certificate and print it from this page.
            </p>
            <a href="<?php echo e(route('courses.index')); ?>" class="cta-button inline-flex items-center justify-center gradient-primary text-white px-6 py-3 rounded-xl font-semibold shadow-lg relative z-10">
                Explore Courses
                <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
            </a>
        </section>
    <?php else: ?>
        <div class="mb-6 fade-up flex items-center gap-2 text-sm text-gray-500" style="animation-delay: .05s">
            <i class="fas fa-circle-check text-green-500"></i>
            <span><?php echo e($completedEnrollments->count()); ?> <?php echo e($completedEnrollments->count() === 1 ? 'certificate' : 'certificates'); ?> earned</span>
        </div>

        <div class="grid gap-6">
            <?php $__currentLoopData = $completedEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $course = $enrollment->course;
                    $certificateCode = strtoupper('SKILLUP-' . $course->id . '-' . $enrollment->user_id . '-' . ($enrollment->completed_at ? $enrollment->completed_at->format('Ymd') : now()->format('Ymd')));
                ?>
                <article class="cert-card glass-card rounded-3xl shadow-sm overflow-hidden fade-up" style="animation-delay: <?php echo e(0.08 + ($i * 0.07)); ?>s">
                    <div class="cert-shine"></div>
                    <div class="grid gap-6 md:grid-cols-[auto_1fr_auto] items-center p-6 relative z-10">
                        <div class="hidden md:flex flex-col items-center justify-center">
                            <div class="ribbon">
                                <div class="seal w-16 h-16 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg">
                                    <i class="fas fa-award text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                <i class="fas fa-calendar-check text-purple-400"></i>
                                <?php echo e($enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Recently'); ?>

                            </p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($course->title); ?></h2>
                            <p class="text-gray-600 mt-3 flex items-center gap-2 flex-wrap">
                                <span>Certificate ID:</span>
                                <span class="font-mono font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded-md text-sm tracking-wide"><?php echo e($certificateCode); ?></span>
                            </p>
                            <div class="mt-4 flex flex-wrap gap-3 text-sm">
                                <span class="badge-pill inline-flex items-center gap-2 px-3 py-2 rounded-full bg-green-50 text-green-700 font-semibold border border-green-100">
                                    <i class="fas fa-check-circle"></i>
                                    Completed
                                </span>
                                <span class="badge-pill inline-flex items-center gap-2 px-3 py-2 rounded-full bg-blue-50 text-blue-700 font-semibold border border-blue-100">
                                    <i class="fas fa-chart-simple"></i>
                                    <?php echo e($enrollment->progress); ?>% Progress
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a href="<?php echo e(route('certificates.show', $course->slug)); ?>" class="cta-button amber inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold shadow-md">
                                <i class="fas fa-print mr-2"></i>
                                View / Print
                            </a>
                            <a href="<?php echo e(route('courses.show', $course->slug)); ?>" class="cta-button inline-flex items-center justify-center px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-book-open mr-2"></i>
                                Course Page
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/courses/certificates.blade.php ENDPATH**/ ?>