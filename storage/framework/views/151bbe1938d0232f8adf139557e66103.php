

<?php $__env->startSection('title', 'About SkillUp - Personalized Web Learning for Youth Career Development'); ?>
<?php $__env->startSection('content'); ?>

<style>
    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --bg: #f3f5fb;
        --text: #101b2e;
        --text-muted: #5b6b85;
        --card-bg: #ffffff;
        --card-border: rgba(16, 27, 46, .06);
        --accent: #c9973b;
        --accent-strong: #e0b054;
    }

    html.dark-mode {
        --bg: #070a13;
        --text: #e7ebf5;
        --text-muted: #8b96b4;
        --card-bg: #0e1526;
        --card-border: rgba(255, 255, 255, .06);
        --accent: #e0b054;
        --accent-strong: #f0c476;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .exam-header {
        text-align: center;
        margin-bottom: 50px;
        animation: fadeIn .6s var(--ease) both;
    }

    .exam-header h1 {
        font-size: 2.2rem;
        margin: 0 0 16px;
        color: var(--text);
        font-weight: 700;
    }

    .exam-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
        animation: fadeInUp .5s var(--ease) both;
    }

    .info-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 12px 24px rgba(16, 27, 46, .08);
    }

    .info-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .info-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent-strong);
    }

    .exam-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 24px 48px rgba(16, 27, 46, .18);
        animation: slideUp .5s var(--ease) both;
    }

    .exam-instructions {
        background: rgba(224, 176, 84, 0.06);
        border-left: 4px solid var(--accent-strong);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 32px;
    }

    .exam-instructions h3 {
        margin: 0 0 12px;
        color: var(--text);
        font-size: 1rem;
    }

    .exam-instructions ul {
        margin: 0;
        padding-left: 20px;
        color: var(--text-muted);
    }

    .exam-instructions li {
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .question-container {
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid var(--card-border);
    }

    .question-container:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .question-number {
        color: var(--accent-strong);
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .question-text {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 20px;
        color: var(--text);
        line-height: 1.6;
    }

    .options {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .option {
        padding: 16px;
        border: 2px solid var(--card-border);
        border-radius: 10px;
        background: rgba(224, 176, 84, 0.05);
        cursor: pointer;
        transition: all .2s var(--ease);
        font-weight: 500;
    }

    .option:hover {
        border-color: var(--accent-strong);
        background: rgba(224, 176, 84, 0.15);
        transform: translateX(4px);
    }

    .option input[type="radio"] {
        margin-right: 12px;
        cursor: pointer;
        accent-color: var(--accent-strong);
        width: 18px;
        height: 18px;
    }

    .button-group {
        display: flex;
        gap: 16px;
        margin-top: 40px;
        justify-content: center;
    }

    .btn {
        padding: 14px 32px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        font-size: 1rem;
        transition: all .2s var(--ease);
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
        color: #241a04;
        box-shadow: 0 8px 20px rgba(224, 176, 84, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(224, 176, 84, 0.35);
    }

    .btn-secondary {
        background: var(--card-border);
        color: var(--text);
        border: 2px solid var(--card-border);
    }

    .btn-secondary:hover {
        border-color: var(--accent-strong);
        color: var(--accent-strong);
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        background: var(--card-border);
        border-radius: 3px;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent), var(--accent-strong));
        transition: width .3s var(--ease);
    }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container">
    <div class="exam-header">
        <h1>📋 Computer 1 - Final Examination</h1>
        <p style="color: var(--text-muted); margin: 0;">College of Information Technology</p>
    </div>

    <div class="exam-info">
        <div class="info-card">
            <div class="info-label">Duration</div>
            <div class="info-value">120 min</div>
        </div>
        <div class="info-card">
            <div class="info-label">Total Questions</div>
            <div class="info-value">50</div>
        </div>
        <div class="info-card">
            <div class="info-label">Passing Score</div>
            <div class="info-value">70%</div>
        </div>
        <div class="info-card">
            <div class="info-label">Attempts</div>
            <div class="info-value">3</div>
        </div>
    </div>

    <div class="exam-card">
        <div class="progress-bar">
            <div class="progress-fill" style="width: 0%;"></div>
        </div>

        <div class="exam-instructions">
            <h3>📌 Exam Instructions</h3>
            <ul>
                <li>This is a timed exam. You have 120 minutes to complete it.</li>
                <li>Once you start the exam, you cannot pause or leave the page.</li>
                <li>Answer all questions before submitting.</li>
                <li>You can only submit your answers once.</li>
                <li>A passing score of 70% or higher is required to pass this exam.</li>
                <li>You have 3 attempts to pass this exam.</li>
            </ul>
        </div>

          <form id="examForm"
              method="<?php echo e(isset($quiz) ? 'POST' : 'GET'); ?>"
              action="<?php echo e(isset($quiz) ? route('quiz.submit', $quiz->id) : route('quiz')); ?>">
            <?php echo csrf_field(); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="question-container">
                    <div class="question-number">Question <?php echo e($i); ?> of 50</div>
                    <div class="question-text">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 1): ?>
                            What is the primary purpose of a variable in programming?
                        <?php elseif($i === 2): ?>
                            Which of the following is NOT a primitive data type in most programming languages?
                        <?php elseif($i === 3): ?>
                            What does CPU stand for?
                        <?php elseif($i === 4): ?>
                            Which of the following is a loop structure in programming?
                        <?php else: ?>
                            What is the main function of RAM in a computer system?
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="options">
                        <label class="option">
                            <input type="radio" name="question_<?php echo e($i); ?>" value="a"> 
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 1): ?>
                                To store data temporarily during program execution
                            <?php elseif($i === 2): ?>
                                Integer
                            <?php elseif($i === 3): ?>
                                Central Processing Unit
                            <?php elseif($i === 4): ?>
                                For loop
                            <?php else: ?>
                                Permanent data storage
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </label>
                        <label class="option">
                            <input type="radio" name="question_<?php echo e($i); ?>" value="b"> 
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 1): ?>
                                To declare functions
                            <?php elseif($i === 2): ?>
                                Array
                            <?php elseif($i === 3): ?>
                                Central Processing Utility
                            <?php elseif($i === 4): ?>
                                Conditional statement
                            <?php else: ?>
                                Temporary high-speed memory
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </label>
                        <label class="option">
                            <input type="radio" name="question_<?php echo e($i); ?>" value="c"> 
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 1): ?>
                                To create objects
                            <?php elseif($i === 2): ?>
                                Class
                            <?php elseif($i === 3): ?>
                                Computer Processing Unit
                            <?php elseif($i === 4): ?>
                                Function definition
                            <?php else: ?>
                                Data backup storage
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </label>
                        <label class="option">
                            <input type="radio" name="question_<?php echo e($i); ?>" value="d"> 
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 1): ?>
                                To replace constants
                            <?php elseif($i === 2): ?>
                                Boolean
                            <?php elseif($i === 3): ?>
                                Computing Power Unit
                            <?php elseif($i === 4): ?>
                                Module declaration
                            <?php else: ?>
                                Monitor display memory
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </label>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </form>

        <div class="button-group">
            <button type="button" class="btn btn-secondary" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="submit" form="examForm" class="btn btn-primary" onclick="return confirm('Are you sure? You cannot change your answers after submission.')">
                <i class="fa-solid fa-check"></i> Submit Exam
            </button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\course\exam.blade.php ENDPATH**/ ?>