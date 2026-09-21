<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sectionMeta['title'] ?? 'Student Report' }} - {{ $user->name }}</title>
    <style>
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body { margin:0; background:#fff; color:#111827; font-family:Arial, Helvetica, sans-serif; }
        .print-shell { max-width:1100px; margin:0 auto; padding:2rem; }
        .print-toolbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; }
        .print-toolbar-actions { display:flex; align-items:center; gap:.6rem; }
        .print-toolbar h1 { margin:0; font-size:1.35rem; }
        .print-button, .back-button { display:inline-flex; align-items:center; gap:.4rem; border:0; border-radius:6px; padding:.65rem 1rem; cursor:pointer; font:inherit; text-decoration:none; }
        .print-button { background:#111827; color:#fff; }
        .back-button { background:#e5e7eb; color:#111827; }
        .print-button:hover, .back-button:hover { filter:brightness(.96); }
        .school-heading { display:flex; justify-content:space-between; gap:1rem; align-items:flex-start; padding-bottom:1rem; border-bottom:2px solid #111827; }
        .school-brand { display:flex; align-items:center; gap:.8rem; }
        .school-logo { width:52px; height:52px; object-fit:contain; border-radius:8px; }
        .school-heading h2 { margin:0; font-size:1.1rem; text-transform:uppercase; letter-spacing:.08em; }
        .school-heading p { margin:.35rem 0 0; color:#4b5563; font-size:.85rem; }
        .report-meta { display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin:1rem 0 1.5rem; padding:1rem 0; border-bottom:1px solid #d1d5db; }
        .report-meta span { display:block; color:#6b7280; font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; }
        .report-meta strong { display:block; margin-top:.25rem; font-size:.9rem; }
        .rs { --ink:#111827; --sub:#374151; --muted:#6b7280; --line:#d1d5db; --bg:#f3f4f6; --accent:#1d4ed8; --success:#15803d; --danger:#b91c1c; }
        .rs-inner-header { padding:0 0 1rem; border-bottom:1px solid var(--line); }
        .rs-inner-header h2 { margin:0 0 .25rem; font-size:1.2rem; }
        .rs-inner-header p { margin:0; color:var(--sub); font-size:.88rem; }
        .rs-badge { display:inline-block; margin-top:.5rem; padding:.2rem .55rem; border:1px solid #9ca3af; border-radius:999px; font-size:.7rem; font-weight:700; }
        .rs-meta-row { display:flex; flex-wrap:wrap; gap:2rem; padding:1rem 0; border-bottom:1px solid var(--line); }
        .rs-meta-item .label { color:var(--muted); font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; }
        .rs-meta-item .val { margin-top:.25rem; font-size:.9rem; font-weight:700; }
        .rs-table-wrap { overflow:visible; }
        .rs-table { width:100%; border-collapse:collapse; font-size:.85rem; text-align:left; }
        .rs-table th { padding:.7rem .6rem; background:#f3f4f6; border-bottom:1px solid #9ca3af; font-size:.7rem; text-transform:uppercase; letter-spacing:.06em; }
        .rs-table td { padding:.7rem .6rem; border-bottom:1px solid #d1d5db; }
        .rs-table .bold { font-weight:700; }
        .rs-empty { padding:2rem 0; color:#6b7280; text-align:center; }
        .rs-empty svg { display:none; }
        @media print {
            @page { size:A4; margin:14mm; }
               /* The print shell already provides the report heading and student metadata. */
               .print-shell .rs-inner-header,
               .print-shell .rs-meta-row { display:none; }
            .print-toolbar { display:none; }
            .print-shell { max-width:none; padding:0; }
            .rs-anim { opacity:1 !important; animation:none !important; }
            .rs-table tr { break-inside:avoid; }
        }
        @media (max-width:700px) {
            .print-shell { padding:1rem; }
            .report-meta { grid-template-columns:1fr; gap:.7rem; }
            .rs-table { font-size:.75rem; }
            .rs-table th, .rs-table td { padding:.5rem .35rem; }
        }
    </style>
</head>
<body>
    <main class="print-shell">
        <div class="print-toolbar">
            <h1>{{ $sectionMeta['title'] ?? 'Student Report' }}</h1>
            <div class="print-toolbar-actions">
                <a class="back-button" href="{{ route('sias.student.reports.' . $currentSection) }}">Back</a>
                <button type="button" class="print-button" onclick="window.print()">Print report</button>
            </div>
        </div>

        <header class="school-heading">
            <div class="school-brand">
                <img class="school-logo" src="{{ asset('image/logo new.jpg') }}" alt="SIAS logo">
                <div>
                <h2>SIAS Student Portal</h2>
                <p>Official student report</p>
                </div>
            </div>
            <div style="text-align:right;color:#4b5563;font-size:.85rem;">{{ now()->format('F j, Y') }}</div>
        </header>

        <div class="report-meta">
            <div><span>Student</span><strong>{{ $user->name }}</strong></div>
            <div><span>Student ID</span><strong>{{ $user->student_id ?? $user->id }}</strong></div>
            <div><span>Period</span><strong>{{ session('current_period') ?? '2025-2' }}</strong></div>
        </div>

        @include($sectionMeta['view'])
    </main>
</body>
</html>
