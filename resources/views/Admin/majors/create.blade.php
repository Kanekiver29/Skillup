@extends('layout.Admin.system')

@section('title', 'Create Major')

@section('content')
<div class="container mx-auto max-w-2xl px-6 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.majors.index') }}" class="text-blue-600 hover:text-blue-900 text-sm mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Majors
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Create New Major</h1>
        <p class="mt-2 text-gray-600">Add a new academic major or program</p>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form method="POST" action="{{ route('admin.majors.store') }}" novalidate>
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2" for="name">Major Name <span class="text-red-600">*</span></label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                    placeholder="Information Technology"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2" for="code">Major Code <span class="text-red-600">*</span></label>
                <input 
                    id="code" 
                    name="code" 
                    type="text" 
                    value="{{ old('code') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror" 
                    placeholder="IT"
                    maxlength="50"
                    required
                >
                @error('code')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2" for="description">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" 
                    placeholder="Brief description of the major..."
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2" for="department">Department</label>
                    <input 
                        id="department" 
                        name="department" 
                        type="text" 
                        value="{{ old('department') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('department') border-red-500 @enderror" 
                        placeholder="Computing"
                        maxlength="255"
                    >
                    @error('department')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2" for="color">Brand Color</label>
                    <div class="flex gap-2">
                        <input 
                            id="color" 
                            name="color" 
                            type="color" 
                            value="{{ old('color', '#3B82F6') }}" 
                            class="h-10 rounded cursor-pointer"
                        >
                        <input 
                            type="text" 
                            id="color_text"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg font-mono text-sm" 
                            readonly
                            value="{{ old('color', '#3B82F6') }}"
                        >
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-save mr-2"></i>Create Major
                </button>
                <a href="{{ route('admin.majors.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('color').addEventListener('input', function(e) {
    document.getElementById('color_text').value = e.target.value.toUpperCase();
});
</script>
@endsection
