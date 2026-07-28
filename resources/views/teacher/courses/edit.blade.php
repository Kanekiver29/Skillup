@extends('teacher.layouts.master')

@section('title', 'Edit Course')
@section('page_title', 'Edit Course')

@section('content')
    <section class="card">
        <h3 style="margin-top:0;">Edit course</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">Update course details and keep your teaching content current.</p>
        <form method="POST" action="{{ route('teacher.courses.update', $course) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display:grid; gap:0.9rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Course title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Short description</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $course->short_description ?? '') }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Description</label>
                    <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">{{ old('description', $course->description ?? '') }}</textarea>
                </div>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:0.9rem;">
                    <div>
                        <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Category</label>
                        <input type="text" name="category" value="{{ old('category', $course->category ?? '') }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Level</label>
                        <select name="level" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                            <option value="Beginner" {{ old('level', $course->level ?? '') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ old('level', $course->level ?? '') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ old('level', $course->level ?? '') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:0.9rem;">
                    <div>
                        <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Duration hours</label>
                        <input type="number" name="duration_hours" min="0" value="{{ old('duration_hours', $course->duration_hours ?? 0) }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Preview image URL</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $course->image_url ?? '') }}" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                    </div>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Replace image</label>
                    <input type="file" name="image" style="width:100%; padding:0.6rem; border:1px solid var(--border); border-radius:0.8rem;">
                </div>
                <label style="display:flex; align-items:center; gap:0.5rem; font-weight:600;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $course->is_published ? 1 : 0) ? 'checked' : '' }}>
                    Publish this course
                </label>
                <div style="display:flex; gap:0.8rem; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">Save changes</button>
                    <a href="{{ route('teacher.courses.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </section>
@endsection
