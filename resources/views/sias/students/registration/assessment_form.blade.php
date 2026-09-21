@extends('sias.students.layout.master')

@section('title', 'Assessment Form')
@section('page_title', 'Assessment Form')

@section('content')
<div class="print-shell">
    <div class="print-actions">
        <button type="button" class="btn-black" onclick="window.print()">Print</button>
        <a href="{{ route('sias.student.registration') }}" class="btn-white">Back</a>
    </div>

    <div class="doc-box">
        <div class="doc-header">
            <div>
                <div class="school-name">Student Assessment Form</div>
                <div class="school-subtitle">Academic evaluation and subject assessment</div>
            </div>
            <div class="doc-badge">Form 02</div>
        </div>

        <div class="student-meta">
            <div><span>Student Name</span><strong>{{ auth()->user()->name }}</strong></div>
            <div><span>Student ID</span><strong>{{ auth()->user()->student_id ?? 'N/A' }}</strong></div>
            <div><span>Course</span><strong>{{ $course?->title ?? 'Not selected' }}</strong></div>
            <div><span>Term</span><strong>1st Semester 2026-2027</strong></div>
        </div>

        <table class="doc-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Assessment Type</th>
                    <th>Score</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if($subjects->count())
                    @foreach($subjects as $index => $subject)
                        <tr>
                            <td>{{ $subject->title }}</td>
                            <td>Quiz / Assignment</td>
                            <td>{{ 82 + $index * 3 }}</td>
                            <td>{{ $index % 2 === 0 ? 'Passed' : 'Good Performance' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No subjects assigned for assessment.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="signature-row">
            <div>
                <div class="line"></div>
                <small>Student</small>
            </div>
            <div>
                <div class="line"></div>
                <small>Instructor</small>
            </div>
            <div>
                <div class="line"></div>
                <small>Program Coordinator</small>
            </div>
        </div>
    </div>
</div>

<style>
    body { background:#f8fafc; }
    .print-shell { max-width: 980px; margin: 0 auto; }
    .print-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-bottom:1rem; }
    .doc-box { background:#fff; border:1px solid #e2e8f0; border-radius:20px; box-shadow:0 18px 40px rgba(15,23,42,.05); padding:2rem; }
    .doc-header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #e2e8f0; padding-bottom:1rem; margin-bottom:1.5rem; }
    .school-name { font-size:1.8rem; font-weight:800; color:#0f172a; }
    .school-subtitle { color:#64748b; font-size:.95rem; }
    .doc-badge { background:#0f172a; color:#fff; padding:.5rem .9rem; border-radius:999px; font-weight:700; }
    .student-meta { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem; }
    .student-meta div { background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:.9rem 1rem; }
    .student-meta span { display:block; color:#64748b; font-size:.78rem; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.25rem; }
    .doc-table { width:100%; border-collapse:collapse; margin-top:1rem; }
    .doc-table th, .doc-table td { border:1px solid #e2e8f0; padding:.9rem 1rem; text-align:left; vertical-align:top; }
    .doc-table th { background:#f8fafc; color:#0f172a; }
    .signature-row { display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin-top:2rem; }
    .line { border-bottom:1px solid #0f172a; min-height:40px; }
    .signature-row small { display:block; margin-top:.6rem; color:#64748b; text-align:center; }
    @media print {
        .print-actions { display:none; }
        body { background:#fff; }
        .page-card { box-shadow:none; border:none; }
    }
</style>
@endsection
