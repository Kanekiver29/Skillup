

<?php $__env->startSection('title', 'How It Works - SkillUp'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-50 text-slate-900">
    <section class="bg-gradient-to-br from-[#06275d] via-[#0d54b8] to-[#1596c5] px-4 pb-20 pt-32 text-white">
        <div class="mx-auto max-w-5xl text-center">
            <p class="mb-4 font-mono text-xs uppercase tracking-[.22em] text-cyan-200">SkillUp / Your next move</p>
            <h1 class="font-display text-4xl font-extrabold tracking-tight sm:text-6xl">Learn with a clear next step.</h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-blue-100">Build momentum through focused courses, practical progress tracking, and credentials you can carry forward.</p>
        </div>
    </section>

    
    <section class="px-4 py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-12 max-w-2xl">
                <p class="font-mono text-xs uppercase tracking-[.18em] text-blue-600">The flow</p>
                <h2 class="mt-3 font-display text-3xl font-bold sm:text-4xl">From TESDA enrollment to your dashboard.</h2>
                <p class="mt-4 leading-7 text-slate-600">You enroll once at the TESDA registration building. From that moment, SkillUp takes over — your course, subjects, teacher, and schedule are set up in the app automatically, so you can start learning the same day.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['01', 'fa-building-columns', 'Enroll at the TESDA registration building', 'Visit the TESDA registration office in person to complete your enrollment — submit requirements, choose your program, and confirm your slot with the registrar.'],
                    ['02', 'fa-mobile-screen-button', 'Open the SkillUp app', 'Once your enrollment is processed, log in to SkillUp using the credentials issued at registration. Your student account is already waiting for you.'],
                    ['03', 'fa-wand-magic-sparkles', 'Everything loads automatically', 'Your course, subjects, assigned teacher, class schedule, and learning materials sync into your dashboard automatically — no manual setup or extra forms needed.'],
                    ['04', 'fa-graduation-cap', 'Start learning right away', 'Jump straight into your modules, track quiz scores and completed lessons, and message your teacher directly through the app.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$number, $icon, $title, $description]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-sm font-bold text-cyan-600"><?php echo e($number); ?></span>
                            <i class="fas <?php echo e($icon); ?> text-lg text-blue-600" aria-hidden="true"></i>
                        </div>
                        <h3 class="mt-8 font-display text-xl font-bold"><?php echo e($title); ?></h3>
                        <p class="mt-3 leading-7 text-slate-600"><?php echo e($description); ?></p>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="border-y border-slate-200 bg-white px-4 py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-12 max-w-2xl">
                <p class="font-mono text-xs uppercase tracking-[.18em] text-blue-600">Auto-provisioned for you</p>
                <h2 class="mt-3 font-display text-3xl font-bold sm:text-4xl">No setup forms. It's already there.</h2>
                <p class="mt-4 leading-7 text-slate-600">The moment your TESDA enrollment is confirmed, SkillUp pulls your registration details into the app and builds your student profile for you.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['fa-book-open', 'Course', 'Your enrolled program is linked to your account, matching exactly what you registered for at TESDA.'],
                    ['fa-layer-group', 'Subjects', 'All subjects under your course load appear in your dashboard, organized by term or module.'],
                    ['fa-chalkboard-user', 'Teacher', 'Your assigned instructor is attached to each subject, so you know exactly who to reach out to.'],
                    ['fa-calendar-check', 'Schedule', 'Class days, times, and deadlines are pulled in automatically, keeping your calendar accurate from day one.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $label, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="rounded-2xl bg-slate-50 p-6">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600/10 text-blue-600">
                            <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
                        </span>
                        <h3 class="mt-5 font-display text-lg font-bold"><?php echo e($label); ?></h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600"><?php echo e($desc); ?></p>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="px-4 py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-12 max-w-2xl">
                <p class="font-mono text-xs uppercase tracking-[.18em] text-blue-600">Once you're in</p>
                <h2 class="mt-3 font-display text-3xl font-bold sm:text-4xl">Four steps from curiosity to capability.</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['01', 'Choose a path', 'Browse courses and select a subject that matches your goals, or continue with the program assigned at enrollment.'],
                    ['02', 'Learn in modules', 'Work through short lessons, materials, and assessments at your pace.'],
                    ['03', 'Track your progress', 'See completed lessons, quiz scores, and the next module waiting for you.'],
                    ['04', 'Show what you know', 'Earn certificates and use your growing skills toward real opportunities.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$number, $title, $description]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <span class="font-mono text-sm font-bold text-cyan-600"><?php echo e($number); ?></span>
                        <h3 class="mt-8 font-display text-xl font-bold"><?php echo e($title); ?></h3>
                        <p class="mt-3 leading-7 text-slate-600"><?php echo e($description); ?></p>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-white px-4 py-16">
        <div class="mx-auto flex max-w-5xl flex-col items-start justify-between gap-8 md:flex-row md:items-center">
            <div>
                <h2 class="font-display text-2xl font-bold">Ready to start your path?</h2>
                <p class="mt-2 text-slate-600">Enroll at the TESDA registration building, then open SkillUp — your first lesson will already be waiting.</p>
            </div>
            <a href="<?php echo e(route('courses.index')); ?>" class="inline-flex items-center rounded-xl bg-blue-600 px-6 py-3 font-bold text-white transition hover:bg-blue-700">Explore courses <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Product\how-it-works.blade.php ENDPATH**/ ?>