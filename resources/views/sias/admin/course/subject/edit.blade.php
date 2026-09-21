@extends('sias.admin.layouts.master')

@section('title', 'Edit Subject')
@section('page_title', 'Edit Subject')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <div style="margin-bottom:2rem;">
        <h2 style="margin:0 0 .5rem;font-size:2rem;letter-spacing:-.02em;" data-i18n="edit_subject">Edit Subject</h2>
        <p style="margin:0;color:var(--text-muted);" data-i18n="update_subject_information">Update subject information</p>
    </div>

    @if($errors->any())
        <div style="display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.25rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;margin-bottom:1.5rem;color:#dc2626;">
            <i class="fa-solid fa-exclamation-circle" style="font-size:1.2rem;margin-top:.25rem;flex-shrink:0;"></i>
            <div>
                <strong data-i18n="error">Error</strong>
                <ul style="margin:.5rem 0 0;padding-left:1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.admin.subject.update', $subject->id) }}" class="section-card" style="display:grid;gap:1.5rem;max-width:800px;">
        @csrf
        @method('PUT')

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-book" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span data-i18n="subject_information">Subject Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">
                        <span data-i18n="select_course">Select Course</span> <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="course_id" class="form-input" required>
                        <option value="" data-i18n="choose_course">Choose a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }} ({{ $course->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">
                        <span data-i18n="subject_title">Subject Title</span> <span style="color:#dc2626;">*</span>
                    </label>
                    <input name="title" type="text" class="form-input" placeholder="" data-i18n-placeholder="e_g_introduction_programming" value="{{ old('title', $subject->title) }}" required>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <span data-i18n="subject_code">Subject Code</span> <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="code" type="text" class="form-input" placeholder="" data-i18n-placeholder="e_g_cs101" value="{{ old('code', $subject->code) }}" required>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <span data-i18n="credit_units">Credit Units</span> <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="units" type="number" class="form-input" placeholder="" data-i18n-placeholder="e_g_3" min="1" max="6" value="{{ old('units', $subject->units ?? 3) }}" required>
                    </div>
                </div>

                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);" data-i18n="description">Description</label>
                    <textarea name="description" rows="4" class="form-input" placeholder="" data-i18n-placeholder="subject_description_objectives">{{ old('description', $subject->description) }}</textarea>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-graduation-cap" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Curriculum Details</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            Year Level <span style="color:#dc2626;">*</span>
                        </label>
                        <select name="year_level" class="form-input" required>
                            <option value="">Select Year</option>
                            <option value="1" {{ old('year_level', $subject->year_level) == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('year_level', $subject->year_level) == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('year_level', $subject->year_level) == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('year_level', $subject->year_level) == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Semester</label>
                        <select name="semester" class="form-input">
                            <option value="">Select Semester</option>
                            <option value="1" {{ old('semester', $subject->semester) == 1 ? 'selected' : '' }}>1st Semester</option>
                            <option value="2" {{ old('semester', $subject->semester) == 2 ? 'selected' : '' }}>2nd Semester</option>
                            <option value="3" {{ old('semester', $subject->semester) == 3 ? 'selected' : '' }}>Summer</option>
                        </select>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Lecture Hours</label>
                        <input name="lecture_hours" type="number" class="form-input" placeholder="e.g. 3" min="0" value="{{ old('lecture_hours', $subject->lecture_hours ?? 3) }}">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Lab Hours</label>
                        <input name="lab_hours" type="number" class="form-input" placeholder="e.g. 2" min="0" value="{{ old('lab_hours', $subject->lab_hours ?? 0) }}">
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <input type="checkbox" name="is_required" value="1" {{ old('is_required', $subject->is_required) ? 'checked' : '' }} style="width:1rem;height:1rem;margin-right:.5rem;cursor:pointer;">
                            Required Subject
                        </label>
                    </div>
                </div>
            </div>
        </details>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('sias.admin.subject') }}" class="btn-white">Cancel</a>
            <button type="submit" class="btn-black">Update Subject</button>
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
