@include('sias.students.reports.sections._styles')

@php
    $termLabel = $sectionMeta['term_label'] ?? 'Second Semester S.Y 2025-2026';
    $courses = $enrollments->map(function($enrollment) {
        $course = optional($enrollment)->course;
        $finalGrade = optional($enrollment)->final_grade ?? optional($course)->final_grade ?? 'INC';
        $average = optional($enrollment)->average_grade ?? optional($course)->average_grade ?? $finalGrade;
        $units = $course->units ?? $course->credit ?? 3.0;
        $instructorRaw = $course->instructor ?? $course->teacher ?? null;
        return [
            'code'       => $course->code ?? 'TBD',
            'title'      => $course->title ?? 'Untitled Subject',
            'instructor' => is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA'),
            'average'    => $average,
            'finalGrade' => $finalGrade,
            'equivGrade' => is_numeric($finalGrade) ? $finalGrade : 'INC',
            'units'      => $units,
            'remark'     => is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete',
            'currEval'   => is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete',
        ];
    });
    $passCount = $courses->where('remark', 'Passed')->count();
    $numericGrades = $courses->filter(fn($r) => is_numeric($r['finalGrade']))->pluck('finalGrade');
    $totalUnits = $courses->sum('units');
    $displayGrade = $gwaMatch !== null ? number_format($gwaMatch, 4) : ($numericGrades->count() ? number_format($numericGrades->avg(), 4) : '—');
    $gwaClass = ($gwaMatch !== null && $gwaMatch >= 75) ? 'pass' : ($gwaMatch !== null ? 'fail' : '');
@endphp

<div class="rs">
    {{-- Inner Header --}}
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Term Grades <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Match)</span></h2>
            <p>{{ $termLabel }}</p>
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <span class="rs-badge pass">{{ $passCount }} Passed</span>
            <span class="rs-badge fail">{{ $courses->count() - $passCount }} Incomplete</span>
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
                        <th>Ave Grade</th>
                        <th>Final Grade</th>
                        <th>Equiv</th>
                        <th>Units</th>
                        <th>Remark</th>
                        <th>Curr Eval</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $row)
                        <tr>
                            <td class="bold">{{ $row['code'] }}</td>
                            <td>{{ $row['title'] }}</td>
                            <td>{{ $row['instructor'] }}</td>
                            <td>{{ is_numeric($row['average']) ? number_format($row['average'], 2) : $row['average'] }}</td>
                            <td class="bold">{{ $row['finalGrade'] }}</td>
                            <td>{{ $row['equivGrade'] }}</td>
                            <td>{{ number_format($row['units'], 1) }}</td>
                            <td><span class="rs-badge {{ $row['remark'] === 'Passed' ? 'pass' : 'fail' }}">{{ $row['remark'] }}</span></td>
                            <td><span class="rs-badge {{ $row['currEval'] === 'Passed' ? 'pass' : 'inc' }}">{{ $row['currEval'] }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="9"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><p>No term grade records available.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Sidebar --}}
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA (Match)</div>
                <div class="big-val {{ $gwaClass }}">{{ $displayGrade }}</div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Matched curriculum rules</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Term Summary</div>
                <dl>
                    <div class="row"><dt>Courses</dt><dd>{{ $courses->count() }}</dd></div>
                    <div class="row"><dt>Passed</dt><dd>{{ $passCount }}</dd></div>
                    <div class="row"><dt>Incomplete</dt><dd>{{ $courses->count() - $passCount }}</dd></div>
                    <div class="row"><dt>Total units</dt><dd>{{ number_format($totalUnits, 1) }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
