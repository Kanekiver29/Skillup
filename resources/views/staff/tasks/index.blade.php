@extends('staff.layouts.masters')

@section('title', 'Staff Tasks')

@section('content')
<div class="cr-page" style="padding:24px;display:grid;gap:20px;">
    <div class="cr-card" style="padding:24px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <div class="cr-header__eyebrow">
                <span class="cr-header__eyebrow-dot"></span>
                Staff Portal
            </div>
            <h1 class="cr-header__title" style="margin:4px 0 0;">Tasks</h1>
            <p class="cr-header__subtitle" style="margin-top:6px;">Review your current task list and add new work items.</p>
        </div>
        <a href="{{ route('staff.tasks.create') }}" class="cr-btn cr-btn--primary">Create Task</a>
    </div>

    <div class="cr-card" style="padding:24px;">
        @if(empty($tasks))
            <p style="margin:0;color:#64748b;">No tasks yet.</p>
        @else
            <div style="display:grid;gap:12px;">
                @foreach($tasks as $task)
                    <div style="border:1px solid #e2e8f0;border-radius:12px;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                        <div>
                            <div style="font-weight:700;">{{ $task['title'] ?? 'Untitled task' }}</div>
                            @if(!empty($task['due']))
                                <div style="color:#64748b;font-size:13px;margin-top:4px;">Due: {{ $task['due'] }}</div>
                            @endif
                        </div>
                        <div style="color:#64748b;font-size:13px;">Added {{ !empty($task['created_at']) ? \
                            \\Illuminate\\Support\\Carbon::parse($task['created_at'])->diffForHumans() : 'recently' }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
