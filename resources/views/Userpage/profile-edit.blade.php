@extends('layout.app')

@section('title', 'Edit Profile - SkillUp')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white pt-20">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('userpage.profile') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Back to Profile
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
            <p class="text-gray-600 mt-2">Keep your profile up-to-date to attract mentors and opportunities</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-8">
            <form action="{{ route('userpage.profile-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="font-semibold text-red-800 mb-2">Please fix the following errors:</p>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Profile Picture Section -->
                <div class="mb-8 p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-camera text-purple-600 mr-3"></i> Profile Picture
                    </h2>

                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Current Profile Picture -->
                        <div class="flex flex-col items-center">
                            <div class="w-40 h-40 bg-white rounded-full overflow-hidden border-4 border-purple-300 shadow-lg flex items-center justify-center">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ asset('uploads/profiles/' . auth()->user()->profile_image) }}" alt="Profile Picture" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center text-gray-400">
                                        <i class="fas fa-user text-6xl"></i>
                                        <p class="text-sm mt-2">No Photo</p>
                                    </div>
                                @endif
                            </div>
                            @if(auth()->user()->profile_image)
                                <p class="text-xs text-gray-600 mt-3 text-center">Current Photo</p>
                            @endif
                        </div>

                        <!-- Upload Section -->
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-800 mb-3">Upload New Photo</label>
                            <div class="border-2 border-dashed border-purple-300 rounded-lg p-6 text-center cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition"
                                onclick="document.getElementById('profile-image-input').click()">
                                <input type="file" id="profile-image-input" name="profile_image" accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(event)">
                                <i class="fas fa-cloud-upload-alt text-4xl text-purple-400 mb-3 block"></i>
                                <p class="text-gray-700 font-semibold">Click to upload or drag and drop</p>
                                <p class="text-gray-500 text-sm mt-2">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            @error('profile_image')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror

                            <!-- Preview -->
                            <div id="image-preview-container" class="mt-6 hidden">
                                <p class="text-sm font-semibold text-gray-800 mb-3">Preview</p>
                                <img id="image-preview" src="" alt="Preview" class="w-40 h-40 object-cover rounded-lg border-2 border-purple-300">
                                <button type="button" onclick="clearImagePreview()" class="mt-3 text-red-600 hover:text-red-700 text-sm font-semibold">
                                    <i class="fas fa-times mr-2"></i> Remove Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-user text-purple-600 mr-3"></i> Basic Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Location</label>
                            <input type="text" name="location" placeholder="e.g., San Francisco, CA"
                                value="{{ old('location', auth()->user()->location ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Headline -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Professional Headline</label>
                            <input type="text" name="headline" placeholder="e.g., Full Stack Developer in Progress"
                                value="{{ old('headline', auth()->user()->headline ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Bio Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-pen text-blue-600 mr-3"></i> About You
                    </h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Bio</label>
                        <textarea name="bio" rows="6" placeholder="Tell us about yourself, your goals, and what you're passionate about..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none @error('bio') border-red-500 @enderror">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                        <p class="text-gray-500 text-xs mt-2">Maximum 500 characters</p>
                        @error('bio')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Social Links Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-share-alt text-pink-600 mr-3"></i> Social Links
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- GitHub -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">
                                <i class="fab fa-github mr-2"></i> GitHub
                            </label>
                            <input type="url" name="github_url" placeholder="https://github.com/yourprofile"
                                value="{{ old('github_url', auth()->user()->github_url ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Portfolio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">
                                <i class="fas fa-globe mr-2"></i> Portfolio Website
                            </label>
                            <input type="url" name="portfolio_url" placeholder="https://yourportfolio.com"
                                value="{{ old('portfolio_url', auth()->user()->portfolio_url ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-star text-orange-500 mr-3"></i> Skills
                    </h2>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Add Your Skills</label>
                        <p class="text-gray-600 text-sm mb-3">Type a skill and press Enter or click Add to add it</p>
                        <div class="flex gap-2 mb-4">
                            <input type="text" id="skill-input" placeholder="e.g., JavaScript, React, Node.js"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <button type="button" onclick="addSkill()" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                                Add
                            </button>
                        </div>

                        <!-- Skills Tags -->
                        <div id="skills-container" class="flex flex-wrap gap-2 mb-4">
                            @if(auth()->user()->skills && count(auth()->user()->skills) > 0)
                                @foreach(auth()->user()->skills as $skill)
                                    <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full flex items-center gap-2 skill-tag">
                                        <span class="skill-name">{{ $skill }}</span>
                                        <input type="hidden" name="skills[]" value="{{ $skill }}">
                                        <button type="button" class="hover:text-purple-900 remove-skill-btn" onclick="removeSkillTag(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                        <input type="hidden" id="skills-input" name="skills" value="{{ auth()->user()->skills ? json_encode(auth()->user()->skills) : '[]' }}">
                    </div>
                </div>

                <script>
                    function addSkill() {
                        const input = document.getElementById('skill-input');
                        const skill = input.value.trim();
                        
                        if (skill === '') return;
                        
                        const container = document.getElementById('skills-container');
                        const skillTag = document.createElement('span');
                        skillTag.className = 'bg-purple-100 text-purple-700 px-4 py-2 rounded-full flex items-center gap-2 skill-tag';
                        skillTag.innerHTML = `
                            <span class="skill-name">${skill}</span>
                            <button type="button" class="hover:text-purple-900 remove-skill-btn" onclick="removeSkillTag(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        
                        container.appendChild(skillTag);
                        updateSkillsInput();
                        input.value = '';
                        input.focus();
                    }
                    
                    function removeSkillTag(btn) {
                        btn.closest('.skill-tag').remove();
                        updateSkillsInput();
                    }
                    
                    function updateSkillsInput() {
                        const skills = Array.from(document.querySelectorAll('.skill-name')).map(el => el.textContent);
                        document.getElementById('skills-input').value = JSON.stringify(skills);
                    }
                    
                    // Allow Enter key to add skill
                    document.getElementById('skill-input').addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            addSkill();
                        }
                    });
                </script>

                <!-- Privacy Section -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lock text-gray-600 mr-3"></i> Privacy
                    </h2>

                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="profile_public" value="1" 
                                {{ auth()->user()->profile_public ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-600 rounded">
                            <span class="ml-3 text-gray-700">Make my profile public</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:shadow-lg transition">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                    <a href="{{ route('userpage.profile') }}" class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('profile-image-input');
        const dropZone = document.querySelector('div[onclick*="profile-image-input"]');

        // Image preview functionality
        window.previewImage = function(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
                    fileInput.value = '';
                    return;
                }

                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must not exceed 2MB');
                    fileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        };

        window.clearImagePreview = function() {
            fileInput.value = '';
            document.getElementById('image-preview-container').classList.add('hidden');
            document.getElementById('image-preview').src = '';
        };

        // Drag and drop functionality
        if (dropZone) {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop zone when dragging over
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, function() {
                    dropZone.classList.add('border-purple-500', 'bg-purple-50');
                }, false);
            });

            // Remove highlight when leaving or dropping
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, function() {
                    dropZone.classList.remove('border-purple-500', 'bg-purple-50');
                }, false);
            });

            // Handle file drop
            dropZone.addEventListener('drop', function(e) {
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    // Trigger the preview manually
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }, false);
        }

        // Allow Enter key to submit form
        document.getElementById('skill-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });
    });
</script>
@endsection
