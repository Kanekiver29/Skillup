@extends('staff.layouts.masters')

@section('title', 'Modules')

@section('content')
<div class="md-page">
    <header class="md-header">
        <div>
            <h1 class="md-title">Modules</h1>
            <p class="md-subtitle">Manage modules for your courses.</p>
        </div>
        <div class="md-header-actions">
            <form method="GET" action="{{ route('staff.modules.index') }}" class="md-filter-form">
                <label for="course_id" class="md-filter-label">Filter by course:</label>
                <div class="md-select-wrap">
                    <select name="course_id" id="course_id" class="md-select">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                        @endforeach
                    </select>
                    <svg class="md-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <button type="submit" class="md-btn-filter">Filter</button>
            </form>
            <a href="{{ route('staff.modules.create', request('course_id') ? ['course_id' => request('course_id')] : []) }}" class="md-btn-new">
                <i class="fas fa-plus"></i> New Module
            </a>
        </div>
    </header>

    @if(session('success'))
        <div class="md-alert md-alert-success">
            <span class="md-alert-icon md-alert-icon-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="md-alert md-alert-error">
            <span class="md-alert-icon md-alert-icon-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </span>
            {{ session('error') }}
        </div>
    @endif

    <div class="md-card">
        <table class="md-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Quizzes</th>
                    <th class="md-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                    <tr class="md-row" style="animation-delay: {{ 80 + ($loop->index * 40) }}ms;">
                        <td class="md-td-order">{{ $module->order }}</td>
                        <td>
                            <div class="md-module-title">{{ $module->title }}</div>
                            @if($module->description)
                                <div class="md-module-desc">{{ $module->description }}</div>
                            @endif
                        </td>
                        <td class="md-td-course">{{ $module->course->title ?? 'N/A' }}</td>
                        <td>
                            <span class="md-badge-quiz">
                                {{ $module->quizzes_count }} {{ \Illuminate\Support\Str::plural('quiz', $module->quizzes_count) }}
                            </span>
                        </td>
                        <td class="md-td-actions">
                            <a href="{{ route('staff.modules.edit', $module) }}" class="md-link-edit">Edit</a>
                            <form action="{{ route('staff.modules.destroy', $module) }}" method="POST" class="md-inline-form" onsubmit="return confirm('Archive module {{ addslashes($module->title) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="md-link-archive">Archive</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="md-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>No modules found. Use the button above to create one.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md-pagination-wrap">
        {{ $modules->appends(request()->query())->links() }}
    </div>
</div>

<style>
:root {
    --md-primary: #0284c7;
    --md-primary-dark: #0369a1;
    --md-primary-light: #e0f2fe;
    --md-accent: #4f46e5;
    --md-ink: #1e293b;
    --md-muted: #64748b;
    --md-muted-light: #94a3b8;
    --md-border: #e2e8f0;
    --md-surface: #ffffff;
    --md-surface-soft: #f8fafc;
    --md-warning: #d97706;
    --md-warning-bg: #fef3c7;
    --md-success-bg: #d1fae5;
    --md-success-text: #065f46;
    --md-error-bg: #ffe4e6;
    --md-error-text: #9f1239;
    --md-radius-md: 0.75rem;
    --md-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --md-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.md-page { max-width: 80rem; margin: 0 auto; padding: 1.5rem; color: var(--md-ink); font-family: inherit; }

/* Header */
.md-header {
    display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;
    animation: mdFadeInDown 0.4s ease-out both;
}
@media (min-width: 768px) {
    .md-header { flex-direction: row; align-items: center; justify-content: space-between; }
}
.md-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--md-ink); }
.md-subtitle { font-size: 0.875rem; color: var(--md-muted-light); margin: 0.15rem 0 0; }

.md-header-actions { display: flex; flex-direction: column; gap: 0.75rem; }
@media (min-width: 640px) { .md-header-actions { flex-direction: row; align-items: center; } }

.md-filter-form { display: flex; align-items: center; gap: 0.75rem; }
.md-filter-label { font-size: 0.875rem; font-weight: 600; color: var(--md-muted); white-space: nowrap; }
.md-select-wrap { position: relative; }
.md-select {
    appearance: none; border: 1px solid var(--md-border); border-radius: 0.6rem; background: #fff;
    padding: 0.5rem 2rem 0.5rem 0.85rem; font-size: 0.875rem; color: var(--md-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.md-select:focus { outline: none; border-color: var(--md-primary); box-shadow: 0 0 0 4px var(--md-primary-light); }
.md-select-caret { position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%); width: 0.9rem; height: 0.9rem; color: var(--md-muted-light); pointer-events: none; }

.md-btn-filter {
    border: none; border-radius: 0.6rem; background: var(--md-primary); color: #fff; font-size: 0.875rem;
    font-weight: 600; padding: 0.55rem 1.1rem; cursor: pointer;
    transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}
.md-btn-filter:hover { background: var(--md-primary-dark); box-shadow: var(--md-shadow-md); transform: translateY(-1px); }
.md-btn-filter:active { transform: scale(0.97); }

.md-btn-new {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
    border-radius: 0.6rem; background: var(--md-accent); color: #fff; font-size: 0.875rem; font-weight: 600;
    padding: 0.55rem 1.1rem; text-decoration: none;
    transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}
.md-btn-new i { font-size: 0.8rem; }
.md-btn-new:hover { background: #4338ca; box-shadow: var(--md-shadow-md); transform: translateY(-1px); }
.md-btn-new:active { transform: scale(0.97); }

/* Alerts */
.md-alert {
    display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem; padding: 1rem;
    border-radius: var(--md-radius-md); font-size: 0.875rem; box-shadow: var(--md-shadow-sm);
    animation: mdToastIn 0.35s ease-out both;
}
.md-alert-success { background: var(--md-success-bg); color: var(--md-success-text); }
.md-alert-error { background: var(--md-error-bg); color: var(--md-error-text); }
.md-alert-icon {
    width: 1.5rem; height: 1.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; color: #fff; animation: mdPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
.md-alert-icon svg { width: 0.875rem; height: 0.875rem; }
.md-alert-icon-success { background: #10b981; }
.md-alert-icon-error { background: #e11d48; }

/* Table card */
.md-card {
    background: var(--md-surface); border: 1px solid var(--md-border); border-radius: 1.25rem;
    box-shadow: var(--md-shadow-sm); overflow-x: auto; transition: box-shadow 0.3s ease;
    animation: mdFadeInUp 0.45s ease-out both;
}
.md-card:hover { box-shadow: var(--md-shadow-md); }
.md-table { width: 100%; border-collapse: collapse; }
.md-table thead { background: var(--md-surface-soft); }
.md-table th {
    text-align: left; padding: 0.85rem 1.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: var(--md-muted); border-bottom: 1px solid var(--md-border);
}
.md-th-right { text-align: right; }
.md-table td { padding: 1rem 1.5rem; font-size: 0.875rem; border-bottom: 1px solid var(--md-border); vertical-align: top; }
.md-row { animation: mdFadeInUp 0.45s ease-out both; transition: background-color 0.15s ease; }
.md-row:hover { background: var(--md-surface-soft); }
.md-row:last-child td { border-bottom: none; }

.md-td-order { color: var(--md-muted-light); font-weight: 600; }
.md-module-title { font-weight: 600; color: #0f172a; }
.md-module-desc { margin-top: 0.25rem; font-size: 0.75rem; color: var(--md-muted-light); max-width: 20rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.md-td-course { color: var(--md-muted); }

.md-badge-quiz {
    display: inline-flex; align-items: center; border-radius: 999px; background: #ede9fe; color: #6d28d9;
    padding: 0.25rem 0.65rem; font-size: 0.75rem; font-weight: 700;
}

.md-td-actions { text-align: right; white-space: nowrap; }
.md-inline-form { display: inline-block; margin-left: 0.85rem; }
.md-link-edit { font-weight: 700; color: var(--md-primary); text-decoration: none; transition: color 0.15s ease; }
.md-link-edit:hover { color: var(--md-primary-dark); }
.md-link-archive { font-weight: 700; color: var(--md-warning); background: none; border: none; cursor: pointer; padding: 0; font-size: 0.875rem; transition: color 0.15s ease; }
.md-link-archive:hover { color: #92400e; }

.md-empty-state {
    text-align: center; padding: 3rem 1.5rem; color: var(--md-muted-light);
    display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
}
.md-empty-state svg { width: 2.25rem; height: 2.25rem; }
.md-empty-state span { font-size: 0.875rem; }

/* Pagination failsafe: caps any SVG rendered by Laravel's default pagination view,
   in case its own Tailwind classes fail to compile on this project. */
.md-pagination-wrap { margin-top: 1.5rem; animation: mdFadeInUp 0.45s ease-out 0.1s both; }
.md-pagination-wrap nav { display: flex; justify-content: center; }
.md-pagination-wrap svg {
    width: 1.1rem !important;
    height: 1.1rem !important;
    display: inline-block !important;
    vertical-align: middle !important;
}
.md-pagination-wrap span, .md-pagination-wrap a {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Animations */
@keyframes mdFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes mdFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes mdToastIn { from { opacity: 0; transform: translateY(-8px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes mdPop { 0% { transform: scale(0); } 70% { transform: scale(1.15); } 100% { transform: scale(1); } }
</style>
@endsection