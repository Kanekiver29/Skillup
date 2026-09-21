@extends('sias.students.layout.master')

@section('title', 'Course and Subject Registration')
@section('page_title', 'Course & Subject Registration')

@section('content')
<div class="page-card" style="max-width:1200px; margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h3 style="margin:0; font-size:1.6rem;">Student course and subject registration</h3>
            <p style="margin:.4rem 0 0; color:#64748b;">Select your program and add subjects for enrollment, assessment, and certification.</p>
        </div>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('sias.student.registration.enrollment_form') }}" class="btn-black">Print Enrollment Form</a>
            <a href="{{ route('sias.student.registration.assessment_form') }}" class="btn-white">Print Assessment Form</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-box success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-box error">{{ session('error') }}</div>
    @endif

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px,1fr)); gap:1.25rem; margin-top:1rem;">
        <div class="info-panel">
            <h4>Register Course</h4>
            <form method="POST" action="{{ route('sias.student.registration.course') }}">
                @csrf
                <label style="display:block; margin-bottom:.75rem; font-weight:600; color:#0f172a;">Course</label>
                <select name="course_id" required style="width:100%; padding:.85rem 1rem; border-radius:12px; border:1px solid #cbd5e1; background:#fff; margin-bottom:1rem;">
                    <option value="">Select a course</option>
                    @foreach($allCourses as $courseItem)
                        <option value="{{ $courseItem->id }}" {{ ($course ?? null)?->id == $courseItem->id ? 'selected' : '' }}>
                            {{ $courseItem->title }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-black">Add Course</button>
            </form>
        </div>

        <div class="info-panel">
            <h4>Register Subjects</h4>
            <form method="POST" action="{{ route('sias.student.registration.subjects') }}">
                @csrf
                <div style="display:grid; gap:.75rem; max-height:280px; overflow:auto; border:1px solid #e2e8f0; border-radius:12px; padding:1rem; background:#f8fafc;">
                    @forelse($allSubjects as $subjectItem)
                        <label style="display:flex; align-items:center; gap:.75rem; color:#0f172a;">
                            <input type="checkbox" name="subject_ids[]" value="{{ $subjectItem->id }}" {{ collect($subjects)->contains('id', $subjectItem->id) ? 'checked' : '' }}>
                            <span>{{ $subjectItem->title }} @if($subjectItem->teacher) <small style="color:#64748b;">— {{ $subjectItem->teacher->name }}</small> @endif</span>
                        </label>
                    @empty
                        <p style="margin:0; color:#64748b;">No subjects available yet.</p>
                    @endforelse
                </div>
                <div style="margin-top:1rem;">
                    <button type="submit" class="btn-black">Add Subjects</button>
                </div>
            </form>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:1.25rem; margin-top:1.75rem;">
        <div class="info-panel">
            <h4>Selected Course</h4>
            @if($course)
                <div class="summary-box">
                    <strong>{{ $course->title }}</strong>
                    <p>{{ $course->category ?? 'Course category' }}</p>
                    <small>Teacher: {{ $course->instructor?->name ?? $course->instructor_name ?? 'Assigned course teacher' }}</small>
                    <small>{{ $course->description ?? 'No description available.' }}</small>
                </div>
            @else
                <p class="muted-text">No course selected yet.</p>
            @endif
        </div>

        <div class="info-panel">
            <h4>Selected Subjects</h4>
            @if($subjects->count())
                <ul style="margin:0; padding-left:1.25rem; display:grid; gap:.5rem; color:#0f172a;">
                    @foreach($subjects as $subject)
                        <li>{{ $subject->title }}</li>
                    @endforeach
                </ul>
            @else
                <p class="muted-text">No subjects selected yet.</p>
            @endif
        </div>
    </div>

    <div style="display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.75rem;">
        <a href="{{ route('sias.student.registration.enrollment_certificate') }}" class="btn-black">Certificate of Enrollment</a>
        <a href="{{ route('sias.student.registration.assessment_certificate') }}" class="btn-white">Assessment Certificate</a>
        <a href="{{ route('sias.student.registration.grade_certificate') }}" class="btn-white">Grade Certificate</a>
        <form method="POST" action="{{ route('sias.student.registration.reset') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-white">Reset</button>
        </form>
    </div>
</div>

<style>
    .alert-box {
        border-radius: 14px;
        padding: 0.9rem 1rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .alert-box.success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
    }
    .alert-box.error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .info-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 1.2rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
    }
    .info-panel h4 {
        margin: 0 0 1rem;
        font-size: 1.1rem;
        color: #0f172a;
    }
    .summary-box {
        display: grid;
        gap: .35rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
    }
    .summary-box strong {
        font-size: 1.08rem;
    }
    .summary-box p,
    .summary-box small,
    .muted-text {
        margin: 0;
        color: #64748b;
    }
</style>
@endsection
