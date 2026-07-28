@extends('teacher.layouts.master')

@section('title', 'Create Module')
@section('page_title', 'Create Module')

@section('content')
    <section class="card">
        <h3 style="margin-top:0;">Create a new module</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">Add a module to one of your courses and publish it when ready.</p>
        <form method="POST" action="{{ route('teacher.modules.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(120px,1fr)); gap:0.75rem; margin-bottom:1rem;">
                <button type="button" id="addQuizBtn" class="btn-secondary" style="width:100%;">Add Quiz</button>
                <button type="button" id="addWordBtn" class="btn-secondary" style="width:100%;">Add Word</button>
                <button type="button" id="addVideoBtn" class="btn-secondary" style="width:100%;">Add Video</button>
                <button type="button" id="addImageBtn" class="btn-secondary" style="width:100%;">Add Image</button>
                <button type="button" id="addPptBtn" class="btn-secondary" style="width:100%;">Add PPT</button>
            </div>
            <input type="file" name="resource_word" id="resourceWordInput" accept=".doc,.docx" hidden>
            <input type="file" name="resource_video" id="resourceVideoInput" accept="video/*" hidden>
            <input type="file" name="resource_image" id="resourceImageInput" accept="image/*" hidden>
            <input type="file" name="resource_ppt" id="resourcePptInput" accept=".ppt,.pptx" hidden>
            <div id="resourceSelection" style="display:grid; gap:0.75rem; margin-bottom:1rem;"></div>
            <div style="display:grid; gap:0.9rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Module title</label>
                    <input type="text" name="title" value="{{ old('title') }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Course</label>
                    <select name="course_id" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;" required>
                        <option value="">Select a course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:0.9rem;">
                    <div>
                        <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Order</label>
                        <input type="number" name="order" min="0" value="{{ old('order', 0) }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                    </div>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Description</label>
                    <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">{{ old('description') }}</textarea>
                </div>
                <label style="display:flex; align-items:center; gap:0.5rem; font-weight:600;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                    Publish this module immediately
                </label>
                <div style="display:flex; gap:0.8rem; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">Save module</button>
                    <a href="{{ route('teacher.modules.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileMappings = [
                {button: 'addWordBtn', input: 'resourceWordInput', label: 'Word file'},
                {button: 'addVideoBtn', input: 'resourceVideoInput', label: 'Video file'},
                {button: 'addImageBtn', input: 'resourceImageInput', label: 'Image file'},
                {button: 'addPptBtn', input: 'resourcePptInput', label: 'PPT file'},
            ];

            const resourceSelection = document.getElementById('resourceSelection');

            fileMappings.forEach(mapping => {
                const button = document.getElementById(mapping.button);
                const input = document.getElementById(mapping.input);

                if (!button || !input) return;

                button.addEventListener('click', () => input.click());
                input.addEventListener('change', () => {
                    const existing = document.querySelector(`[data-resource="${mapping.input}"]`);
                    if (existing) existing.remove();

                    if (!input.files.length) return;

                    const fileRow = document.createElement('div');
                    fileRow.setAttribute('data-resource', mapping.input);
                    fileRow.style.display = 'flex';
                    fileRow.style.justifyContent = 'space-between';
                    fileRow.style.alignItems = 'center';
                    fileRow.style.padding = '0.75rem 1rem';
                    fileRow.style.border = '1px solid var(--border)';
                    fileRow.style.borderRadius = '0.8rem';
                    fileRow.style.background = '#f8fafc';

                    const name = document.createElement('span');
                    name.style.color = '#334155';
                    name.textContent = `${mapping.label}: ${input.files[0].name}`;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.textContent = 'Remove';
                    removeBtn.style.border = 'none';
                    removeBtn.style.background = 'transparent';
                    removeBtn.style.color = '#dc2626';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.fontWeight = '600';

                    removeBtn.addEventListener('click', () => {
                        input.value = '';
                        fileRow.remove();
                    });

                    fileRow.appendChild(name);
                    fileRow.appendChild(removeBtn);
                    resourceSelection.appendChild(fileRow);
                });
            });

            const quizButton = document.getElementById('addQuizBtn');
            if (quizButton) {
                quizButton.addEventListener('click', () => {
                    window.location.href = '{{ route('teacher.quizzes.create') }}';
                });
            }
        });
    </script>
@endsection
