@extends('sias.admin.layouts.master')

@section('title', 'Edit Teacher — ' . $user->name . ' — SIAS Admin')
@section('page_title', 'Edit Teacher Profile')
@section('subtitle', 'Update teacher credentials, assign subjects, or adjust faculty designation.')

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
  .tm-edit-container {
    max-width: 860px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Profile Overview Card */
  .tm-profile-header {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 24px;
    box-shadow: var(--card-shadow);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
  }

  .tm-profile-info {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .tm-avatar-lg {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.15), rgba(124, 92, 255, 0.15));
    border: 1px solid var(--card-border);
    color: var(--accent);
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .tm-profile-name {
    font-family: var(--font-display);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 4px;
  }

  .tm-profile-email {
    font-size: 0.86rem;
    color: var(--text-muted);
    font-family: var(--font-mono);
  }

  .tm-profile-stats {
    display: flex;
    gap: 14px;
  }

  .tm-mini-stat {
    text-align: center;
    padding: 8px 16px;
    border-radius: 10px;
    background: var(--pill-bg);
    border: 1px solid var(--card-border);
  }

  .tm-mini-val {
    font-family: var(--font-mono);
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--text);
  }

  .tm-mini-lbl {
    font-size: 0.72rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  /* Form Card */
  .tm-form-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 28px;
    box-shadow: var(--card-shadow);
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

  /* Danger Zone */
  .tm-danger-card {
    background: rgba(239, 68, 68, 0.03);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 16px;
    padding: 24px;
  }

  .tm-danger-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
  }

  .tm-danger-title {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 700;
    color: #dc2626;
    margin: 0 0 4px;
  }

  .tm-danger-desc {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
  }

  .tm-btn-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
    padding: 0.65rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all var(--dur-fast) var(--ease);
  }

  .tm-btn-danger:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
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

<div class="tm-edit-container">
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

  <!-- Profile Overview Card -->
  @php
    $initials = collect(explode(' ', $user->name))
      ->map(fn($part) => strtoupper(substr($part, 0, 1)))
      ->take(2)
      ->implode('');
  @endphp
  <div class="tm-profile-header">
    <div class="tm-profile-info">
      <div class="tm-avatar-lg" aria-hidden="true">{{ $initials ?: 'T' }}</div>
      <div>
        <h2 class="tm-profile-name">{{ $user->name }}</h2>
        <div class="tm-profile-email">{{ $user->email }}</div>
      </div>
    </div>
    <div class="tm-profile-stats">
      <div class="tm-mini-stat">
        <div class="tm-mini-val">{{ $user->subjects->count() }}</div>
        <div class="tm-mini-lbl">Subjects</div>
      </div>
      <div class="tm-mini-stat">
        <div class="tm-mini-val">{{ $user->courses->count() }}</div>
        <div class="tm-mini-lbl">Courses</div>
      </div>
    </div>
  </div>

  <!-- Edit Details Form -->
  <div class="tm-form-card">
    <form action="{{ route('sias.admin.teachers.update', $user) }}" method="POST">
      @csrf
      @method('PUT')

      <h3 class="tm-section-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        Personal & Account Details
      </h3>

      <div class="tm-form-grid">
        <div class="tm-form-group">
          <label class="tm-label">Full Name <span class="req">*</span></label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" class="tm-input" required />
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Email Address <span class="req">*</span></label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" class="tm-input" required />
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Staff Designation</label>
          <select name="staff_type" class="tm-select">
            <option value="teacher" {{ old('staff_type', $user->staff_type) === 'teacher' ? 'selected' : '' }}>Teacher (Regular Faculty)</option>
            <option value="instructor" {{ old('staff_type', $user->staff_type) === 'instructor' ? 'selected' : '' }}>Instructor (Course Trainer)</option>
          </select>
        </div>

        <div class="tm-form-group">
          <label class="tm-label">Reset Password (Optional)</label>
          <input type="password" name="password" class="tm-input" placeholder="Leave blank to keep existing password" />
          <span class="tm-helper">Minimum 8 characters if changing.</span>
        </div>
      </div>

      <!-- Assign Subjects -->
      <h3 class="tm-section-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
        Assigned Teaching Subjects
      </h3>
      @php
        $assignedSubjectIds = old('subject_ids', $user->subjects->pluck('id')->toArray());
      @endphp
      <div class="tm-check-grid">
        @forelse($subjects as $subject)
          <label class="tm-check-item">
            <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ in_array($subject->id, $assignedSubjectIds) ? 'selected' : '' }} {{ in_array($subject->id, $assignedSubjectIds) ? 'checked' : '' }} />
            <div>
              <div class="tm-check-text">{{ $subject->title }}</div>
              <div class="tm-check-meta">
                {{ $subject->subject_code ? '[' . $subject->subject_code . '] ' : '' }}{{ $subject->course->title ?? 'General' }}
              </div>
            </div>
          </label>
        @empty
          <p style="grid-column: 1 / -1; color: var(--text-muted); font-size: 0.85rem; padding: 8px;">No subjects available.</p>
        @endforelse
      </div>

      <!-- Assign Courses -->
      <h3 class="tm-section-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        Assigned Teaching Courses
      </h3>
      @php
        $assignedCourseIds = old('course_ids', $user->courses->pluck('id')->toArray());
      @endphp
      <div class="tm-check-grid">
        @forelse($courses as $course)
          <label class="tm-check-item">
            <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" {{ in_array($course->id, $assignedCourseIds) ? 'selected' : '' }} {{ in_array($course->id, $assignedCourseIds) ? 'checked' : '' }} />
            <div>
              <div class="tm-check-text">{{ $course->title }}</div>
              <div class="tm-check-meta">{{ $course->category ?? 'Course Program' }}</div>
            </div>
          </label>
        @empty
          <p style="grid-column: 1 / -1; color: var(--text-muted); font-size: 0.85rem; padding: 8px;">No courses available.</p>
        @endforelse
      </div>

      <div class="tm-form-actions">
        <button type="submit" class="btn" style="width: auto; padding: 0.75rem 1.6rem;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
          <span>Save Changes</span>
        </button>
        <a href="{{ route('sias.admin.teachers') }}" class="btn btn-secondary" style="width: auto; padding: 0.75rem 1.4rem;">Cancel</a>
      </div>
    </form>
  </div>

  <!-- Danger Zone Card -->
  <div class="tm-danger-card">
    <div class="tm-danger-header">
      <div>
        <h4 class="tm-danger-title">Demote from Teacher Role</h4>
        <p class="tm-danger-desc">This will revert {{ $user->name }} back to a regular student account and unassign all teaching duties.</p>
      </div>
      <form action="{{ route('sias.admin.teachers.demote', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to demote {{ addslashes($user->name) }} back to a student?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="tm-btn-danger">Demote to Student</button>
      </form>
    </div>
  </div>
</div>
@endsection
