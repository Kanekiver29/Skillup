@extends('sias.students.layout.master')

@section('title', 'Family Background')
@section('page_title', 'Family Background')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <h2 style="margin:0 0 1rem;">Family Background</h2>
    <p style="margin:0 0 1.5rem;color:var(--text-muted);">Submit family member details relevant to your enrollment.</p>

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.student.profile.family_background.update') }}" class="section-card" style="display:grid;gap:1.5rem;max-width:860px;">
        @csrf
        
        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-people-group" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Parents Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Father's Name
                        <input name="father_name" class="form-input" placeholder="Father's full name">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Mother's Name
                        <input name="mother_name" class="form-input" placeholder="Mother's full name">
                    </label>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-hand-holding-hand" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Guardian Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Guardian Name
                        <input name="guardian_name" class="form-input" placeholder="Guardian full name">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Relationship
                        <input name="guardian_relationship" class="form-input" placeholder="e.g. Aunt, Uncle">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Contact Number
                        <input name="guardian_contact" class="form-input" placeholder="e.g. 09181234567">
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