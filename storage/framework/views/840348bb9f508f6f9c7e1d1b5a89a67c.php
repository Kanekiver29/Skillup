<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Registration - <?php echo e($user->name); ?></title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; color: #111827; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e5e7eb; }
        .print-actions { display: flex; justify-content: center; gap: .75rem; padding: 1rem; }
        .print-actions button, .print-actions a { border: 0; border-radius: 6px; padding: .7rem 1rem; font: inherit; text-decoration: none; cursor: pointer; background: #0f766e; color: #fff; }
        .print-actions a { background: #475569; }
        .sheet { width: min(210mm, calc(100% - 2rem)); min-height: 297mm; margin: 0 auto 2rem; padding: 18mm; background: #fff; }
        .header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #0f766e; }
        .brand-wrap { display: flex; align-items: center; gap: 1rem; }
        .brand-logo { width: 88px; height: 88px; object-fit: contain; }
        .header h1 { margin: 0; font-size: 1.4rem; text-transform: uppercase; letter-spacing: .04em; }
        .header p { margin: .25rem 0 0; color: #475569; font-size: .85rem; }
        .photo { width: 92px; height: 112px; object-fit: cover; border: 1px solid #94a3b8; }
        .photo-placeholder { display: grid; place-items: center; color: #64748b; font-size: .75rem; text-align: center; }
        .section { margin-top: 1.2rem; }
        .section h2 { margin: 0 0 .55rem; padding: .45rem .6rem; background: #e6fffb; color: #115e59; font-size: .95rem; text-transform: uppercase; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .45rem 1rem; }
        .item { border-bottom: 1px solid #e2e8f0; padding: .35rem 0; min-width: 0; }
        .label { display: block; color: #64748b; font-size: .72rem; text-transform: uppercase; }
        .value { display: block; min-height: 1.1rem; font-size: .9rem; overflow-wrap: anywhere; }
        .footer { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #cbd5e1; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 2rem; font-size: .8rem; color: #475569; }
        .signature { width: 100%; padding-top: 2rem; border-top: 1px solid #334155; text-align: center; }
        @media (max-width: 650px) { .sheet { width: calc(100% - 1rem); padding: 1rem; } .grid { grid-template-columns: 1fr; } .header { align-items: flex-start; } }
        @media print {
            @page { size: A4 portrait; margin: 12mm; }
            body { background: #fff; }
            .print-actions { display: none; }
            .sheet { width: 210mm; min-height: 297mm; margin: 0; padding: 12mm; }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Print Registration</button>
        <a href="<?php echo e(route('sias.admin.students.index')); ?>">Back to Students</a>
    </div>

    <main class="sheet">
        <header class="header">
            <div class="brand-wrap">
                <img class="brand-logo" src="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" alt="SkillUp Logo">
                <div>
                    <h1>Registered Learner</h1>
                    <p>ARRI POLYTECHNIC INSTITUTE</p>
                    <p>Official Registration Record</p>
                    <p>Printed: <?php echo e(now()->format('F d, Y h:i A')); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile_image): ?>
                <img class="photo" src="<?php echo e(asset('uploads/profiles/' . $user->profile_image)); ?>" alt="Profile photo">
            <?php else: ?>
                <div class="photo photo-placeholder">No profile photo</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </header>

        <section class="section">
            <h2>1. Learner Identification</h2>
            <div class="grid">
                <div class="item"><span class="label">ULI / Learner ID</span><span class="value"><?php echo e($user->lrn ?? '—'); ?></span></div>
                <div class="item"><span class="label">Entry Date</span><span class="value"><?php echo e($registration['entry_date'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Account Username</span><span class="value"><?php echo e($registration['username'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Account Email</span><span class="value"><?php echo e($user->email ?? '—'); ?></span></div>
            </div>
        </section>

        <section class="section">
            <h2>2. Personal Information</h2>
            <div class="grid">
                <div class="item"><span class="label">Name</span><span class="value"><?php echo e($user->name); ?></span></div>
                <div class="item"><span class="label">Birthdate</span><span class="value"><?php echo e($registration['birthdate'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Sex</span><span class="value"><?php echo e($registration['sex'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Civil Status</span><span class="value"><?php echo e($registration['civil_status'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Nationality</span><span class="value"><?php echo e($registration['nationality'] ?? '—'); ?></span></div>
            </div>
        </section>

        <section class="section">
            <h2>3. Contact &amp; Address</h2>
            <div class="grid">
                <div class="item"><span class="label">Email</span><span class="value"><?php echo e($user->email); ?></span></div>
                <div class="item"><span class="label">Contact Number</span><span class="value"><?php echo e($registration['contact_number'] ?? '—'); ?></span></div>
                <div class="item"><span class="label">Complete Address</span><span class="value"><?php echo e($registration['complete_address'] ?? '—'); ?></span></div>
            </div>
        </section>

        <section class="section">
            <h2>4. Education &amp; Employment</h2>
            <div class="grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['educational_attainment' => 'Educational Attainment', 'school' => 'School', 'year_graduated' => 'Year Graduated', 'employment_status' => 'Employment Status', 'employment_type' => 'Employment Type', 'occupation' => 'Occupation']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="item"><span class="label"><?php echo e($label); ?></span><span class="value"><?php echo e($registration[$key] ?? '—'); ?></span></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </section>

        <section class="section">
            <h2>5. Parent / Guardian</h2>
            <div class="grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['guardian_name' => 'Name', 'guardian_relationship' => 'Relationship', 'guardian_contact' => 'Contact Number', 'guardian_address' => 'Address']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="item"><span class="label"><?php echo e($label); ?></span><span class="value"><?php echo e($registration[$key] ?? '—'); ?></span></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </section>

        <section class="section">
            <h2>6. TESDA Training</h2>
            <div class="grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['qualification' => 'Qualification', 'training_program' => 'Training Program', 'training_center' => 'Training Center', 'training_batch' => 'Batch', 'training_schedule' => 'Schedule', 'training_mode' => 'Training Mode']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="item"><span class="label"><?php echo e($label); ?></span><span class="value"><?php echo e($registration[$key] ?? '—'); ?></span></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment): ?>
            <section class="section">
                <h2>7. Enrollment</h2>
                <div class="grid">
                    <div class="item"><span class="label">Course / Qualification</span><span class="value"><?php echo e($enrollment->course?->title ?? '—'); ?></span></div>
                    <div class="item"><span class="label">Enrollment Status</span><span class="value"><?php echo e(ucfirst($enrollment->status ?? '—')); ?></span></div>
                    <div class="item"><span class="label">Enrollment Date</span><span class="value"><?php echo e(optional($enrollment->enrolled_at)->format('F d, Y') ?? '—'); ?></span></div>
                    <div class="item"><span class="label">Unit of Competency</span><span class="value"><?php echo e($enrollment->subject?->title ?? '—'); ?></span></div>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <section class="section">
            <h2>8. Classification &amp; Documents</h2>
            <div class="grid">
                <div class="item"><span class="label">Classification</span><span class="value"><?php echo e(implode(', ', $registration['learner_classification'] ?? []) ?: '—'); ?></span></div>
                <div class="item"><span class="label">Documents Submitted</span><span class="value"><?php echo e(implode(', ', $registration['documents'] ?? []) ?: '—'); ?></span></div>
            </div>
        </section>

        <div class="footer">
            <div class="signature">Registrar</div>
            <div class="signature">CEO of TESDA</div>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\students\print.blade.php ENDPATH**/ ?>