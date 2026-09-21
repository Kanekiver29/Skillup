@extends('sias.admin.layouts.master')
@section('title', 'Academic Management | SIAS Admin')
@section('page_title', 'Academic Management')
@section('subtitle', 'Controls school years, terms, sections, schedules, attendance, grades, and assessments.')
@section('content')
@php($title = 'Academic Management')
@php($purpose = 'Controls the academic structure such as school year, terms, sections, schedules, attendance, grades, and assessments.')
@php($items = [
	['label' => 'Classes / Sections', 'description' => 'Create and maintain class sections and their learner assignments.', 'route' => 'admin.sections.index', 'action' => 'admin.sections.create', 'action_label' => 'New section'],
	['label' => 'Class Schedule', 'description' => 'Review and manage class meeting schedules.', 'route' => 'admin.schedules.index', 'action' => 'admin.schedules.create', 'action_label' => 'New schedule'],
	['label' => 'School Year', 'description' => 'Configure the active school-year and institution academic settings.', 'route' => 'sias.admin.settings.section', 'parameters' => ['section' => 'academic-settings'], 'action' => 'sias.admin.settings.section', 'action_parameters' => ['section' => 'academic-settings'], 'action_label' => 'Open settings'],
	['label' => 'Semester / Term', 'description' => 'Configure term and grading-period values in Academic Settings.', 'route' => 'sias.admin.settings.section', 'parameters' => ['section' => 'academic-settings'], 'action' => 'sias.admin.settings.section', 'action_parameters' => ['section' => 'academic-settings'], 'action_label' => 'Open settings'],
	['label' => 'Attendance', 'description' => 'Record, review, edit, and remove attendance records.', 'route' => 'admin.attendance.index', 'action' => 'admin.attendance.create', 'action_label' => 'Record attendance'],
	['label' => 'Grades', 'description' => 'Create, review, update, and remove learner grades.', 'route' => 'admin.grades.index', 'action' => 'admin.grades.create', 'action_label' => 'Add grade'],
	['label' => 'Assessments', 'description' => 'Assessment administration is not yet registered as a standalone admin workspace.', 'route' => null, 'action' => null, 'action_label' => null],
])
@include('sias.admin.modules._workspace')
@endsection
