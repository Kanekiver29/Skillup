<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'locale' => \App\Http\Middleware\SetLocale::class,
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
        
        $middleware->web(append: \Illuminate\Http\Middleware\HandleCors::class);
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
