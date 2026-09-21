@extends('teacher.layouts.master')
@section('title', 'Announcements')
@section('page_title', 'Announcements')
@section('content')
<div class="portal-page"><div class="portal-heading"><h2>Training Announcements</h2><p>Stay updated with training notices, schedule changes, and reminders.</p></div><div class="portal-grid">@forelse($announcements as $announcement)<article class="portal-card"><small>{{ optional($announcement->published_at)->format('M d, Y') }}</small><h3>{{ $announcement->title }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 180) }}</p></article>@empty<div class="portal-card"><p>No announcements are available.</p></div>@endforelse</div></div>
@endsection