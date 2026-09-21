@extends('sias.admin.layouts.master')

@section('title', 'View Student')
@section('page_title', 'Student Details')

@section('content')
<style>
  .student-profile-shell {
    position: relative;
    max-width: 760px;
    margin: 0 auto;
  }

  .student-profile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.22);
  }

  .student-identity {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .student-avatar {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, #12b5be, #2873ff);
    color: #ffffff;
    font-size: 1.35rem;
    font-weight: 800;
    box-shadow: 0 12px 24px rgba(39, 115, 255, 0.3);
    animation: studentFloat 0.85s ease both;
  }

  .student-name-wrap h3 {
    margin: 0;
    font-size: clamp(1.5rem, 2vw, 2rem);
    line-height: 1.2;
    color: var(--text);
  }

  .student-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    margin-top: 0.3rem;
    padding: 0.35rem 0.7rem;
    border-radius: 999px;
    background: rgba(24, 145, 140, 0.14);
    border: 1px solid rgba(24, 145, 140, 0.4);
    color: #9be7da;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    animation: badgePop 0.6s ease both;
  }

  .student-summary-grid,
  .student-detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-top: 1.2rem;
  }

  .student-summary-item,
  .student-info-block {
    position: relative;
    border-radius: 16px;
    background: rgba(15, 23, 42, 0.34);
    border: 1px solid rgba(148, 163, 184, 0.18);
    padding: 1rem;
    overflow: hidden;
    transform: translateY(12px);
    animation: itemReveal 0.5s ease forwards;
  }

  .student-summary-item::before,
  .student-info-block::before {
    content: "";
    position: absolute;
    inset: auto -30% 0 auto;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(45, 212, 191, 0.18), transparent 65%);
    pointer-events: none;
  }

  .student-summary-item:nth-child(2) { animation-delay: 0.08s; }
  .student-summary-item:nth-child(3) { animation-delay: 0.16s; }
  .student-summary-item:nth-child(4) { animation-delay: 0.24s; }

  .student-info-block:nth-child(1) { animation-delay: 0.08s; }
  .student-info-block:nth-child(2) { animation-delay: 0.16s; }
  .student-info-block:nth-child(3) { animation-delay: 0.24s; }

  .student-stat-label,
  .student-info-label {
    display: block;
    font-size: 0.72rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 0.4rem;
  }

  .student-stat-value,
  .student-info-value {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    word-break: break-word;
  }

  .student-detail-grid {
    margin-top: 1.2rem;
  }

  .student-info-block {
    min-height: 120px;
  }

  .student-info-value small {
    display: block;
    margin-top: 0.2rem;
    font-size: 0.72rem;
    color: var(--text-muted);
    font-weight: 500;
  }

  .student-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(148, 163, 184, 0.22);
  }

  .student-action-btn {
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    animation: buttonReveal 0.55s ease both;
  }

  .student-action-btn::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.14) 50%, transparent 100%);
    transform: translateX(-120%);
    transition: transform 0.55s ease;
  }

  .student-action-btn:hover::before {
    transform: translateX(120%);
  }

  .student-action-btn.secondary {
    background: rgba(15, 23, 42, 0.28);
    border-color: rgba(148, 163, 184, 0.28);
    color: var(--text);
  }

  .student-action-btn:nth-child(2) { animation-delay: 0.08s; }
  .student-action-btn:nth-child(3) { animation-delay: 0.16s; }
  .student-action-btn:nth-child(4) { animation-delay: 0.24s; }

  @keyframes studentFloat {
    0% { opacity: 0; transform: translateY(-8px) scale(0.9); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
  }

  @keyframes badgePop {
    0% { opacity: 0; transform: scale(0.8); }
    70% { opacity: 1; transform: scale(1.06); }
    100% { opacity: 1; transform: scale(1); }
  }

  @keyframes itemReveal {
    from {
      opacity: 0;
      transform: translateY(14px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes buttonReveal {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .student-avatar,
    .student-role-badge,
    .student-summary-item,
    .student-info-block,
    .student-action-btn {
      animation: none !important;
      transition: none !important;
    }
  }
</style>

<div class="admin-card student-profile-shell">
  <div class="student-profile-header">
    <div class="student-identity">
      <div class="student-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <div class="student-name-wrap">
        <h3>{{ $user->name }}</h3>
        <span class="student-role-badge">{{ $user->role ?? 'student' }}</span>
      </div>
    </div>
  </div>

  <div class="student-summary-grid">
    <div class="student-summary-item">
      <span class="student-stat-label">Student ID</span>
      <span class="student-stat-value">{{ $user->lrn ?? $user->id }}</span>
    </div>
    <div class="student-summary-item">
      <span class="student-stat-label">Email</span>
      <span class="student-stat-value">{{ $user->email ?? '—' }}</span>
    </div>
    <div class="student-summary-item">
      <span class="student-stat-label">Created</span>
      <span class="student-stat-value">{{ $user->created_at ? $user->created_at->toDayDateTimeString() : '—' }}</span>
    </div>
  </div>

  <div class="student-detail-grid">
    <div class="student-info-block">
      <span class="student-info-label">Account Status</span>
      <span class="student-info-value">Active</span>
      <small>Ready for enrollment and record access</small>
    </div>
    <div class="student-info-block">
      <span class="student-info-label">Current Access</span>
      <span class="student-info-value">Student Portal</span>
      <small>Permissions available for academic services</small>
    </div>
    <div class="student-info-block">
      <span class="student-info-label">Last Update</span>
      <span class="student-info-value">{{ $user->updated_at ? $user->updated_at->toDayDateTimeString() : '—' }}</span>
      <small>Most recent profile modification</small>
    </div>
  </div>

  <div class="student-actions">
    <a href="{{ route('sias.admin.students.edit', $user->id) }}" class="admin-actions student-action-btn">Edit</a>
    <a href="{{ route('sias.admin.students.enrollment-certificate', $user->id) }}" class="admin-actions student-action-btn" target="_blank" rel="noopener">Print Enrollment Certificate</a>
    <a href="{{ route('sias.admin.students.grade-certificate', $user->id) }}" class="admin-actions student-action-btn" target="_blank" rel="noopener">Print Grade Certificate</a>
    <a href="{{ route('sias.admin.students.index') }}" class="admin-actions secondary student-action-btn">Back to list</a>
  </div>
</div>
@endsection
