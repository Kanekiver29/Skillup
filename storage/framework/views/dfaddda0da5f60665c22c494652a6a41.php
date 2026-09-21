
<?php $__env->startSection('title', 'Enrollment Details'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
    --em-void:         var(--body-bg);
    --em-panel:        var(--surface);
    --em-panel-soft:   var(--topbar-control-bg);

    --em-accent:       #5eead4;
    --em-accent-dark:  #34d3bd;
    --em-accent-light: rgba(94,234,212,.12);
    --em-violet:       #8b7cf6;
    --em-violet-light: rgba(139,124,246,.12);

    --em-success:      #34d399;
    --em-success-bg:   rgba(52,211,153,.12);
    --em-warning:      #fbbf24;
    --em-warning-bg:   rgba(251,191,36,.12);
    --em-danger:       #fb7185;
    --em-danger-bg:    rgba(251,113,133,.12);

    --em-gray-100:     var(--topbar-control-bg);
    --em-gray-200:     var(--border);
    --em-gray-400:     var(--muted);
    --em-gray-600:     var(--muted);
    --em-gray-900:     var(--text);

    --em-radius:       12px;
    --em-radius-sm:    8px;
    --em-shadow:       0 1px 2px rgba(0,0,0,.08);

    --em-font:         'Inter', system-ui, sans-serif;
    --em-font-display: 'Space Grotesk', sans-serif;
    --em-font-mono:    'JetBrains Mono', monospace;
}

html[data-staff-theme="dark"] .em-page {
    --em-void:         #090c12;
    --em-panel:        #10141d;
    --em-panel-soft:   #131826;
    --em-gray-100:     #171c28;
    --em-gray-200:     #212739;
    --em-gray-400:     #838da3;
    --em-gray-600:     #aab2c4;
    --em-gray-900:     #e8ebf4;
    --em-shadow:       0 1px 2px rgba(0,0,0,.35);
}

.em-page {
    font-family: var(--em-font);
    color: var(--em-gray-900);
    max-width: 1300px;
    background: var(--em-void);
    border-radius: 18px;
    padding: 28px;
    position: relative;
    isolation: isolate;
    overflow: hidden;
}
.em-page::before {
    content: '';
    position: absolute; inset: 0; z-index: -2;
    background:
        radial-gradient(circle at 10% -10%, rgba(139,124,246,.16), transparent 42%),
        radial-gradient(circle at 100% 8%, rgba(94,234,212,.10), transparent 40%);
}
.em-page::after {
    content: '';
    position: absolute; inset: 0; z-index: -1;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 34px 34px;
    mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, black 25%, transparent 72%);
}

.em-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: var(--em-font-mono); font-size: 12px;
    color: var(--em-gray-400); text-decoration: none;
    margin-bottom: 14px; transition: color .15s ease, gap .15s ease;
}
.em-back:hover { color: var(--em-accent); gap: 9px; }

.em-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; flex-wrap: wrap; margin-bottom: 26px;
}
.em-header__eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: var(--em-font-mono); font-size: 11px; font-weight: 500;
    letter-spacing: .14em; text-transform: uppercase; color: var(--em-accent);
    margin-bottom: 6px;
}
.em-header__eyebrow-dot {
    width: 6px; height: 6px; border-radius: 50%; background: var(--em-accent);
    box-shadow: 0 0 0 3px var(--em-accent-light);
    animation: em-pulse 2.2s ease-in-out infinite;
}
.em-header__title {
    font-family: var(--em-font-display); font-size: 28px; font-weight: 700; letter-spacing: -.4px; line-height: 1.2;
    background: linear-gradient(120deg, #ffffff 10%, var(--em-accent) 60%, var(--em-violet) 100%);
    -webkit-background-clip: text; background-clip: text; color: transparent;
}
.em-header__subtitle { margin-top: 8px; font-size: 13.5px; color: var(--em-gray-400); }
.em-header__actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

.em-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 16px; border-radius: var(--em-radius-sm);
    font-size: 13.5px; font-weight: 600; font-family: var(--em-font);
    cursor: pointer; border: 1px solid transparent; text-decoration: none;
    transition: transform .15s ease, background .15s ease, box-shadow .15s ease, border-color .15s ease;
    white-space: nowrap;
}
.em-btn:focus-visible { outline: 2px solid var(--em-accent); outline-offset: 2px; }
.em-btn--primary {
    background: linear-gradient(135deg, var(--em-accent), #7ef0d8); color: #06120f;
    box-shadow: 0 4px 18px -6px rgba(94,234,212,.55);
}
.em-btn--primary:hover { transform: translateY(-1px); box-shadow: 0 6px 22px -6px rgba(94,234,212,.75); }
.em-btn--outline { background: rgba(255,255,255,.02); color: var(--em-gray-600); border: 1px solid var(--em-gray-200); }
.em-btn--outline:hover { background: var(--em-violet-light); border-color: var(--em-violet); color: var(--em-gray-900); transform: translateY(-1px); }
.em-btn--danger { background: var(--em-danger-bg); color: var(--em-danger); border: 1px solid rgba(251,113,133,.35); }
.em-btn--danger:hover { background: rgba(251,113,133,.2); transform: translateY(-1px); }

.em-card {
    position: relative;
    background: linear-gradient(180deg, var(--em-panel), var(--em-panel-soft));
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius);
    box-shadow: var(--em-shadow);
    overflow: hidden;
    padding: 26px;
}
.em-corner { position: absolute; width: 16px; height: 16px; border: 2px solid var(--em-accent); opacity: .55; pointer-events: none; }
.em-corner.tl { top: -1px; left: -1px; border-right: none; border-bottom: none; border-top-left-radius: 10px; }
.em-corner.tr { top: -1px; right: -1px; border-left: none; border-bottom: none; border-top-right-radius: 10px; }
.em-corner.bl { bottom: -1px; left: -1px; border-right: none; border-top: none; border-bottom-left-radius: 10px; }
.em-corner.br { bottom: -1px; right: -1px; border-left: none; border-top: none; border-bottom-right-radius: 10px; }

.em-section-label {
    font-family: var(--em-font-mono); font-size: 10.5px; letter-spacing: .14em; text-transform: uppercase;
    color: var(--em-gray-400); display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
}
.em-section-label::after { content: ''; flex: 1; height: 1px; background: var(--em-gray-200); }
.em-section-label svg { opacity: .8; }

.em-profile { display: flex; gap: 18px; align-items: center; margin-bottom: 22px; }
.em-profile__avatar {
    width: 68px; height: 68px; border-radius: 16px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--em-font-display); font-weight: 700; font-size: 24px; color: #06120f;
    box-shadow: 0 10px 28px -10px rgba(94,234,212,.4);
}
.em-profile__name { font-family: var(--em-font-display); font-weight: 700; font-size: 18px; color: var(--em-gray-900); }
.em-profile__email { font-family: var(--em-font-mono); font-size: 13px; color: var(--em-gray-400); margin-top: 4px; }
.em-profile__id { font-family: var(--em-font-mono); font-size: 12px; color: var(--em-gray-400); margin-top: 2px; }

.em-divider { border: none; border-top: 1px solid var(--em-gray-200); margin: 22px 0; }

.em-course-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 4px; }
.em-course-name { font-family: var(--em-font-display); font-weight: 600; font-size: 16px; color: var(--em-gray-900); }
.em-course-code {
    font-family: var(--em-font-mono); font-size: 11.5px; color: var(--em-accent);
    background: var(--em-accent-light); border: 1px solid rgba(94,234,212,.3);
    padding: 3px 10px; border-radius: 99px;
}

.em-meta-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 18px; }
@media (max-width: 640px) { .em-meta-grid { grid-template-columns: 1fr; } }
.em-meta-item {
    background: var(--em-void); border: 1px solid var(--em-gray-200); border-radius: var(--em-radius-sm);
    padding: 14px 16px;
}
.em-meta-item__label {
    display: flex; align-items: center; gap: 6px;
    font-family: var(--em-font-mono); font-size: 10.5px; letter-spacing: .1em; text-transform: uppercase;
    color: var(--em-gray-400); margin-bottom: 8px;
}
.em-meta-item__value { font-weight: 600; font-size: 14.5px; color: var(--em-gray-900); }

.em-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 10px; border-radius: 99px;
    font-family: var(--em-font-mono); font-size: 11.5px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .04em;
}
.em-badge__dot { width: 5px; height: 5px; border-radius: 50%; }
.em-badge--active   { background: var(--em-success-bg); color: var(--em-success); }
.em-badge--active .em-badge__dot { background: var(--em-success); box-shadow: 0 0 0 3px rgba(52,211,153,.16); animation: em-pulse 2.2s ease-in-out infinite; }
.em-badge--pending  { background: var(--em-warning-bg); color: var(--em-warning); }
.em-badge--pending .em-badge__dot { background: var(--em-warning); }
.em-badge--dropped  { background: var(--em-danger-bg);  color: var(--em-danger); }
.em-badge--dropped .em-badge__dot { background: var(--em-danger); }
.em-badge--complete { background: var(--em-accent-light); color: var(--em-accent); }
.em-badge--complete .em-badge__dot { background: var(--em-accent); }

.em-timeline { display: flex; gap: 28px; flex-wrap: wrap; margin-top: 20px; }
.em-timeline__item { min-width: 160px; }
.em-timeline__label {
    display: flex; align-items: center; gap: 6px;
    font-family: var(--em-font-mono); font-size: 10.5px; letter-spacing: .1em; text-transform: uppercase;
    color: var(--em-gray-400); margin-bottom: 6px;
}
.em-timeline__value { font-weight: 600; font-size: 14px; color: var(--em-gray-900); font-family: var(--em-font-mono); }

.em-progress-wrap { min-width: 220px; flex: 1; }
.em-progress-track {
    height: 8px; border-radius: 5px; background: var(--em-gray-200);
    overflow: hidden; margin-top: 8px;
}
.em-progress-fill {
    height: 100%; border-radius: 5px;
    background: linear-gradient(90deg, var(--em-accent), var(--em-violet));
    width: 0%;
    transition: width 1s cubic-bezier(.16,.84,.44,1);
    box-shadow: 0 0 12px rgba(94,234,212,.5);
}

@keyframes em-pulse { 0%, 100% { opacity: 1; } 50% { opacity: .45; } }

@media (prefers-reduced-motion: reduce) {
    .em-btn, .em-back, .em-header__eyebrow-dot, .em-badge__dot, .em-progress-fill { transition: none; animation: none; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $student = $enrollment->student ?? null;
    $studentName = $student?->name ?? $student?->full_name ?? $student?->username ?? null;
    if (is_object($studentName) && method_exists($studentName, '__toString')) {
        $studentName = (string) $studentName;
    } elseif (is_array($studentName)) {
        $studentName = json_encode($studentName);
    } elseif (!is_scalar($studentName) || trim((string) $studentName) === '') {
        $studentName = 'Unknown';
    }

    $studentEmail = $student?->email ?? '';
    if (is_object($studentEmail) && method_exists($studentEmail, '__toString')) {
        $studentEmail = (string) $studentEmail;
    } elseif (is_array($studentEmail)) {
        $studentEmail = json_encode($studentEmail);
    } elseif (!is_scalar($studentEmail)) {
        $studentEmail = '';
    }

    $studentId = $student?->student_id ?? $student?->lrn ?? $student?->id ?? null;
    if (is_object($studentId) && method_exists($studentId, '__toString')) {
        $studentId = (string) $studentId;
    } elseif (is_array($studentId)) {
        $studentId = json_encode($studentId);
    } elseif (!is_scalar($studentId) || trim((string) $studentId) === '') {
        $studentId = 'N/A';
    }

    $course = $enrollment->course ?? null;
    $courseName = $course?->name ?? $course?->course_title ?? $course?->title ?? null;
    if (is_object($courseName) && method_exists($courseName, '__toString')) {
        $courseName = (string) $courseName;
    } elseif (is_array($courseName)) {
        $courseName = json_encode($courseName);
    } elseif (!is_scalar($courseName) || trim((string) $courseName) === '') {
        $courseName = 'Unknown Course';
    }

    $courseCode = $course?->code ?? $course?->slug ?? '';
    if (is_object($courseCode) && method_exists($courseCode, '__toString')) {
        $courseCode = (string) $courseCode;
    } elseif (is_array($courseCode)) {
        $courseCode = json_encode($courseCode);
    } elseif (!is_scalar($courseCode)) {
        $courseCode = '';
    }

    $statusValue = $enrollment->status ?? ($enrollment->completed ? 'complete' : 'active');
    $progressValue = round($enrollment->progress ?? 0, 2);
    $avatarHue = crc32($studentName) % 360;
?>

<div class="em-page">
    <a href="<?php echo e(route('staff.enrollments.index')); ?>" class="em-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Back to enrollments
    </a>

    <div class="em-header">
        <div class="em-header__left">
            <div class="em-header__eyebrow">
                <span class="em-header__eyebrow-dot"></span>
                Staff Portal / Record View
            </div>
            <h1 class="em-header__title">Enrollment Details</h1>
            <p class="em-header__subtitle">Details for a single enrollment record.</p>
        </div>
        <div class="em-header__actions">
            <a href="<?php echo e(route('staff.enrollments.index')); ?>" class="em-btn em-btn--outline">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Back
            </a>
            <a href="<?php echo e(route('staff.enrollments.edit', $enrollment->id)); ?>" class="em-btn em-btn--primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form method="POST" action="<?php echo e(route('staff.enrollments.destroy', $enrollment->id)); ?>" onsubmit="return confirm('Remove this enrollment?')" style="display:inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="em-btn em-btn--danger">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Remove
                </button>
            </form>
        </div>
    </div>

    <div class="em-card">
        <div class="em-corner tl"></div><div class="em-corner tr"></div>
        <div class="em-corner bl"></div><div class="em-corner br"></div>

        <div class="em-section-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Student
        </div>
        <div class="em-profile">
            <div class="em-profile__avatar" style="background: linear-gradient(135deg, hsl(<?php echo e($avatarHue); ?>,75%,68%), hsl(<?php echo e(($avatarHue + 50) % 360); ?>,75%,60%));">
                <?php echo e(strtoupper(substr($studentName, 0, 1))); ?>

            </div>
            <div>
                <div class="em-profile__name"><?php echo e($studentName); ?></div>
                <div class="em-profile__email"><?php echo e($studentEmail ?: 'N/A'); ?></div>
                <div class="em-profile__id">ID: <?php echo e($studentId); ?></div>
            </div>
        </div>

        <hr class="em-divider">

        <div class="em-section-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            Course
        </div>
        <div class="em-course-row">
            <div>
                <div class="em-course-name"><?php echo e($courseName); ?></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courseCode): ?>
                <span class="em-course-code"><?php echo e($courseCode); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="em-meta-grid">
            <div class="em-meta-item">
                <div class="em-meta-item__label">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Year Level
                </div>
                <div class="em-meta-item__value"><?php echo e($enrollment->year_level ?? '—'); ?></div>
            </div>
            <div class="em-meta-item">
                <div class="em-meta-item__label">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
                    Section
                </div>
                <div class="em-meta-item__value"><?php echo e($enrollment->section ?? '—'); ?></div>
            </div>
            <div class="em-meta-item">
                <div class="em-meta-item__label">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    Status
                </div>
                <span class="em-badge em-badge--<?php echo e($statusValue); ?>">
                    <span class="em-badge__dot"></span>
                    <?php echo e(ucfirst($statusValue)); ?>

                </span>
            </div>
        </div>

        <hr class="em-divider">

        <div class="em-section-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Timeline &amp; progress
        </div>
        <div class="em-timeline">
            <div class="em-timeline__item">
                <div class="em-timeline__label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
                    Enrolled at
                </div>
                <div class="em-timeline__value"><?php echo e(optional($enrollment->enrolled_at)->format('M d, Y H:i') ?? optional($enrollment->created_at)->format('M d, Y H:i')); ?></div>
            </div>
            <div class="em-timeline__item">
                <div class="em-timeline__label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                    Last updated
                </div>
                <div class="em-timeline__value"><?php echo e(optional($enrollment->updated_at)->diffForHumans() ?? '-'); ?></div>
            </div>
            <div class="em-progress-wrap">
                <div class="em-timeline__label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                    Progress — <?php echo e($progressValue); ?>%
                </div>
                <div class="em-progress-track">
                    <div class="em-progress-fill" id="emProgressFill" data-progress="<?php echo e($progressValue); ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var fill = document.getElementById('emProgressFill');
    if (!fill) return;
    var target = parseFloat(fill.getAttribute('data-progress')) || 0;
    requestAnimationFrame(function () {
        fill.style.width = Math.min(Math.max(target, 0), 100) + '%';
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\enrollments\show.blade.php ENDPATH**/ ?>