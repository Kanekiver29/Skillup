@extends('sias.admin.layouts.master')

@section('title', 'Edit Subject')
@section('page_title', 'Edit Subject')
@section('subtitle', 'Update subject details and assign teacher')

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <form method="POST" action="{{ route('sias.admin.subject.update', $subject->id) }}" style="display: grid; gap: 1.5rem;">
        @csrf
        @method('PUT')

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Subject Title <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="title" required
                   style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; transition: border 0.2s ease;"
                   placeholder="e.g., Mathematics 101" value="{{ old('title', $subject->title) }}">
            @error('title')
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Course <span style="color: #ef4444;">*</span>
            </label>
            <select name="course_id" required
                    style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; cursor: pointer; transition: border 0.2s ease;">
                <option value="">-- Select a Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Assign Teacher <span style="color: var(--text-muted); font-weight: 400; font-size: 0.9rem;">(Optional)</span>
            </label>
            <select name="teacher_id"
                    style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; cursor: pointer; transition: border 0.2s ease;">
                <option value="">-- No Teacher (Unassigned) --</option>
                @foreach(\App\Models\User::where('role', 'teacher')->orWhere('is_admin', true)->get() as $user)
                    <option value="{{ $user->id }}" {{ old('teacher_id', $subject->teacher_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="background: var(--block-bg); padding: 14px 16px; border-radius: 10px; border-left: 3px solid var(--accent-strong);">
            <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">
                <strong style="color: var(--text);">Current Assignment:</strong>
                @if($subject->teacher)
                    <span style="display: inline-block; margin-top: 6px; padding: 6px 12px; background: rgba(224, 176, 84, 0.15); border-radius: 8px; color: var(--accent-strong); font-weight: 500;">
                        {{ $subject->teacher->name }}
                    </span>
                @else
                    <span style="color: var(--text-muted); font-style: italic;">No teacher assigned</span>
                @endif
            </p>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 1rem;">
            <button type="submit" class="btn" style="flex: 1; padding: 12px 24px;">
                <i class="fa-solid fa-check" style="margin-right: 6px;"></i> Save Changes
            </button>
            <a href="{{ route('sias.admin.subject') }}" class="btn-secondary" style="flex: 1; padding: 12px 24px; text-align: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    input:focus, select:focus {
        outline: none;
        border-color: var(--accent-strong);
        box-shadow: 0 0 0 3px rgba(224, 176, 84, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font: inherit;
        font-weight: 500;
        border: 1px solid var(--card-border);
        cursor: pointer;
        border-radius: 12px;
        background: var(--block-bg);
        color: var(--text);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background: var(--card-bg);
        border-color: var(--accent-strong);
    }
</style>
@endsection
