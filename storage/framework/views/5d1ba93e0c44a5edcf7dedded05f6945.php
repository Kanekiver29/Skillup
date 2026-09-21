<?php
    $item = $item ?? null;
?>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="title" class="mb-2 block text-sm font-semibold text-slate-300">Title</label>
        <input
            id="title"
            name="title"
            type="text"
            value="<?php echo e(old('title', $item->title ?? '')); ?>"
            class="w-full rounded-2xl border border-slate-700/80 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20"
            placeholder="Enter news title"
            required
        />
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div>
        <label for="category" class="mb-2 block text-sm font-semibold text-slate-300">Category</label>
        <select
            id="category"
            name="category"
            class="w-full rounded-2xl border border-slate-700/80 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20"
            required
        >
            <option value="announcement" <?php echo e(old('category', $item->category ?? '') === 'announcement' ? 'selected' : ''); ?>>Announcement</option>
            <option value="event" <?php echo e(old('category', $item->category ?? '') === 'event' ? 'selected' : ''); ?>>Event</option>
            <option value="update" <?php echo e(old('category', $item->category ?? '') === 'update' ? 'selected' : ''); ?>>Update</option>
        </select>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div>
        <label for="published_at" class="mb-2 block text-sm font-semibold text-slate-300">Published at</label>
        <input
            id="published_at"
            name="published_at"
            type="date"
            value="<?php echo e(old('published_at', isset($item) && $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('Y-m-d') : '')); ?>"
            class="w-full rounded-2xl border border-slate-700/80 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20"
        />
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="sm:col-span-2">
        <label for="featured_image" class="mb-2 block text-sm font-semibold text-slate-300">Featured image</label>
        <input
            id="featured_image"
            name="featured_image"
            type="file"
            accept="image/*"
            class="w-full rounded-2xl border border-dashed border-slate-700/80 bg-slate-800/50 px-4 py-3 text-slate-400 file:rounded-xl file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-950 focus:outline-none"
        />
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item) && $item->featured_image): ?>
            <div class="mt-3 flex items-center gap-3">
                <img src="<?php echo e(asset('storage/' . $item->featured_image)); ?>" alt="Current featured image" class="h-16 w-16 rounded-xl object-cover border border-slate-700/80" />
                <span class="text-xs text-slate-400">Current image</span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p class="mt-2 text-xs text-slate-500">Upload an image to display with the news item.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="sm:col-span-2">
        <label for="video_file" class="mb-2 block text-sm font-semibold text-slate-300">Featured video</label>
        <input
            id="video_file"
            name="video_file"
            type="file"
            accept="video/*"
            class="w-full rounded-2xl border border-dashed border-slate-700/80 bg-slate-800/50 px-4 py-3 text-slate-400 file:rounded-xl file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-950 focus:outline-none"
        />
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item) && $item->video_file): ?>
            <div class="mt-3">
                <video src="<?php echo e(asset('storage/' . $item->video_file)); ?>" class="h-32 w-full max-w-sm rounded-xl border border-slate-700/80 object-cover" controls></video>
                <span class="mt-1 block text-xs text-slate-400">Current video</span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p class="mt-2 text-xs text-slate-500">Upload a video to display on the news detail page.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['video_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="sm:col-span-2">
        <label for="content" class="mb-2 block text-sm font-semibold text-slate-300">Content</label>
        <textarea
            id="content"
            name="content"
            rows="7"
            class="w-full resize-y rounded-2xl border border-slate-700/80 bg-slate-800/50 px-4 py-3 text-white placeholder-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20"
            placeholder="Write the news article..."
            required
        ><?php echo e(old('content', $item->content ?? '')); ?></textarea>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="sm:col-span-2 flex items-center gap-3">
        <input
            id="is_featured"
            name="is_featured"
            type="checkbox"
            value="1"
            <?php echo e(old('is_featured', $item->is_featured ?? false) ? 'checked' : ''); ?>

            class="h-5 w-5 rounded border-slate-600 bg-slate-800/50 text-cyan-500 focus:ring-cyan-500/20"
        />
        <label for="is_featured" class="text-sm font-semibold text-slate-300">Mark as featured</label>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['is_featured'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\news\_form.blade.php ENDPATH**/ ?>