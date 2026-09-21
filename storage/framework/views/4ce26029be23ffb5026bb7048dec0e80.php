
<?php $__env->startSection('title', 'Attendance History'); ?>
<?php $__env->startSection('page_title', 'Attendance History'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .history-toolbar { display:flex; align-items:end; gap:.8rem; flex-wrap:wrap; }
    .history-toolbar label { display:grid; gap:.3rem; color:var(--ink-2); font-size:.78rem; font-weight:700; }
    .history-toolbar input, .history-toolbar select { min-height:2.4rem; padding:.5rem .65rem; border:1px solid var(--line); border-radius:var(--r-sm); background:#fff; color:var(--ink); }
    .history-toolbar .history-search { flex:1; min-width:190px; }
    .history-toolbar .history-search input { width:100%; }
    .history-actions { display:flex; gap:.55rem; flex-wrap:wrap; }
    .history-secondary { background:var(--blue-50); color:var(--blue-800); }
    .history-summary { display:grid; grid-template-columns:repeat(6, minmax(90px, 1fr)); gap:.7rem; margin-bottom:1rem; }
    .history-stat { padding:.8rem 1rem; background:#fff; border:1px solid var(--line); border-radius:var(--r-md); }
    .history-stat span { display:block; color:var(--muted); font-size:.7rem; font-weight:800; letter-spacing:.05em; text-transform:uppercase; }
    .history-stat strong { display:block; margin-top:.2rem; color:var(--blue-950); font-size:1.35rem; }
    .status-pill { display:inline-flex; padding:.25rem .5rem; border-radius:999px; font-size:.72rem; font-weight:800; }
    .status-present { background:#dcfce7; color:#166534; }
    .status-late { background:#fef3c7; color:#92400e; }
    .status-absent { background:#fee2e2; color:#991b1b; }
    .status-excused { background:#e0e7ff; color:#3730a3; }
    .history-empty { padding:2.5rem 1rem; text-align:center; color:var(--muted); }
    .history-empty strong { display:block; margin-bottom:.35rem; color:var(--blue-950); font-family:'Newsreader', Georgia, serif; font-size:1.35rem; }
    @media (max-width:700px) { .history-summary { grid-template-columns:repeat(2, 1fr); } }
</style>
<div class="portal-page">
    <div class="portal-heading">
        <div><h2>Attendance History</h2><p>Review attendance records for trainees assigned to your programs.</p></div>
        <div class="history-actions">
            <a class="portal-button history-secondary" href="<?php echo e(route('teacher.attendance.index')); ?>">Record attendance</a>
            <a class="portal-button history-secondary" href="<?php echo e(route('teacher.attendance.print', request()->query())); ?>" target="_blank" rel="noopener">Print</a>
            <a class="portal-button" href="<?php echo e(route('teacher.attendance.export', request()->query())); ?>">Export CSV</a>
        </div>
    </div>

    <form method="GET" action="<?php echo e(route('teacher.attendance.records')); ?>" class="portal-card history-toolbar">
        <label class="history-search">Search trainee<input type="search" name="search" value="<?php echo e($search); ?>" placeholder="Name"></label>
        <label>Program<select name="course_id"><option value="">All programs</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($program->id); ?>" <?php if((string) $courseId === (string) $program->id): echo 'selected'; endif; ?>><?php echo e($program->title); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></label>
        <label>Status<select name="status"><option value="">All statuses</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($value); ?>" <?php if($status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></label>
        <label>From<input type="date" name="from" value="<?php echo e($from); ?>"></label>
        <label>To<input type="date" name="to" value="<?php echo e($to); ?>"></label>
        <div class="history-actions"><button class="portal-button" type="submit">Apply filters</button><a class="portal-button history-secondary" href="<?php echo e(route('teacher.attendance.records')); ?>">Clear</a></div>
    </form>

    <div class="history-summary">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['total' => 'Records', 'present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused', 'rate' => 'Attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="history-stat"><span><?php echo e($label); ?></span><strong><?php echo e($summary[$key]); ?><?php echo e($key === 'rate' ? '%' : ''); ?></strong></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="portal-table-wrap">
        <table class="portal-table">
            <thead><tr><th>Date</th><th>Trainee</th><th>Program</th><th>Status</th><th>Time in</th><th>Time out</th><th>Notes</th></tr></thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($record->attendance_date?->format('d M Y') ?? '—'); ?></td>
                        <td><strong><?php echo e($record->student?->name ?? $record->enrollment?->user?->name ?? 'Unknown trainee'); ?></strong></td>
                        <td><?php echo e($record->course?->title ?? '—'); ?></td>
                        <td><span class="status-pill status-<?php echo e($record->status); ?>"><?php echo e(ucfirst($record->status)); ?></span></td>
                        <td><?php echo e($record->time_in?->format('g:i A') ?? '—'); ?></td>
                        <td><?php echo e($record->time_out?->format('g:i A') ?? '—'); ?></td>
                        <td><?php echo e($record->notes ?: '—'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="7" class="history-empty"><strong>No attendance records found</strong>Try changing the filters or record attendance for an assigned trainee.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\attendance\history.blade.php ENDPATH**/ ?>