@extends('sias.teacher.layout.layout')

@section('title', 'Add Training Schedule')
@section('page_title', 'Add Training Schedule')

@section('content')
<div class="page-card">
	<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;">
		<div>
			<h2>Add Training Schedule</h2>
			<p style="margin:.35rem 0 0;color:#64748b;">Set a class time, room, and subject for your trainees.</p>
		</div>
		<a href="{{ route('sias.teacher.schedule') }}" class="btn" style="background:#eef2ff;color:#1d4ed8;">Back to Schedule</a>
	</div>

	<form method="POST" action="{{ route('sias.teacher.schedule.store') }}" style="display:grid;gap:1rem;max-width:760px;">
		@csrf

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Program
				<select name="course_id">
					<option value="">Select program</option>
					@foreach($courses as $course)
						<option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
					@endforeach
				</select>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Subject / Activity
				<input type="text" name="subject_name" value="{{ old('subject_name') }}" required>
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Day
				<select name="day_of_week" required>
					@foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
						<option value="{{ $day }}" {{ old('day_of_week') === $day ? 'selected' : '' }}>{{ $day }}</option>
					@endforeach
				</select>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Trainee count
				<input type="number" name="student_count" min="0" value="{{ old('student_count', 0) }}">
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Start time
				<input type="time" name="start_time" value="{{ old('start_time') }}" required>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				End time
				<input type="time" name="end_time" value="{{ old('end_time') }}" required>
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Building
				<input type="text" name="building" value="{{ old('building') }}" placeholder="Main Building">
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Room
				<input type="text" name="room_number" value="{{ old('room_number') }}" placeholder="20">
			</label>
		</div>

		<label style="display:grid;gap:.45rem;font-weight:700;">
			Notes
			<textarea name="notes" rows="3" style="resize:vertical;">{{ old('notes') }}</textarea>
		</label>

		<div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
			<a href="{{ route('sias.teacher.schedule') }}" class="btn" style="background:#f1f5f9;color:#0f172a;">Cancel</a>
			<button class="btn" type="submit">Save schedule</button>
		</div>
	</form>
</div>
@endsection