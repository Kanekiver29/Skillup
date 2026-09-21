@extends('sias.teacher.layout.layout')

@section('title', 'Teacher Subjects')
@section('page_title', 'My Subjects')

@section('content')
<div class="page-card">
    <h2 data-i18n="teacher_subjects">Teacher Subjects</h2>
    <p data-i18n="manage_subjects_teach">Manage the subjects you are assigned to teach and update student grades directly here.</p>

    @if(session('success'))
        <div class="section-block" style="margin-bottom:16px; background:#ecfdf3; border-color:#a7f3d0; color:#065f46;">
            {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-grid">
        @forelse($courses as $course)
            <div class="section-block">
                <strong>{{ $course->title }}</strong>
                <p style="margin:6px 0 0;" data-i18n="students_enrolled">Students enrolled</p>: {{ $course->enrollments_count }}
            </div>
        @empty
            <div class="section-block" data-i18n="no_subjects_assigned">No subjects are assigned to you yet.</div>
        @endforelse
    </div>

    @if($enrollments->isNotEmpty())
        <div class="section-block" style="margin-top:16px; overflow-x:auto;">
            <h3 style="margin-top:0;" data-i18n="grade_students">Grade students</h3>
            <table style="width:100%; border-collapse:collapse; min-width:720px;">
                <thead>
                    <tr style="background:#f8fafc; text-align:left;">
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="student">Student</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="course_title">Course</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="current_grade">Current Grade</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->user->name ?? __('sias.unnamed_student') }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->course->title ?? __('sias.course_title') }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->final_grade !== null ? $enrollment->final_grade : __('sias.no_grade_yet') }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">
                                <form method="POST" action="{{ route('sias.teacher.grades.update', $enrollment) }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="final_grade" min="0" max="100" step="0.1" value="{{ old('final_grade', $enrollment->final_grade) }}" placeholder="{{ __('sias.enter_grade') }}" style="padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; min-width:120px;" />
                                    <button type="submit" class="btn" data-i18n="save_grade">Save Grade</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
