<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
        @error('title')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Short Description</label>
        <textarea name="short_description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('short_description', $course->short_description ?? '') }}</textarea>
        @error('short_description')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Full Description</label>
        <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" value="{{ old('category', $course->category ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            @error('category')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Level</label>
            <select name="level" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="">Select level</option>
                <option value="Beginner" {{ old('level', $course->level ?? '') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="Intermediate" {{ old('level', $course->level ?? '') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="Advanced" {{ old('level', $course->level ?? '') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
            @error('level')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Duration (hours)</label>
            <input type="number" step="0.1" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            @error('duration_hours')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Image URL</label>
            <input type="text" name="image_url" value="{{ old('image_url', $course->image_url ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            @error('image_url')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Instructor Name</label>
            <input type="text" name="instructor_name" value="{{ old('instructor_name', $course->instructor_name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            @error('instructor_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Instructor Title</label>
            <input type="text" name="instructor_title" value="{{ old('instructor_title', $course->instructor_title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md">
            @error('instructor_title')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $course->is_published ?? false) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label class="text-sm text-gray-700">Published</label>
    </div>
</div>