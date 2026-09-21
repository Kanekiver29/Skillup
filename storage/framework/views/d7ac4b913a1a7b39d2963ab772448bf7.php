

<?php $__env->startSection('title', 'Teacher Profile'); ?>
<?php $__env->startSection('page_title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .profile-header h1 {
        margin: 0 0 10px 0;
        font-size: 32px;
    }

    .profile-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .info-card {
        background: rgba(255,255,255,0.1);
        padding: 15px 20px;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .info-card strong {
        display: block;
        opacity: 0.9;
        margin-bottom: 5px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .info-card span {
        font-size: 18px;
        font-weight: 600;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        text-align: center;
        border-top: 4px solid #667eea;
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
    }

    .stat-card .label {
        color: #666;
        margin-top: 5px;
        font-size: 14px;
    }

    .courses-section {
        margin-top: 40px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 15px;
    }

    .section-header h2 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .btn-primary {
        background: #667eea;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .btn-danger {
        background: #ff6b6b;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-danger:hover {
        background: #ff5252;
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .course-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .course-image {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .course-body {
        padding: 20px;
    }

    .course-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }

    .course-desc {
        color: #666;
        font-size: 13px;
        margin-bottom: 15px;
        line-height: 1.5;
        max-height: 60px;
        overflow: hidden;
    }

    .course-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 12px;
        color: #999;
    }

    .course-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 10px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 15px;
    }

    .stat-item {
        text-align: center;
        font-size: 12px;
    }

    .stat-item .number {
        font-weight: 700;
        color: #667eea;
        font-size: 16px;
    }

    .stat-item .label {
        color: #999;
    }

    .course-actions {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-published {
        background: #d4edda;
        color: #155724;
    }

    .badge-draft {
        background: #fff3cd;
        color: #856404;
    }

    .badge-beginner {
        background: #cfe2ff;
        color: #084298;
    }

    .badge-intermediate {
        background: #cfe8fc;
        color: #0c5460;
    }

    .badge-advanced {
        background: #f8d7da;
        color: #721c24;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f9f9f9;
        border-radius: 12px;
    }

    .empty-state h3 {
        color: #999;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #bbb;
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }

    .modal-close {
        float: right;
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }

    .modal-close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message = session('success')): ?>
    <div class="alert alert-success"><?php echo e($message); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message = session('info')): ?>
    <div class="alert alert-info"><?php echo e($message); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message = session('error')): ?>
    <div class="alert alert-error"><?php echo e($message); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- Profile Header -->
<div class="profile-header">
    <h1><?php echo e($user->name ?? 'Teacher Profile'); ?></h1>
    <div class="profile-info">
        <div class="info-card">
            <strong>Email</strong>
            <span><?php echo e($user->email); ?></span>
        </div>
        <div class="info-card">
            <strong>Role</strong>
            <span>Teacher</span>
        </div>
        <div class="info-card">
            <strong>Staff Type</strong>
            <span><?php echo e($user->staff_type ?? 'N/A'); ?></span>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="number"><?php echo e($totalCourses); ?></div>
        <div class="label">Total Courses</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo e($publishedCourses); ?></div>
        <div class="label">Published Courses</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo e($draftCourses); ?></div>
        <div class="label">Draft Courses</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo e($totalStudents); ?></div>
        <div class="label">Total Students</div>
    </div>
</div>

<!-- Teaching Courses Section -->
<div class="courses-section">
    <div class="section-header">
        <h2>My Teaching Courses</h2>
        <a href="<?php echo e(route('sias.teacher.profile.create-course')); ?>" class="btn-primary">
            <i class="fas fa-plus"></i> Add Course
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courses->count() > 0): ?>
        <div class="course-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="course-card">
                    <div class="course-image">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->image_url): ?>
                            <img src="<?php echo e($course->image_url); ?>" alt="<?php echo e($course->title); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="fas fa-book"></i> No Image
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="course-body">
                        <div class="course-title"><?php echo e($course->title); ?></div>
                        <div class="course-desc"><?php echo e(Str::limit($course->short_description, 100)); ?></div>
                        
                        <div class="course-meta">
                            <span><?php echo e($course->level); ?></span>
                            <span><?php echo e($course->duration_hours); ?> hours</span>
                        </div>

                        <div class="course-stats">
                            <div class="stat-item">
                                <div class="number"><?php echo e($course->students_count); ?></div>
                                <div class="label">Students</div>
                            </div>
                            <div class="stat-item">
                                <div class="number"><?php echo e($course->rating); ?></div>
                                <div class="label">Rating</div>
                            </div>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->is_published): ?>
                                <span class="badge badge-published">Published</span>
                            <?php else: ?>
                                <span class="badge badge-draft">Draft</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <span class="badge badge-<?php echo e(strtolower($course->level)); ?>"><?php echo e($course->level); ?></span>
                        </div>

                        <div class="course-actions">
                            <a href="<?php echo e(route('sias.teacher.profile.edit-course', $course)); ?>" class="btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$course->is_published): ?>
                                <form method="POST" action="<?php echo e(route('sias.teacher.profile.publish-course', $course)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-secondary" title="Publish this course">
                                        <i class="fas fa-check"></i> Publish
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('sias.teacher.profile.unpublish-course', $course)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-secondary" title="Unpublish this course">
                                        <i class="fas fa-times"></i> Unpublish
                                    </button>
                                </form>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <button type="button" class="btn-secondary" onclick="openAssignModal(<?php echo e($course->id); ?>)">
                                <i class="fas fa-user-plus"></i> Assign Student
                            </button>
                            
                            <form method="POST" action="<?php echo e(route('sias.teacher.profile.destroy-course', $course)); ?>" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-danger" title="Archive this course">
                                    <i class="fas fa-trash"></i> Archive
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No courses yet</h3>
            <p>Create your first course to get started with teaching.</p>
            <a href="<?php echo e(route('sias.teacher.profile.create-course')); ?>" class="btn-primary">
                <i class="fas fa-plus"></i> Create Your First Course
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- Assign Student Modal -->
<div id="assignModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-close" onclick="closeAssignModal()">&times;</span>
            Assign Student to Course
        </div>
        <form id="assignForm" method="POST" style="margin-top: 20px;">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="student">Select Student:</label>
                <select id="student" name="student_id" required>
                    <option value="">-- Choose a student --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\User::where('role', 'student')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?> (<?php echo e($student->email); ?>)</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Assign Student</button>
        </form>
    </div>
</div>

<script>
function openAssignModal(courseId) {
    const modal = document.getElementById('assignModal');
    const form = document.getElementById('assignForm');
    form.action = `/sias/teacher/profile/courses/${courseId}/assign-student`;
    modal.classList.add('active');
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.remove('active');
}

window.onclick = function(event) {
    const modal = document.getElementById('assignModal');
    if (event.target === modal) {
        modal.classList.remove('active');
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\profile\index.blade.php ENDPATH**/ ?>