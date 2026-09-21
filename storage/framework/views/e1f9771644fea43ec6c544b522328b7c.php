

<?php $__env->startSection('title', 'Learning History - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-6">
        <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
            Your Learning History
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Track your progress, review completed courses, and celebrate your achievements.
        </p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-3xl text-purple-600 mb-2"><i class="fas fa-book"></i></div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo e($totalEnrollments); ?></h3>
            <p class="text-gray-600">Total Enrollments</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-3xl text-green-600 mb-2"><i class="fas fa-trophy"></i></div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo e($completedCourses); ?></h3>
            <p class="text-gray-600">Completed Courses</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-3xl text-blue-600 mb-2"><i class="fas fa-tasks"></i></div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo e($totalQuizzes); ?></h3>
            <p class="text-gray-600">Quizzes Taken</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="text-3xl text-orange-600 mb-2"><i class="fas fa-clock"></i></div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo e(number_format($totalHours, 1)); ?>h</h3>
            <p class="text-gray-600">Total Learning Time</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Enrollments History -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-2 h-10 bg-purple-500 rounded-full mr-4"></div>
                <h2 class="text-2xl font-bold text-gray-900">Course Enrollments</h2>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isEmpty()): ?>
                <div class="text-center py-12">
                    <div class="text-6xl text-gray-300 mb-4"><i class="fas fa-book-open"></i></div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No enrollments yet</h3>
                    <p class="text-gray-500 mb-6">Start your learning journey by enrolling in a course.</p>
                    <a href="/courses" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                        Browse Courses
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-shrink-0w-12 h-12 bg-gradient-to-brfrom-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                <?php echo e($enrollment->course->course_title[0] ?? 'C'); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 truncate"><?php echo e($enrollment->course->course_title); ?></h4>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                    <span>Enrolled: <?php echo e($enrollment->created_at->format('M d, Y')); ?></span>
                                    <span>Progress: <?php echo e($enrollment->progress); ?>%</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->completed): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Completed</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">In Progress</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-2 rounded-full" style="width: <?php echo e($enrollment->progress); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Quiz Attempts History -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-2 h-10 bg-green-500 rounded-full mr-4"></div>
                <h2 class="text-2xl font-bold text-gray-900">Quiz Results</h2>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quizAttempts->isEmpty()): ?>
                <div class="text-center py-12">
                    <div class="text-6xl text-gray-300 mb-4"><i class="fas fa-clipboard-question"></i></div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No quiz attempts yet</h3>
                    <p class="text-gray-500 mb-6">Complete some quizzes to see your results here.</p>
                    <a href="/courses" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Start Learning
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $quizAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-shrink-0w-12 h-12 bg-gradient-to-brfrom-green-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                <?php echo e($attempt->quiz->quiz_title[0] ?? 'Q'); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 truncate"><?php echo e($attempt->quiz->quiz_title); ?></h4>
                                <div class="flex items-center justify-between text-sm text-gray-600 mt-1">
                                    <span><?php echo e($attempt->created_at->format('M d, Y H:i')); ?></span>
                                    <span class="font-semibold text-lg">
                                        <?php echo e(number_format($attempt->score, 1)); ?>%
                                    </span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attempt->quiz->module && $attempt->quiz->module->course): ?>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php echo e($attempt->quiz->module->course->course_title); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mt-12">
        <a href="<?php echo e(route('userpage.dashboard')); ?>" class="inline-flex items-center px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-900 transition mr-4">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
        <a href="/courses" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
            Continue Learning
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\history\history.blade.php ENDPATH**/ ?>