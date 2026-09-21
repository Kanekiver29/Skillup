
<?php $__env->startSection('title', 'My Classes / Batches'); ?>
<?php $__env->startSection('page_title', 'My Classes / Batches'); ?>
<?php $__env->startSection('subtitle', 'Batches, trainees, training status and schedules'); ?>

<?php $__env->startSection('content'); ?>

<?php
  /*
   | Defensive accessors.
   | Only relations that actually exist on the model are touched, so this view
   | works whether or not your Course model defines schedules/subjects/batches.
   | $courses may be a Collection or a Paginator — both are handled.
   */
  $has = function ($model, $relation) {
      return $model && method_exists($model, $relation);
  };

  $items = $courses instanceof \Illuminate\Contracts\Pagination\Paginator
      || $courses instanceof \Illuminate\Pagination\AbstractPaginator
          ? collect($courses->items())
          : collect($courses);

  $statusOf = function ($course) {
      $raw = $course->getAttribute('status') ?? $course->getAttribute('training_status');
      if ($raw) return \Illuminate\Support\Str::lower($raw);

      $start = $course->getAttribute('start_date');
      $end   = $course->getAttribute('end_date');
      $today = now();

      if ($start && $today->lt(\Illuminate\Support\Carbon::parse($start))) return 'upcoming';
      if ($end && $today->gt(\Illuminate\Support\Carbon::parse($end)))    return 'completed';
      if ($start || $end) return 'ongoing';
      return 'ongoing';
  };

  $progressOf = function ($course) {
      $start = $course->getAttribute('start_date');
      $end   = $course->getAttribute('end_date');
      if (!$start || !$end) return null;

      $start = \Illuminate\Support\Carbon::parse($start);
      $end   = \Illuminate\Support\Carbon::parse($end);
      $total = $start->diffInDays($end);
      if ($total <= 0) return null;

      $done = $start->diffInDays(now(), false);
      return (int) max(0, min(100, round($done / $total * 100)));
  };

  // Portfolio totals shown in the summary strip
  $totalTrainees = $items->sum(fn ($c) => $has($c, 'enrollments') ? $c->enrollments->count() : 0);
  $statusCounts  = $items->groupBy(fn ($c) => $statusOf($c))->map->count();
  $capacityTotal = $items->sum(fn ($c) => (int) ($c->getAttribute('capacity') ?? $c->getAttribute('slots') ?? 0));
?>

<div class="classes-page">

  
  <section class="class-summary" aria-label="Portfolio summary">
    <div class="summary-item">
      <span class="summary-value"><?php echo e($items->count()); ?></span>
      <span class="summary-label">Assigned <?php echo e(\Illuminate\Support\Str::plural('batch', $items->count())); ?></span>
    </div>
    <div class="summary-item">
      <span class="summary-value"><?php echo e(number_format($totalTrainees)); ?></span>
      <span class="summary-label">Trainees enrolled</span>
    </div>
    <div class="summary-item">
      <span class="summary-value"><?php echo e($statusCounts['ongoing'] ?? 0); ?></span>
      <span class="summary-label">Ongoing</span>
    </div>
    <div class="summary-item">
      <span class="summary-value"><?php echo e($statusCounts['upcoming'] ?? 0); ?></span>
      <span class="summary-label">Not yet started</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($capacityTotal > 0): ?>
      <div class="summary-item">
        <span class="summary-value"><?php echo e($capacityTotal - $totalTrainees); ?></span>
        <span class="summary-label">Open slots</span>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </section>

  
  <section class="class-toolbar" aria-label="Filter classes">
    <div class="search-field">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
        <circle cx="11" cy="11" r="7"></circle><line x1="16.5" y1="16.5" x2="21" y2="21"></line>
      </svg>
      <input id="classSearch" type="search" autocomplete="off" placeholder="Search by program, code or venue" aria-label="Search classes">
    </div>

    <div class="filter-chips" role="group" aria-label="Filter by status">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['all' => 'All', 'ongoing' => 'Ongoing', 'upcoming' => 'Upcoming', 'completed' => 'Completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <button type="button" class="chip <?php echo e($key === 'all' ? 'is-active' : ''); ?>" data-filter="<?php echo e($key); ?>" aria-pressed="<?php echo e($key === 'all' ? 'true' : 'false'); ?>">
          <?php echo e($label); ?>

        </button>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <label class="sort-field">
      <span class="sr-only">Sort classes</span>
      <select id="classSort" aria-label="Sort classes">
        <option value="title">Program name</option>
        <option value="trainees">Most trainees</option>
        <option value="start">Start date</option>
      </select>
    </label>
  </section>

  
  <div class="class-grid" id="classGrid">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
      <?php
        $title     = $course->title ?? $course->name ?? 'Untitled program';
        $code      = $course->getAttribute('code') ?? $course->getAttribute('course_code');
        $enrolled  = $has($course, 'enrollments') ? $course->enrollments->count() : 0;
        $capacity  = (int) ($course->getAttribute('capacity') ?? $course->getAttribute('slots') ?? 0);
        $status    = $statusOf($course);
        $progress  = $progressOf($course);
        $start     = $course->getAttribute('start_date');
        $end       = $course->getAttribute('end_date');
        $venue     = $course->getAttribute('venue') ?? $course->getAttribute('room');
        $hours     = $course->getAttribute('duration_hours') ?? $course->getAttribute('hours');
        $schedules = $has($course, 'schedules') ? $course->schedules : collect();
        $subjects  = $has($course, 'subjects')  ? $course->subjects  : collect();

        $statusLabels = ['ongoing' => 'Ongoing', 'upcoming' => 'Not yet started', 'completed' => 'Completed'];

        $sortStart = $start ? \Illuminate\Support\Carbon::parse($start)->timestamp : 0;
        $haystack  = \Illuminate\Support\Str::lower(trim($title . ' ' . $code . ' ' . $venue));
      ?>

      <article class="class-card"
               data-status="<?php echo e($status); ?>"
               data-title="<?php echo e(\Illuminate\Support\Str::lower($title)); ?>"
               data-trainees="<?php echo e($enrolled); ?>"
               data-start="<?php echo e($sortStart); ?>"
               data-search="<?php echo e($haystack); ?>">

        <header class="card-head">
          <div class="card-heading">
            <h3><?php echo e($title); ?></h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($code): ?>
              <p class="card-code"><?php echo e($code); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
          <span class="status-tag status-<?php echo e($status); ?>"><?php echo e($statusLabels[$status] ?? ucfirst($status)); ?></span>
        </header>

        <dl class="card-facts">
          <div>
            <dt>Trainees</dt>
            <dd><?php echo e($enrolled); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($capacity > 0): ?><span class="fact-muted"> / <?php echo e($capacity); ?></span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></dd>
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start || $end): ?>
            <div>
              <dt>Training period</dt>
              <dd>
                <?php echo e($start ? \Illuminate\Support\Carbon::parse($start)->format('d M Y') : '—'); ?>

                &ndash;
                <?php echo e($end ? \Illuminate\Support\Carbon::parse($end)->format('d M Y') : '—'); ?>

              </dd>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hours): ?>
            <div>
              <dt>Duration</dt>
              <dd><?php echo e($hours); ?> hours</dd>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($venue): ?>
            <div>
              <dt>Venue</dt>
              <dd><?php echo e($venue); ?></dd>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </dl>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($capacity > 0): ?>
          <?php $fill = (int) min(100, round($enrolled / max(1, $capacity) * 100)); ?>
          <div class="meter" role="img" aria-label="<?php echo e($fill); ?> percent of slots filled">
            <span class="meter-fill" style="width: <?php echo e($fill); ?>%"></span>
          </div>
          <p class="meter-note"><?php echo e(max(0, $capacity - $enrolled)); ?> slots remaining</p>
        <?php elseif(!is_null($progress)): ?>
          <div class="meter" role="img" aria-label="<?php echo e($progress); ?> percent of the training period elapsed">
            <span class="meter-fill" style="width: <?php echo e($progress); ?>%"></span>
          </div>
          <p class="meter-note"><?php echo e($progress); ?>% of the training period elapsed</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedules->isNotEmpty()): ?>
          <ul class="schedule-list">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $schedules->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
              <?php
                $day  = $schedule->getAttribute('day') ?? $schedule->getAttribute('day_of_week');
                $from = $schedule->getAttribute('start_time');
                $to   = $schedule->getAttribute('end_time');
              ?>
              <li>
                <span class="schedule-day"><?php echo e($day ?? 'Scheduled'); ?></span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($from || $to): ?>
                  <span class="schedule-time">
                    <?php echo e($from ? \Illuminate\Support\Carbon::parse($from)->format('g:i A') : ''); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($from && $to): ?> – <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php echo e($to ? \Illuminate\Support\Carbon::parse($to)->format('g:i A') : ''); ?>

                  </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedules->count() > 3): ?>
              <li class="schedule-more">+<?php echo e($schedules->count() - 3); ?> more sessions</li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </ul>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->isNotEmpty()): ?>
          <p class="subject-line">
            <?php echo e($subjects->count()); ?> <?php echo e(\Illuminate\Support\Str::plural('subject', $subjects->count())); ?>:
            <?php echo e($subjects->take(3)->map(fn ($s) => $s->title ?? $s->name)->filter()->implode(', ')); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->count() > 3): ?>…<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <footer class="card-actions">
          <a class="action action-primary" href="<?php echo e(route('teacher.courses.show', $course)); ?>">View program</a>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Illuminate\Support\Facades\Route::has('teacher.courses.trainees')): ?>
            <a class="action" href="<?php echo e(route('teacher.courses.trainees', $course)); ?>">Trainees</a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Illuminate\Support\Facades\Route::has('teacher.attendance.index')): ?>
            <a class="action" href="<?php echo e(route('teacher.attendance.index', ['course' => $course->getKey()])); ?>">Attendance</a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Illuminate\Support\Facades\Route::has('teacher.grades.index')): ?>
            <a class="action" href="<?php echo e(route('teacher.grades.index', ['course' => $course->getKey()])); ?>">Grades</a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </footer>
      </article>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
      <div class="class-empty">
        <h3>No classes assigned yet</h3>
        <p>Batches appear here once the registrar assigns you to a program. Ask the admin office to add you as the assigned trainer.</p>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>

  
  <div class="class-empty" id="noMatches" hidden>
    <h3>No batches match this view</h3>
    <p>Clear the search box or choose a different status to see the rest of your classes.</p>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courses instanceof \Illuminate\Contracts\Pagination\Paginator
      || $courses instanceof \Illuminate\Pagination\AbstractPaginator): ?>
    <div class="class-pagination"><?php echo e($courses->withQueryString()->links()); ?></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<style>
  .classes-page { display: flex; flex-direction: column; gap: 22px; }

  .sr-only {
    position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
    overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0;
  }

  /* ---- Summary strip ---- */
  .class-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1px;
    background: var(--line, rgba(19,28,43,.11));
    border: 1px solid var(--line, rgba(19,28,43,.11));
    border-radius: var(--r-lg, 14px);
    overflow: hidden;
  }
  .summary-item {
    background: var(--surface, #fff);
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .summary-value {
    font-family: var(--font-title, Georgia, serif);
    font-size: 1.75rem;
    font-weight: 500;
    line-height: 1.1;
    font-variant-numeric: tabular-nums;
    letter-spacing: -.02em;
  }
  .summary-label { font-size: .82rem; color: var(--ink-soft, #5d6b80); }

  /* ---- Toolbar ---- */
  .class-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
  }
  .search-field {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1 1 260px;
    min-width: 0;
    height: 38px;
    padding: 0 12px;
    background: var(--surface, #fff);
    border: 1px solid var(--line, rgba(19,28,43,.11));
    border-radius: var(--r-sm, 6px);
    color: var(--ink-faint, #8a97a8);
  }
  .search-field input {
    flex: 1;
    min-width: 0;
    border: 0;
    outline: 0;
    background: transparent;
    font: inherit;
    font-size: .9rem;
    color: var(--ink, #131c2b);
  }
  .search-field:focus-within { border-color: var(--ink-faint, #8a97a8); }

  .filter-chips { display: flex; gap: 4px; flex-wrap: wrap; }
  .chip {
    height: 38px;
    padding: 0 14px;
    border-radius: var(--r-sm, 6px);
    border: 1px solid var(--line, rgba(19,28,43,.11));
    background: var(--surface, #fff);
    color: var(--ink-soft, #5d6b80);
    font: inherit;
    font-size: .85rem;
    font-weight: 500;
    cursor: pointer;
    transition: color .13s ease, border-color .13s ease, background .13s ease;
  }
  .chip:hover { color: var(--ink, #131c2b); }
  .chip.is-active {
    background: var(--navy, #0d2f63);
    border-color: var(--navy, #0d2f63);
    color: var(--navy-ink, #fff);
  }

  .sort-field select {
    height: 38px;
    padding: 0 10px;
    border-radius: var(--r-sm, 6px);
    border: 1px solid var(--line, rgba(19,28,43,.11));
    background: var(--surface, #fff);
    color: var(--ink, #131c2b);
    font: inherit;
    font-size: .85rem;
    cursor: pointer;
  }

  /* ---- Cards ---- */
  .class-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    align-items: start;
  }
  .class-card {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding: 20px;
    background: var(--surface, #fff);
    border: 1px solid var(--line, rgba(19,28,43,.11));
    border-radius: var(--r-lg, 14px);
    transition: border-color .13s ease;
  }
  .class-card:hover { border-color: var(--ink-faint, #8a97a8); }
  .class-card[hidden] { display: none; }

  .card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
  .card-heading h3 {
    margin: 0;
    font-family: var(--font-title, Georgia, serif);
    font-size: 1.14rem;
    font-weight: 500;
    line-height: 1.25;
    letter-spacing: -.01em;
  }
  .card-code { margin: 3px 0 0; font-size: .8rem; color: var(--ink-faint, #8a97a8); }

  .status-tag {
    flex-shrink: 0;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: .72rem;
    font-weight: 600;
    border: 1px solid currentColor;
    white-space: nowrap;
  }
  .status-ongoing   { color: var(--success, #1a6b3e); }
  .status-upcoming  { color: var(--warning, #a8750a); }
  .status-completed { color: var(--ink-faint, #8a97a8); }

  .card-facts {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px 14px;
    margin: 0;
    padding-top: 12px;
    border-top: 1px solid var(--line-soft, rgba(19,28,43,.06));
  }
  .card-facts dt { font-size: .76rem; color: var(--ink-faint, #8a97a8); }
  .card-facts dd { margin: 1px 0 0; font-size: .9rem; font-weight: 500; }
  .fact-muted { color: var(--ink-faint, #8a97a8); font-weight: 400; }

  .meter {
    height: 5px;
    border-radius: 99px;
    background: var(--surface-sunk, rgba(19,28,43,.06));
    overflow: hidden;
  }
  .meter-fill { display: block; height: 100%; background: var(--navy, #0d2f63); }
  .meter-note { margin: -8px 0 0; font-size: .78rem; color: var(--ink-soft, #5d6b80); }

  .schedule-list {
    list-style: none;
    margin: 0;
    padding: 12px 0 0;
    border-top: 1px solid var(--line-soft, rgba(19,28,43,.06));
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: .84rem;
  }
  .schedule-list li { display: flex; justify-content: space-between; gap: 12px; }
  .schedule-day { color: var(--ink, #131c2b); }
  .schedule-time { color: var(--ink-soft, #5d6b80); font-variant-numeric: tabular-nums; }
  .schedule-more { color: var(--ink-faint, #8a97a8); }

  .subject-line { margin: 0; font-size: .84rem; color: var(--ink-soft, #5d6b80); }

  .card-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid var(--line-soft, rgba(19,28,43,.06));
  }
  .action {
    padding: 7px 12px;
    border-radius: var(--r-sm, 6px);
    border: 1px solid var(--line, rgba(19,28,43,.11));
    font-size: .84rem;
    font-weight: 500;
    color: var(--ink-soft, #5d6b80);
    text-decoration: none;
    transition: color .13s ease, border-color .13s ease;
  }
  .action:hover { color: var(--ink, #131c2b); border-color: var(--ink-faint, #8a97a8); }
  .action-primary {
    background: var(--navy, #0d2f63);
    border-color: var(--navy, #0d2f63);
    color: var(--navy-ink, #fff);
  }
  .action-primary:hover { color: #fff; border-color: var(--navy, #0d2f63); }

  .class-empty {
    grid-column: 1 / -1;
    padding: 34px 24px;
    text-align: center;
    border: 1px dashed var(--line, rgba(19,28,43,.11));
    border-radius: var(--r-lg, 14px);
    background: var(--surface, #fff);
  }
  .class-empty h3 {
    margin: 0 0 6px;
    font-family: var(--font-title, Georgia, serif);
    font-weight: 500;
    font-size: 1.1rem;
  }
  .class-empty p { margin: 0 auto; max-width: 48ch; color: var(--ink-soft, #5d6b80); font-size: .9rem; }

  .class-pagination { display: flex; justify-content: center; }

  @media (max-width: 560px) {
    .class-grid { grid-template-columns: 1fr; }
    .card-facts { grid-template-columns: 1fr; }
    .class-toolbar > * { flex: 1 1 100%; }
    .sort-field select { width: 100%; }
  }
</style>

<script>
  (function () {
    var grid = document.getElementById('classGrid');
    if (!grid) return;

    var cards    = Array.prototype.slice.call(grid.querySelectorAll('.class-card'));
    var search   = document.getElementById('classSearch');
    var sortSel  = document.getElementById('classSort');
    var chips    = Array.prototype.slice.call(document.querySelectorAll('.chip'));
    var noMatch  = document.getElementById('noMatches');
    var status   = 'all';

    if (!cards.length) return;

    function apply() {
      var term = (search && search.value || '').trim().toLowerCase();
      var visible = 0;

      cards.forEach(function (card) {
        var matchesStatus = status === 'all' || card.dataset.status === status;
        var matchesTerm   = !term || (card.dataset.search || '').indexOf(term) !== -1;
        var show = matchesStatus && matchesTerm;
        card.hidden = !show;
        if (show) visible++;
      });

      if (noMatch) noMatch.hidden = visible !== 0;
    }

    function sort(mode) {
      var sorted = cards.slice().sort(function (a, b) {
        if (mode === 'trainees') return Number(b.dataset.trainees) - Number(a.dataset.trainees);
        if (mode === 'start')    return Number(b.dataset.start) - Number(a.dataset.start);
        return (a.dataset.title || '').localeCompare(b.dataset.title || '');
      });
      sorted.forEach(function (card) { grid.appendChild(card); });
    }

    if (search) search.addEventListener('input', apply);

    chips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        status = chip.dataset.filter;
        chips.forEach(function (c) {
          var on = c === chip;
          c.classList.toggle('is-active', on);
          c.setAttribute('aria-pressed', String(on));
        });
        apply();
      });
    });

    if (sortSel) sortSel.addEventListener('change', function () { sort(sortSel.value); });

    sort('title');
    apply();
  })();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/teacher/classes/index.blade.php ENDPATH**/ ?>