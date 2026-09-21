<?php $__env->startSection('title', 'News & Announcements - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ---------------------------------------------------------------
       SkillUp Announcement Board — "Signal" design system
       Move the @import below into your main <head> for production;
       it's inlined here only because this view is a content partial.
    ----------------------------------------------------------------*/
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

    .signal-board { --ink: #0B1120; --ink-line: #1E293B; --paper: #F5F6F8; --paper-line: #E4E7EC; }
    .signal-board .font-display { font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif; }
    .signal-board .font-body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    .signal-board .font-mono { font-family: 'JetBrains Mono', ui-monospace, monospace; }

    /* Subtle scanline + grid texture for the hero, replaces generic blurred-blob look */
    .signal-grid {
        background-image:
            linear-gradient(rgba(148,163,184,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148,163,184,0.06) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 40%, transparent 90%);
    }

    /* Live signal bars — the signature motif, echoed in hero + urgent cards */
    .signal-bars { display: inline-flex; align-items: flex-end; gap: 2.5px; height: 12px; }
    .signal-bars span { display: block; width: 2.5px; border-radius: 1px; background: currentColor; animation: signal-bounce 1.1s ease-in-out infinite; }
    .signal-bars span:nth-child(1) { height: 40%; animation-delay: -0.9s; }
    .signal-bars span:nth-child(2) { height: 100%; animation-delay: -0.6s; }
    .signal-bars span:nth-child(3) { height: 65%; animation-delay: -0.3s; }
    .signal-bars span:nth-child(4) { height: 85%; animation-delay: 0s; }
    @keyframes signal-bounce {
        0%, 100% { transform: scaleY(0.35); opacity: 0.6; }
        50% { transform: scaleY(1); opacity: 1; }
    }

    /* Scroll-reveal for feed cards, staggered by --i */
    .reveal { opacity: 0; transform: translateY(18px); transition: opacity 0.6s cubic-bezier(.22,.61,.36,1), transform 0.6s cubic-bezier(.22,.61,.36,1); transition-delay: calc(var(--i, 0) * 60ms); }
    .reveal.is-visible { opacity: 1; transform: translateY(0); }

    /* Card hover lift */
    .signal-card { transition: transform 0.35s cubic-bezier(.22,.61,.36,1), box-shadow 0.35s ease, border-color 0.35s ease; }
    .signal-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -20px rgba(15,23,42,0.25); }

    /* Accent bar grows in on reveal */
    .accent-bar { transform: scaleY(0); transform-origin: top; transition: transform 0.5s cubic-bezier(.22,.61,.36,1) 0.15s; }
    .reveal.is-visible .accent-bar { transform: scaleY(1); }

    /* Urgent pulse ring — calm, not frantic */
    @media (prefers-reduced-motion: no-preference) {
        .urgent-pulse::before {
            content: ''; position: absolute; inset: -1px; border-radius: inherit;
            border: 1.5px solid rgba(244,63,94,0.5);
            animation: pulse-ring 2.6s cubic-bezier(.4,0,.6,1) infinite;
            pointer-events: none;
        }
    }
    @keyframes pulse-ring {
        0% { opacity: 0.55; transform: scale(1); }
        70% { opacity: 0; transform: scale(1.015); }
        100% { opacity: 0; transform: scale(1.015); }
    }

    /* Read-more arrow slide */
    .arrow-link svg { transition: transform 0.25s ease; }
    .arrow-link:hover svg { transform: translateX(3px); }

    /* Segmented channel tuner */
    .tuner { position: relative; }
    .tuner-highlight {
        position: absolute; top: 4px; bottom: 4px; left: 0;
        border-radius: 9999px; background: #0B1120;
        transition: transform 0.35s cubic-bezier(.22,.61,.36,1), width 0.35s cubic-bezier(.22,.61,.36,1);
        z-index: 0;
    }
    .tuner button { position: relative; z-index: 1; transition: color 0.3s ease; }

    .fade-item { transition: opacity 0.3s ease, transform 0.3s ease; }
    .fade-item[hidden] { display: none; }

    @media (prefers-reduced-motion: reduce) {
        .reveal, .accent-bar, .signal-card, .arrow-link svg, .tuner-highlight { transition: none !important; animation: none !important; transform: none !important; opacity: 1 !important; }
        .signal-bars span { animation: none !important; height: 70% !important; }
    }
</style>

<div class="signal-board">

    <!-- Hero Section -->
    <section class="pt-32 pb-24 bg-[var(--ink)] text-white relative overflow-hidden">
        <div class="absolute inset-0 signal-grid"></div>

        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <span class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-300 text-xs font-mono uppercase tracking-widest mb-7">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                On Air
                <span class="signal-bars text-cyan-300"><span></span><span></span><span></span><span></span></span>
            </span>
            <h1 class="font-display text-4xl md:text-6xl font-bold mb-5 tracking-tight">Announcement Board</h1>
            <p class="font-body text-lg text-slate-400 max-w-xl mx-auto leading-relaxed">
                Every update from the SkillUp community, broadcast the moment it happens — alerts, deadlines, and opportunities, tuned to what matters to you.
            </p>
        </div>
    </section>

    <!-- Main Feed Section -->
    <section class="py-16 bg-[var(--paper)] text-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">

            <!-- Channel tuner / filters -->
            <div class="tuner inline-flex flex-wrap gap-1 mb-12 p-1 rounded-full bg-white border border-[var(--paper-line)] shadow-sm" data-tuner>
                <div class="tuner-highlight" data-tuner-highlight></div>
                <button type="button" data-filter="all" aria-pressed="true" class="px-4 py-2 rounded-full text-sm font-medium font-body text-white transition">All Updates</button>
                <button type="button" data-filter="alert" aria-pressed="false" class="px-4 py-2 rounded-full text-sm font-medium font-body text-slate-600 hover:text-slate-900 transition">Urgent Alerts</button>
                <button type="button" data-filter="academic" aria-pressed="false" class="px-4 py-2 rounded-full text-sm font-medium font-body text-slate-600 hover:text-slate-900 transition">Academic</button>
                <button type="button" data-filter="event" aria-pressed="false" class="px-4 py-2 rounded-full text-sm font-medium font-body text-slate-600 hover:text-slate-900 transition">Events</button>
            </div>

            <!-- Announcements Feed -->
            <div class="space-y-6" data-feed>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $news ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $category = strtolower($item->category ?? 'update');
                        $isUrgent = $category === 'alert' || $category === 'urgent';
                        $filterKey = $isUrgent ? 'alert' : $category;

                        // Defaults for general updates
                        $colorName = 'cyan';
                        $iconPath = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';

                        if ($isUrgent) {
                            $colorName = 'rose';
                            $iconPath = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                        } elseif ($category === 'event') {
                            $colorName = 'violet';
                            $iconPath = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
                        } elseif ($category === 'academic') {
                            $colorName = 'blue';
                            $iconPath = 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z';
                        }
                    ?>

                    <div class="fade-item reveal" style="--i: <?php echo e($loop->index); ?>;" data-category="<?php echo e($filterKey); ?>">
                        <div class="relative overflow-hidden rounded-3xl <?php echo e($isUrgent ? 'urgent-pulse border-2 border-rose-200' : 'border border-[var(--paper-line)]'); ?> bg-white p-6 sm:p-8 shadow-sm signal-card group">
                            <div class="accent-bar absolute top-0 left-0 w-1.5 h-full bg-<?php echo e($colorName); ?>-500"></div>
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-<?php echo e($colorName); ?>-50 text-<?php echo e($colorName); ?>-<?php echo e($isUrgent ? '500' : '600'); ?>">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($iconPath); ?>" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-<?php echo e($colorName); ?>-100 px-2.5 py-0.5 text-xs font-bold text-<?php echo e($colorName); ?>-700 font-mono tracking-wide uppercase">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isUrgent): ?>
                                                <span class="signal-bars text-<?php echo e($colorName); ?>-700" style="height:8px;"><span></span><span></span><span></span><span></span></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php echo e(ucfirst($item->category ?? 'Update')); ?>

                                        </span>
                                        <span class="text-xs font-mono text-slate-400"><?php echo e(optional($item->published_at ?? $item->created_at)->diffForHumans()); ?></span>
                                    </div>
                                    <h3 class="font-display text-xl font-semibold text-slate-900 mb-3 group-hover:text-<?php echo e($colorName); ?>-600 transition-colors duration-300"><?php echo e($item->title); ?></h3>
                                    <p class="font-body text-slate-600 leading-relaxed mb-4">
                                        <?php echo e(strip_tags($item->content)); ?>

                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item->video_file) || isset($item->featured_image)): ?>
                                        <a href="<?php echo e(route('news.show', $item->id)); ?>" class="arrow-link inline-flex items-center font-body font-medium text-<?php echo e($colorName); ?>-600 hover:text-<?php echo e($colorName); ?>-700 mb-4">
                                            View attached media <svg class="ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('news.show', $item->id)); ?>" class="arrow-link inline-flex items-center font-body font-medium text-<?php echo e($colorName); ?>-600 hover:text-<?php echo e($colorName); ?>-700 mb-4">
                                            Read more <svg class="ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="flex items-center gap-3 text-xs font-mono text-slate-500">
                                        <span><?php echo e($item->author->name ?? 'SkillUp Team'); ?></span>
                                        <span class="text-slate-300">&bull;</span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            <?php echo e($item->views ?? rand(10, 500)); ?> views
                                        </span>
                                    </div>
                                    
                                    
                                    <div class="flex items-center gap-1 mt-4 pt-4 border-t border-[var(--paper-line)]">
                                        <?php
                                            $userReaction = auth()->check() ? $item->reactions->where('user_id', auth()->id())->first()?->type : null;
                                            $reactionCounts = $item->reactions->groupBy('type')->map->count();
                                        ?>
                                        
                                        <button type="button" onclick="toggleReaction(this, <?php echo e($item->id); ?>, 'like')" class="reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors <?php echo e($userReaction === 'like' ? 'text-blue-600 bg-blue-50 ring-1 ring-blue-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'); ?>">
                                            <span>👍</span>
                                            <span class="count"><?php echo e($reactionCounts['like'] ?? 0); ?></span>
                                        </button>
                                        <button type="button" onclick="toggleReaction(this, <?php echo e($item->id); ?>, 'heart')" class="reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors <?php echo e($userReaction === 'heart' ? 'text-rose-600 bg-rose-50 ring-1 ring-rose-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'); ?>">
                                            <span>❤️</span>
                                            <span class="count"><?php echo e($reactionCounts['heart'] ?? 0); ?></span>
                                        </button>
                                        <button type="button" onclick="toggleReaction(this, <?php echo e($item->id); ?>, 'care')" class="reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors <?php echo e($userReaction === 'care' ? 'text-amber-600 bg-amber-50 ring-1 ring-amber-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'); ?>">
                                            <span>🥰</span>
                                            <span class="count"><?php echo e($reactionCounts['care'] ?? 0); ?></span>
                                        </button>
                                        <button type="button" onclick="toggleReaction(this, <?php echo e($item->id); ?>, 'sad')" class="reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors <?php echo e($userReaction === 'sad' ? 'text-indigo-600 bg-indigo-50 ring-1 ring-indigo-200' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'); ?>">
                                            <span>😢</span>
                                            <span class="count"><?php echo e($reactionCounts['sad'] ?? 0); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm">
                        <div class="signal-bars text-slate-300 justify-center mb-4" style="height:20px;"><span></span><span></span><span></span><span></span></div>
                        <p class="font-display text-lg font-semibold text-slate-900">No signal yet.</p>
                        <p class="font-body mt-2 text-sm text-slate-500">Nothing's been broadcast in this channel. Check back later for updates and alerts.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Empty filter state (hidden by default, shown by JS when a channel has no matches) -->
            <div class="hidden rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-sm mt-6" data-empty-filter>
                <p class="font-display text-lg font-semibold text-slate-900">Nothing on this channel right now.</p>
                <p class="font-body mt-2 text-sm text-slate-500">Try another filter, or switch back to All Updates.</p>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <button class="px-6 py-3 rounded-full bg-white border border-[var(--paper-line)] text-slate-700 font-body font-medium shadow-sm transition duration-300 hover:bg-slate-900 hover:text-white hover:border-slate-900 hover:shadow-lg active:scale-95">Load Older Updates</button>
            </div>

        </div>
    </section>
</div>

<script>
(function () {
    var reduceMotion = document.documentElement.dataset.skillupReducedMotion === 'true'
        || window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Scroll-reveal for feed cards
    var revealEls = document.querySelectorAll('.reveal');
    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealEls.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(function (el) { io.observe(el); });
    }

    // Channel tuner: filters cards, moves the sliding highlight, updates empty state
    var tuner = document.querySelector('[data-tuner]');
    if (!tuner) return;
    var highlight = tuner.querySelector('[data-tuner-highlight]');
    var buttons = Array.prototype.slice.call(tuner.querySelectorAll('button[data-filter]'));
    var cards = Array.prototype.slice.call(document.querySelectorAll('[data-feed] [data-category]'));
    var emptyFilterMsg = document.querySelector('[data-empty-filter]');

    function moveHighlight(btn) {
        highlight.style.width = btn.offsetWidth + 'px';
        highlight.style.transform = 'translateX(' + btn.offsetLeft + 'px)';
    }

    function setActive(btn) {
        buttons.forEach(function (b) {
            var active = b === btn;
            b.setAttribute('aria-pressed', active ? 'true' : 'false');
            b.classList.toggle('text-white', active);
            b.classList.toggle('text-slate-600', !active);
        });
        moveHighlight(btn);
    }

    function applyFilter(filter) {
        var visibleCount = 0;
        cards.forEach(function (card) {
            var match = filter === 'all' || card.getAttribute('data-category') === filter;
            if (match) {
                card.hidden = false;
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                visibleCount++;
            } else {
                card.hidden = true;
            }
        });
        if (emptyFilterMsg) emptyFilterMsg.classList.toggle('hidden', visibleCount !== 0 || cards.length === 0);
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            setActive(btn);
            applyFilter(btn.getAttribute('data-filter'));
        });
    });

    // Initialize highlight position after layout settles
    window.addEventListener('load', function () { moveHighlight(buttons[0]); });
    window.addEventListener('resize', function () {
        var activeBtn = buttons.find(function (b) { return b.getAttribute('aria-pressed') === 'true'; });
        if (activeBtn) moveHighlight(activeBtn);
    });
    moveHighlight(buttons[0]);
})();

async function toggleReaction(btn, newsId, type) {
    const isGuest = <?php echo e(auth()->check() ? 'false' : 'true'); ?>;
    if (isGuest) {
        alert('Please login to react to announcements.');
        return;
    }

    const originalHtml = btn.innerHTML;
    btn.style.opacity = '0.5';

    try {
        const response = await fetch(`/news/${newsId}/react`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ type: type })
        });

        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        // Update counts and styles for all buttons in this row
        const row = btn.closest('.flex');
        const buttons = row.querySelectorAll('.reaction-btn');
        
        const typeMap = {
            'like': { activeClass: 'text-blue-600 bg-blue-50 ring-1 ring-blue-200' },
            'heart': { activeClass: 'text-rose-600 bg-rose-50 ring-1 ring-rose-200' },
            'care': { activeClass: 'text-amber-600 bg-amber-50 ring-1 ring-amber-200' },
            'sad': { activeClass: 'text-indigo-600 bg-indigo-50 ring-1 ring-indigo-200' }
        };

        buttons.forEach(b => {
            // Reset all to default first
            b.className = 'reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors text-slate-500 hover:bg-slate-100 hover:text-slate-800';
            
            // Re-apply active class if needed
            const bType = b.getAttribute('onclick').split("'")[1]; // extract type
            if (data.action !== 'removed' && bType === type) {
                b.className = `reaction-btn p-1.5 px-2 rounded-full flex items-center gap-1.5 text-xs font-mono transition-colors ${typeMap[bType].activeClass}`;
            }

            // Update counts
            const countSpan = b.querySelector('.count');
            if (countSpan && data.counts[bType] !== undefined) {
                countSpan.textContent = data.counts[bType];
            }
        });

    } catch (error) {
        console.error('Error toggling reaction:', error);
        alert('An error occurred. Please try again.');
    } finally {
        btn.style.opacity = '1';
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\news\news.blade.php ENDPATH**/ ?>