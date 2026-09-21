@extends('sias.students.layout.master')

@section('title', 'Addresses & Contacts')
@section('page_title', 'Addresses & Contacts')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <h2 style="margin:0 0 1rem;">Addresses & Contacts</h2>
    <p style="margin:0 0 1.5rem;color:var(--text-muted);">Keep your mailing address and contact information current.</p>

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.student.profile.addresses_contacts.update') }}" class="section-card" style="display:grid;gap:1.5rem;max-width:860px;">
        @csrf
        
        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-map-location-dot" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Address Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:1.4fr .6fr;gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Permanent Address
                        <input name="permanent_address" class="form-input" placeholder="Street, Barangay, City, Province">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Zip Code
                        <input name="zip_code" class="form-input" placeholder="e.g. 1000">
                    </label>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-phone" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Contact Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Mobile Number
                        <input name="mobile_number" class="form-input" placeholder="e.g. 09171234567">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Email Address
                        <input name="contact_email" type="email" class="form-input" placeholder="student@example.com">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Emergency Contact
                        <input name="emergency_contact" class="form-input" placeholder="Name and number">
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