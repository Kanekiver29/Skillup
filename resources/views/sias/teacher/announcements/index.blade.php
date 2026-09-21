@extends('sias.teacher.layout.layout')
@section('title', 'Announcements')
@section('page_title', 'Announcements')
@section('content')
<div class="page-card"><h2>Training Announcements</h2><p>Training notices, schedule changes, and reminders.</p><div class="portal-grid">@forelse($announcements as $announcement)<article class="portal-card"><small>{{ optional($announcement->published_at)->format('M d, Y') }}</small><h3>{{ $announcement->title }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 220) }}</p></article>@empty<div class="portal-card"><p>No announcements available.</p></div>@endforelse</div></div>
@endsection