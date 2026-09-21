@extends('sias.admin.layouts.master')

@section('title', 'Course Reports')
@section('page_title', 'Department & Course Reports')

@section('content')
<div class="page-card" style="padding:1.5rem; display:grid; gap:1.5rem;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap;">
        <div>
            <h2 style="margin:0; font-size:2rem; letter-spacing:-.02em;">Department Report</h2>
            <p style="margin:.5rem 0 0; color:var(--text-muted); max-width:42rem;">
                Review each department, its active courses, and the related subject list in one place.
            </p>
        </div>
        <a href="{{ route('sias.admin.course') }}" class="btn" style="display:inline-flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-arrow-left"></i>
            Back to courses
        </a>
    </div>

    <div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px,1fr));">
        <div class="admin-panel" style="--i:0;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Departments</p>
            <h3 style="margin:0; font-size:2rem;">{{ $departments->count() }}</h3>
        </div>
        <div class="admin-panel" style="--i:1;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Courses</p>
            <h3 style="margin:0; font-size:2rem;">{{ $courses->count() }}</h3>
        </div>
        <div class="admin-panel" style="--i:2;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Subjects</p>
            <h3 style="margin:0; font-size:2rem;">{{ $subjects->count() }}</h3>
        </div>
    </div>

    <div style="display:grid; gap:1.25rem; grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);">
        <aside class="admin-card" style="padding:1.25rem;">
            <h3 style="margin:0 0 1rem; font-size:1.1rem;">Department filters</h3>
            <div style="display:grid; gap:.65rem;">
                <a href="{{ route('sias.admin.reports') }}"
                   style="padding:.8rem .9rem; border-radius:10px; text-decoration:none; font-weight:600; color:{{ $selectedDepartment === '' ? 'var(--accent-strong)' : 'var(--text)' }}; background:{{ $selectedDepartment === '' ? 'rgba(29,78,216,.08)' : 'var(--card-bg)' }}; border:1px solid {{ $selectedDepartment === '' ? 'rgba(29,78,216,.2)' : 'var(--border)' }};">
                    All departments
                </a>

                @foreach($departments as $department)
                    <a href="{{ route('sias.admin.reports', ['department' => $department]) }}"
                       style="padding:.8rem .9rem; border-radius:10px; text-decoration:none; font-weight:600; color:{{ $selectedDepartment === $department ? 'var(--accent-strong)' : 'var(--text)' }}; background:{{ $selectedDepartment === $department ? 'rgba(29,78,216,.08)' : 'var(--card-bg)' }}; border:1px solid {{ $selectedDepartment === $department ? 'rgba(29,78,216,.2)' : 'var(--border)' }};">
                        {{ $department }}
                    </a>
                @endforeach
            </div>
        </aside>

        <section class="admin-card" style="padding:1.25rem;">
            @if($activeCourse)
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                    <div>
                        <p style="margin:0 0 .35rem; font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--text-muted);">Current course</p>
                        <h3 style="margin:0; font-size:1.5rem;">{{ $activeCourse->title }}</h3>
                        <p style="margin:.35rem 0 0; color:var(--text-muted);">
                            {{ $activeCourse->department ?? $activeCourse->category ?? 'General' }} ·
                            {{ $activeCourse->enrollments_count ?? 0 }} enrolled students
                        </p>
                    </div>
                    <a href="{{ route('sias.admin.course.edit', $activeCourse->id) }}" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:.5rem;">
                        <i class="fa-solid fa-pen"></i>
                        Edit course
                    </a>
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; margin-bottom:1.25rem;">
                    @foreach($courses as $course)
                        <a href="{{ route('sias.admin.reports', ['department' => $selectedDepartment ?: ($course->department ?? $course->category ?? 'General'), 'course_id' => $course->id]) }}"
                           style="display:block; text-decoration:none; padding:1rem; border-radius:12px; border:1px solid {{ $activeCourse->id === $course->id ? 'rgba(29,78,216,.3)' : 'var(--border)' }}; background:{{ $activeCourse->id === $course->id ? 'rgba(29,78,216,.08)' : 'var(--card-bg)' }}; color:var(--text); transition:transform .2s ease;">
                            <p style="margin:0 0 .35rem; font-size:.75rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em;">{{ $course->department ?? $course->category ?? 'General' }}</p>
                            <strong style="display:block; margin-bottom:.25rem; font-size:1rem;">{{ $course->title }}</strong>
                            <span style="color:var(--text-muted); font-size:.85rem;">{{ $course->enrollments_count ?? 0 }} students</span>
                        </a>
                    @endforeach
                </div>

                <div style="border-top:1px solid var(--border); padding-top:1rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                        <h3 style="margin:0; font-size:1.1rem;">Subjects for this course</h3>
                        <a href="{{ route('sias.admin.subject.add') }}" class="btn" style="display:inline-flex;align-items:center;gap:.5rem;">
                            <i class="fa-solid fa-plus"></i>
                            Add subject
                        </a>
                    </div>

                    @if($subjects->isEmpty())
                        <div style="padding:2rem 1rem; border:1px dashed var(--border); border-radius:12px; text-align:center; color:var(--text-muted);">
                            <i class="fa-solid fa-inbox" style="font-size:2rem; display:block; margin-bottom:.5rem; opacity:.5;"></i>
                            No subjects are linked to this course yet.
                        </div>
                    @else
                        <div style="display:grid; gap:.75rem;">
                            @foreach($subjects as $subject)
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:.9rem 1rem; border:1px solid var(--border); border-radius:12px; background:rgba(148,163,184,.03);">
                                    <div>
                                        <div style="font-weight:700;">{{ $subject->title }}</div>
                                        <div style="font-size:.85rem; color:var(--text-muted); margin-top:.2rem;">
                                            @if(!empty($subject->code))
                                                {{ $subject->code }} ·
                                            @endif
                                            {{ $subject->teacher?->name ?? 'No assigned teacher' }}
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:.5rem;">
                                        <a href="{{ route('sias.admin.subject.edit', $subject->id) }}" class="btn btn-secondary" style="padding:.6rem .9rem; font-size:.85rem;">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('sias.admin.subject.delete', $subject->id) }}" onsubmit="return confirm('Delete this subject?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary" style="padding:.6rem .9rem; font-size:.85rem; border-color:rgba(239,68,68,.25); color:#dc2626;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div style="padding:3rem 1rem; border:1px dashed var(--border); border-radius:12px; text-align:center; color:var(--text-muted);">
                    <i class="fa-solid fa-chart-simple" style="font-size:2.5rem; display:block; margin-bottom:.75rem; opacity:.6;"></i>
                    No course is available for this department yet.
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
