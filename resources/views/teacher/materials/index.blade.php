@extends('teacher.layouts.master')
@section('title', 'Learning Materials')
@section('page_title', 'Learning Materials')
@section('content')
<div class="portal-page"><div class="portal-heading"><h2>Learning Materials</h2><p>Upload and organize modules, PDF resources, videos, and training activities.</p><a class="portal-button" href="{{ route('teacher.modules.upload-resource') }}">Upload material</a></div><div class="portal-grid">@forelse($modules as $module)<article class="portal-card"><h3>{{ $module->title }}</h3><p>{{ $module->course?->title ?? 'Unassigned program' }}</p><a class="portal-link" href="{{ route('teacher.modules.edit', $module) }}">Manage module</a></article>@empty<div class="portal-card"><p>No learning modules available.</p></div>@endforelse</div></div>
@endsection