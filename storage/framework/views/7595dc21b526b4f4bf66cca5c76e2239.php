

<?php $__env->startSection('title', 'Help & Documentation - SkillUp Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">

    
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Help & Documentation</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">Help</span>
                </nav>
            </div>
            <div class="p-3 bg-cyan-100 rounded-lg">
                <i class="fas fa-question-circle text-cyan-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        
        <div class="bg-gradient-to-rfrom-blue-800 to-blue-900 rounded-xl p-8 mb-10 text-white text-center">
            <h2 class="text-2xl font-bold mb-2">How can we help you?</h2>
            <p class="text-blue-200 mb-6">Browse the sections below or search for a topic.</p>
            <div class="relative max-w-md mx-auto">
                <input type="text" id="help-search" placeholder="Search topics..."
                    class="w-full h-11 pl-5 pr-12 rounded-lg text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <a href="#getting-started"
                class="flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-lg p-5 text-center hover:border-cyan-400 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-cyan-100 rounded-full flex items-center justify-center group-hover:bg-cyan-500 transition">
                    <i class="fas fa-rocket text-cyan-600 group-hover:text-white transition"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-cyan-600 transition">Getting Started</span>
            </a>
            <a href="#users"
                class="flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-lg p-5 text-center hover:border-cyan-400 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-500 transition">
                    <i class="fas fa-users text-blue-600 group-hover:text-white transition"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition">User Management</span>
            </a>
            <a href="#courses"
                class="flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-lg p-5 text-center hover:border-cyan-400 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-500 transition">
                    <i class="fas fa-book-open text-purple-600 group-hover:text-white transition"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600 transition">Courses & Modules</span>
            </a>
            <a href="#settings"
                class="flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-lg p-5 text-center hover:border-cyan-400 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition">
                    <i class="fas fa-cog text-green-600 group-hover:text-white transition"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-green-600 transition">Settings</span>
            </a>
        </div>

        
        <section id="getting-started" class="scroll-mt-24 mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rocket text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Getting Started</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 1 ? null : 1"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">What is the Admin Dashboard?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 1 }"></i>
                    </button>
                    <div x-show="open === 1" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        The Admin Dashboard is the central control panel for managing SkillUp. From here you can monitor
                        platform statistics, manage users and courses, handle enrollments, review reports, and configure
                        system settings.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 2 ? null : 2"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I navigate between sections?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 2 }"></i>
                    </button>
                    <div x-show="open === 2" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Use the sidebar on the left to navigate between Dashboard, User Management, Courses, Modules,
                        Enrollments, Messages, Reports, Settings, and Archive. On mobile devices, tap the hamburger icon
                        in the top-right corner to open the slide-over menu.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 3 ? null : 3"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">What are the different admin roles?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 3 }"></i>
                    </button>
                    <div x-show="open === 3" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        <ul class="space-y-2">
                            <li><strong>Super Admin:</strong> Full access to all features including user management, system settings, reports, and database overview.</li>
                            <li><strong>Staff Admin:</strong> Access to courses, modules, enrollments, and messages. Cannot modify system settings or manage admin accounts.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </section>

        
        <section id="users" class="scroll-mt-24 mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">User Management</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 4 ? null : 4"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I view and edit user accounts?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 4 }"></i>
                    </button>
                    <div x-show="open === 4" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Navigate to <strong>User Management</strong> in the sidebar. Use the search and filter tools to locate a user,
                        then click the edit icon to modify their profile, role, or status.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 5 ? null : 5"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I archive or delete a user?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 5 }"></i>
                    </button>
                    <div x-show="open === 5" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        In User Management, click the delete button next to a user to soft-delete (archive) their account.
                        Archived users can be restored from the <strong>Archive</strong> section. A permanent force-delete is also
                        available from the archive view but cannot be undone.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 6 ? null : 6"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I promote a user to Admin or Staff?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 6 }"></i>
                    </button>
                    <div x-show="open === 6" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Go to <strong>Admin Accounts</strong> to grant or remove Super Admin privileges. Use <strong>Staff Admin</strong>
                        to manage staff-level access. Only a Super Admin can change these roles.
                    </div>
                </div>

            </div>
        </section>

        
        <section id="courses" class="scroll-mt-24 mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Courses & Modules</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 7 ? null : 7"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I create a new course?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 7 }"></i>
                    </button>
                    <div x-show="open === 7" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Navigate to <strong>Courses</strong> in the sidebar and click <strong>Create Course</strong>. Fill in the
                        course title, description, instructor, and thumbnail image. Once saved, you can add modules and lessons to the course.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 8 ? null : 8"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do modules and lessons work?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 8 }"></i>
                    </button>
                    <div x-show="open === 8" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Each course is divided into <strong>Modules</strong>. Each module contains individual <strong>Lessons</strong>
                        and optionally a <strong>Quiz</strong>. Manage modules via the Modules section; lessons are managed within
                        each module's edit view.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 9 ? null : 9"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I manage enrollments?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 9 }"></i>
                    </button>
                    <div x-show="open === 9" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        The <strong>Enrollments</strong> section shows all student course enrollments with progress and status.
                        You can view details, filter by course or status, and monitor learner progress from this view.
                    </div>
                </div>

            </div>
        </section>

        
        <section id="settings" class="scroll-mt-24 mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Settings & Maintenance</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 10 ? null : 10"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I configure general platform settings?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 10 }"></i>
                    </button>
                    <div x-show="open === 10" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        Go to <strong>Settings</strong> in the sidebar. The General tab lets you change the site name,
                        tagline, and contact email. The Email tab configures outgoing mail. Security settings manage
                        password policies and session lengths.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 11 ? null : 11"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I clear the application cache?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 11 }"></i>
                    </button>
                    <div x-show="open === 11" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        In <strong>Settings &rarr; Maintenance</strong>, click the <strong>Clear Cache</strong> button.
                        This flushes the application, config, and route caches which can resolve issues with stale data.
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = open === 12 ? null : 12"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-800">How do I enable maintenance mode?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"
                           :class="{ 'rotate-180': open === 12 }"></i>
                    </button>
                    <div x-show="open === 12" x-collapse class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        In <strong>Settings &rarr; Maintenance</strong>, toggle the <strong>Maintenance Mode</strong> switch.
                        While active, regular users will see a maintenance page. Admin users can still access the panel normally.
                    </div>
                </div>

            </div>
        </section>

        
        <div class="bg-cyan-50 border border-cyan-200 rounded-xl p-6 text-center">
            <div class="w-14 h-14 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-headset text-cyan-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Still need help?</h3>
            <p class="text-gray-600 text-sm mb-4">Contact the development team or view the full documentation.</p>
            <a href="<?php echo e(route('admin.chats.index')); ?>"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition">
                <i class="fas fa-comment-alt"></i> Open Support Chat
            </a>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Simple client-side search highlight
    document.getElementById('help-search')?.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('section button span.font-medium').forEach(function (el) {
            const text = el.textContent.toLowerCase();
            el.closest('.bg-white').style.display = (!query || text.includes(query)) ? '' : 'none';
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\Legal\help.blade.php ENDPATH**/ ?>