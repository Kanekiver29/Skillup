@extends('teacher.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<style>
    .teacher-dashboard {
        --ink: #101a33;
        --muted: #71809b;
        --line: #e5eaf5;
        --blue: #2f5be7;
        --blue-soft: #eef3ff;
        --teal: #11a8a3;
        color: var(--ink);
        max-width: 1280px;
        margin: 0 auto;
    }
    .dashboard-intro { display:flex; align-items:flex-end; justify-content:space-between; gap:1.5rem; margin-bottom:1.35rem; animation:teacherFadeUp .5s ease both; }
    .dashboard-kicker { color:var(--blue); font-size:.72rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; margin-bottom:.45rem; }
    .dashboard-intro h2 { font-family:'Plus Jakarta Sans',sans-serif; color:var(--ink); font-size:clamp(1.7rem,3vw,2.45rem); line-height:1.1; letter-spacing:-.045em; margin:0; }
    .dashboard-intro p { color:var(--muted); margin-top:.55rem; font-size:.9rem; }
    .date-chip { display:inline-flex; align-items:center; gap:.55rem; color:#52627e; background:#fff; border:1px solid var(--line); border-radius:999px; padding:.65rem .85rem; font-size:.78rem; font-weight:700; box-shadow:0 8px 20px rgba(25,46,94,.06); white-space:nowrap; }
    .date-chip span { width:7px; height:7px; border-radius:50%; background:#21bb7a; box-shadow:0 0 0 4px #e7f8ef; }
    .dashboard-hero { display:grid; grid-template-columns:minmax(0,1fr) auto; gap:1.5rem; align-items:center; background:linear-gradient(125deg,#111b36 0%,#1c2d5b 100%); border-radius:1.2rem; color:#fff; padding:1.65rem 1.8rem; position:relative; overflow:hidden; box-shadow:0 18px 34px rgba(29,51,103,.17); animation:teacherFadeUp .55s .05s ease both; }
    .dashboard-hero::after { content:''; position:absolute; width:270px; height:270px; right:16%; top:-145px; border:1px solid rgba(255,255,255,.15); border-radius:50%; box-shadow:0 0 0 32px rgba(255,255,255,.025),0 0 0 64px rgba(255,255,255,.025); pointer-events:none; }
    .hero-copy,.hero-actions { position:relative; z-index:1; }
    .hero-copy small { color:#a9b9df; font-size:.7rem; letter-spacing:.15em; text-transform:uppercase; font-weight:800; }
    .hero-copy h3 { font-family:'Playfair Display',Georgia,serif; font-size:clamp(1.55rem,3vw,2.25rem); margin:.45rem 0; line-height:1.1; }
    .hero-copy p { color:#b9c6e1; max-width:560px; font-size:.88rem; line-height:1.65; }
    .hero-actions { display:flex; flex-direction:column; gap:.65rem; min-width:158px; }
    .dashboard-button { display:inline-flex; align-items:center; justify-content:center; gap:.55rem; border-radius:.65rem; padding:.72rem 1rem; font-size:.78rem; font-weight:800; transition:transform .2s ease,box-shadow .2s ease,background .2s ease; }
    .dashboard-button:hover { transform:translateY(-2px); }
    .dashboard-button.primary { background:#d7ad65; color:#16213a; box-shadow:0 8px 20px rgba(0,0,0,.16); }
    .dashboard-button.secondary { border:1px solid rgba(255,255,255,.18); color:#fff; background:rgba(255,255,255,.07); }
    .dashboard-section { margin-top:1.35rem; }
    .section-heading,.panel-title-row { display:flex; align-items:center; justify-content:space-between; gap:1rem; }
    .section-heading { margin-bottom:.7rem; }
    .section-heading h3,.panel-title-row h3 { color:var(--ink); font-family:'Plus Jakarta Sans',sans-serif; font-size:.95rem; }
    .section-heading a,.panel-title-row a { color:var(--blue); font-size:.75rem; font-weight:800; }
    .kpi-grid { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:.8rem; }
    .kpi-card { background:#fff; border:1px solid var(--line); border-radius:.9rem; padding:1rem; min-width:0; box-shadow:0 8px 22px rgba(25,46,94,.05); animation:teacherFadeUp .5s ease both; transition:transform .2s ease,box-shadow .2s ease; }
    .kpi-card:hover { transform:translateY(-3px); box-shadow:0 14px 28px rgba(25,46,94,.1); }
    .kpi-card:nth-child(2){animation-delay:.06s}.kpi-card:nth-child(3){animation-delay:.12s}.kpi-card:nth-child(4){animation-delay:.18s}.kpi-card:nth-child(5){animation-delay:.24s}
    .kpi-top { display:flex; align-items:center; justify-content:space-between; gap:.5rem; }
    .kpi-icon { display:inline-flex; width:2rem; height:2rem; align-items:center; justify-content:center; border-radius:.6rem; background:var(--blue-soft); color:var(--blue); font-size:.9rem; font-weight:900; }
    .kpi-card:nth-child(2) .kpi-icon{background:#e9f8f7;color:var(--teal)}.kpi-card:nth-child(3) .kpi-icon{background:#fff5e5;color:#b77c18}.kpi-card:nth-child(4) .kpi-icon{background:#f4edff;color:#8055c9}.kpi-card:nth-child(5) .kpi-icon{background:#eaf8ef;color:#21965c}
    .kpi-badge { color:#24945e; background:#eaf8ef; border-radius:999px; padding:.25rem .45rem; font-size:.62rem; font-weight:800; white-space:nowrap; }
    .kpi-card strong { display:block; margin-top:.9rem; color:var(--ink); font-family:'Plus Jakarta Sans',sans-serif; font-size:1.65rem; letter-spacing:-.05em; }
    .kpi-card p { color:var(--muted); font-size:.7rem; margin-top:.18rem; line-height:1.3; }
    .dashboard-columns { display:grid; grid-template-columns:minmax(0,1.2fr) minmax(280px,.8fr); gap:.9rem; }
    .dashboard-panel { background:#fff; border:1px solid var(--line); border-radius:.95rem; padding:1.15rem; box-shadow:0 8px 22px rgba(25,46,94,.04); }
    .panel-title-row { margin-bottom:.9rem; }.panel-title-row span { color:var(--muted); font-size:.7rem; }
    .action-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:.55rem; }
    .action-card { display:flex; align-items:center; gap:.7rem; border:1px solid var(--line); border-radius:.7rem; padding:.75rem; color:var(--ink); transition:border-color .2s ease,background .2s ease,transform .2s ease; }
    .action-card:hover { background:#f7f9ff; border-color:#b8c8f5; transform:translateY(-2px); }.action-card i { width:1.9rem; height:1.9rem; display:inline-flex; align-items:center; justify-content:center; border-radius:.55rem; background:var(--blue-soft); color:var(--blue); font-style:normal; font-size:.8rem; font-weight:900; }.action-card span { font-size:.76rem; font-weight:800; }
    .activity-list { list-style:none; display:grid; gap:.1rem; }.activity-item { display:flex; align-items:center; gap:.7rem; padding:.55rem 0; border-bottom:1px solid #f0f2f8; }.activity-item:last-child{border-bottom:0}.activity-avatar { flex:0 0 2rem; height:2rem; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:#eef3ff; color:var(--blue); font-size:.65rem; font-weight:900; }.activity-copy{min-width:0;flex:1}.activity-copy p{color:#3c4963;font-size:.74rem;line-height:1.35}.activity-copy time{color:#9aa6bb;font-size:.65rem}.activity-status{width:6px;height:6px;border-radius:50%;background:#2abb7b}
    .attendance-row { display:grid; grid-template-columns:repeat(3,1fr); gap:.55rem; }.attendance-box{border-radius:.7rem;padding:.7rem;background:#f8faff}.attendance-box strong{display:block;color:var(--ink);font-size:1.05rem}.attendance-box span{color:var(--muted);font-size:.65rem}
    @keyframes teacherFadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
    @media(max-width:1050px){.kpi-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
    @media(max-width:760px){.dashboard-intro,.dashboard-hero{display:block}.date-chip{margin-top:1rem}.hero-actions{flex-direction:row;flex-wrap:wrap;margin-top:1.25rem}.dashboard-button{flex:1}.dashboard-columns{grid-template-columns:1fr}}
    @media(max-width:560px){.kpi-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.action-grid{grid-template-columns:1fr}.hero-actions{flex-direction:column}}
</style>

@php
    $teacherName = auth()->user()->name ?? 'Instructor';
    $today = now()->format('D, M j, Y');
@endphp

<div class="teacher-dashboard">
    <section class="dashboard-intro" aria-label="Dashboard introduction">
        <div><div class="dashboard-kicker">Instructor workspace</div><h2>Good afternoon, {{ $teacherName }}</h2><p>Here is the pulse of your training programs today.</p></div>
        <div class="date-chip"><span aria-hidden="true"></span>{{ $today }}</div>
    </section>

    <section class="dashboard-hero" aria-label="Dashboard welcome">
        <div class="hero-copy"><small>Keep learning moving forward</small><h3>Build confident, career-ready learners.</h3><p>Manage your programs, modules, assessments, and trainee progress from one focused workspace.</p></div>
        <div class="hero-actions"><a href="{{ route('teacher.courses.index') }}" class="dashboard-button primary">Manage courses <span aria-hidden="true">&#8594;</span></a><a href="{{ route('teacher.modules.index') }}" class="dashboard-button secondary">View modules <span aria-hidden="true">&#8594;</span></a></div>
    </section>

    <section class="dashboard-section" aria-labelledby="overview-heading">
        <div class="section-heading"><h3 id="overview-heading">Training overview</h3><a href="{{ route('teacher.reports.index') }}">View reports &#8594;</a></div>
        <div class="kpi-grid">
            <article class="kpi-card"><div class="kpi-top"><span class="kpi-icon">P</span><span class="kpi-badge">Live</span></div><strong>{{ $stats['programs'] ?? 0 }}</strong><p>Assigned programs</p></article>
            <article class="kpi-card"><div class="kpi-top"><span class="kpi-icon">S</span><span class="kpi-badge">7 days</span></div><strong>{{ $stats['active_sessions'] ?? 0 }}</strong><p>Upcoming sessions</p></article>
            <article class="kpi-card"><div class="kpi-top"><span class="kpi-icon">T</span><span class="kpi-badge">Active</span></div><strong>{{ $stats['trainees'] ?? 0 }}</strong><p>Total trainees</p></article>
            <article class="kpi-card"><div class="kpi-top"><span class="kpi-icon">A</span><span class="kpi-badge">Published</span></div><strong>{{ $stats['upcoming_assessments'] ?? 0 }}</strong><p>Published assessments</p></article>
            <article class="kpi-card"><div class="kpi-top"><span class="kpi-icon">&#10003;</span><span class="kpi-badge">Today</span></div><strong>{{ $stats['attendance_present'] ?? 0 }}</strong><p>Present today</p></article>
        </div>
    </section>

    <section class="dashboard-section dashboard-columns" aria-label="Dashboard activity and actions">
        <div class="dashboard-panel"><div class="panel-title-row"><h3>Quick actions</h3><span>Common tasks</span></div><div class="action-grid">
            <a href="{{ route('teacher.courses.index') }}" class="action-card"><i>P</i><span>Browse programs</span></a>
            <a href="{{ route('teacher.modules.index') }}" class="action-card"><i>M</i><span>Manage modules</span></a>
            <a href="{{ route('teacher.progress.index') }}" class="action-card"><i>G</i><span>Track progress</span></a>
            <a href="{{ route('teacher.schedule.index') }}" class="action-card"><i>S</i><span>Schedule training</span></a>
            <a href="{{ route('teacher.quizzes.create') }}" class="action-card"><i>Q</i><span>Create a quiz</span></a>
            <a href="{{ route('teacher.announcements.index') }}" class="action-card"><i>N</i><span>Post announcement</span></a>
        </div></div>
        <div class="dashboard-panel"><div class="panel-title-row"><h3>Attendance today</h3><span>{{ $stats['attendance_present'] ?? 0 }} present</span></div><div class="attendance-row"><div class="attendance-box"><strong>{{ $stats['attendance_present'] ?? 0 }}</strong><span>Present</span></div><div class="attendance-box"><strong>{{ $stats['attendance_late'] ?? 0 }}</strong><span>Late</span></div><div class="attendance-box"><strong>{{ $stats['attendance_absent'] ?? 0 }}</strong><span>Absent</span></div></div><div class="panel-title-row" style="margin-top:1.1rem;margin-bottom:.35rem"><h3>Recent activity</h3><a href="{{ route('teacher.students.index') }}">Trainees &#8594;</a></div><ul class="activity-list">
            @forelse ($activities as $activity)<li class="activity-item"><span class="activity-avatar">{{ $activity['initials'] }}</span><div class="activity-copy"><p>{{ $activity['text'] }}</p><time>{{ $activity['time'] }}</time></div><span class="activity-status"></span></li>@empty<li class="activity-item"><div class="activity-copy"><p>No recent trainee activity.</p><time>New enrollments will appear here.</time></div></li>@endforelse
        </ul></div>
    </section>
</div>
@endsection
