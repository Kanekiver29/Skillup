

<?php $__env->startSection('title', 'My Learning - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-semibold">Learning space</p>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">My Learning</h1>
            <p class="mt-2 text-gray-600">Continue your enrolled courses and track your progress.</p>
        </div>
        <a href="<?php echo e(route('courses.index')); ?>" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white transition hover:bg-blue-700">
            <i class="fas fa-book-open mr-2"></i> Browse courses
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800" role="status"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isEmpty()): ?>
        <section class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">No enrolled courses yet</h2>
            <p class="mt-2 text-gray-600">Browse the course catalog to start your learning journey.</p>
            <a href="<?php echo e(route('courses.index')); ?>" class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">
                Browse courses <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </section>
    <?php else: ?>
        <?php
            $completed = $enrollments->where('completed', true)->count();
            $inProgress = $enrollments->where('completed', false)->where('progress', '>', 0)->count();
            $averageProgress = round($enrollments->avg('progress') ?? 0);
        ?>

        <div class="mb-6 grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Enrolled courses</p><strong class="mt-1 block text-2xl text-gray-900"><?php echo e($enrollments->count()); ?></strong></div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">In progress</p><strong class="mt-1 block text-2xl text-gray-900"><?php echo e($inProgress); ?></strong></div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Average progress</p><strong class="mt-1 block text-2xl text-gray-900"><?php echo e($averageProgress); ?>%</strong></div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $course = $enrollment->course;
                    $progress = max(0, min(100, (int) ($enrollment->progress ?? 0)));
                ?>
                <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900"><?php echo e($course?->title ?? $course?->course_title ?? 'Untitled course'); ?></h2>
                            <p class="mt-1 text-sm text-gray-500"><?php echo e(ucfirst($enrollment->status ?? 'enrolled')); ?></p>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700"><?php echo e($progress); ?>%</span>
                    </div>
                    <div class="mt-5 h-2 overflow-hidden rounded-full bg-gray-100" role="progressbar" aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full rounded-full bg-blue-600" style="width:<?php echo e($progress); ?>%"></div>
                    </div>
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                        <span class="text-sm text-gray-500"><?php echo e($enrollment->completed ? 'Completed' : 'Keep learning'); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course?->slug): ?>
                            <a href="<?php echo e(route('courses.show', $course->slug)); ?>" class="font-semibold text-blue-600 hover:text-blue-800">Open course <i class="fas fa-arrow-right ml-1"></i></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\courses\my-learning.blade.php ENDPATH**/ ?>