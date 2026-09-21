

<?php $__env->startSection('title', 'Help'); ?>
<?php $__env->startSection('page_title', 'Help'); ?>

<?php $__env->startSection('content'); ?>
<div class="help-page">

    <div class="help-hero">
        <div class="help-hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>
        <div>
            <h2>Help &amp; Support</h2>
            <p>Find documentation, frequently asked questions, and contact options for student support.</p>
        </div>
    </div>

    <section class="section-block reveal" style="--delay: 0.05s">
        <h3><span class="section-dot"></span>Frequently Asked Questions</h3>

        <div class="faq-list">
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How do I enroll in a course?</span>
                    <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Go to the <strong>Course Registration</strong> page from your dashboard, select the term, and click <strong>Enroll</strong> next to the course you want to join.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How do I view my grades?</span>
                    <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Open the <strong>Grades</strong> section in your student portal to view grades per term, once your instructor has posted them.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>How do I contact support?</span>
                    <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Email <a href="mailto:support@example.com">support@example.com</a> or open a ticket via the <strong>Documents / Requests</strong> page.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block reveal" style="--delay: 0.15s">
        <h3><span class="section-dot"></span>Contact Support</h3>
        <p class="section-lead">Still need help? Reach us through either of the options below.</p>

        <div class="contact-grid">
            <a href="mailto:support@example.com" class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div>
                    <span class="contact-title">Email Support</span>
                    <span class="contact-sub">support@example.com</span>
                </div>
            </a>

            <a href="<?php echo e(route('sias.student.documents')); ?>" class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <div>
                    <span class="contact-title">Open a Ticket</span>
                    <span class="contact-sub">Documents / Requests page</span>
                </div>
            </a>
        </div>
    </section>

</div>

<style>
.help-page {
    max-width: 820px;
    margin: 0 auto;
    animation: help-fade-in 0.5s ease both;
}

.help-hero {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 24px;
    margin-bottom: 20px;
    border-radius: 14px;
    background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
    border: 1px solid #e5e7eb;
}
.help-hero-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #4f46e5;
    color: #fff;
    animation: help-pop 0.6s ease 0.1s both;
}
.help-hero h2 {
    margin: 0 0 4px;
    font-size: 1.4rem;
    font-weight: 700;
    color: #1f2937;
}
.help-hero p {
    margin: 0;
    color: #6b7280;
    line-height: 1.5;
}

.section-block {
    padding: 22px 24px;
    margin-bottom: 18px;
    border-radius: 14px;
    background: #fff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
.section-block h3 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 14px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
}
.section-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4f46e5;
    flex-shrink: 0;
}
.section-lead {
    margin: -6px 0 16px;
    color: #6b7280;
    font-size: 0.925rem;
}

.reveal {
    opacity: 0;
    transform: translateY(14px);
    animation: help-fade-in 0.5s ease forwards;
    animation-delay: var(--delay, 0s);
}

/* FAQ accordion */
.faq-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.faq-item {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.faq-item:hover {
    border-color: #c7d2fe;
}
.faq-question {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 16px;
    background: #fafafa;
    border: none;
    text-align: left;
    font-size: 0.95rem;
    font-weight: 500;
    color: #1f2937;
    cursor: pointer;
    transition: background 0.2s ease;
}
.faq-question:hover {
    background: #f3f4f6;
}
.faq-chevron {
    flex-shrink: 0;
    color: #6b7280;
    transition: transform 0.3s ease;
}
.faq-item.active .faq-chevron {
    transform: rotate(180deg);
    color: #4f46e5;
}
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.35s ease;
    background: #fff;
}
.faq-item.active .faq-answer {
    max-height: 200px;
    padding: 4px 16px 16px;
}
.faq-answer p {
    margin: 0;
    color: #4b5563;
    line-height: 1.55;
    font-size: 0.9rem;
}
.faq-answer a {
    color: #4f46e5;
    text-decoration: none;
}
.faq-answer a:hover {
    text-decoration: underline;
}

/* Contact cards */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 12px;
}
.contact-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.contact-card:hover {
    transform: translateY(-3px);
    border-color: #c7d2fe;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.12);
}
.contact-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eef2ff;
    color: #4f46e5;
}
.contact-title {
    display: block;
    font-weight: 600;
    color: #1f2937;
    font-size: 0.925rem;
}
.contact-sub {
    display: block;
    color: #6b7280;
    font-size: 0.825rem;
    margin-top: 2px;
}

@keyframes help-fade-in {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes help-pop {
    from { opacity: 0; transform: scale(0.7); }
    to { opacity: 1; transform: scale(1); }
}

@media (max-width: 640px) {
    .help-hero { flex-direction: column; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.faq-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.faq-item');
            var wasActive = item.classList.contains('active');

            document.querySelectorAll('.faq-item.active').forEach(function (openItem) {
                openItem.classList.remove('active');
            });

            if (!wasActive) {
                item.classList.add('active');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\help\index.blade.php ENDPATH**/ ?>