{{-- Shared form partial for module create/edit --}}
<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Course</label>
        <select name="course_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
            <option value="">-- Select Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id', $selectedCourseId ?? ($module->course_id ?? '')) == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
        @error('course_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $module->title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
        @error('title')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description', $module->description ?? '') }}</textarea>
        @error('description')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Definition</label>
        <textarea name="definition" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('definition', $module->definition ?? '') }}</textarea>
        @error('definition')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Example</label>
        <textarea name="example" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('example', $module->example ?? '') }}</textarea>
        @error('example')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Order</label>
            <input type="number" name="order" min="0" value="{{ old('order', $module->order ?? '') }}" placeholder="Auto-assigned if empty" class="mt-1 block w-full border-gray-300 rounded-md">
            @error('order')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-end">
            <div class="flex items-center space-x-3 pb-2">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $module->is_published ?? false) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label class="text-sm text-gray-700">Published</label>
            </div>
        </div>
    </div>
</div>
