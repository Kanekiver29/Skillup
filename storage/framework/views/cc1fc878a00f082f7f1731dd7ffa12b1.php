

<?php $__env->startSection('title', 'About SkillUp - Personalized Web Learning for Youth Career Development'); ?>
<?php $__env->startSection('content'); ?>

<style>
    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --bg: #f3f5fb;
        --text: #101b2e;
        --text-muted: #5b6b85;
        --card-bg: #ffffff;
        --card-border: rgba(16, 27, 46, .06);
        --card-shadow: 0 24px 48px -18px rgba(16, 27, 46, .18), 0 2px 8px rgba(16, 27, 46, .05);
        --accent: #c9973b;
        --accent-strong: #e0b054;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    html.dark-mode {
        --bg: #070a13;
        --text: #e7ebf5;
        --text-muted: #8b96b4;
        --card-bg: #0e1526;
        --card-border: rgba(255, 255, 255, .06);
        --card-shadow: 0 24px 48px -18px rgba(0, 0, 0, .6), 0 2px 8px rgba(0, 0, 0, .3);
        --accent: #e0b054;
        --accent-strong: #f0c476;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        margin-bottom: 40px;
        animation: fadeInDown .6s var(--ease) both;
    }

    .page-header h1 {
        font-size: 2.2rem;
        margin: 0 0 8px;
        color: var(--text);
        font-weight: 700;
    }

    .breadcrumb {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.95rem;
    }

    .breadcrumb a {
        color: var(--accent-strong);
        text-decoration: none;
        font-weight: 600;
        transition: color .2s var(--ease);
    }

    .breadcrumb a:hover {
        color: var(--accent);
    }

    .grade-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .summary-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 28px;
        box-shadow: var(--card-shadow);
        animation: fadeInUp .5s var(--ease) both;
        transition: all .3s var(--ease);
    }

    .summary-card:nth-child(1) { animation-delay: 0.1s; }
    .summary-card:nth-child(2) { animation-delay: 0.2s; }
    .summary-card:nth-child(3) { animation-delay: 0.3s; }

    .summary-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(224, 176, 84, 0.15);
    }

    .grade-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .grade-value {
        font-size: 2.4rem;
        font-weight: 800;
        margin: 0 0 12px;
        background: linear-gradient(135deg, var(--accent), var(--accent-strong));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .grade-description {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .grades-table-wrapper {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 28px;
        box-shadow: var(--card-shadow);
        animation: fadeInUp .5s var(--ease) both;
        animation-delay: 0.4s;
        overflow-x: auto;
    }

    .grades-table-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0 0 24px;
        color: var(--text);
    }

    .grades-table {
        width: 100%;
        border-collapse: collapse;
    }

    .grades-table thead {
        background: linear-gradient(135deg, rgba(224, 176, 84, 0.08), rgba(224, 176, 84, 0.04));
    }

    .grades-table th {
        text-align: left;
        padding: 16px;
        border-bottom: 2px solid var(--card-border);
        color: var(--text);
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .grades-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--card-border);
        color: var(--text);
    }

    .grades-table tbody tr:hover {
        background: rgba(224, 176, 84, 0.04);
    }

    .grade-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(224, 176, 84, 0.1);
        color: var(--accent-strong);
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-passed {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }

    .status-failed {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #b45309;
    }

    .chart-wrapper {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 28px;
        box-shadow: var(--card-shadow);
        animation: fadeInUp .5s var(--ease) both;
        animation-delay: 0.5s;
        margin-top: 24px;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0 0 24px;
        color: var(--text);
    }

    .chart-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, rgba(224, 176, 84, 0.06), rgba(224, 176, 84, 0.02));
        border: 2px dashed var(--card-border);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1rem;
        text-align: center;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
        color: #241a04;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s var(--ease);
        text-transform: uppercase;
        letter-spacing: 0.02em;
        text-decoration: none;
        margin-top: 24px;
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(224, 176, 84, 0.35);
    }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container">
    <div class="page-header">
        <p class="breadcrumb">
            <a href="<?php echo e(route('courses.index')); ?>">← Courses</a>
            <span> / My Grades</span>
        </p>
        <h1>📊 My Automatic Grade Report</h1>
    </div>

    <div class="grade-summary">
        <div class="summary-card">
            <div class="grade-label">Current Average</div>
            <div class="grade-value"><?php echo e(number_format($average ?? 0, 1)); ?>%</div>
            <div class="grade-description">Calculated from your best completed quiz attempts</div>
        </div>
        <div class="summary-card">
            <div class="grade-label">Total Assessments</div>
            <div class="grade-value"><?php echo e($totalAssessments ?? 0); ?></div>
            <div class="grade-description">Completed quizzes with automatic scores</div>
        </div>
        <div class="summary-card">
            <div class="grade-label">Attendance</div>
            <div class="grade-value"><?php echo e($passed ?? 0); ?></div>
            <div class="grade-description">Quizzes passed</div>
        </div>
    </div>

    <div class="grades-table-wrapper">
        <h3 class="grades-table-title">📋 Assessment Breakdown</h3>
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Assessment</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = ($grades ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $quiz = $attempt->quiz;
                        $title = $quiz?->title ?? 'Quiz';
                        $score = (float) ($attempt->score_percentage ?? 0);
                        $passed = (bool) $attempt->passed;
                    ?>
                    <tr>
                        <td><?php echo e($title); ?></td>
                        <td>Quiz<?php echo e($quiz?->is_trivia ? ' / Trivia' : ''); ?></td>
                        <td><?php echo e(optional($attempt->completed_at)->format('M d, Y')); ?></td>
                        <td><?php echo e(number_format($score, 1)); ?>%</td>
                        <td><span class="grade-badge"><i class="fa-solid fa-star"></i> <?php echo e($passed ? 'Passed' : 'Needs Work'); ?></span></td>
                        <td><a class="status-badge <?php echo e($passed ? 'status-passed' : 'status-failed'); ?>" href="<?php echo e(route('quizzes.results', [$quiz->module->course->slug, $quiz->module->slug, $quiz->slug, $attempt->id])); ?>"><?php echo e($passed ? '✓ Passed' : '✕ Needs Work'); ?> · Review</a></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">No completed quizzes yet. Your grades will appear automatically after submission.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="chart-wrapper">
        <h3 class="chart-title">📈 Performance Trend</h3>
        <div class="chart-placeholder">
            📊 Grade distribution chart will appear here
        </div>
        <a href="<?php echo e(route('courses.index')); ?>" class="action-button">
            <i class="fa-solid fa-arrow-left"></i> Back to Courses
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\course\grades.blade.php ENDPATH**/ ?>