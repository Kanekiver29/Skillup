@php
    $modules = [
        'audit-logs' => ['title' => 'Audit Logs', 'purpose' => 'Review important actions performed by users for security, accountability, and troubleshooting.', 'items' => ['Recent activity', 'User filters', 'Export audit report']],
        'grades' => ['title' => 'Grades', 'purpose' => 'Manage grade records and review academic performance across students, subjects, and terms.', 'items' => ['Grade records', 'Term filters', 'Assessment summary']],
        'attendance' => ['title' => 'Attendance', 'purpose' => 'Monitor attendance records by class, subject, student, and academic period.', 'items' => ['Attendance overview', 'Class filters', 'Absence report']],
        'announcements' => ['title' => 'Announcements', 'purpose' => 'Publish important school announcements for teachers, students, and staff.', 'items' => ['Published announcements', 'Drafts', 'Create announcement']],
        'schedules' => ['title' => 'Schedules', 'purpose' => 'Coordinate classes, subjects, teachers, rooms, and teaching loads in one place.', 'items' => ['Class schedule', 'Teaching load', 'Subject schedule']],
    ];
    $current = $modules[$module] ?? [
        'title' => str($module)->replace('-', ' ')->title(),
        'purpose' => 'Manage this SIAS administration area and review its related records.',
        'items' => ['Overview', 'Records', 'Reports'],
    ];
@endphp

@extends('sias.admin.layouts.master')

@section('title', $current['title'] . ' | SIAS Admin')
@section('page_title', $current['title'])
@section('subtitle', $current['purpose'])

@section('content')
<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
    @foreach($current['items'] as $index => $item)
        <section class="admin-panel" style="--i: {{ $index }};">
            <p style="margin:0 0 .5rem; color:var(--text-muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.08em;">SIAS Admin</p>
            <h3 style="margin:0 0 .65rem;">{{ $item }}</h3>
            <p style="margin:0; color:var(--text-muted);">This workspace is ready for {{ strtolower($item) }} management.</p>
        </section>
    @endforeach
</div>

<section class="admin-card" style="margin-top:1rem;">
    <h3 style="margin-top:0;">{{ $current['title'] }} workspace</h3>
    <p style="margin-bottom:0; color:var(--text-muted);">{{ $current['purpose'] }}</p>
</section>
@endsection
