@extends('sias.admin.layouts.master')

@section('title', 'Add Learner Enrollment')
@section('page_title', 'Add Learner Enrollment')
@section('subtitle', 'Register a learner in a TESDA qualification, training program, and batch.')

@section('content')
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

<form method="POST" action="{{ route('sias.admin.enrollment.store') }}" enctype="multipart/form-data" class="enrollment-form">
  @csrf
  @if($errors->any())
    <div class="admin-panel" style="border-color:var(--danger); color:var(--danger);">
      <strong>Please review the enrollment fields.</strong>
      <ul style="margin:.5rem 0 0 1.25rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="enrollment-section">
    <h3>1. Learner</h3><p>Select the learner who will be enrolled.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="student_id">Select Learner *</label><select class="enrollment-input" id="student_id" name="student_id" required><option value="">Select learner</option>@foreach($students as $student)<option value="{{ $student->id }}" data-lrn="{{ $student->lrn }}" @selected(old('student_id') == $student->id)>{{ $student->name }} ({{ $student->lrn ?? $student->email }})</option>@endforeach</select></div>
      <div class="enrollment-field"><label for="learner_id">Learner ID / ULI</label><input class="enrollment-input" id="learner_id" value="{{ old('learner_id') }}" placeholder="ULI Number" readonly></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>2. Qualification / Program</h3><p>Connect the selected qualification to its available units of competency.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="course_id">Qualification Name *</label><select class="enrollment-input" id="course_id" name="course_id" required><option value="">Select qualification</option>@foreach($courses as $course)<option value="{{ $course->id }}" data-code="{{ $course->code }}" @selected(old('course_id') == $course->id)>{{ $course->title }}</option>@endforeach</select></div>
      <div class="enrollment-field"><label for="qualification_code">Qualification Code</label><input class="enrollment-input" id="qualification_code" value="{{ old('qualification_code') }}" placeholder="Auto-filled" readonly></div>
      <div class="enrollment-field"><label for="training_program">Training Program *</label><select class="enrollment-input" id="training_program" name="training_program" required><option value="">Select training program</option>@foreach($courses as $course)<option value="{{ $course->title }}" @selected(old('training_program') === $course->title)>{{ $course->title }}</option>@endforeach</select></div>
      <div class="enrollment-field"><label for="subject_id">Unit of Competency (Optional)</label><select class="enrollment-input" id="subject_id" name="subject_id"><option value="">Select competency</option>@foreach($subjects as $subject)<option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->subject_code ?? $subject->code ?? '' }}{{ ($subject->subject_code ?? $subject->code) ? ' - ' : '' }}{{ $subject->title }}</option>@endforeach</select></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>3. Training Information</h3><p>Record the center, batch, schedule, delivery mode, and location.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="training_center">Training Center *</label><input class="enrollment-input" id="training_center" name="training_center" value="{{ old('training_center') }}" required></div>
      <div class="enrollment-field"><label for="batch_class">Batch / Class *</label><input class="enrollment-input" id="batch_class" name="batch_class" value="{{ old('batch_class') }}" required></div>
      <div class="enrollment-field full"><label for="training_schedule">Training Schedule *</label><input class="enrollment-input" id="training_schedule" name="training_schedule" value="{{ old('training_schedule') }}" placeholder="Example: Monday-Friday, 8:00 AM-5:00 PM" required></div>
      <div class="enrollment-field"><label for="training_start_date">Training Start Date *</label><input class="enrollment-input" id="training_start_date" name="training_start_date" type="date" value="{{ old('training_start_date') }}" required></div>
      <div class="enrollment-field"><label for="training_end_date">Training End Date *</label><input class="enrollment-input" id="training_end_date" name="training_end_date" type="date" value="{{ old('training_end_date') }}" required></div>
      <div class="enrollment-field"><label for="training_mode">Training Mode *</label><select class="enrollment-input" id="training_mode" name="training_mode" required>@foreach(['Face-to-Face','Online','Blended'] as $option)<option value="{{ $option }}" @selected(old('training_mode', 'Face-to-Face') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="enrollment-field"><label for="training_location">Training Location *</label><input class="enrollment-input" id="training_location" name="training_location" value="{{ old('training_location') }}" required></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>4. Scholarship</h3><p>Record the learner's scholarship support.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="scholarship_type">Scholarship Type *</label><select class="enrollment-input" id="scholarship_type" name="scholarship_type" required>@foreach(['None','TWSP','PESFA','STEP','Other'] as $option)<option value="{{ $option }}" @selected(old('scholarship_type', 'None') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="enrollment-field"><label for="scholarship_reference_no">Scholarship Reference No. <span class="enrollment-help">(optional)</span></label><input class="enrollment-input" id="scholarship_reference_no" name="scholarship_reference_no" value="{{ old('scholarship_reference_no') }}"></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>5. Enrollment</h3><p>Set the enrollment date and current workflow status.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="enrollment_date">Enrollment Date *</label><input class="enrollment-input" id="enrollment_date" name="enrollment_date" type="date" value="{{ old('enrollment_date', now()->toDateString()) }}" required></div>
      <div class="enrollment-field"><label for="status">Enrollment Status *</label><select class="enrollment-input" id="status" name="status" required>@foreach(['Pending','For Verification','Approved','Enrolled','Completed','Cancelled','Rejected'] as $option)<option value="{{ $option }}" @selected(old('status', 'Pending') === $option)>{{ $option }}</option>@endforeach</select></div>
    </div>
  </section>

  <section class="enrollment-section">
    <h3>6. Documents</h3><p>Upload supporting documents and track their verification state.</p>
    <div class="enrollment-grid">
      <div class="enrollment-field"><label for="supporting_documents">Supporting Documents</label><input class="enrollment-input" id="supporting_documents" name="supporting_documents[]" type="file" multiple accept="application/pdf,image/jpeg,image/png,image/webp"><small class="enrollment-help">PDF, JPG, PNG, or WebP; up to 5 MB per file and 10 files.</small></div>
      <div class="enrollment-field"><label for="document_status">Document Status *</label><select class="enrollment-input" id="document_status" name="document_status" required>@foreach(['Pending','Verified','Rejected'] as $option)<option value="{{ $option }}" @selected(old('document_status', 'Pending') === $option)>{{ $option }}</option>@endforeach</select></div>
    </div>
  </section>

  <section class="admin-card" style="display:flex; justify-content:flex-end; gap:.75rem; flex-wrap:wrap;">
    <a href="{{ route('sias.admin.enrollments') }}" class="btn btn-secondary" style="width:auto;">Cancel</a>
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
@endsection
