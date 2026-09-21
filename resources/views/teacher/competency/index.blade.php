@extends('teacher.layouts.master')
@section('title', 'Competency / Modules')
@section('page_title', 'Competency / Modules')
@section('content')
<div class="portal-page"><div class="portal-heading"><h2>Competency Units and Modules</h2><p>Track competency units, learning activities, and competency progress.</p></div><div class="portal-table-wrap"><table class="portal-table"><thead><tr><th>Module</th><th>Program</th><th>Learning activities</th><th>Progress</th></tr></thead><tbody>@forelse($modules as $module)<tr><td>{{ $module->title }}</td><td>{{ $module->course?->title ?? '—' }}</td><td>{{ $module->lessons?->count() ?? 0 }} lessons</td><td>In progress</td></tr>@empty<tr><td colspan="4">No competency modules available.</td></tr>@endforelse</tbody></table></div></div>
@endsection