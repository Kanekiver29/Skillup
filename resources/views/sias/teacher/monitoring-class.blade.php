@extends('sias.teacher.layout.layout')

@section('title', 'Monitoring Class')
@section('page_title', 'Class Monitoring')

@section('content')
<div class="page-card">
    <h2>Monitoring Class</h2>
    <p>Track attendance, performance, and top student scores in real time.</p>

    <div class="dashboard-grid" style="margin-top:24px;">
        <div class="dashboard-card">
            <strong>Active Classes</strong>
            <p class="text-sm text-slate-500">{{ $courses->count() }} classes currently assigned to you.</p>
            <div style="margin-top:14px;display:grid;gap:12px;">
                @forelse($courses as $course)
                    <div><span style="font-weight:700;">{{ $course->title }}</span> — {{ $course->enrollments_count }} students</div>
                @empty
                    <div>No classes assigned.</div>
                @endforelse
            </div>
        </div>
        <div class="dashboard-card">
            <strong>Attendance Summary</strong>
            <p class="text-sm text-slate-500">Last 7 days attendance trend.</p>
            <div style="margin-top:14px;display:grid;gap:10px;">
                <div><strong>Present:</strong> {{ $attendanceSummary['present'] }}</div>
                <div><strong>Absent:</strong> {{ $attendanceSummary['absent'] }}</div>
                <div><strong>Late:</strong> {{ $attendanceSummary['late'] }}</div>
                <div><strong>Rate:</strong> {{ $attendanceSummary['rate'] }}%</div>
            </div>
        </div>
        <div class="dashboard-card">
            <strong>Top Students</strong>
            <p class="text-sm text-slate-500">Highest average grades across your classes.</p>
            <ol style="margin-top:14px;padding-left:18px;line-height:1.7;">
                @forelse($topStudents as $student)
                    <li>{{ $student['name'] }} — {{ $student['grade'] }}%</li>
                @empty
                    <li>No grade records available yet.</li>
                @endforelse
            </ol>
        </div>
    </div>

    <div class="section-block" style="margin-top:24px;overflow-x:auto;">
        <h3 style="margin-bottom:14px;font-size:1.05rem;font-weight:700;">Class performance</h3>
        <table style="width:100%;border-collapse:collapse;min-width:640px;">
            <thead>
                <tr style="text-align:left;color:#0f172a;">
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Class</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Avg Grade</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Students</th>
                    <th style="padding:14px 12px;border-bottom:1px solid #e2e8f0;">Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courseGrades as $course)
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:14px 12px;">{{ $course['title'] }}</td>
                        <td style="padding:14px 12px;">{{ $course['avg_grade'] }}%</td>
                        <td style="padding:14px 12px;">{{ $course['students'] }}</td>
                        <td style="padding:14px 12px;">{{ $course['avg_grade'] >= 75 ? 'Good' : 'Improving' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-block" style="margin-top:24px;">
        <h3 style="margin-bottom:14px;font-size:1.05rem;font-weight:700;">Attendance trend</h3>
        <canvas id="attendanceTrendChart" width="840" height="320"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trendData = @json(array_map(fn($item) => $item['present'], $attendanceSummary['trend']));
        const trendLabels = @json(array_map(fn($item) => $item['day'], $attendanceSummary['trend']));
        const ctx = document.getElementById('attendanceTrendChart');

        if (ctx && trendData.length) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Present students',
                        data: trendData,
                        borderColor: '#3751ff',
                        backgroundColor: 'rgba(55,81,255,0.16)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3751ff',
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#475569' } },
                        y: { beginAtZero: true, ticks: { color: '#475569' }, grid: { color: 'rgba(148,163,184,0.2)' } }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    }
                }
            });
        }
    });
</script>
@endpush
