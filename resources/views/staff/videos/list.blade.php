@extends('staff.layouts.masters')

@section('title', 'Video Resources')

@section('content')
<div class="vr-page">
    <header class="vr-header">
        <div class="vr-header-left">
            <span class="vr-icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </span>
            <div>
                <h1 class="vr-title">Video Resources</h1>
                <p class="vr-subtitle">Attach or update videos for modules from one place.</p>
            </div>
        </div>
        <span class="vr-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            {{ $modules->count() }} {{ Str::plural('module', $modules->count()) }}
        </span>
    </header>

    @if(session('success'))
        <div class="vr-toast">
            <span class="vr-toast-check">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="vr-card vr-form-card">
        <div class="vr-form-glow"></div>
        <form action="{{ route('staff.videos.store') }}" method="POST" enctype="multipart/form-data" id="video_form" class="vr-form-grid">
            @csrf
            <div class="vr-form-fields">
                <div class="vr-field">
                    <label class="vr-label" for="module_id">Module</label>
                    <div class="vr-select-wrap">
                        <select name="module_id" id="module_id" class="vr-select" required>
                            <option value="">Select a module</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</option>
                            @endforeach
                        </select>
                        <svg class="vr-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="vr-field">
                    <label class="vr-label" for="video_file">Upload Video File</label>
                    <label for="video_file" id="drop_zone" class="vr-dropzone">
                        <span class="vr-dropzone-icon-wrap">
                            <svg id="drop_icon" class="vr-dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </span>
                        <span class="vr-dropzone-text"><span id="video_file_name">Click to choose or drag a file here</span></span>
                        <span class="vr-dropzone-hint">MP4, MOV or other common video formats</span>
                        <input type="file" name="video_file" id="video_file" accept="video/*" class="vr-hidden-input">
                        <span class="vr-dropzone-sheen"></span>
                    </label>
                </div>
            </div>

            <div class="vr-info-panel">
                <div>
                    <h2 class="vr-info-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        How it works
                    </h2>
                    <ul class="vr-info-list">
                        <li><span class="vr-dot"></span>Choose a module and upload a video file.</li>
                        <li><span class="vr-dot"></span>The video will appear in the module resources area for learners.</li>
                        <li><span class="vr-dot"></span>You can remove it later whenever needed.</li>
                    </ul>
                </div>
                <button type="submit" id="video_submit_btn" class="vr-btn-primary">
                    <svg id="video_submit_spinner" class="vr-spinner vr-hidden" viewBox="0 0 24 24" fill="none">
                        <circle class="vr-spinner-track" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="vr-spinner-head" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span id="video_submit_label">Save Video</span>
                </button>
            </div>
        </form>
    </div>

    <div class="vr-card vr-table-card">
        <table class="vr-table">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Current Video</th>
                    <th class="vr-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                    <tr class="vr-row" style="animation-delay: {{ 150 + ($loop->index * 40) }}ms;">
                        <td class="vr-td-module">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</td>
                        <td>
                            @if($module->video_url)
                                <a href="{{ $module->video_url }}" target="_blank" rel="noopener" class="vr-badge-link">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    Open video
                                </a>
                            @else
                                <span class="vr-badge-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    No video attached
                                </span>
                            @endif
                        </td>
                        <td class="vr-td-actions">
                            <a href="{{ route('staff.videos.edit', $module) }}" class="vr-link-edit">Edit</a>
                            <form action="{{ route('staff.videos.destroy', $module) }}" method="POST" onsubmit="return confirm('Remove this video resource?');" class="vr-inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="vr-link-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="vr-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span>No modules available yet.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
:root {
    --vr-primary: #0284c7;
    --vr-primary-dark: #0369a1;
    --vr-primary-light: #e0f2fe;
    --vr-accent: #06b6d4;
    --vr-ink: #1e293b;
    --vr-muted: #64748b;
    --vr-muted-light: #94a3b8;
    --vr-border: #e2e8f0;
    --vr-surface: #ffffff;
    --vr-surface-soft: #f8fafc;
    --vr-danger: #e11d48;
    --vr-success-bg: #d1fae5;
    --vr-success-text: #065f46;
    --vr-success-solid: #10b981;
    --vr-radius-lg: 1rem;
    --vr-radius-md: 0.75rem;
    --vr-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --vr-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.vr-page {
    max-width: 72rem;
    margin: 0 auto;
    padding: 1.5rem;
    font-family: inherit;
    color: var(--vr-ink);
}

/* Header */
.vr-header {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    animation: vrFadeInDown 0.4s ease-out both;
}
.vr-header-left { display: flex; align-items: center; gap: 0.75rem; }
.vr-icon-badge {
    width: 2.75rem;
    height: 2.75rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.9rem;
    color: #fff;
    background: linear-gradient(135deg, var(--vr-primary), var(--vr-accent));
    box-shadow: var(--vr-shadow-md);
}
.vr-icon-badge svg { width: 1.5rem; height: 1.5rem; display: block; }
.vr-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--vr-ink); }
.vr-subtitle { font-size: 0.875rem; color: var(--vr-muted-light); margin: 0.15rem 0 0; }
.vr-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    width: fit-content;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    background: var(--vr-surface-soft);
    color: var(--vr-muted);
    font-size: 0.75rem;
    font-weight: 600;
}
.vr-pill svg { width: 0.875rem; height: 0.875rem; }

@media (min-width: 768px) {
    .vr-header { flex-direction: row; align-items: center; justify-content: space-between; }
}

/* Toast */
.vr-toast {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: var(--vr-radius-md);
    background: var(--vr-success-bg);
    color: var(--vr-success-text);
    font-size: 0.875rem;
    box-shadow: var(--vr-shadow-sm);
    animation: vrToastIn 0.35s ease-out both;
}
.vr-toast-check {
    width: 1.5rem;
    height: 1.5rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: var(--vr-success-solid);
    color: #fff;
    animation: vrPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
.vr-toast-check svg { width: 0.875rem; height: 0.875rem; }

/* Cards */
.vr-card {
    background: var(--vr-surface);
    border: 1px solid var(--vr-border);
    border-radius: 1.25rem;
    box-shadow: var(--vr-shadow-sm);
    transition: box-shadow 0.3s ease;
}
.vr-card:hover { box-shadow: var(--vr-shadow-md); }

.vr-form-card {
    position: relative;
    overflow: hidden;
    padding: 1.75rem;
    margin-bottom: 2rem;
    animation: vrFadeInUp 0.45s ease-out both;
}
.vr-form-glow {
    position: absolute;
    top: -60%;
    right: -20%;
    width: 20rem;
    height: 20rem;
    background: radial-gradient(circle, rgba(2, 132, 199, 0.08), transparent 70%);
    pointer-events: none;
}
.vr-form-grid {
    position: relative;
    display: grid;
    gap: 1.75rem;
    grid-template-columns: 1fr;
}
@media (min-width: 768px) {
    .vr-form-grid { grid-template-columns: 1.1fr 0.9fr; }
}
.vr-form-fields { display: flex; flex-direction: column; gap: 1.1rem; }

.vr-field { display: flex; flex-direction: column; }
.vr-label { font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }

.vr-select-wrap { position: relative; }
.vr-select, .vr-input {
    width: 100%;
    appearance: none;
    border: 1px solid var(--vr-border);
    border-radius: 0.6rem;
    background: #fff;
    padding: 0.65rem 0.85rem;
    font-size: 0.875rem;
    color: var(--vr-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.vr-select:focus, .vr-input:focus {
    outline: none;
    border-color: var(--vr-primary);
    box-shadow: 0 0 0 4px var(--vr-primary-light);
}
.vr-select-caret { position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); width: 1rem; height: 1rem; color: var(--vr-muted-light); pointer-events: none; }

.vr-dropzone {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    text-align: center;
    padding: 2rem 1rem;
    border: 2px dashed var(--vr-border);
    border-radius: var(--vr-radius-md);
    background: var(--vr-surface-soft);
    cursor: pointer;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}
.vr-dropzone:hover, .vr-dropzone.vr-drag-active { border-color: var(--vr-primary); background: var(--vr-primary-light); }
.vr-dropzone-icon-wrap {
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #fff;
    box-shadow: var(--vr-shadow-sm);
    margin-bottom: 0.6rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.vr-dropzone:hover .vr-dropzone-icon-wrap { transform: scale(1.1); box-shadow: var(--vr-shadow-md); }
.vr-dropzone-icon { width: 1.5rem; height: 1.5rem; color: var(--vr-muted-light); transition: color 0.3s ease; }
.vr-dropzone:hover .vr-dropzone-icon { color: var(--vr-primary); }
.vr-dropzone-text { font-size: 0.875rem; font-weight: 600; color: var(--vr-muted); transition: color 0.3s ease; }
.vr-dropzone:hover .vr-dropzone-text { color: var(--vr-primary-dark); }
.vr-dropzone-hint { margin-top: 0.25rem; font-size: 0.75rem; color: var(--vr-muted-light); }
.vr-dropzone-sheen {
    position: absolute;
    inset: 0;
    pointer-events: none;
    transform: translateX(-100%);
    background: linear-gradient(90deg, transparent, rgba(2, 132, 199, 0.12), transparent);
    transition: transform 0.7s ease;
}
.vr-dropzone:hover .vr-dropzone-sheen { transform: translateX(100%); }
.vr-hidden-input { display: none; }

.vr-info-panel {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border-radius: var(--vr-radius-md);
    background: linear-gradient(160deg, var(--vr-surface-soft), #f1f5f9);
    padding: 1.4rem;
    font-size: 0.875rem;
    color: var(--vr-muted);
}
.vr-info-title { display: flex; align-items: center; gap: 0.5rem; font-weight: 700; color: #1e293b; margin: 0 0 0.85rem; }
.vr-info-title svg { width: 1rem; height: 1rem; color: var(--vr-primary); }
.vr-info-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.65rem; }
.vr-info-list li { display: flex; align-items: flex-start; gap: 0.5rem; }
.vr-dot { width: 0.4rem; height: 0.4rem; border-radius: 999px; background: var(--vr-accent); margin-top: 0.4rem; flex-shrink: 0; }

.vr-btn-primary {
    margin-top: 1.4rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    border: none;
    border-radius: 0.7rem;
    background: var(--vr-primary);
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 0.7rem 1.1rem;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.vr-btn-primary:hover { background: var(--vr-primary-dark); box-shadow: var(--vr-shadow-md); transform: translateY(-2px); }
.vr-btn-primary:active { transform: scale(0.97); }
.vr-btn-primary:disabled { opacity: 0.8; cursor: not-allowed; }

.vr-spinner { width: 1rem; height: 1rem; animation: vrSpin 0.8s linear infinite; }
.vr-spinner-track { opacity: 0.25; }
.vr-spinner-head { opacity: 0.85; }
.vr-hidden { display: none; }

/* Table */
.vr-table-card { overflow-x: auto; animation: vrFadeInUp 0.45s ease-out 0.12s both; }
.vr-table { width: 100%; border-collapse: collapse; }
.vr-table thead { background: var(--vr-surface-soft); }
.vr-table th {
    text-align: left;
    padding: 0.85rem 1.5rem;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--vr-muted);
    border-bottom: 1px solid var(--vr-border);
}
.vr-th-right { text-align: right; }
.vr-table td { padding: 1rem 1.5rem; font-size: 0.875rem; border-bottom: 1px solid var(--vr-border); }
.vr-row { animation: vrFadeInUp 0.45s ease-out both; transition: background-color 0.15s ease; }
.vr-row:hover { background: var(--vr-surface-soft); }
.vr-row:last-child td { border-bottom: none; }
.vr-td-module { font-weight: 600; color: #334155; }
.vr-td-actions { text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 0.85rem; }
.vr-inline-form { display: inline-flex; }

.vr-badge-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    background: var(--vr-primary-light);
    color: var(--vr-primary-dark);
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.15s ease, color 0.15s ease;
}
.vr-badge-link:hover { background: #bae6fd; color: var(--vr-primary-dark); }
.vr-badge-link svg { width: 0.875rem; height: 0.875rem; }
.vr-badge-empty { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--vr-muted-light); }
.vr-badge-empty svg { width: 0.875rem; height: 0.875rem; }

.vr-link-edit { font-weight: 700; color: var(--vr-primary); text-decoration: none; transition: color 0.15s ease; }
.vr-link-edit:hover { color: var(--vr-primary-dark); }
.vr-link-remove { font-weight: 700; color: var(--vr-danger); background: none; border: none; cursor: pointer; padding: 0; font-size: 0.875rem; transition: color 0.15s ease; }
.vr-link-remove:hover { color: #9f1239; }

.vr-empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--vr-muted-light);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}
.vr-empty-state svg { width: 2.5rem; height: 2.5rem; }
.vr-empty-state span { font-size: 0.875rem; }

/* Animations */
@keyframes vrFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes vrFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes vrToastIn { from { opacity: 0; transform: translateY(-8px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes vrPop { 0% { transform: scale(0); } 70% { transform: scale(1.15); } 100% { transform: scale(1); } }
@keyframes vrSpin { to { transform: rotate(360deg); } }
</style>

<script>
    (function () {
        var input = document.getElementById('video_file');
        var display = document.getElementById('video_file_name');
        var dropZone = document.getElementById('drop_zone');
        var form = document.getElementById('video_form');
        var submitBtn = document.getElementById('video_submit_btn');
        var submitSpinner = document.getElementById('video_submit_spinner');
        var submitLabel = document.getElementById('video_submit_label');

        if (input) {
            input.addEventListener('change', function () {
                display.textContent = (input.files && input.files[0]) ? input.files[0].name : 'Click to choose or drag a file here';
            });
        }

        if (dropZone) {
            ['dragenter', 'dragover'].forEach(function (evt) {
                dropZone.addEventListener(evt, function (e) {
                    e.preventDefault();
                    dropZone.classList.add('vr-drag-active');
                });
            });
            ['dragleave', 'drop'].forEach(function (evt) {
                dropZone.addEventListener(evt, function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('vr-drag-active');
                });
            });
            dropZone.addEventListener('drop', function (e) {
                if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    display.textContent = e.dataTransfer.files[0].name;
                }
            });
        }

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                if (submitSpinner) submitSpinner.classList.remove('vr-hidden');
                if (submitLabel) submitLabel.textContent = 'Saving…';
            });
        }
    })();
</script>
@endsection