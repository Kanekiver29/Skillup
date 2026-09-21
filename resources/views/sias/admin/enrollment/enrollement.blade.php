@extends('sias.admin.layouts.master')

@section('title', 'Student Enrollment')
@section('page_title', 'Student Enrollment')
@section('subtitle', 'Overview of student subject assignments.')

@section('content')
<div class="admin-card">
    <div class="admin-actions" style="margin-top:0; margin-bottom:1.25rem;">
        <a href="{{ route('sias.admin.enrollment.add') }}" class="btn-black"><span data-i18n="add_subject">Add Subject</span></a>
        <a href="{{ route('sias.admin.enrollments') }}" class="btn-white"><span data-i18n="back_to_list">Back to List</span></a>
    </div>

    <div class="admin-grid">
        <div class="admin-panel">
            <h3 data-i18n="student">Student</h3>
            <p style="margin:0; font-size:1.2rem; font-weight:700;">John Dela Cruz</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);"><span data-i18n="student_id">Student ID</span>: 20260001</p>
        </div>
        <div class="admin-panel">
            <h3 data-i18n="courses">Courses</h3>
            <p style="margin:0; font-size:1.2rem; font-weight:700;">BSIT</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);"><span data-i18n="year_level_text">Year Level</span>: 4th Year</p>
        </div>
        <div class="admin-panel">
            <h3 data-i18n="status">Status</h3>
            <p style="margin:0; font-size:1.2rem; font-weight:700; color:#16a34a;" data-i18n="approved">Approved</p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">1st Semester</p>
        </div>
    </div>

    <div class="admin-panel" style="margin-top:1.5rem;">
        <h3 data-i18n="enrolled_subjects">Enrolled Subjects</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; margin-top:1rem;">
                <thead>
                    <tr style="border-bottom:1px solid var(--card-border);">
                        <th style="padding:.85rem .75rem; text-align:left;" data-i18n="subject">Subject</th>
                        <th style="padding:.85rem .75rem; text-align:left;" data-i18n="code">Code</th>
                        <th style="padding:.85rem .75rem; text-align:left;" data-i18n="units">Units</th>
                        <th style="padding:.85rem .75rem; text-align:left;" data-i18n="status">Status</th>
                        <th style="padding:.85rem .75rem; text-align:left;" data-i18n="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:.85rem .75rem;">IT 201 - Data Structures</td>
                        <td style="padding:.85rem .75rem;">IT201</td>
                        <td style="padding:.85rem .75rem;">3</td>
                        <td style="padding:.85rem .75rem; color:#16a34a; font-weight:700;" data-i18n="approved">Approved</td>
                        <td style="padding:.85rem .75rem;">
                            <a href="{{ route('sias.admin.enrollment.edit', 1) }}" class="btn-white" style="padding:.55rem .8rem; font-size:.85rem;" data-i18n="edit">Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:.85rem .75rem;">IT 301 - Database Systems</td>
                        <td style="padding:.85rem .75rem;">IT301</td>
                        <td style="padding:.85rem .75rem;">3</td>
                        <td style="padding:.85rem .75rem; color:#f59e0b; font-weight:700;" data-i18n="pending">Pending</td>
                        <td style="padding:.85rem .75rem;">
                            <a href="{{ route('sias.admin.enrollment.edit', 2) }}" class="btn-white" style="padding:.55rem .8rem; font-size:.85rem;" data-i18n="edit">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
