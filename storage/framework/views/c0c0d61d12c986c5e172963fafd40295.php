

<?php $__env->startSection('title', 'Trivia Games - SkillUp'); ?>
<?php $__env->startSection('content'); ?>


<?php
    $leaderboardRows = collect($leaderboard ?? []);
    $stats = $gameStats ?? [];
    $playableGames = collect($triviaGames ?? [])->filter(function ($game) {
        return $game->module && $game->module->course;
    })->values();
?>

<style>
    :root {
        --ease: cubic-bezier(.22, 1, .36, 1);
        --bg: #f3f5fb;
        --text: #101b2e;
        --text-muted: #5b6b85;
        --card-bg: #ffffff;
        --card-border: rgba(16, 27, 46, .06);
        --card-shadow: 0 24px 48px -18px rgba(16, 27, 46, .18), 0 2px 8px rgba(16, 27, 46, .05);
        --accent: #c9973b;
        --accent-strong: #e0b054;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    html.dark-mode {
        --bg: #070a13;
        --text: #e7ebf5;
        --text-muted: #8b96b4;
        --card-bg: #0e1526;
        --card-border: rgba(255, 255, 255, .06);
        --card-shadow: 0 24px 48px -18px rgba(0, 0, 0, .6), 0 2px 8px rgba(0, 0, 0, .3);
        --accent: #e0b054;
        --accent-strong: #f0c476;
    }

    * { box-sizing: border-box; }

    body { margin: 0; font-family: 'Inter', system-ui, sans-serif; background: var(--bg); color: var(--text); transition: background-color .4s var(--ease), color .4s var(--ease); }

    .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }

    .page-header { text-align: center; margin-bottom: 50px; animation: fadeInDown .6s var(--ease) both; }
    .page-header h1 { font-size: 2.8rem; margin: 0 0 16px; color: var(--text); font-weight: 800; background: linear-gradient(135deg, var(--accent), var(--accent-strong)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .page-header p { color: var(--text-muted); font-size: 1.1rem; margin: 0 auto; max-width: 600px; }

    .games-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 28px; margin-bottom: 40px; }

    .game-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 32px 24px; box-shadow: var(--card-shadow); transition: transform .3s var(--ease), box-shadow .3s var(--ease), border-color .3s var(--ease); text-align: center; display: flex; flex-direction: column; opacity: 0; transform: translateY(20px); }
    .game-card.is-visible { animation: fadeInUp .5s var(--ease) both; }

    .game-card:hover { transform: translateY(-12px); box-shadow: 0 28px 50px rgba(224, 176, 84, 0.3); border-color: var(--accent-strong); }

    .game-icon { font-size: 64px; margin-bottom: 16px; animation: float 3s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .game-title { font-size: 1.35rem; font-weight: 800; margin: 0 0 12px; color: var(--text); }
    .game-description { color: var(--text-muted); font-size: .95rem; margin: 0 0 24px; line-height: 1.6; flex-grow: 1; }

    .game-stats { display: flex; gap: 12px; margin-bottom: 24px; padding: 12px; background: rgba(224, 176, 84, .08); border-radius: 10px; }
    .game-stat { flex: 1; font-size: .85rem; color: var(--text-muted); }
    .game-stat-value { display: block; font-weight: 700; color: var(--accent-strong); font-size: 1.2rem; }
    .badge-new { display: inline-block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: var(--accent-strong); background: rgba(224, 176, 84, .15); padding: 3px 10px; border-radius: 999px; }

    .play-button { background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%); color: #241a04; padding: 14px 28px; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 1rem; transition: transform .2s var(--ease), box-shadow .2s var(--ease); text-transform: uppercase; letter-spacing: .03em; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 20px rgba(224, 176, 84, .3); width: 100%; }
    .play-button:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(224, 176, 84, .4); }

    .leaderboard { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 18px; padding: 32px; box-shadow: var(--card-shadow); animation: fadeIn .6s var(--ease) both .3s; opacity: 0; animation-fill-mode: forwards; }
    .leaderboard h2 { font-size: 1.5rem; margin: 0 0 24px; color: var(--text); font-weight: 700; }

    .leaderboard-table { width: 100%; border-collapse: collapse; }
    .leaderboard-table th { text-align: left; padding: 12px; border-bottom: 2px solid var(--card-border); color: var(--text-muted); font-weight: 700; font-size: .9rem; text-transform: uppercase; letter-spacing: .05em; }
    .leaderboard-table td { padding: 14px 12px; border-bottom: 1px solid var(--card-border); }

    .rank { font-weight: 700; color: var(--accent-strong); font-size: 1.1rem; }
    .rank.first { color: #fbbf24; }
    .rank.second { color: #d1d5db; }
    .rank.third { color: #cd7f32; }

    .player-name { font-weight: 600; color: var(--text); }
    .score { font-weight: 700; color: var(--accent-strong); }

    .empty-leaderboard { text-align: center; padding: 40px 20px; color: var(--text-muted); }

    /* Game modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(7, 10, 19, .55); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; padding: 20px; z-index: 100; opacity: 0; transition: opacity .25s var(--ease); }
    .modal-overlay.open { display: flex; opacity: 1; }

    .modal-panel { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; max-width: 560px; width: 100%; max-height: 88vh; overflow-y: auto; padding: 32px; box-shadow: var(--card-shadow); transform: scale(.92) translateY(12px); transition: transform .3s var(--ease); }
    .modal-overlay.open .modal-panel { transform: scale(1) translateY(0); }

    .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .modal-header h3 { margin: 0; font-size: 1.3rem; font-weight: 800; }
    .modal-close { background: var(--card-border); border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; color: var(--text); transition: background .2s var(--ease), transform .2s var(--ease); }
    .modal-close:hover { background: rgba(239, 68, 68, .15); color: var(--danger); transform: rotate(90deg); }

    .game-progress-track { display: flex; justify-content: space-between; font-size: .82rem; color: var(--text-muted); font-weight: 600; margin-bottom: 8px; }
    .game-progress-bar { width: 100%; height: 6px; background: var(--card-border); border-radius: 3px; overflow: hidden; margin-bottom: 24px; }
    .game-progress-fill { height: 100%; background: linear-gradient(90deg, var(--accent), var(--accent-strong)); border-radius: 3px; transition: width .35s var(--ease); width: 0%; }

    .g-question { font-size: 1.15rem; font-weight: 700; margin: 0 0 20px; line-height: 1.5; }

    .g-options { display: flex; flex-direction: column; gap: 10px; }
    .g-option { padding: 14px 16px; border: 2px solid var(--card-border); border-radius: 10px; background: rgba(224, 176, 84, .05); cursor: pointer; transition: border-color .2s var(--ease), background .2s var(--ease), transform .15s var(--ease); text-align: left; font-weight: 500; color: var(--text); font-family: inherit; font-size: .95rem; }
    .g-option:hover:not(:disabled) { border-color: var(--accent-strong); background: rgba(224, 176, 84, .15); transform: translateX(3px); }
    .g-option:disabled { cursor: default; }
    .g-option.correct { border-color: var(--success); background: rgba(16, 185, 129, .15); color: var(--success); }
    .g-option.incorrect { border-color: var(--danger); background: rgba(239, 68, 68, .15); color: var(--danger); }

    .g-tf-row { display: flex; gap: 14px; }
    .g-tf-row .g-option { flex: 1; text-align: center; font-weight: 700; }

    .g-timer { font-weight: 800; font-size: 1.05rem; }
    .g-timer.low { color: var(--danger); animation: pulse .6s ease-in-out infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .4; } }

    .g-score-live { font-size: .85rem; color: var(--text-muted); font-weight: 600; }

    .g-match-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .g-match-col { display: flex; flex-direction: column; gap: 10px; }
    .g-chip { padding: 12px 14px; border: 2px solid var(--card-border); border-radius: 10px; background: rgba(224, 176, 84, .05); cursor: pointer; font-size: .88rem; font-weight: 600; text-align: left; transition: border-color .2s var(--ease), background .2s var(--ease); color: var(--text); font-family: inherit; }
    .g-chip:hover:not(:disabled) { border-color: var(--accent-strong); }
    .g-chip.selected { border-color: var(--accent-strong); background: rgba(224, 176, 84, .18); }
    .g-chip.matched { border-color: var(--success); background: rgba(16, 185, 129, .12); color: var(--success); opacity: .7; cursor: default; }
    .g-chip.wrong { border-color: var(--danger); background: rgba(239, 68, 68, .15); animation: shake .35s var(--ease); }
    @keyframes shake { 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }

    .g-complete { text-align: center; padding: 10px 0; }
    .g-complete .g-score-big { font-size: 3.2rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 6px; animation: popIn .45s var(--ease) both; }
    .g-complete p { color: var(--text-muted); margin: 0 0 26px; }
    .g-best { font-size: .85rem; color: var(--accent-strong); font-weight: 700; margin-bottom: 22px; }

    .g-actions { display: flex; gap: 12px; justify-content: center; }
    .g-btn { padding: 12px 26px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; font-size: .92rem; transition: transform .2s var(--ease), box-shadow .2s var(--ease); }
    .g-btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-strong)); color: #241a04; }
    .g-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(224,176,84,.35); }
    .g-btn-secondary { background: var(--card-border); color: var(--text); }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes popIn { from { opacity: 0; transform: scale(.7); } to { opacity: 1; transform: scale(1); } }

    @media (prefers-reduced-motion: reduce) {
        .game-card, .game-icon, .leaderboard, .modal-panel, .g-complete .g-score-big { animation: none !important; }
    }

    /* Arcade control-room refresh */
    .trivia-page {
        --ink: #10213d;
        --muted: #65728a;
        --line: #d9e1ed;
        --blue: #155eef;
        --blue-deep: #0b2d73;
        --coral: #f26b5e;
        max-width: 1240px;
        margin: 0 auto;
        padding: 34px 28px 72px;
    }

    .trivia-hero {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 28px;
        padding: 38px 42px 40px;
        margin-bottom: 34px;
        overflow: hidden;
        border-radius: 24px;
        color: #fff;
        background: linear-gradient(120deg, #08275f 0%, #1252b8 62%, #1683bf 100%);
        box-shadow: 0 24px 50px rgba(16, 55, 123, .22);
    }

    .trivia-hero::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        right: 7%;
        top: -180px;
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 50%;
        box-shadow: 0 0 0 28px rgba(255,255,255,.04), 0 0 0 58px rgba(255,255,255,.035);
    }

    .hero-copy, .hero-stat { position: relative; z-index: 1; }
    .hero-kicker { margin: 0 0 10px; color: #9bdcff; font: 700 .72rem/1.2 'JetBrains Mono', monospace; letter-spacing: .13em; text-transform: uppercase; }
    .trivia-hero h1 { margin: 0; color: #fff; font: 800 clamp(2rem, 4vw, 3.45rem)/1.02 'Sora', sans-serif; letter-spacing: -.04em; }
    .trivia-hero p { max-width: 590px; margin: 16px 0 0; color: rgba(255,255,255,.78); font-size: 1rem; line-height: 1.65; }
    .hero-stat { min-width: 146px; padding: 17px 20px; border: 1px solid rgba(255,255,255,.2); border-radius: 14px; background: rgba(4, 23, 65, .24); text-align: center; }
    .hero-stat strong { display: block; color: #fff; font: 800 2rem/1 'Sora', sans-serif; }
    .hero-stat span { display: block; margin-top: 6px; color: #b9d8ff; font-size: .76rem; text-transform: uppercase; letter-spacing: .08em; }

    .section-heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin: 0 2px 15px; }
    .section-heading h2 { margin: 0; color: var(--ink); font: 800 1.55rem/1.15 'Sora', sans-serif; letter-spacing: -.03em; }
    .section-heading p { margin: 0; color: var(--muted); font-size: .88rem; }
    .games-grid { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 42px; }
    .game-card { position: relative; min-height: 315px; padding: 25px 22px 22px; border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 9px 25px rgba(22, 49, 93, .08); text-align: left; }
    .game-card::before { content: ''; position: absolute; left: 0; top: 22px; bottom: 22px; width: 4px; border-radius: 0 4px 4px 0; background: var(--coral); }
    .game-card:hover { transform: translateY(-6px); border-color: #91b4f5; box-shadow: 0 18px 35px rgba(22, 49, 93, .14); }
    .game-icon { display: grid; place-items: center; width: 52px; height: 52px; margin: 0 0 22px; border-radius: 14px; background: #eaf1ff; font-size: 1.8rem; animation: none; }
    .game-title { margin-bottom: 9px; font: 800 1.1rem/1.25 'Sora', sans-serif; }
    .game-description { min-height: 48px; margin-bottom: 20px; font-size: .86rem; line-height: 1.55; }
    .game-stats { margin-bottom: 17px; padding: 10px 12px; border: 1px solid #e8edf5; background: #f8faff; border-radius: 9px; }
    .game-stat { font-size: .72rem; }
    .game-stat-value { color: var(--blue); font: 800 1rem/1.2 'Sora', sans-serif; }
    .play-button { padding: 11px 15px; border-radius: 9px; background: var(--blue); color: #fff; box-shadow: none; font-size: .78rem; letter-spacing: .08em; }
    .play-button:hover { background: var(--blue-deep); box-shadow: 0 8px 18px rgba(21,94,239,.22); }

    .leaderboard { padding: 27px 30px; border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 9px 25px rgba(22, 49, 93, .08); }
    .leaderboard h2 { margin-bottom: 19px; font: 800 1.25rem/1.2 'Sora', sans-serif; }
    .leaderboard-table th { padding: 11px 12px; border-bottom: 1px solid var(--line); font-size: .72rem; letter-spacing: .1em; }
    .leaderboard-table td { padding: 15px 12px; border-bottom: 1px solid #edf1f7; font-size: .9rem; }
    .leaderboard-table tbody tr:last-child td { border-bottom: 0; }
    .rank { color: var(--blue); }
    .score { color: var(--blue); }

    @media (max-width: 640px) {
        .trivia-page { padding: 20px 14px 48px; }
        .trivia-hero { grid-template-columns: 1fr; padding: 28px 24px; }
        .hero-stat { justify-self: start; }
        .section-heading { display: block; }
        .section-heading p { margin-top: 7px; }
        .leaderboard { padding: 22px 15px; overflow-x: auto; }
        .leaderboard-table { min-width: 520px; }
    }
</style>

<div class="trivia-page">
    <section class="trivia-hero">
        <div class="hero-copy">
            <p class="hero-kicker">SkillUp / Play zone</p>
            <h1>Think fast.<br>Play smart.</h1>
            <p>Short, focused challenges built to turn what you know into a score worth chasing.</p>
        </div>
        <div class="hero-stat">
            <strong><?php echo e($playableGames->count()); ?></strong>
            <span>Live challenges</span>
        </div>
    </section>

    <div class="section-heading">
        <div>
            <h2>Choose your challenge</h2>
            <p>Every round is a chance to beat your personal best.</p>
        </div>
    </div>

    <div class="games-grid" id="games-grid">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $playableGames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php $gameCourse = $game->module->course; $gameModule = $game->module; ?>
            <div class="game-card" data-title="<?php echo e($game->title); ?>" data-slug="<?php echo e($game->slug); ?>">
                <div class="game-icon">🎯</div>
                <h3 class="game-title"><?php echo e($game->title); ?></h3>
                <p class="game-description"><?php echo e($game->description ?: 'Test your knowledge and climb the leaderboard.'); ?></p>
                <div class="game-stats">
                    <div class="game-stat">
                        <span class="game-stat-value"><?php echo e($game->questions_count); ?></span><span>Questions</span>
                    </div>
                    <div class="game-stat">
                        <span class="game-stat-value"><?php echo e(ucfirst($game->difficulty ?: 'Mixed')); ?></span><span>Difficulty</span>
                    </div>
                </div>
                <a class="play-button" href="<?php echo e(route('quizzes.start', [$gameCourse->slug, $gameModule->slug, $game->slug])); ?>"><i class="fa-solid fa-play"></i> Start Game</a>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="empty-leaderboard">No trivia games are available right now.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="section-heading">
        <div>
            <h2>Quick play</h2>
            <p>Jump into a short practice round anytime.</p>
        </div>
    </div>

    <div class="games-grid" id="quick-games-grid">
        <div class="game-card" data-mode="multiple">
            <div class="game-icon">A</div>
            <h3 class="game-title">Multiple Choice</h3>
            <p class="game-description">Pick the best answer across a fast mix of general knowledge questions.</p>
            <div class="game-stats">
                <div class="game-stat"><span class="game-stat-value">6</span><span>Questions</span></div>
                <div class="game-stat"><span class="game-stat-value">Easy</span><span>Difficulty</span></div>
            </div>
            <button type="button" class="play-button" data-play>Start Game</button>
        </div>

        <div class="game-card" data-mode="truefalse">
            <div class="game-icon">T/F</div>
            <h3 class="game-title">True or False</h3>
            <p class="game-description">Trust your instincts and decide whether each statement is correct.</p>
            <div class="game-stats">
                <div class="game-stat"><span class="game-stat-value">6</span><span>Questions</span></div>
                <div class="game-stat"><span class="game-stat-value">Mixed</span><span>Difficulty</span></div>
            </div>
            <button type="button" class="play-button" data-play>Start Game</button>
        </div>

        <div class="game-card" data-mode="match">
            <div class="game-icon">=</div>
            <h3 class="game-title">Word Match</h3>
            <p class="game-description">Pair important terms with their meanings before the board fills up.</p>
            <div class="game-stats">
                <div class="game-stat"><span class="game-stat-value">5</span><span>Pairs</span></div>
                <div class="game-stat"><span class="game-stat-value">Medium</span><span>Difficulty</span></div>
            </div>
            <button type="button" class="play-button" data-play>Start Game</button>
        </div>

        <div class="game-card" data-mode="timed">
            <div class="game-icon">60s</div>
            <h3 class="game-title">Timed Challenge</h3>
            <p class="game-description">Answer as many questions as you can before the clock reaches zero.</p>
            <div class="game-stats">
                <div class="game-stat"><span class="game-stat-value">60s</span><span>Time limit</span></div>
                <div class="game-stat"><span class="game-stat-value">Hard</span><span>Difficulty</span></div>
            </div>
            <button type="button" class="play-button" data-play>Start Game</button>
        </div>
    </div>

    <div class="leaderboard">
        <h2>🏆 Top Performers This Week</h2>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leaderboardRows->isNotEmpty()): ?>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Rank</th>
                        <th style="width: 40%;">Player</th>
                        <th style="width: 25%;">Score</th>
                        <th style="width: 25%;">Games Played</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $leaderboardRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $rank = $entry['rank'] ?? $entry->rank; ?>
                        <tr>
                            <td>
                                <span class="rank <?php echo e($rank === 1 ? 'first' : ($rank === 2 ? 'second' : ($rank === 3 ? 'third' : ''))); ?>">
                                    <?php echo e($rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : '#' . $rank))); ?>

                                </span>
                            </td>
                            <td><span class="player-name"><?php echo e($entry['name'] ?? $entry->name); ?></span></td>
                            <td><span class="score"><?php echo e(number_format($entry['score'] ?? $entry->score)); ?></span></td>
                            <td><?php echo e($entry['games'] ?? $entry->games); ?> games</td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-leaderboard">
                <p style="font-weight: 700; color: var(--text); margin: 0 0 6px;">No scores yet this week.</p>
                <p style="margin: 0;">Play a game above — you could be the first name on the board.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<!-- Game modal (shared shell for all four games) -->
<div class="modal-overlay" id="game-modal">
    <div class="modal-panel">
        <div class="modal-header">
            <h3 id="modal-title">Trivia</h3>
            <button type="button" class="modal-close" id="modal-close" aria-label="Close">✕</button>
        </div>
        <div id="modal-body"><!-- game content injected here --></div>
    </div>
</div>

<script>
(function () {
    var quickPlayScoreUrl = <?php echo json_encode(route('trivia.quick-play.scores'), 15, 512) ?>;
    var canSubmitQuickPlayScore = <?php echo json_encode(auth()->check(), 15, 512) ?>;
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function submitQuickPlayScore(gameType, score, maxScore) {
        if (!canSubmitQuickPlayScore || !csrfToken) return;

        fetch(quickPlayScoreUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ game_type: gameType, score: score, max_score: maxScore })
        }).catch(function () {
            // The local result remains available if the network is unavailable.
        });
    }

    // Small built-in question bank so games work out of the box.
    // Swap this for data from the backend by rendering it into a
    // `window.TRIVIA_BANK = <?php echo json_encode($triviaBank ?? null, 15, 512) ?>` line if you have real question sets.
    var MC_BANK = [
        { q: 'What is the capital of France?', options: ['Paris', 'Rome', 'Berlin', 'Madrid'], correct: 0 },
        { q: 'Which planet is known as the Red Planet?', options: ['Venus', 'Mars', 'Jupiter', 'Saturn'], correct: 1 },
        { q: 'What is 12 × 8?', options: ['96', '86', '108', '92'], correct: 0 },
        { q: 'Who wrote "Romeo and Juliet"?', options: ['Charles Dickens', 'Mark Twain', 'William Shakespeare', 'Jane Austen'], correct: 2 },
        { q: 'What gas do plants absorb from the atmosphere?', options: ['Oxygen', 'Nitrogen', 'Carbon dioxide', 'Hydrogen'], correct: 2 },
        { q: 'How many continents are there?', options: ['5', '6', '7', '8'], correct: 2 },
        { q: 'What is the chemical symbol for gold?', options: ['Go', 'Gd', 'Au', 'Ag'], correct: 2 },
        { q: 'Which ocean is the largest?', options: ['Atlantic', 'Indian', 'Arctic', 'Pacific'], correct: 3 }
    ];

    var TF_BANK = [
        { q: 'The Great Wall of China is visible from space with the naked eye.', correct: false },
        { q: 'Water boils at 100°C at sea level.', correct: true },
        { q: 'A group of lions is called a pride.', correct: true },
        { q: 'The sun rises in the west.', correct: false },
        { q: 'Humans have 206 bones in adulthood.', correct: true },
        { q: 'Sharks are mammals.', correct: false },
        { q: 'The Pacific Ocean is the smallest ocean.', correct: false },
        { q: 'HTML stands for HyperText Markup Language.', correct: true }
    ];

    var MATCH_BANK = [
        { word: 'Photosynthesis', def: 'Process plants use to convert light into energy' },
        { word: 'Democracy', def: 'A system of government by the whole population' },
        { word: 'Algorithm', def: 'A step-by-step procedure for solving a problem' },
        { word: 'Ecosystem', def: 'A community of living organisms and their environment' },
        { word: 'Inflation', def: 'A general rise in prices over time' },
        { word: 'Gravity', def: 'The force that attracts objects toward each other' }
    ];

    function shuffle(arr) {
        var a = arr.slice();
        for (var i = a.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var t = a[i]; a[i] = a[j]; a[j] = t;
        }
        return a;
    }

    var overlay = document.getElementById('game-modal');
    var modalTitle = document.getElementById('modal-title');
    var modalBody = document.getElementById('modal-body');
    var closeBtn = document.getElementById('modal-close');
    var activeCleanup = null;

    function openModal(title) {
        modalTitle.textContent = title;
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
        if (activeCleanup) { activeCleanup(); activeCleanup = null; }
        modalBody.innerHTML = '';
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal(); });

    function bestScoreKey(slug) { return 'trivia_best_' + slug; }
    function getBest(slug) { return Number(localStorage.getItem(bestScoreKey(slug)) || 0); }
    function setBestIfHigher(slug, score) {
        var best = getBest(slug);
        if (score > best) { localStorage.setItem(bestScoreKey(slug), score); return score; }
        return best;
    }

    function renderComplete(slug, scoreLabel, scoreValue, subtitle, onReplay, maxScore) {
        submitQuickPlayScore(slug, scoreValue, maxScore || scoreValue);
        var best = setBestIfHigher(slug, scoreValue);
        modalBody.innerHTML =
            '<div class="g-complete">' +
                '<div class="g-score-big">' + scoreLabel + '</div>' +
                '<p>' + subtitle + '</p>' +
                '<div class="g-best">🏅 Your best: ' + best + '</div>' +
                '<div class="g-actions">' +
                    '<button type="button" class="g-btn g-btn-primary" id="g-replay">Play Again</button>' +
                    '<button type="button" class="g-btn g-btn-secondary" id="g-close2">Close</button>' +
                '</div>' +
            '</div>';
        document.getElementById('g-replay').addEventListener('click', onReplay);
        document.getElementById('g-close2').addEventListener('click', closeModal);
    }

    // ---------- Multiple choice ----------
    function playMultiple() {
        var pool = shuffle(MC_BANK).slice(0, 6);
        var idx = 0, score = 0;

        function renderQ() {
            var item = pool[idx];
            modalBody.innerHTML =
                '<div class="game-progress-track"><span>Question ' + (idx + 1) + ' of ' + pool.length + '</span><span class="g-score-live">Score: ' + score + '</span></div>' +
                '<div class="game-progress-bar"><div class="game-progress-fill" style="width:' + (idx / pool.length * 100) + '%"></div></div>' +
                '<p class="g-question">' + item.q + '</p>' +
                '<div class="g-options">' + item.options.map(function (opt, i) {
                    return '<button type="button" class="g-option" data-i="' + i + '">' + opt + '</button>';
                }).join('') + '</div>';

            var buttons = modalBody.querySelectorAll('.g-option');
            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var chosen = Number(btn.dataset.i);
                    buttons.forEach(function (b) { b.disabled = true; });
                    if (chosen === item.correct) { btn.classList.add('correct'); score += 10; }
                    else {
                        btn.classList.add('incorrect');
                        buttons[item.correct].classList.add('correct');
                    }
                    setTimeout(function () {
                        idx++;
                        if (idx < pool.length) renderQ(); else finish();
                    }, 700);
                });
            });
        }

        function finish() {
            renderComplete('multiple-choice', score, score, 'Correct answers earn 10 points each.', playMultiple, pool.length * 10);
        }

        renderQ();
    }

    // ---------- True / False ----------
    function playTrueFalse() {
        var pool = shuffle(TF_BANK).slice(0, 6);
        var idx = 0, score = 0;

        function renderQ() {
            var item = pool[idx];
            modalBody.innerHTML =
                '<div class="game-progress-track"><span>Question ' + (idx + 1) + ' of ' + pool.length + '</span><span class="g-score-live">Score: ' + score + '</span></div>' +
                '<div class="game-progress-bar"><div class="game-progress-fill" style="width:' + (idx / pool.length * 100) + '%"></div></div>' +
                '<p class="g-question">' + item.q + '</p>' +
                '<div class="g-tf-row">' +
                    '<button type="button" class="g-option" data-v="true">True</button>' +
                    '<button type="button" class="g-option" data-v="false">False</button>' +
                '</div>';

            var buttons = modalBody.querySelectorAll('.g-option');
            buttons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var chosen = btn.dataset.v === 'true';
                    buttons.forEach(function (b) { b.disabled = true; });
                    var correctBtn = modalBody.querySelector('[data-v="' + item.correct + '"]');
                    if (chosen === item.correct) { btn.classList.add('correct'); score += 10; }
                    else { btn.classList.add('incorrect'); correctBtn.classList.add('correct'); }
                    setTimeout(function () {
                        idx++;
                        if (idx < pool.length) renderQ(); else finish();
                    }, 700);
                });
            });
        }

        function finish() {
            renderComplete('true-false', score, score, 'Correct answers earn 10 points each.', playTrueFalse, pool.length * 10);
        }

        renderQ();
    }

    // ---------- Word match ----------
    function playMatch() {
        var pairs = shuffle(MATCH_BANK).slice(0, 5);
        var words = shuffle(pairs.map(function (p, i) { return { text: p.word, id: i }; }));
        var defs = shuffle(pairs.map(function (p, i) { return { text: p.def, id: i }; }));
        var selectedWord = null, matched = 0, mistakes = 0;

        modalBody.innerHTML =
            '<div class="game-progress-track"><span>Matched ' + matched + ' of ' + pairs.length + '</span><span class="g-score-live">Mistakes: ' + mistakes + '</span></div>' +
            '<div class="game-progress-bar"><div class="game-progress-fill" id="match-fill" style="width:0%"></div></div>' +
            '<div class="g-match-grid">' +
                '<div class="g-match-col" id="match-words">' + words.map(function (w) { return '<button type="button" class="g-chip" data-id="' + w.id + '">' + w.text + '</button>'; }).join('') + '</div>' +
                '<div class="g-match-col" id="match-defs">' + defs.map(function (d) { return '<button type="button" class="g-chip" data-id="' + d.id + '">' + d.text + '</button>'; }).join('') + '</div>' +
            '</div>';

        var wordEls = modalBody.querySelectorAll('#match-words .g-chip');
        var defEls = modalBody.querySelectorAll('#match-defs .g-chip');
        var trackLabel = modalBody.querySelector('.game-progress-track');

        function updateTrack() {
            trackLabel.innerHTML = '<span>Matched ' + matched + ' of ' + pairs.length + '</span><span class="g-score-live">Mistakes: ' + mistakes + '</span>';
            modalBody.querySelector('#match-fill').style.width = (matched / pairs.length * 100) + '%';
        }

        wordEls.forEach(function (el) {
            el.addEventListener('click', function () {
                wordEls.forEach(function (w) { w.classList.remove('selected'); });
                selectedWord = el;
                el.classList.add('selected');
            });
        });

        defEls.forEach(function (el) {
            el.addEventListener('click', function () {
                if (!selectedWord) return;
                if (selectedWord.dataset.id === el.dataset.id) {
                    selectedWord.classList.remove('selected');
                    selectedWord.classList.add('matched');
                    el.classList.add('matched');
                    selectedWord.disabled = true;
                    el.disabled = true;
                    selectedWord = null;
                    matched++;
                    updateTrack();
                    if (matched === pairs.length) {
                        var accuracy = Math.max(0, Math.round(100 - mistakes * 10));
                        setTimeout(function () {
                            renderComplete('word-match', accuracy + '%', accuracy, mistakes + ' mistake' + (mistakes === 1 ? '' : 's') + ' along the way.', playMatch, 100);
                        }, 400);
                    }
                } else {
                    mistakes++;
                    el.classList.add('wrong');
                    setTimeout(function () { el.classList.remove('wrong'); }, 350);
                    updateTrack();
                }
            });
        });
    }

    // ---------- Timed challenge ----------
    function playTimed() {
        var pool = shuffle(MC_BANK.concat(MC_BANK)); // cycle through if 60s outlasts the bank
        var idx = 0, score = 0, timeLeft = 60, timerId = null;

        function renderQ() {
            var item = pool[idx % pool.length];
            modalBody.innerHTML =
                '<div class="game-progress-track"><span class="g-timer' + (timeLeft <= 10 ? ' low' : '') + '" id="g-time">⏱ ' + timeLeft + 's</span><span class="g-score-live">Score: ' + score + '</span></div>' +
                '<p class="g-question">' + item.q + '</p>' +
                '<div class="g-options">' + item.options.map(function (opt, i) {
                    return '<button type="button" class="g-option" data-i="' + i + '">' + opt + '</button>';
                }).join('') + '</div>';

            modalBody.querySelectorAll('.g-option').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var chosen = Number(btn.dataset.i);
                    if (chosen === item.correct) { btn.classList.add('correct'); score += 10; }
                    else { btn.classList.add('incorrect'); }
                    idx++;
                    setTimeout(renderQ, 250);
                });
            });
        }

        function tick() {
            timeLeft--;
            var t = document.getElementById('g-time');
            if (t) { t.textContent = '⏱ ' + timeLeft + 's'; t.classList.toggle('low', timeLeft <= 10); }
            if (timeLeft <= 0) { finish(); }
        }

        function finish() {
            clearInterval(timerId);
            renderComplete('timed-challenge', score, score, 'Points earned in 60 seconds.', playTimed, 600);
        }

        renderQ();
        timerId = setInterval(tick, 1000);
        activeCleanup = function () { clearInterval(timerId); };
    }

    var LAUNCHERS = {
        multiple: { title: 'Multiple Choice', run: playMultiple },
        truefalse: { title: 'True or False', run: playTrueFalse },
        match: { title: 'Word Match', run: playMatch },
        timed: { title: 'Timed Challenge', run: playTimed }
    };

    document.querySelectorAll('[data-play]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var card = btn.closest('.game-card');
            var mode = card.dataset.mode;
            var launcher = LAUNCHERS[mode];
            if (!launcher) return;
            openModal(launcher.title);
            launcher.run();
        });
    });

    // Staggered reveal for any number of cards (robust if more games are added later).
    var cards = Array.prototype.slice.call(document.querySelectorAll('.trivia-page .game-card'));
    if ('IntersectionObserver' in window) {
        var seen = 0;
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = (seen * 100) + 'ms';
                    entry.target.classList.add('is-visible');
                    seen++;
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        cards.forEach(function (c) { obs.observe(c); });
    } else {
        cards.forEach(function (c) { c.classList.add('is-visible'); });
    }
})();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\course\trivia games.blade.php ENDPATH**/ ?>