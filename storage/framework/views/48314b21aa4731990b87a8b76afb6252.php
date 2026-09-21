

<?php $__env->startSection('title', 'Training Schedule'); ?>
<?php $__env->startSection('page_title', 'Training Schedule'); ?>

<?php $__env->startSection('content'); ?>

<?php
    // Small, real numbers derived from the data we already have — nothing invented.
    $totalSessions = $schedules->count();
    $trainingDays  = $schedules->pluck('day_of_week')->filter()->unique()->count();
    $venueCount    = $schedules->pluck('building')->filter()->unique()->count();
    $today         = now()->format('l'); // e.g. "Monday" — used to badge today's sessions.
?>

<div id="training-schedule-page" class="portal-page">
    <style>
        #training-schedule-page {
            --ts-blue: #0b2f6b;
            --ts-blue-deep: #071d45;
            --ts-blue-soft: rgba(11, 47, 107, .06);
            --ts-blue-line: rgba(11, 47, 107, .12);
            --ts-gold: #e0a512;
            --ts-gold-strong: #f0b429;
            --ts-gold-soft: rgba(240, 180, 41, .14);
            --ts-ink: #16233d;
            --ts-muted: #64748b;
            --ts-surface: #ffffff;
            --ts-bg: #f4f6fb;
        }

        #training-schedule-page .ts-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.75rem;
        }
        #training-schedule-page .ts-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--ts-gold);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            margin-bottom: .6rem;
        }
        #training-schedule-page .ts-kicker::before {
            content: '';
            width: .4rem;
            height: .4rem;
            border-radius: 50%;
            background: var(--ts-gold-strong);
        }
        #training-schedule-page .ts-header h2 {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 2rem;
            color: var(--ts-blue-deep);
            margin: 0 0 .4rem;
            letter-spacing: -.01em;
        }
        #training-schedule-page .ts-header p {
            color: var(--ts-muted);
            margin: 0;
            max-width: 46rem;
        }
        #training-schedule-page .ts-header-meta {
            font-size: .8rem;
            color: var(--ts-muted);
            text-align: right;
        }
        #training-schedule-page .ts-header-meta strong { color: var(--ts-blue); }

        #training-schedule-page .ts-alert {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-left: 4px solid #16a34a;
            color: #166534;
            padding: .85rem 1.1rem;
            border-radius: .7rem;
            margin-bottom: 1.5rem;
            font-size: .92rem;
        }

        #training-schedule-page .ts-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        #training-schedule-page .ts-stat {
            background: var(--ts-surface);
            border: 1px solid var(--ts-blue-line);
            border-top: 3px solid var(--ts-gold-strong);
            border-radius: .9rem;
            padding: 1.1rem 1.25rem;
            box-shadow: 0 6px 18px rgba(11, 47, 107, .05);
        }
        #training-schedule-page .ts-stat .num {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ts-blue-deep);
            line-height: 1;
        }
        #training-schedule-page .ts-stat .label {
            margin-top: .35rem;
            font-size: .78rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--ts-muted);
        }

        #training-schedule-page .portal-table-wrap {
            background: var(--ts-surface);
            border: 1px solid var(--ts-blue-line);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(11, 47, 107, .06);
        }
        #training-schedule-page .portal-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .92rem;
        }
        #training-schedule-page .portal-table thead th {
            background: linear-gradient(160deg, var(--ts-blue) 0%, var(--ts-blue-deep) 100%);
            color: #fff;
            text-align: left;
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            padding: .95rem 1.1rem;
        }
        #training-schedule-page .portal-table tbody td {
            padding: .95rem 1.1rem;
            border-bottom: 1px solid var(--ts-blue-line);
            color: var(--ts-ink);
            vertical-align: middle;
        }
        #training-schedule-page .portal-table tbody tr:last-child td { border-bottom: none; }
        #training-schedule-page .portal-table tbody tr:nth-child(even) { background: var(--ts-bg); }
        #training-schedule-page .portal-table tbody tr:hover { background: var(--ts-blue-soft); }

        #training-schedule-page .day-pill {
            display: inline-block;
            background: var(--ts-blue-soft);
            color: var(--ts-blue);
            font-weight: 700;
            font-size: .78rem;
            letter-spacing: .03em;
            padding: .28rem .7rem;
            border-radius: 999px;
        }
        #training-schedule-page .day-pill.is-today {
            background: var(--ts-blue);
            color: #fff;
        }
        #training-schedule-page .time-cell {
            font-variant-numeric: tabular-nums;
            color: var(--ts-ink);
            white-space: nowrap;
        }
        #training-schedule-page .program-cell strong { color: var(--ts-blue-deep); }
        #training-schedule-page .muted-cell { color: var(--ts-muted); }

        #training-schedule-page .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            padding: .3rem .65rem;
            border-radius: 999px;
        }
        #training-schedule-page .status-badge.today {
            background: var(--ts-gold-soft);
            color: #8a5a06;
        }
        #training-schedule-page .status-badge.today::before {
            content: '';
            width: .4rem; height: .4rem; border-radius: 50%;
            background: var(--ts-gold-strong);
        }
        #training-schedule-page .status-none { color: var(--ts-muted); font-size: .85rem; }

        #training-schedule-page .ts-empty {
            text-align: center;
            padding: 3.5rem 1.5rem;
            color: var(--ts-muted);
        }
        #training-schedule-page .ts-empty .icon { font-size: 2.2rem; margin-bottom: .6rem; }
        #training-schedule-page .ts-empty p { margin: .3rem 0; }
        #training-schedule-page .ts-empty .hint { font-size: .85rem; color: #93a1b8; }

        @media (max-width: 720px) {
            #training-schedule-page .ts-header { align-items: flex-start; }
            #training-schedule-page .ts-header-meta { text-align: left; }
            #training-schedule-page .portal-table-wrap { overflow-x: auto; }
            #training-schedule-page .portal-table { min-width: 720px; }
        }
    </style>

    <div class="ts-header">
        <div>
            <span class="ts-kicker">Teacher Portal · TESDA</span>
            <h2>Training Schedule</h2>
            <p>Review class days, venues, rooms, and trainer assignments.</p>
        </div>
        <div class="ts-header-meta">
            Today is <strong><?php echo e($today); ?></strong>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="ts-alert">
            <span aria-hidden="true">✅</span>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalSessions > 0): ?>
        <div class="ts-stats">
            <div class="ts-stat">
                <div class="num"><?php echo e($totalSessions); ?></div>
                <div class="label">Total Sessions</div>
            </div>
            <div class="ts-stat">
                <div class="num"><?php echo e($trainingDays); ?></div>
                <div class="label">Training Days</div>
            </div>
            <div class="ts-stat">
                <div class="num"><?php echo e($venueCount); ?></div>
                <div class="label">Venues in Use</div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="portal-table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Program</th>
                    <th>Subject</th>
                    <th>Venue</th>
                    <th>Room</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $isToday = $schedule->day_of_week === $today; ?>
                    <tr>
                        <td><span class="day-pill <?php echo e($isToday ? 'is-today' : ''); ?>"><?php echo e($schedule->day_of_week); ?></span></td>
                        <td class="time-cell"><?php echo e($schedule->start_time); ?> – <?php echo e($schedule->end_time); ?></td>
                        <td class="program-cell"><strong><?php echo e($schedule->course?->title ?? '—'); ?></strong></td>
                        <td><?php echo e($schedule->subject_name ?? '—'); ?></td>
                        <td class="muted-cell"><?php echo e($schedule->building ?? '—'); ?></td>
                        <td class="muted-cell"><?php echo e($schedule->room_number ?? '—'); ?></td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isToday): ?>
                                <span class="status-badge today">Today</span>
                            <?php else: ?>
                                <span class="status-none">—</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7">
                            <div class="ts-empty">
                                <div class="icon" aria-hidden="true">📅</div>
                                <p>No training schedules assigned yet.</p>
                                <p class="hint">Example: 9:00 AM – 10:30 AM, Room 20.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\schedule\index.blade.php ENDPATH**/ ?>