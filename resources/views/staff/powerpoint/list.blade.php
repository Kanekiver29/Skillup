@extends('staff.layouts.masters')

@section('title', 'PowerPoint Resources')

@section('content')
<div class="pr-page">
    <header class="pr-header">
        <div class="pr-header-left">
            <span class="pr-icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </span>
            <div>
                <h1 class="pr-title">PowerPoint Resources</h1>
                <p class="pr-subtitle">Attach and manage PowerPoint files for modules.</p>
            </div>
        </div>
        <span class="pr-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            {{ $modules->count() }} {{ Str::plural('module', $modules->count()) }}
        </span>
    </header>

    @if(session('success'))
        <div class="pr-toast">
            <span class="pr-toast-check">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="pr-card pr-form-card">
        <div class="pr-form-glow"></div>
        <form action="{{ route('staff.powerpoints.store') }}" method="POST" enctype="multipart/form-data" id="ppt_form" class="pr-form-grid">
            @csrf
            <div class="pr-form-fields">
                <div class="pr-field">
                    <label class="pr-label" for="module_id">Module</label>
                    <div class="pr-select-wrap">
                        <select name="module_id" id="module_id" class="pr-select" required>
                            <option value="">Select a module</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</option>
                            @endforeach
                        </select>
                        <svg class="pr-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="pr-field">
                    <label class="pr-label" for="ppt_file">Upload PowerPoint File</label>

                    <label for="ppt_file" id="drop_zone" class="pr-dropzone">
                        <span id="drop_icon_wrap" class="pr-dropzone-icon-wrap">
                            <svg id="drop_icon" class="pr-dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </span>
                        <span class="pr-dropzone-text"><span id="file_name_display">Click to choose or drag a file here</span></span>
                        <span class="pr-dropzone-hint">PPT, PPTX or PDF up to your server limit</span>
                        <input type="file" name="ppt_file" id="ppt_file" accept=".ppt,.pptx,.pdf" class="pr-hidden-input">
                        <span class="pr-dropzone-sheen"></span>
                    </label>
                </div>
            </div>

            <div class="pr-info-panel">
                <div>
                    <h2 class="pr-info-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        How it works
                    </h2>
                    <ul class="pr-info-list">
                        <li><span class="pr-dot"></span>Choose a module and upload a PowerPoint or PDF file.</li>
                        <li><span class="pr-dot"></span>The file is stored with the module and can be opened directly.</li>
                        <li><span class="pr-dot"></span>You can delete it later if content changes.</li>
                    </ul>
                </div>
                <button type="submit" id="submit_btn" class="pr-btn-primary">
                    <svg id="submit_spinner" class="pr-spinner pr-hidden" viewBox="0 0 24 24" fill="none">
                        <circle class="pr-spinner-track" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="pr-spinner-head" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span id="submit_label">Save PowerPoint</span>
                </button>
            </div>
        </form>
    </div>

    <div class="pr-card pr-table-card">
        <table class="pr-table">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Current File</th>
                    <th class="pr-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                    <tr class="pr-row" style="animation-delay: {{ 150 + ($loop->index * 40) }}ms;">
                        <td class="pr-td-module">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</td>
                        <td>
                            @if($module->ppt_url)
                                <a href="{{ $module->ppt_url }}" target="_blank" rel="noopener" class="pr-badge-link">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    Open presentation
                                </a>
                            @else
                                <span class="pr-badge-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    No PowerPoint attached
                                </span>
                            @endif
                        </td>
                        <td class="pr-td-actions">
                            <a href="{{ route('staff.powerpoints.edit', $module) }}" class="pr-link-edit">Edit</a>
                            <form action="{{ route('staff.powerpoints.destroy', $module) }}" method="POST" onsubmit="return confirm('Remove this PowerPoint resource?');" class="pr-inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pr-link-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="pr-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 13h6m-3-3v6m5 4H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
    --pr-primary: #0284c7;
    --pr-primary-dark: #0369a1;
    --pr-primary-light: #e0f2fe;
    --pr-accent: #4f46e5;
    --pr-ink: #1e293b;
    --pr-muted: #64748b;
    --pr-muted-light: #94a3b8;
    --pr-border: #e2e8f0;
    --pr-surface: #ffffff;
    --pr-surface-soft: #f8fafc;
    --pr-danger: #e11d48;
    --pr-success-bg: #d1fae5;
    --pr-success-text: #065f46;
    --pr-success-solid: #10b981;
    --pr-radius-md: 0.75rem;
    --pr-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --pr-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.pr-page { max-width: 72rem; margin: 0 auto; padding: 1.5rem; color: var(--pr-ink); font-family: inherit; }

/* Header */
.pr-header { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; animation: prFadeInDown 0.4s ease-out both; }
.pr-header-left { display: flex; align-items: center; gap: 0.75rem; }
.pr-icon-badge {
    width: 2.75rem; height: 2.75rem; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    border-radius: 0.9rem; color: #fff;
    background: linear-gradient(135deg, var(--pr-primary), var(--pr-accent));
    box-shadow: var(--pr-shadow-md);
}
.pr-icon-badge svg { width: 1.5rem; height: 1.5rem; display: block; }
.pr-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--pr-ink); }
.pr-subtitle { font-size: 0.875rem; color: var(--pr-muted-light); margin: 0.15rem 0 0; }
.pr-pill {
    display: inline-flex; align-items: center; gap: 0.4rem; width: fit-content;
    padding: 0.35rem 0.85rem; border-radius: 999px; background: var(--pr-surface-soft);
    color: var(--pr-muted); font-size: 0.75rem; font-weight: 600;
}
.pr-pill svg { width: 0.875rem; height: 0.875rem; }
@media (min-width: 768px) { .pr-header { flex-direction: row; align-items: center; justify-content: space-between; } }

/* Toast */
.pr-toast {
    display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem; padding: 1rem;
    border-radius: var(--pr-radius-md); background: var(--pr-success-bg); color: var(--pr-success-text);
    font-size: 0.875rem; box-shadow: var(--pr-shadow-sm); animation: prToastIn 0.35s ease-out both;
}
.pr-toast-check {
    width: 1.5rem; height: 1.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; background: var(--pr-success-solid); color: #fff;
    animation: prPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
.pr-toast-check svg { width: 0.875rem; height: 0.875rem; }

/* Cards */
.pr-card { background: var(--pr-surface); border: 1px solid var(--pr-border); border-radius: 1.25rem; box-shadow: var(--pr-shadow-sm); transition: box-shadow 0.3s ease; }
.pr-card:hover { box-shadow: var(--pr-shadow-md); }
.pr-form-card { position: relative; overflow: hidden; padding: 1.75rem; margin-bottom: 2rem; animation: prFadeInUp 0.45s ease-out both; }
.pr-form-glow {
    position: absolute; top: -60%; right: -20%; width: 20rem; height: 20rem;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.08), transparent 70%); pointer-events: none;
}
.pr-form-grid { position: relative; display: grid; gap: 1.75rem; grid-template-columns: 1fr; }
@media (min-width: 768px) { .pr-form-grid { grid-template-columns: 1.1fr 0.9fr; } }
.pr-form-fields { display: flex; flex-direction: column; gap: 1.1rem; }

.pr-field { display: flex; flex-direction: column; }
.pr-label { font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }

.pr-select-wrap { position: relative; }
.pr-select {
    width: 100%; appearance: none; border: 1px solid var(--pr-border); border-radius: 0.6rem;
    background: #fff; padding: 0.65rem 0.85rem; font-size: 0.875rem; color: var(--pr-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.pr-select:focus { outline: none; border-color: var(--pr-primary); box-shadow: 0 0 0 4px var(--pr-primary-light); }
.pr-select-caret { position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); width: 1rem; height: 1rem; color: var(--pr-muted-light); pointer-events: none; }

.pr-dropzone {
    position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center;
    overflow: hidden; text-align: center; padding: 1.75rem 1rem;
    border: 2px dashed var(--pr-border); border-radius: var(--pr-radius-md); background: var(--pr-surface-soft);
    cursor: pointer; transition: border-color 0.3s ease, background-color 0.3s ease;
}
.pr-dropzone:hover, .pr-dropzone.pr-drag-active { border-color: var(--pr-primary); background: var(--pr-primary-light); }
.pr-dropzone-icon-wrap {
    width: 2.75rem; height: 2.75rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; background: #fff; box-shadow: var(--pr-shadow-sm); margin-bottom: 0.6rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}
.pr-dropzone:hover .pr-dropzone-icon-wrap { transform: scale(1.08); box-shadow: var(--pr-shadow-md); }
.pr-dropzone-icon-wrap.pr-file-chosen { background: var(--pr-primary-light); }
.pr-dropzone-icon { width: 1.4rem; height: 1.4rem; color: var(--pr-muted-light); transition: color 0.3s ease; }
.pr-dropzone:hover .pr-dropzone-icon { color: var(--pr-primary); }
.pr-dropzone-icon.pr-file-chosen { color: var(--pr-primary); }
.pr-dropzone-text { font-size: 0.875rem; font-weight: 600; color: var(--pr-muted); transition: color 0.3s ease; }
.pr-dropzone:hover .pr-dropzone-text { color: var(--pr-primary-dark); }
.pr-dropzone-hint { margin-top: 0.25rem; font-size: 0.75rem; color: var(--pr-muted-light); }
.pr-dropzone-sheen {
    position: absolute; inset: 0; pointer-events: none; transform: translateX(-100%);
    background: linear-gradient(90deg, transparent, rgba(2, 132, 199, 0.12), transparent);
    transition: transform 0.7s ease;
}
.pr-dropzone:hover .pr-dropzone-sheen { transform: translateX(100%); }
.pr-hidden-input { display: none; }

.pr-info-panel {
    display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--pr-radius-md);
    background: linear-gradient(160deg, var(--pr-surface-soft), #f1f5f9); padding: 1.4rem; font-size: 0.875rem; color: var(--pr-muted);
}
.pr-info-title { display: flex; align-items: center; gap: 0.5rem; font-weight: 700; color: #1e293b; margin: 0 0 0.85rem; }
.pr-info-title svg { width: 1rem; height: 1rem; color: var(--pr-primary); }
.pr-info-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.65rem; }
.pr-info-list li { display: flex; align-items: flex-start; gap: 0.5rem; }
.pr-dot { width: 0.4rem; height: 0.4rem; border-radius: 999px; background: var(--pr-accent); margin-top: 0.4rem; flex-shrink: 0; }

.pr-btn-primary {
    margin-top: 1.4rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
    border: none; border-radius: 0.7rem; background: var(--pr-primary); color: #fff; font-weight: 700;
    font-size: 0.9rem; padding: 0.7rem 1.1rem; cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.pr-btn-primary:hover { background: var(--pr-primary-dark); box-shadow: var(--pr-shadow-md); transform: translateY(-2px); }
.pr-btn-primary:active { transform: scale(0.97); }
.pr-btn-primary:disabled { opacity: 0.8; cursor: not-allowed; }

.pr-spinner { width: 1rem; height: 1rem; animation: prSpin 0.8s linear infinite; }
.pr-spinner-track { opacity: 0.25; }
.pr-spinner-head { opacity: 0.85; }
.pr-hidden { display: none; }

/* Table */
.pr-table-card { overflow-x: auto; animation: prFadeInUp 0.45s ease-out 0.12s both; }
.pr-table { width: 100%; border-collapse: collapse; }
.pr-table thead { background: var(--pr-surface-soft); }
.pr-table th {
    text-align: left; padding: 0.85rem 1.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: var(--pr-muted); border-bottom: 1px solid var(--pr-border);
}
.pr-th-right { text-align: right; }
.pr-table td { padding: 1rem 1.5rem; font-size: 0.875rem; border-bottom: 1px solid var(--pr-border); }
.pr-row { animation: prFadeInUp 0.45s ease-out both; transition: background-color 0.15s ease; }
.pr-row:hover { background: var(--pr-surface-soft); }
.pr-row:last-child td { border-bottom: none; }
.pr-td-module { font-weight: 600; color: #334155; }
.pr-td-actions { text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 0.85rem; }
.pr-inline-form { display: inline-flex; }

.pr-badge-link {
    display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.75rem; border-radius: 999px;
    background: var(--pr-primary-light); color: var(--pr-primary-dark); text-decoration: none; font-weight: 500;
    transition: background-color 0.15s ease, color 0.15s ease;
}
.pr-badge-link:hover { background: #bae6fd; }
.pr-badge-link svg { width: 0.875rem; height: 0.875rem; }
.pr-badge-empty { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--pr-muted-light); }
.pr-badge-empty svg { width: 0.875rem; height: 0.875rem; }

.pr-link-edit { font-weight: 700; color: var(--pr-primary); text-decoration: none; transition: color 0.15s ease; }
.pr-link-edit:hover { color: var(--pr-primary-dark); }
.pr-link-remove { font-weight: 700; color: var(--pr-danger); background: none; border: none; cursor: pointer; padding: 0; font-size: 0.875rem; transition: color 0.15s ease; }
.pr-link-remove:hover { color: #9f1239; }

.pr-empty-state { text-align: center; padding: 3rem 1.5rem; color: var(--pr-muted-light); display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
.pr-empty-state svg { width: 2rem; height: 2rem; }
.pr-empty-state span { font-size: 0.875rem; }

/* Animations */
@keyframes prFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes prFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes prToastIn { from { opacity: 0; transform: translateY(-8px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes prPop { 0% { transform: scale(0); } 70% { transform: scale(1.15); } 100% { transform: scale(1); } }
@keyframes prSpin { to { transform: rotate(360deg); } }
</style>

<script>
    (function () {
        var input = document.getElementById('ppt_file');
        var dropZone = document.getElementById('drop_zone');
        var display = document.getElementById('file_name_display');
        var iconWrap = document.getElementById('drop_icon_wrap');
        var icon = document.getElementById('drop_icon');
        var form = document.getElementById('ppt_form');
        var submitBtn = document.getElementById('submit_btn');
        var submitSpinner = document.getElementById('submit_spinner');
        var submitLabel = document.getElementById('submit_label');

        if (!input || !dropZone || !display) return;

        var chosenIconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
        var defaultIconPath = 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12';

        function showFileName(file) {
            if (file) {
                display.textContent = file.name;
                iconWrap.classList.add('pr-file-chosen');
                icon.classList.add('pr-file-chosen');
                icon.setAttribute('d', chosenIconPath);
            } else {
                display.textContent = 'Click to choose or drag a file here';
                iconWrap.classList.remove('pr-file-chosen');
                icon.classList.remove('pr-file-chosen');
                icon.setAttribute('d', defaultIconPath);
            }
        }

        input.addEventListener('change', function () {
            showFileName(input.files && input.files[0]);
        });

        ['dragenter', 'dragover'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                dropZone.classList.add('pr-drag-active');
            });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                dropZone.classList.remove('pr-drag-active');
            });
        });
        dropZone.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                showFileName(e.dataTransfer.files[0]);
            }
        });

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                if (submitSpinner) submitSpinner.classList.remove('pr-hidden');
                if (submitLabel) submitLabel.textContent = 'Saving…';
            });
        }
    })();
</script>
@endsection