

<?php $__env->startSection('title', 'My Badges - SkillUp'); ?>

<?php $__env->startSection('content'); ?>

<style>
    @keyframes fadeInUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
    @keyframes floatOrb{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(22px,-28px) scale(1.08)}}
    @keyframes gradientShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
    @keyframes shimmerSweep{0%{transform:translateX(-130%) skewX(-18deg)}100%{transform:translateX(230%) skewX(-18deg)}}
    @keyframes badgePop{0%{opacity:0;transform:scale(.7) translateY(14px)}60%{transform:scale(1.04) translateY(-2px)}100%{opacity:1;transform:scale(1) translateY(0)}}
    @keyframes sparkleTwinkle{0%,100%{opacity:.35;transform:scale(1)}50%{opacity:.9;transform:scale(1.25)}}
    @keyframes ringGlow{0%,100%{box-shadow:0 0 0 0 rgba(255,255,255,.35)}50%{box-shadow:0 0 0 10px rgba(255,255,255,0)}}
    @keyframes countUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
    @keyframes spinSlow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
    @keyframes lockShine{0%{transform:translateX(-120%) skewX(-18deg)}100%{transform:translateX(220%) skewX(-18deg)}}
    @keyframes starTwinkle{0%,100%{opacity:.15;transform:scale(.8)}50%{opacity:.9;transform:scale(1.2)}}
    @keyframes borderRotate{to{--angle:360deg}}
    @keyframes scanline{0%{transform:translateY(-100%)}100%{transform:translateY(220%)}}
    @keyframes hueShift{0%,100%{filter:hue-rotate(0deg)}50%{filter:hue-rotate(20deg)}}
    @keyframes neonPulse{0%,100%{box-shadow:0 0 12px 1px rgba(124,58,237,.35),0 0 0 1px rgba(255,255,255,.08) inset}50%{box-shadow:0 0 22px 4px rgba(124,58,237,.55),0 0 0 1px rgba(255,255,255,.12) inset}}
    @property --angle{syntax:'<angle>';initial-value:0deg;inherits:false}

    .bd-hero{position:relative;overflow:hidden;background:linear-gradient(120deg,#4c1d95,#6d28d9,#4338ca,#7c3aed);background-size:300% 300%;animation:gradientShift 15s ease infinite}
    .bd-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.06) 1px,transparent 1px);background-size:34px 34px;mask-image:radial-gradient(ellipse at top left,black 30%,transparent 75%);border-radius:1rem}
    .bd-orb{position:absolute;border-radius:9999px;filter:blur(48px);opacity:.35;pointer-events:none;animation:floatOrb 10s ease-in-out infinite}
    .bd-star{position:absolute;width:3px;height:3px;background:#fff;border-radius:50%;animation:starTwinkle 3s ease-in-out infinite;pointer-events:none}

    .fade-up{opacity:0;animation:fadeInUp .6s ease forwards}

    .stat-glass{position:relative;background:rgba(255,255,255,.14);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.22);transition:transform .3s ease,background .3s ease,box-shadow .3s ease}
    .stat-glass:hover{transform:translateY(-4px);background:rgba(255,255,255,.2);box-shadow:0 14px 26px -12px rgba(0,0,0,.35)}
    .stat-num{animation:countUp .7s ease both;font-variant-numeric:tabular-nums}

    .cat-card{position:relative;transition:transform .3s cubic-bezier(.2,.8,.2,1),box-shadow .3s ease;will-change:transform}
    .cat-card:hover{box-shadow:0 20px 36px -18px rgba(88,28,135,.22)}
    .cat-icon{transition:transform .35s ease}
    .cat-card:hover .cat-icon{transform:rotate(10deg) scale(1.1)}

    .badge-card{position:relative;overflow:hidden;transition:box-shadow .35s ease,border-color .35s ease;animation:badgePop .5s ease both;will-change:transform}
    .badge-card:hover{box-shadow:0 26px 46px -18px rgba(88,28,135,.28)}
    .badge-shine{position:absolute;top:0;left:0;width:45%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.55),transparent);opacity:0;pointer-events:none;z-index:3}
    .badge-card:hover .badge-shine{opacity:1;animation:shimmerSweep 1s ease}
    .badge-ring{animation:ringGlow 2.6s ease-in-out infinite}
    .badge-icon-wrap{transition:transform .35s ease}
    .badge-card:hover .badge-icon-wrap{transform:scale(1.08) rotate(-4deg)}
    .badge-header{position:relative;overflow:hidden;animation:hueShift 6s ease-in-out infinite}
    .sparkle{animation:sparkleTwinkle 2.4s ease-in-out infinite}
    .sparkle.s2{animation-delay:.8s}
    .rarity-strip{height:3px;width:100%;background-size:200% 100%;animation:gradientShift 4s ease infinite}

    /* animated conic-gradient neon border, revealed on hover */
    .neon-border{position:relative}
    .neon-border::before{content:'';position:absolute;inset:-2px;border-radius:inherit;padding:2px;background:conic-gradient(from var(--angle),#7c3aed,#4f46e5,#06b6d4,#7c3aed);-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;opacity:0;transition:opacity .3s ease;animation:borderRotate 3.5s linear infinite;pointer-events:none;z-index:2}
    .neon-border:hover::before{opacity:1}

    .locked-card{position:relative;overflow:hidden;transition:box-shadow .3s ease,opacity .3s ease;will-change:transform}
    .locked-card:hover{opacity:1;box-shadow:0 18px 32px -18px rgba(15,15,26,.2)}
    .lock-shine{position:absolute;top:0;left:0;width:40%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.45),transparent);opacity:0;pointer-events:none;z-index:3}
    .locked-card:hover .lock-shine{opacity:1;animation:lockShine 1.1s ease}
    .lock-icon{transition:transform .3s ease}
    .locked-card:hover .lock-icon{transform:scale(1.1) rotate(-6deg)}
    .scanline{position:absolute;left:0;right:0;height:26%;background:linear-gradient(180deg,transparent,rgba(255,255,255,.35),transparent);animation:scanline 3.2s linear infinite;pointer-events:none;z-index:2}

    .empty-orb{animation:spinSlow 18s linear infinite}

    .explore-btn{position:relative;overflow:hidden;transition:transform .2s ease,box-shadow .2s ease}
    .explore-btn:hover{transform:translateY(-2px);box-shadow:0 10px 20px -10px rgba(124,58,237,.4)}
    .explore-btn::after{content:'';position:absolute;top:0;left:-75%;width:50%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.5),transparent);transform:skewX(-20deg);transition:left .55s ease}
    .explore-btn:hover::after{left:125%}

    .tilt-card{transform-style:preserve-3d;perspective:900px}

    @media (prefers-reduced-motion: reduce){
        .bd-hero,.bd-orb,.bd-star,.fade-up,.stat-num,.badge-card,.badge-shine,.badge-ring,.badge-header,.sparkle,.rarity-strip,.neon-border::before,.locked-card,.lock-shine,.lock-icon,.scanline,.empty-orb,.explore-btn,.cat-icon{animation:none!important;transition:none!important}
    }
</style>

<div class="space-y-8">

    
    <div class="flex items-center justify-between fade-up">
        <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:-translate-x-0.5 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    
    <div class="bd-hero rounded-2xl p-8 text-white shadow-lg relative fade-up" style="animation-delay:.05s">
        <div class="bd-hero-grid"></div>
        <div class="bd-orb w-56 h-56 bg-amber-300 -top-16 -left-10"></div>
        <div class="bd-orb w-48 h-48 bg-indigo-300 -bottom-14 right-4" style="animation-delay:3s"></div>
        
        <span class="bd-star" style="top:14%;left:22%"></span>
        <span class="bd-star" style="top:60%;left:8%;animation-delay:.6s"></span>
        <span class="bd-star" style="top:30%;left:65%;animation-delay:1.1s"></span>
        <span class="bd-star" style="top:75%;left:48%;animation-delay:1.7s"></span>
        <span class="bd-star" style="top:20%;left:85%;animation-delay:2.2s"></span>
        <span class="bd-star" style="top:85%;left:78%;animation-delay:.3s"></span>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fas fa-award text-yellow-300 drop-shadow"></i> My Badges
                </h1>
                <p class="mt-2 text-purple-100">Earn badges by completing modules and acing quizzes!</p>
            </div>
            <div class="flex gap-4 flex-wrap">
                <div class="stat-glass rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold stat-num" data-count-target="<?php echo e($totalEarned); ?>">0</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Total Earned</p>
                </div>
                <div class="stat-glass rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold stat-num" data-count-target="<?php echo e($moduleBadges->count()); ?>" style="animation-delay:.05s">0</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Modules</p>
                </div>
                <div class="stat-glass rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold stat-num" data-count-target="<?php echo e($quizBadges->count()); ?>" style="animation-delay:.1s">0</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Quizzes</p>
                </div>
                <div class="stat-glass rounded-xl px-5 py-3 text-center">
                    <p class="text-2xl font-bold stat-num" data-count-target="<?php echo e($courseBadges->count()); ?>" style="animation-delay:.15s">0</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Courses</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="cat-card tilt-card neon-border bg-white rounded-xl shadow-md p-6 border-t-4 border-green-500 fade-up" style="animation-delay:.1s">
            <div class="flex items-center gap-3 mb-3">
                <div class="cat-icon w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-puzzle-piece text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Module Completion</h3>
                    <p class="text-xs text-gray-500">Pass all quizzes in a module</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Complete every quiz in a module to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-green-600">
                <i class="fas fa-check-circle mr-1"></i> <?php echo e($moduleBadges->count()); ?> earned
            </div>
        </div>

        
        <div class="cat-card tilt-card neon-border bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-500 fade-up" style="animation-delay:.15s">
            <div class="flex items-center gap-3 mb-3">
                <div class="cat-icon w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Quiz Master</h3>
                    <p class="text-xs text-gray-500">Score 100% on a quiz</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Achieve a perfect score on any quiz to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-yellow-600">
                <i class="fas fa-check-circle mr-1"></i> <?php echo e($quizBadges->count()); ?> earned
            </div>
        </div>

        
        <div class="cat-card tilt-card neon-border bg-white rounded-xl shadow-md p-6 border-t-4 border-purple-500 fade-up" style="animation-delay:.2s">
            <div class="flex items-center gap-3 mb-3">
                <div class="cat-icon w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Course Completion</h3>
                    <p class="text-xs text-gray-500">Complete all modules in a course</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Finish every module in a course to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-purple-600">
                <i class="fas fa-check-circle mr-1"></i> <?php echo e($courseBadges->count()); ?> earned
            </div>
        </div>
    </div>

    
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4 fade-up">
            <i class="fas fa-trophy text-yellow-500 mr-2"></i> Earned Badges
        </h2>

        <?php if($badgeData->isEmpty()): ?>
            <div class="bg-white rounded-xl shadow-md p-12 text-center fade-up relative overflow-hidden">
                <div class="empty-orb absolute -top-10 -right-10 w-40 h-40 rounded-full bg-gradient-to-br from-purple-200 to-amber-200 opacity-40 blur-2xl"></div>
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 relative z-10 shadow-inner">
                    <i class="fas fa-award text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2 relative z-10">No Badges Yet</h3>
                <p class="text-gray-500 mb-4 relative z-10">Start completing modules and quizzes to earn your first badge!</p>
                <a href="<?php echo e(route('courses.index')); ?>" class="explore-btn inline-flex items-center px-6 py-3 gradient-primary text-white rounded-lg shadow-md relative z-10">
                    <i class="fas fa-book-open mr-2"></i> Browse Courses
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $badgeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $badge = $item['badge'];
                        $ub = $item['user_badge'];
                        $context = $item['context'];

                        // Set styling based on badge type
                        $typeStyles = [
                            'module_completion' => [
                                'gradient' => 'from-green-400 to-emerald-600',
                                'bg' => 'bg-green-50',
                                'text' => 'text-green-700',
                                'border' => 'border-green-200',
                                'ring' => 'ring-green-300',
                                'label' => 'Module Complete',
                            ],
                            'quiz_perfect' => [
                                'gradient' => 'from-yellow-400 to-orange-500',
                                'bg' => 'bg-yellow-50',
                                'text' => 'text-yellow-700',
                                'border' => 'border-yellow-200',
                                'ring' => 'ring-yellow-300',
                                'label' => 'Quiz Master',
                            ],
                            'course_completion' => [
                                'gradient' => 'from-purple-400 to-indigo-600',
                                'bg' => 'bg-purple-50',
                                'text' => 'text-purple-700',
                                'border' => 'border-purple-200',
                                'ring' => 'ring-purple-300',
                                'label' => 'Course Complete',
                            ],
                        ];
                        $style = $typeStyles[$badge->type] ?? $typeStyles['module_completion'];
                    ?>

                    <div class="badge-card tilt-card neon-border bg-white rounded-xl shadow-md overflow-hidden border <?php echo e($style['border']); ?>" style="animation-delay: <?php echo e($i * 0.06); ?>s">
                        <div class="rarity-strip bg-gradient-to-r <?php echo e($style['gradient']); ?>"></div>
                        <div class="badge-shine"></div>
                        
                        <div class="badge-header bg-gradient-to-r <?php echo e($style['gradient']); ?> p-6 text-center relative">
                            <div class="badge-icon-wrap badge-ring w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto ring-4 <?php echo e($style['ring']); ?> backdrop-blur-sm">
                                <i class="fas <?php echo e($badge->icon); ?> text-white text-3xl"></i>
                            </div>
                            
                            <div class="sparkle absolute top-3 right-4 text-white/40">
                                <i class="fas fa-sparkles text-lg"></i>
                            </div>
                            <div class="sparkle s2 absolute bottom-3 left-4 text-white/30">
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>

                        
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold text-gray-800"><?php echo e($badge->name); ?></h3>
                                <span class="text-xs px-2 py-1 rounded-full <?php echo e($style['bg']); ?> <?php echo e($style['text']); ?> font-medium">
                                    <?php echo e($style['label']); ?>

                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3"><?php echo e($badge->description); ?></p>

                            <?php if($context): ?>
                                <div class="flex items-center text-xs text-gray-500 bg-gray-50 rounded-lg px-3 py-2 mb-3">
                                    <i class="fas fa-bookmark mr-2 text-gray-400"></i>
                                    <span class="truncate"><?php echo e($context); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div class="flex items-center text-xs text-gray-400">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    <?php echo e($ub->earned_at ? $ub->earned_at->format('M d, Y') : 'Recently'); ?>

                                </div>
                                <div class="flex items-center text-xs font-medium <?php echo e($style['text']); ?>">
                                    <i class="fas fa-check-circle mr-1"></i> Earned
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    
    <?php
        $earnedBadgeIds = $badgeData->pluck('badge.id')->unique();
        $unearnedBadges = $allBadges->reject(fn($b) => $earnedBadgeIds->contains($b->id));
    ?>

    <?php if($unearnedBadges->isNotEmpty()): ?>
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4 fade-up">
                <i class="fas fa-lock text-gray-400 mr-2"></i> Badges to Unlock
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $unearnedBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="locked-card tilt-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 opacity-95 fade-up" style="animation-delay: <?php echo e(0.1 + ($i * 0.06)); ?>s">
                        <div class="lock-shine"></div>
                        
                        <div class="bg-gradient-to-r from-gray-300 to-gray-400 p-6 text-center relative overflow-hidden">
                            <div class="scanline"></div>
                            <div class="lock-icon w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto ring-4 ring-gray-300 backdrop-blur-sm relative z-10">
                                <i class="fas fa-lock text-gray-700 text-2xl"></i>
                            </div>
                        </div>

                        
                        <div class="p-5">
                            <h3 class="font-bold text-gray-600 mb-1"><?php echo e($badge->name); ?></h3>
                            <p class="text-sm text-gray-500 mb-3"><?php echo e($badge->description); ?></p>
                            <div class="flex items-center text-xs text-gray-400 mb-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                <?php if($badge->type === 'module_completion'): ?>
                                    Complete all quizzes in a module to unlock
                                <?php elseif($badge->type === 'quiz_perfect'): ?>
                                    Score 100% on a quiz to unlock
                                <?php elseif($badge->type === 'course_completion'): ?>
                                    Complete all modules in a course to unlock
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('courses.index')); ?>" class="explore-btn inline-flex items-center justify-center w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-arrow-right mr-2"></i> Explore courses
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    // Count-up animation for header stats
    var counters = document.querySelectorAll('.stat-num[data-count-target]');
    counters.forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count-target'), 10) || 0;
        var duration = 900;
        var startTime = null;

        function step(ts) {
            if (!startTime) startTime = ts;
            var progress = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target;
            }
        }
        requestAnimationFrame(step);
    });

    // Subtle 3D tilt on cards, mouse-tracked
    var tiltCards = document.querySelectorAll('.tilt-card');
    var isTouch = window.matchMedia('(pointer: coarse)').matches;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!isTouch && !reduceMotion) {
        tiltCards.forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var x = (e.clientX - rect.left) / rect.width - 0.5;
                var y = (e.clientY - rect.top) / rect.height - 0.5;
                var rotateX = (y * -8).toFixed(2);
                var rotateY = (x * 8).toFixed(2);
                card.style.transform = 'perspective(900px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-6px)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translateY(0)';
            });
        });
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/badges/badge.blade.php ENDPATH**/ ?>