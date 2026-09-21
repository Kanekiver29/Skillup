@extends('teacher.layouts.master')

@section('title', 'Module Management')
@section('page_title', 'Curriculum Modules')

@section('content')
<style>
    .mod-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .mod-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.6rem;
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

    .module-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .module-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s var(--ease);
    }
    .module-box:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
        border-color: var(--navy-200);
    }
    .mod-course-badge {
        font-size: 0.75rem;
        font-weight: 800;
        background: var(--navy-50);
        color: var(--accent);
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-sm);
        display: inline-block;
        margin-bottom: 0.75rem;
    }
    .mod-title {
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--navy-950);
        margin-bottom: 0.4rem;
    }
    .mod-desc {
        font-size: 0.88rem;
        color: var(--muted);
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }
    .mod-stats-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.82rem;
        color: var(--text-2);
        border-top: 1px solid var(--border-soft);
        padding-top: 0.85rem;
        margin-bottom: 1.25rem;
    }
    .mod-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .action-btn {
        flex: 1;
        padding: 0.55rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.82rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.2s var(--ease);
    }
    .btn-edit {
        background: var(--navy-50);
        color: var(--navy-800);
        border: 1px solid var(--navy-100);
    }
    .btn-edit:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }
    .btn-upload {
        background: var(--navy-950);
        color: #fff;
    }
    .btn-upload:hover {
        background: var(--navy-700);
    }
    .empty-card {
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: var(--radius-xl);
        padding: 4rem 2rem;
        text-align: center;
        grid-column: 1 / -1;
    }
</style>

<div class="mod-header">
    <div>
        <h1>📂 Curriculum Modules</h1>
        <p style="color:var(--muted); font-size:0.92rem; margin-top:0.25rem;">Organize course content, upload media resources, and structure lessons for learners.</p>
    </div>
    <div style="display:flex; gap:0.75rem;">
        <a href="{{ route('teacher.modules.upload-resource') }}" class="btn-create" style="background:var(--navy-950); box-shadow:none;">
            📤 Upload Resource
        </a>
        <a href="{{ route('teacher.modules.create') }}" class="btn-create">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Module
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #15803d; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div class="module-grid">
    @forelse($modules ?? [] as $module)
        <div class="module-box">
            <div>
                <span class="mod-course-badge">Course: {{ $module->course?->title ?? 'General' }}</span>
                <h3 class="mod-title">{{ $module->title }}</h3>
                <p class="mod-desc">{{ Str::limit($module->description ?: 'No detailed description provided for this module.', 100) }}</p>

                <div class="mod-stats-row">
                    <div>📖 {{ $module->lessons()->count() }} Lessons</div>
                    <div>❓ {{ $module->quizzes()->count() }} Quizzes</div>
                </div>
            </div>

            <div class="mod-actions">
                <a href="{{ route('teacher.modules.edit', $module->id) }}" class="action-btn btn-edit">
                    ✏️ Edit Module
                </a>
                <a href="{{ route('teacher.modules.upload-resource') }}?module_id={{ $module->id }}" class="action-btn btn-upload">
                    📤 Attach Material
                </a>
            </div>
        </div>
    @empty
        <div class="empty-card">
            <div style="font-size:3rem; margin-bottom:1rem;">📂</div>
            <h3 style="font-size:1.3rem; font-weight:700; color:var(--navy-950); margin-bottom:0.5rem;">No Modules Created Yet</h3>
            <p style="color:var(--muted); max-width:460px; margin:0 auto 1.5rem;">Create curriculum modules to group your lessons and upload documents, videos, and slides.</p>
            <a href="{{ route('teacher.modules.create') }}" class="btn-create">
                + Create Your First Module
            </a>
        </div>
    @endforelse
</div>
@endsection
