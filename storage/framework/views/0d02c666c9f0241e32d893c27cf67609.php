

<?php $__env->startSection('title', 'Add Learner Enrollment'); ?>
<?php $__env->startSection('page_title', 'Add Learner Enrollment'); ?>
<?php $__env->startSection('subtitle', 'Register a learner in a TESDA qualification, training program, and batch.'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .enrollment-form { display:grid; gap:1rem; }
  .enrollment-section { border:1px solid var(--card-border); border-radius:14px; padding:1.25rem; background:var(--card-bg); }
  .enrollment-section h3 { margin:0 0 .25rem; font-family:var(--font-display); }
  .enrollment-section > p { margin:0 0 1rem; color:var(--text-muted); font-size:.9rem; }
  .enrollment-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1rem; }
  .enrollment-field { display:grid; gap:.35rem; }
  .enrollment-field.full { grid-column:1 / -1; }
  .enrollment-field label { font-weight:600; font-size:.9rem; }
  .enrollment-input { width:100%; padding:.72rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text); font:inherit; }
  .enrollment-input[readonly] { opacity:.8; }
  .enrollment-help { color:var(--text-muted); font-size:.8rem; }
  @media (max-width:600px) { .enrollment-grid { grid-template-columns:1fr; } .enrollment-field.full { grid-column:auto; } }
</style>

<form method="POST" action="<?php echo e(route('sias.admin.enrollment.store')); ?>" enctype="multipart/form-data" class="enrollment-form">
  <?php echo csrf_field(); ?>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="admin-panel" style="border-color:var(--danger); color:var(--danger);">
      <strong>Please review the enrollment fields.</strong>
      <ul style="margin:.5rem 0 0 1.25rem;"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><li><?php echo e($error); ?></li><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></ul>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <section class="enrollment-section">
    <h3>1. Learner</h3><p>Select the learner who will be enrolled.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="student_id">Select Learner *</label><select class="enrollment-input" id="student_id" name="student_id" required><option value="">Select learner</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($student->id); ?>" data-lrn="<?php echo e($student->lrn); ?>" <?php if(old('student_id') == $student->id): echo 'selected'; endif; ?>><?php echo e($student->name); ?> (<?php echo e($student->lrn ?? $student->email); ?>)</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="enrollment-field"><label for="learner_id">Learner ID / ULI</label><input class="enrollment-input" id="learner_id" value="<?php echo e(old('learner_id')); ?>" placeholder="ULI Number" readonly></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>2. Qualification / Program</h3><p>Connect the selected qualification to its available units of competency.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="course_id">Qualification Name *</label><select class="enrollment-input" id="course_id" name="course_id" required><option value="">Select qualification</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($course->id); ?>" data-code="<?php echo e($course->code); ?>" <?php if(old('course_id') == $course->id): echo 'selected'; endif; ?>><?php echo e($course->title); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="enrollment-field"><label for="qualification_code">Qualification Code</label><input class="enrollment-input" id="qualification_code" value="<?php echo e(old('qualification_code')); ?>" placeholder="Auto-filled" readonly></div>
      <div class="enrollment-field"><label for="training_program">Training Program *</label><select class="enrollment-input" id="training_program" name="training_program" required><option value="">Select training program</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($course->title); ?>" <?php if(old('training_program') === $course->title): echo 'selected'; endif; ?>><?php echo e($course->title); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="enrollment-field"><label for="subject_id">Unit of Competency (Optional)</label><select class="enrollment-input" id="subject_id" name="subject_id"><option value="">Select competency</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($subject->id); ?>" <?php if(old('subject_id') == $subject->id): echo 'selected'; endif; ?>><?php echo e($subject->subject_code ?? $subject->code ?? ''); ?><?php echo e(($subject->subject_code ?? $subject->code) ? ' - ' : ''); ?><?php echo e($subject->title); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>3. Training Information</h3><p>Record the center, batch, schedule, delivery mode, and location.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="training_center">Training Center *</label><input class="enrollment-input" id="training_center" name="training_center" value="<?php echo e(old('training_center')); ?>" required></div>
      <div class="enrollment-field"><label for="batch_class">Batch / Class *</label><input class="enrollment-input" id="batch_class" name="batch_class" value="<?php echo e(old('batch_class')); ?>" required></div>
      <div class="enrollment-field full"><label for="training_schedule">Training Schedule *</label><input class="enrollment-input" id="training_schedule" name="training_schedule" value="<?php echo e(old('training_schedule')); ?>" placeholder="Example: Monday-Friday, 8:00 AM-5:00 PM" required></div>
      <div class="enrollment-field"><label for="training_start_date">Training Start Date *</label><input class="enrollment-input" id="training_start_date" name="training_start_date" type="date" value="<?php echo e(old('training_start_date')); ?>" required></div>
      <div class="enrollment-field"><label for="training_end_date">Training End Date *</label><input class="enrollment-input" id="training_end_date" name="training_end_date" type="date" value="<?php echo e(old('training_end_date')); ?>" required></div>
      <div class="enrollment-field"><label for="training_mode">Training Mode *</label><select class="enrollment-input" id="training_mode" name="training_mode" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Face-to-Face','Online','Blended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('training_mode', 'Face-to-Face') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="enrollment-field"><label for="training_location">Training Location *</label><input class="enrollment-input" id="training_location" name="training_location" value="<?php echo e(old('training_location')); ?>" required></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>4. Scholarship</h3><p>Record the learner's scholarship support.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="scholarship_type">Scholarship Type *</label><select class="enrollment-input" id="scholarship_type" name="scholarship_type" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['None','TWSP','PESFA','STEP','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('scholarship_type', 'None') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="enrollment-field"><label for="scholarship_reference_no">Scholarship Reference No. <span class="enrollment-help">(optional)</span></label><input class="enrollment-input" id="scholarship_reference_no" name="scholarship_reference_no" value="<?php echo e(old('scholarship_reference_no')); ?>"></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>5. Enrollment</h3><p>Set the enrollment date and current workflow status.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="enrollment_date">Enrollment Date *</label><input class="enrollment-input" id="enrollment_date" name="enrollment_date" type="date" value="<?php echo e(old('enrollment_date', now()->toDateString())); ?>" required></div>
      <div class="enrollment-field"><label for="status">Enrollment Status *</label><select class="enrollment-input" id="status" name="status" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Pending','For Verification','Approved','Enrolled','Completed','Cancelled','Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('status', 'Pending') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>6. Documents</h3><p>Upload supporting documents and track their verification state.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="supporting_documents">Supporting Documents</label><input class="enrollment-input" id="supporting_documents" name="supporting_documents[]" type="file" multiple accept="application/pdf,image/jpeg,image/png,image/webp"><small class="enrollment-help">PDF, JPG, PNG, or WebP; up to 5 MB per file and 10 files.</small></div>
      <div class="enrollment-field"><label for="document_status">Document Status *</label><select class="enrollment-input" id="document_status" name="document_status" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Pending','Verified','Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('document_status', 'Pending') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
    </div>
  </section>

  <section class="admin-card" style="display:flex; justify-content:flex-end; gap:.75rem; flex-wrap:wrap;">
    <a href="<?php echo e(route('sias.admin.enrollments')); ?>" class="btn btn-secondary" style="width:auto;">Cancel</a>
    <button type="submit" class="btn" style="width:auto;">Save Enrollment</button>
  </section>
</form>

<script>
  (function () {
    var learner = document.getElementById('student_id');
    var learnerId = document.getElementById('learner_id');
    var qualification = document.getElementById('course_id');
    var code = document.getElementById('qualification_code');
    function syncLearner() {
      var option = learner.options[learner.selectedIndex];
      learnerId.value = option ? (option.dataset.lrn || '') : '';
    }
    function syncQualification() {
      var option = qualification.options[qualification.selectedIndex];
      code.value = option ? (option.dataset.code || '') : '';
    }
    learner.addEventListener('change', syncLearner);
    qualification.addEventListener('change', syncQualification);
    syncLearner();
    syncQualification();
  }());
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\enrollment\add.blade.php ENDPATH**/ ?>