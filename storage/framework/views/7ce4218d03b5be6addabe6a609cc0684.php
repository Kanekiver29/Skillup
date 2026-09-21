

<?php $__env->startSection('title', 'Create Profile'); ?>
<?php $__env->startSection('page_title', 'Create Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem;">
    <div style="display:grid;gap:1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
            <div>
                <h2 style="margin:0;font-size:2rem;letter-spacing:-.02em;">Create Enrollment Profile</h2>
                <p style="margin:.5rem 0 0;color:var(--text-muted);max-width:42rem;">Fill in the student enrollment details to create a new profile entry.</p>
            </div>
            <a href="<?php echo e(route('sias.student.profile')); ?>" class="btn-white">Back to Profile</a>
        </div>

        <form method="POST" action="#" style="display:grid;gap:1.25rem;">
            <?php echo csrf_field(); ?>
            <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Course
                    <input name="course" class="form-input" placeholder="e.g. BS Information Technology">
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Level
                    <select name="level" class="form-input">
                        <option value="">Select level</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Dept
                    <input name="department" class="form-input" placeholder="e.g. Information Technology">
                </label>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Curriculum
                    <input name="curriculum" class="form-input" placeholder="e.g. BSIT Curriculum 2018">
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Year Level
                    <select name="year_level" class="form-input">
                        <option value="">Select year</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Learner Ref. No
                    <input name="learner_ref" class="form-input" placeholder="e.g. 20260001">
                </label>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Entry Period
                    <input name="entry_period" class="form-input" placeholder="e.g. First Semester SY 2026-2027">
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Entry Date
                    <input name="entry_date" type="date" class="form-input">
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Exam Score
                    <input name="exam_score" class="form-input" placeholder="e.g. 87">
                </label>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    NSTP No
                    <input name="nstp_no" class="form-input" placeholder="e.g. NSTP-1234">
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Pref. Modality
                    <select name="modality" class="form-input">
                        <option value="">Select modality</option>
                        <option value="onsite">Onsite</option>
                        <option value="online">Online</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </label>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Campus
                    <input name="campus" class="form-input" placeholder="e.g. Main Campus">
                </label>
            </div>

            <div style="display:grid;grid-template-columns:1.3fr .7fr;gap:1rem;">
                <fieldset style="border:1px solid #d1d5db;border-radius:18px;padding:1rem;display:grid;gap:.85rem;">
                    <legend style="font-weight:700;padding:0 .5rem;color:var(--text);">Type</legend>
                    <label style="display:flex;align-items:center;gap:.5rem;font-weight:600;color:var(--text);">
                        <input type="checkbox" name="type[]" value="new_student" style="width:1rem;height:1rem;accent:#2563eb;">
                        New Student
                    </label>
                    <label style="display:flex;align-items:center;gap:.5rem;font-weight:600;color:var(--text);">
                        <input type="checkbox" name="type[]" value="regular" style="width:1rem;height:1rem;accent:#2563eb;">
                        Regular
                    </label>
                </fieldset>
                <label style="display:grid;gap:.35rem;font-size:.9rem;color:var(--text-muted);">
                    Section No
                    <input name="section_no" class="form-input" placeholder="e.g. A1">
                </label>
            </div>

            <div style="display:grid;grid-template-columns:1fr 280px;gap:1rem;align-items:start;">
                <div style="display:grid;gap:.75rem;">
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Personal Information ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Addresses &amp; Contacts ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Family Background ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Educational Background ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Religious Background ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Medical Information ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Employment Records ...</a>
                    <a href="#" style="color:#1d4ed8;font-weight:700;text-decoration:none;">Classifications &amp; Disabilities ...</a>
                </div>
                <div style="background:var(--block-bg);border:1px solid var(--block-border);border-radius:18px;padding:1rem;display:flex;align-items:center;justify-content:center;min-height:240px;color:var(--text-muted);text-align:center;">
                    Document preview or student profile photo
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
                <button type="button" onclick="history.back()" style="padding:.85rem 1.25rem;border-radius:14px;border:1px solid #cbd5e1;background:#fff;color:var(--text);font-weight:700;">Cancel</button>
                <button type="submit" style="padding:.85rem 1.25rem;border-radius:14px;background:#1d4ed8;color:#fff;border:none;font-weight:700;">Create Profile</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\profile\create.blade.php ENDPATH**/ ?>