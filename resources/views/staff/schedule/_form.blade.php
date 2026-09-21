@csrf

<div class="grid gap-4 md:grid-cols-2">
    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Trainer</span>
        <select name="teacher_id" required class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">Select trainer</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" @selected(old('teacher_id', $schedule->teacher_id ?? '') == $teacher->id)>{{ $teacher->name }}</option>
            @endforeach
        </select>
        @error('teacher_id')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Course</span>
        <select name="course_id" class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">No course</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" @selected(old('course_id', $schedule->course_id ?? '') == $course->id)>{{ $course->title }}</option>
            @endforeach
        </select>
        @error('course_id')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block md:col-span-2">
        <span class="mb-1 block text-sm font-medium text-slate-700">Subject</span>
        <input name="subject_name" value="{{ old('subject_name', $schedule->subject_name ?? '') }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
        @error('subject_name')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Day</span>
        <select name="day_of_week" required class="w-full rounded border border-slate-300 px-3 py-2">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <option value="{{ $day }}" @selected(old('day_of_week', $schedule->day_of_week ?? '') === $day)>{{ $day }}</option>
            @endforeach
        </select>
        @error('day_of_week')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Student count</span>
        <input type="number" name="student_count" min="0" value="{{ old('student_count', $schedule->student_count ?? 0) }}" class="w-full rounded border border-slate-300 px-3 py-2">
        @error('student_count')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Start time</span>
        <input type="time" name="start_time" required value="{{ old('start_time', isset($schedule) ? substr($schedule->start_time, 0, 5) : '') }}" class="w-full rounded border border-slate-300 px-3 py-2">
        @error('start_time')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">End time</span>
        <input type="time" name="end_time" required value="{{ old('end_time', isset($schedule) ? substr($schedule->end_time, 0, 5) : '') }}" class="w-full rounded border border-slate-300 px-3 py-2">
        @error('end_time')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Room</span>
        <input name="room_number" value="{{ old('room_number', $schedule->room_number ?? '') }}" maxlength="50" class="w-full rounded border border-slate-300 px-3 py-2">
    </label>

    <label class="block">
        <span class="mb-1 block text-sm font-medium text-slate-700">Building</span>
        <input name="building" value="{{ old('building', $schedule->building ?? '') }}" maxlength="100" class="w-full rounded border border-slate-300 px-3 py-2">
    </label>

    <label class="block md:col-span-2">
        <span class="mb-1 block text-sm font-medium text-slate-700">Notes</span>
        <textarea name="notes" rows="3" maxlength="1000" class="w-full rounded border border-slate-300 px-3 py-2">{{ old('notes', $schedule->notes ?? '') }}</textarea>
    </label>

    @isset($schedule)
        <label class="flex items-center gap-2 md:col-span-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $schedule->is_active))>
            <span class="text-sm text-slate-700">Active schedule</span>
        </label>
    @endisset
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">{{ $submitLabel }}</button>
    <a href="{{ route('staff.schedule.index') }}" class="rounded border border-slate-300 px-4 py-2 font-semibold text-slate-700">Cancel</a>
</div>
