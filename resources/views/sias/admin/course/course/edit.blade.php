@extends('sias.admin.layouts.master')

@section('title', 'Edit Course')
@section('page_title', 'Edit Course')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <div style="margin-bottom:2rem;">
        <h2 style="margin:0 0 .5rem;font-size:2rem;letter-spacing:-.02em;">Edit Course</h2>
        <p style="margin:0;color:var(--text-muted);">Update the course information</p>
    </div>

    @if($errors->any())
        <div style="display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.25rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;margin-bottom:1.5rem;color:#dc2626;">
            <i class="fa-solid fa-exclamation-circle" style="font-size:1.2rem;margin-top:.25rem;flex-shrink:0;"></i>
            <div>
                <strong>Error</strong>
                <ul style="margin:.5rem 0 0;padding-left:1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.admin.course.update', $course->id) }}" class="section-card" style="display:grid;gap:1.5rem;max-width:800px;">
        @csrf
        @method('PUT')

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-book-open" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Course Details</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">
                        Course Title <span style="color:#dc2626;">*</span>
                    </label>
                    <input name="title" type="text" class="form-input" placeholder="e.g. Bachelor of Science in Information Technology" value="{{ old('title', $course->title) }}" required>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            Course Code <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="code" type="text" class="form-input" placeholder="e.g. BSIT" value="{{ old('code', $course->code) }}" required>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            Department <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="department" type="text" class="form-input" placeholder="e.g. Information Technology" value="{{ old('department', $course->department) }}" required>
                    </div>
                </div>

                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">Description</label>
                    <textarea name="description" rows="4" class="form-input" placeholder="Brief description of the course">{{ old('description', $course->description) }}</textarea>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Duration (Years)</label>
                        <input name="duration" type="number" class="form-input" placeholder="e.g. 4" min="1" value="{{ old('duration', $course->duration ?? 4) }}">
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Category</label>
                        <select name="category" class="form-input">
                            <option value="">Select Category</option>
                            <option value="Undergraduate" {{ old('category', $course->category) == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                            <option value="Graduate" {{ old('category', $course->category) == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="Certificate" {{ old('category', $course->category) == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                        </select>
                    </div>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-cogs" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Additional Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">Curriculum</label>
                    <input name="curriculum" type="text" class="form-input" placeholder="e.g. BSIT Curriculum 2024" value="{{ old('curriculum', $course->curriculum) }}">
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }} style="width:1rem;height:1rem;margin-right:.5rem;cursor:pointer;">
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </details>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('sias.admin.course') }}" class="btn-white">Cancel</a>
            <button type="submit" class="btn-black">Update Course</button>
        </div>
    </form>
</div>

<style>
    .form-section-toggle { list-style: none; }
    .form-section-toggle summary { list-style: none; outline: none; }
    .form-section-toggle summary::-webkit-details-marker { display: none; }
    .form-section-toggle[open] summary { background: var(--block-bg-hover) !important; border-color: var(--accent-strong) !important; }
    .form-section-toggle[open] summary i:last-child { transform: rotate(180deg); }
    .form-section-toggle summary:hover { background: var(--block-bg-hover) !important; border-color: var(--accent-strong) !important; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
