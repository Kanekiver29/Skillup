@extends('staff.layouts.masters')

@section('title', 'Staff Tasks')

@section('content')
<div class="cr-page" style="padding:24px;display:grid;gap:20px;">
    <div class="cr-card" style="padding:24px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;border:1px solid var(--border);background:var(--surface);border-radius:12px;box-shadow:0 10px 30px -18px rgba(15,23,42,0.25);color:var(--text);">
        <div>
            <div class="cr-header__eyebrow">
                <span class="cr-header__eyebrow-dot"></span>
                Staff Portal
            </div>
            <h1 class="cr-header__title" style="margin:4px 0 0;color:var(--text);">Tasks</h1>
            <p class="cr-header__subtitle" style="margin-top:6px;color:var(--muted);">Review your current task list and add new work items.</p>
        </div>
        <a href="{{ route('staff.tasks.create') }}" class="cr-btn cr-btn--primary">Create Task</a>
    </div>

    <div class="cr-card" style="padding:24px;border:1px solid var(--border);background:var(--surface);border-radius:12px;box-shadow:0 10px 30px -18px rgba(15,23,42,0.25);color:var(--text);">
        @if(empty($tasks))
            <p style="margin:0;color:var(--muted);">No tasks yet.</p>
        @else
            <div style="display:grid;gap:12px;">
                @foreach($tasks as $task)
                    <div style="border:1px solid var(--border);background:var(--surface);border-radius:12px;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                        <div>
                            <div style="font-weight:700;color:var(--text);">{{ $task['title'] ?? 'Untitled task' }}</div>
                            @if(!empty($task['due']))
                                <div style="color:var(--muted);font-size:13px;margin-top:4px;">Due: {{ $task['due'] }}</div>
                            @endif
                        </div>
                        <div style="color:var(--muted);font-size:13px;">Added {{ !empty($task['created_at']) ? \
                            \\Illuminate\\Support\\Carbon::parse($task['created_at'])->diffForHumans() : 'recently' }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
