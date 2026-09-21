
<?php $__env->startSection('title', 'Academic Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Academic Management'); ?>
<?php $__env->startSection('subtitle', 'Controls school years, terms, sections, schedules, attendance, grades, and assessments.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Academic Management'); ?>
<?php ($purpose = 'Controls the academic structure such as school year, terms, sections, schedules, attendance, grades, and assessments.'); ?>
<?php ($items = [
	['label' => 'Classes / Sections', 'description' => 'Create and maintain class sections and their learner assignments.', 'route' => 'admin.sections.index', 'action' => 'admin.sections.create', 'action_label' => 'New section'],
	['label' => 'Class Schedule', 'description' => 'Review and manage class meeting schedules.', 'route' => 'admin.schedules.index', 'action' => 'admin.schedules.create', 'action_label' => 'New schedule'],
	['label' => 'School Year', 'description' => 'Configure the active school-year and institution academic settings.', 'route' => 'sias.admin.settings.section', 'parameters' => ['section' => 'academic-settings'], 'action' => 'sias.admin.settings.section', 'action_parameters' => ['section' => 'academic-settings'], 'action_label' => 'Open settings'],
	['label' => 'Semester / Term', 'description' => 'Configure term and grading-period values in Academic Settings.', 'route' => 'sias.admin.settings.section', 'parameters' => ['section' => 'academic-settings'], 'action' => 'sias.admin.settings.section', 'action_parameters' => ['section' => 'academic-settings'], 'action_label' => 'Open settings'],
	['label' => 'Attendance', 'description' => 'Record, review, edit, and remove attendance records.', 'route' => 'admin.attendance.index', 'action' => 'admin.attendance.create', 'action_label' => 'Record attendance'],
	['label' => 'Grades', 'description' => 'Create, review, update, and remove learner grades.', 'route' => 'admin.grades.index', 'action' => 'admin.grades.create', 'action_label' => 'Add grade'],
	['label' => 'Assessments', 'description' => 'Assessment administration is not yet registered as a standalone admin workspace.', 'route' => null, 'action' => null, 'action_label' => null],
]); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\academic-management\index.blade.php ENDPATH**/ ?>