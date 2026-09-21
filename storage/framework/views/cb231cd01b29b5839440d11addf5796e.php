

<?php $__env->startSection('title', 'FAQ - SkillUp'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-50 px-4 pb-20 pt-32 text-slate-900">
    <div class="mx-auto max-w-4xl">
        <header class="mb-12 text-center">
            <p class="font-mono text-xs uppercase tracking-[.2em] text-blue-600">SkillUp / Help center</p>
            <h1 class="mt-4 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Frequently asked questions</h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-600">Quick answers about learning, progress, accounts, and certificates.</p>
        </header>

        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                ['How do I start learning?', 'Open Courses, choose a course that fits your goal, and enroll. Your lessons and module progress will then be available from My Learning.'],
                ['Can I learn at my own pace?', 'Yes. Lessons, materials, and quizzes remain available according to each course schedule, so you can return and continue where you left off.'],
                ['How is my progress calculated?', 'Progress is based on completed lessons and modules in your enrolled course. Quiz results also appear in your grades and assessment history.'],
                ['Where can I find my certificates?', 'Open the Student Profile menu and choose Certificates. Completed and unlocked certificates are available there for viewing.'],
                ['What should I do if I cannot access a course?', 'Check that you are signed in and enrolled in the course. If the issue continues, contact the SkillUp support team with the course name and your account email.'],
                ['Can teachers create quizzes and trivia games?', 'Yes. Teachers can create quizzes, assign them to modules, add questions, publish them, and manage results from the teacher quiz manager.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$question, $answer]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <details class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-lg font-bold"><?php echo e($question); ?> <i class="fas fa-plus text-sm text-blue-600 transition group-open:rotate-45"></i></summary>
                    <p class="mt-4 max-w-3xl leading-7 text-slate-600"><?php echo e($answer); ?></p>
                </details>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div class="mt-12 rounded-2xl bg-[#08275f] p-8 text-white sm:flex sm:items-center sm:justify-between sm:gap-8">
            <div>
                <h2 class="font-display text-2xl font-bold">Still need help?</h2>
                <p class="mt-2 text-blue-100">Send us the details and we will help you find the right answer.</p>
            </div>
            <a href="<?php echo e(route('contact')); ?>" class="mt-5 inline-flex shrink-0 items-center rounded-xl bg-white px-5 py-3 font-bold text-[#08275f] transition hover:bg-cyan-50 sm:mt-0">Contact support <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Product\faq.blade.php ENDPATH**/ ?>