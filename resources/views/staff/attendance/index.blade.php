@extends('staff.layouts.masters')

@section('title', 'Staff Attendance')

@section('content')
<div class="cr-page" style="padding:24px;display:grid;gap:20px;">
    <div class="cr-card" style="padding:24px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <div class="cr-header__eyebrow">
                <span class="cr-header__eyebrow-dot"></span>
                Staff Portal
            </div>
            <h1 class="cr-header__title" style="margin:4px 0 0;">Attendance</h1>
            <p class="cr-header__subtitle" style="margin-top:6px;">View your weekly attendance progress and logged hours.</p>
        </div>
        <a href="{{ route('staff.dashboard') }}" class="cr-btn cr-btn--outline">Back to Dashboard</a>
    </div>

    <div class="cr-card" style="padding:24px;display:grid;gap:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div>
                <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Hours logged</div>
                <div style="font-size:24px;font-weight:700;margin-top:4px;">{{ $attendance['hours_logged'] }} / {{ $attendance['target_hours'] }} hrs</div>
            </div>
            <div style="min-width:220px;">
                <div style="height:8px;border-radius:999px;background:#e2e8f0;overflow:hidden;">
                    <div style="height:100%;width:{{ round(($attendance['hours_logged'] / $attendance['target_hours']) * 100) }}%;background:#2563eb;border-radius:999px;"></div>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(90px,1fr));gap:10px;">
            @foreach($attendance['days'] as $day)
                <div style="border:1px solid #e2e8f0;border-radius:12px;padding:12px;text-align:center;background:#f8fafc;">
                    <div style="font-weight:700;">{{ $day['label'] }}</div>
                    <div style="margin-top:6px;font-size:12px;color:{{ $day['state'] === 'active' ? '#2563eb' : '#94a3b8' }};">
                        {{ $day['state'] === 'active' ? 'Present' : 'Pending' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
