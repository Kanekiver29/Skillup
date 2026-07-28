<?php $__env->startSection('title', $lesson->title . ' - ' . $module->title . ' - ' . $course->title); ?>

<?php $__env->startPush('head'); ?>
    <style>
        :root {
            --mod-navy: #0a2540;
            --mod-sky: #00b4d8;
        }
        .lesson-content {
            animation: fadeIn 0.6s var(--mod-ease) forwards;
            opacity: 0;
            transform: translateY(12px);
        }
        @keyframes fadeIn {
            to { opacity:1; transform:none; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="max-w-6xl mx-auto p-4 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Player + Content -->
            <div class="lg:col-span-2 bg-white/5 backdrop-blur-md rounded-xl p-6 shadow">
                <div class="flex items-start justify-between mb-4">
                    <h1 class="text-2xl font-bold text-sky-600"><?php echo e($lesson->title); ?></h1>
                    <div class="flex items-center gap-3">
                        <form id="completeForm" method="POST" action="<?php echo e(route('lessons.complete', [$course->slug, $module->slug, $lesson->slug])); ?>">
                            <?php echo csrf_field(); ?>
                            <?php if($lessonEnrollment && $lessonEnrollment->completed): ?>
                                <button type="button" disabled class="px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow">Completed</button>
                            <?php else: ?>
                                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">Mark as Completed</button>
                            <?php endif; ?>
                        </form>
                        <button id="download-txt" type="button" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Download .txt</button>
                    </div>
                </div>

                <?php if($lesson->description): ?>
                    <p class="text-gray-700 mb-4"><?php echo e($lesson->description); ?></p>
                <?php endif; ?>

                <?php
                    $hasVideo = !empty($lesson->video_url);
                    $hasPresentation = $lesson->isPresentation();
                    $hasDocument = $lesson->isDocument();
                    $hasImage = $lesson->isImage();
                    $resourceUrl = $lesson->resourceUrl();
                    $label = $lesson->resourceLabel();
                    $lessonsList = $module->lessons()->where('is_published', true)->orderBy('order')->get();
                    // Precompute a simple array for use in JavaScript to avoid Blade/PHP parsing issues
                    $lessonsJs = $lessonsList->map(function($x) use ($course, $module) {
                        return [
                            'slug' => $x->slug,
                            'url' => route('lessons.show', [$course->slug, $module->slug, $x->slug])
                        ];
                    })->values()->toArray();
                ?>

                <div id="player-area" class="w-full bg-black rounded overflow-hidden mb-4" style="min-height:320px;">
                    <?php if($hasVideo): ?>
                        <?php
                            $src = $lesson->video_url;
                            // Ensure enablejsapi is present for YouTube embeds
                            if (str_contains($src, 'youtube') && !str_contains($src, 'enablejsapi')) {
                                $sep = str_contains($src, '?') ? '&' : '?';
                                $src .= $sep . 'enablejsapi=1&rel=0';
                            }
                        ?>
                        <?php if(str_contains($lesson->video_url, '.mp4')): ?>
                            <video id="lesson-video" class="w-full h-auto" controls playsinline>
                                <source src="<?php echo e($lesson->video_url); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else: ?>
                            <div style="position:relative;padding-top:56.25%;">
                                <iframe id="lesson-iframe" class="absolute inset-0 w-full h-full" src="<?php echo e($src); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        <?php endif; ?>
                    <?php elseif($hasPresentation): ?>
                        <iframe class="w-full h-[560px] rounded" src="<?php echo e($resourceUrl); ?>" frameborder="0"></iframe>
                    <?php elseif($hasDocument || $hasImage): ?>
                        <div class="p-4">
                            <?php if($hasImage): ?>
                                <img src="<?php echo e($resourceUrl); ?>" alt="<?php echo e($lesson->title); ?>" class="max-w-full h-auto rounded shadow"/>
                            <?php else: ?>
                                <a href="<?php echo e($resourceUrl); ?>" target="_blank" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Open <?php echo e($label); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-gray-600">No media attached to this lesson.</div>
                    <?php endif; ?>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div>
                        <a id="prev-lesson" href="#" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                            <i class="fas fa-chevron-left mr-2"></i>Previous
                        </a>
                    </div>
                    <div>
                        <span>Progress: <?php echo e($userProgress ?? 0); ?>%</span>
                    </div>
                    <div>
                        <a id="next-lesson" href="#" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Next<i class="fas fa-chevron-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Playlist -->
            <aside class="bg-white/5 rounded-xl p-4 shadow">
                <h4 class="font-semibold mb-3">Module Playlist</h4>
                <div class="space-y-2 max-h-[60vh] overflow-y-auto">
                    <?php $__currentLoopData = $lessonsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $completed = $l->isCompletedBy(auth()->id() ?? 0); ?>
                        <a href="<?php echo e(route('lessons.show', [$course->slug, $module->slug, $l->slug])); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-white/10 transition <?php echo e($l->id === $lesson->id ? 'bg-white/10 border-l-4 border-sky-500' : ''); ?>">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 flex items-center justify-center rounded bg-white/5 text-sm"><?php echo e($l->order ?? '-'); ?></span>
                                <div class="truncate text-sm"><?php echo e($l->title); ?></div>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if($completed): ?>
                                    <i class="fas fa-check-circle text-green-400"></i>
                                <?php endif; ?>
                                <?php if($l->id === $lesson->id): ?>
                                    <span class="text-xs text-sky-300">Now</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </aside>
        </div>
    </section>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const lessons = Array.from(<?php echo json_encode($lessonsJs, 15, 512) ?>);
    const currentSlug = '<?php echo e($lesson->slug); ?>';
    const idx = lessons.findIndex(l => l.slug === currentSlug);
    const prev = document.getElementById('prev-lesson');
    const next = document.getElementById('next-lesson');

    if (idx > 0) {
        prev.href = lessons[idx - 1].url;
    } else {
        prev.removeAttribute('href'); prev.classList.add('opacity-50','cursor-not-allowed');
    }
    if (idx < lessons.length - 1) {
        next.href = lessons[idx + 1].url;
    } else {
        next.removeAttribute('href'); next.classList.add('opacity-50','cursor-not-allowed');
    }

    // Download lesson as .txt (description + content)
    document.getElementById('download-txt')?.addEventListener('click', () => {
        const title = `<?php echo e(addslashes($lesson->title)); ?>`;
        const desc = `<?php echo e(addslashes($lesson->description ?? '')); ?>`;
        const text = `${title}\n\n${desc}`;
        const blob = new Blob([text], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = `${title.replace(/[^a-z0-9\-]/gi,'_')}.txt`; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    });

    // Autoplay next for HTML5 video
    const video = document.getElementById('lesson-video');
    if (video) {
        video.addEventListener('ended', () => { if (idx < lessons.length - 1) window.location = lessons[idx + 1].url; });
    }

    // YouTube embed API handling
    const iframe = document.getElementById('lesson-iframe');
    if (iframe && iframe.src.includes('youtube')) {
        // load API if not present
        if (!window.YT) {
            const tag = document.createElement('script'); tag.src = 'https://www.youtube.com/iframe_api'; document.head.appendChild(tag);
        }
        window.onYouTubeIframeAPIReady = function() {
            try {
                const player = new YT.Player('lesson-iframe', {
                    events: {
                        'onStateChange': function(e) {
                            if (e.data === YT.PlayerState.ENDED) {
                                if (idx < lessons.length - 1) window.location = lessons[idx + 1].url;
                            }
                        }
                    }
                });
            } catch (err) { console.warn('YT player init failed', err); }
        };
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/courses/lessons/show.blade.php ENDPATH**/ ?>