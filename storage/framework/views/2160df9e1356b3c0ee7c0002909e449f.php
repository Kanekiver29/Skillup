

<?php $__env->startSection('title', 'Student Overview'); ?>
<?php $__env->startSection('page_title', 'Student Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="max-width: 1100px; margin: 0 auto; display:grid; gap:1.25rem;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
        <div>
            <h2 style="margin:0 0 .35rem; font-size:1.4rem;"><?php echo e($enrollment->user->name ?? 'Student'); ?></h2>
            <p style="margin:0; color:var(--muted);">
                <?php echo e($enrollment->course->title ?? 'Course'); ?> · <?php echo e($enrollment->status ?? 'Active'); ?>

            </p>
        </div>
        <a href="<?php echo e(route('teacher.students.index')); ?>" class="btn btn-outline" style="text-decoration:none;">Back to students</a>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1rem;">
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Progress</div>
            <div style="font-size:1.7rem; font-weight:700;"><?php echo e((int) ($enrollment->progress ?? 0)); ?>%</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Status</div>
            <div style="font-size:1.1rem; font-weight:700;"><?php echo e($enrollment->status ?? 'Active'); ?></div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Final grade</div>
            <div style="font-size:1.25rem; font-weight:700;"><?php echo e(is_numeric($enrollment->final_grade) ? $enrollment->final_grade.'%' : 'Not graded yet'); ?></div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Email</div>
            <div style="font-size:1rem; font-weight:600;"><?php echo e($enrollment->user->email ?? '—'); ?></div>
        </div>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin-top:0;">Learning snapshot</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">A simple teacher overview for this learner’s current enrollment.</p>
        <ul style="margin:0; padding-left:1.1rem; line-height:1.8;">
            <li>Course: <?php echo e($enrollment->course->title ?? 'Course'); ?></li>
            <li>Student: <?php echo e($enrollment->user->name ?? 'Student'); ?></li>
            <li>Current progress: <?php echo e((int) ($enrollment->progress ?? 0)); ?>%</li>
            <li>Enrollment status: <?php echo e($enrollment->status ?? 'Active'); ?></li>
        </ul>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:.8rem;">
            <div>
                <h3 style="margin:0 0 .25rem;">Activity and progress monitoring</h3>
                <p style="margin:0; color:var(--muted);">Recent learning actions and lesson completion for this enrollment.</p>
            </div>
            <div style="font-size:.85rem; color:var(--muted);">
                <?php echo e($lessonProgress->where('completed', true)->count()); ?> of <?php echo e($lessonProgress->count()); ?> lessons completed
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentActivity->isEmpty()): ?>
            <p style="margin:0; color:var(--muted);">No learning activity has been recorded yet.</p>
        <?php else: ?>
            <div style="display:grid; gap:.55rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="display:flex; align-items:center; gap:.8rem; padding:.75rem; border:1px solid #e4eaf7; border-radius:.7rem; background:#f8fafc;">
                        <span style="width:34px; height:34px; display:grid; place-items:center; border-radius:50%; background:<?php echo e($activity['type'] === 'Quiz' ? '#fff4d6' : '#e7efff'); ?>; color:<?php echo e($activity['type'] === 'Quiz' ? '#a16207' : '#315bd6'); ?>; font-size:.72rem; font-weight:800;"><?php echo e(strtoupper(substr($activity['type'], 0, 1))); ?></span>
                        <div style="min-width:0; flex:1;">
                            <strong style="display:block;"><?php echo e($activity['title']); ?></strong>
                            <span style="color:var(--muted); font-size:.8rem;"><?php echo e($activity['detail']); ?> · <?php echo e($activity['date']->format('M j, Y g:i A')); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity['score'] !== null): ?>
                            <strong style="color:#315bd6;"><?php echo e($activity['score']); ?>%</strong>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Lesson progress</h3>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lessonProgress->isEmpty()): ?>
            <p style="margin:0; color:var(--muted);">No lesson progress records found for this enrollment.</p>
        <?php else: ?>
            <div style="display:grid; gap:.65rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $lessonProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="display:grid; grid-template-columns:minmax(0, 1fr) auto; gap:.7rem; align-items:center;">
                        <div>
                            <strong><?php echo e($lesson->lesson?->title ?? 'Lesson'); ?></strong>
                            <div style="height:7px; margin-top:.35rem; background:#e6ebf5; border-radius:99px; overflow:hidden;">
                                <span style="display:block; width:<?php echo e($lesson->completed ? 100 : 50); ?>%; height:100%; background:<?php echo e($lesson->completed ? '#16a34a' : '#315bd6'); ?>; border-radius:inherit;"></span>
                            </div>
                        </div>
                        <span style="font-size:.82rem; font-weight:800; color:<?php echo e($lesson->completed ? '#15803d' : '#315bd6'); ?>;"><?php echo e($lesson->completed ? 'Completed' : 'In progress'); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Add student grade</h3>
        <form method="POST" action="<?php echo e(route('teacher.grades.store')); ?>" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:.75rem; align-items:end;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="student_id" value="<?php echo e($enrollment->user_id); ?>">
            <input type="hidden" name="course_id" value="<?php echo e($enrollment->course_id); ?>">
            <select name="assessment_type" required style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
                <option value="activity">Activity</option>
                <option value="assignment">Assignment</option>
                <option value="exam" selected>Exam</option>
                <option value="module">Module</option>
            </select>
            <input name="title" required placeholder="Assessment title" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="score" type="number" min="0" step="0.01" required placeholder="Score" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="max_score" type="number" min="0.01" step="0.01" required value="100" placeholder="Max" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="remarks" placeholder="Remarks" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <button type="submit" style="padding:.8rem 1rem;border:0;border-radius:.6rem;background:#315bd6;color:#fff;font-weight:800;">Save grade</button>
        </form>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Existing grades</h3>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gradeRecords->isEmpty()): ?>
            <p style="margin:0; color:var(--muted);">No grades recorded for this student yet.</p>
        <?php else: ?>
            <div style="display:grid; gap:.8rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $gradeRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="border:1px solid #e4eaf7;border-radius:.8rem;padding:.9rem;background:#f8fafc;display:grid;gap:.7rem;">
                        <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;align-items:center;">
                            <div>
                                <strong><?php echo e($grade->title); ?></strong>
                                <div style="color:var(--muted); font-size:.8rem;"><?php echo e(ucfirst($grade->assessment_type)); ?></div>
                            </div>
                            <div style="font-weight:800;color:#315bd6;"><?php echo e($grade->percentage); ?>%</div>
                        </div>
                        <form method="POST" action="<?php echo e(route('teacher.grades.update', $grade)); ?>" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap:.6rem; align-items:end;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <input name="score" type="number" min="0" step="0.01" value="<?php echo e($grade->score); ?>" required style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <input name="max_score" type="number" min="0.01" step="0.01" value="<?php echo e($grade->max_score); ?>" required style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <input name="remarks" value="<?php echo e($grade->remarks); ?>" placeholder="Remarks" style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <button type="submit" style="padding:.65rem .8rem;border:0;border-radius:.5rem;background:#1f2937;color:#fff;font-weight:700;">Update</button>
                        </form>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\students\show.blade.php ENDPATH**/ ?>