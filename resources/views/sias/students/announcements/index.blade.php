@extends('sias.students.layout.master')

@section('title', 'Announcements')
@section('page_title', 'Announcements')

@section('content')
<div class="page-card">
    <h2>Training Announcements</h2>
    <p>Important notices, schedule changes, and reminders from your training center.</p>
    <div style="display:grid;gap:1rem;margin-top:1.25rem;">
        @forelse($announcements ?? collect() as $announcement)
            <article class="dashboard-card">
                <small>{{ optional($announcement->published_at)->format('F d, Y') }}</small>
                <h3>{{ $announcement->title }}</h3>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 240) }}</p>
            </article>
        @empty
            <div class="section-block"><strong>No announcements yet</strong><span>New training notices will appear here.</span></div>
        @endforelse
    </div>
</div>
@endsection
