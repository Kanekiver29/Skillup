

<?php $__env->startSection('title', 'Quiz Details'); ?>
<?php $__env->startSection('page_title', 'Quiz Details'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">❓ <?php echo e($quiz->title); ?></h1>
            <p style="margin-top:0.45rem; color:#64768f;"><?php echo e($quiz->module?->course?->title ?? 'Course'); ?> / <?php echo e($quiz->module?->title ?? 'Module'); ?></p>
        </div>
        <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
            <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" style="padding:0.7rem 1rem; border-radius:0.8rem; background:#edf2ff; color:#182c63; font-weight:700;">Edit</a>
            <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="padding:0.7rem 1rem; border-radius:0.8rem; background:#f1f5fd; color:#0b1730; border:1px solid #e4eaf7; font-weight:700;">Back</a>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        <p style="color:#33415c; line-height:1.7; margin:0;">
            <?php echo e($quiz->description ?: 'No description provided for this quiz yet.'); ?>

        </p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1.5rem;">
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Passing score</div>
                <div style="font-size:1.4rem; font-weight:800; color:#0b1730; margin-top:0.3rem;"><?php echo e($quiz->passing_score ?? 70); ?>%</div>
            </div>
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Questions</div>
                <div style="font-size:1.4rem; font-weight:800; color:#0b1730; margin-top:0.3rem;"><?php echo e($quiz->questions()->count()); ?></div>
            </div>
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Status</div>
                <div style="font-size:1.1rem; font-weight:800; color:#0b1730; margin-top:0.3rem;"><?php echo e($quiz->is_published ? 'Published' : 'Draft'); ?></div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:.75rem; margin-top:2rem;">
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Participants</small><strong style="display:block; font-size:1.5rem; color:#0b1730;"><?php echo e($participationStats['participants']); ?></strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Attempts</small><strong style="display:block; font-size:1.5rem; color:#0b1730;"><?php echo e($participationStats['attempts']); ?></strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Average score</small><strong style="display:block; font-size:1.5rem; color:#0b1730;"><?php echo e($participationStats['average_score']); ?>%</strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Pass rate</small><strong style="display:block; font-size:1.5rem; color:#0b1730;"><?php echo e($participationStats['pass_rate']); ?>%</strong></div>
        </div>

        <h2 style="margin:2rem 0 .75rem; color:#0b1730;">Leaderboard</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $leaderboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="display:grid; grid-template-columns:3rem 1fr auto auto; gap:.75rem; align-items:center; border-top:1px solid #e4eaf7; padding:.75rem 0; color:#33415c;"><strong style="color:#315bd6;">#<?php echo e($attempt->leaderboard_rank); ?></strong><span><?php echo e($attempt->user?->name ?? 'Student'); ?></span><span><?php echo e($attempt->correct_answers); ?>/<?php echo e($attempt->total_questions); ?></span><strong><?php echo e($attempt->score_percentage); ?>%</strong></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="color:#64768f;">No completed attempts yet.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <h2 style="margin:2rem 0 .75rem; color:#0b1730;">Student scores and answer review</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $attempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <details style="border-top:1px solid #e4eaf7; padding:.85rem 0;">
                <summary style="cursor:pointer; font-weight:800; color:#0b1730;"><?php echo e($attempt->user?->name ?? 'Student'); ?> · <?php echo e($attempt->score_percentage); ?>% · <?php echo e($attempt->passed ? 'Passed' : 'Not passed'); ?></summary>
                <div style="display:grid; gap:.5rem; margin-top:.75rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attempt->responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div style="padding:.7rem .85rem; border-radius:.6rem; background:<?php echo e($response->is_correct ? '#ecfdf5' : '#fff1f2'); ?>; color:<?php echo e($response->is_correct ? '#166534' : '#9f1239'); ?>;">
                            <strong><?php echo e($response->question?->question_text); ?></strong><br>
                            <span><?php echo e($response->is_correct ? 'Correct' : 'Incorrect'); ?>: <?php echo e($response->answer?->answer_text ?? $response->answer_text ?? 'No answer'); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$response->is_correct): ?><br><span>Correct answer: <?php echo e($response->question?->getCorrectAnswer()?->answer_text ?? 'Not available'); ?></span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </details>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="color:#64768f;">Answer reviews will appear after students complete the game.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\quizzes\show.blade.php ENDPATH**/ ?>