@extends('teacher.layouts.master')

@section('title', 'Subject Content & Lessons: ' . $subject->title)
@section('page_title', 'Subject Lessons')

@section('content')
<style>
    .lesson-wrap {
        max-width: 1100px;
        margin: 0 auto;
    }
    .subj-banner {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 100%);
        border: 1px solid var(--navy-700);
        border-radius: var(--radius-xl);
        padding: 2rem 2.25rem;
        color: #fff;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-card);
    }
    .subj-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(56, 217, 217, 0.15), transparent 70%);
        pointer-events: none;
    }
    .subj-banner-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .subj-code-pill {
        background: rgba(255,255,255,0.12);
        color: var(--signature);
        font-weight: 800;
        font-size: 0.8rem;
        padding: 0.3rem 0.75rem;
        border-radius: var(--radius-sm);
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1px solid rgba(56, 217, 217, 0.3);
    }
    .subj-banner h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.5rem;
    }
    .subj-banner p {
        color: var(--navy-200);
        font-size: 0.95rem;
        max-width: 750px;
        line-height: 1.5;
    }
    .banner-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 0.88rem;
        color: var(--navy-100);
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.1);
        flex-wrap: wrap;
    }
    .banner-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Student Sync Alert */
    .sync-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-left: 4px solid var(--accent);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        box-shadow: var(--shadow-xs);
    }
    .sync-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .sync-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--navy-50);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .btn-student-view {
        background: var(--navy-950);
        color: #fff;
        font-weight: 700;
        padding: 0.65rem 1.2rem;
        border-radius: var(--radius-md);
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s var(--ease);
    }
    .btn-student-view:hover {
        background: var(--accent);
        color: #fff;
    }

    /* Modules & Lessons Section */
    .section-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--navy-950);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .quick-resource-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .resource-chip {
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--navy-950);
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.45rem 0.85rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s var(--ease);
    }
    .resource-chip:hover {
        background: var(--navy-50);
        border-color: var(--navy-200);
        color: var(--accent);
    }

    .module-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .module-header {
        background: var(--surface-2);
        border-bottom: 1px solid var(--border);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .module-title-box h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .module-title-box p {
        font-size: 0.84rem;
        color: var(--muted);
        margin-top: 0.2rem;
    }

    .lesson-list {
        padding: 1rem 1.5rem;
    }
    .lesson-item {
        background: var(--surface);
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: all 0.2s var(--ease);
    }
    .lesson-item:last-child {
        margin-bottom: 0;
    }
    .lesson-item:hover {
        border-color: var(--navy-200);
        box-shadow: var(--shadow-xs);
        transform: translateX(4px);
    }
    .lesson-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .lesson-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        background: var(--navy-50);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .lesson-info h4 {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--navy-950);
        margin-bottom: 0.2rem;
    }
    .lesson-info p {
        font-size: 0.82rem;
        color: var(--muted);
    }
    .lesson-meta-badges {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.35rem;
    }
    .badge-tag {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        background: var(--navy-50);
        color: var(--navy-800);
    }
    .badge-tag.has-video {
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
    }
    .badge-tag.has-doc {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
    }
    .lesson-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-edit-sm {
        background: var(--navy-50);
        color: var(--navy-800);
        border: 1px solid var(--navy-100);
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.4rem 0.75rem;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.2s var(--ease);
    }
    .btn-edit-sm:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }

    .empty-modules {
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: var(--radius-xl);
        padding: 3.5rem 2rem;
        text-align: center;
    }
</style>

<div class="lesson-wrap">
    {{-- Subject Header Banner --}}
    <div class="subj-banner">
        <div class="subj-banner-top">
            <span class="subj-code-pill">{{ $subject->subject_code ?: 'SUBJ-'.$subject->id }}</span>
            <a href="{{ route('teacher.subjects.edit', $subject->id) }}" style="color:var(--signature); font-weight:700; font-size:0.88rem; display:inline-flex; align-items:center; gap:0.4rem; background:rgba(255,255,255,0.1); padding:0.4rem 0.85rem; border-radius:var(--radius-sm);">
                ✏️ Edit Subject Details
            </a>
        </div>

        <h1>{{ $subject->title }}</h1>
        @if($subject->subject_type)
            <span class="subj-code-pill" style="display:inline-block; margin-bottom:.65rem;">{{ $subject->subject_type }}</span>
        @endif
        <p>{{ $subject->description ?: 'Manage the curriculum, modules, and lessons for this subject. All lessons automatically display to students on the Userpage course portal.' }}</p>

        <div class="banner-meta">
            <div class="banner-meta-item">
                <span>🎓</span> <strong>{{ $subject->units ?: 3 }} Academic Units</strong>
            </div>
            <div class="banner-meta-item">
                <span>⏱️</span> <strong>{{ $subject->hours ?: 54 }} Hours Duration</strong>
            </div>
            <div class="banner-meta-item">
                <span>👨‍🏫</span> Teacher: <strong>{{ $subject->teacher?->name ?: auth()->user()->name }}</strong>
            </div>
            <div class="banner-meta-item">
                <span>🔗</span> Course: <strong>{{ $subject->course?->title ?? 'Unlinked / Standalone' }}</strong>
            </div>
        </div>
    </div>

    {{-- Sync to Userpage course --}}
    <div class="sync-card">
        <div class="sync-info">
            <div class="sync-icon">⚡</div>
            <div>
                <h4 style="font-size:1rem; font-weight:700; color:var(--navy-950); margin-bottom:0.2rem;">Live Student Connection Enabled</h4>
                <p style="font-size:0.85rem; color:var(--muted); margin:0;">
                    Changes to modules and lessons are instantly available on <strong>Userpage/course/subject</strong> & <strong>Userpage/course/course</strong>.
                </p>
            </div>
        </div>
        <a href="{{ route('subjects') }}" target="_blank" class="btn-student-view">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Preview Student Course Page
        </a>
    </div>

    {{-- Quick Resource Upload Bar --}}
    <div class="quick-resource-bar">
        <span style="font-weight:700; font-size:0.88rem; color:var(--navy-950); margin-right:0.5rem;">Quick Add Resource:</span>
        <span style="color:var(--muted); font-size:0.82rem;">Choose a module below to attach its materials and quizzes.</span>
    </div>

    {{-- Modules & Lessons --}}
    <div class="section-title">
        <span>📚 Curriculum Modules & Lessons</span>
        @if($subject->course)
            <a href="{{ route('teacher.modules.create') }}?course_id={{ $subject->course->id }}" style="font-size:0.88rem; font-weight:700; color:var(--accent); display:inline-flex; align-items:center; gap:0.4rem;">
                + Add Module
            </a>
        @endif
    </div>

    @php
        $course = $subject->course;
        $modules = $course?->modules ?? collect();
        $standaloneLessons = $course?->lessons ?? collect();
    @endphp

    @if($modules->count() > 0)
        @foreach($modules as $index => $module)
            <div class="module-card">
                <div class="module-header">
                    <div class="module-title-box">
                        <h3>
                            <span style="background:var(--navy-50); color:var(--navy-800); font-size:0.75rem; padding:0.2rem 0.5rem; border-radius:4px; font-weight:800;">
                                MODULE {{ $index + 1 }}
                            </span>
                            {{ $module->title }}
                        </h3>
                        <p>{{ $module->description ?: 'No module summary specified.' }}</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <a href="{{ route('teacher.lessons.create', ['module_id' => $module->id]) }}" class="btn-edit-sm">
                            + Add Lesson
                        </a>
                        <a href="{{ route('teacher.quizzes.create', ['module_id' => $module->id]) }}" class="btn-edit-sm">
                            ? Add Quiz
                        </a>
                        <a href="{{ route('teacher.modules.upload-resource', ['type' => 'pdf', 'course_id' => $subject->course->id, 'module_id' => $module->id]) }}" class="btn-edit-sm">
                            📎 Add Material
                        </a>
                        <a href="{{ route('teacher.modules.edit', $module->id) }}" class="btn-edit-sm">
                            ✏️ Edit Module & Lessons
                        </a>
                    </div>
                </div>

                <div class="lesson-list">
                    @if($module->quizzes->isNotEmpty())
                        <div style="border-top:1px solid var(--border-soft); padding:1rem 0 0; margin-top:1rem;">
                            <strong style="font-size:.86rem; color:var(--navy-950);">Quizzes</strong>
                            @foreach($module->quizzes as $quiz)
                                <div style="display:flex; justify-content:space-between; gap:.75rem; margin-top:.6rem; font-size:.84rem;">
                                    <span>❓ {{ $quiz->title }}</span>
                                    <span class="badge-tag">{{ $quiz->is_published ? 'Published' : 'Draft' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @forelse($module->lessons as $lIndex => $lessonItem)
                        <div class="lesson-item">
                            <div class="lesson-left">
                                <div class="lesson-icon">{{ $lIndex + 1 }}</div>
                                <div class="lesson-info">
                                    <h4>{{ $lessonItem->title }}</h4>
                                    <p>{{ Str::limit($lessonItem->description ?: $lessonItem->content, 90) }}</p>
                                    <div class="lesson-meta-badges">
                                        <span class="badge-tag">⏱️ {{ $lessonItem->duration_minutes ?: 30 }} mins</span>
                                        @if($lessonItem->video_url)
                                            <span class="badge-tag has-video">🎥 Video Attached</span>
                                        @endif
                                        @if($lessonItem->material_url)
                                            <span class="badge-tag has-doc">📄 Material Download</span>
                                        @endif
                                        <span class="badge-tag" style="background:{{ $lessonItem->is_published ? 'rgba(34,197,94,0.1)' : 'rgba(234,179,8,0.1)' }}; color:{{ $lessonItem->is_published ? '#16a34a' : '#ca8a04' }};">
                                            {{ $lessonItem->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson-actions">
                                @if($lessonItem->material_url)
                                    <a href="{{ $lessonItem->material_url }}" target="_blank" class="btn-edit-sm" title="View Material">
                                        📥 Download
                                    </a>
                                @endif
                                @if($lessonItem->slug && $course?->slug && $module->slug)
                                    <a href="{{ route('lessons.show', [$course->slug, $module->slug, $lessonItem->slug]) }}" target="_blank" class="btn-edit-sm" title="Preview Lesson in Student View">
                                        👁️ Student View
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:1.5rem; color:var(--muted); font-size:0.9rem;">
                            No lessons added to this module yet. <a href="{{ route('teacher.lessons.create', ['module_id' => $module->id]) }}" style="color:var(--accent); font-weight:700;">Add First Lesson</a>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-modules">
            <div style="font-size:2.5rem; margin-bottom:0.75rem;">📂</div>
            <h3 style="font-size:1.2rem; font-weight:700; color:var(--navy-950); margin-bottom:0.4rem;">No Curriculum Modules Found</h3>
            <p style="color:var(--muted); max-width:480px; margin:0 auto 1.25rem; font-size:0.9rem;">
                @if($subject->course)
                    This subject is connected to course <strong>"{{ $subject->course->title }}"</strong>. Start by creating a module to organize lessons and learning materials.
                @else
                    This subject is currently standalone. Edit this subject to link it to a course, or create modules for your course.
                @endif
            </p>

            @if($subject->course)
                <a href="{{ route('teacher.modules.create') }}?course_id={{ $subject->course->id }}" class="btn-student-view" style="background:var(--accent);">
                    + Create First Module for {{ $subject->course->title }}
                </a>
            @else
                <a href="{{ route('teacher.subjects.edit', $subject->id) }}" class="btn-student-view" style="background:var(--accent);">
                    🔗 Link Subject to a Course
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
