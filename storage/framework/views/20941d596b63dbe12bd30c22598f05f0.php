<?php $__env->startSection('title', $sectionMeta['title'] ?? 'Student Report'); ?>
<?php $__env->startSection('page_title', $sectionMeta['title'] ?? 'Student Report'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Tokens ─────────────────────────────────────────── */
    .rpt-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --success:#16a34a; --danger:#dc2626;
               --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    @keyframes shimmer { 0%{background-position:-400px 0} 100%{background-position:400px 0} }
    .anim { opacity:0; animation:fadeUp .42s var(--ease) forwards; }
    .anim-1 { animation-delay:.04s; }
    .anim-2 { animation-delay:.08s; }
    .anim-3 { animation-delay:.13s; }
    .anim-4 { animation-delay:.18s; }

    /* ── Report Header Card ──────────────────────────────── */
    .rpt-header-card {
        background:#fff; border:1px solid var(--line); border-radius:18px;
        padding:1.5rem 2rem; margin-bottom:1.5rem;
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1.25rem;
        box-shadow:0 4px 16px -8px rgba(15,23,42,.06);
    }
    .rpt-title-area .rpt-breadcrumb { display:flex; align-items:center; gap:.5rem; font-size:.78rem; color:var(--muted); margin-bottom:.5rem; }
    .rpt-title-area .rpt-breadcrumb span { font-weight:600; }
    .rpt-title-area .rpt-breadcrumb .dot { width:3px; height:3px; border-radius:50%; background:var(--muted); }
    .rpt-title-area h1 { margin:0; font-size:1.5rem; font-weight:800; color:var(--ink); letter-spacing:-0.02em; }
    
    .chip { display:inline-flex; align-items:center; gap:.35rem; padding:.3rem .8rem; border-radius:999px; font-size:.75rem; font-weight:700; border:1px solid var(--line); background:var(--bg); color:var(--sub); }
    .chip.accent { background:#eff6ff; border-color:#bfdbfe; color:#1e40af; }
    
    /* ── Action Buttons ──────────────────────────────────── */
    .rpt-actions { display:flex; gap:.6rem; flex-wrap:wrap; }
    .btn-rpt { display:inline-flex; align-items:center; gap:.4rem; padding:.55rem 1.1rem; border-radius:8px;
        font-size:.85rem; font-weight:600; cursor:pointer; transition:all .15s ease; border:none; text-decoration:none; }
    .btn-rpt svg { width:15px; height:15px; }
    .btn-refresh { background:#f1f5f9; color:var(--ink); }
    .btn-refresh:hover { background:#e2e8f0; }
    .btn-pdf { background:var(--ink); color:#fff; }
    .btn-pdf:hover { background:#1e293b; transform:translateY(-1px); box-shadow:0 4px 10px -4px rgba(15,23,42,.4); }
    .btn-rog { background:#16a34a; color:#fff; }
    .btn-rog:hover { background:#15803d; transform:translateY(-1px); }

    /* ── Menu Sidebar ────────────────────────────────────── */
    .rpt-layout { display:grid; gap:1.5rem; grid-template-columns:240px 1fr; }
    @media (max-width:860px) { .rpt-layout { grid-template-columns:1fr; } }
    
    .rpt-menu { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.25rem; height:fit-content; box-shadow:0 4px 16px -8px rgba(15,23,42,.05); }
    .rpt-menu h3 { margin:0 0 1rem; font-size:.78rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); padding-bottom:.75rem; border-bottom:1px solid var(--line); }
    .rpt-menu nav { display:flex; flex-direction:column; gap:.25rem; }
    .rpt-menu a { display:block; padding:.65rem .9rem; border-radius:9px; font-size:.88rem; font-weight:600; color:var(--sub); text-decoration:none; transition:all .15s ease; }
    .rpt-menu a:hover { background:var(--bg); color:var(--ink); }
    .rpt-menu a.active { background:var(--ink); color:#fff; box-shadow:0 2px 8px -2px rgba(15,23,42,.3); }

    /* ── Content Wrapper ─────────────────────────────────── */
    .rpt-content-card { background:#fff; border:1px solid var(--line); border-radius:16px; overflow:hidden; box-shadow:0 4px 16px -8px rgba(15,23,42,.05); }

    /* ── Print ───────────────────────────────────────────── */
    @media print {
        .no-print, nav, aside, .rpt-actions, .btn-rpt, .rpt-menu, header { display:none !important; }
        .rpt-layout { grid-template-columns:1fr !important; }
        .rpt-header-card, .rpt-content-card { border:1px solid #ccc !important; box-shadow:none !important; }
        body { background:#fff !important; }
    }
</style>

<div class="rpt-page">
    
    <div class="rpt-header-card anim anim-1">
        <div class="rpt-title-area">
            <div class="rpt-breadcrumb">
                <span>Reports</span>
                <div class="dot"></div>
                <span><?php echo e($sectionMeta['title'] ?? 'Student Report'); ?></span>
                <div class="dot"></div>
                <span class="chip">Period: <?php echo e(session('current_period') ?? '2025-2'); ?></span>
            </div>
            <h1><?php echo e($sectionMeta['title'] ?? 'Student Report'); ?></h1>
        </div>
        
        <div class="rpt-actions no-print">
            <button type="button" class="btn-rpt btn-refresh" onclick="window.location.reload()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Refresh
            </button>
            <a href="<?php echo e(route('sias.student.reports.print', ['section' => $currentSection])); ?>" target="_blank" rel="noopener" class="btn-rpt btn-pdf">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print / PDF
            </a>
        </div>
    </div>

    <div class="rpt-layout">
        
        <?php
            $reportMenuItems = [
                ['route' => 'sias.student.reports.class-offerings',   'icon' => 'M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z', 'title' => 'Class Offerings'],
                ['route' => 'sias.student.reports.enrolled-subjects', 'icon' => 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20',                   'title' => 'Enrolled Subjects'],
                ['route' => 'sias.student.reports.final-grades-match','icon' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14',               'title' => 'Final Grades (Match)'],
                ['route' => 'sias.student.reports.final-grades-ignore','icon' => 'M22 11.08V12a10 10 0 1 1-5.93-9.14',              'title' => 'Final Grades (Ignore)'],
                ['route' => 'sias.student.reports.gwa-match',         'icon' => 'M18 20V10',                                         'title' => 'GWA (Match)'],
                ['route' => 'sias.student.reports.gwa-ignore',        'icon' => 'M18 20V10',                                         'title' => 'GWA (Ignore)'],
                ['route' => 'sias.student.reports.term-grades-match', 'icon' => 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01','title' => 'Term Grades (Match)'],
                ['route' => 'sias.student.reports.term-grades-ignore','icon' => 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01','title' => 'Term Grades (Ignore)'],
            ];
        ?>
        <div class="rpt-menu anim anim-2 no-print">
            <h3>Report Types</h3>
            <nav>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reportMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e(route($item['route'])); ?>" class="<?php echo e(request()->routeIs($item['route']) ? 'active' : ''); ?>">
                        <?php echo e($item['title']); ?>

                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </nav>
        </div>

        
        <div class="rpt-content-card anim anim-3">
            <?php echo $__env->make($sectionMeta['view'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\show.blade.php ENDPATH**/ ?>