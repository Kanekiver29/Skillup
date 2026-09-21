

<?php $__env->startSection('title', 'Lessons'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-950 py-8 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 rounded-3xl border border-slate-700/70 bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30 backdrop-blur-xl">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <p class="text-sm uppercase tracking-[0.35em] text-cyan-400">Staff lessons</p>
                    <h1 class="mt-3 text-4xl font-semibold text-white">Manage your lesson library</h1>
                    <p class="mt-3 max-w-2xl text-sm text-slate-400">Create, update, and track all lesson assets assigned to your course modules.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('staff.lessons.create')); ?>" class="inline-flex items-center gap-2 rounded-2xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-400">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        New lesson
                    </a>
                    <a href="<?php echo e(route('staff.lessons.archived')); ?>" class="inline-flex items-center gap-2 rounded-2xl border border-slate-700 bg-slate-800 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:border-cyan-400 hover:text-white">
                        <i class="fas fa-box-archive" aria-hidden="true"></i>
                        Archived lessons
                    </a>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mb-6 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-100 shadow-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="overflow-hidden rounded-[28px] border border-slate-700 bg-slate-900/90 shadow-xl shadow-slate-950/20">
            <div class="border-b border-slate-700/70 bg-slate-950/60 px-6 py-5 backdrop-blur-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-100">Active lessons</h2>
                        <p class="mt-1 text-sm text-slate-500">All lessons that are currently available for staff management.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-slate-700 bg-slate-900/70 px-4 py-2 text-sm font-semibold text-slate-300">
                        <?php echo e($lessons->count()); ?> lessons
                    </span>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lessons->isEmpty()): ?>
                <div class="px-6 py-16 text-center text-slate-400">
                    <p class="text-xl font-semibold text-slate-100">No lessons created yet</p>
                    <p class="mt-3 max-w-2xl mx-auto text-sm text-slate-500">Use the button above to add your first lesson and attach it to a module.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-300">
                        <thead class="border-b border-slate-700/70 bg-slate-950/80 text-slate-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">Lesson</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">Course</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">Module</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">Order</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">Updated</th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-900/80">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-slate-950/80 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-2xl bg-cyan-500/10 text-cyan-300 flex items-center justify-center">
                                                <i class="fas fa-book-open" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white"><?php echo e($lesson->title); ?></p>
                                                <p class="text-xs text-slate-500"><?php echo e(Str::limit($lesson->description, 50)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300"><?php echo e($lesson->course?->title ?? 'N/A'); ?></td>
                                    <td class="px-6 py-4 text-slate-300"><?php echo e($lesson->module?->title ?? 'N/A'); ?></td>
                                    <td class="px-6 py-4 text-slate-300"><?php echo e($lesson->order); ?></td>
                                    <td class="px-6 py-4 text-slate-300"><?php echo e($lesson->updated_at->format('M d, Y')); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?php echo e(route('staff.lessons.edit', $lesson)); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-950/80 px-4 py-2 text-xs font-semibold text-slate-100 transition hover:border-cyan-400 hover:text-cyan-300">
                                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\lessons\list.blade.php ENDPATH**/ ?>