@extends('sias.students.layout.master')

@section('title', 'Notifications')
@section('page_title', 'Notifications')

@section('content')
<div class="page-card">
    <h2>Notifications</h2>
    <p>Keep track of updates about your enrollment, classes, assessments, and account.</p>
    <div style="display:grid;gap:1rem;margin-top:1.25rem;">
        @forelse(auth()->user()->notifications ?? collect() as $notification)
            <article class="dashboard-card">
                <small>{{ optional($notification->created_at)->format('F d, Y h:i A') }}</small>
                <p>{{ data_get($notification->data, 'message', data_get($notification->data, 'title', 'You have a new notification.')) }}</p>
            </article>
        @empty
            <div class="section-block"><strong>No notifications</strong><span>You are all caught up.</span></div>
        @endforelse
    </div>
</div>
@endsection
