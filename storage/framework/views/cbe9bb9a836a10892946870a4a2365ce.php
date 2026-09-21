

<?php $__env->startSection('title', 'Monitoring Class'); ?>
<?php $__env->startSection('page_title', 'Class Monitoring'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2>Monitoring Class</h2>
    <p>Track attendance, performance, and top student scores in real time.</p>

    <div class="dashboard-grid" style="margin-top:24px;">
        <div class="dashboard-card">
            <strong>Active Classes</strong>
            <p class="text-sm text-slate-500"><?php echo e($courses->count()); ?> classes currently assigned to you.</p>
            <div style="margin-top:14px;display:grid;gap:12px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div><span style="font-weight:700;"><?php echo e($course->title); ?></span> — <?php echo e($course->enrollments_count); ?> students</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div>No classes assigned.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div class="dashboard-card">
            <strong>Attendance Summary</strong>
            <p class="text-sm text-slate-500">Last 7 days attendance trend.</p>
            <div style="margin-top:14px;display:grid;gap:10px;">
                <div><strong>Present:</strong> <?php echo e($attendanceSummary['present']); ?></div>
                <div><strong>Absent:</strong> <?php echo e($attendanceSummary['absent']); ?></div>
                <div><strong>Late:</strong> <?php echo e($attendanceSummary['late']); ?></div>
                <div><strong>Rate:</strong> <?php echo e($attendanceSummary['rate']); ?>%</div>
            </div>
        </div>
        <div class="dashboard-card">
            <strong>Top Students</strong>
            <p class="text-sm text-slate-500">Highest average grades across your classes.</p>
            <ol style="margin-top:14px;padding-left:18px;line-height:1.7;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($student['name']); ?> — <?php echo e($student['grade']); ?>%</li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <li>No grade records available yet.</li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ol>
        </div>
    </div>

    <div class="section-block" style="margin-top:24px;overflow-x:auto;">
        <h3 style="margin-bottom:14px;font-size:1.05rem;font-weight:700;">Class performance</h3>
        <table style="width:100%;border-collapse:collapse;min-width:640px;">
            <thead>
                <tr style="text-align:left;color:#0f172a;">
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Class</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Avg Grade</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Students</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Trend</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courseGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:14px 12px;"><?php echo e($course['title']); ?></td>
                        <td style="padding:14px 12px;"><?php echo e($course['avg_grade']); ?>%</td>
                        <td style="padding:14px 12px;"><?php echo e($course['students']); ?></td>
                        <td style="padding:14px 12px;"><?php echo e($course['avg_grade'] >= 75 ? 'Good' : 'Improving'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="section-block" style="margin-top:24px;">
        <h3 style="margin-bottom:14px;font-size:1.05rem;font-weight:700;">Attendance trend</h3>
        <canvas id="attendanceTrendChart" width="840" height="320"></canvas>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trendData = <?php echo json_encode(array_map(fn($item) => $item['present'], $attendanceSummary['trend']), 512) ?>;
        const trendLabels = <?php echo json_encode(array_map(fn($item) => $item['day'], $attendanceSummary['trend']), 512) ?>;
        const ctx = document.getElementById('attendanceTrendChart');

        if (ctx && trendData.length) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Present students',
                        data: trendData,
                        borderColor: '#3751ff',
                        backgroundColor: 'rgba(55,81,255,0.16)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3751ff',
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#475569' } },
                        y: { beginAtZero: true, ticks: { color: '#475569' }, grid: { color: 'rgba(148,163,184,0.2)' } }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\monitoring-class.blade.php ENDPATH**/ ?>