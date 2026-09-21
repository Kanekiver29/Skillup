@include('sias.students.reports.sections._styles')

@php
    $passCount = 0; $totalUnits = 0; $weightedSum = 0;
    foreach($enrollments as $e) {
        $fg = optional($e)->final_grade ?? optional(optional($e)->course)->final_grade ?? null;
        $u = optional(optional($e)->course)->units ?? 3;
        if (is_numeric($fg) && $fg >= 75) $passCount++;
        if (is_numeric($fg)) { $weightedSum += $fg * $u; $totalUnits += $u; }
    }
    $computedGwa = $totalUnits > 0 ? round($weightedSum / $totalUnits, 4) : null;
    $gwa = isset($gwaMatch) ? $gwaMatch : $computedGwa;
@endphp

<div class="rs">
    {{-- Inner Header --}}
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>General Weighted Average <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Match)</span></h2>
            <p>Match Curriculum mode — weighted average using matched course grading rules.</p>
        </div>
        <span class="rs-badge {{ $gwa !== null && $gwa >= 75 ? 'pass' : 'fail' }}">GWA: {{ $gwa !== null ? number_format($gwa, 2) : '—' }}</span>
    </div>

    <div class="rs-grid">
        {{-- Table --}}
        <div class="rs-table-wrap rs-anim" style="animation-delay:.1s;">
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
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
                        <tr><td colspan="6"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><p>No grade records available yet.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Sidebar --}}
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA Summary</div>
                @php $gwaClass = ($gwa !== null && $gwa >= 75) ? 'pass' : ($gwa !== null ? 'fail' : ''); @endphp
                <div class="big-val {{ $gwaClass }}">{{ $gwa !== null ? number_format($gwa, 4) : '—' }}</div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Using matched curriculum rules</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Details</div>
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
