

<?php $__env->startSection('title', 'Enrollment'); ?>
<?php $__env->startSection('page_title', 'Enrollment'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="max-width: 1100px; margin: 0 auto;">
    <div class="enrollment-header">
        <div>
            <h3 style="margin:0; font-size:1.6rem; color:#0f172a;">Student Enrollment</h3>
            <p style="margin:.4rem 0 0; color:#64748b;">Manage your enrollment records, subject list, and academic forms.</p>
        </div>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <a href="<?php echo e(route('sias.student.registration')); ?>" class="btn-black">Register Course</a>
            <a href="<?php echo e(route('sias.student.registration.enrollment_form')); ?>" class="btn-white">Enrollment Form</a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="label">Program</span>
            <strong><?php echo e(auth()->user()->program ?? 'Bachelor of Science in Information Technology'); ?></strong>
        </div>
        <div class="stat-card">
            <span class="label">Year Level</span>
            <strong><?php echo e(auth()->user()->year_level ?? '4th Year'); ?></strong>
        </div>
        <div class="stat-card">
            <span class="label">Semester</span>
            <strong>1st Semester 2026-2027</strong>
        </div>
        <div class="stat-card">
            <span class="label">Status</span>
            <strong>Validated</strong>
        </div>
    </div>

    <div class="panel-grid">
        <div class="info-panel">
            <h4>Current Enrollment</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Units</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e(auth()->user()->program ?? 'BSIT'); ?></td>
                        <td>18</td>
                        <td><span class="status-badge">Active</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-panel">
            <h4>Selected Subjects</h4>
            <ul class="subject-list">
                <li>IT 101 - Computer Fundamentals</li>
                <li>IT 201 - Data Structures</li>
                <li>IT 301 - Database Systems</li>
                <li>IT 401 - System Analysis and Design</li>
            </ul>
        </div>
    </div>

    <div class="form-actions">
        <a href="<?php echo e(route('sias.student.registration.assessment_form')); ?>" class="btn-black">Print Assessment Form</a>
        <a href="<?php echo e(route('sias.student.registration.enrollment_certificate')); ?>" class="btn-white">Certificate of Enrollment</a>
        <a href="<?php echo e(route('sias.student.registration.grade_certificate')); ?>" class="btn-white">Grade Certificate</a>
    </div>
</div>

<style>
    .enrollment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card,
    .info-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.1rem 1rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
    }
    .label {
        display: block;
        color: #64748b;
        font-size: .76rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .5rem;
    }
    .stat-card strong {
        font-size: 1.08rem;
        color: #0f172a;
    }
    .panel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .info-panel h4 {
        margin: 0 0 1rem;
        font-size: 1.1rem;
        color: #0f172a;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: .8rem .75rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }
    .data-table th {
        color: #334155;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .status-badge {
        display: inline-block;
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
        border-radius: 999px;
        padding: .38rem .75rem;
        font-size: .8rem;
        font-weight: 700;
    }
    .subject-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: .6rem;
        color: #0f172a;
    }
    .subject-list li {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: .75rem .9rem;
    }
    .form-actions {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\enrollment.blade.php ENDPATH**/ ?>