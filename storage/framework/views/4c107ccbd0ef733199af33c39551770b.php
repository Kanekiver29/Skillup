

<?php $__env->startSection('title', 'My Certificates - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-indigo-600 font-semibold">Achievements</p>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">My Certificates</h1>
        </div>
        <a href="<?php echo e(route('userpage.dashboard')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completedEnrollments->isEmpty()): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                <i class="fas fa-certificate text-3xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">No certificates yet</h2>
            <p class="mt-2 text-gray-500">Finish a course and complete all modules to unlock your first certificate.</p>
            <a href="<?php echo e(route('courses.index')); ?>" class="mt-5 inline-flex items-center px-5 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                <i class="fas fa-book-open mr-2"></i> Browse Courses
            </a>
        </div>
    <?php else: ?>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $completedEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $course = $enrollment->course;
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course): ?>
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="bg-gradient-to-r from-amber-400 via-yellow-400 to-orange-400 p-4 text-white">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-white/20 px-2.5 py-1 text-xs font-semibold uppercase tracking-wide">Completed</span>
                                <i class="fas fa-certificate text-xl"></i>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-sm text-gray-500">Completed <?php echo e($enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Recently'); ?></p>
                            <h3 class="mt-3 text-xl font-bold text-gray-900"><?php echo e($course->title ?? $course->course_title); ?></h3>
                            <p class="mt-2 text-sm text-gray-600">Certificate of completion for successfully finishing this course.</p>

                            <div class="mt-5 flex flex-wrap gap-3">
                                <a href="<?php echo e(route('certificates.show', $course->slug)); ?>" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-white font-semibold hover:bg-amber-600 transition">
                                    <i class="fas fa-eye mr-2"></i> View
                                </a>
                                <a href="<?php echo e(route('certificates.show', $course->slug)); ?>?print=1" target="_blank" rel="noopener" class="inline-flex items-center px-4 py-2 rounded-lg border border-indigo-200 bg-indigo-50 text-indigo-700 font-semibold hover:bg-indigo-100 transition">
                                    <i class="fas fa-download mr-2"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\courses\certificates.blade.php ENDPATH**/ ?>