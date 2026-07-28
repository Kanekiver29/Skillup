@extends('staff.layouts.masters')

@section('title', 'Edit Lesson')

@section('content')
<div class="lf-page">

    {{-- ambient background layer --}}
    <div class="lf-bg" aria-hidden="true">
        <div class="lf-bg-grid"></div>
        <div class="lf-bg-orb lf-bg-orb--cyan"></div>
        <div class="lf-bg-orb lf-bg-orb--violet"></div>
        <div class="lf-bg-scan"></div>
    </div>

    <div class="lf-wrap">

        {{-- header --}}
        <div class="lf-header">
            <div class="lf-eyebrow">
                <span class="lf-eyebrow-dot"></span>
                STAFF&nbsp;/&nbsp;CONTENT&nbsp;PIPELINE
            </div>
            <h1 class="lf-title">Lesson <span>Refine</span></h1>
            <p class="lf-subtitle">Update the lesson content, metadata, and media assets for your selected module.</p>
        </div>

        @if ($errors->any())
            <div class="lf-alert">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div>
                    <strong>Transmission blocked</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="lf-shell">
            <aside class="lf-spine" aria-hidden="true">
                <div class="lf-spine-track"></div>
                <div class="lf-spine-progress" id="lfSpineProgress"></div>

                <div class="lf-node" data-node="1">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Course&nbsp;Link</span>
                </div>
                <div class="lf-node" data-node="2">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Lesson&nbsp;Details</span>
                </div>
                <div class="lf-node" data-node="3">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Content&nbsp;Payload</span>
                </div>
                <div class="lf-node" data-node="4">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Parameters</span>
                </div>
                <div class="lf-node lf-node--deploy" data-node="5">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Deploy</span>
                </div>
            </aside>

            <div class="lf-mobile-progress" aria-hidden="true">
                <div class="lf-mobile-progress-fill" id="lfMobileProgress"></div>
            </div>

            <form method="POST" action="{{ route('staff.lessons.update', $lesson) }}" class="lf-panel" id="lfForm" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <section class="lf-section" data-section="1" style="--d:0">
                    <div class="lf-section-head">
                        <span class="lf-section-index">01</span>
                        <div>
                            <h2>Course Link</h2>
                            <p>Attach this lesson to its parent course and module.</p>
                        </div>
                    </div>

                    <div class="lf-grid lf-grid--2">
                        <div class="lf-field">
                            <label class="lf-label" for="course_id">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                Course
                            </label>
                            <div class="lf-select-wrap">
                                <select id="course_id" name="course_id" class="lf-select" required>
                                    <option value="" disabled>Select a course&hellip;</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                <svg class="lf-select-chevron" viewBox="0 0 24 24" fill="none"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="module_id">
                                <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="4" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="4" y="13" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="13" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/></svg>
                                Module
                            </label>
                            <div class="lf-select-wrap">
                                <select id="module_id" name="module_id" class="lf-select" required>
                                    <option value="" disabled>Select a module&hellip;</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                                    @endforeach
                                </select>
                                <svg class="lf-select-chevron" viewBox="0 0 24 24" fill="none"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="lf-section" data-section="2" style="--d:1">
                    <div class="lf-section-head">
                        <span class="lf-section-index">02</span>
                        <div>
                            <h2>Lesson Details</h2>
                            <p>The title and a short summary students will see first.</p>
                        </div>
                    </div>

                    <div class="lf-field">
                        <label class="lf-label" for="lesson_title">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            Title
                        </label>
                        <input type="text" id="lesson_title" name="lesson_title" class="lf-input" value="{{ old('lesson_title', $lesson->title) }}" placeholder="e.g. Introduction to Variables" required>
                        <span class="lf-underline"></span>
                    </div>

                    <div class="lf-field">
                        <div class="lf-label-row">
                            <label class="lf-label" for="lesson_description">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                Description
                            </label>
                            <span class="lf-counter" data-counter-for="lesson_description">0 / 300</span>
                        </div>
                        <textarea id="lesson_description" name="lesson_description" maxlength="300" class="lf-input lf-textarea" placeholder="A one or two sentence overview of what this lesson covers&hellip;">{{ old('lesson_description', $lesson->description) }}</textarea>
                        <span class="lf-underline"></span>
                    </div>
                </section>

                <section class="lf-section" data-section="3" style="--d:2">
                    <div class="lf-section-head">
                        <span class="lf-section-index">03</span>
                        <div>
                            <h2>Content Payload</h2>
                            <p>The full lesson body, markdown, or a resource link.</p>
                        </div>
                    </div>

                    <div class="lf-field">
                        <div class="lf-label-row">
                            <label class="lf-label" for="lesson_content">
                                <svg viewBox="0 0 24 24" fill="none"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M13 5l-2 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Content
                            </label>
                            <span class="lf-counter" data-counter-for="lesson_content">0 characters</span>
                        </div>
                        <textarea id="lesson_content" name="lesson_content" class="lf-input lf-textarea lf-textarea--code" placeholder="Full lesson content or resource URL (required by database)" required>{{ old('lesson_content', $lesson->content) }}</textarea>
                        <span class="lf-underline"></span>
                        <p class="lf-hint">Tip &mdash; paste a video transcript, structured markdown, or a direct resource URL. This field is required by the database.</p>
                    </div>
                </section>

                <section class="lf-section" data-section="4" style="--d:3">
                    <div class="lf-section-head">
                        <span class="lf-section-index">04</span>
                        <div>
                            <h2>Parameters</h2>
                            <p>Timing, ordering, and media reference for this lesson.</p>
                        </div>
                    </div>

                    <div class="lf-grid lf-grid--3">
                        <div class="lf-field">
                            <label class="lf-label" for="lesson_duration">
                                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6"/><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Duration&nbsp;<em>(min)</em>
                            </label>
                            <input type="number" id="lesson_duration" name="lesson_duration" class="lf-input lf-input--mono" min="0" placeholder="0" value="{{ old('lesson_duration', $lesson->duration_minutes) }}">
                            <span class="lf-underline"></span>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="lesson_order">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M7 4v16m0-16 3.5 3.5M7 4 3.5 7.5M17 20V4m0 16-3.5-3.5M17 20l3.5-3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Order
                            </label>
                            <input type="number" id="lesson_order" name="lesson_order" class="lf-input lf-input--mono" min="0" placeholder="0" value="{{ old('lesson_order', $lesson->order) }}">
                            <span class="lf-underline"></span>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="lesson_video_url">
                                <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="14" height="12" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m21 8-4 3 4 3V8Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                Video&nbsp;URL
                            </label>
                            <input type="url" id="lesson_video_url" name="lesson_video_url" class="lf-input" placeholder="https://" value="{{ old('lesson_video_url', $lesson->video_url) }}">
                            <span class="lf-underline"></span>
                        </div>
                    </div>

                    <div class="lf-field">
                        <label class="lf-label" for="lesson_image">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 13l2.5 3 3.5-4.5 4.5 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="9" r="1" fill="currentColor"/></svg>
                            Lesson Image
                        </label>
                        <input type="file" id="lesson_image" name="lesson_image" class="lf-input" accept="image/*">
                        <span class="lf-underline"></span>
                        <p class="lf-hint">Optional lesson cover image (JPEG, PNG, GIF, WEBP).</p>
                        @if(!empty($lesson->image_url))
                            <p class="lf-hint">Current image: <a href="{{ $lesson->image_url }}" target="_blank">View</a></p>
                        @endif
                    </div>
                </section>

                <div class="lf-submit-row" style="--d:4">
                    <p class="lf-submit-note">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4.5 8-11V5l-8-3-8 3v6c0 6.5 8 11 8 11Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        Edit and save changes to this lesson.
                    </p>
                    <button type="submit" class="lf-submit" id="lfSubmit">
                        <span class="lf-submit-label">Save Changes</span>
                        <svg class="lf-submit-arrow" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="lf-submit-spinner"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
