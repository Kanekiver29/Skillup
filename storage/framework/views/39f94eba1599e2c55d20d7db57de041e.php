<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Enrollment - <?php echo e($user->name); ?></title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; color: #111827; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e5e7eb; }
        .print-actions { display: flex; justify-content: center; gap: .75rem; padding: 1rem; }
        .print-actions button, .print-actions a { border: 0; border-radius: 6px; padding: .7rem 1rem; font: inherit; text-decoration: none; cursor: pointer; background: #0f766e; color: #fff; }
        .print-actions a { background: #475569; }
        .sheet { width: min(210mm, calc(100% - 2rem)); min-height: 297mm; margin: 0 auto 2rem; padding: 22mm 18mm; background: #fff; }
        header { text-align: center; border-bottom: 2px solid #0f766e; padding-bottom: 1rem; }
        .brand-wrap { display: flex; align-items: center; justify-content: center; gap: 1rem; }
        .brand-logo { width: 150px; height: 150px; object-fit: contain; }
        .brand-logo--small { width: 150px; height: 150px; object-fit: contain; }
        header h1 { margin: 0; color: #115e59; font-size: 1.8rem; text-transform: uppercase; }
        header p { margin: .35rem 0 0; color: #475569; }
        .student { margin: 2rem 0 1.5rem; text-align: center; }
        .student h2 { margin: 0; font-size: 1.8rem; }
        .student p { margin: .35rem 0; color: #475569; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        th, td { border: 1px solid #cbd5e1; padding: .7rem; text-align: left; }
        th { background: #e6fffb; color: #115e59; }
        .signatures { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-top: 5rem; }
        .signature { padding-top: 2rem; border-top: 1px solid #334155; text-align: center; }
        @media print { @page { size: A4 portrait; margin: 12mm; } body { background: #fff; } .print-actions { display: none; } .sheet { width: 210mm; min-height: 297mm; margin: 0; padding: 12mm; } }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Print Certificate</button>
        <a href="<?php echo e(route('sias.admin.students.show', $user->id)); ?>">Back to Student</a>
    </div>
    <main class="sheet">
        <header>
            <div class="brand-wrap">
                <img class="brand-logo" src="<?php echo e(asset('image/logo new.jpg')); ?>" alt="Main Logo">
                <div>
                    <h1>Certificate of Enrollment</h1>
                    <p>ARRI POLYTECHNIC INSTITUTE</p>
                    <p>Issued: <?php echo e(now()->format('F d, Y')); ?></p>
                </div>
                <img class="brand-logo--small" src="<?php echo e(asset('image/hello.png')); ?>" alt="Secondary Logo">
            </div>
        </header>
        <div class="student">
            <p>This certifies that</p>
            <h2><?php echo e($user->name); ?></h2>
            <p>Student ID: <?php echo e($user->lrn ?? $user->id); ?></p>
            <p>is officially enrolled in the following program or subject records:</p>
        </div>
        <table>
            <thead><tr><th>Program</th><th>Subject</th><th>Status</th><th>Enrollment Date</th></tr></thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($enrollment->course?->title ?? '—'); ?></td>
                        <td><?php echo e($enrollment->subject?->title ?? '—'); ?></td>
                        <td><?php echo e(ucfirst($enrollment->status ?? '—')); ?></td>
                        <td><?php echo e(optional($enrollment->enrolled_at ?? $enrollment->enrollment_date)->format('F d, Y') ?? '—'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="4">No enrollment records available.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        <div class="signatures"><div class="signature">Registrar</div><div class="signature">CEO of TESDA</div></div>
    </main>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\students\enrollment-certificate.blade.php ENDPATH**/ ?>