@extends('teacher.layouts.master')

@section('title', 'Upload Resource')
@section('page_title', 'Upload Resource')

@section('content')

<style>
    /* ── Base ───────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .ur-wrap {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 2.5rem 1rem 4rem;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* ── Card ───────────────────────────────────── */
    .ur-card {
        width: 100%;
        max-width: 680px;
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow:
            0 0 0 1px rgba(16,185,129,.09),
            0 4px 6px -2px rgba(15,23,41,.06),
            0 20px 60px -10px rgba(16,185,129,.12);
        overflow: hidden;
        animation: cardRise .55s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes cardRise {
        from { opacity: 0; transform: translateY(32px) scale(.97); }
        to   { opacity: 1; transform: translateY(0)   scale(1);    }
    }

    /* ── Header ─────────────────────────────────── */
    .ur-header {
        background: linear-gradient(135deg, #059669 0%, #0D9488 55%, #0891B2 100%);
        padding: 2rem 2rem 1.6rem;
        position: relative;
        overflow: hidden;
    }

    .ur-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='64' height='64' viewBox='0 0 64 64' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cpath d='M32 0 L64 32 L32 64 L0 32 Z' fill='%23ffffff' fill-opacity='0.035'/%3E%3C/g%3E%3C/svg%3E");
        background-size: 64px 64px;
        animation: patternDrift 22s linear infinite;
    }

    @keyframes patternDrift {
        from { background-position: 0 0;      }
        to   { background-position: 64px 64px; }
    }

    .ur-header-icon {
        width: 3rem;
        height: 3rem;
        background: rgba(255,255,255,.18);
        border-radius: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        position: relative;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,.25);
        animation: iconPop .55s .25s cubic-bezier(.22,.68,0,1.35) both;
    }

    @keyframes iconPop {
        from { opacity: 0; transform: scale(.5); }
        to   { opacity: 1; transform: scale(1);  }
    }

    .ur-header-icon svg { width: 1.4rem; height: 1.4rem; color: #fff; }

    .ur-header h2 {
        font-size: 1.45rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -.02em;
        text-transform: capitalize;
        position: relative;
    }

    .ur-header p {
        margin-top: .35rem;
        font-size: .875rem;
        color: rgba(255,255,255,.72);
        position: relative;
    }

    /* ── Progress dots ──────────────────────────── */
    .ur-steps {
        display: flex;
        gap: .5rem;
        margin-top: 1.4rem;
        position: relative;
    }

    .ur-step-dot {
        height: 4px;
        border-radius: 2px;
        background: rgba(255,255,255,.25);
        flex: 1;
        transition: background .4s ease, box-shadow .4s ease;
    }

    .ur-step-dot.active {
        background: #fff;
        box-shadow: 0 0 8px rgba(255,255,255,.6);
    }

    /* ── Form body ──────────────────────────────── */
    .ur-body {
        padding: 2rem;
        display: grid;
        gap: 1.4rem;
    }

    /* ── Section eyebrow ────────────────────────── */
    .ur-section-label {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #059669;
        margin-bottom: -.4rem;
    }

    .ur-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, rgba(5,150,105,.25), transparent);
    }

    /* ── Fields ─────────────────────────────────── */
    .ur-field {
        display: flex;
        flex-direction: column;
        gap: .4rem;
        animation: fieldSlide .45s both;
    }

    .ur-field:nth-child(1)  { animation-delay: .07s; }
    .ur-field:nth-child(2)  { animation-delay: .12s; }
    .ur-field:nth-child(3)  { animation-delay: .17s; }
    .ur-field:nth-child(4)  { animation-delay: .22s; }
    .ur-field:nth-child(5)  { animation-delay: .27s; }
    .ur-field:nth-child(6)  { animation-delay: .32s; }
    .ur-field:nth-child(7)  { animation-delay: .37s; }

    @keyframes fieldSlide {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    /* ── Labels ─────────────────────────────────── */
    .ur-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .825rem;
        font-weight: 600;
        color: #1e293b;
        letter-spacing: -.01em;
    }

    .ur-label svg { width: .9rem; height: .9rem; color: #059669; flex-shrink: 0; }
    .ur-label .ur-badge {
        margin-left: auto;
        font-size: .68rem;
        font-weight: 600;
        padding: .15rem .5rem;
        border-radius: 99px;
        background: #f0fdf4;
        color: #059669;
        border: 1px solid #bbf7d0;
    }

    .ur-label .ur-badge.optional {
        background: #f8fafc;
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    /* ── Inputs & selects ───────────────────────── */
    .ur-input,
    .ur-select {
        width: 100%;
        padding: .75rem 1rem;
        font-size: .9rem;
        font-family: inherit;
        color: #1e293b;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: .85rem;
        outline: none;
        transition:
            border-color .2s ease,
            background   .2s ease,
            box-shadow   .25s ease,
            transform    .15s ease;
        appearance: none;
        -webkit-appearance: none;
    }

    .ur-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23059669' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
        cursor: pointer;
    }

    .ur-select:disabled {
        opacity: .55;
        cursor: not-allowed;
        background-color: #f1f5f9;
    }

    .ur-input:hover:not(:disabled),
    .ur-select:hover:not(:disabled) {
        border-color: #6ee7b7;
        background: #fff;
    }

    .ur-input:focus,
    .ur-select:focus {
        border-color: #059669;
        background: #fff;
        box-shadow:
            0 0 0 3px rgba(5,150,105,.12),
            0 1px 4px rgba(5,150,105,.10);
        transform: translateY(-1px);
    }

    /* ── Module loading state ───────────────────── */
    .ur-select.is-loading {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='12' r='10' stroke='%23059669' stroke-width='2' stroke-dasharray='31.4' stroke-dashoffset='10' stroke-linecap='round'%3E%3CanimateTransform attributeName='transform' type='rotate' from='0 12 12' to='360 12 12' dur='.8s' repeatCount='indefinite'/%3E%3C/circle%3E%3C/svg%3E");
        background-size: 1.1rem;
    }

    /* ── Hint ───────────────────────────────────── */
    .ur-hint {
        font-size: .75rem;
        color: #94a3b8;
    }

    /* ── Error ──────────────────────────────────── */
    .ur-error {
        font-size: .78rem;
        color: #ef4444;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Divider ────────────────────────────────── */
    .ur-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: .2rem 0;
    }

    /* ── Drop zone ──────────────────────────────── */
    .ur-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .65rem;
        cursor: pointer;
        transition:
            border-color .25s ease,
            background   .25s ease,
            transform    .2s ease;
        background: #f8fafc;
        text-align: center;
        position: relative;
    }

    .ur-dropzone:hover,
    .ur-dropzone.drag-over {
        border-color: #059669;
        background: #f0fdf4;
        transform: translateY(-2px);
        box-shadow: 0 4px 18px rgba(5,150,105,.10);
    }

    .ur-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .ur-dropzone-icon {
        width: 3rem;
        height: 3rem;
        background: #ecfdf5;
        border-radius: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #a7f3d0;
        transition: transform .3s cubic-bezier(.22,.68,0,1.35);
    }

    .ur-dropzone:hover .ur-dropzone-icon,
    .ur-dropzone.drag-over .ur-dropzone-icon {
        transform: translateY(-4px) scale(1.05);
    }

    .ur-dropzone-icon svg { width: 1.4rem; height: 1.4rem; color: #059669; }

    .ur-dropzone-title {
        font-size: .9rem;
        font-weight: 600;
        color: #1e293b;
    }

    .ur-dropzone-sub {
        font-size: .78rem;
        color: #94a3b8;
        line-height: 1.5;
    }

    .ur-dropzone-btn {
        display: inline-block;
        padding: .35rem .9rem;
        font-size: .8rem;
        font-weight: 600;
        color: #059669;
        background: #ecfdf5;
        border: 1.5px solid #a7f3d0;
        border-radius: 99px;
        transition: background .2s, border-color .2s;
        pointer-events: none;
    }

    .ur-dropzone:hover .ur-dropzone-btn {
        background: #d1fae5;
        border-color: #6ee7b7;
    }

    /* ── File preview chip ──────────────────────── */
    .ur-file-chip {
        display: none;
        align-items: center;
        gap: .65rem;
        padding: .7rem 1rem;
        background: #f0fdf4;
        border: 1.5px solid #a7f3d0;
        border-radius: .85rem;
        font-size: .85rem;
        color: #065f46;
        animation: chipPop .3s cubic-bezier(.22,.68,0,1.35) both;
    }

    .ur-file-chip.visible { display: flex; }

    @keyframes chipPop {
        from { opacity: 0; transform: scale(.9); }
        to   { opacity: 1; transform: scale(1);  }
    }

    .ur-file-chip svg { width: 1rem; height: 1rem; flex-shrink: 0; }

    .ur-file-chip-name {
        flex: 1;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ur-file-chip-size { font-size: .75rem; color: #059669; flex-shrink: 0; }

    .ur-file-chip-remove {
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        padding: .15rem;
        border-radius: .4rem;
        display: flex;
        align-items: center;
        transition: color .2s;
    }

    .ur-file-chip-remove:hover { color: #ef4444; }
    .ur-file-chip-remove svg { width: .9rem; height: .9rem; }

    /* ── Actions ────────────────────────────────── */
    .ur-actions {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        align-items: center;
        padding-top: .25rem;
    }

    /* ── Primary button ─────────────────────────── */
    .ur-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 1.6rem;
        font-size: .9rem;
        font-weight: 600;
        font-family: inherit;
        color: #fff;
        background: linear-gradient(135deg, #059669 0%, #0D9488 100%);
        border: none;
        border-radius: .85rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 4px 14px rgba(5,150,105,.38);
    }

    .ur-btn-primary::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
        transform: skewX(-15deg);
        transition: left .5s ease;
    }

    .ur-btn-primary:hover::before { left: 160%; }

    .ur-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(5,150,105,.42);
    }

    .ur-btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(5,150,105,.32);
    }

    .ur-btn-primary:disabled {
        opacity: .6;
        cursor: not-allowed;
        transform: none !important;
    }

    .ur-btn-primary svg { width: .95rem; height: .95rem; transition: transform .2s; }
    .ur-btn-primary:hover:not(:disabled) svg { transform: translateY(-2px); }

    /* ── Secondary button ───────────────────────── */
    .ur-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .75rem 1.4rem;
        font-size: .9rem;
        font-weight: 600;
        font-family: inherit;
        color: #64748b;
        background: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        border-radius: .85rem;
        text-decoration: none;
        transition: background .2s, border-color .2s, color .2s, transform .2s;
    }

    .ur-btn-secondary:hover {
        background: #e8edf5;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-1px);
    }

    /* ── Validation toast ───────────────────────── */
    .ur-toast {
        display: none;
        align-items: center;
        gap: .6rem;
        padding: .7rem 1rem;
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        border-radius: .85rem;
        font-size: .83rem;
        color: #b91c1c;
        animation: toastIn .3s ease both;
    }

    .ur-toast.visible { display: flex; }

    @keyframes toastIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    .ur-toast svg { width: 1rem; height: 1rem; flex-shrink: 0; }

    /* ── Reduced motion ─────────────────────────── */
    @media (prefers-reduced-motion: reduce) {
        .ur-card,
        .ur-header-icon,
        .ur-field,
        .ur-header::before   { animation: none !important; }
        .ur-input:focus,
        .ur-select:focus,
        .ur-dropzone:hover   { transform: none !important; }
        .ur-btn-primary:hover,
        .ur-btn-secondary:hover { transform: none !important; }
    }

    @keyframes spin {
        from { transform: rotate(0deg);   }
        to   { transform: rotate(360deg); }
    }
</style>

<div class="ur-wrap">
    <div class="ur-card">

        {{-- ── Header ── --}}
        <div class="ur-header">
            <div class="ur-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16
                             6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <h2>Upload {{ $resourceType }} resource</h2>
            <p>Use the form below to upload a {{ $resourceType }} file for your module.</p>
            <div class="ur-steps">
                <div class="ur-step-dot active" data-step="0"></div>
                <div class="ur-step-dot" data-step="1"></div>
                <div class="ur-step-dot" data-step="2"></div>
            </div>
        </div>

        {{-- ── Form ── --}}
        <form method="POST"
              action="{{ route('teacher.modules.upload-resource.store') }}"
              enctype="multipart/form-data"
              id="urForm"
              novalidate>
            @csrf
            <input type="hidden" name="resource_type" value="{{ $resourceType }}">

            <div class="ur-body">

                {{-- Section: Assignment ──────────────── --}}
                <div class="ur-section-label">Assignment</div>

                {{-- Course --}}
                <div class="ur-field">
                    <label class="ur-label" for="courseSelect">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168
                                     5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477
                                     4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0
                                     3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5
                                     18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Course
                        <span class="ur-badge optional">Optional</span>
                    </label>
                    <select name="course_id" id="courseSelect" class="ur-select" data-step="0">
                        <option value="">Select a course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Module --}}
                <div class="ur-field">
                    <label class="ur-label" for="moduleSelect">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2
                                     2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14
                                     0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0
                                     0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Module
                        <span class="ur-badge optional">Optional</span>
                    </label>
                    <select name="module_id" id="moduleSelect" class="ur-select" disabled data-step="0">
                        <option value="">Select a course first</option>
                    </select>
                    <span class="ur-hint" id="moduleHint">Choose a course above to load its modules.</span>
                </div>

                {{-- Validation toast --}}
                <div class="ur-toast" id="urToast">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0
                                 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2
                                 2 0 00-3.42 0z"/>
                    </svg>
                    <span id="urToastMsg">Please select a module before uploading.</span>
                </div>

                <div class="ur-divider"></div>

                {{-- Section: File ────────────────────── --}}
                <div class="ur-section-label">File</div>

                {{-- Drop zone --}}
                <div class="ur-field">
                    <label class="ur-label">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.172 7l-6.586 6.586a2 2 0 102.828
                                     2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415
                                     6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        Choose {{ $resourceType }} file
                        <span class="ur-badge">Required</span>
                    </label>

                    <div class="ur-dropzone" id="urDropzone" data-step="1">
                        <input type="file" name="resource_file"
                               id="urFileInput" required
                               accept="{{ $resourceType === 'video' ? 'video/*' : ($resourceType === 'image' ? 'image/*' : ($resourceType === 'audio' ? 'audio/*' : '')) }}">
                        <div class="ur-dropzone-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16
                                         6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <span class="ur-dropzone-title">Drag &amp; drop your file here</span>
                        <span class="ur-dropzone-sub">
                            or click to browse from your computer
                        </span>
                        <span class="ur-dropzone-btn">Browse file</span>
                    </div>

                    {{-- File chip preview --}}
                    <div class="ur-file-chip" id="urFileChip">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                     012-2h5.586a1 1 0 01.707.293l5.414 5.414a1
                                     1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="ur-file-chip-name" id="urFileName">—</span>
                        <span class="ur-file-chip-size" id="urFileSize"></span>
                        <button type="button" class="ur-file-chip-remove" id="urFileRemove"
                                title="Remove file">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @error('resource_file')
                        <span class="ur-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116
                                         0zm-7 4a1 1 0 11-2 0 1 1 0 012
                                         0zm-1-9a1 1 0 00-1 1v4a1 1 0 102
                                         0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="ur-actions">
                    <button type="submit" class="ur-btn-primary" id="urSubmit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16
                                     6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload {{ ucfirst($resourceType) }}
                    </button>
                    <a href="{{ route('teacher.modules.index') }}" class="ur-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to modules
                    </a>
                </div>

            </div>{{-- /ur-body --}}
        </form>

    </div>{{-- /ur-card --}}
</div>

<script>
(function () {
    'use strict';

    /* ── Elements ── */
    var courseSelect = document.getElementById('courseSelect');
    var moduleSelect = document.getElementById('moduleSelect');
    var moduleHint   = document.getElementById('moduleHint');
    var urForm       = document.getElementById('urForm');
    var urSubmit     = document.getElementById('urSubmit');
    var urDropzone   = document.getElementById('urDropzone');
    var urFileInput  = document.getElementById('urFileInput');
    var urFileChip   = document.getElementById('urFileChip');
    var urFileName   = document.getElementById('urFileName');
    var urFileSize   = document.getElementById('urFileSize');
    var urFileRemove = document.getElementById('urFileRemove');
    var urToast      = document.getElementById('urToast');
    var urToastMsg   = document.getElementById('urToastMsg');
    var dots         = document.querySelectorAll('.ur-step-dot');

    var initialModules = @json($modules ?? []);

    /* ── Helpers ── */
    function formatBytes(bytes) {
        if (bytes < 1024)        return bytes + ' B';
        if (bytes < 1048576)     return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function showToast(msg) {
        urToastMsg.textContent = msg;
        urToast.classList.add('visible');
        setTimeout(function () { urToast.classList.remove('visible'); }, 4000);
    }

    function hideToast() {
        urToast.classList.remove('visible');
    }

    /* ── Progress dots ── */
    function updateDots() {
        var hasCourse = !!courseSelect.value;
        var hasFile   = !!(urFileInput.files && urFileInput.files.length);

        dots[0].classList.toggle('active', true);           // always on
        dots[1].classList.toggle('active', hasCourse);
        dots[2].classList.toggle('active', hasFile);
    }

    /* ── Module placeholder helpers ── */
    function setModulePlaceholder(message, disabled) {
        moduleSelect.innerHTML = '<option value="">' + message + '</option>';
        moduleSelect.disabled = disabled;
    }

    function renderModules(list) {
        if (!list.length) {
            setModulePlaceholder('No modules available for this course.', true);
            moduleHint.textContent = 'This course has no modules yet.';
            return;
        }
        moduleSelect.disabled = false;
        moduleSelect.innerHTML = '<option value="">Select a module</option>';
        list.forEach(function (m) {
            var opt = document.createElement('option');
            opt.value = m.id;
            opt.textContent = m.title + ' (' + (m.course_title || m.course_id || 'No course') + ')';
            opt.setAttribute('data-course', m.course_id);
            moduleSelect.appendChild(opt);
        });
        moduleHint.textContent = list.length + ' module' + (list.length !== 1 ? 's' : '') + ' available.';
    }

    /* ── Fetch modules for selected course ── */
    async function loadModulesForCourse(courseId) {
        if (!courseId) {
            setModulePlaceholder('Select a course first.', true);
            moduleHint.textContent = 'Choose a course above to load its modules.';
            return;
        }

        moduleSelect.classList.add('is-loading');
        setModulePlaceholder('Loading modules…', true);
        moduleHint.textContent = 'Fetching modules…';

        var urlTemplate = '{{ route('teacher.modules.by-course', ['course' => 'COURSE_ID']) }}';
        var url = urlTemplate.replace('COURSE_ID', courseId);

        try {
            var res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Network response was not ok');
            var json = await res.json();
            renderModules(json.map(function (m) {
                return { id: m.id, title: m.title, course_id: courseId, course_title: null };
            }));
        } catch (e) {
            var filtered = initialModules.filter(function (m) {
                return String(m.course_id) === String(courseId);
            });
            renderModules(filtered.map(function (m) {
                return {
                    id: m.id,
                    title: m.title,
                    course_id: m.course_id,
                    course_title: (m.course && m.course.title) ? m.course.title : null
                };
            }));
        } finally {
            moduleSelect.classList.remove('is-loading');
        }
    }

    /* ── Course change ── */
    courseSelect.addEventListener('change', function () {
        hideToast();
        loadModulesForCourse(this.value);
        updateDots();
    });

    /* ── File input: show chip ── */
    function applyFile(file) {
        if (!file) return;
        urFileName.textContent = file.name;
        urFileSize.textContent = formatBytes(file.size);
        urFileChip.classList.add('visible');
        urDropzone.style.display = 'none';
        updateDots();
    }

    urFileInput.addEventListener('change', function () {
        if (this.files && this.files.length) {
            applyFile(this.files[0]);
        }
    });

    /* ── Remove file ── */
    urFileRemove.addEventListener('click', function () {
        urFileInput.value = '';
        urFileChip.classList.remove('visible');
        urDropzone.style.display = '';
        updateDots();
    });

    /* ── Drag and drop ── */
    ['dragenter', 'dragover'].forEach(function (evt) {
        urDropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            urDropzone.classList.add('drag-over');
        });
    });

    ['dragleave', 'drop'].forEach(function (evt) {
        urDropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            urDropzone.classList.remove('drag-over');
        });
    });

    urDropzone.addEventListener('drop', function (e) {
        var files = e.dataTransfer && e.dataTransfer.files;
        if (files && files.length) {
            // Transfer to the real input via DataTransfer
            try {
                var dt = new DataTransfer();
                dt.items.add(files[0]);
                urFileInput.files = dt.files;
            } catch (_) { /* Safari fallback — chip shows anyway */ }
            applyFile(files[0]);
        }
    });

    /* ── Form submit validation ── */
    urForm.addEventListener('submit', function (e) {
        hideToast();

        if (courseSelect.value && !moduleSelect.value) {
            e.preventDefault();
            showToast('Please select a module for the chosen course before uploading.');
            return;
        }

        if (!urFileInput.files || !urFileInput.files.length) {
            e.preventDefault();
            showToast('Please choose a file to upload.');
            return;
        }

        /* Loading state */
        urSubmit.disabled = true;
        urSubmit.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" ' +
            '     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" ' +
            '     style="animation:spin .7s linear infinite">' +
            '  <path stroke-linecap="round" stroke-linejoin="round" ' +
            '        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 ' +
            '           11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>' +
            '</svg>Uploading…';
    });

    /* ── Init ── */
    setModulePlaceholder('Select a course first.', true);
    updateDots();
}());
</script>

@endsection