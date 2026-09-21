@extends('teacher.layouts.master')

@section('title', 'Student Overview')
@section('page_title', 'Student Overview')

@section('content')
<div class="card" style="max-width: 1100px; margin: 0 auto; display:grid; gap:1.25rem;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
        <div>
            <h2 style="margin:0 0 .35rem; font-size:1.4rem;">{{ $enrollment->user->name ?? 'Student' }}</h2>
            <p style="margin:0; color:var(--muted);">
                {{ $enrollment->course->title ?? 'Course' }} · {{ $enrollment->status ?? 'Active' }}
            </p>
        </div>
        <a href="{{ route('teacher.students.index') }}" class="btn btn-outline" style="text-decoration:none;">Back to students</a>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1rem;">
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Progress</div>
            <div style="font-size:1.7rem; font-weight:700;">{{ (int) ($enrollment->progress ?? 0) }}%</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Status</div>
            <div style="font-size:1.1rem; font-weight:700;">{{ $enrollment->status ?? 'Active' }}</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Final grade</div>
            <div style="font-size:1.25rem; font-weight:700;">{{ is_numeric($enrollment->final_grade) ? $enrollment->final_grade.'%' : 'Not graded yet' }}</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Email</div>
            <div style="font-size:1rem; font-weight:600;">{{ $enrollment->user->email ?? '—' }}</div>
        </div>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin-top:0;">Learning snapshot</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">A simple teacher overview for this learner’s current enrollment.</p>
        <ul style="margin:0; padding-left:1.1rem; line-height:1.8;">
            <li>Course: {{ $enrollment->course->title ?? 'Course' }}</li>
            <li>Student: {{ $enrollment->user->name ?? 'Student' }}</li>
            <li>Current progress: {{ (int) ($enrollment->progress ?? 0) }}%</li>
            <li>Enrollment status: {{ $enrollment->status ?? 'Active' }}</li>
        </ul>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:.8rem;">
            <div>
                <h3 style="margin:0 0 .25rem;">Activity and progress monitoring</h3>
                <p style="margin:0; color:var(--muted);">Recent learning actions and lesson completion for this enrollment.</p>
            </div>
            <div style="font-size:.85rem; color:var(--muted);">
                {{ $lessonProgress->where('completed', true)->count() }} of {{ $lessonProgress->count() }} lessons completed
            </div>
        </div>

        @if($recentActivity->isEmpty())
            <p style="margin:0; color:var(--muted);">No learning activity has been recorded yet.</p>
        @else
            <div style="display:grid; gap:.55rem;">
                @foreach($recentActivity as $activity)
                    <div style="display:flex; align-items:center; gap:.8rem; padding:.75rem; border:1px solid #e4eaf7; border-radius:.7rem; background:#f8fafc;">
                        <span style="width:34px; height:34px; display:grid; place-items:center; border-radius:50%; background:{{ $activity['type'] === 'Quiz' ? '#fff4d6' : '#e7efff' }}; color:{{ $activity['type'] === 'Quiz' ? '#a16207' : '#315bd6' }}; font-size:.72rem; font-weight:800;">{{ strtoupper(substr($activity['type'], 0, 1)) }}</span>
                        <div style="min-width:0; flex:1;">
                            <strong style="display:block;">{{ $activity['title'] }}</strong>
                            <span style="color:var(--muted); font-size:.8rem;">{{ $activity['detail'] }} · {{ $activity['date']->format('M j, Y g:i A') }}</span>
                        </div>
                        @if($activity['score'] !== null)
                            <strong style="color:#315bd6;">{{ $activity['score'] }}%</strong>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Lesson progress</h3>
        @if($lessonProgress->isEmpty())
            <p style="margin:0; color:var(--muted);">No lesson progress records found for this enrollment.</p>
        @else
            <div style="display:grid; gap:.65rem;">
                @foreach($lessonProgress as $lesson)
                    <div style="display:grid; grid-template-columns:minmax(0, 1fr) auto; gap:.7rem; align-items:center;">
                        <div>
                            <strong>{{ $lesson->lesson?->title ?? 'Lesson' }}</strong>
                            <div style="height:7px; margin-top:.35rem; background:#e6ebf5; border-radius:99px; overflow:hidden;">
                                <span style="display:block; width:{{ $lesson->completed ? 100 : 50 }}%; height:100%; background:{{ $lesson->completed ? '#16a34a' : '#315bd6' }}; border-radius:inherit;"></span>
                            </div>
                        </div>
                        <span style="font-size:.82rem; font-weight:800; color:{{ $lesson->completed ? '#15803d' : '#315bd6' }};">{{ $lesson->completed ? 'Completed' : 'In progress' }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Add student grade</h3>
        <form method="POST" action="{{ route('teacher.grades.store') }}" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:.75rem; align-items:end;">
            @csrf
            <input type="hidden" name="student_id" value="{{ $enrollment->user_id }}">
            <input type="hidden" name="course_id" value="{{ $enrollment->course_id }}">
            <select name="assessment_type" required style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
                <option value="activity">Activity</option>
                <option value="assignment">Assignment</option>
                <option value="exam" selected>Exam</option>
                <option value="module">Module</option>
            </select>
            <input name="title" required placeholder="Assessment title" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="score" type="number" min="0" step="0.01" required placeholder="Score" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="max_score" type="number" min="0.01" step="0.01" required value="100" placeholder="Max" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <input name="remarks" placeholder="Remarks" style="padding:.7rem;border:1px solid #dfe7f5;border-radius:.6rem;">
            <button type="submit" style="padding:.8rem 1rem;border:0;border-radius:.6rem;background:#315bd6;color:#fff;font-weight:800;">Save grade</button>
        </form>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin:0 0 .8rem;">Existing grades</h3>
        @if($gradeRecords->isEmpty())
            <p style="margin:0; color:var(--muted);">No grades recorded for this student yet.</p>
        @else
            <div style="display:grid; gap:.8rem;">
                @foreach($gradeRecords as $grade)
                    <div style="border:1px solid #e4eaf7;border-radius:.8rem;padding:.9rem;background:#f8fafc;display:grid;gap:.7rem;">
                        <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;align-items:center;">
                            <div>
                                <strong>{{ $grade->title }}</strong>
                                <div style="color:var(--muted); font-size:.8rem;">{{ ucfirst($grade->assessment_type) }}</div>
                            </div>
                            <div style="font-weight:800;color:#315bd6;">{{ $grade->percentage }}%</div>
                        </div>
                        <form method="POST" action="{{ route('teacher.grades.update', $grade) }}" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap:.6rem; align-items:end;">
                            @csrf
                            @method('PATCH')
                            <input name="score" type="number" min="0" step="0.01" value="{{ $grade->score }}" required style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <input name="max_score" type="number" min="0.01" step="0.01" value="{{ $grade->max_score }}" required style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <input name="remarks" value="{{ $grade->remarks }}" placeholder="Remarks" style="padding:.6rem;border:1px solid #dfe7f5;border-radius:.5rem;">
                            <button type="submit" style="padding:.65rem .8rem;border:0;border-radius:.5rem;background:#1f2937;color:#fff;font-weight:700;">Update</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
