@extends('sias.admin.layouts.master')

@section('title', 'Create New Qualification')
@section('page_title', 'Create New Qualification')
@section('subtitle', 'Register a TESDA-aligned qualification and its units of competency.')

@section('content')
<style>
  .qualification-form { display:grid; gap:1rem; }
  .qualification-section { border:1px solid var(--card-border); border-radius:14px; padding:1.25rem; background:var(--card-bg); }
  .qualification-section h3 { margin:0 0 .25rem; font-family:var(--font-display); }
  .qualification-section > p { margin:0 0 1rem; color:var(--text-muted); font-size:.9rem; }
  .qualification-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1rem; }
  .qualification-field { display:grid; gap:.35rem; }
  .qualification-field.full { grid-column:1 / -1; }
  .qualification-field label { font-weight:600; font-size:.9rem; }
  .qualification-input { width:100%; padding:.72rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text); font:inherit; }
  .qualification-input:focus { border-color:var(--accent); outline:2px solid var(--accent-tint); }
  .competency-row { display:grid; grid-template-columns:150px minmax(0, 1fr) auto; gap:.65rem; align-items:end; margin-top:.65rem; }
  .competency-empty { padding:1rem; border:1px dashed var(--card-border); border-radius:10px; color:var(--text-muted); text-align:center; }
  .remove-competency { width:auto; padding:.7rem .85rem; }
  @media (max-width:650px) { .qualification-grid, .competency-row { grid-template-columns:1fr; } .qualification-field.full { grid-column:auto; } .remove-competency { width:100%; } }
</style>

<form method="POST" action="{{ route('sias.admin.course.store') }}" class="qualification-form">
  @csrf
  @if($errors->any())
    <div class="admin-panel" style="border-color:var(--danger); color:var(--danger);">
      <strong>Please review the qualification fields.</strong>
      <ul style="margin:.5rem 0 0 1.25rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <section class="qualification-section">
    <h3>Qualification Information</h3><p>Identify the TESDA qualification and describe the program.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="qualification_title">Qualification Title *</label><input class="qualification-input" id="qualification_title" name="qualification_title" value="{{ old('qualification_title') }}" placeholder="Computer Systems Servicing NC II" required></div>
      <div class="qualification-field"><label for="qualification_code">Qualification Code *</label><input class="qualification-input" id="qualification_code" name="qualification_code" value="{{ old('qualification_code') }}" placeholder="CSS NC II" required></div>
      <div class="qualification-field"><label for="qualification_level">Qualification Level *</label><select class="qualification-input" id="qualification_level" name="qualification_level" required>@foreach(['NC I','NC II','NC III','NC IV','Diploma'] as $option)<option value="{{ $option }}" @selected(old('qualification_level', 'NC II') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="qualification-field"><label for="sector_industry">Sector / Industry *</label><select class="qualification-input" id="sector_industry" name="sector_industry" required>@foreach(['Information and Communication Technology','Construction','Agriculture','Automotive','Health, Social and Other Community Development Services','Tourism','Other'] as $option)<option value="{{ $option }}" @selected(old('sector_industry') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="qualification-field full"><label for="qualification_description">Description</label><textarea class="qualification-input" id="qualification_description" name="qualification_description" rows="4" placeholder="Description of the qualification...">{{ old('qualification_description') }}</textarea></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>TESDA Registration</h3><p>Record the qualification registration and training regulations reference.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="program_registration_no">Program Registration No. / CoPR No.</label><input class="qualification-input" id="program_registration_no" name="program_registration_no" value="{{ old('program_registration_no') }}"></div>
      <div class="qualification-field"><label for="registration_status">Registration Status *</label><select class="qualification-input" id="registration_status" name="registration_status" required>@foreach(['Registered','Pending','Expired','Suspended'] as $option)<option value="{{ $option }}" @selected(old('registration_status', 'Registered') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="qualification-field"><label for="registration_date">Registration Date</label><input class="qualification-input" id="registration_date" name="registration_date" type="date" value="{{ old('registration_date') }}"></div>
      <div class="qualification-field"><label for="training_regulations_version">Training Regulations Version</label><input class="qualification-input" id="training_regulations_version" name="training_regulations_version" value="{{ old('training_regulations_version') }}" placeholder="TR Version / Year"></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>Training Information</h3><p>Define the nominal duration, delivery mode, and batch capacity.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="nominal_training_duration">Training Duration (Hours) *</label><input class="qualification-input" id="nominal_training_duration" name="nominal_training_duration" type="number" min="0.01" step="0.01" value="{{ old('nominal_training_duration', 436) }}" required></div>
      <div class="qualification-field"><label for="delivery_mode">Delivery Mode *</label><select class="qualification-input" id="delivery_mode" name="delivery_mode" required>@foreach(['Face-to-Face','Online','Blended'] as $option)<option value="{{ $option }}" @selected(old('delivery_mode', 'Face-to-Face') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="qualification-field"><label for="maximum_batch_capacity">Maximum Batch Capacity (Learners) *</label><input class="qualification-input" id="maximum_batch_capacity" name="maximum_batch_capacity" type="number" min="1" value="{{ old('maximum_batch_capacity', 25) }}" required></div>
      <div class="qualification-field"><label for="category">Category *</label><select class="qualification-input" id="category" name="category" required>@foreach(['Certificate','Diploma','Short Course','Other'] as $option)<option value="{{ $option }}" @selected(old('category', 'Certificate') === $option)>{{ $option }}</option>@endforeach</select></div>
      <div class="qualification-field full"><label for="curriculum">Training Regulations / Curriculum Version</label><input class="qualification-input" id="curriculum" name="curriculum" value="{{ old('curriculum') }}" placeholder="TR Version / Curriculum 2024"></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>Qualification Competencies</h3><p>Connect the qualification to its basic, common, and core units of competency.</p>
    <div id="competencies">
      @php($oldCompetencies = old('competencies', [['type' => 'Basic', 'name' => 'Manage Your Own Performance'], ['type' => 'Common', 'name' => 'Apply Quality Standards'], ['type' => 'Core', 'name' => 'Install and Configure Computer Systems']]))
      @foreach($oldCompetencies as $index => $competency)
        <div class="competency-row">
          <div class="qualification-field"><label>Competency Type</label><select class="qualification-input" name="competencies[{{ $index }}][type]"><option value="Basic" @selected(($competency['type'] ?? '') === 'Basic')>Basic</option><option value="Common" @selected(($competency['type'] ?? '') === 'Common')>Common</option><option value="Core" @selected(($competency['type'] ?? '') === 'Core')>Core</option></select></div>
          <div class="qualification-field"><label>Unit of Competency</label><input class="qualification-input" name="competencies[{{ $index }}][name]" value="{{ $competency['name'] ?? '' }}" placeholder="Unit of competency"></div>
          <button type="button" class="btn btn-secondary remove-competency">Remove</button>
        </div>
      @endforeach
    </div>
    <button type="button" id="addCompetency" class="btn btn-secondary" style="width:auto; margin-top:1rem;">+ Add Unit of Competency</button>
  </section>

  <section class="qualification-section">
    <h3>Program Status</h3>
    <input type="hidden" name="program_status" value="Inactive">
    <label style="display:flex;align-items:center;gap:.5rem;font-weight:600;"><input type="checkbox" name="program_status" value="Active" @checked(old('program_status', 'Active') === 'Active')> Active</label>
  </section>

  <section class="admin-card" style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
    <a href="{{ route('sias.admin.course') }}" class="btn btn-secondary" style="width:auto;">Cancel</a>
    <button type="submit" class="btn" style="width:auto;">Create Qualification</button>
  </section>
</form>

<template id="competencyTemplate">
  <div class="competency-row">
    <div class="qualification-field"><label>Competency Type</label><select class="qualification-input" data-name="type"><option value="Basic">Basic</option><option value="Common">Common</option><option value="Core" selected>Core</option></select></div>
    <div class="qualification-field"><label>Unit of Competency</label><input class="qualification-input" data-name="name" placeholder="Unit of competency"></div>
    <button type="button" class="btn btn-secondary remove-competency">Remove</button>
  </div>
</template>
<script>
(function () {
  var list = document.getElementById('competencies');
  var template = document.getElementById('competencyTemplate');
  var add = document.getElementById('addCompetency');
  function reindex() {
    Array.from(list.querySelectorAll('.competency-row')).forEach(function (row, index) {
      row.querySelectorAll('[data-name], select[name], input[name]').forEach(function (field) {
        var name = field.dataset.name || (field.name || '').split(']').pop().replace('[', '');
        if (field.dataset.name) field.name = 'competencies[' + index + '][' + field.dataset.name + ']';
      });
    });
  }
  add.addEventListener('click', function () { list.appendChild(template.content.cloneNode(true)); reindex(); });
  list.addEventListener('click', function (event) { if (event.target.classList.contains('remove-competency')) { event.target.closest('.competency-row').remove(); reindex(); } });
  reindex();
}());
</script>
@endsection
