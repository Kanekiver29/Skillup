

<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('page_title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ===== Profile Page Animations & Polish ===== */
    .profile-page * { box-sizing: border-box; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes popIn {
        from { opacity: 0; transform: scale(.85); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes shimmer {
        0%   { background-position: -400px 0; }
        100% { background-position: 400px 0; }
    }

    .profile-page .anim-in {
        opacity: 0;
        animation: fadeInUp .55s cubic-bezier(.22,1,.36,1) forwards;
    }
    .profile-page .anim-avatar {
        opacity: 0;
        animation: popIn .5s cubic-bezier(.34,1.56,.64,1) forwards;
        animation-delay: .05s;
    }

    /* staggered reveal for grouped children */
    .profile-page .stagger > * {
        opacity: 0;
        animation: fadeInUp .5s cubic-bezier(.22,1,.36,1) forwards;
    }
    .profile-page .stagger > *:nth-child(1) { animation-delay: .06s; }
    .profile-page .stagger > *:nth-child(2) { animation-delay: .14s; }
    .profile-page .stagger > *:nth-child(3) { animation-delay: .22s; }

    /* field value boxes */
    .profile-page .field-box {
        min-height: 48px;
        border: 1px solid #d1d5db;
        border-radius: 14px;
        padding: 1rem;
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }
    .profile-page .field-box:hover {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
        transform: translateY(-1px);
    }

    .profile-page .field-label {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    /* panels */
    .profile-page .panel {
        background: var(--block-bg);
        border: 1px solid var(--block-border);
        border-radius: 22px;
        padding: 1.25rem;
        transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
    }
    .profile-page .panel:hover {
        box-shadow: 0 10px 28px -14px rgba(15,23,42,.18);
        transform: translateY(-2px);
    }

    /* header icon pulse */
    .profile-page .header-icon {
        width: 48px; height: 48px; border-radius: 999px;
        background: rgba(59,130,246,.12); color: #2563eb;
        display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:1.1rem;
        position: relative;
        animation: fadeIn .6s ease forwards;
    }
    .profile-page .header-icon::after {
        content:'';
        position:absolute; inset:-6px;
        border-radius:999px;
        border:2px solid rgba(37,99,235,.25);
        animation: pulseRing 2.2s ease-out infinite;
    }
    @keyframes pulseRing {
        0%   { transform: scale(.85); opacity: .8; }
        70%  { transform: scale(1.25); opacity: 0; }
        100% { opacity: 0; }
    }

    /* checkbox row */
    .profile-page .type-option {
        display:inline-flex; align-items:center; gap:.5rem;
        font-weight:600; color: var(--text);
        padding: .5rem .75rem;
        border-radius: 10px;
        transition: background .2s ease;
    }
    .profile-page .type-option:hover { background: rgba(37,99,235,.06); }
    .profile-page .type-option input[type="checkbox"] {
        width:1rem; height:1rem; accent-color:#2563eb;
    }

    /* Profile Sections accordion — smooth height animation */
    .profile-page .profile-sections-toggle summary {
        display:flex; align-items:center; gap:.75rem;
        padding:1.25rem;
        background: var(--block-bg);
        border:1px solid var(--block-border);
        border-radius:16px;
        cursor:pointer; user-select:none;
        transition: background .2s ease, border-color .2s ease;
        font-weight:600;
        margin-bottom:1rem;
        list-style: none;
    }
    .profile-page .profile-sections-toggle summary::-webkit-details-marker { display:none; }
    .profile-page .profile-sections-toggle summary:hover {
        background: rgba(37,99,235,.06);
        border-color: rgba(37,99,235,.35);
    }
    .profile-page .profile-sections-toggle .chevron {
        margin-left:auto; font-size:.85rem;
        transition: transform .35s cubic-bezier(.34,1.56,.64,1);
        color: var(--text-muted);
    }
    .profile-page .profile-sections-toggle[open] .chevron { transform: rotate(180deg); }

    .profile-page .profile-links-wrap {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows .35s cubic-bezier(.22,1,.36,1);
    }
    .profile-page .profile-sections-toggle[open] .profile-links-wrap {
        grid-template-rows: 1fr;
    }
    .profile-page .profile-links-wrap > .profile-links {
        overflow: hidden;
        display: grid;
        gap: .5rem;
    }

    .profile-page .profile-links a {
        display:flex; align-items:center; gap:.6rem;
        padding:.75rem 1rem;
        background: var(--block-bg);
        border:1px solid var(--block-border);
        border-radius:12px;
        border-left:3px solid transparent;
        color:#1d4ed8;
        text-decoration:none;
        font-weight:600;
        transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
    }
    .profile-page .profile-links a i { transition: transform .25s ease; }
    .profile-page .profile-links a:hover {
        background:#fff;
        border-left-color:#2563eb;
        box-shadow: 0 6px 18px -10px rgba(37,99,235,.45);
        transform: translateX(4px);
    }
    .profile-page .profile-links a:hover i { transform: scale(1.15); }

    /* photo/document preview shimmer placeholder */
    .profile-page .photo-preview {
        background: var(--card-bg);
        border:1px solid var(--block-border);
        border-radius:20px;
        padding:1rem;
        display:flex; align-items:center; justify-content:center;
        color: var(--text-muted);
        min-height:240px;
        text-align:center;
        position: relative;
        overflow: hidden;
        transition: border-color .25s ease;
    }
    .profile-page .photo-preview:hover { border-color:#93c5fd; }
    .profile-page .photo-preview::before {
        content:'';
        position:absolute; inset:0;
        background: linear-gradient(90deg, transparent, rgba(37,99,235,.06), transparent);
        background-size: 800px 100%;
        animation: shimmer 3.2s linear infinite;
        pointer-events:none;
    }

    /* sidebar */
    .profile-page .sidebar-row {
        display:flex; justify-content:space-between; gap:1rem;
        padding: .4rem 0;
        border-bottom: 1px dashed var(--block-border);
    }
    .profile-page .sidebar-row:last-child { border-bottom: none; }

    .profile-page .btn-primary,
    .profile-page .btn-secondary {
        padding:.85rem 1rem;
        border-radius:14px;
        text-decoration:none;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease, filter .18s ease;
    }
    .profile-page .btn-primary {
        background:#2563eb;
        color:#fff;
        box-shadow: 0 8px 20px -10px rgba(37,99,235,.6);
    }
    .profile-page .btn-primary:hover {
        transform: translateY(-2px);
        filter: brightness(1.06);
        box-shadow: 0 12px 24px -10px rgba(37,99,235,.7);
    }
    .profile-page .btn-primary:active { transform: translateY(0); }

    .profile-page .btn-secondary {
        border:1px solid #cbd5e1;
        color: var(--text);
        background: transparent;
    }
    .profile-page .btn-secondary:hover {
        transform: translateY(-2px);
        background: rgba(15,23,42,.04);
    }

    @media (max-width: 900px) {
        .profile-page .grid-2col { grid-template-columns: 1fr !important; }
        .profile-page .grid-3col { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 560px) {
        .profile-page .grid-3col { grid-template-columns: 1fr !important; }
    }

    @media (prefers-reduced-motion: reduce) {
        .profile-page * { animation: none !important; transition: none !important; }
    }
</style>

<div class="page-card profile-page" style="padding:1.5rem;">
    <?php
        $enrollment = auth()->user()->enrollments()->with('course')->first();
        $courseTitle = $enrollment?->course->title ?? 'Bachelor of Science in Information Technology';
        $courseDept = $enrollment?->course->department ?? 'Information Technology';
        $curriculum = $enrollment?->course->category ?? 'BSIT Curriculum 2018';
        $yearLevel = $enrollment?->year_level ?? '4';
        $learnerRef = auth()->user()->student_number ?? auth()->user()->id;
        $entryPeriod = 'First Semester SY 2026-2027';
        $entryDate = auth()->user()->created_at?->format('M d, Y') ?? now()->format('M d, Y');
        $examScore = $enrollment?->exam_score ?? 'N/A';
        $nstpNo = $enrollment?->nstp_number ?? 'N/A';
        $prefModality = $enrollment?->modality ?? 'Onsite';
        $campus = $enrollment?->campus ?? 'Main Campus';
        $type = $enrollment?->student_type ?? 'New Student';
        $sectionNo = $enrollment?->section_no ?? 'A1';
    ?>

    <?php
        $profileVisibility = auth()->user()->profileVisibility();
        $profileVisibilityLabel = [
            'public' => 'Public profile',
            'students_only' => 'Visible to students only',
            'private' => 'Private profile',
        ][$profileVisibility] ?? 'Private profile';
    ?>

    <div style="display:grid; gap:1.25rem;">
        <div class="anim-in" style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; animation-delay:.02s;">
            <div>
                <h2 style="margin:0;font-size:2rem;letter-spacing:-.02em;">Enrollment Data</h2>
                <p style="margin:.5rem 0 0;color:var(--text-muted);max-width:44rem;">Student enrollment and registration details are tracked here for quick review.</p>
            </div>
            <div style="display:flex;align-items:center;gap:.65rem;flex-wrap:wrap;">
                <span style="display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .7rem;border-radius:999px;background:var(--block-bg);border:1px solid var(--block-border);color:var(--text-muted);font-size:.78rem;font-weight:700;">
                    <i class="fa-solid fa-shield-halved" style="color:var(--accent-strong);"></i><?php echo e($profileVisibilityLabel); ?>

                </span>
                <div class="header-icon">?</div>
            </div>
        </div>

        <div class="grid-2col" style="display:grid;grid-template-columns:1.2fr .8fr;gap:1rem;align-items:start;">
            <div style="display:grid;gap:1rem;">
                <div class="panel anim-in" style="animation-delay:.08s; display:grid;gap:1.25rem;">
                    <div class="grid-3col stagger" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Course</span>
                            <div class="field-box"><?php echo e($courseTitle); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Level</span>
                            <div class="field-box">Year <?php echo e($yearLevel); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Dept</span>
                            <div class="field-box"><?php echo e($courseDept); ?></div>
                        </div>
                    </div>

                    <div class="grid-3col stagger" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Curriculum</span>
                            <div class="field-box"><?php echo e($curriculum); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Year Level</span>
                            <div class="field-box"><?php echo e($yearLevel); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Learner Ref. No</span>
                            <div class="field-box"><?php echo e($learnerRef); ?></div>
                        </div>
                    </div>

                    <div class="grid-3col stagger" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;align-items:end;">
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Entry Period</span>
                            <div class="field-box"><?php echo e($entryPeriod); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Entry Date</span>
                            <div class="field-box"><?php echo e($entryDate); ?></div>
                        </div>
                        <div style="display:grid;gap:.35rem;">
                            <span class="field-label">Exam Score</span>
                            <div class="field-box"><?php echo e($examScore); ?></div>
                        </div>
                    </div>
                </div>

                <div class="grid-3col stagger" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <div class="panel" style="display:grid;gap:.75rem;">
                        <span class="field-label">NSTP No</span>
                        <div class="field-box"><?php echo e($nstpNo); ?></div>
                    </div>
                    <div class="panel" style="display:grid;gap:.75rem;">
                        <span class="field-label">Pref. Modality</span>
                        <div class="field-box"><?php echo e($prefModality); ?></div>
                    </div>
                    <div class="panel" style="display:grid;gap:.75rem;">
                        <span class="field-label">Campus</span>
                        <div class="field-box"><?php echo e($campus); ?></div>
                    </div>
                </div>

                <div class="grid-2col anim-in" style="animation-delay:.18s; display:grid;grid-template-columns:1.3fr .7fr;gap:1rem;">
                    <div class="panel">
                        <span class="field-label">Type</span>
                        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:.75rem;">
                            <label class="type-option">
                                <input type="checkbox" disabled <?php echo e($type === 'New Student' ? 'checked' : ''); ?>>
                                New Student
                            </label>
                            <label class="type-option">
                                <input type="checkbox" disabled <?php echo e($type === 'Regular' ? 'checked' : ''); ?>>
                                Regular
                            </label>
                        </div>
                    </div>
                    <div class="panel" style="display:grid;gap:.75rem;">
                        <span class="field-label">Section No</span>
                        <div class="field-box"><?php echo e($sectionNo); ?></div>
                    </div>
                </div>

                <div class="grid-2col anim-in" style="animation-delay:.24s; display:grid;grid-template-columns:1fr 240px;gap:1rem;">
                    <details class="profile-sections-toggle" open>
                        <summary>
                            <i class="fa-solid fa-folder-open" style="color:var(--accent-strong);font-size:1.1rem;"></i>
                            <span>Profile Sections</span>
                            <i class="fa-solid fa-chevron-down chevron"></i>
                        </summary>
                        <div class="profile-links-wrap">
                            <div class="profile-links">
                                <a href="<?php echo e(route('sias.student.profile.personal_information')); ?>"><i class="fa-solid fa-user"></i>Personal Information</a>
                                <a href="<?php echo e(route('sias.student.profile.addresses_contacts')); ?>"><i class="fa-solid fa-map-location-dot"></i>Addresses &amp; Contacts</a>
                                <a href="<?php echo e(route('sias.student.profile.family_background')); ?>"><i class="fa-solid fa-people-group"></i>Family Background</a>
                                <a href="<?php echo e(route('sias.student.profile.educational_background')); ?>"><i class="fa-solid fa-graduation-cap"></i>Educational Background</a>
                                <a href="<?php echo e(route('sias.student.profile.religious_background')); ?>"><i class="fa-solid fa-heart"></i>Religious Background</a>
                                <a href="<?php echo e(route('sias.student.profile.medical_information')); ?>"><i class="fa-solid fa-stethoscope"></i>Medical Information</a>
                                <a href="<?php echo e(route('sias.student.profile.employment_records')); ?>"><i class="fa-solid fa-briefcase"></i>Employment Records</a>
                                <a href="<?php echo e(route('sias.student.profile.classifications_disabilities')); ?>"><i class="fa-solid fa-universal-access"></i>Classifications &amp; Disabilities</a>
                            </div>
                        </div>
                    </details>
                    <div class="photo-preview">
                        Student photo or document preview
                    </div>
                </div>
            </div>

            <aside class="panel anim-in" style="animation-delay:.3s; display:grid;gap:1rem;">
                <div>
                    <h3 style="margin:0 0 .5rem;font-size:1.05rem;">Profile Snapshot</h3>
                    <p style="margin:0;color:var(--text-muted);">Quick enrollment summary and active student details.</p>
                </div>
                <div style="display:grid;gap:.25rem;">
                    <div class="sidebar-row"><span style="color:var(--text-muted);">Name</span><strong><?php echo e(auth()->user()->name ?? 'Student Name'); ?></strong></div>
                    <div class="sidebar-row"><span style="color:var(--text-muted);">Email</span><strong><?php echo e(auth()->user()->email ?? 'student@example.com'); ?></strong></div>
                    <div class="sidebar-row"><span style="color:var(--text-muted);">Enrollment status</span><strong><?php echo e(ucfirst($enrollment?->status ?? 'Active')); ?></strong></div>
                    <div class="sidebar-row"><span style="color:var(--text-muted);">Enrollments</span><strong><?php echo e(auth()->user()->enrollments()->count()); ?></strong></div>
                </div>
                <div style="margin-top:1rem;display:flex;gap:.75rem;flex-wrap:wrap;">
                    <a href="#" class="btn-primary">Update Data</a>
                    <a href="#" class="btn-secondary">View Record</a>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\profile\index.blade.php ENDPATH**/ ?>