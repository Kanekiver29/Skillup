@extends('sias.admin.layouts.master')

@section('title', 'Courses')
@section('page_title', 'Course Management')

@section('content')
<div class="page-card" style="padding:1.5rem;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h2 style="margin:0;font-size:2rem;letter-spacing:-.02em;">All Courses</h2>
            <p style="margin:.5rem 0 0;color:var(--text-muted);">Browse and manage all courses in the system</p>
        </div>
        <a href="{{ route('sias.admin.course.add') }}" style="display:inline-flex;align-items:center;gap:.6rem;padding:.85rem 1.2rem;background:#1d4ed8;color:#fff;border-radius:14px;text-decoration:none;font-weight:700;transition:all .2s ease;"><i class="fa-solid fa-plus"></i> New Course</a>
    </div>

    <div style="display:grid;gap:1rem;margin-bottom:2rem;">
        <input type="text" id="courseSearch" placeholder="Search courses by name or code..." style="width:100%;padding:.75rem 1rem;border:1px solid var(--block-border);border-radius:10px;background:var(--card-bg);color:var(--text);font-size:.95rem;" />
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid var(--divider);">
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;">Course Name</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;">Code</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;">Department</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;">Subjects</th>
                    <th style="text-align:center;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr style="border-bottom:1px solid var(--block-border);transition:background .2s ease;">
                        <td style="padding:1rem;"><strong>{{ $course->title }}</strong></td>
                        <td style="padding:1rem;color:var(--text-muted);">{{ $course->code }}</td>
                        <td style="padding:1rem;color:var(--text-muted);">{{ $course->department }}</td>
                        <td style="padding:1rem;"><span style="display:inline-block;background:rgba(29,78,216,.1);color:#1d4ed8;padding:.35rem .75rem;border-radius:6px;font-size:.85rem;font-weight:600;">{{ $course->subjects_count ?? 0 }}</span></td>
                        <td style="padding:1rem;text-align:center;">
                            <div style="display:flex;gap:.5rem;justify-content:center;">
                                <a href="{{ route('sias.admin.course.edit', $course->id) }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(29,78,216,.1);color:#1d4ed8;text-decoration:none;transition:all .2s ease;font-size:.85rem;" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="{{ route('sias.admin.course.delete', $course->id) }}" style="display:inline;" onsubmit="return confirm('Delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(220,38,38,.1);color:#dc2626;border:none;cursor:pointer;transition:all .2s ease;font-size:.85rem;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:2rem;text-align:center;color:var(--text-muted);">
                            <i class="fa-solid fa-inbox" style="font-size:2rem;margin-bottom:.5rem;display:block;opacity:.5;"></i>
                            No courses found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('courseSearch').addEventListener('keyup', function(e) {
        const filter = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
