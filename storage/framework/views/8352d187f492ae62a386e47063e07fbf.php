

<?php $__env->startSection('content'); ?>
<div class="px-6 py-6 space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Teacher Management</h1>
            <p class="text-sm text-slate-600">Create, review, and manage teacher accounts from one place.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="#teacher-create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500 transition">Create Teacher</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <p class="text-xs uppercase tracking-wide text-slate-600">Total Teachers</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900"><?php echo e(number_format($stats['total'] ?? 0)); ?></p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <p class="text-xs uppercase tracking-wide text-slate-600">Teachers</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900"><?php echo e(number_format($stats['teachers'] ?? 0)); ?></p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <p class="text-xs uppercase tracking-wide text-slate-600">Instructors</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900"><?php echo e(number_format($stats['instructors'] ?? 0)); ?></p>
        </div>
    </div>

    <div id="teacher-create" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <h2 class="text-lg font-semibold text-slate-900">Add Teacher</h2>
        <form method="POST" action="<?php echo e(route('admin.teachers.store')); ?>" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-1">Promote existing user</label>
                <select name="user_id" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                    <option value="">Create a new teacher account</option>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?> — <?php echo e($student->email); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-1">Teacher name</label>
                <input type="text" name="name" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Enter teacher name">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-1">Teacher email</label>
                <input type="email" name="email" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="teacher@example.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Min 8 characters">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-500 transition">Save Teacher</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Teacher List</h2>
        </div>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Role</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-5 py-4 text-sm font-medium text-slate-900"><?php echo e($teacher->name); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-600"><?php echo e($teacher->email); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-600"><?php echo e($teacher->staff_type ?? 'teacher'); ?></td>
                        <td class="px-5 py-4 text-right">
                            <form action="<?php echo e(route('admin.teachers.demote', $teacher)); ?>" method="POST" onsubmit="return confirm('Remove this user from teacher management?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-600">No teacher accounts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="px-5 py-4"><?php echo e($teachers->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Admin/teachers/index.blade.php ENDPATH**/ ?>