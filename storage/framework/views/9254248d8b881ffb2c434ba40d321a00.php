<?php $__env->startSection('title', 'Teacher & Subject Assignments'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .tsa-wrap {
        --bg: #eef3fc;
        --surface: #ffffff;
        --raised: #edf4ff;
        --border: rgba(148,163,184,0.38);
        --border-h: rgba(34,211,238,0.4);
        --accent: #6366F1;
        --cyan: #22D3EE;
        --emerald: #34D399;
        --amber: #FBBF24;
        --rose: #FB7185;
        --text: #0b1526;
        --text-dim: #5a6f92;
        --text-xs: #4B5563;
        color: var(--text);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        background-color: var(--bg);
        font-family: 'Inter', system-ui, sans-serif;
        padding: 2rem;
    }

    html[data-staff-theme="dark"] .tsa-wrap {
        --bg: #080D18;
        --surface: #0D1424;
        --raised: #111827;
        --border: rgba(99,102,241,0.18);
        --text: #E2E8F0;
        --text-dim: #7C8AA5;
    }

    /* Ambient Orbs */
    .tsa-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        pointer-events: none;
        opacity: 0.5;
        animation: orb-drift 15s infinite alternate ease-in-out;
    }
    .tsa-orb-1 { top: -10%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, var(--accent), transparent 70%); }
    .tsa-orb-2 { bottom: -10%; right: -5%; width: 500px; height: 500px; background: radial-gradient(circle, var(--cyan), transparent 70%); animation-delay: -5s; }
    
    @keyframes orb-drift {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(50px, 30px) scale(1.1); }
    }
    
    @keyframes hue-shift {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(30deg); }
    }

    @keyframes sheen {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }

    .tsa-content {
        position: relative;
        z-index: 10;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .tsa-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .tsa-title {
        font-size: 2.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--text), var(--cyan), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0 0 0.5rem 0;
        animation: hue-shift 8s infinite alternate ease-in-out;
    }
    .tsa-subtitle {
        color: var(--text-dim);
        font-size: 1rem;
        margin: 0;
    }
    
    .tsa-new-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        background: linear-gradient(135deg, var(--accent), #4F46E5);
        color: #fff;
        font-weight: 600;
        text-decoration: none;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease;
    }
    .tsa-new-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
        animation: sheen 3s infinite;
    }
    .tsa-new-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        color: #fff;
    }

    /* Stats Strip */
    .tsa-stats {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .tsa-stat-card {
        flex: 1;
        min-width: 250px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .tsa-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .tsa-stat-icon.indigo { background: rgba(99,102,241,0.1); color: var(--accent); }
    .tsa-stat-icon.emerald { background: rgba(52,211,153,0.1); color: var(--emerald); }
    .tsa-stat-icon.amber { background: rgba(251,191,36,0.1); color: var(--amber); }
    
    .tsa-stat-info { display: flex; flex-direction: column; }
    .tsa-stat-value { font-size: 1.75rem; font-weight: 700; color: var(--text); line-height: 1; margin-bottom: 0.25rem; }
    .tsa-stat-label { color: var(--text-dim); font-size: 0.875rem; font-weight: 500; }

    /* Filters */
    .tsa-filters {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }
    .tsa-form-group {
        position: relative;
        flex: 1;
        min-width: 200px;
    }
    .tsa-input, .tsa-select {
        width: 100%;
        background: var(--raised);
        border: 1px solid var(--border);
        color: var(--text);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: border-color 0.3s;
    }
    .tsa-input:focus, .tsa-select:focus {
        outline: none;
        border-color: var(--accent);
    }
    .tsa-input-icon {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        color: var(--text-dim);
        pointer-events: none;
    }
    .tsa-filter-btn {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    .tsa-filter-btn:hover { background: #4F46E5; }
    .tsa-clear-link { color: var(--text-dim); text-decoration: none; font-size: 0.875rem; }
    .tsa-clear-link:hover { color: var(--text); }

    /* Flash Alerts */
    .tsa-alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: slide-in 0.3s ease-out forwards;
    }
    @keyframes slide-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .tsa-alert-success { background: rgba(52,211,153,0.1); border: 1px solid var(--emerald); color: var(--emerald); }
    .tsa-alert-error { background: rgba(251,113,133,0.1); border: 1px solid var(--rose); color: var(--rose); }
    .tsa-alert-close { background: none; border: none; color: inherit; cursor: pointer; opacity: 0.7; }
    .tsa-alert-close:hover { opacity: 1; }

    /* Table */
    .tsa-table-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .tsa-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .tsa-table th {
        background: var(--raised);
        padding: 1rem 1.25rem;
        color: var(--text-dim);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border);
    }
    .tsa-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        font-size: 0.875rem;
        transition: background 0.2s;
    }
    .tsa-table tbody tr {
        transition: all 0.3s ease;
    }
    .tsa-table tbody tr:hover {
        background: rgba(99,102,241,0.05);
        box-shadow: inset 2px 0 0 var(--accent);
    }
    .tsa-table tbody tr:last-child td { border-bottom: none; }
    
    .tsa-code { font-family: monospace; color: var(--cyan); background: rgba(34,211,238,0.1); padding: 0.25rem 0.5rem; border-radius: 4px; }
    
    .tsa-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .tsa-badge-course { background: rgba(255,255,255,0.1); color: var(--text); border: 1px solid rgba(255,255,255,0.2); }
    .tsa-badge-assigned { background: rgba(52,211,153,0.1); color: var(--emerald); border: 1px solid rgba(52,211,153,0.3); }
    .tsa-badge-unassigned { background: rgba(251,191,36,0.1); color: var(--amber); border: 1px solid rgba(251,191,36,0.3); }
    
    .tsa-teacher-name { display: flex; align-items: center; gap: 0.5rem; }
    .tsa-unassigned-text { color: var(--amber); font-style: italic; opacity: 0.8; }
    
    /* Actions */
    .tsa-actions { display: flex; gap: 0.5rem; align-items: center; }
    .tsa-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: var(--raised);
        color: var(--text-dim);
        border: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .tsa-action-btn.edit:hover { background: rgba(99,102,241,0.1); color: var(--accent); border-color: var(--accent); }
    .tsa-action-btn.unassign:hover { background: rgba(251,113,133,0.1); color: var(--rose); border-color: var(--rose); }
    .tsa-action-link {
        color: var(--accent);
        font-size: 0.875rem;
        text-decoration: none;
        font-weight: 600;
    }
    .tsa-action-link:hover { text-decoration: underline; }
    
    /* Empty State */
    .tsa-empty {
        padding: 4rem 2rem;
        text-align: center;
    }
    .tsa-empty-icon {
        font-size: 3rem;
        color: var(--text-dim);
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .tsa-empty h3 { margin: 0 0 0.5rem 0; font-size: 1.25rem; color: var(--text); }
    .tsa-empty p { color: var(--text-dim); margin-bottom: 1.5rem; }

    /* Pagination */
    .tsa-pagination { margin-top: 2rem; }
    .tsa-pagination nav > ul { display: flex; gap: 0.25rem; list-style: none; padding: 0; margin: 0; justify-content: flex-end; }
    .tsa-pagination nav a, .tsa-pagination nav span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        text-decoration: none;
        transition: all 0.2s;
    }
    .tsa-pagination nav a:hover { background: var(--raised); border-color: var(--accent); color: var(--accent); }
    .tsa-pagination nav span[aria-current="page"] { background: var(--accent); color: #fff; border-color: var(--accent); }
</style>

<div class="tsa-wrap">
    <div class="tsa-orb tsa-orb-1"></div>
    <div class="tsa-orb tsa-orb-2"></div>

    <div class="tsa-content">
        <!-- Header -->
        <div class="tsa-header">
            <div>
                <h1 class="tsa-title">Teacher & Subject Assignments</h1>
                <p class="tsa-subtitle">Assign and manage teacher-subject pairings.</p>
            </div>
            <a href="<?php echo e(route('staff.teacher-subjects.create')); ?>" class="tsa-new-btn">
                <i class="fas fa-plus"></i> Assign Teacher
            </a>
        </div>

        <!-- Stats Strip -->
        <div class="tsa-stats">
            <div class="tsa-stat-card">
                <div class="tsa-stat-icon indigo"><i class="fas fa-book"></i></div>
                <div class="tsa-stat-info">
                    <span class="tsa-stat-value"><?php echo e($totalSubjects ?? 0); ?></span>
                    <span class="tsa-stat-label">Total Subjects</span>
                </div>
            </div>
            <div class="tsa-stat-card">
                <div class="tsa-stat-icon emerald"><i class="fas fa-user-check"></i></div>
                <div class="tsa-stat-info">
                    <span class="tsa-stat-value"><?php echo e($assignedCount ?? 0); ?></span>
                    <span class="tsa-stat-label">Assigned</span>
                </div>
            </div>
            <div class="tsa-stat-card">
                <div class="tsa-stat-icon amber"><i class="fas fa-user-times"></i></div>
                <div class="tsa-stat-info">
                    <span class="tsa-stat-value"><?php echo e($unassignedCount ?? 0); ?></span>
                    <span class="tsa-stat-label">Unassigned</span>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="tsa-alert tsa-alert-success" id="flash-alert">
                <div style="display:flex; gap:0.75rem; align-items:center;">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                </div>
                <button class="tsa-alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="tsa-alert tsa-alert-error" id="flash-alert">
                <div style="display:flex; gap:0.75rem; align-items:center;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                </div>
                <button class="tsa-alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Filter Bar -->
        <form action="<?php echo e(route('staff.teacher-subjects.index')); ?>" method="GET" class="tsa-filters">
            <div class="tsa-form-group" style="flex: 2;">
                <input type="text" name="search" class="tsa-input" placeholder="Search subject code, title or teacher..." value="<?php echo e(request('search')); ?>">
                <i class="fas fa-search tsa-input-icon"></i>
            </div>
            <div class="tsa-form-group">
                <select name="course_id" class="tsa-select">
                    <option value="">All Courses</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(request('course_id') == $course->id ? 'selected' : ''); ?>>
                            <?php echo e($course->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div class="tsa-form-group">
                <select name="status" class="tsa-select">
                    <option value="">All Status</option>
                    <option value="assigned" <?php echo e(request('status') == 'assigned' ? 'selected' : ''); ?>>Assigned</option>
                    <option value="unassigned" <?php echo e(request('status') == 'unassigned' ? 'selected' : ''); ?>>Unassigned</option>
                </select>
            </div>
            <button type="submit" class="tsa-filter-btn">Filter</button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search', 'course_id', 'status'])): ?>
                <a href="<?php echo e(route('staff.teacher-subjects.index')); ?>" class="tsa-clear-link">Clear</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </form>

        <!-- Table Container -->
        <div class="tsa-table-container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($subjects) && $subjects->count() > 0): ?>
                <table class="tsa-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject Code</th>
                            <th>Subject Title</th>
                            <th>Course</th>
                            <th>Assigned Teacher</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($subjects->firstItem() + $index); ?></td>
                                <td><span class="tsa-code"><?php echo e($subject->subject_code); ?></span></td>
                                <td style="font-weight:500; color:var(--text);"><?php echo e($subject->title); ?></td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->course): ?>
                                        <span class="tsa-badge tsa-badge-course"><?php echo e($subject->course->title); ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->teacher): ?>
                                        <div class="tsa-teacher-name">
                                            <i class="fas fa-user-circle" style="color:var(--text-dim);"></i>
                                            <?php echo e($subject->teacher->name); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="tsa-unassigned-text">Unassigned</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->teacher_id): ?>
                                        <span class="tsa-badge tsa-badge-assigned">Assigned</span>
                                    <?php else: ?>
                                        <span class="tsa-badge tsa-badge-unassigned">Unassigned</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <div class="tsa-actions" style="justify-content:flex-end;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->teacher_id): ?>
                                            <a href="<?php echo e(route('staff.teacher-subjects.edit', $subject->id)); ?>" class="tsa-action-btn edit" title="Edit Assignment">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('staff.teacher-subjects.destroy', $subject->id)); ?>" method="POST" class="unassign-form" style="display:inline-block;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="tsa-action-btn unassign" title="Unassign Teacher">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('staff.teacher-subjects.create', ['subject_id' => $subject->id])); ?>" class="tsa-action-link">
                                                Assign
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="tsa-empty">
                    <i class="fas fa-clipboard-list tsa-empty-icon"></i>
                    <h3>No subjects found</h3>
                    <p>There are no subjects matching your criteria or currently available.</p>
                    <a href="<?php echo e(route('staff.teacher-subjects.create')); ?>" class="tsa-new-btn">
                        <i class="fas fa-plus"></i> Assign Teacher Now
                    </a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($subjects) && $subjects->hasPages()): ?>
            <div class="tsa-pagination">
                <?php echo e($subjects->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        const alert = document.getElementById('flash-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                alert.style.transition = 'all 0.3s ease-out';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        }

        // Confirm unassign
        const forms = document.querySelectorAll('.unassign-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to unassign the teacher from this subject?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\teacher and course\list.blade.php ENDPATH**/ ?>