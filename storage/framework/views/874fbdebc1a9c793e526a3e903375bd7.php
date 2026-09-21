<style>
    :root {
        --admin-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --admin-navy: #0a2540;
        --admin-navy-deep: #061829;
        --admin-navy-mid: #003a8f;
        --admin-sky: #93c5fd;
    }

    /* Visible by default — hidden only when JS enables animations */
    [data-admin-animate] {
        opacity: 1;
        transform: none;
        filter: none;
    }

    html.admin-animate-enabled [data-admin-animate]:not(.admin-visible) {
        opacity: 0;
        transform: translateY(20px);
        filter: blur(4px);
    }

    html.admin-animate-enabled [data-admin-animate].admin-visible {
        animation: adminFadeUp 0.75s var(--admin-ease) forwards;
    }

    .admin-delay-1 { animation-delay: 80ms; }
    .admin-delay-2 { animation-delay: 140ms; }
    .admin-delay-3 { animation-delay: 200ms; }
    .admin-delay-4 { animation-delay: 260ms; }
    .admin-delay-5 { animation-delay: 320ms; }

    @keyframes adminFadeUp {
        to { opacity: 1; transform: translateY(0); filter: blur(0); }
    }

    .admin-page-hero {
        background: linear-gradient(135deg, var(--admin-navy-deep) 0%, var(--admin-navy) 45%, var(--admin-navy-mid) 100%);
        border-radius: 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .admin-page-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(255,255,255,0.08) 50%, transparent 65%);
        background-size: 200% 100%;
        animation: adminShine 4s linear infinite;
        pointer-events: none;
    }

    @keyframes adminShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .admin-stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        transition: transform 280ms var(--admin-ease), box-shadow 280ms var(--admin-ease), border-color 280ms var(--admin-ease);
        position: relative;
        overflow: hidden;
    }

    .admin-stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--admin-navy-mid), var(--admin-sky));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 400ms var(--admin-ease);
    }

    .admin-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 44px rgba(10, 37, 64, 0.1);
        border-color: #93c5fd;
    }

    .admin-stat-card:hover::after {
        transform: scaleX(1);
    }

    .admin-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        transition: transform 280ms var(--admin-ease), box-shadow 280ms var(--admin-ease);
    }

    .admin-card:hover {
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    }

    .admin-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        transition: transform 200ms var(--admin-ease), box-shadow 200ms var(--admin-ease), filter 200ms var(--admin-ease);
    }

    .admin-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 58, 143, 0.2);
    }

    .admin-btn-primary {
        background: linear-gradient(135deg, var(--admin-navy-mid), var(--admin-navy));
        color: #fff;
    }

    .admin-btn-secondary {
        background: #f1f5f9;
        color: var(--admin-navy);
        border: 1px solid #cbd5e1;
    }

    .admin-btn-success {
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff;
    }

    .admin-btn-warning {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: #fff;
    }

    .admin-table-wrap {
        overflow: hidden;
        border-radius: 1rem;
    }

    .admin-table tbody tr {
        transition: background 200ms ease, transform 200ms var(--admin-ease);
    }

    .admin-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.002);
    }

    .admin-staff-chip {
        transition: transform 280ms var(--admin-ease), box-shadow 280ms var(--admin-ease);
    }

    .admin-staff-chip:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 58, 143, 0.12);
    }

    .admin-alert {
        animation: adminFadeUp 0.5s var(--admin-ease) forwards;
        border-radius: 0.75rem;
    }

    .admin-filter-bar {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
    }

    .admin-live-dot {
        animation: adminPulse 2s ease-in-out infinite;
    }

    @keyframes adminPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.15); }
    }

    @media (prefers-reduced-motion: reduce) {
        html.admin-animate-enabled [data-admin-animate] {
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
            animation: none !important;
        }

        .admin-page-hero::before {
            animation: none !important;
        }
        .admin-stat-card:hover,
        .admin-btn:hover,
        .admin-table tbody tr:hover {
            transform: none;
        }
    }\n\n.glass-card {\n    background: rgba(255,255,255,0.08);\n    backdrop-filter: blur(12px);\n    border: 1px solid rgba(255,255,255,0.12);\n    transition: transform 0.3s var(--admin-ease), box-shadow 0.3s var(--admin-ease);\n}\n.glass-card:hover {\n    transform: translateY(-4px);\n    box-shadow: 0 12px 28px rgba(0,58,143,0.12);\n}
</style>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\partials\polish-styles.blade.php ENDPATH**/ ?>