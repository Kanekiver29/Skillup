@extends('sias.teacher.layout.layout')

@section('title', 'Teacher Grades')
@section('page_title', 'Gradebook')

@section('content')
<div class="page-card">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="margin:0;">Manage student grades</h2>
            <p style="margin:6px 0 0;">Add or update a final grade for each student enrolled in your course.</p>
        </div>
        <div class="section-block" style="margin:0;"><strong>Courses:</strong> {{ $courses->count() }}</div>
    </div>

    @if(session('success'))
        <div class="section-block" style="margin-top:16px; background:#ecfdf3; border-color:#a7f3d0; color:#065f46;">
            {{ session('success') }}
        </div>
    @endif

    @if($enrollments->isEmpty())
        <div class="section-block" style="margin-top:16px;">No students have been enrolled in your courses yet.</div>
    @else
        <div class="section-block" style="margin-top:16px; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; min-width:720px;">
                <thead>
                    <tr style="background:#f8fafc; text-align:left;">
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Student</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Course</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Status</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Current Grade</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->user->name ?? 'Unnamed student' }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->course->title ?? 'Course' }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->status ?? 'Active' }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">{{ $enrollment->final_grade !== null ? $enrollment->final_grade : 'No grade yet' }}</td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">
                                <form method="POST" action="{{ route('sias.teacher.grades.update', $enrollment) }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="final_grade" min="0" max="100" step="0.1" value="{{ old('final_grade', $enrollment->final_grade) }}" placeholder="Enter grade" style="padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; min-width:120px;" />
                                    <button type="submit" class="btn" style="padding:8px 12px;">Save Grade</button>
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
