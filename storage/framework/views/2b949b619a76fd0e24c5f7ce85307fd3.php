<style>
    :root {
        --auth-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --auth-navy: #0a2540;
        --auth-navy-deep: #061829;
        --auth-navy-mid: #003a8f;
        --auth-sky: #93c5fd;
        --auth-border: #d1d9e2;
    }

    .auth-page {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6rem 1rem 3rem;
        background: linear-gradient(160deg, #f0f4fa 0%, #e8eef8 45%, #f4f6f9 100%);
        overflow: hidden;
    }

    .auth-blob {
        position: absolute;
        border-radius: 9999px;
        filter: blur(48px);
        pointer-events: none;
        animation: authBlob 12s ease-in-out infinite;
    }

    .auth-blob-1 {
        width: 22rem;
        height: 22rem;
        background: rgba(0, 58, 143, 0.22);
        top: -6rem;
        right: -4rem;
    }

    .auth-blob-2 {
        width: 18rem;
        height: 18rem;
        background: rgba(10, 37, 64, 0.18);
        bottom: -4rem;
        left: -3rem;
        animation-delay: 2s;
    }

    .auth-blob-3 {
        width: 14rem;
        height: 14rem;
        background: rgba(147, 197, 253, 0.35);
        top: 40%;
        left: 55%;
        animation-delay: 4s;
    }

    @keyframes authBlob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(12px, -16px) scale(1.08); }
    }

    .auth-card-wrap {
        width: 100%;
        max-width: 28rem;
        position: relative;
        z-index: 1;
    }

    .auth-card-wrap--wide {
        max-width: 32rem;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        border: 1px solid rgba(209, 217, 226, 0.9);
        box-shadow:
            0 4px 6px rgba(10, 37, 64, 0.04),
            0 24px 48px rgba(10, 37, 64, 0.12),
            0 0 0 1px rgba(255, 255, 255, 0.6) inset;
        overflow: hidden;
        animation: authCardEnter 0.9s var(--auth-ease) forwards;
    }

    @keyframes authCardEnter {
        0% {
            opacity: 0;
            transform: translateY(32px) scale(0.96);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .auth-header {
        position: relative;
        padding: 2rem 2rem 1.75rem;
        text-align: center;
        background: linear-gradient(145deg, var(--auth-navy-deep) 0%, var(--auth-navy) 40%, var(--auth-navy-mid) 100%);
        overflow: hidden;
    }

    .auth-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 30%, rgba(255, 255, 255, 0.12) 50%, transparent 70%);
        background-size: 200% 100%;
        animation: authShine 4s linear infinite;
        pointer-events: none;
    }

    @keyframes authShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .auth-logo-ring {
        width: 4.5rem;
        height: 4.5rem;
        margin: 0 auto 1rem;
        border-radius: 1.25rem;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        animation: authLogoFloat 4s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes authLogoFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    .auth-logo-ring img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .auth-header h1 {
        position: relative;
        z-index: 1;
        font-size: 1.75rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
        margin-bottom: 0.35rem;
    }

    .auth-header p {
        position: relative;
        z-index: 1;
        color: rgba(219, 228, 245, 0.95);
        font-size: 0.95rem;
    }

    .auth-body {
        padding: 2rem;
    }

    .auth-field {
        margin-bottom: 1.25rem;
    }

    .auth-field label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .auth-field label i {
        color: var(--auth-navy-mid);
        margin-right: 0.35rem;
        width: 1rem;
        text-align: center;
    }

    .auth-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--auth-border);
        border-radius: 0.75rem;
        background: #fff;
        color: #1f2937;
        font-size: 0.9375rem;
        transition:
            border-color 220ms var(--auth-ease),
            box-shadow 220ms var(--auth-ease),
            transform 220ms var(--auth-ease);
    }

    .auth-input:focus {
        outline: none;
        border-color: var(--auth-navy-mid);
        box-shadow: 0 0 0 4px rgba(0, 58, 143, 0.12);
        transform: translateY(-1px);
    }

    .auth-input-wrap {
        position: relative;
    }

    .auth-input-wrap .auth-input {
        padding-right: 2.75rem;
    }

    .auth-pw-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        padding: 0.35rem;
        border: none;
        background: none;
        cursor: pointer;
        transition: color 200ms var(--auth-ease);
    }

    .auth-pw-toggle:hover {
        color: var(--auth-navy-mid);
    }

    .auth-role-grid {
        display: grid;
        gap: 0.65rem;
    }

    .auth-role-btn {
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 9999px;
        font-size: 0.9375rem;
        font-weight: 600;
        border: 2px solid var(--auth-navy-mid);
        background: #fff;
        color: var(--auth-navy-mid);
        cursor: pointer;
        transition:
            background 280ms var(--auth-ease),
            color 280ms var(--auth-ease),
            transform 280ms var(--auth-ease),
            box-shadow 280ms var(--auth-ease),
            border-color 280ms var(--auth-ease);
    }

    .auth-role-btn:hover:not(.is-active) {
        background: #e5efff;
        transform: translateY(-2px);
    }

    .auth-role-btn.is-active {
        background: linear-gradient(135deg, var(--auth-navy-mid), var(--auth-navy));
        color: #fff;
        border-color: transparent;
        box-shadow: 0 8px 24px rgba(0, 58, 143, 0.35);
        transform: scale(1.02);
    }

    .auth-role-btn:active {
        transform: scale(0.98);
    }

    .auth-btn-primary {
        width: 100%;
        padding: 0.875rem 1.25rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1rem;
        color: #fff;
        background: linear-gradient(135deg, var(--auth-navy-mid) 0%, var(--auth-navy) 100%);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition:
            transform 220ms var(--auth-ease),
            box-shadow 220ms var(--auth-ease),
            filter 220ms var(--auth-ease);
        box-shadow: 0 8px 24px rgba(0, 58, 143, 0.3);
    }

    .auth-btn-primary:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(0, 58, 143, 0.38);
        filter: brightness(1.05);
    }

    .auth-btn-primary:active:not(:disabled) {
        transform: translateY(0);
    }

    .auth-btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .auth-btn-outline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 0.9375rem;
        color: var(--auth-navy-mid);
        border: 2px solid var(--auth-navy-mid);
        background: #fff;
        text-decoration: none;
        transition:
            background 220ms var(--auth-ease),
            transform 220ms var(--auth-ease),
            box-shadow 220ms var(--auth-ease);
    }

    .auth-btn-outline:hover {
        background: #e5efff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 58, 143, 0.12);
    }

    .auth-divider {
        position: relative;
        margin: 1.5rem 0;
        text-align: center;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: var(--auth-border);
    }

    .auth-divider span {
        position: relative;
        display: inline-block;
        padding: 0 0.75rem;
        background: rgba(255, 255, 255, 0.92);
        font-size: 0.8125rem;
        color: #6b7280;
    }

    .auth-footer-bar {
        padding: 1rem 2rem;
        text-align: center;
        font-size: 0.8125rem;
        color: #4b5563;
        background: #f4f6f9;
        border-top: 1px solid var(--auth-border);
    }

    .auth-footer-bar a {
        color: var(--auth-navy-mid);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer-bar a:hover {
        text-decoration: underline;
    }

    .auth-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        text-decoration: none;
        transition: color 200ms var(--auth-ease), transform 200ms var(--auth-ease);
    }

    .auth-back:hover {
        color: var(--auth-navy-mid);
        transform: translateX(-4px);
    }

    .auth-error {
        display: flex;
        align-items: flex-start;
        gap: 0.35rem;
        font-size: 0.8125rem;
        color: #c1121f;
        margin-top: 0.5rem;
        animation: authShake 0.45s var(--auth-ease);
    }

    @keyframes authShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    .auth-alert {
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        margin-bottom: 1.25rem;
        animation: authFadeIn 0.5s var(--auth-ease);
    }

    .auth-alert--success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .auth-alert--error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    @keyframes authFadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .auth-strength {
        height: 4px;
        border-radius: 9999px;
        background: #e5e7eb;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .auth-strength-bar {
        height: 100%;
        width: 0;
        border-radius: 9999px;
        transition: width 400ms var(--auth-ease), background 400ms var(--auth-ease);
    }

    .auth-strength-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.35rem;
    }

    .auth-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    [data-auth-animate] {
        opacity: 0;
        transform: translateY(18px);
    }

    [data-auth-animate].is-visible {
        animation: authFieldIn 0.65s var(--auth-ease) forwards;
    }

    @keyframes authFieldIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delay-1 { animation-delay: 80ms; }
    .delay-2 { animation-delay: 140ms; }
    .delay-3 { animation-delay: 200ms; }
    .delay-4 { animation-delay: 260ms; }
    .delay-5 { animation-delay: 320ms; }
    .delay-6 { animation-delay: 380ms; }
    .delay-7 { animation-delay: 440ms; }
    .delay-8 { animation-delay: 500ms; }
    .delay-9 { animation-delay: 560ms; }

    .auth-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
    }

    .auth-checkbox input {
        width: 1.1rem;
        height: 1.1rem;
        margin-top: 0.15rem;
        accent-color: var(--auth-navy-mid);
        flex-shrink: 0;
    }

    .auth-checkbox label {
        font-size: 0.8125rem;
        color: #4b5563;
        line-height: 1.45;
        margin: 0;
        font-weight: 400;
    }

    .auth-checkbox label a {
        color: var(--auth-navy-mid);
        font-weight: 600;
    }

    .auth-trust {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px dashed var(--auth-border);
    }

    .auth-trust span {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        color: #6b7280;
    }

    .auth-trust i {
        color: var(--auth-navy-mid);
    }

    @media (max-width: 480px) {
        .auth-grid-2 {
            grid-template-columns: 1fr;
        }

        .auth-body {
            padding: 1.5rem;
        }

        .auth-blob {
            opacity: 0.5;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .auth-card,
        [data-auth-animate].is-visible,
        .auth-blob,
        .auth-logo-ring,
        .auth-header::before {
            animation: none !important;
        }

        [data-auth-animate] {
            opacity: 1;
            transform: none;
        }

        .auth-card {
            opacity: 1;
            transform: none;
            filter: none;
        }
    }
</style>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\partials\polish-styles.blade.php ENDPATH**/ ?>