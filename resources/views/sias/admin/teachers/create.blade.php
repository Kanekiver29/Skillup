@extends('sias.admin.layouts.master')

@section('title', 'Create Teacher — SIAS Admin')
@section('page_title', 'Add New Teacher')
@section('subtitle', 'Create a new faculty account or promote an existing student to the teaching staff.')

@section('header_actions')
  <a href="{{ route('sias.admin.teachers') }}" class="btn btn-secondary" title="Return to teacher list">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <line x1="19" y1="12" x2="5" y2="12"></line>
      <polyline points="12 19 5 12 12 5"></polyline>
    </svg>
    <span>Back to Teachers</span>
  </a>
@endsection

@section('content')
<style>
  .tm-form-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--card-shadow);
    max-width: 840px;
    margin: 0 auto;
  }

  .tm-mode-tabs {
    display: flex;
    gap: 8px;
    padding: 6px;
    background: var(--pill-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    margin-bottom: 24px;
  }

  .tm-tab-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-family: inherit;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--dur-fast) var(--ease);
  }

  .tm-tab-btn.active {
    background: var(--card-bg);
    color: var(--text);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .tm-section-title {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
    margin: 24px 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .tm-section-title:first-of-type {
    margin-top: 0;
  }

  .tm-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
  }

  .tm-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .tm-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text);
  }

  .tm-label .req {
    color: #ef4444;
  }

  .tm-input,
  .tm-select {
    width: 100%;
    height: 44px;
    padding: 0 14px;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: var(--card-bg);
    color: var(--text);
    font-family: inherit;
    font-size: 0.92rem;
    transition: border-color var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease);
  }

  .tm-input:focus,
  .tm-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }

  .tm-helper {
    font-size: 0.78rem;
    color: var(--text-muted);
  }

  /* Multi-select check list container */
  .tm-check-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 10px;
    max-height: 240px;
    overflow-y: auto;
    padding: 12px;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    background: var(--pill-bg);
  }

  .tm-check-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    cursor: pointer;
    transition: all var(--dur-fast) var(--ease);
  }

  .tm-check-item:hover {
    border-color: var(--accent);
    transform: translateY(-1px);
  }

  .tm-check-item input[type="checkbox"] {
    margin-top: 3px;
    accent-color: var(--accent);
    cursor: pointer;
  }

  .tm-check-text {
    font-size: 0.86rem;
    font-weight: 500;
    color: var(--text);
    line-height: 1.3;
  }

  .tm-check-meta {
    font-size: 0.74rem;
    color: var(--text-muted);
    font-family: var(--font-mono);
    margin-top: 2px;
  }

  /* Form actions */
  .tm-form-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid var(--card-border);
  }

  /* Validation error box */
  .tm-errors-box {
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid rgba(239, 68, 68, 0.25);
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 20px;
    color: #dc2626;
  }

  .tm-errors-box ul {
    margin: 6px 0 0;
    padding-left: 20px;
    font-size: 0.86rem;
  }
</style>

<div class="tm-form-card">
  @if($errors->any())
    <div class="tm-errors-box">
      <div style="font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <span>Please resolve the following errors:</span>
      </div>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Mode Selector Tabs -->
  <div class="tm-mode-tabs" role="tablist">
    <button type="button" class="tm-tab-btn active" id="tabNewUser" onclick="switchMode('new')">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
      <span>Create New Account</span>
    </button>
    <button type="button" class="tm-tab-btn" id="tabPromote" onclick="switchMode('promote')">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      <span>Promote Existing Student</span>
    </button>
  </div>

  <form action="{{ route('sias.admin.teachers.store') }}" method="POST" id="teacherForm">
    @csrf

    <!-- Promote Existing Student Section -->
    <div id="promoteSection" style="display: none;">
      <h3 class="tm-section-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        Select Student Account
      </h3>
      <div class="tm-form-group" style="margin-bottom: 20px;">
        <label class="tm-label">Student to Promote <span class="req">*</span></label>
        <select name="user_id" id="userIdSelect" class="tm-select">
          <option value="">— Select a registered student —</option>
          @foreach($students as $student)
            <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
              {{ $student->name }} ({{ $student->email }})
            </option>
          @endforeach
        </select>
        <span class="tm-helper">The selected student will have their role elevated to teaching faculty.</span>
      </div>
    </div>

    <!-- New Teacher Account Section -->
    <div id="newAccountSection">
      <h3 class="tm-section-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        Account Information
      </h3>
      <div class="tm-form-grid">
        <div class="tm-form-group">
          <label class="tm-label">Full Name <span class="req">*</span></label>
          <input type="text" name="name" id="inputName" value="{{ old('name') }}" class="tm-input" placeholder="e.g. Dr. Maria Santos" />
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Email Address <span class="req">*</span></label>
          <input type="email" name="email" id="inputEmail" value="{{ old('email') }}" class="tm-input" placeholder="e.g. maria.santos@skillup.edu" />
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Password <span class="req">*</span></label>
          <input type="password" name="password" id="inputPassword" class="tm-input" placeholder="Min. 8 characters" />
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Confirm Password <span class="req">*</span></label>
          <input type="password" name="password_confirmation" id="inputPasswordConf" class="tm-input" placeholder="Re-type password" />
        </div>
      </div>
    </div>

    <!-- Staff Role & Designation -->
    <h3 class="tm-section-title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
      Role & Designation
    </h3>
    <div class="tm-form-group" style="max-width: 380px;">
      <label class="tm-label">Staff Type <span class="req">*</span></label>
      <select name="staff_type" class="tm-select">
        <option value="teacher" {{ old('staff_type', 'teacher') === 'teacher' ? 'selected' : '' }}>Teacher (Regular Faculty)</option>
        <option value="instructor" {{ old('staff_type') === 'instructor' ? 'selected' : '' }}>Instructor (Course Trainer)</option>
      </select>
    </div>

    <!-- Assign Subjects -->
    <h3 class="tm-section-title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
      Assign Teaching Subjects (Optional)
    </h3>
    <div class="tm-check-grid">
      @forelse($subjects as $subject)
        <label class="tm-check-item">
          <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subject_ids', [])) ? 'selected' : '' }} />
          <div>
            <div class="tm-check-text">{{ $subject->title }}</div>
            <div class="tm-check-meta">
              {{ $subject->subject_code ? '[' . $subject->subject_code . '] ' : '' }}{{ $subject->course->title ?? 'General' }}
            </div>
          </div>
        </label>
      @empty
        <p style="grid-column: 1 / -1; color: var(--text-muted); font-size: 0.85rem; padding: 8px;">No subjects created yet.</p>
      @endforelse
    </div>

    <!-- Assign Courses -->
    <h3 class="tm-section-title">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
      Assign Teaching Courses (Optional)
    </h3>
    <div class="tm-check-grid">
      @forelse($courses as $course)
        <label class="tm-check-item">
          <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" {{ in_array($course->id, old('course_ids', [])) ? 'selected' : '' }} />
          <div>
            <div class="tm-check-text">{{ $course->title }}</div>
            <div class="tm-check-meta">{{ $course->category ?? 'Course Program' }}</div>
          </div>
        </label>
      @empty
        <p style="grid-column: 1 / -1; color: var(--text-muted); font-size: 0.85rem; padding: 8px;">No courses created yet.</p>
      @endforelse
    </div>

    <div class="tm-form-actions">
      <button type="submit" class="btn" style="width: auto; padding: 0.75rem 1.6rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
        <span>Save Teacher</span>
      </button>
      <a href="{{ route('sias.admin.teachers') }}" class="btn btn-secondary" style="width: auto; padding: 0.75rem 1.4rem;">Cancel</a>
    </div>
  </form>
</div>

<script>
  function switchMode(mode) {
    var newTab = document.getElementById('tabNewUser');
    var promoteTab = document.getElementById('tabPromote');
    var newSection = document.getElementById('newAccountSection');
    var promoteSection = document.getElementById('promoteSection');
    var userIdSelect = document.getElementById('userIdSelect');

    if (mode === 'promote') {
      promoteTab.classList.add('active');
      newTab.classList.remove('active');
      promoteSection.style.display = 'block';
      newSection.style.display = 'none';
      if (userIdSelect) userIdSelect.required = true;
    } else {
      newTab.classList.add('active');
      promoteTab.classList.remove('active');
      newSection.style.display = 'block';
      promoteSection.style.display = 'none';
      if (userIdSelect) {
        userIdSelect.required = false;
        userIdSelect.value = '';
      }
    }
  }

  // Initialize mode based on old input
  @if(old('user_id'))
    switchMode('promote');
  @else
    switchMode('new');
  @endif
</script>
@endsection
