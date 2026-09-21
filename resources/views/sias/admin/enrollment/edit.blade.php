@extends('sias.admin.layouts.master')

@section('title', 'Edit Student Enrollment')
@section('page_title', 'Edit Student Enrollment')
@section('subtitle', 'Update the selected enrollment details.')

@section('content')
<div class="admin-card">
    @if($errors->any())
        <div style="padding:.75rem 1rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#dc2626;border-radius:8px;margin-bottom:1rem;">
            <ul style="margin:0;padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.admin.enrollment.update', $enrollment->id) }}" style="display:grid; gap:1.25rem;">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="field-group">
                <label for="student">Student</label>
                <select id="student" name="student_id" required>
                    <option value="">Select student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id', $enrollment->user_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->lrn ?? $student->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field-group">
                <label for="course">Course</label>
                <select id="course" name="course_id" required>
                    <option value="">Select course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $enrollment->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->code ? $course->code . ' - ' : '' }}{{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field-group">
                <label for="subject">Subject (Optional)</label>
                <select id="subject" name="subject_id">
                    <option value="">Select subject (all / none)</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $enrollment->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->subject_code ?? $subject->code ?? '' }} - {{ $subject->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field-group">
                <label for="year_level">Year Level</label>
                <select id="year_level" name="year_level" required>
                    <option value="1st Year" {{ old('year_level', $enrollment->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                    <option value="2nd Year" {{ old('year_level', $enrollment->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3rd Year" {{ old('year_level', $enrollment->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4th Year" {{ old('year_level', $enrollment->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                </select>
            </div>

            <div class="field-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    <option value="1st Semester" {{ old('semester', $enrollment->semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd Semester" {{ old('semester', $enrollment->semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="Summer" {{ old('semester', $enrollment->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                </select>
            </div>

            <div class="field-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="pending" {{ old('status', $enrollment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $enrollment->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="dropped" {{ old('status', $enrollment->status) == 'dropped' ? 'selected' : '' }}>Dropped</option>
                </select>
            </div>
        </div>

        <div class="admin-actions" style="margin-top:0;">
            <button type="submit" class="btn-black">Update Enrollment</button>
            <a href="{{ route('sias.admin.enrollments') }}" class="btn-white">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-grid {
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
        gap:1rem;
    }
    .field-group {
        display:grid;
        gap:.5rem;
    }
    .field-group label {
        font-weight:700;
        color:var(--text);
    }
    .field-group select,
    .field-group input {
        width:100%;
        padding:.8rem .9rem;
        border-radius:12px;
        border:1px solid var(--card-border);
        background:var(--card-bg);
        color:var(--text);
        font:inherit;
    }
</style>
@endsection
