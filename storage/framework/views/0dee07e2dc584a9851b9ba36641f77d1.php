<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History | SkillUp</title>
    <style>
        @page { size: A4 landscape; margin: 14mm; }
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #14203f; font: 12px/1.45 Arial, sans-serif; }
        .print-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .print-toolbar button, .print-toolbar a { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; color: #143b9a; cursor: pointer; text-decoration: none; }
        .brand { color: #0a2461; font-size: 20px; font-weight: 700; }
        .brand small { display: block; margin-top: 2px; color: #64748b; font-size: 11px; font-weight: 400; }
        h1 { margin: 0 0 4px; color: #061a48; font-size: 22px; }
        .meta { margin: 0 0 16px; color: #52617d; }
        .summary { display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; margin-bottom: 18px; }
        .summary-item { padding: 8px 10px; border: 1px solid #dbe3ef; }
        .summary-item span { display: block; color: #64748b; font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .summary-item strong { display: block; margin-top: 2px; color: #0a2461; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 7px 8px; border: 1px solid #cbd5e1; text-align: left; vertical-align: top; }
        th { background: #eef3fc; color: #0a2461; font-size: 10px; text-transform: uppercase; }
        .status { font-weight: 700; }
        .status-present { color: #166534; }
        .status-late { color: #92400e; }
        .status-absent { color: #991b1b; }
        .status-excused { color: #3730a3; }
        .empty { padding: 24px; color: #64748b; text-align: center; }
        footer { display: flex; justify-content: space-between; margin-top: 14px; color: #64748b; font-size: 10px; }
        @media print { .print-toolbar { display: none; } }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <div class="brand">SkillUp<small>Attendance report</small></div>
        <div><button type="button" onclick="window.print()">Print</button> <a href="<?php echo e(route('teacher.attendance.records', request()->query())); ?>">Back to history</a></div>
    </div>

    <h1>Attendance History</h1>
    <p class="meta">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($from || $to): ?> Period: <?php echo e($from ?: 'Beginning'); ?> to <?php echo e($to ?: 'Present'); ?> · <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status): ?> Status: <?php echo e(ucfirst($status)); ?> · <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        Printed <?php echo e(now()->format('d M Y g:i A')); ?>

    </p>

    <div class="summary">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['total' => 'Records', 'present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused', 'rate' => 'Attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="summary-item"><span><?php echo e($label); ?></span><strong><?php echo e($summary[$key]); ?><?php echo e($key === 'rate' ? '%' : ''); ?></strong></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <table>
        <thead><tr><th>Date</th><th>Trainee</th><th>Program</th><th>Status</th><th>Time in</th><th>Time out</th><th>Notes</th></tr></thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($record->attendance_date?->format('d M Y') ?? '—'); ?></td>
                    <td><?php echo e($record->student?->name ?? $record->enrollment?->user?->name ?? 'Unknown trainee'); ?></td>
                    <td><?php echo e($record->course?->title ?? '—'); ?></td>
                    <td class="status status-<?php echo e($record->status); ?>"><?php echo e(ucfirst($record->status)); ?></td>
                    <td><?php echo e($record->time_in?->format('g:i A') ?? '—'); ?></td>
                    <td><?php echo e($record->time_out?->format('g:i A') ?? '—'); ?></td>
                    <td><?php echo e($record->notes ?: '—'); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="7" class="empty">No attendance records found for the selected filters.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
    <footer><span>Generated from the teacher portal</span><span><?php echo e($records->count()); ?> record(s)</span></footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\attendance\print.blade.php ENDPATH**/ ?>