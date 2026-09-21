@include('sias.students.reports.sections._styles')

<div class="rs">
    {{-- Inner Header --}}
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Class Offerings</h2>
            <p>Courses available in the current enrollment period.</p>
        </div>
        <span class="rs-badge info">{{ isset($enrollments) ? $enrollments->count() : 0 }} Courses</span>
    </div>

    {{-- Meta Row --}}
    <div class="rs-meta-row rs-anim" style="animation-delay:.08s;">
        <div class="rs-meta-item">
            <div class="label">Student</div>
            <div class="val">{{ $user->student_id ?? $user->id }}</div>
        </div>
        <div class="rs-meta-item">
            <div class="label">Name</div>
            <div class="val">{{ $user->name }}</div>
        </div>
        <div class="rs-meta-item">
            <div class="label">Period</div>
            <div class="val">{{ session('current_period') ?? '2025-2' }}</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="rs-table-wrap rs-anim" style="animation-delay:.12s;">
        @if(isset($enrollments) && $enrollments->isNotEmpty())
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Description</th>
                        <th>Units</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        @php
                            $course = optional($enrollment)->course;
                            $units = $course->units ?? $course->credit ?? 3.0;
                        @endphp
                        <tr>
                            <td class="bold">{{ $course->code ?? $course->slug ?? 'TBD' }}</td>
                            <td>{{ $course->title ?? 'Untitled Course' }}</td>
                            <td>{{ number_format($units, 1) }}</td>
                            <td>{{ $enrollment->section ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="rs-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p>No class offerings available for this period.</p>
            </div>
        @endif
    </div>
</div>
