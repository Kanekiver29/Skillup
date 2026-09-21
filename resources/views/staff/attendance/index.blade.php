@extends('staff.layouts.masters')

@section('title', 'Attendance')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
        --paper:      #F7F4EC;
        --paper-line: #FFFFFF;
        --card:       #FFFFFF;
        --ink:        #23201A;
        --ink-soft:   #6E675A;
        --ink-faint:  #A79E8E;
        --rule:       #E1D9C7;
        --rule-soft:  #ECE6D8;
        --sage:       #4B6355;
        --sage-tint:  #EAEFE9;
        --rust:       #A3402F;
        --rust-tint:  #F5E9E4;
        --mustard:    #B07E1F;
        --mustard-tint: #F6EEDC;
    }

    .font-display { font-family: 'Fraunces', ui-serif, Georgia, serif; font-optical-sizing: auto; }
    .font-mono    { font-family: 'JetBrains Mono', ui-monospace, 'SFMono-Regular', Menlo, monospace; }

    .att-page { background-color: var(--paper); }
    .att-page::before {
        content: "";
        position: fixed;
        inset: 0;
        pointer-events: none;
        background-image:
            linear-gradient(var(--rule-soft) 1px, transparent 1px);
        background-size: 100% 32px;
        opacity: 0.35;
        z-index: 0;
    }

    @keyframes revealHero {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fillTrack {
        from { width: 0%; }
        to   { width: var(--fill-to, 0%); }
    }
    @keyframes stampIn {
        0%   { opacity: 0; transform: rotate(-8deg) scale(0.7); }
        60%  { opacity: 1; transform: rotate(-4deg) scale(1.05); }
        100% { opacity: 1; transform: rotate(-4deg) scale(1); }
    }

    .hero-card { padding: 28px; }
    .hero-reveal { opacity: 0; animation: revealHero 0.5s cubic-bezier(0.22, 1, 0.36, 1) 0.05s forwards; }
    .track-fill  { width: 0%; animation: fillTrack 1s cubic-bezier(0.22, 1, 0.36, 1) 0.35s forwards; }
    .status-stamp { animation: stampIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both; }

    @media (prefers-reduced-motion: reduce) {
        .hero-reveal, .track-fill, .status-stamp {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            width: var(--fill-to, 0%) !important;
        }
    }

    .ledger-card {
        background: var(--card);
        border: 1px solid var(--rule);
        border-radius: 4px;
    }

    .marker-pin {
        left: var(--pin-left, 0%);
        transform: translateX(-50%);
    }

    .tick {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 1px;
        background: var(--rule);
    }

    .punch-card {
        border: 1px solid var(--rule);
        border-radius: 3px;
        background: var(--card);
        transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .punch-card.is-active { border-color: rgba(75, 99, 85, 0.35); }
    .punch-card:focus-within, .punch-card:hover { background: var(--paper); }
    .punch-card:focus-within { outline: 1.5px solid var(--ink); outline-offset: -1.5px; }

    .punch-dot {
        width: 9px; height: 9px; border-radius: 9999px;
        border: 1.5px solid var(--ink-faint);
        background: transparent;
    }
    .punch-dot.filled {
        border-color: var(--sage);
        background: var(--sage);
    }

    .stamp-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
        border: 1.5px solid currentColor;
        border-radius: 9999px;
        transform: rotate(-4deg);
        white-space: nowrap;
    }
    .stamp-on-track  { color: var(--sage); }
    .stamp-attention { color: var(--mustard); }
    .stamp-streak    { color: var(--rust); }

    .ruler {
        position: relative;
        height: 34px;
        margin-top: 32px;
    }
    .ruler-pin {
        position: absolute;
        top: -6px;
        transform: translate(-50%, -100%);
        font-size: 12px;
        font-weight: 600;
        padding: 3px 7px;
        border-radius: 4px;
        white-space: nowrap;
    }
    .ruler-track {
        position: absolute;
        left: 0;
        right: 0;
        top: 15px;
        height: 3px;
        border-radius: 9999px;
        overflow: hidden;
    }
    .ruler-ticks {
        position: absolute;
        inset: 0;
    }
    .ruler-label {
        position: absolute;
        bottom: 0;
        font-size: 11px;
    }
    .ruler-label.start { left: 0; }
    .ruler-label.end   { right: 0; }

    .empty-card { padding: 40px 24px; text-align: center; }
    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin: 0 auto 12px;
        border-radius: 9999px;
        font-size: 12px;
    }

    /* ---- Structural layout (kept out of Tailwind so it renders
       consistently no matter how/whether Tailwind is compiled) ---- */

    .att-wrap {
        position: relative;
        z-index: 1;
        max-width: 720px;
        margin: 0 auto;
        padding: 32px 20px 56px;
    }

    .att-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 28px;
    }
    .att-header h1 { font-size: 26px; }
    .att-badges { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding-top: 2px; }

    .hero-top {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 6px 16px;
    }
    .hero-figure { font-size: 40px; line-height: 1; }
    .hero-figure small { font-size: 22px; color: var(--ink-faint); font-weight: 400; }

    .stat-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px 32px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--rule);
    }
    .stat-item { display: flex; flex-direction: column; gap: 2px; min-width: 88px; }
    .stat-label { font-size: 11px; color: var(--ink-faint); }
    .stat-value { font-size: 14px; font-weight: 600; color: var(--ink); }

    .week-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .week-grid {
        display: grid;
        grid-template-columns: repeat(var(--day-count, 5), minmax(0, 1fr));
        gap: 8px;
    }
    .punch-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 8px;
    }

    @media (max-width: 768px) {
        .hero-card { padding: 22px; }
        .att-header { align-items: flex-start; }
        .att-badges { width: 100%; justify-content: flex-start; }
        .week-heading {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }

    @media (max-width: 640px) {
        .att-wrap { padding: 24px 16px 40px; }
        .att-header h1 { font-size: 22px; }
        .hero-figure { font-size: 32px; }
        .hero-figure small { font-size: 18px; }
        .stat-row { gap: 16px 24px; }

        .week-grid {
            grid-template-columns: none;
            grid-auto-flow: column;
            grid-auto-columns: minmax(84px, 1fr);
            overflow-x: auto;
            padding-bottom: 4px;
            scroll-snap-type: x proximity;
            -webkit-overflow-scrolling: touch;
        }
        .punch-card { scroll-snap-align: start; }
    }

    @media (max-width: 480px) {
        .hero-card { padding: 18px; }
        .att-header { margin-bottom: 20px; }
        .att-badges { gap: 8px; }
        .hero-top { flex-direction: column; align-items: flex-start; }
        .stat-row { margin-top: 22px; padding-top: 16px; }
        .stat-item { min-width: 72px; }
        .week-grid { grid-auto-columns: minmax(74px, 1fr); }
    }

    @media (max-width: 380px) {
        .att-wrap { padding: 20px 12px 32px; }
        .att-header h1 { font-size: 20px; }
        .hero-figure { font-size: 28px; }
        .hero-figure small { font-size: 16px; }
        .hero-top { gap: 4px; }
    }
</style>

@php
    $hoursLogged = $attendance['hours_logged'];
    $targetHours = $attendance['target_hours'];
    $progressPct = $targetHours > 0
        ? min(100, round(($hoursLogged / $targetHours) * 100))
        : 0;

    $days = $attendance['days'] ?? [];
    $totalDays = count($days);
    $activeDays = collect($days)->where('state', 'active')->count();
    $onTrack = $progressPct >= 80;
    $hoursRemaining = max($targetHours - $hoursLogged, 0);
    $avgPerActiveDay = $activeDays > 0 ? round($hoursLogged / $activeDays, 1) : 0;

    // Keep the pin label inside the track even at 0% or 100%.
    $pinLeftPct = max(4, min(96, $progressPct));

    $streak = 0;
    foreach (array_reverse($days) as $day) {
        if ($day['state'] === 'active') {
            $streak++;
        } else {
            break;
        }
    }

    // Optional week-over-week comparison — only rendered if the controller supplies it.
    $lastWeekHours = $attendance['last_week_hours'] ?? null;
    $hoursDelta = $lastWeekHours !== null ? round($hoursLogged - $lastWeekHours, 1) : null;
@endphp

<div class="att-page relative min-h-full">
    <div class="att-wrap">

        {{-- Header --}}
        <div class="att-header">
            <div>
                <h1 class="font-display font-semibold leading-tight" style="color: var(--ink);">Attendance</h1>
                <p class="mt-1 text-sm" style="color: var(--ink-soft);">Logged hours and daily status, this week.</p>
            </div>

            @if($totalDays > 0)
                <div class="att-badges">
                    @if($streak >= 2)
                        <span class="status-stamp stamp-badge stamp-streak inline-flex items-center px-3 py-1 text-xs font-semibold font-mono" style="animation-delay: 300ms;">
                            {{ $streak }}-day streak
                        </span>
                    @endif
                    <span
                        class="status-stamp stamp-badge {{ $onTrack ? 'stamp-on-track' : 'stamp-attention' }} inline-flex items-center px-3 py-1 text-xs font-semibold font-mono"
                        role="status"
                    >
                        {{ $onTrack ? 'On track' : 'Needs attention' }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Hero: hours + ruler-style progress track --}}
        <div class="ledger-card hero-card hero-reveal">
            <div class="hero-top">
                <p class="font-display hero-figure" style="color: var(--ink);">
                    {{ number_format($hoursLogged, 1) }}<small> / {{ number_format($targetHours, 1) }}h</small>
                </p>
                @if($hoursDelta !== null && $hoursDelta != 0)
                    <p class="text-xs font-mono font-medium" style="color: {{ $hoursDelta > 0 ? 'var(--sage)' : 'var(--mustard)' }};">
                        {{ $hoursDelta > 0 ? '+' : '' }}{{ $hoursDelta }}h vs last week
                    </p>
                @endif
            </div>
            <p class="mt-1 text-sm" style="color: var(--ink-soft);">hours logged this week</p>

            {{-- Ruler track --}}
            <div class="mt-8 relative" style="height: 34px;">
                @if($totalDays > 0 || $targetHours > 0)
                    <div class="marker-pin absolute -top-1 -translate-y-full font-mono text-xs font-semibold px-1.5 py-0.5 rounded"
                         style="--pin-left: {{ $pinLeftPct }}%; background: var(--ink); color: var(--paper);"
                         role="img" aria-label="{{ $progressPct }} percent of target hours completed">
                        {{ $progressPct }}%
                    </div>
                @endif
                <div class="absolute left-0 right-0 top-[15px] h-[3px] rounded-full overflow-hidden" style="background: var(--rule-soft);"
                     role="progressbar" aria-valuenow="{{ $progressPct }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progress toward weekly target hours">
                    <div class="track-fill h-full rounded-full" style="--fill-to: {{ $progressPct }}%; background: {{ $onTrack ? 'var(--sage)' : 'var(--mustard)' }};"></div>
                </div>
                <div class="absolute left-0 right-0 top-0" style="height: 34px;" aria-hidden="true">
                    @for ($i = 0; $i <= 10; $i++)
                        <span class="tick" style="left: {{ $i * 10 }}%; top: 10px; bottom: 10px;"></span>
                    @endfor
                </div>
                <span class="absolute left-0 bottom-0 text-[11px] font-mono" style="color: var(--ink-faint);">0h</span>
                <span class="absolute right-0 bottom-0 text-[11px] font-mono" style="color: var(--ink-faint);">{{ number_format($targetHours, 0) }}h</span>
            </div>

            {{-- Compact stats --}}
            <div class="stat-row">
                <div class="stat-item">
                    <span class="stat-label">Remaining</span>
                    <span class="stat-value font-mono">{{ number_format($hoursRemaining, 1) }}h</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Avg / active day</span>
                    <span class="stat-value font-mono">{{ number_format($avgPerActiveDay, 1) }}h</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Days active</span>
                    <span class="stat-value font-mono">{{ $activeDays }} / {{ $totalDays }}</span>
                </div>
            </div>
        </div>

        {{-- Weekly punch cards --}}
        <div class="mt-6">
            <div class="week-heading">
                <h2 class="font-display text-lg font-semibold" style="color: var(--ink);">This week</h2>
                @if($totalDays > 0)
                    <span class="text-xs font-mono" style="color: var(--ink-faint);">{{ $activeDays }}/{{ $totalDays }} logged</span>
                @endif
            </div>

            @if($totalDays > 0)
                <ul class="week-grid" style="--day-count: {{ min($totalDays, 7) }};">
                    @foreach($days as $day)
                        @php $isActive = $day['state'] === 'active'; @endphp
                        <li class="punch-card {{ $isActive ? 'is-active' : '' }}" tabindex="0">
                            <span class="text-xs font-medium" style="color: var(--ink-soft);">{{ $day['label'] }}</span>
                            <span class="punch-dot {{ $isActive ? 'filled' : '' }}" aria-hidden="true"></span>
                            <span class="text-xs font-mono tabular-nums" style="color: {{ $isActive ? 'var(--ink)' : 'var(--ink-faint)' }};">
                                @if($isActive && isset($day['hours']))
                                    {{ number_format($day['hours'], 1) }}h
                                @else
                                    &mdash;
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="ledger-card text-center py-10">
                    <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-full" style="border: 1.5px dashed var(--rule);" aria-hidden="true">
                        <span class="font-mono text-xs" style="color: var(--ink-faint);">--</span>
                    </div>
                    <p class="text-sm font-medium" style="color: var(--ink-soft);">No attendance records yet</p>
                    <p class="text-xs mt-1" style="color: var(--ink-faint);">Daily status will appear here once the week begins.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection