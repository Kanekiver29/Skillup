

<?php $__env->startSection('title', 'Student Progress'); ?>
<?php $__env->startSection('page_title', 'Student Progress'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .progress-page { display:grid; gap:1.25rem; }
    .progress-summary { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:1rem; }
    .progress-card, .progress-table-card { background:#fff; border:1px solid #e4eaf7; border-radius:1rem; box-shadow:0 10px 30px rgba(9,20,51,.08); }
    .progress-card { padding:1.1rem 1.2rem; }
    .progress-card span { display:block; color:#64768f; font-size:.78rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
    .progress-card strong { display:block; margin-top:.35rem; color:#0b1730; font-size:1.7rem; }
    .progress-table-card { overflow:hidden; }
    .progress-table-header { padding:1.2rem 1.25rem; border-bottom:1px solid #eef2fb; }
    .progress-table-header h2 { margin:0; color:#0b1730; font-size:1.1rem; }
    .progress-table-header p { margin:.3rem 0 0; color:#64768f; font-size:.85rem; }
    .progress-table-wrap { overflow-x:auto; }
    .progress-table { width:100%; min-width:980px; border-collapse:collapse; }
    .progress-table th, .progress-table td { padding:.9rem 1.25rem; text-align:left; border-bottom:1px solid #eef2fb; }
    .progress-table th { color:#64768f; font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; background:#fbfcff; }
    .progress-table td { color:#33415c; font-size:.88rem; }
    .progress-table td strong { color:#0b1730; }
    .progress-meter { display:flex; align-items:center; gap:.65rem; min-width:150px; }
    .progress-track { flex:1; height:8px; overflow:hidden; border-radius:999px; background:#e4eaf7; }
    .progress-fill { height:100%; border-radius:inherit; background:#3358e0; }
    .progress-value { min-width:42px; color:#0b1730; font-weight:700; }
    .progress-status { display:inline-block; padding:.3rem .55rem; border-radius:999px; background:#eef2ff; color:#3730a3; font-size:.75rem; font-weight:700; }
    .progress-activity { color:#64768f; font-size:.8rem; line-height:1.45; }
    .progress-activity strong { display:block; color:#33415c; font-size:.84rem; }
    .progress-link { color:#3358e0; font-weight:700; text-decoration:none; }
    .progress-link:hover { text-decoration:underline; }
    .progress-empty { padding:2rem 1.25rem; color:#64768f; text-align:center; }
    @media (max-width:800px) { .progress-summary { grid-template-columns:repeat(2, minmax(0, 1fr)); } }
    @media (max-width:480px) { .progress-summary { grid-template-columns:1fr; } }
</style>

<div class="progress-page">
    <div class="progress-summary">
        <div class="progress-card"><span>Students</span><strong><?php echo e($summary['students']); ?></strong></div>
        <div class="progress-card"><span>Courses</span><strong><?php echo e($summary['courses']); ?></strong></div>
        <div class="progress-card"><span>Average Progress</span><strong><?php echo e($summary['average']); ?>%</strong></div>
        <div class="progress-card"><span>Completed</span><strong><?php echo e($summary['completed']); ?></strong></div>
    </div>

    <section class="progress-table-card">
        <div class="progress-table-header">
            <h2>Enrolled Student Progress</h2>
            <p>Monitor progress across the courses assigned to you.</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isNotEmpty()): ?>
            <div class="progress-table-wrap">
                <table class="progress-table">
                    <thead>
                        <tr><th>Student</th><th>Course</th><th>Subject</th><th>Progress</th><th>Lessons</th><th>Activity</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php ($progress = $enrollment->monitoring_progress); ?>
                            <tr>
                                <td><a class="progress-link" href="<?php echo e(route('teacher.students.show', $enrollment->id)); ?>"><?php echo e($enrollment->user?->name ?? 'Unknown student'); ?></a></td>
                                <td><?php echo e($enrollment->course?->title ?? '—'); ?></td>
                                <td><?php echo e($enrollment->subject?->title ?? 'All subjects'); ?></td>
                                <td>
                                    <div class="progress-meter">
                                        <div class="progress-track"><div class="progress-fill" style="width:<?php echo e($progress); ?>%"></div></div>
                                        <span class="progress-value"><?php echo e($progress); ?>%</span>
                                    </div>
                                </td>
                                <td><?php echo e($enrollment->completed_lessons); ?>/<?php echo e($enrollment->total_lessons); ?><br><small><?php echo e($enrollment->quiz_attempts); ?> quiz attempts</small></td>
                                <td class="progress-activity">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->last_activity): ?>
                                        <strong><?php echo e($enrollment->last_activity->diffForHumans()); ?></strong>
                                        <?php echo e($enrollment->last_activity->format('M j, Y g:i A')); ?>

                                    <?php else: ?>
                                        No activity recorded
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><span class="progress-status"><?php echo e($progress >= 100 ? 'Completed' : ucfirst($enrollment->status ?? 'In progress')); ?></span></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="progress-empty">No students are enrolled in your courses yet.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\progress\index.blade.php ENDPATH**/ ?>