@extends('sias.admin.layouts.master')

@section('title', 'Teacher Management — SIAS Admin')
@section('page_title', 'Teacher Management')
@section('subtitle', 'Manage faculty members, assign instructors, and configure teaching loads.')

@section('header_actions')
  <a href="{{ route('sias.admin.teachers.create') }}" class="btn" title="Add a new teacher or promote student">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span>Add Teacher</span>
  </a>
@endsection

@section('content')
<style>
  /* ---------- Teacher Module Component Styles ---------- */
  .tm-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }

  .tm-stat-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 20px;
    box-shadow: var(--card-shadow);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease);
  }

  .tm-stat-card:hover {
    transform: translateY(-2px);
    border-color: var(--accent);
    box-shadow: 0 12px 24px -10px var(--accent-glow);
  }

  .tm-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .tm-stat-val {
    font-family: var(--font-display);
    font-size: 1.65rem;
    font-weight: 700;
    line-height: 1.1;
    color: var(--text);
  }

  .tm-stat-lbl {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
    margin-top: 2px;
    letter-spacing: 0.02em;
  }

  /* ---------- Search & Filter Toolbar ---------- */
  .tm-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
  }

  .tm-search-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    max-width: 600px;
    flex-wrap: wrap;
  }

  .tm-input-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
  }

  .tm-input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
  }

  .tm-input {
    width: 100%;
    height: 42px;
    padding: 0 14px 0 38px;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: var(--card-bg);
    color: var(--text);
    font-family: inherit;
    font-size: 0.9rem;
    transition: border-color var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease);
  }

  .tm-input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }

  .tm-select {
    height: 42px;
    padding: 0 32px 0 14px;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: var(--card-bg);
    color: var(--text);
    font-family: inherit;
    font-size: 0.88rem;
    font-weight: 500;
    cursor: pointer;
    transition: border-color var(--dur-fast) var(--ease);
  }

  .tm-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }

  .tm-btn-sm {
    height: 42px;
    padding: 0 16px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all var(--dur-fast) var(--ease);
  }

  .tm-btn-primary {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    color: #fff;
    box-shadow: 0 4px 12px var(--accent-glow);
  }

  .tm-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px var(--accent-glow);
  }

  .tm-btn-ghost {
    background: var(--pill-bg);
    color: var(--text-muted);
    border: 1px solid var(--card-border);
  }

  .tm-btn-ghost:hover {
    color: var(--text);
    border-color: var(--accent);
  }

  /* ---------- Table Layout ---------- */
  .tm-table-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
  }

  .tm-table-wrap {
    width: 100%;
    overflow-x: auto;
  }

  .tm-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.92rem;
    text-align: left;
  }

  .tm-table thead th {
    padding: 14px 18px;
    font-family: var(--font-mono);
    font-size: 0.74rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: var(--text-muted);
    border-bottom: 1px solid var(--card-border);
    background: rgba(11, 17, 32, 0.02);
    white-space: nowrap;
  }

  .tm-table tbody tr {
    border-bottom: 1px solid var(--card-border);
    transition: background-color var(--dur-fast) var(--ease);
  }

  .tm-table tbody tr:hover {
    background-color: var(--pill-bg);
  }

  .tm-table tbody td {
    padding: 16px 18px;
    vertical-align: middle;
  }

  /* User Info Badge */
  .tm-user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .tm-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.15), rgba(124, 92, 255, 0.15));
    border: 1px solid var(--card-border);
    color: var(--accent);
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .tm-user-name {
    font-weight: 600;
    color: var(--text);
    margin-bottom: 2px;
  }

  .tm-user-email {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: var(--font-mono);
  }

  /* Badges */
  .tm-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    white-space: nowrap;
  }

  .tm-badge-teacher {
    background: rgba(8, 145, 178, 0.12);
    color: var(--accent);
    border: 1px solid rgba(8, 145, 178, 0.25);
  }

  .tm-badge-instructor {
    background: rgba(124, 92, 255, 0.12);
    color: var(--accent-2);
    border: 1px solid rgba(124, 92, 255, 0.25);
  }

  .tm-count-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 26px;
    height: 24px;
    padding: 0 8px;
    border-radius: 999px;
    background: var(--pill-bg);
    border: 1px solid var(--card-border);
    font-family: var(--font-mono);
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--text);
  }

  /* Action Buttons */
  .tm-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
  }

  .tm-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--card-border);
    background: var(--card-bg);
    color: var(--text-muted);
    cursor: pointer;
    text-decoration: none;
    transition: all var(--dur-fast) var(--ease);
  }

  .tm-action-btn:hover {
    color: var(--accent);
    border-color: var(--accent);
    transform: translateY(-1px);
    box-shadow: 0 0 0 2px var(--accent-glow);
  }

  .tm-action-danger:hover {
    color: #ef4444;
    border-color: #ef4444;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25);
  }

  /* Alerts */
  .tm-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 0.92rem;
    animation: fade-up 0.3s var(--ease) both;
  }

  .tm-alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #16a34a;
  }

  .tm-alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
  }

  /* Empty State */
  .tm-empty {
    text-align: center;
    padding: 50px 20px;
    color: var(--text-muted);
  }

  .tm-empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: var(--pill-bg);
    border: 1px solid var(--card-border);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    margin-bottom: 16px;
  }
</style>

{{-- Flash Feedback Alerts --}}
@if(session('success'))
  <div class="tm-alert tm-alert-success" role="alert">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
      <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <div style="flex: 1;">{{ session('success') }}</div>
  </div>
@endif

@if(session('error'))
  <div class="tm-alert tm-alert-error" role="alert">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="12" cy="12" r="10"></circle>
      <line x1="12" y1="8" x2="12" y2="12"></line>
      <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <div style="flex: 1;">{{ session('error') }}</div>
  </div>
@endif

{{-- Stats HUD Grid --}}
<div class="tm-stats-grid">
  <div class="tm-stat-card">
    <div class="tm-stat-icon" style="background: rgba(8, 145, 178, 0.12); color: var(--accent);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
      </svg>
    </div>
    <div>
      <div class="tm-stat-val">{{ $stats['total'] ?? 0 }}</div>
      <div class="tm-stat-lbl">Total Teachers</div>
    </div>
  </div>

  <div class="tm-stat-card">
    <div class="tm-stat-icon" style="background: rgba(124, 92, 255, 0.12); color: var(--accent-2);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
        <line x1="8" y1="21" x2="16" y2="21"></line>
        <line x1="12" y1="17" x2="12" y2="21"></line>
      </svg>
    </div>
    <div>
      <div class="tm-stat-val">{{ $stats['instructors'] ?? 0 }}</div>
      <div class="tm-stat-lbl">Instructors</div>
    </div>
  </div>

  <div class="tm-stat-card">
    <div class="tm-stat-icon" style="background: rgba(34, 197, 94, 0.12); color: var(--ok);">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
      </svg>
    </div>
    <div>
      <div class="tm-stat-val">{{ $stats['teachers'] ?? 0 }}</div>
      <div class="tm-stat-lbl">Faculty Staff</div>
    </div>
  </div>

  <div class="tm-stat-card">
    <div class="tm-stat-icon" style="background: rgba(234, 179, 8, 0.12); color: #eab308;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
      </svg>
    </div>
    <div>
      <div class="tm-stat-val">{{ $stats['assigned_subjects'] ?? 0 }}</div>
      <div class="tm-stat-lbl">Assigned Subjects</div>
    </div>
  </div>
</div>

{{-- Search & Filter Toolbar --}}
<div class="tm-toolbar">
  <form method="GET" action="{{ route('sias.admin.teachers') }}" class="tm-search-form">
    <div class="tm-input-wrap">
      <svg class="tm-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search teacher name, email..." class="tm-input" />
    </div>

    <select name="type" class="tm-select" onchange="this.form.submit()">
      <option value="">All Staff Roles</option>
      <option value="teacher" {{ request('type') === 'teacher' ? 'selected' : '' }}>Teachers</option>
      <option value="instructor" {{ request('type') === 'instructor' ? 'selected' : '' }}>Instructors</option>
    </select>

    <button type="submit" class="tm-btn-sm tm-btn-primary">
      <span>Filter</span>
    </button>

    @if(request()->hasAny(['search', 'type']))
      <a href="{{ route('sias.admin.teachers') }}" class="tm-btn-sm tm-btn-ghost">Clear</a>
    @endif
  </form>

  <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-muted);">
    Showing <strong>{{ $teachers->count() }}</strong> of <strong>{{ $teachers->total() }}</strong> faculty
  </div>
</div>

{{-- Data Table --}}
<div class="tm-table-card">
  <div class="tm-table-wrap">
    <table class="tm-table">
      <thead>
        <tr>
          <th>Teacher Profile</th>
          <th>Staff Type</th>
          <th style="text-align: center;">Subjects</th>
          <th style="text-align: center;">Courses</th>
          <th>Joined Date</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($teachers as $teacher)
          @php
            $initials = collect(explode(' ', $teacher->name))
              ->map(fn($part) => strtoupper(substr($part, 0, 1)))
              ->take(2)
              ->implode('');
            $staffType = strtolower($teacher->staff_type ?? $teacher->role ?? 'teacher');
          @endphp
          <tr>
            <td>
              <div class="tm-user-cell">
                <div class="tm-avatar" aria-hidden="true">{{ $initials ?: 'T' }}</div>
                <div>
                  <div class="tm-user-name">{{ $teacher->name }}</div>
                  <div class="tm-user-email">{{ $teacher->email }}</div>
                </div>
              </div>
            </td>
            <td>
              @if($staffType === 'instructor')
                <span class="tm-badge tm-badge-instructor">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                  Instructor
                </span>
              @else
                <span class="tm-badge tm-badge-teacher">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                  Teacher
                </span>
              @endif
            </td>
            <td style="text-align: center;">
              <span class="tm-count-pill" title="{{ $teacher->subjects_count }} subjects assigned">
                {{ $teacher->subjects_count ?? 0 }}
              </span>
            </td>
            <td style="text-align: center;">
              <span class="tm-count-pill" title="{{ $teacher->courses_count }} courses assigned">
                {{ $teacher->courses_count ?? 0 }}
              </span>
            </td>
            <td>
              <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-muted);">
                {{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : '—' }}
              </span>
            </td>
            <td>
              <div class="tm-actions">
                <a href="{{ route('sias.admin.teachers.edit', $teacher) }}" class="tm-action-btn" title="Edit Teacher">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </a>
                <form action="{{ route('sias.admin.teachers.demote', $teacher) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to demote/remove {{ addslashes($teacher->name) }} from the teacher role?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tm-action-btn tm-action-danger" title="Demote to Student">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">
              <div class="tm-empty">
                <div class="tm-empty-icon" aria-hidden="true">
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="17" y1="8" x2="23" y2="14"></line>
                    <line x1="23" y1="8" x2="17" y2="14"></line>
                  </svg>
                </div>
                <h3 style="margin: 0 0 6px; font-family: var(--font-display); color: var(--text);">No teachers found</h3>
                <p style="margin: 0 0 18px; font-size: 0.88rem;">No teacher accounts match your current filters.</p>
                <a href="{{ route('sias.admin.teachers.create') }}" class="btn" style="display: inline-flex; width: auto; font-size: 0.85rem; padding: 0.65rem 1.1rem;">
                  Add New Teacher
                </a>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($teachers->hasPages())
    <div style="padding: 16px 20px; border-top: 1px solid var(--card-border); display: flex; justify-content: center;">
      {{ $teachers->links() }}
    </div>
  @endif
</div>
@endsection
