@extends('teacher.layouts.master')

@section('title', 'Upload Learning Resource')
@section('page_title', 'Upload Resource')

@section('content')
<style>
    .upload-container {
        max-width: 840px;
        margin: 0 auto;
    }
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .page-header-box h1 {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .btn-back {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--navy-800);
        font-weight: 700;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        transition: all 0.2s var(--ease);
    }
    .btn-back:hover {
        background: var(--navy-50);
        color: var(--navy-950);
        border-color: var(--navy-200);
    }

    .type-switcher {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
    }
    .type-tab {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-2);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s var(--ease);
    }
    .type-tab.active {
        background: var(--navy-950);
        color: #fff;
        border-color: var(--navy-950);
        box-shadow: 0 4px 14px rgba(5, 7, 15, 0.2);
    }
    .type-tab:hover:not(.active) {
        background: var(--navy-50);
        color: var(--navy-950);
    }

    .upload-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-group label span.req {
        color: var(--danger);
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-family: inherit;
        font-size: 0.92rem;
        transition: all 0.2s var(--ease);
    }
    .form-control:focus {
        border-color: var(--accent-2);
        box-shadow: 0 0 0 3.5px var(--accent-muted);
        outline: none;
        background: #fff;
    }
    .form-hint {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.35rem;
    }

    .file-dropzone {
        border: 2px dashed var(--navy-200);
        border-radius: var(--radius-lg);
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: var(--surface-2);
        transition: all 0.25s var(--ease);
        cursor: pointer;
        position: relative;
    }
    .file-dropzone:hover {
        border-color: var(--accent);
        background: var(--navy-50);
    }
    .file-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .dropzone-icon {
        font-size: 2.8rem;
        margin-bottom: 0.75rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 18px var(--accent-glow);
        transition: all 0.25s var(--ease);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--accent-glow);
    }
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
</style>

@php
    $type = $resourceType ?? request()->query('type', 'pdf');
    $typeLabels = [
        'pdf' => ['title' => 'PDF Document', 'icon' => '📄', 'accept' => '.pdf', 'hint' => 'Upload PDF materials (max 10MB)'],
        'video' => ['title' => 'Video Lecture', 'icon' => '🎥', 'accept' => 'video/mp4,video/quicktime,video/x-msvideo,video/x-matroska', 'hint' => 'Upload MP4 or MOV video (max 100MB)'],
        'word' => ['title' => 'Word Document', 'icon' => '📝', 'accept' => '.doc,.docx', 'hint' => 'Upload Microsoft Word document (max 20MB)'],
        'ppt' => ['title' => 'Presentation (PPT)', 'icon' => '📊', 'accept' => '.ppt,.pptx', 'hint' => 'Upload PowerPoint presentation (max 20MB)'],
        'image' => ['title' => 'Image Graphic', 'icon' => '🖼️', 'accept' => 'image/*', 'hint' => 'Upload PNG, JPG or SVG diagram (max 10MB)'],
    ];
    $currentType = $typeLabels[$type] ?? $typeLabels['pdf'];
@endphp

<div class="upload-container">
    <div class="page-header-box">
        <div>
            <h1>{{ $currentType['icon'] }} Upload {{ $currentType['title'] }}</h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Attach course materials and media resources directly to your modules.</p>
        </div>
        <a href="{{ route('teacher.modules.index') }}" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Modules
        </a>
    </div>

    {{-- Type Tabs --}}
    <div class="type-switcher">
        <a href="{{ route('teacher.modules.upload-resource') }}?type=pdf" class="type-tab {{ $type === 'pdf' ? 'active' : '' }}">📄 PDF Document</a>
        <a href="{{ route('teacher.modules.upload-resource') }}?type=video" class="type-tab {{ $type === 'video' ? 'active' : '' }}">🎥 Video Lecture</a>
        <a href="{{ route('teacher.modules.upload-resource') }}?type=word" class="type-tab {{ $type === 'word' ? 'active' : '' }}">📝 Word Document</a>
        <a href="{{ route('teacher.modules.upload-resource') }}?type=ppt" class="type-tab {{ $type === 'ppt' ? 'active' : '' }}">📊 Presentation (PPT)</a>
        <a href="{{ route('teacher.modules.upload-resource') }}?type=image" class="type-tab {{ $type === 'image' ? 'active' : '' }}">🖼️ Image Graphic</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #15803d; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 0.6rem; font-weight: 600;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:currentColor; cursor:pointer; font-size:1.1rem;">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <strong style="display:block; margin-bottom:0.4rem;">Please fix the errors below:</strong>
            <ul style="padding-left: 1.2rem; font-size: 0.88rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="upload-card">
        <form method="POST" action="{{ route('teacher.modules.upload-resource.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="resource_type" value="{{ $type }}">

            <div class="form-group">
                <label for="course_id">Target Course</label>
                <select id="course_id" name="course_id" class="form-control" onchange="filterModulesByCourse(this.value)">
                    <option value="">-- Choose Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('course_id', request('course_id')) == $c->id ? 'selected' : '' }}>
                            {{ $c->title }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Select the course this resource belongs to.</div>
            </div>

            <div class="form-group">
                <label for="module_id">Target Module <span class="req">*</span></label>
                <select id="module_id" name="module_id" class="form-control">
                    <option value="">-- Choose Module --</option>
                    @foreach($modules as $m)
                        <option value="{{ $m->id }}" data-course-id="{{ $m->course_id }}" {{ old('module_id', request('module_id')) == $m->id ? 'selected' : '' }}>
                            {{ $m->title }} (Course: {{ $m->course?->title }})
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Required: attaching to a module makes this resource available to its students.</div>
            </div>

            <div class="form-group">
                <label>Select File <span class="req">*</span></label>
                <div class="file-dropzone" onclick="document.getElementById('resource_file').click()">
                    <div class="dropzone-icon">{{ $currentType['icon'] }}</div>
                    <div style="font-weight:700; font-size:1.05rem; color:var(--navy-950); margin-bottom:0.25rem;">
                        Click or drag file here to upload
                    </div>
                    <div style="font-size:0.84rem; color:var(--muted);" id="file-name-display">
                        {{ $currentType['hint'] }}
                    </div>
                    <input type="file" id="resource_file" name="resource_file" accept="{{ $currentType['accept'] }}" required onchange="showSelectedFile(this)">
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('teacher.modules.index') }}" class="btn-back">Cancel</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Upload & Save Resource
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showSelectedFile(input) {
        const display = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            display.innerHTML = `<span style="color:var(--accent); font-weight:700;">Selected: ${file.name}</span> (${sizeMb} MB)`;
        }
    }

    function filterModulesByCourse(courseId) {
        const moduleSelect = document.getElementById('module_id');
        const options = moduleSelect.querySelectorAll('option');
        options.forEach(opt => {
            if (!opt.value) return;
            const cId = opt.getAttribute('data-course-id');
            if (!courseId || cId == courseId) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
    }
</script>
@endsection
