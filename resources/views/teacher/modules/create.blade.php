@extends('teacher.layouts.master')

@section('title', isset($module) ? 'Edit Module' : 'Create Module')
@section('page_title', isset($module) ? 'Edit Module' : 'New Module')

@section('content')
<style>
    .form-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .form-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--navy-950);
    }
    .btn-back {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--navy-800);
        font-weight: 700;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
    }
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .form-group {
        margin-bottom: 1.4rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-family: inherit;
        font-size: 0.92rem;
    }
    .form-control:focus {
        border-color: var(--accent-2);
        outline: none;
        background: #fff;
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
    }
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h1>📂 {{ isset($module) ? 'Edit Module' : 'Create New Module' }}</h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Define curriculum modules to organize lessons and assessments.</p>
        </div>
        <a href="{{ route('teacher.modules.index') }}" class="btn-back">← Back to Modules</a>
    </div>

    @if($errors->any())
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        @if(($courses ?? collect())->isEmpty())
            <div style="background: rgba(234, 179, 8, 0.08); border: 1px solid rgba(234, 179, 8, 0.3); color: #92400e; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
                <strong>No courses assigned yet.</strong>
                <p style="margin: 0.5rem 0 0;">Create a course first in the teacher courses section before adding a module.</p>
                <div style="margin-top: 0.85rem;">
                    <a href="{{ route('teacher.courses.create') }}" class="btn-back">Create Course</a>
                </div>
            </div>
        @else
            <form method="POST" action="{{ isset($module) ? route('teacher.modules.update', $module->id) : route('teacher.modules.store') }}">
                @csrf
                @if(isset($module))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="course_id">Associated Course <span style="color:var(--danger)">*</span></label>
                    <select id="course_id" name="course_id" class="form-control" required>
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ old('course_id', $module->course_id ?? request('course_id')) == $c->id ? 'selected' : '' }}>
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Module Title <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $module->title ?? '') }}" class="form-control" placeholder="e.g., Module 1: Introduction to Web Development" required>
                </div>

                <div class="form-group">
                    <label for="description">Module Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control" placeholder="Module goals and summary...">{{ old('description', $module->description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="order">Display Order</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $module->order ?? 1) }}" min="1" class="form-control">
                </div>

                <div class="form-footer">
                    <a href="{{ route('teacher.modules.index') }}" class="btn-back">Cancel</a>
                    <button type="submit" class="btn-submit">
                        {{ isset($module) ? 'Update Module' : 'Save & Publish Module' }}
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
