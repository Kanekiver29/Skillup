<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Sign in to SkillUp to continue your learning journey.">
    <meta name="theme-color" content="#0B2A6B">
    <title><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($title)): ?><?php echo e($title); ?><?php else: ?>@yield('title', 'SkillUp')<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" type="image/png">

    <!-- Brand type system: Fraunces (display) · Inter (UI/body) · IBM Plex Mono (utility/data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('head'); ?>

    <style>
        :root{
            --navy:#0B2A6B;
            --navy-deep:#071B45;
            --gold:#F0AE00;
            --gold-soft:#FDF0CC;
            --flag-red:#C8102E;
            --ink:#16213E;
            --slate:#5B6478;
            --mist:#F5F7FB;
            --line:#E6E9F2;
            --danger:#DC2626;
            --success:#0F9D65;
        }

        *,*::before,*::after{
            box-sizing:border-box;
        }

        html{
            height:100%;
            -webkit-text-size-adjust:100%;
        }

        body{
            min-height:100%;
            margin:0;
            padding:0;
            font-family:'Inter',system-ui,-apple-system,sans-serif;
            background:var(--mist);
            color:var(--ink);
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
        }

        .auth-page{
            min-height:100vh;
            min-height:100dvh;
            display:flex;
            align-items:center;
            justify-content:center;
            width:100%;
        }

        a{color:inherit}

        :focus-visible{
            outline:2px solid var(--navy);
            outline-offset:2px;
        }
    </style>
</head>
<body class="auth-page">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($slot)): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <?php echo $__env->yieldContent('auth-content'); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\layouts\master.blade.php ENDPATH**/ ?>