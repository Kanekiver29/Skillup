

<?php $__env->startSection('title', 'Create Module'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ---- Entrance animations ---- */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInDown {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    @keyframes subtle-pulse {
        0%, 100% {
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }
        50% {
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.2);
        }
    }

    @keyframes inputFocus {
        0% {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0);
        }
        100% {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        animation-delay: var(--delay, 0s);
    }

    .slide-in-down {
        opacity: 0;
        animation: slideInDown 0.5s ease-out forwards;
    }

    /* ---- Header Polish ---- */
    .page-header {
        position: relative;
        padding-bottom: 1rem;
    }

    .page-header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        border-radius: 2px;
        animation: slideInDown 0.6s ease-out 0.2s backwards;
    }

    /* ---- Card polish with depth ---- */
    .module-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid rgba(148, 163, 184, 0.2);
        position: relative;
        overflow: hidden;
    }

    .module-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.1) 50%,
            transparent 100%
        );
        transition: left 0.5s ease;
        pointer-events: none;
    }

    .module-card:hover::before {
        left: 100%;
    }

    .module-card:hover {
        box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.2);
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.2);
    }

    /* ---- Form group styling ---- */
    .form-group {
        animation: fadeInUp 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    /* ---- Input field styling ---- */
    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 0.625rem;
        font-size: 0.9375rem;
        line-height: 1.5;
        color: #1e293b;
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        font-family: inherit;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #94a3b8;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #4f46e5;
        background-color: #f9fafb;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-input:hover,
    .form-textarea:hover,
    .form-select:hover {
        border-color: #cbd5e1;
    }

    /* ---- Textarea specific ---- */
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-textarea:focus {
        min-height: 120px;
    }

    /* ---- Checkbox styling ---- */
    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
        accent-color: #4f46e5;
        transition: all 0.3s ease;
    }

    .form-checkbox:hover {
        transform: scale(1.1);
    }

    .form-checkbox:focus {
        outline: 2px solid #4f46e5;
        outline-offset: 2px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background-color: #f8fafc;
        border-radius: 0.625rem;
        border: 1.5px solid #e2e8f0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .checkbox-wrapper:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }

    .checkbox-wrapper input:checked + label {
        color: #4f46e5;
        font-weight: 600;
    }

    /* ---- Error messages ---- */
    .error-message {
        font-size: 0.8125rem;
        color: #dc2626;
        margin-top: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        animation: fadeInUp 0.3s ease-out;
    }

    .error-message::before {
        content: "⚠";
        font-weight: bold;
    }

    /* ---- Primary button with shine ---- */
    .btn-primary {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: white;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        border-radius: 0.625rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        animation: subtle-pulse 2s ease-in-out infinite;
    }

    .btn-primary:hover {
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
        transform: translateY(-2px);
        background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
    }

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:focus {
        outline: 2px solid #4f46e5;
        outline-offset: 2px;
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        animation: none;
    }

    /* Shine sweep animation */
    .btn-primary::after {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            120deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.3) 50%,
            rgba(255, 255, 255, 0) 100%
        );
        transform: skewX(-20deg);
        transition: left 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .btn-primary:hover::after {
        left: 125%;
    }

    /* ---- Secondary button ---- */
    .btn-secondary {
        position: relative;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #475569;
        background-color: #e2e8f0;
        border: 1.5px solid #cbd5e1;
        border-radius: 0.625rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-secondary:hover {
        background-color: #cbd5e1;
        border-color: #94a3b8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(71, 85, 105, 0.15);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    .btn-secondary:focus {
        outline: 2px solid #cbd5e1;
        outline-offset: 2px;
    }

    /* ---- Button group ---- */
    .button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    /* ---- Stagger animation for form fields ---- */
    .form-group:nth-child(1) { --delay: 0.1s; }
    .form-group:nth-child(2) { --delay: 0.2s; }
    .form-group:nth-child(3) { --delay: 0.3s; }
    .form-group:nth-child(4) { --delay: 0.4s; }
    .form-group:nth-child(5) { --delay: 0.5s; }
    .form-group:nth-child(6) { --delay: 0.6s; }

    /* ---- Respect reduced motion preference ---- */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation: none !important;
            transition: none !important;
        }
    }

    /* ---- Responsive adjustments ---- */
    @media (max-width: 640px) {
        .module-card {
            padding: 1.25rem;
        }

        .page-header h1 {
            font-size: 1.875rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }
</style>


<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        <!-- Header -->
        <header class="page-header fade-in-up mb-8" style="--delay: 0s;">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight">Create Module</h1>
            <p class="text-base text-slate-600 mt-3 font-medium">Add a new module to enhance your course content</p>
        </header>

        <!-- Card Container -->
        <div class="module-card rounded-xl bg-white shadow-lg fade-in-up" style="--delay: 0.1s;">
            <div class="p-6 sm:p-8">
                <form action="<?php echo e(route('staff.modules.store')); ?>" method="POST" class="space-y-6" novalidate>
                    <?php echo csrf_field(); ?>

                    <!-- Course Selection -->
                    <div class="form-group">
                        <label for="course_id" class="form-label">
                            Select Course <span class="text-red-500 font-bold">*</span>
                        </label>
                        <select 
                            id="course_id"
                            name="course_id" 
                            class="form-select <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required
                            aria-label="Select a course"
                        >
                            <option value="">-- Select a Course --</option>
                            <?php if(isset($courses) && $courses->count()): ?>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option 
                                        value="<?php echo e($course->id); ?>" 
                                        <?php echo e(old('course_id', $selectedCourseId ?? '') == $course->id ? 'selected' : ''); ?>

                                    >
                                        <?php echo e($course->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Module Title -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Module Title <span class="text-red-500 font-bold">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title"
                            name="title" 
                            value="<?php echo e(old('title')); ?>" 
                            class="form-input <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Enter module title (e.g., Introduction to JavaScript)"
                            required
                            aria-label="Module title"
                        >
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Module Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea 
                            id="description"
                            name="description" 
                            rows="4" 
                            class="form-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Provide a brief overview of what this module covers..."
                            aria-label="Module description"
                        ><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Module Definition -->
                    <div class="form-group">
                        <label for="definition" class="form-label">
                            Definition
                        </label>
                        <textarea 
                            id="definition"
                            name="definition" 
                            rows="4" 
                            class="form-textarea <?php $__errorArgs = ['definition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Define key concepts and terminology for this module..."
                            aria-label="Module definition"
                        ><?php echo e(old('definition')); ?></textarea>
                        <?php $__errorArgs = ['definition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Module Example -->
                    <div class="form-group">
                        <label for="example" class="form-label">
                            Example
                        </label>
                        <textarea 
                            id="example"
                            name="example" 
                            rows="4" 
                            class="form-textarea <?php $__errorArgs = ['example'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Provide practical examples related to this module content..."
                            aria-label="Module example"
                        ><?php echo e(old('example')); ?></textarea>
                        <?php $__errorArgs = ['example'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Order and Published -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order -->
                        <div class="form-group">
                            <label for="order" class="form-label">
                                Module Order
                            </label>
                            <input 
                                type="number" 
                                id="order"
                                name="order" 
                                min="0" 
                                value="<?php echo e(old('order')); ?>" 
                                class="form-input <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Leave blank for auto-assignment"
                                aria-label="Module order"
                            >
                            <p class="text-xs text-slate-500 mt-2">Auto-assigned if left empty</p>
                            <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="error-message"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Published Checkbox -->
                        <div class="form-group flex items-end">
                            <label class="checkbox-wrapper">
                                <input 
                                    type="checkbox" 
                                    id="is_published"
                                    name="is_published" 
                                    value="1" 
                                    <?php echo e(old('is_published') ? 'checked' : ''); ?>

                                    class="form-checkbox"
                                    aria-label="Publish this module"
                                >
                                <span class="form-label !m-0">Publish Module</span>
                            </label>
                        </div>
                    </div>

                    <!-- Button Group -->
                    <div class="button-group">
                        <button 
                            type="submit" 
                            class="btn-primary"
                            aria-label="Create and save this module"
                        >
                            <span>✓</span>
                            <span>Create Module</span>
                        </button>

                        <a 
                            href="<?php echo e(route('staff.modules.index', ['course_id' => request('course_id')])); ?>"
                            class="btn-secondary"
                            aria-label="Cancel and return to modules list"
                        >
                            <span>✕</span>
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Helpful Info Footer -->
        <div class="mt-8 fade-in-up" style="--delay: 0.2s;">
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 md:p-6">
                <p class="text-sm text-blue-900">
                    <span class="font-semibold">💡 Tip:</span> Make sure to fill in all required fields marked with <span class="text-red-500 font-bold">*</span>. You can publish the module later if needed.
                </p>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/modules/create.blade.php ENDPATH**/ ?>