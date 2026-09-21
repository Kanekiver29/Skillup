@extends('sias.admin.layouts.master')

@section('title', 'Enrollment Management')
@section('page_title', 'Enrollment Management')
@section('subtitle', 'Review, approve, and monitor student enrollment records.')

@section('content')
<div class="admin-card">
    <div class="admin-actions" style="margin-top:0; margin-bottom:1.25rem;">
        <a href="{{ route('sias.admin.enrollment.add') }}" class="btn-black"><i class="fa-solid fa-plus"></i> Add Student Enrollment</a>
        <a href="{{ route('sias.admin.enrollments') }}" class="btn-white"><i class="fa-solid fa-arrows-rotate"></i> Refresh</a>
    </div>

    @if(session('success'))
        <div style="padding:.75rem 1rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#16a34a;border-radius:8px;margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-grid">
        <div class="admin-panel">
            <h3>Total Enrollments</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:var(--accent);">{{ $totalCount ?? 0 }}</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Active course records.</p>
        </div>
        <div class="admin-panel">
            <h3>Pending</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:#f59e0b;">{{ $pendingCount ?? 0 }}</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Awaiting validation.</p>
        </div>
        <div class="admin-panel">
            <h3>Approved</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:#22c55e;">{{ $approvedCount ?? 0 }}</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Validated student records.</p>
        </div>
    </div>

    <div class="admin-panel" style="margin-top:1.5rem;">
        <h3>Enrollment Records</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; margin-top:1rem;">
                <thead>
                    <tr style="border-bottom:1px solid var(--card-border);">
                        <th style="padding:.85rem .75rem; text-align:left;">Student</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Course</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Subject</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Year / Semester</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Status</th>
                        <th style="padding:.85rem .75rem; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr style="border-bottom:1px solid var(--card-border);">
                            <td style="padding:.85rem .75rem;">
                                <div style="font-weight:600;">{{ $enrollment->user->name ?? 'Unknown Student' }}</div>
                                <div style="font-size:.85rem;color:var(--text-muted);">{{ $enrollment->user->email ?? '' }}</div>
                            </td>
                            <td style="padding:.85rem .75rem;">{{ $enrollment->course->title ?? $enrollment->course->code ?? 'N/A' }}</td>
                            <td style="padding:.85rem .75rem;">
                                @if($enrollment->subject)
                                    <span style="font-weight:600;">{{ $enrollment->subject->subject_code ?? $enrollment->subject->code ?? '' }}</span> - {{ $enrollment->subject->title }}
                                @else
                                    <span style="color:var(--text-muted);">(All Subjects)</span>
                                @endif
                            </td>
                            <td style="padding:.85rem .75rem;">{{ $enrollment->year_level ?? 'N/A' }} {{ $enrollment->semester ? '· ' . $enrollment->semester : '' }}</td>
                            <td style="padding:.85rem .75rem;">
                                @if(strtolower($enrollment->status) === 'approved' || $enrollment->completed)
                                    <span style="color:#16a34a;font-weight:700;padding:.2rem .6rem;background:rgba(22,163,74,.1);border-radius:6px;font-size:.85rem;">Approved</span>
                                @elseif(strtolower($enrollment->status) === 'pending')
                                    <span style="color:#d97706;font-weight:700;padding:.2rem .6rem;background:rgba(217,119,6,.1);border-radius:6px;font-size:.85rem;">Pending</span>
                                @else
                                    <span style="color:#dc2626;font-weight:700;padding:.2rem .6rem;background:rgba(220,38,38,.1);border-radius:6px;font-size:.85rem;">{{ ucfirst($enrollment->status ?? 'Active') }}</span>
                                @endif
                            </td>
                            <td style="padding:.85rem .75rem;text-align:right;">
                                <a href="{{ route('sias.admin.enrollment.edit', $enrollment->id) }}" class="btn-white" style="padding:.4rem .7rem; font-size:.85rem;margin-right:.3rem;">Edit</a>
                                <form method="POST" action="{{ route('sias.admin.enrollment.delete', $enrollment->id) }}" style="display:inline;" onsubmit="return confirm('Delete this enrollment record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:.4rem .7rem; font-size:.85rem;background:rgba(239,68,68,.1);color:#dc2626;border:none;border-radius:6px;cursor:pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:1.25rem .75rem; color:var(--text-muted); text-align:center;">
                                No enrollment data available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($enrollments) && method_exists($enrollments, 'links'))
            <div style="margin-top:1rem;">
                {{ $enrollments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
