@extends('sias.admin.layouts.master')

@section('title', 'Subject Management')
@section('page_title', 'Subjects')
@section('subtitle', 'Manage subjects and assign teachers')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <h2 style="margin: 0; font-size: 1.5rem;">All Subjects</h2>
        <a href="{{ route('sias.admin.subject.add') }}" class="btn" style="padding: 0.7rem 1.2rem; font-size: 0.9rem;">
            <i class="fa-solid fa-plus" style="margin-right: 6px;"></i> Add Subject
        </a>
    </div>

    @if($subjects->isEmpty())
        <p style="color: var(--text-muted); text-align: center; padding: 2rem 1rem;">No subjects found. <a href="{{ route('sias.admin.subject.add') }}" style="color: var(--accent); text-decoration: none; font-weight: 600;">Create one</a>.</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--card-border); background: var(--block-bg);">
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Subject Title</th>
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Course</th>
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Assigned Teacher</th>
                        <th style="text-align: center; padding: 12px 16px; font-weight: 600; color: var(--text-muted); width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr style="border-bottom: 1px solid var(--card-border); transition: background 0.2s ease;">
                            <td style="padding: 14px 16px;">
                                <strong style="color: var(--text);">{{ $subject->title }}</strong>
                            </td>
                            <td style="padding: 14px 16px; color: var(--text-muted);">
                                {{ $subject->course->title ?? 'N/A' }}
                            </td>
                            <td style="padding: 14px 16px;">
                                @if($subject->teacher)
                                    <span style="display: inline-block; padding: 6px 12px; background: rgba(224, 176, 84, 0.15); border-radius: 8px; color: var(--accent-strong); font-weight: 500; font-size: 0.9rem;">
                                        {{ $subject->teacher->name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic; font-size: 0.9rem;">Unassigned</span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="{{ route('sias.admin.subject.edit', $subject->id) }}" 
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: var(--block-bg); color: var(--accent-strong); text-decoration: none; transition: all 0.2s ease;"
                                       title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('sias.admin.subject.delete', $subject->id) }}" style="display: inline; margin: 0;"
                                          onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;"
                                                title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($subjects->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $subjects->links() }}
            </div>
        @endif
    @endif
</div>

<style>
    table tr:hover {
        background: var(--block-bg);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font: inherit;
        font-weight: 500;
        border: none;
        cursor: pointer;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
        color: #241a04;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(201, 151, 59, .25);
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(201, 151, 59, .35);
    }
</style>
@endsection
