<?php $__env->startSection('title', 'Create Announcement'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Reusing DB Aurora Grid variables from dashboard */
:root {
    --db-accent:        #22E2FF;
    --db-accent-light:  rgba(34,226,255,.12);
    --db-accent-dark:   #8B6BFF;
    --db-success:       #3DFFB0;
    --db-danger:        #FF5D6C;
    --db-gray-100:      #141B2E;
    --db-gray-200:      #202A44;
    --db-gray-300:      #2B3554;
    --db-gray-400:      #5C6584;
    --db-gray-500:      #8B94B3;
    --db-gray-600:      #AAB2CC;
    --db-gray-700:      #C7CEE2;
    --db-gray-900:      #E7ECF9;
    --db-bg-deep:       #0A0E1A;
    --db-card-bg:       rgba(15,21,36,.72);
    --db-radius:        14px;
    --db-radius-sm:     8px;
    --db-shadow:        0 4px 20px -6px rgba(0,0,0,.45);
    --db-font:          'Inter', system-ui, sans-serif;
    --db-font-display:  'Space Grotesk', sans-serif;
}

.news-page {
    position: relative;
    font-family: var(--db-font);
    color: var(--db-gray-900);
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
}

.news-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.news-header h1 {
    font-family: var(--db-font-display);
    font-size: 24px;
    color: #fff;
}

.db-card {
    background: var(--db-card-bg);
    border: 1px solid var(--db-gray-200);
    border-radius: var(--db-radius);
    padding: 24px;
    box-shadow: var(--db-shadow);
}

.db-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: var(--db-radius-sm);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
}

.db-btn--primary {
    background: linear-gradient(100deg, var(--db-accent), var(--db-accent-dark));
    color: #06101C;
    box-shadow: 0 8px 22px -8px rgba(34,226,255,.55);
}

.db-btn--primary:hover {
    filter: brightness(1.1);
    transform: translateY(-2px);
    color: #06101C;
}

.db-btn--ghost {
    background: transparent;
    color: var(--db-gray-500);
    border: 1px solid var(--db-gray-300);
}

.db-btn--ghost:hover {
    background: rgba(255,255,255,.05);
    color: #fff;
    border-color: var(--db-gray-400);
}

.form-group { margin-bottom: 20px; }
.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--db-gray-600);
    font-size: 13px;
    font-weight: 500;
}
.form-control {
    width: 100%;
    padding: 12px 14px;
    background: var(--db-bg-deep);
    border: 1px solid var(--db-gray-300);
    border-radius: var(--db-radius-sm);
    color: #fff;
    font-family: var(--db-font);
    font-size: 14px;
}
.form-control:focus {
    outline: none;
    border-color: var(--db-accent);
    box-shadow: 0 0 0 2px var(--db-accent-light);
}

.text-danger { color: var(--db-danger); font-size: 12px; margin-top: 4px; display: block; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="news-page">
    <div class="news-header">
        <div>
            <h1>Publish New Announcement</h1>
            <p style="color: var(--db-gray-500); margin-top: 4px; font-size: 14px;">Create a new alert, event, or general update.</p>
        </div>
        <a href="<?php echo e(route('staff.news.index')); ?>" class="db-btn db-btn--ghost">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="db-card">
        <form action="<?php echo e(route('staff.news.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" placeholder="E.g., System Maintenance Schedule" required>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="update" <?php echo e(old('category') == 'update' ? 'selected' : ''); ?>>General Update</option>
                        <option value="academic" <?php echo e(old('category') == 'academic' ? 'selected' : ''); ?>>Academic</option>
                        <option value="event" <?php echo e(old('category') == 'event' ? 'selected' : ''); ?>>Event</option>
                        <option value="alert" style="color: #FF5D6C;" <?php echo e(old('category') == 'alert' ? 'selected' : ''); ?>>Urgent Alert / Push Notification</option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Target Audience (Optional)</label>
                    <select name="audience" class="form-control">
                        <option value="all" <?php echo e(old('audience') == 'all' ? 'selected' : ''); ?>>Broadcast to All Students</option>
                        <option value="year_1" <?php echo e(old('audience') == 'year_1' ? 'selected' : ''); ?>>1st Year Students</option>
                        <option value="year_2" <?php echo e(old('audience') == 'year_2' ? 'selected' : ''); ?>>2nd Year Students</option>
                        <option value="dept_it" <?php echo e(old('audience') == 'dept_it' ? 'selected' : ''); ?>>IT Department</option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['audience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Message Content</label>
                <textarea name="content" class="form-control" rows="6" placeholder="Type the announcement details here..." required><?php echo e(old('content')); ?></textarea>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Attach Photos (Optional, Max 25)</label>
                <input type="file" name="photos[]" id="photos-input" class="form-control" style="padding: 9px;" multiple accept="image/*">
                <span style="color: var(--db-gray-500); text-size: 11px; margin-top: 4px; display: block;">Supported: JPG, JPEG, PNG, GIF, WEBP. Max 5MB per file.</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Attach Videos (Optional, Max 3)</label>
                <input type="file" name="videos[]" id="videos-input" class="form-control" style="padding: 9px;" multiple accept="video/*">
                <span style="color: var(--db-gray-500); text-size: 11px; margin-top: 4px; display: block;">Supported: MP4, MOV, AVI, WEBM. Max 20MB per file.</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['videos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['videos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <div class="form-group" style="display: flex; gap: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--db-gray-200);">
                <button type="submit" class="db-btn db-btn--primary">
                    <i class="fas fa-paper-plane"></i> Publish Now
                </button>
                <a href="<?php echo e(route('staff.news.index')); ?>" class="db-btn db-btn--ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photosInput = document.getElementById('photos-input');
    const videosInput = document.getElementById('videos-input');
    const form = photosInput.closest('form');

    form.addEventListener('submit', function(e) {
        if (photosInput.files.length > 25) {
            alert('You can only attach a maximum of 25 photos.');
            e.preventDefault();
            return false;
        }

        if (videosInput.files.length > 3) {
            alert('You can only attach a maximum of 3 videos.');
            e.preventDefault();
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\news\create.blade.php ENDPATH**/ ?>