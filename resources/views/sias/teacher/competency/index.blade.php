@extends('sias.teacher.layout.layout')
@section('title', 'Competency / Modules')
@section('page_title', 'Competency / Modules')
@section('content')
<div class="page-card"><h2>Competency Units and Learning Modules</h2><p>Manage training activities and competency progress.</p><div style="overflow:auto"><table class="portal-table"><thead><tr><th>Module</th><th>Program</th><th>Lessons</th><th>Activities</th><th>Action</th></tr></thead><tbody>@forelse($modules as $module)<tr><td>{{ $module->title }}</td><td>{{ $module->course?->title ?? '—' }}</td><td>{{ $module->lessons?->count() ?? 0 }}</td><td>{{ $module->quizzes?->count() ?? 0 }} assessments</td><td><a class="btn" href="{{ route('sias.teacher.materials') }}">Manage content</a></td></tr>@empty<tr><td colspan="5">No modules found.</td></tr>@endforelse</tbody></table></div></div>
@endsection