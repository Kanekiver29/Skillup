@extends('sias.admin.layouts.master')

@section('title', 'Schedule Management')
@section('page_title', 'Schedule Management')
@section('subtitle', 'Manage training sessions, rooms, teachers, and course assignments')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:1rem;">
    <a href="{{ route('admin.schedules.create') }}" class="btn" style="padding:12px 20px;">+ Add Schedule</a>
</div>

@if(session('success'))
    <div style="margin-bottom:1rem;padding:12px 16px;border:1px solid #a7f3d0;border-radius:10px;background:#ecfdf5;color:#166534;">{{ session('success') }}</div>
@endif

<div class="admin-card" style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;min-width:900px;">
        <thead>
            <tr style="border-bottom:1px solid var(--card-border);text-align:left;">
                <th style="padding:12px 10px;">Day / Time</th>
                <th style="padding:12px 10px;">Course</th>
                <th style="padding:12px 10px;">Subject</th>
                <th style="padding:12px 10px;">Teacher</th>
                <th style="padding:12px 10px;">Venue</th>
                <th style="padding:12px 10px;">Status</th>
                <th style="padding:12px 10px;text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr style="border-bottom:1px solid var(--card-border);">
                    <td style="padding:14px 10px;white-space:nowrap;">
                        <strong>{{ $schedule->day_of_week }}</strong><br>
                        <span style="color:var(--text-muted);font-size:.85rem;">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</span>
                    </td>
                    <td style="padding:14px 10px;">{{ $schedule->course?->title ?? 'No course' }}</td>
                    <td style="padding:14px 10px;">{{ $schedule->subject_name }}</td>
                    <td style="padding:14px 10px;">{{ $schedule->teacher?->name ?? 'Unassigned' }}</td>
                    <td style="padding:14px 10px;">{{ $schedule->building ?: '—' }}{{ $schedule->room_number ? ' · Room ' . $schedule->room_number : '' }}</td>
                    <td style="padding:14px 10px;">
                        <span style="display:inline-block;padding:4px 9px;border-radius:999px;background:{{ $schedule->is_active ? '#dcfce7' : '#f1f5f9' }};color:{{ $schedule->is_active ? '#166534' : '#64748b' }};font-size:.78rem;font-weight:700;">{{ $schedule->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td style="padding:14px 10px;text-align:right;white-space:nowrap;">
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn-secondary" style="padding:7px 11px;">Edit</a>
                        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" style="display:inline;" onsubmit="return confirm('Delete this schedule?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary" style="padding:7px 11px;color:#b42318;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="padding:2.5rem;text-align:center;color:var(--text-muted);">No schedules have been created yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($schedules->hasPages())
        <div style="margin-top:1rem;">{{ $schedules->links() }}</div>
    @endif
</div>
@endsection
