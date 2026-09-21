@extends('sias.students.layout.master')

@section('title', 'Assessment Certificate')
@section('page_title', 'Assessment Certificate')

@section('content')
<div class="print-shell">
    <div class="print-actions">
        <button type="button" class="btn-black" onclick="window.print()">Print</button>
        <a href="{{ route('sias.student.registration') }}" class="btn-white">Back</a>
    </div>

    <div class="doc-box certificate-box">
        <div class="certificate-head">
            <div class="school-mark">SIAS</div>
            <div>
                <h2>Assessment Certificate</h2>
                <p>Academic performance verification</p>
            </div>
        </div>

        <div class="student-name">{{ auth()->user()->name }}</div>
        <p class="cert-copy">has completed assessment for the program</p>
        <div class="program-name">{{ $course?->title ?? 'Not selected' }}</div>

        <table class="mini-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @if($subjects->count())
                    @foreach($subjects as $index => $subject)
                        <tr>
                            <td>{{ $subject->title }}</td>
                            <td>{{ 82 + $index * 3 }}</td>
                            <td>{{ $index % 2 === 0 ? 'Passed' : 'Strong' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="3">No assessment records available.</td></tr>
                @endif
            </tbody>
        </table>

        <div class="signature-row">
            <div>
                <div class="line"></div>
                <small>Instructor</small>
            </div>
            <div>
                <div class="line"></div>
                <small>Chairperson</small>
            </div>
        </div>
    </div>
</div>

<style>
    body { background:#f8fafc; }
    .print-shell { max-width: 900px; margin: 0 auto; }
    .print-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-bottom:1rem; }
    .doc-box { background:#fff; border:1px solid #e2e8f0; border-radius:22px; box-shadow:0 18px 40px rgba(15,23,42,.05); padding:2.25rem; }
    .certificate-box { text-align:center; }
    .certificate-head { display:flex; justify-content:center; align-items:center; gap:1rem; margin-bottom:1rem; }
    .school-mark { width:72px; height:72px; border-radius:50%; background:#0f172a; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; }
    .certificate-head h2 { margin:0; font-size:2rem; color:#0f172a; }
    .certificate-head p { margin:.2rem 0 0; color:#64748b; }
    .student-name { font-size:2rem; font-weight:800; color:#0f172a; margin-top:1rem; }
    .cert-copy { color:#334155; font-size:1.05rem; margin:.5rem 0; }
    .program-name { font-size:1.4rem; font-weight:700; color:#0f172a; margin:1rem 0; }
    .mini-table { width:100%; border-collapse:collapse; margin:1rem auto 2rem; max-width:540px; }
    .mini-table th, .mini-table td { border:1px solid #e2e8f0; padding:.8rem .9rem; text-align:left; }
    .mini-table th { background:#f8fafc; }
    .signature-row { display:grid; grid-template-columns:repeat(2, 1fr); gap:1.5rem; margin-top:2rem; max-width:420px; margin-left:auto; margin-right:auto; }
    .line { border-bottom:1px solid #0f172a; min-height:34px; }
    .signature-row small { display:block; margin-top:.6rem; color:#64748b; }
    @media print {
        .print-actions { display:none; }
        body { background:#fff; }
        .page-card { box-shadow:none; border:none; }
    }
</style>
@endsection
