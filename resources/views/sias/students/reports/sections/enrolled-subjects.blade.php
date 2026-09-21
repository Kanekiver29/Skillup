@include('sias.students.reports.sections._styles')

<div class="rs">
    {{-- Inner Header --}}
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Enrolled Subjects</h2>
            <p>Full list of subjects enrolled this semester.</p>
        </div>
        <span class="rs-badge info">{{ $enrollments->count() }} Subject(s)</span>
    </div>

    {{-- Meta Row --}}
    <div class="rs-meta-row rs-anim" style="animation-delay:.08s;">
        <div class="rs-meta-item">
            <div class="label">Student ID</div>
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
        <div class="rs-meta-item">
            <div class="label">Status</div>
            <div class="val blue">OFFICIALLY Enrolled</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="rs-table-wrap rs-anim" style="animation-delay:.12s;">
        <table class="rs-table">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Room</th>
                    <th>Instructor</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    @php
                        $course = optional($enrollment)->course;
                        $units = $course->units ?? $course->credit ?? 3.0;
                        $schedule = $enrollment->schedule ?? $course->schedule ?? 'TBA';
                        $room = $course->room ?? '—';
                        $instructorRaw = $course->instructor ?? $course->teacher ?? null;
                        $instructor = is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA');
                    @endphp
                    <tr>
                        <td class="bold">{{ $course->class_code ?? $course->code ?? 'TBD' }}</td>
                        <td>{{ $course->code ?? '—' }}</td>
                        <td class="bold">{{ $course->title ?? 'Untitled Subject' }}</td>
                        <td>{{ number_format($units, 1) }}</td>
                        <td>{{ $schedule }}</td>
                        <td>{{ $room }}</td>
                        <td>{{ $instructor }}</td>
                        <td>{{ $enrollment->section ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="rs-empty">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                <p>No enrolled subjects found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
