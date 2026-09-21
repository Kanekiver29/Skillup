<li class="announcement-item">
    <a href="{{ url('/sias/student/announcements') }}" style="color:inherit;text-decoration:none;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
            <div style="flex:1">{{ \Illuminate\Support\Str::limit($announcement->title ?? ($announcement->message ?? 'Announcement'), 120) }}</div>
            <div style="color:#64748b;font-size:.85rem;margin-left:.5rem">{{ \Carbon\Carbon::parse($announcement->created_at)->toDateString() }}</div>
        </div>
    </a>
</li>
