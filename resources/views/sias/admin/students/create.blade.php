@extends('sias.admin.layouts.master')

@section('title', 'Register New Learner')
@section('page_title', 'Register New Learner')
@section('subtitle', 'Create a complete learner record, account, and enrollment profile.')

@section('content')
<style>
  .learner-form { display:grid; gap:1rem; }
  .learner-section { border:1px solid var(--card-border); border-radius:14px; padding:1.25rem; background:var(--card-bg); }
  .learner-section h3 { margin:0 0 .25rem; font-family:var(--font-display); }
  .learner-section > p { margin:0 0 1rem; color:var(--text-muted); font-size:.9rem; }
  .learner-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1rem; }
  .learner-field { display:grid; gap:.35rem; }
  .learner-field.full { grid-column:1 / -1; }
  .learner-field label { font-weight:600; font-size:.9rem; }
  .learner-input { width:100%; padding:.72rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text); font:inherit; }
  .learner-input:focus { border-color:var(--accent); outline:2px solid var(--accent-tint); }
  .learner-help, .learner-error { font-size:.8rem; }
  .learner-help { color:var(--text-muted); }
  .choice-grid { display:flex; flex-wrap:wrap; gap:.65rem 1rem; }
  .choice { display:flex; align-items:center; gap:.45rem; font-size:.9rem; }
  .choice input { accent-color:var(--accent); }
  @media (max-width:600px) { .learner-grid { grid-template-columns:1fr; } .learner-field.full { grid-column:auto; } }
</style>

<form method="POST" action="{{ route('sias.admin.students.store') }}" enctype="multipart/form-data" class="learner-form">
  @csrf

  @if($errors->any())
    <div class="admin-panel" style="border-color:var(--danger); color:var(--danger);">
      <strong>Please review the highlighted registration fields.</strong>
      <ul style="margin:.5rem 0 0 1.25rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="learner-section">
    <h3>1. Learner Identification</h3><p>Assign the learner identity and entry details.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="student_id">ULI / Learner ID *</label><input class="learner-input" id="student_id" name="student_id" value="{{ old('student_id') }}" required><small class="learner-help">This becomes the learner reference number and username.</small></div>
      <div class="learner-field"><label for="entry_date">Entry Date *</label><input class="learner-input" id="entry_date" name="entry_date" type="date" value="{{ old('entry_date', now()->toDateString()) }}" required></div>
      <div class="learner-field full"><label for="profile_photo">Profile Photo</label><input class="learner-input" id="profile_photo" name="profile_photo" type="file" accept="image/jpeg,image/png,image/webp"><small class="learner-help">JPG, PNG, or WebP up to 2 MB.</small></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>2. Personal Information</h3><p>Record the learner's personal identity details.</p>
    <div class="learner-grid">
      <div class="learner-field full"><label for="name">Full Name *</label><input class="learner-input" id="name" name="name" value="{{ old('name') }}" required></div>
      <div class="learner-field"><label for="birthdate">Birthdate</label><input class="learner-input" id="birthdate" name="birthdate" type="date" value="{{ old('birthdate') }}"></div>
      <div class="learner-field"><label for="nationality">Nationality</label><input class="learner-input" id="nationality" name="nationality" value="{{ old('nationality', 'Filipino') }}"></div>
      <div class="learner-field"><label for="sex">Sex</label><select class="learner-input" id="sex" name="sex"><option value="">Select sex</option>@foreach(['Male','Female','Prefer not to say'] as $option)<option value="{{ $option }}" @selected(old('sex') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="learner-field"><label for="civil_status">Civil Status</label><select class="learner-input" id="civil_status" name="civil_status"><option value="">Select civil status</option>@foreach(['Single','Married','Widowed','Separated'] as $option)<option value="{{ $option }}" @selected(old('civil_status') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="learner-field"><label for="birthplace_city">Birthplace City / Municipality</label><input class="learner-input" id="birthplace_city" name="birthplace_city" value="{{ old('birthplace_city') }}"></div>
      <div class="learner-field"><label for="birthplace_province">Birthplace Province</label><input class="learner-input" id="birthplace_province" name="birthplace_province" value="{{ old('birthplace_province') }}"></div>
      <div class="learner-field"><label for="birthplace_region">Birthplace Region</label><input class="learner-input" id="birthplace_region" name="birthplace_region" value="{{ old('birthplace_region') }}"></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>3. Contact &amp; Address</h3><p>Provide current communication and residential information.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="email">Email</label><input class="learner-input" id="email" name="email" type="email" value="{{ old('email') }}"></div>
      <div class="learner-field"><label for="contact_number">Contact Number</label><input class="learner-input" id="contact_number" name="contact_number" value="{{ old('contact_number') }}"></div>
      <div class="learner-field full"><label for="complete_address">Complete Address</label><textarea class="learner-input" id="complete_address" name="complete_address" rows="3">{{ old('complete_address') }}</textarea></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>4. Educational Background</h3><p>Capture the learner's prior educational attainment.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="educational_attainment">Educational Attainment</label><input class="learner-input" id="educational_attainment" name="educational_attainment" value="{{ old('educational_attainment') }}"></div>
      <div class="learner-field"><label for="school">School</label><input class="learner-input" id="school" name="school" value="{{ old('school') }}"></div>
      <div class="learner-field"><label for="year_graduated">Year Graduated</label><input class="learner-input" id="year_graduated" name="year_graduated" type="number" min="1900" max="{{ now()->year }}" value="{{ old('year_graduated') }}"></div>
      <div class="learner-field full"><label>Education Level Completed</label><div class="choice-grid">@foreach(['No Grade Completed','Elementary Undergraduate','Elementary Graduate','High School Undergraduate','High School Graduate','Junior High (K-12)','Senior High (K-12)','Post-Secondary Non-Tertiary / Technical Vocational Course Undergraduate','Post-Secondary Non-Tertiary / Technical Vocational Course Graduate','College Undergraduate','College Graduate','Masteral','Doctorate'] as $option)<label class="choice"><input type="checkbox" name="education_levels[]" value="{{ $option }}" @checked(in_array($option, old('education_levels', []), true))>{{ $option }}</label>@endforeach</div></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>5. Employment</h3><p>Record current work status and occupation.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="employment_status">Employment Status</label><select class="learner-input" id="employment_status" name="employment_status"><option value="">Select status</option>@foreach(['Employed','Self-employed','Unemployed','Student'] as $option)<option value="{{ $option }}" @selected(old('employment_status') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="learner-field"><label for="employment_type">Employment Type</label><select class="learner-input" id="employment_type" name="employment_type"><option value="">Select type</option>@foreach(['Full-time','Part-time','Contractual','Seasonal'] as $option)<option value="{{ $option }}" @selected(old('employment_type') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="learner-field full"><label for="occupation">Occupation</label><input class="learner-input" id="occupation" name="occupation" value="{{ old('occupation') }}"></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>6. Parent / Guardian</h3><p>Keep an emergency or family contact for the learner.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="guardian_name">Name</label><input class="learner-input" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}"></div>
      <div class="learner-field"><label for="guardian_relationship">Relationship</label><input class="learner-input" id="guardian_relationship" name="guardian_relationship" value="{{ old('guardian_relationship') }}"></div>
      <div class="learner-field"><label for="guardian_contact">Contact Number</label><input class="learner-input" id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact') }}"></div>
      <div class="learner-field"><label for="guardian_address">Address</label><input class="learner-input" id="guardian_address" name="guardian_address" value="{{ old('guardian_address') }}"></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>7. TESDA Training</h3><p>Document the learner's training program information.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="qualification">Qualification</label><input class="learner-input" id="qualification" name="qualification" value="{{ old('qualification') }}"></div>
      <div class="learner-field"><label for="training_program">Training Program</label><input class="learner-input" id="training_program" name="training_program" value="{{ old('training_program') }}"></div>
      <div class="learner-field"><label for="training_center">Training Center</label><input class="learner-input" id="training_center" name="training_center" value="{{ old('training_center') }}"></div>
      <div class="learner-field"><label for="training_batch">Batch</label><input class="learner-input" id="training_batch" name="training_batch" value="{{ old('training_batch') }}"></div>
      <div class="learner-field"><label for="training_schedule">Schedule</label><input class="learner-input" id="training_schedule" name="training_schedule" value="{{ old('training_schedule') }}"></div>
      <div class="learner-field"><label for="training_mode">Training Mode</label><select class="learner-input" id="training_mode" name="training_mode"><option value="">Select mode</option>@foreach(['Face-to-face','Online','Blended'] as $option)<option value="{{ $option }}" @selected(old('training_mode') === $option)>{{ $option }}</option>@endforeach</select></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>8. Learner Classification</h3><p>Select all classifications that apply.</p>
    <div class="choice-grid">@foreach(['4Ps Beneficiary','Displaced Workers','Family Members of AFP and PNP Killed-in-Action','Family Members of AFP and PNP Wounded-in-Action','Farmers and Fishermen','Indigenous People & Cultural Communities','Industry Workers','Inmates and Detainees','MILF Beneficiary','Out-of-School Youth','Overseas Filipino Workers (OFW)','ROCE-RESP','Returning/Repatriated Overseas Filipino Workers (OFW)','Student','TESDA Alumni','TVET Trainers','Uniformed Personnel','Victim of Natural Disasters and Calamities','Wounded-in-Action AFP & PNP Personnel','Others'] as $option)<label class="choice"><input type="checkbox" name="learner_classification[]" value="{{ $option }}" @checked(in_array($option, old('learner_classification', []), true))>{{ $option }}</label>@endforeach</div>
  </section>

  <section class="learner-section">
    <h3>9. Disability &amp; Scholarship</h3><p>Complete these fields when applicable to the learner.</p>
    <div class="learner-grid">
      <div class="learner-field full"><label>Type of Disability</label><div class="choice-grid">@foreach(['Mental/Intellectual','Hearing','Psychosocial','Visual','Speech Impairment','Disability Due to Chronic Illness','Orthopedic (Musculoskeletal)','Multiple Disabilities','Learning Disability'] as $option)<label class="choice"><input type="checkbox" name="disability_types[]" value="{{ $option }}" @checked(in_array($option, old('disability_types', []), true))>{{ $option }}</label>@endforeach</div></div>
      <div class="learner-field"><label for="disability_cause">Cause of Disability</label><select class="learner-input" id="disability_cause" name="disability_cause"><option value="">Not applicable</option>@foreach(['Congenital/Inborn','Illness','Injury'] as $option)<option value="{{ $option }}" @selected(old('disability_cause') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="learner-field"><label for="scholarship_package">Scholarship Package</label><input class="learner-input" id="scholarship_package" name="scholarship_package" value="{{ old('scholarship_package') }}" placeholder="TWSP, PESFA, STEP, others"></div>
    </div>
  </section>

  <section class="learner-section">
    <h3>10. Supporting Documents</h3><p>Mark the documents submitted during registration.</p>
    <div class="choice-grid">@foreach(['Diploma / Form 137 / TOR','Certificate of Residency','Valid Government ID','Birth Certificate','Medical Certificate'] as $option)<label class="choice"><input type="checkbox" name="documents[]" value="{{ $option }}" @checked(in_array($option, old('documents', []), true))>{{ $option }}</label>@endforeach</div>
    <div class="learner-field" style="margin-top:1rem;"><label for="supporting_documents">Upload Documents</label><input class="learner-input" id="supporting_documents" name="supporting_documents[]" type="file" multiple accept="application/pdf,image/jpeg,image/png,image/webp"><small class="learner-help">PDF, JPG, PNG, or WebP; up to 5 MB per file and 10 files.</small></div>
  </section>

  <section class="learner-section">
    <h3>11. Account Information</h3><p>Create the learner's login credentials.</p>
    <div class="learner-grid">
      <div class="learner-field"><label for="username">Username *</label><input class="learner-input" id="username" name="username" value="{{ old('username') }}" readonly required></div>
      <div class="learner-field"><label for="password">Temporary Password *</label><input class="learner-input" id="password" name="password" type="text" value="{{ old('password', 'SkillUp26') }}" minlength="6" required></div>
    </div>
    <small class="learner-help">The learner should change this temporary password after signing in.</small>
  </section>

  <section class="learner-section">
    <h3>12. Privacy Consent &amp; Signature</h3><p>Record consent and the paper form completion details.</p>
    <label class="choice"><input type="checkbox" name="privacy_confirmation" value="1" required @checked(old('privacy_confirmation'))> I confirm that the information provided is accurate and that the learner has consented to its use for SIAS purposes. *</label>
    <div class="learner-grid" style="margin-top:1rem;">
      <div class="learner-field"><label for="privacy_response">Privacy Response *</label><select class="learner-input" id="privacy_response" name="privacy_response" required><option value="">Select response</option><option value="Agree" @selected(old('privacy_response') === 'Agree')>Agree</option><option value="Disagree" @selected(old('privacy_response') === 'Disagree')>Disagree</option></select></div>
      <div class="learner-field"><label for="applicant_signature">Applicant Signature / Printed Name</label><input class="learner-input" id="applicant_signature" name="applicant_signature" value="{{ old('applicant_signature') }}"></div>
      <div class="learner-field"><label for="signature_date">Date Accomplished</label><input class="learner-input" id="signature_date" name="signature_date" type="date" value="{{ old('signature_date') }}"></div>
      <div class="learner-field"><label for="received_by">Registrar / School Administrator</label><input class="learner-input" id="received_by" name="received_by" value="{{ old('received_by') }}"></div>
      <div class="learner-field"><label for="received_date">Date Received</label><input class="learner-input" id="received_date" name="received_date" type="date" value="{{ old('received_date') }}"></div>
      <div class="learner-field full"><label for="thumbprint">Right Thumbmark</label><input class="learner-input" id="thumbprint" name="thumbprint" type="file" accept="image/jpeg,image/png,image/webp"><small class="learner-help">Upload a clear image of the learner's right thumbmark, up to 2 MB.</small></div>
    </div>
  </section>

  <section class="admin-card" style="display:flex; justify-content:flex-end; gap:.75rem; flex-wrap:wrap;">
    <a href="{{ route('sias.admin.students.index') }}" class="btn btn-secondary" style="width:auto;">Cancel</a>
    <button type="submit" class="btn" style="width:auto;">Register New Learner</button>
  </section>
</form>

<script>
  document.getElementById('student_id')?.addEventListener('input', function () {
    document.getElementById('username').value = this.value.trim();
  });
  document.getElementById('student_id')?.dispatchEvent(new Event('input'));
</script>
@endsection
