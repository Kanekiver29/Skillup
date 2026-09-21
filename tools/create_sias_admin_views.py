from pathlib import Path

base = Path(r'c:\xampp\htdocs\skillupv2\resources\views\sias\admin')

pages = {
    'dashboard.blade.php': (
        'Dashboard',
        'Overview of system statistics, recent activity, and admin quick actions.',
        '<div class="admin-grid"><div class="admin-panel"><h3>Recent activity</h3><p>View the latest enrollments, teacher assignments, and system alerts.</p></div><div class="admin-panel"><h3>Quick actions</h3><p>Add students, approve enrollments, or run reports from here.</p></div></div>'
    ),
    'students/index.blade.php': (
        'Student Management',
        'Add, edit, and delete student records.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/students/create\') }}">Add student</a></div>'
    ),
    'students/create.blade.php': (
        'Create Student',
        'Add a new student to the system.',
        ''
    ),
    'students/edit.blade.php': (
        'Edit Student',
        'Update a student profile and enrollment status.',
        ''
    ),
    'teachers/index.blade.php': (
        'Teacher Management',
        'Add and edit teachers, then assign them to subjects.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/teachers/create\') }}">Add teacher</a></div>'
    ),
    'teachers/create.blade.php': (
        'Create Teacher',
        'Create a new teacher account and assign subjects.',
        ''
    ),
    'teachers/edit.blade.php': (
        'Edit Teacher',
        'Update teacher profile and subject assignments.',
        ''
    ),
    'courses/index.blade.php': (
        'Course / Program Management',
        'Manage courses and programs available to students.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/courses/create\') }}">Add course</a></div>'
    ),
    'courses/create.blade.php': (
        'Create Course',
        'Add a new course or program to the school catalog.',
        ''
    ),
    'courses/edit.blade.php': (
        'Edit Course',
        'Update course details, description, and availability.',
        ''
    ),
    'subjects/index.blade.php': (
        'Subject Management',
        'Create and assign subjects to teachers.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/subjects/create\') }}">Add subject</a></div>'
    ),
    'subjects/create.blade.php': (
        'Create Subject',
        'Add a new subject to the curriculum.',
        ''
    ),
    'subjects/edit.blade.php': (
        'Edit Subject',
        'Update subject details and assignments.',
        ''
    ),
    'sections/index.blade.php': (
        'Section Management',
        'Create and manage sections for courses.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/sections/create\') }}">Add section</a></div>'
    ),
    'sections/create.blade.php': (
        'Create Section',
        'Create a new section and assign students.',
        ''
    ),
    'sections/edit.blade.php': (
        'Edit Section',
        'Update section details and capacity.',
        ''
    ),
    'schedules/index.blade.php': (
        'Schedule Management',
        'Build and manage course schedules.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/schedules/create\') }}">Create schedule</a></div>'
    ),
    'schedules/create.blade.php': (
        'Create Schedule',
        'Create a new schedule entry for classes.',
        ''
    ),
    'schedules/edit.blade.php': (
        'Edit Schedule',
        'Update an existing schedule.',
        ''
    ),
    'enrollments/index.blade.php': (
        'Enrollment Management',
        'Review and approve enrollments and manage student status.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/enrollments\') }}">Review enrollments</a></div>'
    ),
    'attendance/index.blade.php': (
        'Attendance Monitoring',
        'View attendance records and trends.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/attendance/create\') }}">Record attendance</a></div>'
    ),
    'attendance/create.blade.php': (
        'Record Attendance',
        'Log attendance for students and teachers.',
        ''
    ),
    'attendance/edit.blade.php': (
        'Edit Attendance',
        'Update recorded attendance entries.',
        ''
    ),
    'grades/index.blade.php': (
        'Grade Management',
        'Monitor and approve student grades.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/grades/create\') }}">Add grade</a></div>'
    ),
    'grades/create.blade.php': (
        'Add Grade',
        'Record a new grade entry for a student.',
        ''
    ),
    'grades/edit.blade.php': (
        'Edit Grade',
        'Update a grade record before approval.',
        ''
    ),
    'reports/index.blade.php': (
        'Reports',
        'Generate enrollment, attendance, and grade reports.',
        ''
    ),
    'announcements/index.blade.php': (
        'Announcements',
        'Create and manage announcements for students and staff.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/announcements/create\') }}">New announcement</a></div>'
    ),
    'announcements/create.blade.php': (
        'Create Announcement',
        'Publish a new announcement to the institution.',
        ''
    ),
    'announcements/edit.blade.php': (
        'Edit Announcement',
        'Update announcement content and scheduling.',
        ''
    ),
    'users/index.blade.php': (
        'User & Role Management',
        'Manage user accounts, administrators, and roles.',
        '<div class="admin-actions"><a href="{{ url(\'/admin/users/create\') }}">Add user</a></div>'
    ),
    'users/create.blade.php': (
        'Create User',
        'Create a new user account and assign the proper role.',
        ''
    ),
    'users/edit.blade.php': (
        'Edit User',
        'Update user details and roles.',
        ''
    ),
    'settings.blade.php': (
        'System Settings',
        'Configure system settings, notifications, and security.',
        ''
    ),
}


def render(title, description, actions):
    return f"""@extends('sias.admin.Layouts.master')\n\n@section('title', '{title}')\n@section('page_title', '{title}')\n\n@section('content')\n<div class='admin-card'>\n  <p>{description}</p>\n  {actions}\n</div>\n@endsection\n"""

base.mkdir(parents=True, exist_ok=True)
for rel, data in pages.items():
    path = base / rel
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(render(*data), encoding='utf-8')
print(f'Created {len(pages)} blade files under {base}')