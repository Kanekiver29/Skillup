

<?php $__env->startSection('title', 'Trivia Games by Module'); ?>
<?php $__env->startSection('page_title', 'Trivia Games by Module'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:1200px;margin:0 auto;padding:2rem 1.25rem 3rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:2rem;font-weight:800;margin:0;color:#0b1730;">Trivia Games by Module</h1>
            <p style="margin:.45rem 0 0;color:#64768f;">Create and manage the trivia challenges attached to each module.</p>
        </div>
        <div style="display:flex;gap:.6rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="padding:.7rem 1rem;border-radius:.8rem;background:#f1f5fd;color:#0b1730;border:1px solid #e4eaf7;font-weight:700;">Back to Quizzes</a>
            <a href="<?php echo e(route('teacher.quizzes.create', ['is_trivia' => 1])); ?>" style="padding:.7rem 1rem;border-radius:.8rem;background:#15803d;color:#fff;font-weight:700;">+ New Trivia Game</a>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modules->isEmpty()): ?>
        <div style="background:#fff;border:1px solid #e4eaf7;border-radius:1.25rem;padding:3rem 1.5rem;text-align:center;box-shadow:0 10px 30px -12px rgba(9,20,51,.14);">
            <h2 style="margin:0 0 .5rem;color:#0b1730;">No trivia games yet</h2>
            <p style="margin:0 0 1.25rem;color:#64768f;">Create a trivia game and assign it to one of your course modules.</p>
            <a href="<?php echo e(route('teacher.quizzes.create', ['is_trivia' => 1])); ?>" style="display:inline-flex;padding:.75rem 1.1rem;border-radius:.75rem;background:#3358e0;color:#fff;font-weight:800;">Create Trivia Game</a>
        </div>
    <?php else: ?>
        <div style="display:grid;gap:1rem;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <section style="background:#fff;border:1px solid #e4eaf7;border-radius:1.1rem;padding:1.25rem;box-shadow:0 10px 30px -12px rgba(9,20,51,.12);">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
                        <div>
                            <p style="margin:0 0 .25rem;color:#64768f;font-size:.8rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;"><?php echo e($module->course?->title ?? 'Course'); ?></p>
                            <h2 style="margin:0;color:#0b1730;font-size:1.25rem;font-weight:800;"><?php echo e($module->title); ?></h2>
                        </div>
                        <a href="<?php echo e(route('teacher.quizzes.create', ['module_id' => $module->id, 'is_trivia' => 1])); ?>" style="padding:.6rem .9rem;border-radius:.7rem;background:#e8fff3;color:#15803d;border:1px solid #b9f2d0;font-weight:700;">+ Add to Module</a>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:.75rem;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $module->quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <article style="border:1px solid #e4eaf7;border-left:4px solid #f26b5e;border-radius:.8rem;padding:1rem;background:#fbfcff;">
                                <div style="display:flex;justify-content:space-between;gap:.75rem;align-items:flex-start;">
                                    <h3 style="margin:0;color:#0b1730;font-size:1rem;"><?php echo e($quiz->title); ?></h3>
                                    <span style="font-size:.72rem;font-weight:800;color:<?php echo e($quiz->is_published ? '#15803d' : '#b45309'); ?>;"><?php echo e($quiz->is_published ? 'Published' : 'Draft'); ?></span>
                                </div>
                                <p style="margin:.65rem 0;color:#64768f;font-size:.85rem;"><?php echo e($quiz->questions_count); ?> questions · <?php echo e(ucfirst($quiz->difficulty ?: 'Mixed')); ?></p>
                                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                                    <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" style="padding:.45rem .7rem;border-radius:.6rem;background:#edf2ff;color:#182c63;font-size:.82rem;font-weight:700;">Edit</a>
                                    <a href="<?php echo e(route('teacher.quizzes.show', $quiz->id)); ?>" style="padding:.45rem .7rem;border-radius:.6rem;background:#f1f5fd;color:#33415c;font-size:.82rem;font-weight:700;">Results</a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quiz->is_published && $quiz->slug && $module->course?->slug && $module->slug): ?>
                                        <a href="<?php echo e(route('quizzes.start', [$module->course->slug, $module->slug, $quiz->slug])); ?>" target="_blank" style="padding:.45rem .7rem;border-radius:.6rem;background:#e8fff3;color:#15803d;font-size:.82rem;font-weight:700;">Preview</a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </article>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </section>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\quizzes\trivia.blade.php ENDPATH**/ ?>