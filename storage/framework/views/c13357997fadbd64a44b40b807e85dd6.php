
<?php $__env->startSection('title', 'Learning Management | SIAS Admin'); ?>
<?php $__env->startSection('page_title', 'Learning Management'); ?>
<?php $__env->startSection('subtitle', 'Manages learning materials and activities such as lessons, quizzes, trivia, assignments, and exams.'); ?>
<?php $__env->startSection('content'); ?>
<?php ($title = 'Learning Management'); ?>
<?php ($purpose = 'Manages actual learning materials and activities such as lessons, quizzes, trivia, assignments, and exams.'); ?>
<?php ($items = ['Lessons / Modules', 'Quizzes', 'Trivia', 'Assignments', 'Midterm Exam', 'Final Exam']); ?>
<?php echo $__env->make('sias.admin.modules._workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\learning-management\index.blade.php ENDPATH**/ ?>