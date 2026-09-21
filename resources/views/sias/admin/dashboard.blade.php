@extends('sias.admin.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<div class="dash-scope">

  <!-- Overview -->
  <div class="dash-overview-head">
    <div>
      <p class="dash-eyebrow-plain">Overview</p>
      <h2 class="dash-overview-title">Today at a glance</h2>
    </div>
    <div class="dash-live-badge"><span class="dash-live-dot"></span>Live</div>
  </div>

  <!-- Key Statistics -->
  <div class="dash-stat-grid">
    <!-- Total Users — featured -->
    <div class="admin-panel dash-stat-card dash-stat-hero" style="--i: 0">
      <div class="dash-stat-hero-sparkline" aria-hidden="true">
        @foreach($monthlyEnrollments as $i => $count)
          <span style="--h: {{ max(6, ($count / (max($monthlyEnrollments) ?: 1)) * 100) }}%; --i: {{ $i }};"></span>
        @endforeach
      </div>
      <div class="dash-stat-head">
        <div>
          <p class="dash-stat-label">Total Users</p>
          <h3 class="dash-stat-value dash-stat-value-lg" data-countup="{{ $userCount }}">0</h3>
        </div>
        <div class="dash-stat-icon">👥</div>
      </div>
      <p class="dash-stat-foot">
        <strong class="dash-text-ok">+{{ $newSignupsToday }}</strong> new today
      </p>
    </div>

    <!-- Active Courses -->
    <div class="admin-panel dash-stat-card" style="--i: 1">
      <div class="dash-stat-head">
        <div>
          <p class="dash-stat-label">Active Courses</p>
          <h3 class="dash-stat-value" data-countup="{{ $activeCourses }}">0</h3>
        </div>
        <div class="dash-stat-icon">📚</div>
      </div>
      <a href="{{ route('sias.admin.course') }}" class="dash-stat-link">View all courses <span class="dash-arrow">→</span></a>
    </div>

    <!-- Total Enrollments -->
    <div class="admin-panel dash-stat-card" style="--i: 2">
      <div class="dash-stat-head">
        <div>
          <p class="dash-stat-label">Total Enrollments</p>
          <h3 class="dash-stat-value" data-countup="{{ $enrollmentCount }}">0</h3>
        </div>
        <div class="dash-stat-icon">✅</div>
      </div>
      <a href="{{ route('sias.admin.enrollments') }}" class="dash-stat-link">Manage enrollments <span class="dash-arrow">→</span></a>
    </div>

    <!-- System Progress -->
    <div class="admin-panel dash-stat-card" style="--i: 3">
      <div>
        <p class="dash-stat-label">System Progress</p>
        <h3 class="dash-stat-value" data-countup="{{ $progress }}" data-suffix="%">0%</h3>
      </div>
      <div class="dash-track dash-track-lg" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="System progress">
        <div class="dash-fill" style="--w: {{ $progress }}%;"></div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="dash-chart-grid">
    <!-- Monthly Enrollment Trends -->
    <div class="admin-card" style="--i: 4">
      <h3 class="dash-card-title">Monthly Enrollment Trends</h3>
      <div class="dash-bars">
        @foreach($monthlyEnrollments as $i => $count)
          <div class="dash-bar-col">
            <div class="dash-bar dash-bar-accent"
                 style="height: {{ max(10, ($count / (max($monthlyEnrollments) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="{{ $count }} enrollments"></div>
            <small class="dash-bar-label">{{ $chartLabels[$i] }}</small>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Daily Activity (Last 7 Days) -->
    <div class="admin-card" style="--i: 5">
      <h3 class="dash-card-title">Daily Enrollments <span class="dash-card-title-muted">Last 7 days</span></h3>
      <div class="dash-bars">
        @foreach($dailyData as $i => $count)
          <div class="dash-bar-col">
            <div class="dash-bar dash-bar-green"
                 style="height: {{ max(10, ($count / (max($dailyData) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="{{ $count }} enrollments"></div>
            <small class="dash-bar-label">{{ $dailyLabels[$i] }}</small>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Weekly Enrollment -->
    <div class="admin-card" style="--i: 6">
      <h3 class="dash-card-title">Weekly Enrollments</h3>
      <div class="dash-bars">
        @foreach($weeklyData as $i => $count)
          <div class="dash-bar-col">
            <div class="dash-bar dash-bar-amber"
                 style="height: {{ max(10, ($count / (max($weeklyData) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="{{ $count }} enrollments"></div>
            <small class="dash-bar-label">{{ $weeklyLabels[$i] }}</small>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Enrollment by Category -->
    <div class="admin-card" style="--i: 7">
      <h3 class="dash-card-title">Enrollments by Course Category</h3>
      <div class="dash-category-list">
        @forelse($collegeLabels as $i => $label)
          <div class="dash-category-row" style="--i: {{ $i }};">
            <div class="dash-category-head">
              <span class="dash-category-name">{{ $label }}</span>
              <span class="dash-category-count">{{ $collegeData[$i] }}</span>
            </div>
            <div class="dash-track">
              <div class="dash-fill" style="--w: {{ max(0, ($collegeData[$i] / (max($collegeData) ?: 1)) * 100) }}%;"></div>
            </div>
          </div>
        @empty
          <p class="dash-empty">No category data yet.</p>
        @endforelse
      </div>
    </div>

    <!-- Yearly Overview -->
    <div class="admin-card" style="--i: 8">
      <h3 class="dash-card-title">Yearly Enrollments</h3>
      <div class="dash-bars dash-bars-wide">
        @foreach($yearlyData as $i => $count)
          <div class="dash-bar-col">
            <div class="dash-bar dash-bar-violet"
                 style="height: {{ max(10, ($count / (max($yearlyData) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="{{ $count }} enrollments"></div>
            <small class="dash-bar-label">{{ $yearlyLabels[$i] }}</small>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Recent Activity & Quick Actions -->
  <div class="dash-split-grid">
    <!-- Recent Users -->
    <div class="admin-card" style="--i: 9">
      <h3 class="dash-card-title">Recent User Registrations</h3>
      <div class="dash-activity-list">
        @forelse($recentUsers as $i => $user)
          <div class="dash-activity-item" style="--i: {{ $i }};">
            <div class="dash-avatar-wrap">
              <div class="dash-avatar">{{ strtoupper(substr($user->name ?? '?', 0, 1)) }}</div>
              @if(!$loop->last)<span class="dash-timeline-line"></span>@endif
            </div>
            <div class="dash-activity-info">
              <p class="dash-activity-name">{{ $user->name }}</p>
              <p class="dash-activity-email">{{ $user->email }}</p>
            </div>
            <div class="dash-activity-time">{{ $user->created_at->diffForHumans() }}</div>
          </div>
        @empty
          <p class="dash-empty">No recent users yet.</p>
        @endforelse
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card" style="--i: 10">
      <h3 class="dash-card-title">Quick Actions</h3>
      <div class="dash-quick-actions">
        <a href="{{ route('sias.admin.students.create') }}" class="dash-quick-action" style="--qa: 34, 211, 238;">
          <span class="dash-quick-icon">➕</span><span class="dash-quick-text">Add Student</span><span class="dash-quick-arrow">→</span>
        </a>
        <a href="{{ route('sias.admin.enrollments') }}" class="dash-quick-action" style="--qa: 34, 197, 94;">
          <span class="dash-quick-icon">✓</span><span class="dash-quick-text">Manage Enrollments</span><span class="dash-quick-arrow">→</span>
        </a>
        <a href="{{ route('sias.admin.students.index') }}" class="dash-quick-action" style="--qa: 59, 130, 246;">
          <span class="dash-quick-icon">👥</span><span class="dash-quick-text">View All Students</span><span class="dash-quick-arrow">→</span>
        </a>
        <a href="{{ route('sias.admin.course') }}" class="dash-quick-action" style="--qa: 244, 63, 94;">
          <span class="dash-quick-icon">📚</span><span class="dash-quick-text">Manage Courses</span><span class="dash-quick-arrow">→</span>
        </a>
        <a href="{{ route('sias.admin.subject') }}" class="dash-quick-action" style="--qa: 251, 146, 60;">
          <span class="dash-quick-icon">📖</span><span class="dash-quick-text">Manage Subjects</span><span class="dash-quick-arrow">→</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Monthly Signups Trend -->
  <div class="admin-card" style="--i: 11">
    <h3 class="dash-card-title">New User Signups vs Enrollments</h3>
    <div class="dash-bars dash-bars-tall">
      @foreach($monthlySignups as $i => $signups)
        <div class="dash-bar-col">
          <div class="dash-bar-pair">
            <div class="dash-bar dash-bar-thin dash-bar-cyan"
                 style="height: {{ max(5, ($signups / (max($monthlySignups) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="Signups: {{ $signups }}"></div>
            <div class="dash-bar dash-bar-thin dash-bar-purple"
                 style="height: {{ max(5, ($monthlyEnrollments[$i] / (max($monthlyEnrollments) ?: 1)) * 150) }}px; --i: {{ $i }};"
                 title="Enrollments: {{ $monthlyEnrollments[$i] }}"></div>
          </div>
          <small class="dash-bar-label">{{ $chartLabels[$i] }}</small>
        </div>
      @endforeach
    </div>
    <div class="dash-legend">
      <span class="dash-legend-item"><i class="dash-legend-swatch" style="background: rgba(34, 211, 238, .85);"></i>New Signups</span>
      <span class="dash-legend-item"><i class="dash-legend-swatch" style="background: rgba(168, 85, 247, .85);"></i>Enrollments</span>
    </div>
  </div>

</div>

<style>
  /* =========================================================
     Dashboard — premium refresh
     One orchestrated entrance choreography; all other motion
     responds to hover/focus. Tokens fall back gracefully if
     the master layout doesn't define them.
     ========================================================= */

  .dash-scope {
    --dash-ease: cubic-bezier(.16, 1, .3, 1);
    --dash-radius: 14px;
    --dash-radius-sm: 10px;
    --dash-border: var(--card-border, rgba(255,255,255,.08));
    --dash-muted: var(--text-muted, #8b93a1);
    --dash-accent: var(--accent, #22d3ee);
    --dash-accent-2: var(--accent-2, #a855f7);
  }

  /* ---------- Header ---------- */
  .dash-overview-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    opacity: 0;
    animation: dash-rise .6s var(--dash-ease) both;
  }
  .dash-eyebrow-plain {
    margin: 0 0 .25rem;
    font-size: .82rem;
    color: var(--dash-muted);
  }
  .dash-overview-title {
    margin: 0;
    font-family: var(--font-display, inherit);
    font-size: 1.5rem;
    letter-spacing: -.02em;
  }
  .dash-live-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .4rem .8rem;
    border-radius: 999px;
    border: 1px solid var(--dash-border);
    background: var(--pill-bg, rgba(255,255,255,.04));
    font-size: .78rem;
    color: var(--dash-muted);
    font-weight: 600;
  }
  .dash-live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 0 0 rgba(34,197,94,.6);
    animation: dash-pulse-dot 2.4s ease-out infinite;
  }
  @keyframes dash-pulse-dot {
    0%   { box-shadow: 0 0 0 0 rgba(34,197,94,.55); }
    70%  { box-shadow: 0 0 0 7px rgba(34,197,94,0); }
    100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
  }

  /* ---------- Entrance choreography (plays once) ---------- */
  .dash-stat-card,
  .dash-chart-grid > .admin-card,
  .dash-split-grid > .admin-card,
  .admin-card[style*="--i: 11"] {
    opacity: 0;
    animation: dash-rise .6s var(--dash-ease) both;
    animation-delay: calc(var(--i, 0) * 65ms + .1s);
  }
  @keyframes dash-rise {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @media (prefers-reduced-motion: reduce) {
    .dash-overview-head,
    .dash-stat-card,
    .dash-chart-grid > .admin-card,
    .dash-split-grid > .admin-card,
    .admin-card[style*="--i: 11"] { animation: none; opacity: 1; }
  }

  /* ---------- Card chrome (quiet, consistent) ---------- */
  .dash-stat-card,
  .dash-chart-grid > .admin-card,
  .dash-split-grid > .admin-card,
  .admin-card[style*="--i: 11"] {
    position: relative;
    border-radius: var(--dash-radius);
    border-top: 1px solid color-mix(in srgb, var(--dash-accent) 35%, var(--dash-border));
    box-shadow: 0 18px 40px -28px rgba(0,0,0,.55);
    transition: box-shadow .35s var(--dash-ease), transform .35s var(--dash-ease), border-color .35s var(--dash-ease);
  }
  .dash-stat-card:hover,
  .dash-chart-grid > .admin-card:hover,
  .dash-split-grid > .admin-card:hover,
  .admin-card[style*="--i: 11"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 24px 48px -26px rgba(0,0,0,.6);
  }

  .dash-text-ok { color: #22c55e; }

  /* ---------- Stat cards ---------- */
  .dash-stat-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(4, 1fr);
    margin-bottom: 2rem;
  }
  .dash-stat-card { display: flex; flex-direction: column; padding: 22px; min-height: 148px; }
  .dash-stat-hero {
    grid-column: span 2;
    background: linear-gradient(160deg, color-mix(in srgb, var(--dash-accent) 10%, transparent), transparent 60%);
    overflow: hidden;
  }
  .dash-stat-hero-sparkline {
    position: absolute;
    inset: auto 0 0 0;
    height: 44%;
    display: flex;
    align-items: flex-end;
    gap: 4px;
    padding: 0 22px;
    opacity: .35;
    pointer-events: none;
  }
  .dash-stat-hero-sparkline span {
    flex: 1;
    height: var(--h, 20%);
    background: linear-gradient(180deg, var(--dash-accent), transparent);
    border-radius: 3px 3px 0 0;
    transform: scaleY(0);
    transform-origin: bottom;
    animation: dash-bar-grow .5s var(--dash-ease) both;
    animation-delay: calc(var(--i, 0) * 35ms + .35s);
  }
  .dash-stat-value-lg { font-size: clamp(2.2rem, 3.4vw, 3rem); }

  .dash-stat-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; position: relative; z-index: 1; }
  .dash-stat-label { margin: 0 0 .5rem; color: var(--dash-muted); font-size: .88rem; font-weight: 500; }
  .dash-stat-value {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    font-family: var(--font-display, inherit);
    letter-spacing: -.03em;
    font-variant-numeric: tabular-nums;
  }
  .dash-stat-icon {
    font-size: 1.5rem;
    width: 46px; height: 46px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px;
    background: var(--accent-tint, rgba(34,211,238,.12));
    border: 1px solid var(--dash-border);
    flex-shrink: 0;
  }
  .dash-stat-foot { margin: .85rem 0 0; font-size: .85rem; color: var(--dash-muted); position: relative; z-index: 1; }
  .dash-stat-link {
    margin-top: .85rem; display: inline-flex; align-items: center; gap: .3rem;
    font-size: .85rem;
    color: var(--dash-accent); text-decoration: none; font-weight: 600;
  }
  .dash-arrow { display: inline-block; transition: transform .25s var(--dash-ease); }
  .dash-stat-link:hover .dash-arrow { transform: translateX(3px); }

  /* ---------- Track / fill ---------- */
  .dash-track {
    height: 8px;
    background: var(--pill-bg, rgba(255,255,255,.06));
    border: 1px solid var(--dash-border);
    border-radius: 999px;
    overflow: hidden;
  }
  .dash-track-lg { height: 6px; margin-top: 1rem; }
  .dash-fill {
    height: 100%;
    width: var(--w, 0%);
    background: linear-gradient(90deg, var(--dash-accent), var(--dash-accent-2));
    border-radius: 999px;
    transform-origin: left;
    animation: dash-fill-grow .8s var(--dash-ease) both;
    animation-delay: calc(var(--i, 0) * 55ms + .3s);
  }
  @keyframes dash-fill-grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }
  @media (prefers-reduced-motion: reduce) { .dash-fill, .dash-stat-hero-sparkline span { animation: none; transform: none; } }

  /* ---------- Chart cards ---------- */
  .dash-chart-grid {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fit, minmax(min(400px, 100%), 1fr));
    margin-bottom: 2rem;
  }
  .dash-chart-grid > .admin-card,
  .dash-split-grid > .admin-card,
  .admin-card[style*="--i: 11"] { padding: 22px; }

  .dash-card-title {
    display: flex; align-items: baseline; gap: .5rem;
    margin: 0 0 1.5rem;
    font-family: var(--font-display, inherit);
    font-size: 1rem;
    letter-spacing: -.01em;
  }
  .dash-card-title-muted { font-size: .78rem; font-weight: 400; color: var(--dash-muted); }

  .dash-bars {
    display: flex; align-items: flex-end; justify-content: space-between;
    height: 180px; gap: 8px;
    padding: 0 .35rem;
    border-bottom: 1px solid var(--dash-border);
  }
  .dash-bars-tall { height: 200px; gap: 4px; }
  .dash-bars-wide { gap: 12px; }
  .dash-bar-col { display: flex; flex-direction: column; align-items: center; flex: 1; min-width: 0; }
  .dash-bar-pair { width: 100%; display: flex; align-items: flex-end; justify-content: center; gap: 2px; height: 150px; }

  .dash-bar {
    width: 100%;
    border-radius: 5px 5px 2px 2px;
    transform-origin: bottom;
    transition: filter .2s var(--dash-ease), transform .2s var(--dash-ease);
    animation: dash-bar-grow .55s var(--dash-ease) both;
    animation-delay: calc(var(--i, 0) * 45ms + .15s);
  }
  .dash-bar:hover { filter: brightness(1.15); transform: scaleY(1.02); }
  .dash-bar-thin { width: 42%; }
  @keyframes dash-bar-grow { from { transform: scaleY(0); opacity: .4; } to { transform: scaleY(1); opacity: 1; } }
  @media (prefers-reduced-motion: reduce) { .dash-bar { animation: none; } }

  .dash-bar-accent { background: linear-gradient(180deg, var(--dash-accent), var(--dash-accent-2)); }
  .dash-bar-green  { background: linear-gradient(180deg, #22c55e, #16a34a); }
  .dash-bar-amber  { background: linear-gradient(180deg, #f59e0b, #d97706); }
  .dash-bar-violet { background: linear-gradient(180deg, #8b5cf6, #6d28d9); }
  .dash-bar-cyan   { background: rgba(34, 211, 238, .75); }
  .dash-bar-purple { background: rgba(168, 85, 247, .75); }
  .dash-bar-cyan:hover   { background: rgba(34, 211, 238, 1); }
  .dash-bar-purple:hover { background: rgba(168, 85, 247, 1); }

  .dash-bar-label { margin-top: .6rem; color: var(--dash-muted); font-size: .74rem; text-align: center; }

  .dash-legend { margin-top: 1.5rem; display: flex; gap: 2rem; flex-wrap: wrap; }
  .dash-legend-item { display: inline-flex; align-items: center; gap: .5rem; font-size: .85rem; color: var(--dash-muted); }
  .dash-legend-swatch { display: inline-block; width: 10px; height: 10px; border-radius: 3px; }

  /* ---------- Category list ---------- */
  .dash-category-list { display: flex; flex-direction: column; gap: 1.1rem; }
  .dash-category-head { display: flex; justify-content: space-between; margin-bottom: .5rem; gap: 8px; }
  .dash-category-name { font-size: .88rem; font-weight: 500; }
  .dash-category-count { color: var(--dash-accent); font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }

  /* ---------- Recent activity ---------- */
  .dash-split-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
  .dash-activity-list { display: flex; flex-direction: column; }
  .dash-activity-item {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: .65rem 0;
    transition: transform .25s var(--dash-ease);
  }
  .dash-activity-item:hover { transform: translateX(3px); }
  .dash-avatar-wrap { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
  .dash-avatar {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--dash-accent), var(--dash-accent-2));
    display: flex; align-items: center; justify-content: center;
    color: var(--accent-text, #06131a); font-weight: 700; font-size: .9rem;
  }
  .dash-timeline-line { width: 1px; flex: 1; min-height: 18px; margin-top: 4px; background: var(--dash-border); }
  .dash-activity-info { flex: 1; min-width: 0; padding-top: .1rem; }
  .dash-activity-name, .dash-activity-email {
    margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .dash-activity-name { font-weight: 500; }
  .dash-activity-email { margin-top: .2rem; font-size: .82rem; color: var(--dash-muted); }
  .dash-activity-time { font-size: .8rem; color: var(--dash-muted); text-align: right; white-space: nowrap; padding-top: .15rem; }

  .dash-empty { text-align: center; padding: 2rem; color: var(--dash-muted); margin: 0; }

  /* ---------- Quick actions ---------- */
  .dash-quick-actions { display: flex; flex-direction: column; gap: .6rem; }
  .dash-quick-action {
    display: flex; align-items: center; gap: .75rem;
    padding: .7rem .85rem;
    background: rgba(var(--qa), .07);
    border: 1px solid rgba(var(--qa), .22);
    border-radius: var(--dash-radius-sm);
    color: rgb(var(--qa));
    text-decoration: none;
    font-weight: 500;
    font-size: .92rem;
    transition: background .25s var(--dash-ease), border-color .25s var(--dash-ease), transform .25s var(--dash-ease);
  }
  .dash-quick-action:hover {
    background: rgba(var(--qa), .15);
    border-color: rgba(var(--qa), .5);
    transform: translateX(3px);
  }
  .dash-quick-icon {
    font-size: 1.05rem;
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(var(--qa), .16);
    flex-shrink: 0;
  }
  .dash-quick-text { flex: 1; }
  .dash-quick-arrow { opacity: 0; transform: translateX(-4px); transition: opacity .25s var(--dash-ease), transform .25s var(--dash-ease); }
  .dash-quick-action:hover .dash-quick-arrow { opacity: 1; transform: translateX(0); }

  /* ---------- Responsive ---------- */
  @media (max-width: 1200px) {
    .dash-stat-grid { grid-template-columns: repeat(2, 1fr); }
    .dash-stat-hero { grid-column: span 2; }
    .dash-chart-grid { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
  }
  @media (max-width: 768px) {
    .dash-stat-grid { grid-template-columns: 1fr; }
    .dash-stat-hero { grid-column: span 1; }
    .dash-chart-grid { grid-template-columns: 1fr; }
    .dash-split-grid { grid-template-columns: 1fr; }
    .dash-activity-time { display: none; }
    .dash-overview-head { flex-direction: column; align-items: flex-start; gap: .5rem; }
  }
  @media (max-width: 480px) {
    .dash-stat-value { font-size: 1.6rem; }
    .dash-bars, .dash-bars-tall { height: 140px; }
    .dash-bar-pair { height: 110px; }
  }
</style>

<script>
  (function () {
    var reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ---- Count-up animation for stat values ----
    document.querySelectorAll('[data-countup]').forEach(function (el) {
      var raw = el.getAttribute('data-countup');
      var suffix = el.getAttribute('data-suffix') || '';
      var target = parseFloat(String(raw).replace(/[^0-9.\-]/g, ''));

      if (!isFinite(target)) { el.textContent = raw + suffix; return; }
      if (reduceMotion) { el.textContent = raw + suffix; return; }

      var duration = 900;
      var start = null;

      var step = function (ts) {
        if (start === null) start = ts;
        var progress = Math.min(1, (ts - start) / duration);
        var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
        var value = Math.round(target * eased);
        el.textContent = value.toLocaleString() + suffix;
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = raw + suffix;
      };

      requestAnimationFrame(step);
    });
  })();

  // Auto-refresh dashboard data every 30 seconds
  function refreshDashboardData() {
    fetch('{{ route("admin.liveData") }}', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .catch(error => console.warn('Dashboard auto-refresh: ', error));
  }

  // Optional: uncomment to enable live refresh
  // setInterval(refreshDashboardData, 30000);
</script>
@endsection