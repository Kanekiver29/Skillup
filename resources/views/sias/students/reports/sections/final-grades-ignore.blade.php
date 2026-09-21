@include('sias.students.reports.sections._styles')

@php
    $passCount = 0; $totalUnits = 0;
    foreach($enrollments as $e) {
        $fg = optional($e)->final_grade ?? optional(optional($e)->course)->final_grade ?? null;
        if (is_numeric($fg) && $fg >= 75) $passCount++;
        $totalUnits += optional(optional($e)->course)->units ?? 3;
    }
@endphp

<div class="rs">
    {{-- Inner Header --}}
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Final Grades <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Ignore Curriculum)</span></h2>
            <p>Final grades shown without curriculum matching — raw recorded grades.</p>
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <span class="rs-badge pass">{{ $passCount }} Passed</span>
            <span class="rs-badge fail">{{ $enrollments->count() - $passCount }} Incomplete</span>
        </div>
    </div>

    <div class="rs-grid">
        {{-- Table --}}
        <div class="rs-table-wrap rs-anim" style="animation-delay:.1s;">
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Final Grade</th>
                        <th>Units</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        @php
                            $course = optional($enrollment)->course;
                            $finalGrade = optional($enrollment)->final_grade ?? optional($course)->final_grade ?? 'INC';
                            $units = $course->units ?? $course->credit ?? 3.0;
                            $remark = is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete';
                            $instructorRaw = $course->instructor ?? $course->teacher ?? null;
                            $instructor = is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA');
                        @endphp
                        <tr>
                            <td class="bold">{{ $course->code ?? 'TBD' }}</td>
                            <td>{{ $course->title ?? 'Untitled Subject' }}</td>
                            <td>{{ $instructor }}</td>
                            <td class="bold">{{ $finalGrade }}</td>
                            <td>{{ number_format($units, 1) }}</td>
                            <td><span class="rs-badge {{ $remark === 'Passed' ? 'pass' : 'fail' }}">{{ $remark }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><p>No grade records available yet.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Sidebar --}}
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA (Ignore)</div>
                @php $gwa = isset($gwaIgnore) ? $gwaIgnore : (isset($gwa) ? $gwa : null); $gwaClass = $gwa >= 75 ? 'pass' : ($gwa !== null ? 'fail' : ''); @endphp
                <div class="big-val {{ $gwaClass }}">{{ $gwa !== null ? number_format($gwa, 4) : '—' }}</div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Raw weighted average</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Summary</div>
                <dl>
                    <div class="row"><dt>Total courses</dt><dd>{{ $enrollments->count() }}</dd></div>
                    <div class="row"><dt>Passed</dt><dd>{{ $passCount }}</dd></div>
                    <div class="row"><dt>Incomplete</dt><dd>{{ $enrollments->count() - $passCount }}</dd></div>
                    <div class="row"><dt>Total units</dt><dd>{{ number_format($totalUnits, 1) }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
