@extends('teacher.layouts.master')

@section('title', 'Module PPT')
@section('page_title', 'Module PPT')

@section('content')
    <section class="card">
        <h3 style="margin-top:0;">Module PPT</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">View or upload a PPT file for this module.</p>

        @if(!empty($module->ppt_url))
            <div style="margin-bottom:1rem;">
                <strong>Current file:</strong>
                <div style="margin-top:0.5rem; display:flex; gap:0.75rem; align-items:center;">
                    <a href="{{ $module->ppt_url }}" target="_blank" class="btn-primary" style="padding:0.5rem 0.8rem;">Open PPT</a>
                    <a href="{{ $module->ppt_url }}" download class="btn-secondary" style="padding:0.5rem 0.8rem;">Download</a>
                </div>
            </div>

            <div style="width:100%; height:620px; border:1px solid var(--border); border-radius:0.8rem; overflow:auto;">
                <iframe src="{{ $module->ppt_url }}" style="width:100%; height:100%; border:0;" title="Module PPT"></iframe>
            </div>
        @else
            <div style="margin-bottom:1rem; color:var(--muted);">No PPT file attached to this module yet.</div>
            <div style="display:flex; gap:0.75rem;">
                <a href="{{ route('teacher.modules.upload-resource') }}?type=ppt" class="btn-primary">Upload PPT</a>
                <a href="{{ route('teacher.modules.index') }}" class="btn-secondary">Back to modules</a>
            </div>
        @endif
    </section>
@endsection
