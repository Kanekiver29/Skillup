<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('backup:full --exclude-heavy --type=automatic')->dailyAt('02:00');
        $schedule->command('backup:full --exclude-heavy --type=automatic')->weeklyOn(0, '02:30');
        $schedule->command('backup:prune --days=30')->dailyAt('02:45');
        $schedule->command('cache:clear')->dailyAt('03:00');
        $schedule->command('config:clear')->dailyAt('03:05');
        $schedule->command('route:clear')->dailyAt('03:10');
        $schedule->command('view:clear')->dailyAt('03:15');
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'locale' => \App\Http\Middleware\SetLocale::class,
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'sias.admin' => \App\Http\Middleware\EnsureSiasAdmin::class,
        ]);
        
        $middleware->web(append: [
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\EnsureAdminPortal::class,
        ]);
        $middleware->web(append: ['locale']);

        // Redirect authenticated users away from guest-only pages (login/register)
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            $user = $request->user();
            if ($user && $user->is_admin) {
                return '/admin';
            }
            if ($user && method_exists($user, 'isStaff') && $user->isStaff()) {
                return '/admin/staff-dashboard';
            }
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
