

<?php $__env->startSection('title', 'Certificate - ' . ($course->title ?? $course->course_title) . ' - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<style>
	@media print {
		.no-print {
			display: none !important;
		}

		.print-area {
			box-shadow: none !important;
			border: 1px solid #d1d5db !important;
		}

		body {
			background: #fff !important;
		}
	}
</style>

<div class="max-w-5xl mx-auto px-4 py-10">
	<div class="no-print mb-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
		<a href="<?php echo e(route('courses.show', $course->slug)); ?>"
		   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
			<i class="fas fa-arrow-left mr-2"></i> Back to Course
		</a>

		<button type="button"
				onclick="window.print()"
				class="inline-flex items-center px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
			<i class="fas fa-print mr-2"></i> Print / Save PDF
		</button>
	</div>

	<div class="print-area relative overflow-hidden rounded-2xl border-8 border-amber-300 bg-linear-to-br from-amber-50 via-white to-indigo-50 shadow-2xl">
		<div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-amber-200/40 blur-2xl"></div>
		<div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full bg-indigo-200/40 blur-2xl"></div>

		<div class="relative z-10 p-8 md:p-14 text-center">
			<p class="uppercase tracking-[0.3em] text-xs sm:text-sm text-gray-600 font-semibold">SkillUp Learning Portal</p>
			<h1 class="mt-4 text-3xl sm:text-5xl font-extrabold text-gray-900">Certificate of Completion</h1>
			<p class="mt-5 text-gray-600 text-sm sm:text-base">This is proudly presented to</p>

			<h2 class="mt-3 text-3xl sm:text-4xl font-bold text-indigo-700 border-b-2 border-dashed border-indigo-300 inline-block pb-2 px-3">
				<?php echo e($user->name); ?>

			</h2>

			<p class="mt-6 text-gray-700 text-base sm:text-lg">
				for successfully completing all modules and quizzes in
			</p>

			<h3 class="mt-2 text-2xl sm:text-3xl font-semibold text-gray-900">
				<?php echo e($course->title ?? $course->course_title); ?>

			</h3>

			<div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
				<div class="bg-white/80 border border-gray-200 rounded-xl p-4">
					<p class="text-xs uppercase text-gray-500">Modules Completed</p>
					<p class="mt-1 text-xl font-bold text-green-700"><?php echo e($completedModules); ?>/<?php echo e($totalModules); ?></p>
				</div>
				<div class="bg-white/80 border border-gray-200 rounded-xl p-4">
					<p class="text-xs uppercase text-gray-500">Completion Date</p>
					<p class="mt-1 text-xl font-bold text-gray-900"><?php echo e($completionDate->format('M d, Y')); ?></p>
				</div>
				<div class="bg-white/80 border border-gray-200 rounded-xl p-4">
					<p class="text-xs uppercase text-gray-500">Certificate ID</p>
					<p class="mt-1 text-sm sm:text-base font-bold text-gray-900 break-all"><?php echo e($certificateCode); ?></p>
				</div>
			</div>

			<div class="mt-10 flex flex-col sm:flex-row justify-between items-center gap-8 text-left">
				<div>
					<p class="text-sm text-gray-500">Authorized by</p>
					<p class="mt-2 font-semibold text-gray-900">SkillUp Academic Team</p>
					<div class="mt-2 h-px w-52 bg-gray-400"></div>
				</div>

				<div class="text-center sm:text-right">
					<div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-600 text-white text-3xl shadow-lg">
						<i class="fas fa-certificate"></i>
					</div>
					<p class="mt-2 text-xs text-gray-500">Verified Digital Certificate</p>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        if (params.get('print') === '1') {
            window.print();
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\badge & certificate\certificate.blade.php ENDPATH**/ ?>