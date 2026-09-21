@extends('staff.layouts.masters')

@section('title', 'Edit Syllabus')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════
   SYLLABI EDIT — Ultra-polished console UI
   ═══════════════════════════════════════════════════════ */
.syl-wrap {
    --bg:      var(--body-bg);
    --surface: var(--surface);
    --border:  var(--border);
    --accent:  #6366F1;
    --cyan:    #22D3EE;
    --text:    var(--text);
    --dim:     var(--muted);
    color: var(--text);
}

html[data-staff-theme="dark"] .syl-wrap {
    --bg:      #080D18;
    --surface: #0D1424;
    --border:  rgba(99,102,241,0.18);
    --text:    #E2E8F0;
    --dim:     #7C8AA5;
}
.syl-orb { position:fixed; pointer-events:none; border-radius:50%; filter:blur(90px); animation:orb-f 20s ease-in-out infinite alternate; }
.syl-orb-a { width:400px; height:400px; top:-100px; right:-60px; background:radial-gradient(circle,rgba(99,102,241,0.16) 0%,transparent 70%); }
.syl-orb-b { width:280px; height:280px; bottom:-40px; left:-40px; background:radial-gradient(circle,rgba(34,211,238,0.10) 0%,transparent 70%); animation-delay:-9s; }
@keyframes orb-f { from{transform:translate(0,0) scale(1);} to{transform:translate(28px,18px) scale(1.07);} }

.syl-heading {
    font-size:1.55rem; font-weight:800; letter-spacing:-0.02em;
    background:linear-gradient(100deg,#fff 10%,var(--cyan) 50%,var(--accent) 90%);
    -webkit-background-clip:text; background-clip:text; color:transparent;
    animation:hue-s 8s ease-in-out infinite;
}
@keyframes hue-s { 0%,100%{filter:hue-rotate(0deg) brightness(1);} 50%{filter:hue-rotate(12deg) brightness(1.15);} }
.syl-sub { font-size:0.78rem; color:var(--dim); margin-top:2px; }

.syl-back {
    display:inline-flex; align-items:center; gap:6px;
    font-size:0.78rem; font-weight:600; color:var(--dim);
    background:rgba(99,102,241,0.07); border:1px solid rgba(99,102,241,0.2);
    padding:0.42rem 0.9rem; border-radius:8px;
    transition:color .15s, background .15s, border-color .15s, transform .15s;
    text-decoration:none;
}
.syl-back:hover { color:var(--text); background:rgba(99,102,241,0.14); border-color:rgba(99,102,241,0.45); transform:translateY(-1px); }

.syl-panel {
    position:relative;
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:20px; overflow:hidden;
    box-shadow: 0 0 0 1px rgba(99,102,241,0.05),
                0 1px 0 0 rgba(255,255,255,0.04) inset,
                0 36px 90px -24px rgba(2,6,23,0.85);
}
.syl-dotgrid {
    position:absolute; inset:0; pointer-events:none; z-index:0;
    background-image:radial-gradient(circle, rgba(99,102,241,0.11) 1px, transparent 1px);
    background-size:28px 28px;
    mask-image:radial-gradient(ellipse 90% 55% at 50% 0%, black 15%, transparent 78%);
    animation:dot-d 20s linear infinite;
}
@keyframes dot-d { from{background-position:0 0;} to{background-position:28px 28px;} }
.syl-topglow {
    position:absolute; top:0; left:0; right:0; height:1px; z-index:1;
    background:linear-gradient(90deg, transparent 5%, var(--accent) 40%, var(--cyan) 60%, transparent 95%);
    opacity:0.55;
}
.syl-scanline {
    position:absolute; top:0; left:-35%; width:35%; height:2px; z-index:2;
    background:linear-gradient(90deg, transparent, var(--cyan), transparent);
    animation:scan 3.8s ease-in-out infinite;
    filter:drop-shadow(0 0 8px var(--cyan));
}
@keyframes scan { 0%{left:-35%;} 100%{left:110%;} }
.syl-panel-content { position:relative; z-index:3; padding:1.75rem; }

.syl-toolbar {
    display:flex; align-items:center; justify-content:space-between;
    padding:0.7rem 1.25rem; border-bottom:1px solid var(--border);
}
.syl-macdot { width:7px; height:7px; border-radius:50%; display:inline-block; }
.syl-dot-r{background:#FF5F57;} .syl-dot-y{background:#FEBC2E;} .syl-dot-g{background:#28C840;}
.syl-toolbar-title { font-size:0.7rem; font-family:monospace; color:var(--dim); letter-spacing:0.08em; margin-left:8px; }

.syl-sec-badge {
    display:inline-flex; align-items:center; gap:5px;
    font-size:0.67rem; font-weight:700; letter-spacing:0.09em; text-transform:uppercase;
    padding:0.18rem 0.65rem; border-radius:999px;
    background:rgba(99,102,241,0.1); color:#A5B4FC;
    border:1px solid rgba(99,102,241,0.22);
}
.syl-divider { height:1px; margin:1.75rem 0; background:linear-gradient(90deg, transparent, rgba(99,102,241,0.22) 30%, rgba(34,211,238,0.18) 70%, transparent); }

.syl-label { display:block; font-size:0.68rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--dim); margin-bottom:0.32rem; }
.syl-input, .syl-select, .syl-textarea {
    width:100%; background:rgba(8,13,24,0.6); border:1px solid var(--border);
    border-radius:10px; padding:0.55rem 0.85rem; color:var(--text); font-size:0.875rem; outline:none;
    transition:border-color .18s, box-shadow .18s, background .18s;
}
.syl-input:focus, .syl-select:focus, .syl-textarea:focus {
    border-color:rgba(34,211,238,0.5);
    box-shadow:0 0 0 3px rgba(34,211,238,0.09), 0 0 14px rgba(34,211,238,0.1);
    background:rgba(8,13,24,0.9);
}
.syl-input::placeholder, .syl-textarea::placeholder { color:rgba(124,138,165,0.6); }
.syl-select option { background:#0D1424; color:var(--text); }

.syl-field { opacity:0; transform:translateY(10px); animation:fi .35s cubic-bezier(.22,.61,.36,1) forwards; animation-delay:calc(var(--fi,0)*55ms); }
@keyframes fi { to{opacity:1;transform:translateY(0);} }

.syl-toggle { display:flex; align-items:center; gap:8px; cursor:pointer; user-select:none; }
.syl-toggle input[type="checkbox"] { accent-color:var(--cyan); width:15px; height:15px; cursor:pointer; }
.syl-toggle-lbl { font-size:0.85rem; }

.syl-err {
    background:rgba(239,68,68,0.07); border:1px solid rgba(239,68,68,0.3);
    box-shadow:0 0 18px rgba(239,68,68,0.05);
    border-radius:10px; padding:0.85rem 1rem; color:#FCA5A5;
    animation:err-in .28s cubic-bezier(.22,.61,.36,1); margin-bottom:1.25rem;
}
@keyframes err-in { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }

.section-card {
    background:rgba(8,13,24,0.55); border:1px solid var(--border);
    border-radius:13px; padding:1rem 1.1rem;
    position:relative; overflow:hidden;
    transition:border-color .2s, box-shadow .2s;
    animation:sc-in .32s cubic-bezier(.22,.61,.36,1) both;
}
@keyframes sc-in { from{opacity:0;transform:scale(.97) translateY(7px);} to{opacity:1;transform:none;} }
.section-card::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:2px;
    background:linear-gradient(to bottom, var(--accent), var(--cyan));
    opacity:0; transition:opacity .2s;
}
.section-card:hover { border-color:rgba(34,211,238,0.28); box-shadow:0 0 20px rgba(34,211,238,0.05); }
.section-card:hover::before { opacity:1; }
.sec-num {
    display:inline-flex; align-items:center; justify-content:center;
    width:20px; height:20px; border-radius:6px;
    background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.25);
    font-size:0.65rem; font-weight:800; color:#A5B4FC;
}
.sec-count-badge { font-size:0.68rem; font-family:monospace; color:var(--dim); padding:0.15rem 0.5rem; border-radius:999px; background:rgba(99,102,241,0.07); border:1px solid rgba(99,102,241,0.12); }

.syl-btn-primary {
    position:relative; overflow:hidden;
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    background:linear-gradient(135deg, var(--accent), var(--cyan));
    color:#fff; font-weight:700; font-size:0.9rem;
    border-radius:11px; border:none; cursor:pointer;
    padding:0.75rem 1.5rem; width:100%;
    transition:transform .18s, box-shadow .22s, filter .22s;
    box-shadow:0 0 0 1px rgba(99,102,241,0.3) inset;
}
.syl-btn-primary::after {
    content:''; position:absolute; top:-50%; left:-60%; width:38%; height:200%;
    background:rgba(255,255,255,0.15); transform:skewX(-20deg);
    animation:sheen 3.8s ease-in-out infinite;
}
@keyframes sheen { 0%{left:-60%;} 55%,100%{left:130%;} }
.syl-btn-primary:hover { transform:translateY(-2px); filter:brightness(1.12); box-shadow:0 0 28px rgba(34,211,238,0.5), 0 6px 20px rgba(99,102,241,0.35); }
.syl-btn-primary:active { transform:translateY(0); }

.syl-btn-add { display:inline-flex; align-items:center; gap:5px; background:rgba(99,102,241,0.08); color:#A5B4FC; border:1px solid rgba(99,102,241,0.22); padding:0.42rem 0.95rem; border-radius:8px; font-size:0.78rem; font-weight:600; cursor:pointer; transition:background .18s, border-color .18s, transform .15s; }
.syl-btn-add:hover { background:rgba(99,102,241,0.16); border-color:rgba(99,102,241,0.45); transform:translateY(-1px); }
.syl-btn-rm { display:inline-flex; align-items:center; gap:4px; background:rgba(239,68,68,0.07); color:#FCA5A5; border:1px solid rgba(239,68,68,0.18); padding:0.25rem 0.65rem; border-radius:7px; font-size:0.72rem; font-weight:600; cursor:pointer; transition:background .18s, border-color .18s; }
.syl-btn-rm:hover { background:rgba(239,68,68,0.15); border-color:rgba(239,68,68,0.4); }

.media-zone {
    background:rgba(8,13,24,0.45); border:1.5px dashed rgba(99,102,241,0.28);
    border-radius:12px; padding:1.25rem 1rem; text-align:center; position:relative; cursor:pointer;
    transition:border-color .2s, background .2s, box-shadow .2s;
}
.media-zone:hover, .media-zone.dragover { border-color:var(--cyan); background:rgba(34,211,238,0.04); box-shadow:0 0 20px rgba(34,211,238,0.08); }
.media-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.media-zone-icon { color:var(--cyan); opacity:0.6; margin-bottom:6px; display:flex; justify-content:center; }
.media-counter { display:inline-flex; align-items:center; gap:5px; font-size:0.68rem; font-weight:700; letter-spacing:0.06em; padding:0.18rem 0.6rem; border-radius:999px; background:rgba(34,211,238,0.09); color:var(--cyan); border:1px solid rgba(34,211,238,0.18); }
.media-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(68px,1fr)); gap:6px; margin-top:10px; }

/* existing media tiles */
.media-tile { position:relative; border-radius:8px; overflow:hidden; border:1px solid rgba(34,211,238,0.2); animation:th-in .22s cubic-bezier(.22,.61,.36,1) both; }
/* new preview tiles */
.media-thumb { position:relative; border-radius:8px; overflow:hidden; border:1px solid var(--border); animation:th-in .22s cubic-bezier(.22,.61,.36,1) both; }
@keyframes th-in { from{opacity:0;transform:scale(.85);} to{opacity:1;transform:scale(1);} }
.media-tile img, .media-thumb img { width:100%; height:68px; object-fit:cover; display:block; }
.media-thumb-video, .media-tile-video {
    width:100%; height:68px; display:flex; align-items:center; justify-content:center;
    flex-direction:column; gap:3px; color:var(--cyan);
    font-size:0.6rem; font-weight:700; letter-spacing:0.04em;
}
.media-tile-video { background:rgba(34,211,238,0.07); }
.media-thumb-video { background:rgba(99,102,241,0.1); }
.media-rm {
    position:absolute; top:2px; right:2px; width:17px; height:17px;
    background:rgba(0,0,0,0.78); border-radius:50%; border:none;
    color:#fff; font-size:9px; cursor:pointer;
    display:flex; align-items:center; justify-content:center; transition:background .15s;
}
.media-rm:hover { background:rgba(239,68,68,0.9); }

/* existing tile label */
.tile-label {
    position:absolute; bottom:0; left:0; right:0;
    font-size:0.55rem; font-weight:700; letter-spacing:0.04em;
    text-align:center; padding:2px 0;
    background:rgba(34,211,238,0.18); color:var(--cyan);
    backdrop-filter:blur(4px);
}

@media (prefers-reduced-motion:reduce) {
    .syl-orb,.syl-scanline,.syl-heading,.syl-field,.section-card,.media-thumb,.media-tile,.syl-btn-primary::after {
        animation:none !important; opacity:1 !important; transform:none !important;
    }
}
@media (max-width:640px) { .responsive-grid { grid-template-columns:1fr !important; } }
</style>

<div class="syl-wrap" style="position:relative; min-height:100vh; padding:1.5rem 1.5rem 3rem;">
    <div class="syl-orb syl-orb-a"></div>
    <div class="syl-orb syl-orb-b"></div>

    <div style="max-width:760px; margin:0 auto; position:relative; z-index:2;">

        <!-- Header -->
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.5rem; gap:1rem;">
            <div>
                <h1 class="syl-heading">Edit Syllabus</h1>
                <p class="syl-sub">Editing: <strong style="color:#CBD5E1;">{{ $syllabus->title }}</strong></p>
            </div>
            <a href="{{ route('staff.syllabi.index') }}" class="syl-back" style="flex-shrink:0;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        @if($errors->any())
            <div class="syl-err">
                <ul class="list-disc list-inside text-sm" style="line-height:1.8;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <!-- Panel -->
        <div class="syl-panel">
            <div class="syl-dotgrid"></div>
            <div class="syl-topglow"></div>
            <div class="syl-scanline"></div>

            <!-- Toolbar -->
            <div class="syl-toolbar">
                <div style="display:flex; align-items:center;">
                    <span class="syl-macdot syl-dot-r" style="margin-right:5px;"></span>
                    <span class="syl-macdot syl-dot-y" style="margin-right:5px;"></span>
                    <span class="syl-macdot syl-dot-g"></span>
                    <span class="syl-toolbar-title">syllabi.edit — #{{ $syllabus->id }}</span>
                </div>
                @if($syllabus->is_published)
                    <span style="font-size:0.68rem; color:rgba(52,211,153,0.8); font-family:monospace; letter-spacing:0.06em;">● PUBLISHED</span>
                @else
                    <span style="font-size:0.68rem; color:rgba(124,138,165,0.7); font-family:monospace; letter-spacing:0.06em;">○ DRAFT</span>
                @endif
            </div>

            <div class="syl-panel-content">
                <form action="{{ route('staff.syllabi.update', $syllabus) }}" method="POST"
                      enctype="multipart/form-data" id="syllabus-form" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- ── Basic Info ── -->
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:1.2rem;">
                        <span class="syl-sec-badge">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Basic Info
                        </span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="responsive-grid">
                        <div class="syl-field" style="--fi:0;">
                            <label class="syl-label" for="course_id">Course</label>
                            <select name="course_id" id="course_id" class="syl-select" required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ (old('course_id') ?? $syllabus->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="syl-field" style="--fi:1;">
                            <label class="syl-label" for="title">Syllabus Title</label>
                            <input type="text" name="title" id="title"
                                   value="{{ old('title') ?? $syllabus->title }}"
                                   class="syl-input" required/>
                        </div>
                    </div>

                    <div class="syl-field" style="--fi:2; margin-top:1rem;">
                        <label class="syl-label" for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="syl-textarea">{{ old('description') ?? $syllabus->description }}</textarea>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-top:1rem;" class="responsive-grid">
                        <div class="syl-field" style="--fi:3;">
                            <label class="syl-label" for="effective_start">Effective Start</label>
                            <input type="date" name="effective_start" id="effective_start"
                                   value="{{ old('effective_start') ?? ($syllabus->effective_start ? $syllabus->effective_start->format('Y-m-d') : '') }}"
                                   class="syl-input"/>
                        </div>
                        <div class="syl-field" style="--fi:4;">
                            <label class="syl-label" for="effective_end">Effective End</label>
                            <input type="date" name="effective_end" id="effective_end"
                                   value="{{ old('effective_end') ?? ($syllabus->effective_end ? $syllabus->effective_end->format('Y-m-d') : '') }}"
                                   class="syl-input"/>
                        </div>
                    </div>

                    <div class="syl-field" style="--fi:5; margin-top:1.1rem;">
                        <label class="syl-toggle">
                            <input type="checkbox" name="is_published" value="1" id="is_published"
                                   {{ (old('is_published') ?? $syllabus->is_published) ? 'checked' : '' }}/>
                            <span class="syl-toggle-lbl">Published</span>
                            <span style="font-size:0.72rem; color:var(--dim);">(visible to students)</span>
                        </label>
                    </div>

                    <div class="syl-divider"></div>

                    <!-- ── Sections ── -->
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                        <span class="syl-sec-badge">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Sections
                        </span>
                        <span class="sec-count-badge" id="sec-count"></span>
                    </div>

                    <div id="sections-wrapper" style="display:flex; flex-direction:column; gap:0.65rem;">
                        @if(old('sections'))
                            @foreach(old('sections') as $i => $section)
                                <div class="section-card" data-index="{{ $i }}">
                                    <input type="hidden" name="sections[{{ $i }}][id]" value="{{ $section['id'] ?? '' }}"/>
                                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.65rem;">
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <span class="sec-num">{{ $i + 1 }}</span>
                                            <span style="font-size:0.7rem; color:var(--dim); font-family:monospace; letter-spacing:0.06em; text-transform:uppercase;">Section</span>
                                        </div>
                                        <button type="button" class="remove-section syl-btn-rm">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg> Remove
                                        </button>
                                    </div>
                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="responsive-grid">
                                        <div>
                                            <label class="syl-label">Section Title</label>
                                            <input type="text" name="sections[{{ $i }}][section_title]"
                                                   value="{{ $section['section_title'] ?? '' }}" class="syl-input" required/>
                                        </div>
                                        <div>
                                            <label class="syl-label">Content</label>
                                            <textarea name="sections[{{ $i }}][content]" rows="2"
                                                      class="syl-textarea">{{ $section['content'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($syllabus->sections()->orderBy('order')->get() as $i => $section)
                                <div class="section-card" data-index="{{ $i }}">
                                    <input type="hidden" name="sections[{{ $i }}][id]" value="{{ $section->id }}"/>
                                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.65rem;">
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <span class="sec-num">{{ $i + 1 }}</span>
                                            <span style="font-size:0.7rem; color:var(--dim); font-family:monospace; letter-spacing:0.06em; text-transform:uppercase;">Section</span>
                                        </div>
                                        <button type="button" class="remove-section syl-btn-rm">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg> Remove
                                        </button>
                                    </div>
                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;" class="responsive-grid">
                                        <div>
                                            <label class="syl-label">Section Title</label>
                                            <input type="text" name="sections[{{ $i }}][section_title]"
                                                   value="{{ $section->section_title }}" class="syl-input" required/>
                                        </div>
                                        <div>
                                            <label class="syl-label">Content</label>
                                            <textarea name="sections[{{ $i }}][content]" rows="2"
                                                      class="syl-textarea">{{ $section->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <button type="button" id="add-section" class="syl-btn-add" style="margin-top:0.75rem;">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Section
                    </button>

                    <div class="syl-divider"></div>

                    <!-- ── Media ── -->
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:1.1rem;">
                        <span class="syl-sec-badge">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Media Attachments
                        </span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="responsive-grid">

                        <!-- Photos -->
                        <div class="syl-field" style="--fi:6;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                                <label class="syl-label" style="margin-bottom:0;">Photos</label>
                                <span class="media-counter" id="photo-counter">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ count($syllabus->photos ?? []) }} / 25
                                </span>
                            </div>

                            @if(!empty($syllabus->photos))
                                <input type="hidden" name="existing_photos" id="existing-photos-field"
                                       value="{{ json_encode($syllabus->photos) }}"/>
                                <div class="media-grid" id="existing-photo-grid">
                                    @foreach($syllabus->photos as $pi => $pPath)
                                        <div class="media-tile" id="ep-{{ $pi }}">
                                            <img src="{{ Storage::url($pPath) }}" alt="Photo {{ $pi + 1 }}">
                                            <div class="tile-label">existing</div>
                                            <button type="button" class="media-rm existing-photo-rm"
                                                    data-index="{{ $pi }}" title="Remove">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <input type="hidden" name="existing_photos" id="existing-photos-field" value="[]"/>
                            @endif

                            <div class="media-zone" id="photo-drop" style="margin-top:8px;">
                                <input type="file" name="photos[]" id="photos-input" accept="image/*" multiple/>
                                <div class="media-zone-icon">
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p style="font-size:0.72rem; color:var(--dim);">Add more photos</p>
                                <p style="font-size:0.65rem; color:#374151; margin-top:2px;">Max 25 total · 5 MB each</p>
                            </div>
                            <div class="media-grid" id="photo-previews"></div>
                        </div>

                        <!-- Videos -->
                        <div class="syl-field" style="--fi:7;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                                <label class="syl-label" style="margin-bottom:0;">Videos</label>
                                <span class="media-counter" id="video-counter">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    {{ count($syllabus->videos ?? []) }} / 3
                                </span>
                            </div>

                            @if(!empty($syllabus->videos))
                                <input type="hidden" name="existing_videos" id="existing-videos-field"
                                       value="{{ json_encode($syllabus->videos) }}"/>
                                <div class="media-grid" id="existing-video-grid">
                                    @foreach($syllabus->videos as $vi => $vPath)
                                        <div class="media-tile" id="ev-{{ $vi }}">
                                            <div class="media-tile-video">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                <span>Video {{ $vi + 1 }}</span>
                                            </div>
                                            <div class="tile-label">existing</div>
                                            <button type="button" class="media-rm existing-video-rm"
                                                    data-index="{{ $vi }}" title="Remove">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <input type="hidden" name="existing_videos" id="existing-videos-field" value="[]"/>
                            @endif

                            <div class="media-zone" id="video-drop" style="margin-top:8px;">
                                <input type="file" name="videos[]" id="videos-input"
                                       accept="video/mp4,video/webm,video/ogg" multiple/>
                                <div class="media-zone-icon">
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p style="font-size:0.72rem; color:var(--dim);">Add more videos</p>
                                <p style="font-size:0.65rem; color:#374151; margin-top:2px;">Max 3 total · 20 MB · MP4/WebM/OGG</p>
                            </div>
                            <div class="media-grid" id="video-previews"></div>
                        </div>
                    </div>

                    <div class="syl-divider"></div>

                    <!-- Submit -->
                    <div class="syl-field" style="--fi:8;">
                        <button type="submit" class="syl-btn-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Syllabus
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Sections ─── */
    var wrapper  = document.getElementById('sections-wrapper');
    var addBtn   = document.getElementById('add-section');
    var countLbl = document.getElementById('sec-count');
    var MAX_SEC  = 10;
    var secIdx   = wrapper.children.length ? parseInt(wrapper.lastElementChild.dataset.index) + 1 : 1;

    function refreshCount() {
        var n = wrapper.children.length;
        countLbl.textContent = n + ' / ' + MAX_SEC;
        addBtn.disabled = n >= MAX_SEC;
        addBtn.style.opacity = n >= MAX_SEC ? '0.45' : '';
        wrapper.querySelectorAll('.section-card').forEach(function (c, i) {
            var num = c.querySelector('.sec-num');
            if (num) num.textContent = i + 1;
        });
    }

    function makeCard(i) {
        var d = document.createElement('div');
        d.className = 'section-card'; d.dataset.index = i;
        d.innerHTML =
            '<input type="hidden" name="sections[' + i + '][id]" value="">' +
            '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.65rem;">' +
                '<div style="display:flex;align-items:center;gap:6px;">' +
                    '<span class="sec-num">' + (wrapper.children.length + 1) + '</span>' +
                    '<span style="font-size:0.7rem;color:var(--dim);font-family:monospace;letter-spacing:0.06em;text-transform:uppercase;">Section</span>' +
                '</div>' +
                '<button type="button" class="remove-section syl-btn-rm"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Remove</button>' +
            '</div>' +
            '<div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;" class="responsive-grid">' +
                '<div><label class="syl-label">Section Title</label><input type="text" name="sections[' + i + '][section_title]" class="syl-input" placeholder="e.g. Introduction" required/></div>' +
                '<div><label class="syl-label">Content</label><textarea name="sections[' + i + '][content]" rows="2" class="syl-textarea" placeholder="Describe…"></textarea></div>' +
            '</div>';
        wrapper.appendChild(d);
        refreshCount();
    }

    addBtn.addEventListener('click', function () { if (wrapper.children.length < MAX_SEC) makeCard(secIdx++); });
    wrapper.addEventListener('click', function (e) {
        var rm = e.target.closest('.remove-section');
        if (!rm) return;
        var card = rm.closest('.section-card');
        card.style.transition = 'opacity .18s, transform .18s';
        card.style.opacity = '0'; card.style.transform = 'scale(0.96)';
        setTimeout(function () { card.remove(); refreshCount(); }, 180);
    });
    refreshCount();

    /* ─── Existing photo removal ─── */
    var epField = document.getElementById('existing-photos-field');
    var evField = document.getElementById('existing-videos-field');
    var photoCounter = document.getElementById('photo-counter');
    var videoCounter = document.getElementById('video-counter');

    function getExistingPhotos() { try { return JSON.parse(epField.value || '[]'); } catch(e){ return []; } }
    function getExistingVideos() { try { return JSON.parse(evField.value || '[]'); } catch(e){ return []; } }
    function refreshPhotoCounter() {
        photoCounter.innerHTML = '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' + (getExistingPhotos().length + photoFiles.length) + ' / 25';
    }
    function refreshVideoCounter() {
        videoCounter.innerHTML = '<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>' + (getExistingVideos().length + videoFiles.length) + ' / 3';
    }

    document.addEventListener('click', function (e) {
        var rm = e.target.closest('.existing-photo-rm');
        if (rm) {
            var idx = parseInt(rm.dataset.index);
            var arr = getExistingPhotos(); arr.splice(idx, 1); epField.value = JSON.stringify(arr);
            var tile = document.getElementById('ep-' + rm.dataset.index);
            if (tile) { tile.style.transition = 'opacity .18s, transform .18s'; tile.style.opacity = '0'; tile.style.transform = 'scale(0.85)'; setTimeout(function(){ tile.remove(); refreshPhotoCounter(); }, 180); }
            else refreshPhotoCounter();
        }
        rm = e.target.closest('.existing-video-rm');
        if (rm) {
            var idx2 = parseInt(rm.dataset.index);
            var arr2 = getExistingVideos(); arr2.splice(idx2, 1); evField.value = JSON.stringify(arr2);
            var tile2 = document.getElementById('ev-' + rm.dataset.index);
            if (tile2) { tile2.style.transition = 'opacity .18s, transform .18s'; tile2.style.opacity = '0'; tile2.style.transform = 'scale(0.85)'; setTimeout(function(){ tile2.remove(); refreshVideoCounter(); }, 180); }
            else refreshVideoCounter();
        }
    });

    /* ─── Photo upload ─── */
    var photoInput    = document.getElementById('photos-input');
    var photoPreviews = document.getElementById('photo-previews');
    var photoDrop     = document.getElementById('photo-drop');
    var MAX_PHOTOS    = 25;
    var photoFiles    = [];

    function syncPhotos() { var dt = new DataTransfer(); photoFiles.forEach(function(f){dt.items.add(f);}); photoInput.files = dt.files; }
    function renderPhotos() {
        photoPreviews.innerHTML = '';
        photoFiles.forEach(function (f, i) {
            var wrap = document.createElement('div'); wrap.className = 'media-thumb';
            var img = document.createElement('img'); img.src = URL.createObjectURL(f); img.alt = f.name;
            var rm = document.createElement('button'); rm.type='button'; rm.className='media-rm'; rm.dataset.index=i; rm.textContent='×';
            wrap.appendChild(img); wrap.appendChild(rm); photoPreviews.appendChild(wrap);
        });
        refreshPhotoCounter();
    }
    photoPreviews.addEventListener('click', function (e) {
        var btn = e.target.closest('.media-rm'); if (!btn || !btn.dataset.index) return;
        photoFiles.splice(parseInt(btn.dataset.index), 1); syncPhotos(); renderPhotos();
    });
    photoInput.addEventListener('change', function () {
        var ep = getExistingPhotos().length;
        Array.from(photoInput.files).forEach(function (f) { if ((ep + photoFiles.length) < MAX_PHOTOS) photoFiles.push(f); });
        syncPhotos(); renderPhotos();
    });
    ['dragover','dragleave','drop'].forEach(function (ev) {
        photoDrop.addEventListener(ev, function (e) {
            e.preventDefault(); photoDrop.classList.toggle('dragover', ev==='dragover');
            if (ev==='drop') { var ep = getExistingPhotos().length; Array.from(e.dataTransfer.files).filter(function(f){return f.type.startsWith('image/');}).forEach(function(f){if((ep+photoFiles.length)<MAX_PHOTOS)photoFiles.push(f);}); syncPhotos(); renderPhotos(); }
        });
    });

    /* ─── Video upload ─── */
    var videoInput    = document.getElementById('videos-input');
    var videoPreviews = document.getElementById('video-previews');
    var videoDrop     = document.getElementById('video-drop');
    var MAX_VIDEOS    = 3;
    var videoFiles    = [];

    function syncVideos() { var dt = new DataTransfer(); videoFiles.forEach(function(f){dt.items.add(f);}); videoInput.files = dt.files; }
    function renderVideos() {
        videoPreviews.innerHTML = '';
        videoFiles.forEach(function (f, i) {
            var wrap = document.createElement('div'); wrap.className = 'media-thumb';
            var info = document.createElement('div'); info.className = 'media-thumb-video';
            info.innerHTML = '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg><span>' + f.name.substring(0,10) + (f.name.length>10?'…':'') + '</span>';
            var rm = document.createElement('button'); rm.type='button'; rm.className='media-rm'; rm.dataset.index=i; rm.textContent='×';
            wrap.appendChild(info); wrap.appendChild(rm); videoPreviews.appendChild(wrap);
        });
        refreshVideoCounter();
    }
    videoPreviews.addEventListener('click', function (e) {
        var btn = e.target.closest('.media-rm'); if (!btn || !btn.dataset.index) return;
        videoFiles.splice(parseInt(btn.dataset.index), 1); syncVideos(); renderVideos();
    });
    videoInput.addEventListener('change', function () {
        var ev2 = getExistingVideos().length;
        Array.from(videoInput.files).forEach(function (f) { if ((ev2 + videoFiles.length) < MAX_VIDEOS) videoFiles.push(f); });
        syncVideos(); renderVideos();
    });
    ['dragover','dragleave','drop'].forEach(function (ev) {
        videoDrop.addEventListener(ev, function (e) {
            e.preventDefault(); videoDrop.classList.toggle('dragover', ev==='dragover');
            if (ev==='drop') { var ev2 = getExistingVideos().length; Array.from(e.dataTransfer.files).filter(function(f){return f.type.startsWith('video/');}).forEach(function(f){if((ev2+videoFiles.length)<MAX_VIDEOS)videoFiles.push(f);}); syncVideos(); renderVideos(); }
        });
    });

    refreshPhotoCounter();
    refreshVideoCounter();
});
</script>
@endsection
