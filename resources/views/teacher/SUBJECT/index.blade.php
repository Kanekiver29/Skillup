@extends('teacher.layouts.master')

@section('title', 'Subject Management')
@section('page_title', 'Subject Directory')

@section('content')
<style>
    .subj-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .subj-title-area h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--navy-950);
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .subj-title-area p {
        color: var(--muted);
        font-size: 0.92rem;
        margin-top: 0.25rem;
    }
    .btn-create {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.75rem 1.4rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 18px var(--accent-glow);
        transition: all 0.25s var(--ease);
    }
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--accent-glow);
        color: #fff;
    }

    /* Stats bar */
    .subj-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        box-shadow: var(--shadow-xs);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.25s var(--ease);
    }
    .stat-card:hover {
        border-color: var(--navy-200);
        box-shadow: var(--shadow-card);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: var(--navy-50);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .stat-info .num {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--navy-950);
        line-height: 1.1;
    }
    .stat-info .lbl {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.2rem;
    }

    /* Search & Filters */
    .filter-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .search-box {
        position: relative;
        flex: 1;
        min-width: 260px;
    }
    .search-box input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.6rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-size: 0.9rem;
        transition: all 0.2s var(--ease);
    }
    .search-box input:focus {
        border-color: var(--accent-2);
        box-shadow: 0 0 0 3px var(--accent-muted);
        outline: none;
    }
    .search-box svg {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        width: 18px;
        height: 18px;
    }
    .btn-preview-userpage {
        background: var(--navy-50);
        color: var(--accent);
        border: 1px solid var(--navy-100);
        font-weight: 700;
        padding: 0.65rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        transition: all 0.2s var(--ease);
    }
    .btn-preview-userpage:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }

    /* Cards Grid */
    .subject-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .subject-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: all 0.3s var(--ease);
    }
    .subject-box:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: var(--navy-200);
    }
    .subject-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent), var(--signature));
    }
    .subj-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
    }
    .subj-code-tag {
        background: var(--navy-50);
        color: var(--navy-800);
        font-weight: 800;
        font-size: 0.75rem;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-sm);
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1px solid var(--navy-100);
    }
    .status-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 99px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .status-badge.active {
        background: rgba(34, 197, 94, 0.12);
        color: #16a34a;
    }
    .status-badge.inactive {
        background: rgba(220, 38, 38, 0.12);
        color: #dc2626;
    }
    .subj-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--navy-950);
        line-height: 1.3;
        margin-bottom: 0.5rem;
    }
    .subj-desc {
        color: var(--muted);
        font-size: 0.88rem;
        line-height: 1.5;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .connection-pill {
        background: var(--surface-2);
        border: 1px dashed var(--navy-200);
        border-radius: var(--radius-md);
        padding: 0.6rem 0.85rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        color: var(--text-2);
    }
    .connection-pill svg {
        color: var(--accent);
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }
    .connection-pill strong {
        color: var(--navy-950);
    }
    .subj-meta-row {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        font-size: 0.82rem;
        color: var(--muted);
        border-top: 1px solid var(--border-soft);
        padding-top: 0.85rem;
        margin-bottom: 1.25rem;
    }
    .subj-meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-weight: 600;
    }
    .subj-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .action-btn {
        flex: 1;
        padding: 0.55rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.83rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.2s var(--ease);
        border: 1px solid transparent;
    }
    .btn-lessons {
        background: var(--accent);
        color: #fff;
    }
    .btn-lessons:hover {
        background: var(--navy-600);
        color: #fff;
    }
    .btn-edit-subj {
        background: var(--navy-50);
        color: var(--navy-800);
        border-color: var(--navy-200);
    }
    .btn-edit-subj:hover {
        background: var(--navy-100);
        color: var(--navy-950);
    }
    .btn-del-subj {
        background: rgba(220, 74, 74, 0.08);
        color: var(--danger);
        padding: 0.55rem 0.65rem;
    }
    .btn-del-subj:hover {
        background: var(--danger);
        color: #fff;
    }
    .empty-card {
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: var(--radius-xl);
        padding: 4rem 2rem;
        text-align: center;
        grid-column: 1 / -1;
    }
    .empty-card-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
</style>

<div class="subj-header">
    <div class="subj-title-area">
        <h1>📖 Subject Management</h1>
        <p>Manage your academic subjects and connect them directly with student courses and lessons.</p>
    </div>
    <a href="{{ route('teacher.subjects.create') }}" class="btn-create">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Subject
    </a>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #15803d; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 0.6rem; font-weight: 600;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:currentColor; cursor:pointer; font-size:1.1rem;">&times;</button>
    </div>
@endif

{{-- Stats Overview --}}
<div class="subj-stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-info">
            <div class="num">{{ $subjects->total() ?? $subjects->count() }}</div>
            <div class="lbl">Total Subjects</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🔗</div>
        <div class="stat-info">
            <div class="num">{{ $coursesCount ?? 0 }}</div>
            <div class="lbl">Connected Courses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
            <div class="num">{{ $activeCount ?? 0 }}</div>
            <div class="lbl">Active Subjects</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏱️</div>
        <div class="stat-info">
            <div class="num">{{ $totalUnits ?? 0 }}</div>
            <div class="lbl">Total Academic Units</div>
        </div>
    </div>
</div>

{{-- Search & Direct Userpage Connection --}}
<div class="filter-card">
    <form method="GET" action="{{ route('teacher.subjects.index') }}" class="search-box">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search subject code, title or details..." onchange="this.form.submit()">
    </form>

    <a href="{{ route('subjects') }}" target="_blank" class="btn-preview-userpage" title="Open student-facing subject view">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        View Live Student Subject Directory
    </a>
</div>

{{-- Subjects List Grid --}}
<div class="subject-grid">
    @forelse($subjects as $subject)
        <div class="subject-box">
            <div>
                <div class="subj-top">
                    <span class="subj-code-tag">{{ $subject->subject_code ?: 'SUBJ-' . $subject->id }}</span>
                    <span class="status-badge {{ $subject->is_active ? 'active' : 'inactive' }}">
                        <span style="width:6px; height:6px; border-radius:50%; background:currentColor;"></span>
                        {{ $subject->is_active ? 'Active' : 'Draft' }}
                    </span>
                </div>

                <h2 class="subj-title">{{ $subject->title }}</h2>
                <p class="subj-desc">{{ $subject->description ?: 'No detailed description specified for this subject.' }}</p>

                <div class="connection-pill">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    <span>
                        Connected Course:
                        <strong>{{ $subject->course?->title ?? 'Unlinked / Standalone' }}</strong>
                    </span>
                </div>

                <div class="subj-meta-row">
                    <div class="subj-meta-item">
                        <span>🎓</span> {{ $subject->units ?: 3 }} Units
                    </div>
                    <div class="subj-meta-item">
                        <span>⏱️</span> {{ $subject->hours ?: 54 }} Hours
                    </div>
                    <div class="subj-meta-item">
                        <span>👨‍🏫</span> {{ $subject->teacher?->name ?: auth()->user()->name }}
                    </div>
                </div>
            </div>

            <div class="subj-actions">
                <a href="{{ route('teacher.subjects.lesson', $subject->id) }}" class="action-btn btn-lessons">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Lessons
                </a>
                <a href="{{ route('teacher.subjects.edit', $subject->id) }}" class="action-btn btn-edit-subj" title="Edit Subject">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('teacher.subjects.destroy', $subject->id) }}" onsubmit="return confirm('Are you sure you want to delete subject {{ $subject->title }}?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-del-subj" title="Delete Subject">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-card">
            <div class="empty-card-icon">📘</div>
            <h3 style="font-size:1.3rem; font-weight:700; color:var(--navy-950); margin-bottom:0.5rem;">No Subjects Created Yet</h3>
            <p style="color:var(--muted); max-width:460px; margin:0 auto 1.5rem;">Create your first academic subject to structure your courses and automatically publish them to the student Userpage course view.</p>
            <a href="{{ route('teacher.subjects.create') }}" class="btn-create">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Your First Subject
            </a>
        </div>
    @endforelse
</div>

@if($subjects->hasPages())
    <div style="margin-top: 2rem;">
        {{ $subjects->links() }}
    </div>
@endif
@endsection
