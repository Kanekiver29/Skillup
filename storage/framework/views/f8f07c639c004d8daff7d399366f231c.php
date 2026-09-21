

<?php $__env->startSection('title', 'Staff Dashboard - SkillUp'); ?>

<?php $__env->startPush('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/staff-admin.css')); ?>">
    <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <script>document.addEventListener('DOMContentLoaded', () => { if (window.feather) feather.replace(); });</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <header data-admin-animate class="admin-page-hero p-6 md:p-8 text-white admin-page-hero">
        <div class="relative z-[2] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-sky-200 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 admin-live-dot"></span>
                    Instructor workspace
                </span>
                <h1 class="text-2xl md:text-3xl font-bold">Staff dashboard</h1>
                <p class="text-slate-300 text-sm mt-1">Welcome back, <span class="font-semibold text-white"><?php echo e(auth()->user()->name); ?></span></p>
                <?php $staffType = \App\Models\User::STAFF_TYPES[auth()->user()->staff_type] ?? null; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($staffType): ?>
                    <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold text-sky-100 border border-white/20">
                        <i class="<?php echo e($staffType['icon']); ?> mr-1.5"></i><?php echo e($staffType['label']); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="text-left sm:text-right rounded-xl bg-white/6 border border-white/8 px-4 py-3 backdrop-blur-sm last-updated-box">
                <p class="text-xs text-slate-300">Last updated</p>
                <p class="text-sm font-semibold text-cyan-300 tabular-nums" id="last-updated"><?php echo e(now()->format('M d, Y - h:i A')); ?></p>
            </div>
        </div>
    </header>

    <div class="space-y-6">
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div data-admin-animate class="admin-delay-1 staff-action-card admin-card p-6 text-center rounded-xl bg-[#071726] border border-[#0e2a3b] text-white"
                 onclick="document.getElementById('create-modal').classList.remove('hidden')">
                <div class="staff-icon w-12 h-12 mx-auto mb-3 rounded-2xl flex items-center justify-center text-white shadow-lg gradient-teal">
                    <i class="fas fa-pen text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-1">Create</h3>
                <p class="text-slate-400 text-xs">New course or module</p>
            </div>

            <div data-admin-animate class="admin-delay-2 staff-action-card admin-card p-6 text-center rounded-xl bg-[#071726] border border-[#0e2a3b] text-white"
                 onclick="window.location.href='<?php echo e(route('admin.modules.index')); ?>'">
                <div class="staff-icon w-12 h-12 mx-auto mb-3 rounded-2xl flex items-center justify-center text-white shadow-lg green">
                    <i class="fas fa-cubes text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-1">Modules</h3>
                <p class="text-slate-400 text-xs">Manage course modules</p>
            </div>

            <div data-admin-animate class="admin-delay-3 staff-action-card admin-card p-6 text-center rounded-xl bg-[#071726] border border-[#0e2a3b] text-white"
                 onclick="window.location.href='<?php echo e(route('admin.courses.index')); ?>'">
                <div class="staff-icon w-12 h-12 mx-auto mb-3 rounded-2xl flex items-center justify-center text-white shadow-lg orange">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-1">Courses</h3>
                <p class="text-slate-400 text-xs">Manage all courses</p>
            </div>

            <div data-admin-animate class="admin-delay-4 staff-action-card admin-card p-6 text-center rounded-xl bg-[#071726] border border-[#0e2a3b] text-white"
                 onclick="document.getElementById('file-input').click()">
                <div class="staff-icon w-12 h-12 mx-auto mb-3 rounded-2xl flex items-center justify-center text-white shadow-lg purple">
                    <i class="fas fa-cloud-upload-alt text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-1">Upload</h3>
                <p class="text-slate-400 text-xs">Upload course content</p>
            </div>
            <input type="file" id="file-input" class="hidden" multiple accept=".pdf,.ppt,.pptx,.xlsx,.xls,.doc,.docx,.jpg,.jpeg,.png,.mp4,.avi,.mov" onchange="handleFileUpload(event)">
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div data-admin-animate class="admin-stat-card p-5 bg-[#071726] text-white rounded-xl border border-[#0e2a3b]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-300">Active courses</h3>
                    <div class="p-2 bg-[#052433] rounded-xl"><i class="fas fa-book text-cyan-300"></i></div>
                </div>
                <p class="text-3xl font-bold text-cyan-300" data-admin-count="<?php echo e($activeCourses); ?>"><?php echo e($activeCourses); ?></p>
                <p class="text-xs text-slate-400 mt-1">Total courses</p>
            </div>

            <div data-admin-animate class="admin-delay-1 admin-stat-card p-5 bg-[#071726] text-white rounded-xl border border-[#0e2a3b]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-300">Enrollments</h3>
                    <div class="p-2 bg-[#063026] rounded-xl"><i class="fas fa-users text-emerald-400"></i></div>
                </div>
                <p class="text-3xl font-bold text-cyan-300" data-admin-count="<?php echo e($enrollmentCount); ?>"><?php echo e($enrollmentCount); ?></p>
                <p class="text-xs text-slate-400 mt-1">Active enrollments</p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($newEnrollmentsToday)): ?>
                    <p class="text-xs text-emerald-400 mt-1 font-semibold">+<?php echo e($newEnrollmentsToday); ?> today</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div data-admin-animate class="admin-delay-2 admin-stat-card p-5 bg-[#071726] text-white rounded-xl border border-[#0e2a3b]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-300">Badges earned</h3>
                    <div class="p-2 bg-[#3a2a0a] rounded-xl"><i class="fas fa-medal text-amber-400"></i></div>
                </div>
                <p class="text-3xl font-bold text-cyan-300" data-admin-count="<?php echo e($badges); ?>"><?php echo e($badges); ?></p>
                <p class="text-xs text-slate-400 mt-1">Achievement badges</p>
            </div>

            <div data-admin-animate class="admin-delay-3 admin-stat-card p-5 bg-[#071726] text-white rounded-xl border border-[#0e2a3b]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-300">Overall progress</h3>
                    <div class="p-2 bg-[#2a1f3f] rounded-xl"><i class="fas fa-chart-pie text-indigo-400"></i></div>
                </div>
                <p class="text-3xl font-bold text-cyan-300"><?php echo e($progress); ?>%</p>
                <div class="w-full bg-[#0b1620] rounded-full h-2 mt-3 overflow-hidden">
                    <div class="staff-progress-bar h-2 rounded-full progress-fill-gradient" style="width: <?php echo e($progress); ?>%;"></div>
                </div>
            </div>
        </section>

        <!-- Staff Report Summary -->
        <section class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#071726] text-white rounded-lg shadow border border-[#0e2a3b] p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-slate-300">Total Modules</h3>
                        <div class="p-2 bg-[#052433] rounded-lg">
                            <i class="fas fa-layer-group text-cyan-300"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-cyan-300"><?php echo e($totalModules); ?></div>
                    <p class="text-xs text-slate-400 mt-2">Modules currently available</p>
                </div>
                <div class="bg-[#071726] text-white rounded-lg shadow border border-[#0e2a3b] p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-slate-300">Total Lessons</h3>
                        <div class="p-2 bg-[#1b2540] rounded-lg">
                            <i class="fas fa-book-reader text-indigo-400"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-cyan-300"><?php echo e($totalLessons); ?></div>
                    <p class="text-xs text-slate-400 mt-2">Lessons across all courses</p>
                </div>
                <div class="bg-[#071726] text-white rounded-lg shadow border border-[#0e2a3b] p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-slate-300">Published Courses</h3>
                        <div class="p-2 bg-[#063026] rounded-lg">
                            <i class="fas fa-check-circle text-emerald-400"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-cyan-300"><?php echo e($publishedCourses); ?></div>
                    <p class="text-xs text-slate-400 mt-2">Courses available for learners</p>
                </div>
            </div>
        </section>

        <!-- Recent Activity and Top Courses -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-[#071726] rounded-lg shadow border border-[#0e2a3b] p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Top Courses</h3>
                        <p class="text-sm text-slate-300">Most enrolled courses</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $topCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="p-4 rounded-lg bg-[#081423] border border-[#112233]">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-semibold text-white"><?php echo e($course->title); ?></h4>
                                    <p class="text-xs text-slate-400 mt-1"><?php echo e($course->enrollments_count); ?> enrollments</p>
                                </div>
                                <div class="w-52">
                                    <div class="flex items-center justify-between mb-1">
                                        <small class="text-xs text-slate-400">Progress</small>
                                        <small class="text-xs text-slate-300"><?php echo e(intval($course->progress ?? 0)); ?>%</small>
                                    </div>
                                    <div class="w-full bg-[#06101a] rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full progress-fill-gradient" style="width: <?php echo e(intval($course->progress ?? 0)); ?>%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <div class="bg-[#071726] rounded-lg shadow border border-[#0e2a3b] p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Recent Enrollments</h3>
                        <p class="text-sm text-slate-300">Latest learner signups</p>
                    </div>
                </div>
                <div class="divide-y divide-custom-border">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="py-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-medium text-white"><?php echo e($enrollment->user->name ?? 'Unknown'); ?></p>
                                    <p class="text-xs text-slate-400"><?php echo e($enrollment->course->title ?? 'Unknown course'); ?></p>
                                </div>
                                <span class="text-xs text-slate-400"><?php echo e($enrollment->created_at->format('M d')); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Daily Enrollments Chart -->
            <div class="bg-[#071726] rounded-lg shadow border border-[#0e2a3b] p-6 text-white">
                <h3 class="text-lg font-semibold text-white mb-4">Enrollments (Last 7 Days)</h3>
                <canvas id="dailyChart"></canvas>
            </div>

            <!-- Weekly Enrollments Chart -->
            <div class="bg-[#071726] rounded-lg shadow border border-[#0e2a3b] p-6 text-white">
                <h3 class="text-lg font-semibold text-white mb-4">Enrollments (Last 4 Weeks)</h3>
                <canvas id="weeklyChart"></canvas>
            </div>

            <!-- Monthly Enrollments Chart -->
            <div class="bg-[#071726] rounded-lg shadow border border-[#0e2a3b] p-6 lg:col-span-2 text-white">
                <h3 class="text-lg font-semibold text-white mb-4">Enrollments (Last 6 Months)</h3>
                <canvas id="monthlyChart"></canvas>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dailyLabels); ?>,
            datasets: [{
                label: 'Enrollments',
                data: <?php echo json_encode($dailyData); ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });

    // Weekly Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($weeklyLabels); ?>,
            datasets: [{
                label: 'Enrollments',
                data: <?php echo json_encode($weeklyData); ?>,
                backgroundColor: '#10b981',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($monthlyLabels); ?>,
            datasets: [{
                label: 'Enrollments',
                data: <?php echo json_encode($monthlyData); ?>,
                borderColor: '#a855f7',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });

    // Update timestamp every minute
    setInterval(() => {
        document.getElementById('last-updated').textContent = new Date().toLocaleString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }, 60000);

    // Get modules on page load (injected from server when available)
    let modules = <?php echo json_encode($modules ?? [], 15, 512) ?>;
    let courses = <?php echo json_encode($courses ?? [], 15, 512) ?>;

    function buildCourseList() {
        const courseMap = new Map();
        modules.forEach(module => {
            if (module.course_id && module.course_title) {
                courseMap.set(module.course_id, module.course_title);
            }
        });
        courses = Array.from(courseMap.entries()).map(([id, title]) => ({ id, title }));
    }

    function getCourseOptions() {
        return `
            <option value="">Select Course</option>
            ${courses.map(course => `<option value="${course.id}">${course.title}</option>`).join('')}
        `;
    }

    function getModuleOptions(courseId) {
        const filtered = modules.filter(module => String(module.course_id) === String(courseId));
        return `
            <option value="">Select Module</option>
            ${filtered.map(module => `<option value="${module.id}">${module.module_title}</option>`).join('')}
        `;
    }

    function filterModuleOptions(prefix) {
        const courseSelect = document.getElementById(`${prefix}Course`);
        const moduleSelect = document.getElementById(`${prefix}Module`);
        if (!courseSelect || !moduleSelect) return;

        moduleSelect.innerHTML = getModuleOptions(courseSelect.value);
        moduleSelect.disabled = moduleSelect.options.length <= 1;
    }

    function filterUploadModuleOptions() {
        const courseSelect = document.getElementById('upload-course');
        const moduleSelect = document.getElementById('upload-module');
        if (!courseSelect || !moduleSelect) return;

        moduleSelect.innerHTML = getModuleOptions(courseSelect.value);
        moduleSelect.disabled = moduleSelect.options.length <= 1;
    }

    function parseJsonResponse(response) {
        return response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        });
    }

    function loadModules() {
        fetch('<?php echo e(route('admin.content.modules')); ?>', {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(parseJsonResponse)
            .then(data => {
                if (data.success) {
                    modules = data.data;
                    buildCourseList();
                }
            })
            .catch(error => {
                console.error('Module load failed:', error);
                Swal.fire('Error', 'Unable to load modules: ' + error.message, 'error');
            });
    }

    function openCreateModal(type) {
        document.getElementById('create-modal').classList.add('hidden');

        switch (type) {
            case 'assessment':
                createAssessment();
                break;
            case 'video':
                createVideo();
                break;
            case 'presentation':
                createPresentation();
                break;
            case 'quiz':
                createQuiz();
                break;
            case 'ppt':
                createPPT();
                break;
            case 'module':
                createModule();
                break;
            case 'course':
                createCourse();
                break;
            default:
                console.warn('Unknown content type:', type);
        }
    }

    function createModule() {
        window.location.href = '<?php echo e(route('admin.modules.create')); ?>';
    }

    function createCourse() {
        window.location.href = '<?php echo e(route('admin.courses.create')); ?>';
    }

    // File Upload Handler
    function handleFileUpload(event) {
        const files = event.target.files;
        if (files.length > 0) {
            Swal.fire({
                title: 'Upload Files',
                html: `
                    <div class="text-left">
                        <p class="mb-3">${files.length} file(s) selected</p>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select id="upload-course" class="w-full px-3 py-2 border border-gray-300 rounded-lg" onchange="filterUploadModuleOptions()">
                                ${getCourseOptions()}
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                            <select id="upload-module" class="w-full px-3 py-2 border border-gray-300 rounded-lg" disabled>
                                <option value="">Select Module</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                confirmButtonColor: '#3b82f6',
                preConfirm: () => {
                    const moduleId = document.getElementById('upload-module').value;
                    if (!moduleId) {
                        Swal.showValidationMessage('Please select a module');
                        return false;
                    }
                    return { moduleId };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    for (let i = 0; i < files.length; i++) {
                        formData.append('images[]', files[i]);
                    }
                    formData.append('module_id', result.value.moduleId);

                    Swal.fire({
                        title: 'Uploading Files',
                        html: 'Please wait while your files are being uploaded...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        allowOutsideClick: false
                    });

                    fetch('<?php echo e(route('admin.content.images')); ?>', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(parseJsonResponse)
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Upload failed: ' + error.message, 'error');
                    });
                }
            });
        }
    }

    // Create Assessment
    function createAssessment() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Assessment',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select id="assessmentCourse" onchange="filterModuleOptions('assessment')" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            ${getCourseOptions()}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="assessmentModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" disabled>
                            <option value="">Select Module</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Title</label>
                        <input type="text" id="assessmentTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="assessmentDesc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Enter description"></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('assessmentModule').value;
                const title = document.getElementById('assessmentTitle').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                return { moduleId, title };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.assessment')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    description: document.getElementById('assessmentDesc').value
                });
            }
        });
    }

    // Create Video
    function createVideo() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Video Content',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select id="videoCourse" onchange="filterModuleOptions('video')" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            ${getCourseOptions()}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="videoModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" disabled>
                            <option value="">Select Module</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video Title</label>
                        <input type="text" id="videoTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                        <input type="url" id="videoUrl" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://youtube.com/...">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('videoModule').value;
                const title = document.getElementById('videoTitle').value;
                const url = document.getElementById('videoUrl').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (!url) {
                    Swal.showValidationMessage('Please enter a video URL');
                    return false;
                }
                return { moduleId, title, url };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.video')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    video_url: result.value.url
                });
            }
        });
    }

    // Create Presentation
    function createPresentation() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Presentation',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="presentationModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Presentation Title</label>
                        <input type="text" id="presentationTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload File (PowerPoint/PDF)</label>
                        <input type="file" id="presentationFile" class="w-full" accept=".ppt,.pptx,.pdf">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('presentationModule').value;
                const title = document.getElementById('presentationTitle').value;
                const file = document.getElementById('presentationFile').files[0];
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (!file) {
                    Swal.showValidationMessage('Please select a file');
                    return false;
                }
                return { moduleId, title, file };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('module_id', result.value.moduleId);
                formData.append('title', result.value.title);
                formData.append('file', result.value.file);

                submitFormData('<?php echo e(route('admin.content.presentation')); ?>', formData);
            }
        });
    }

    // Create Quiz
    function createQuiz() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Quiz',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="quizModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quiz Title</label>
                        <input type="text" id="quizTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="quizDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Optional quiz overview"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Questions</label>
                        <input type="number" id="quizQuestions" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="5" min="1">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Limit (minutes)</label>
                        <input type="number" id="quizTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="30" min="5">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Media Type</label>
                        <select id="quizMediaType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">None</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Media URL</label>
                        <input type="url" id="quizMediaUrl" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/video.mp4 or image.jpg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Media File</label>
                        <input type="file" id="quizMediaFile" class="w-full" accept="image/*,video/*">
                        <p class="text-xs text-gray-500 mt-1">Optional file upload instead of URL. Leave blank if using a URL.</p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('quizModule').value;
                const title = document.getElementById('quizTitle').value;
                const description = document.getElementById('quizDescription').value;
                const mediaType = document.getElementById('quizMediaType').value;
                const mediaUrl = document.getElementById('quizMediaUrl').value;
                const mediaFile = document.getElementById('quizMediaFile').files[0];

                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (mediaUrl && !mediaType) {
                    Swal.showValidationMessage('Please select a media type for the provided URL');
                    return false;
                }
                if (mediaFile && !mediaType) {
                    Swal.showValidationMessage('Please select a media type for the uploaded file');
                    return false;
                }
                if (mediaUrl && mediaFile) {
                    Swal.showValidationMessage('Use either a media URL or file upload, not both');
                    return false;
                }
                return {
                    moduleId,
                    title,
                    description,
                    questions: document.getElementById('quizQuestions').value,
                    time: document.getElementById('quizTime').value,
                    mediaType,
                    mediaUrl,
                    mediaFile,
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.mediaFile) {
                    const formData = new FormData();
                    formData.append('module_id', result.value.moduleId);
                    formData.append('title', result.value.title);
                    formData.append('description', result.value.description);
                    formData.append('questions_count', result.value.questions);
                    formData.append('time_limit_minutes', result.value.time);
                    formData.append('media_type', result.value.mediaType);
                    formData.append('media_file', result.value.mediaFile);
                    if (result.value.mediaUrl) {
                        formData.append('media_url', result.value.mediaUrl);
                    }
                    submitFormData('<?php echo e(route('admin.content.quiz')); ?>', formData);
                } else {
                    submitForm('<?php echo e(route('admin.content.quiz')); ?>', {
                        module_id: result.value.moduleId,
                        title: result.value.title,
                        description: result.value.description,
                        questions_count: result.value.questions,
                        time_limit_minutes: result.value.time,
                        media_type: result.value.mediaType,
                        media_url: result.value.mediaUrl,
                    });
                }
            }
        });
    }

    // Create PowerPoint
    function createPPT() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create PowerPoint Slide',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="pptModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slide Title</label>
                        <input type="text" id="pptTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter slide title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Choose Template</label>
                        <select id="pptTemplate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Blank</option>
                            <option>Title Slide</option>
                            <option>Content & Image</option>
                            <option>Two Content</option>
                        </select>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('pptModule').value;
                const title = document.getElementById('pptTitle').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                return { 
                    moduleId, 
                    title,
                    template: document.getElementById('pptTemplate').value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.powerpoint')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    template: result.value.template
                });
            }
        });
    }

    // Form submission helpers
    function submitForm(url, data) {
        Swal.fire({
            title: 'Creating...',
            html: 'Please wait while your content is being created...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        }))
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6',
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Request failed: ' + error.message, 'error');
        });
    }

    function submitFormData(url, formData) {
        Swal.fire({
            title: 'Uploading...',
            html: 'Please wait while your file is being uploaded...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        }))
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6',
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Upload failed: ' + error.message, 'error');
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadModules();
    });

    // Handle image upload
    function handleImageUpload(event) {
        handleFileUpload(event);
        event.target.value = '';
    }

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- Create Modal (outside main content so fixed positioning and z-index stay correct) -->
<div id="create-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[200] p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full" role="dialog" aria-labelledby="create-modal-title">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 id="create-modal-title" class="text-lg font-semibold text-gray-900">Create New Content</h3>
            <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="create-modal-close text-gray-400 hover:text-gray-600 p-1">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <button type="button" onclick="openCreateModal('assessment')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-file-alt text-xl text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Assessment</h4>
                    <p class="text-xs text-gray-600 mt-1">Create quizzes &amp; tests</p>
                </button>

                <button type="button" onclick="openCreateModal('video')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-red-50 hover:border-red-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-video text-xl text-red-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Video</h4>
                    <p class="text-xs text-gray-600 mt-1">Add video lessons</p>
                </button>

                <button type="button" onclick="openCreateModal('presentation')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-orange-50 hover:border-orange-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-file-powerpoint text-xl text-orange-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Presentation</h4>
                    <p class="text-xs text-gray-600 mt-1">Upload presentations</p>
                </button>

                <button type="button" onclick="openCreateModal('quiz')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-green-50 hover:border-green-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-question-circle text-xl text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Quiz</h4>
                    <p class="text-xs text-gray-600 mt-1">Build interactive quizzes</p>
                </button>

                <button type="button" onclick="document.getElementById('image-input-modal').click()" class="create-type-card w-full col-span-2 sm:col-span-1 sm:col-start-2 flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-pink-50 hover:border-pink-500 transition text-center">
                    <input type="file" id="image-input-modal" class="hidden" accept="image/*" multiple onchange="handleImageUpload(event)">
                    <div class="mb-2">
                        <i class="fas fa-image text-xl text-pink-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Image</h4>
                    <p class="text-xs text-gray-600 mt-1">Upload images</p>
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.staff.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\staff\staff-admin.blade.php ENDPATH**/ ?>