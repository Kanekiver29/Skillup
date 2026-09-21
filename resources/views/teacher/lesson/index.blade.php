@extends('teacher.layouts.master')

@section('title', 'Lessons')
@section('page_title', 'Lessons')

@section('content')
<style>
    .lessons-page { max-width: 1200px; margin: 0 auto; padding: 2rem 1.25rem 3rem; color: #17233f; }
    .lessons-heading { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .lessons-heading h1 { margin: 0; color: #0b1730; font-size: 2rem; font-weight: 800; }
    .lessons-heading p { margin: .35rem 0 0; color: #64748b; }
    .new-lesson { background: #315bd6; color: #fff; border-radius: 8px; padding: .75rem 1rem; text-decoration: none; font-weight: 800; }
    .lessons-card { overflow: hidden; background: #fff; border: 1px solid #dfe7f5; border-radius: 14px; box-shadow: 0 12px 30px rgba(25, 48, 92, .08); }
    .lessons-table { width: 100%; border-collapse: collapse; }
    .lessons-table th { background: #f5f8fd; color: #52627c; font-size: .75rem; letter-spacing: .05em; text-align: left; text-transform: uppercase; padding: 1rem 1.25rem; }
    .lessons-table td { border-top: 1px solid #e8eef7; padding: 1rem 1.25rem; vertical-align: middle; }
    .lesson-title { color: #0b1730; font-weight: 800; }
    .lesson-course { color: #718198; font-size: .8rem; margin-top: .25rem; }
    .status, .media-tag { display: inline-block; border-radius: 999px; padding: .3rem .6rem; font-size: .75rem; font-weight: 800; }
    .published { background: #dcfce7; color: #15803d; }
    .draft { background: #fef3c7; color: #a16207; }
    .media-tag { margin: .15rem; background: #eef4ff; color: #315bd6; }
    .lesson-links { display: flex; justify-content: flex-end; gap: .75rem; flex-wrap: wrap; }
    .lesson-links a, .lesson-links button { color: #315bd6; background: none; border: 0; padding: 0; font: inherit; font-weight: 700; text-decoration: none; cursor: pointer; }
    .lesson-links .danger { color: #dc2626; }
    .empty-lessons { padding: 3rem 1rem; text-align: center; color: #64748b; }
    .empty-lessons a { color: #315bd6; font-weight: 700; }
    @media (max-width: 720px) { .lessons-table th:nth-child(2), .lessons-table td:nth-child(2) { display: none; } .lessons-table th, .lessons-table td { padding: .8rem .65rem; } .lesson-links { justify-content: flex-start; } }
</style>

<div class="lessons-page">
    <div class="lessons-heading">
        <div>
            <h1>Lessons</h1>
            <p>Manage course lessons and learning materials.</p>
        </div>
        <a href="{{ route('teacher.lessons.create') }}" class="new-lesson">+ New Lesson</a>
    </div>

    <div class="lessons-card">
        @forelse($lessons as $lesson)
            @if($loop->first)
                <table class="lessons-table"><thead><tr><th>Lesson</th><th>Module / Course</th><th>Content</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            @endif
            <tr>
                <td><div class="lesson-title">{{ $lesson->title }}</div><div class="lesson-course">{{ $lesson->duration_minutes ?: 0 }} minutes</div></td>
                <td>{{ $lesson->module?->title ?: 'Unassigned' }}<div class="lesson-course">{{ $lesson->module?->course?->title ?: 'No course' }}</div></td>
                <td>
                    @if($lesson->content)<span class="media-tag">Text</span>@endif
                    @if($lesson->image_url)<span class="media-tag">Image</span>@endif
                    @if($lesson->video_url)<span class="media-tag">Video</span>@endif
                    @if($lesson->material_url)<span class="media-tag">File</span>@endif
                </td>
                <td><span class="status {{ $lesson->is_published ? 'published' : 'draft' }}">{{ $lesson->is_published ? 'Published' : 'Draft' }}</span></td>
                <td><div class="lesson-links">
                    @if($lesson->slug && $lesson->module?->course?->slug && $lesson->module?->slug)<a href="{{ route('lessons.show', [$lesson->module->course->slug, $lesson->module->slug, $lesson->slug]) }}" target="_blank">Student View</a>@endif
                    <a href="{{ route('teacher.lessons.edit', $lesson->id) }}">Edit</a>
                    <form method="POST" action="{{ route('teacher.lessons.destroy', $lesson->id) }}" onsubmit="return confirm('Delete this lesson?');">@csrf @method('DELETE')<button class="danger" type="submit">Delete</button></form>
                </div></td>
            </tr>
            @if($loop->last)</tbody></table>@endif
        @empty
            <div class="empty-lessons"><strong>No lessons found yet.</strong><br><a href="{{ route('teacher.lessons.create') }}">Create the first lesson</a></div>
        @endforelse
</div>
@endsection
