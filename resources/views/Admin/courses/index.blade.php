@extends('layout.Admin.system')

@section('title', 'Courses Management')

@push('head')
<style>
    /* ══════════════════════════════════════════
       COURSES PAGE — matches the admin shell's
       dark tokens (--bg-card, --accent, --gold …)
       so every bit of text stays legible.
    ══════════════════════════════════════════ */
    .courses-page { animation: cp-rise .45s cubic-bezier(.16,1,.3,1) both; }
    @keyframes cp-rise { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

    .cp-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .cp-title {
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: 26px;
        letter-spacing: -.4px; color: var(--text-primary); line-height: 1.15;
    }
    .cp-subtitle {
        font-size: 13px; color: var(--text-muted); margin-top: 4px;
    }

    .cp-btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: var(--radius-sm);
        background: linear-gradient(135deg, var(--accent-dark), var(--accent));
        color: #fff; font-size: 13px; font-weight: 600; text-decoration: none;
        border: 1px solid rgba(79,140,255,.4);
        box-shadow: 0 6px 20px rgba(79,140,255,.22);
        transition: transform .18s cubic-bezier(.34,1.56,.64,1), box-shadow .2s, filter .2s;
        white-space: nowrap;
    }
    .cp-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(79,140,255,.32);
        filter: brightness(1.06);
    }
    .cp-btn-primary:active { transform: translateY(0); }
    .cp-btn-primary i { font-size: 12px; }

    /* Success banner */
    .cp-alert {
        display: flex; align-items: center; gap: 10px;
        padding: 13px 16px; margin-bottom: 20px;
        background: rgba(47,214,167,.10); border: 1px solid rgba(47,214,167,.25);
        border-radius: var(--radius-sm); color: #bdf3e3;
        font-size: 13px; font-weight: 500;
        animation: cp-alert-in .3s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes cp-alert-in { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
    .cp-alert i { color: var(--success); font-size: 15px; flex-shrink: 0; }

    /* Card / table shell */
    .cp-card {
        background: var(--bg-card);
        border: 1px solid var(--border-mid);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-drop), inset 0 1px 0 rgba(255,255,255,.03);
    }
    .cp-table-wrap { overflow-x: auto; }
    .cp-table { width: 100%; border-collapse: collapse; }

    .cp-table thead th {
        text-align: left; padding: 14px 22px;
        background: var(--bg-surface);
        border-bottom: 1px solid var(--border-mid);
        font-size: 10.5px; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; color: var(--text-muted);
        white-space: nowrap;
    }
    .cp-table thead th:last-child { text-align: right; }

    .cp-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .18s ease;
        opacity: 0; animation: cp-row-in .35s cubic-bezier(.16,1,.3,1) forwards;
    }
    .cp-table tbody tr:last-child { border-bottom: none; }
    .cp-table tbody tr:hover { background: var(--bg-card-hover); }
    .cp-table tbody tr:nth-child(1) { animation-delay: .02s; }
    .cp-table tbody tr:nth-child(2) { animation-delay: .06s; }
    .cp-table tbody tr:nth-child(3) { animation-delay: .10s; }
    .cp-table tbody tr:nth-child(4) { animation-delay: .14s; }
    .cp-table tbody tr:nth-child(5) { animation-delay: .18s; }
    .cp-table tbody tr:nth-child(n+6) { animation-delay: .22s; }
    @keyframes cp-row-in { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

    .cp-table td { padding: 15px 22px; font-size: 13.5px; vertical-align: middle; }
    .cp-course-title { font-weight: 600; color: var(--text-primary); }
    .cp-cell-muted { color: var(--text-secondary); }
    .cp-td-actions { text-align: right; white-space: nowrap; }

    /* Pill badges (category / level) */
    .cp-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 11px; border-radius: 99px;
        font-size: 11.5px; font-weight: 600;
        background: var(--accent-soft); color: var(--accent);
        border: 1px solid rgba(79,140,255,.22);
        white-space: nowrap;
    }
    .cp-pill.cp-pill-gold {
        background: var(--gold-soft); color: var(--gold);
        border-color: rgba(242,177,52,.25);
    }
    .cp-pill i { font-size: 9px; }

    /* Published status */
    .cp-status { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; }
    .cp-status .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .cp-status.is-yes { color: var(--success); }
    .cp-status.is-yes .dot { background: var(--success); box-shadow: 0 0 8px rgba(47,214,167,.6); }
    .cp-status.is-no { color: var(--danger); }
    .cp-status.is-no .dot { background: var(--danger); box-shadow: 0 0 8px rgba(242,97,124,.5); }

    /* Row action links */
    .cp-action {
        font-size: 12px; font-weight: 600; text-decoration: none;
        padding: 6px 10px; border-radius: var(--radius-xs);
        transition: background .15s, color .15s;
        margin-left: 4px; display: inline-block;
    }
    .cp-action-enroll { color: var(--accent-2); }
    .cp-action-enroll:hover { background: rgba(155,140,247,.12); color: #cfc7ff; }
    .cp-action-edit { color: var(--accent); }
    .cp-action-edit:hover { background: var(--accent-soft); color: #cfe1ff; }

    /* Empty state */
    .cp-empty {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 10px; padding: 56px 20px; color: var(--text-muted);
    }
    .cp-empty i { font-size: 28px; color: var(--text-subtle); }
    .cp-empty span { font-size: 13.5px; }

    /* Pagination (Laravel default Tailwind pagination markup) */
    .cp-pagination-wrap { margin-top: 18px; }
    .cp-pagination-wrap nav { color: var(--text-muted); font-size: 13px; }
    .cp-pagination-wrap span:not([class]) { color: var(--text-secondary); }
    .cp-pagination-wrap a {
        color: var(--text-secondary) !important;
    }
    .cp-pagination-wrap svg { color: var(--text-muted); }
    .cp-pagination-wrap [aria-current="page"] span,
    .cp-pagination-wrap [aria-current="page"] {
        background: var(--accent) !important;
        border-color: var(--accent) !important;
        color: #fff !important;
    }

    @media (prefers-reduced-motion: reduce) {
        .courses-page, .cp-alert, .cp-table tbody tr { animation: none !important; opacity: 1 !important; }
    }
</style>
@endpush

@section('content')
<div class="courses-page">

    <header class="cp-header">
        <div>
            <h1 class="cp-title">Courses</h1>
            <p class="cp-subtitle">Manage every course on the platform — content, level, and publish status.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="cp-btn-primary">
            <i class="fas fa-plus"></i> New Course
        </a>
    </header>

    @if(session('success'))
        <div class="cp-alert">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="cp-card">
        <div class="cp-table-wrap">
            <table class="cp-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $c)
                        <tr>
                            <td class="cp-course-title">{{ $c->title }}</td>
                            <td class="cp-cell-muted">
                                <span class="cp-pill"><i class="fas fa-tag"></i>{{ $c->category }}</span>
                            </td>
                            <td class="cp-cell-muted">
                                <span class="cp-pill cp-pill-gold"><i class="fas fa-layer-group"></i>{{ $c->level }}</span>
                            </td>
                            <td>
                                @if($c->is_published)
                                    <span class="cp-status is-yes"><span class="dot"></span> Yes</span>
                                @else
                                    <span class="cp-status is-no"><span class="dot"></span> No</span>
                                @endif
                            </td>
                            <td class="cp-td-actions">
                                <a href="{{ route('admin.courses.enrollments', $c) }}" class="cp-action cp-action-enroll">Enrollments</a>
                                <a href="{{ route('admin.courses.edit', $c) }}" class="cp-action cp-action-edit">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="cp-empty">
                                    <i class="fas fa-book-open" aria-hidden="true"></i>
                                    <span>No courses created yet.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="cp-pagination-wrap">
        {{ $courses->links() }}
    </div>

</div>
@endsection