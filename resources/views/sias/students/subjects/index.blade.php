@extends('sias.students.layout.master')

@section('title', 'My Subjects')
@section('page_title', 'My Subjects')

@section('content')
<div class="page-card subjects-page">
    @php
        $enrollments = auth()->user()->enrollments()
            ->with(['course', 'subject.teacher'])
            ->where(function($q) {
                $q->whereIn('status', ['active', 'approved'])->orWhereNull('status');
            })
            ->get();
        $semesterLabel = 'First Semester SY 2026-2027';
        $totalSubjects = $enrollments->count();
        $totalUnits = $enrollments->sum(function ($enrollment) {
            $units = $enrollment->subject?->units ?? $enrollment->course?->duration ?? 3;
            return is_numeric($units) ? (float) $units : 3;
        });
        $toText = static function ($value, string $fallback = 'TBA'): string {
            return is_scalar($value) && trim((string) $value) !== '' ? (string) $value : $fallback;
        };
    @endphp

    <style>
        @keyframes subjFadeUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes subjPop {
            0%   { opacity:0; transform:scale(.9); }
            100% { opacity:1; transform:scale(1); }
        }
        @keyframes subjPulse {
            0%, 100% { box-shadow:0 0 0 0 rgba(37,99,235,.28); }
            50%      { box-shadow:0 0 0 5px rgba(37,99,235,0); }
        }
        @keyframes subjShake {
            0%, 100% { transform:translateX(0); }
            25%      { transform:translateX(-4px); }
            75%      { transform:translateX(4px); }
        }

        .subjects-page .anim-in { opacity:0; animation:subjFadeUp .55s cubic-bezier(.22,1,.36,1) forwards; }

        .subjects-page .subj-header {
            display:flex; justify-content:space-between; align-items:flex-start;
            gap:1rem; flex-wrap:wrap; margin-bottom:1.25rem;
        }
        .subjects-page .subj-header h2 { margin:0; font-size:2rem; letter-spacing:-.02em; color:#0f172a; }
        .subjects-page .subj-header p { margin:.5rem 0 0; color:#64748b; max-width:42rem; line-height:1.55; }

        .subjects-page .subj-toolbar-actions { display:flex; gap:.6rem; flex-wrap:wrap; }
        .subjects-page .btn-black, .subjects-page .btn-white {
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }
        .subjects-page .btn-black:hover { transform:translateY(-2px); filter:brightness(1.08); box-shadow:0 10px 22px -10px rgba(15,23,42,.55); }
        .subjects-page .btn-white:hover { transform:translateY(-2px); box-shadow:0 8px 18px -10px rgba(15,23,42,.25); }
        .subjects-page .btn-black:active, .subjects-page .btn-white:active { transform:translateY(0); }

        /* stat cards */
        .subj-stats {
            display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:1rem;
            margin-bottom:1.25rem;
        }
        .subj-stat {
            background:#fff; border:1px solid #e2e8f0; border-radius:18px; padding:1.1rem 1.25rem;
            display:flex; align-items:center; gap:.9rem;
            transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
        }
        .subj-stat:hover { transform:translateY(-3px); box-shadow:0 14px 30px -18px rgba(15,23,42,.25); border-color:#cbd5e1; }
        .subj-stat .icon {
            width:44px; height:44px; border-radius:14px; display:flex; align-items:center; justify-content:center;
            font-size:1.1rem; flex-shrink:0;
        }
        .subj-stat .icon.blue  { background:rgba(37,99,235,.12); color:#2563eb; }
        .subj-stat .icon.amber { background:rgba(217,119,6,.12); color:#b45309; }
        .subj-stat .icon.green { background:rgba(22,163,74,.12); color:#15803d; }
        .subj-stat .label { display:block; font-size:.78rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#94a3b8; }
        .subj-stat .value { display:block; font-size:1.35rem; font-weight:700; color:#0f172a; line-height:1.2; }

        /* toolbar: search + sort + view toggle */
        .subj-toolbar {
            display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;
            background:#fff; border:1px solid #e2e8f0; border-radius:18px;
            padding:.85rem 1rem; margin-bottom:1.25rem;
        }
        .subj-search { position:relative; flex:1; min-width:220px; }
        .subj-search input {
            width:100%; padding:.75rem 1rem .75rem 2.4rem; border:1px solid #cbd5e1; border-radius:12px;
            background:#f8fafc; font-size:.95rem; color:#0f172a;
            transition:border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .subj-search input:focus { outline:none; border-color:#0f172a; box-shadow:0 0 0 4px rgba(15,23,42,.06); background:#fff; }
        .subj-search i {
            position:absolute; left:.85rem; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:.9rem;
        }
        .subj-sort select {
            padding:.72rem 1rem; border-radius:12px; border:1px solid #d1d5db;
            background:#fff; color:#0f172a; cursor:pointer; font-size:.92rem;
            transition:border-color .2s ease, transform .2s ease;
        }
        .subj-sort select:hover { border-color:#9ca3af; }
        .subj-sort select:focus { outline:none; border-color:#0f172a; box-shadow:0 0 0 4px rgba(15,23,42,.06); }

        .subj-view-toggle { display:flex; gap:.25rem; background:#f1f5f9; border-radius:12px; padding:.25rem; }
        .subj-view-toggle button {
            border:none; background:transparent; padding:.55rem .8rem; border-radius:9px; cursor:pointer;
            color:#64748b; font-size:.9rem; transition:background .2s ease, color .2s ease, box-shadow .2s ease;
        }
        .subj-view-toggle button.active { background:#fff; color:#0f172a; box-shadow:0 2px 6px rgba(15,23,42,.12); }
        .subj-view-toggle button:hover:not(.active) { color:#0f172a; }

        /* subject grid / list */
        .subj-grid {
            display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1.5rem;
            transition: opacity .2s ease;
            align-items:stretch;
        }
        .subj-grid.list-view { grid-template-columns:1fr; }

        .subject-card {
            background:#fff; border:1px solid #e2e8f0; border-radius:24px; padding:2rem;
            display:grid; grid-template-rows:auto minmax(2.8rem, auto) minmax(3rem, auto) auto; gap:.85rem;
            min-width:0; min-height:346px; height:100%;
            opacity:0; animation:subjFadeUp .5s cubic-bezier(.22,1,.36,1) forwards;
            transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease, opacity .2s ease, max-height .3s ease;
        }
        .subject-card:hover { transform:translateY(-3px); box-shadow:0 16px 34px -18px rgba(15,23,42,.22); border-color:#cbd5e1; }
        .subject-card.is-hidden { display:none; }

        .subject-card .card-top { display:flex; justify-content:space-between; align-items:flex-start; gap:.75rem; }
        .subject-card .code-badge {
            display:inline-block; font-size:.72rem; font-weight:800; letter-spacing:.06em;
            color:#2563eb; background:rgba(37,99,235,.1); border-radius:999px; padding:.3rem .65rem;
        }
        .subject-card .status-pill {
            display:inline-flex; align-items:center; gap:.35rem;
            font-size:.72rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase;
            color:#15803d; background:rgba(22,163,74,.12); border-radius:999px; padding:.3rem .65rem;
            animation: subjPulse 2.6s ease-in-out infinite;
        }
        .subject-card .status-pill::before {
            content:''; width:6px; height:6px; border-radius:999px; background:#15803d;
        }

        .subject-card h3.subject-title { margin:0; min-height:3.2rem; font-size:1.35rem; color:#0f172a; line-height:1.3; display:flex; align-items:center; }

        .subject-card .teacher-row { display:flex; align-items:center; gap:.85rem; min-height:3.5rem; }
        .subject-card .avatar {
            width:64px; height:64px; border-radius:999px; flex-shrink:0;
            background:linear-gradient(135deg, #2563eb, #7c3aed);
            color:#fff; font-weight:700; font-size:1rem;
            display:flex; align-items:center; justify-content:center;
            animation: subjPop .4s cubic-bezier(.34,1.56,.64,1) forwards;
        }
        .subject-card .teacher-meta { display:grid; line-height:1.25; }
        .subject-card .teacher-meta .name { font-weight:700; color:#0f172a; font-size:1.15rem; }
        .subject-card .teacher-meta .role { font-size:1rem; color:#94a3b8; }

        .subject-card .meta-grid {
            display:grid; grid-template-columns:repeat(3, 1fr); gap:.6rem;
            border-top:1px dashed #e2e8f0; padding-top:1.2rem;
            align-self:end;
        }
        .subject-card .meta-grid .meta-item span { display:block; }
        .subject-card .meta-grid .meta-item .meta-label {
            font-size:.78rem; font-weight:700; letter-spacing:.05em; text-transform:uppercase; color:#94a3b8;
        }
        .subject-card .meta-grid .meta-item .meta-value { font-size:1.05rem; color:#0f172a; font-weight:600; margin-top:.15rem; }

        .subj-grid.list-view .subject-card { grid-template-columns:1fr auto; align-items:center; }
        .subj-grid.list-view .subject-card .meta-grid { border-top:none; padding-top:0; grid-column:1/-1; }

        /* empty state */
        .subj-empty {
            display:none; flex-direction:column; align-items:center; justify-content:center;
            text-align:center; gap:.6rem; padding:3rem 1.5rem; color:#64748b;
            border:1px dashed #cbd5e1; border-radius:20px; background:#f8fafc;
        }
        .subj-empty.show { display:flex; animation: subjFadeUp .4s ease forwards; }
        .subj-empty i { font-size:1.8rem; color:#cbd5e1; }
        .subj-empty.shake { animation: subjShake .35s ease; }

        @media (max-width: 720px) {
            .subj-stats { grid-template-columns:1fr; }
            .subj-grid { grid-template-columns:1fr; }
            .subject-card { padding:1.25rem; min-height:0; }
            .subject-card .meta-grid { grid-template-columns:1fr 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            .subjects-page * { animation:none !important; transition:none !important; }
        }
    </style>

    <div class="subj-header anim-in" style="animation-delay:.02s;">
        <div>
            <h2>My Subjects</h2>
            <p>View your enrolled subjects, schedules, and assigned teachers for {{ $semesterLabel }}.</p>
        </div>
        <div class="subj-toolbar-actions">
            <button class="btn-white" type="button" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
            <button class="btn-black" type="button">Enrollment Data</button>
        </div>
    </div>

    <div class="subj-stats anim-in" style="animation-delay:.08s;">
        <div class="subj-stat">
            <div class="icon blue"><i class="fa-solid fa-book"></i></div>
            <div>
                <span class="label">Total Subjects</span>
                <span class="value">{{ $totalSubjects }}</span>
            </div>
        </div>
        <div class="subj-stat">
            <div class="icon amber"><i class="fa-solid fa-layer-group"></i></div>
            <div>
                <span class="label">Total Units</span>
                <span class="value">{{ number_format($totalUnits, 1) }}</span>
            </div>
        </div>
        <div class="subj-stat">
            <div class="icon green"><i class="fa-solid fa-calendar-check"></i></div>
            <div>
                <span class="label">Semester</span>
                <span class="value" style="font-size:.98rem;">{{ $semesterLabel }}</span>
            </div>
        </div>
    </div>

    <div class="subj-toolbar anim-in" style="animation-delay:.14s;">
        <div class="subj-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="subjSearchInput" placeholder="Search by subject or teacher name..." autocomplete="off">
        </div>
        <div class="subj-sort">
            <select id="subjSortSelect">
                <option value="default">Sort: Default</option>
                <option value="name-asc">Subject A–Z</option>
                <option value="name-desc">Subject Z–A</option>
                <option value="units-desc">Units: High–Low</option>
                <option value="units-asc">Units: Low–High</option>
            </select>
        </div>
        <div class="subj-view-toggle" role="group" aria-label="Toggle view">
            <button type="button" id="subjGridBtn" class="active"><i class="fa-solid fa-table-cells-large"></i> Grid</button>
            <button type="button" id="subjListBtn"><i class="fa-solid fa-list"></i> List</button>
        </div>
    </div>

    <div class="subj-grid anim-in" id="subjGrid" style="animation-delay:.2s;">
        @forelse($enrollments as $index => $enrollment)
            @php
                $course = $enrollment->course;
                $subjectModel = $enrollment->subject;
                $instructor = $subjectModel?->teacher ?? $course?->instructor;
                $subjectTitle = $toText($subjectModel?->title ?? $course?->title, 'Subject ' . ($index + 1));
                $subjectCode = $toText($subjectModel?->subject_code ?? $subjectModel?->code ?? $course?->code ?? $course?->slug, 'SUBJ-' . ($index + 1));
                $teacherName = $toText($instructor?->name, 'Teacher not assigned');
                $teacherRole = $toText($instructor?->staff_type, 'Faculty');
                $units = is_numeric($subjectModel?->units) ? (float) $subjectModel->units : (is_numeric($course?->duration) ? (float) $course->duration : 3);
                $schedule = $toText($enrollment->schedule);
                $room = $toText($enrollment->room);
                $status = ucfirst($toText($enrollment->status, 'active'));
                $initials = collect(explode(' ', trim($teacherName)))
                    ->filter()
                    ->map(fn ($w) => strtoupper(substr($w, 0, 1)))
                    ->take(2)
                    ->implode('');
            @endphp
            <div class="subject-card"
                 style="animation-delay:{{ .04 * $index }}s;"
                 data-title="{{ strtolower($subjectTitle) }}"
                 data-teacher="{{ strtolower($teacherName) }}"
                 data-units="{{ $units }}">
                <div class="card-top">
                    <span class="code-badge">{{ $subjectCode }}</span>
                    <span class="status-pill">{{ $status }}</span>
                </div>

                <h3 class="subject-title">{{ $subjectTitle }}</h3>

                <div class="teacher-row">
                    <div class="avatar">{{ $initials ?: 'T' }}</div>
                    <div class="teacher-meta">
                        <span class="name">{{ $teacherName }}</span>
                        <span class="role">{{ $teacherRole }}</span>
                    </div>
                </div>

                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Units</span>
                        <span class="meta-value">{{ number_format($units, 1) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Schedule</span>
                        <span class="meta-value">{{ $schedule }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Room</span>
                        <span class="meta-value">{{ $room }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="subject-card" data-title="automotive systems" data-teacher="teacher name" data-units="3">
                <div class="card-top">
                    <span class="code-badge">AUTO-101</span>
                    <span class="status-pill">Enrolled</span>
                </div>
                <h3 class="subject-title">Automotive Systems</h3>
                <div class="teacher-row">
                    <div class="avatar">TN</div>
                    <div class="teacher-meta">
                        <span class="name">Teacher Name</span>
                        <span class="role">Faculty</span>
                    </div>
                </div>
                <div class="meta-grid">
                    <div class="meta-item"><span class="meta-label">Units</span><span class="meta-value">3.0</span></div>
                    <div class="meta-item"><span class="meta-label">Schedule</span><span class="meta-value">TBA</span></div>
                    <div class="meta-item"><span class="meta-label">Room</span><span class="meta-value">TBA</span></div>
                </div>
            </div>
            <div class="subject-card" data-title="electrical installation" data-teacher="teacher name" data-units="3">
                <div class="card-top">
                    <span class="code-badge">ELEC-101</span>
                    <span class="status-pill">Enrolled</span>
                </div>
                <h3 class="subject-title">Electrical Installation</h3>
                <div class="teacher-row">
                    <div class="avatar">TN</div>
                    <div class="teacher-meta">
                        <span class="name">Teacher Name</span>
                        <span class="role">Faculty</span>
                    </div>
                </div>
                <div class="meta-grid">
                    <div class="meta-item"><span class="meta-label">Units</span><span class="meta-value">3.0</span></div>
                    <div class="meta-item"><span class="meta-label">Schedule</span><span class="meta-value">TBA</span></div>
                    <div class="meta-item"><span class="meta-label">Room</span><span class="meta-value">TBA</span></div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="subj-empty" id="subjEmptyState">
        <i class="fa-solid fa-magnifying-glass"></i>
        <strong style="color:#0f172a;">No subjects match your search</strong>
        <span>Try a different subject or teacher name.</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var grid = document.getElementById('subjGrid');
        var cards = Array.prototype.slice.call(grid.querySelectorAll('.subject-card'));
        var searchInput = document.getElementById('subjSearchInput');
        var sortSelect = document.getElementById('subjSortSelect');
        var gridBtn = document.getElementById('subjGridBtn');
        var listBtn = document.getElementById('subjListBtn');
        var emptyState = document.getElementById('subjEmptyState');

        function applyFilter() {
            var query = searchInput.value.trim().toLowerCase();
            var visibleCount = 0;
            cards.forEach(function (card) {
                var matches = !query
                    || card.dataset.title.indexOf(query) !== -1
                    || card.dataset.teacher.indexOf(query) !== -1;
                card.classList.toggle('is-hidden', !matches);
                if (matches) visibleCount++;
            });
            emptyState.classList.toggle('show', visibleCount === 0);
        }

        function applySort() {
            var value = sortSelect.value;
            var sorted = cards.slice();
            if (value === 'name-asc') {
                sorted.sort(function (a, b) { return a.dataset.title.localeCompare(b.dataset.title); });
            } else if (value === 'name-desc') {
                sorted.sort(function (a, b) { return b.dataset.title.localeCompare(a.dataset.title); });
            } else if (value === 'units-desc') {
                sorted.sort(function (a, b) { return parseFloat(b.dataset.units) - parseFloat(a.dataset.units); });
            } else if (value === 'units-asc') {
                sorted.sort(function (a, b) { return parseFloat(a.dataset.units) - parseFloat(b.dataset.units); });
            } else {
                sorted = cards;
            }
            sorted.forEach(function (card, i) {
                card.style.animation = 'none';
                void card.offsetWidth;
                card.style.animation = '';
                card.style.animationDelay = (i * 0.04) + 's';
                grid.appendChild(card);
            });
        }

        searchInput.addEventListener('input', applyFilter);

        sortSelect.addEventListener('change', applySort);

        gridBtn.addEventListener('click', function () {
            grid.classList.remove('list-view');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        });

        listBtn.addEventListener('click', function () {
            grid.classList.add('list-view');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        });
    });
</script>
@endsection