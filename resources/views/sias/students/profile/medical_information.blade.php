@extends('sias.students.layout.master')

@section('title', 'Medical Information')
@section('page_title', 'Medical Information')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <h2 style="margin:0 0 1rem;">Medical Information</h2>
    <p style="margin:0 0 1.5rem;color:var(--text-muted);">Capture relevant medical details for wellness and emergency reporting.</p>

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.student.profile.medical_information.update') }}" class="section-card" style="display:grid;gap:1.5rem;max-width:860px;">
        @csrf
        
        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-droplet" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Blood & Allergies</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Blood Type
                        <select name="blood_type" class="form-input">
                            <option value="">Select blood type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Allergies
                        <input name="allergies" class="form-input" placeholder="e.g. Penicillin, shellfish">
                    </label>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-stethoscope" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Medical Conditions</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Medical Conditions
                        <input name="medical_conditions" class="form-input" placeholder="e.g. Asthma, diabetes">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Emergency Contact Info
                        <input name="medical_emergency_contact" class="form-input" placeholder="Name and number">
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