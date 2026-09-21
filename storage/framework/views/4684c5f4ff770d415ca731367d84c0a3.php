<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-4 rounded-2xl border border-slate-700 bg-slate-900/80 p-8 shadow-2xl">
        <div class="inline-flex items-center rounded-full border border-amber-500/40 bg-amber-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-300">
            Scheduled Maintenance
        </div>

        <h1 class="mt-6 text-4xl font-bold tracking-tight">Maintenance Mode</h1>

        <p class="mt-4 text-lg text-slate-300">
            This site will remain under maintenance only.
        </p>

        <div class="mt-8 rounded-xl border border-slate-700 bg-slate-800/70 p-5 text-sm text-slate-300">
            <p class="font-semibold text-slate-100">Maintenance details</p>
            <p class="mt-2"><?php echo e(env('APP_MAINTENANCE_REASON', 'Scheduled system maintenance is in progress.')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\errors\maintenance.blade.php ENDPATH**/ ?>