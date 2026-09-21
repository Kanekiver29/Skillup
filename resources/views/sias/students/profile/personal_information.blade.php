@extends('sias.students.layout.master')

@section('title', 'Personal Information')
@section('page_title', 'Personal Information')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <h2 style="margin:0 0 1rem;">Personal Information</h2>
    <p style="margin:0 0 1.5rem;color:var(--text-muted);">Review or update your personal details used for enrollment.</p>

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.student.profile.personal_information.update') }}" class="section-card" style="display:grid;gap:1.5rem;max-width:860px;">
        @csrf
        
        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-user-circle" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Basic Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        First Name
                        <input name="first_name" class="form-input" placeholder="e.g. Juan" value="{{ auth()->user()->first_name ?? '' }}">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Last Name
                        <input name="last_name" class="form-input" placeholder="e.g. Dela Cruz" value="{{ auth()->user()->last_name ?? '' }}">
                    </label>
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Date of Birth
                        <input name="birthdate" type="date" class="form-input">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Gender
                        <select name="gender" class="form-input">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Civil Status
                        <select name="civil_status" class="form-input">
                            <option value="">Select status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                        </select>
                    </label>
                </div>
            </div>
        </details>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('sias.student.profile') }}" class="btn-white">Back</a>
            <button type="submit" class="btn-black">Save</button>
        </div>
    </form>
</div>

<style>
    .form-section-toggle {
        list-style: none;
    }
    .form-section-toggle summary {
        list-style: none;
        outline: none;
    }
    .form-section-toggle summary::-webkit-details-marker {
        display: none;
    }
    .form-section-toggle[open] summary {
        background: var(--block-bg-hover) !important;
        border-color: var(--accent-strong) !important;
    }
    .form-section-toggle[open] summary i:last-child {
        transform: rotate(180deg);
    }
    .form-section-toggle summary:hover {
        background: var(--block-bg-hover) !important;
        border-color: var(--accent-strong) !important;
    }
</style>
@endsection