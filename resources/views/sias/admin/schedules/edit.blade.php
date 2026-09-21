@extends('sias.admin.layouts.master')

@section('title', 'Edit Schedule')
@section('page_title', 'Edit Schedule')
@section('subtitle', 'Update the training session details')

@section('content')
<div class="admin-card" style="max-width:760px;margin:0 auto;">
    <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" style="display:grid;gap:1.25rem;">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Course
                <select name="course_id" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    <option value="">No course selected</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $schedule->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('course_id')<span style="color:#ef4444;font-size:.85rem;">{{ $message }}</span>@enderror
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Teacher <span style="color:#ef4444;">*</span>
                <select name="teacher_id" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    <option value="">Select teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @error('teacher_id')<span style="color:#ef4444;font-size:.85rem;">{{ $message }}</span>@enderror
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Subject / Activity <span style="color:#ef4444;">*</span>
                <input type="text" name="subject_name" value="{{ old('subject_name', $schedule->subject_name) }}" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                @error('subject_name')<span style="color:#ef4444;font-size:.85rem;">{{ $message }}</span>@enderror
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Day <span style="color:#ef4444;">*</span>
                <select name="day_of_week" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <option value="{{ $day }}" {{ old('day_of_week', $schedule->day_of_week) === $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Start time <span style="color:#ef4444;">*</span>
                <input type="time" name="start_time" value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">End time <span style="color:#ef4444;">*</span>
                <input type="time" name="end_time" value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Building
                <input type="text" name="building" value="{{ old('building', $schedule->building) }}" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Room
                <input type="text" name="room_number" value="{{ old('room_number', $schedule->room_number) }}" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Trainee count
                <input type="number" name="student_count" min="0" value="{{ old('student_count', $schedule->student_count) }}" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:flex;align-items:center;gap:.55rem;align-self:end;padding-bottom:12px;font-weight:600;color:var(--text);">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $schedule->is_active) ? 'checked' : '' }}> Active schedule
            </label>
        </div>

        <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Notes
            <textarea name="notes" rows="3" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;resize:vertical;">{{ old('notes', $schedule->notes) }}</textarea>
        </label>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="{{ route('admin.schedules.index') }}" class="btn-secondary" style="padding:12px 24px;">Cancel</a>
            <button type="submit" class="btn" style="padding:12px 24px;">Update Schedule</button>
        </div>
    </form>
</div>
@endsection
