@extends('sias.teacher.layout.layout')
@section('title', 'Learning Materials')
@section('page_title', 'Learning Materials')
@section('content')
<div class="page-card"><div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap"><div><h2>Learning Materials</h2><p>Upload PDF resources, videos, modules, and training activities.</p></div><a class="btn" href="{{ route('teacher.modules.upload-resource') }}">Upload resource</a></div><div class="portal-grid">@forelse($modules as $module)<article class="portal-card"><h3>{{ $module->title }}</h3><p>{{ $module->course?->title ?? '—' }}</p><a class="btn" href="{{ route('teacher.modules.edit', $module) }}">Manage module</a></article>@empty<div class="portal-card"><p>No learning materials yet.</p></div>@endforelse</div></div>
@endsection