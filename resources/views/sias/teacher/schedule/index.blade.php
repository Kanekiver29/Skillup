@extends('sias.teacher.layout.layout')

@section('title', 'Class Schedule')
@section('page_title', 'My Class Schedule')

@section('content')
<style>
    .schedule-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .schedule-header h2 {
        margin: 0 0 15px 0;
        font-size: 28px;
    }

    .schedule-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .stat {
        background: rgba(255,255,255,0.1);
        padding: 12px 15px;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        opacity: 0.9;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin: 30px 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title i {
        color: #667eea;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .btn-danger {
        background: #ff6b6b;
        color: white;
        padding: 8px 12px;
        font-size: 12px;
    }

    .btn-danger:hover {
        background: #ff5252;
    }

    .btn-info {
        background: #3b82f6;
        color: white;
        padding: 8px 12px;
        font-size: 12px;
    }

    .btn-info:hover {
        background: #2563eb;
    }

    .weekly-schedule {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .day-column {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .day-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        font-weight: 700;
        font-size: 14px;
    }

    .day-body {
        padding: 15px;
        min-height: 100px;
    }

    .day-empty {
        color: #999;
        font-size: 13px;
        text-align: center;
        padding: 30px 15px;
    }

    .class-item {
        background: white;
        border: 1px solid #e0e0e0;
        border-left: 4px solid #667eea;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .class-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .class-item.inactive {
        opacity: 0.6;
        border-left-color: #ccc;
        background: #f9f9f9;
    }

    .class-time {
        font-size: 12px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 3px;
    }

    .class-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        font-size: 13px;
    }

    .class-room {
        font-size: 11px;
        color: #999;
        margin-bottom: 3px;
    }

    .class-students {
        font-size: 11px;
        color: #999;
        margin-bottom: 8px;
    }

    .class-actions {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .class-actions form {
        display: inline;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #666;
        margin: 10px 0;
    }

    .empty-state p {
        margin: 0 0 20px 0;
    }

    .table-view {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f5f5f5;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
        font-size: 13px;
    }

    td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }

    tr:hover {
        background: #f9f9f9;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .view-toggle {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .view-btn {
        padding: 8px 16px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .view-btn.active {
        border-color: #667eea;
        color: #667eea;
        background: #f0f0ff;
    }

    .view-btn:hover {
        border-color: #667eea;
    }

    @media (max-width: 768px) {
        .weekly-schedule {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Header -->
<div class="schedule-header">
    <h2>📅 My Class Schedule</h2>
    <div class="schedule-stats">
        <div class="stat">
            <span class="stat-value">{{ $totalClasses }}</span>
            <span class="stat-label">Total Classes</span>
        </div>
        <div class="stat">
            <span class="stat-value">{{ $activeClasses }}</span>
            <span class="stat-label">Active Classes</span>
        </div>
        <div class="stat">
            <span class="stat-value">{{ $totalStudents }}</span>
            <span class="stat-label">Total Students</span>
        </div>
        <div class="stat">
            <span class="stat-value">{{ $hoursPerWeek }}h</span>
            <span class="stat-label">Hours/Week</span>
        </div>
    </div>
</div>

<!-- Alerts -->
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Action Buttons -->
<div class="action-buttons">
    <a href="{{ route('sias.teacher.schedule.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Class
    </a>
</div>

<!-- View Toggle -->
<div class="view-toggle">
    <button class="view-btn active" onclick="showWeeklyView()">
        <i class="fas fa-calendar-week"></i> Weekly View
    </button>
    <button class="view-btn" onclick="showTableView()">
        <i class="fas fa-table"></i> List View
    </button>
</div>

<!-- Weekly View -->
<div id="weeklyView">
    @if ($schedules->count() > 0)
        <div class="weekly-schedule">
            @foreach ($days as $day)
                <div class="day-column">
                    <div class="day-header">{{ $day }}</div>
                    <div class="day-body">
                        @if ($schedulesByDay[$day]->count() > 0)
                            @foreach ($schedulesByDay[$day] as $schedule)
                                <div class="class-item {{ !$schedule->is_active ? 'inactive' : '' }}">
                                    <div class="class-time">
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - 
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                    </div>
                                    <div class="class-name">{{ $schedule->subject_name }}</div>
                                    @if ($schedule->room_number || $schedule->building)
                                        <div class="class-room">
                                            <i class="fas fa-door-open"></i> 
                                            {{ $schedule->room_number }}@if($schedule->building) - {{ $schedule->building }} @endif
                                        </div>
                                    @endif
                                    @if ($schedule->student_count > 0)
                                        <div class="class-students">
                                            <i class="fas fa-users"></i> {{ $schedule->student_count }} students
                                        </div>
                                    @endif
                                    <div class="class-actions">
                                        <a href="{{ route('sias.teacher.schedule.edit', $schedule) }}" class="btn btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('sias.teacher.schedule.toggle', $schedule) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-{{ $schedule->is_active ? 'pause' : 'play' }}"></i> {{ $schedule->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('sias.teacher.schedule.destroy', $schedule) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="day-empty">No classes</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-calendar"></i>
            <h3>No Schedule Yet</h3>
            <p>Create your first class schedule to get started.</p>
            <a href="{{ route('sias.teacher.schedule.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Your First Class
            </a>
        </div>
    @endif
</div>

<!-- Table View -->
<div id="tableView" style="display: none;">
    @if ($schedules->count() > 0)
        <div class="table-view">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Students</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td><strong>{{ $schedule->subject_name }}</strong></td>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}
                                </td>
                                <td>
                                    @if ($schedule->room_number)
                                        {{ $schedule->room_number }}
                                        @if ($schedule->building) ({{ $schedule->building }}) @endif
                                    @else
                                        <span style="color: #999;">—</span>
                                    @endif
                                </td>
                                <td>{{ $schedule->student_count ?? 0 }}</td>
                                <td>
                                    @if ($schedule->course)
                                        {{ Str::limit($schedule->course->title, 30) }}
                                    @else
                                        <span style="color: #999;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $schedule->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                        <a href="{{ route('sias.teacher.schedule.edit', $schedule) }}" class="btn btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('sias.teacher.schedule.destroy', $schedule) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    function showWeeklyView() {
        document.getElementById('weeklyView').style.display = 'block';
        document.getElementById('tableView').style.display = 'none';
        document.querySelectorAll('.view-btn')[0].classList.add('active');
        document.querySelectorAll('.view-btn')[1].classList.remove('active');
    }

    function showTableView() {
        document.getElementById('weeklyView').style.display = 'none';
        document.getElementById('tableView').style.display = 'block';
        document.querySelectorAll('.view-btn')[0].classList.remove('active');
        document.querySelectorAll('.view-btn')[1].classList.add('active');
    }
</script>

@endsection
