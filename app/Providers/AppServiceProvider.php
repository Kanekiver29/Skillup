<?php

namespace App\Providers;

use App\Filesystem\WindowsSafeFilesystem;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new WindowsSafeFilesystem;
        });
    }

    public function boot(): void
    {
        PreventRequestsDuringMaintenance::except([
            'admin',
            'admin/*',
            '/admin',
            '/admin/*',
            'login',
            'login/*',
            '/login',
            '/login/*',
            'register',
            'register/*',
            '/register',
            '/register/*',
            'up',
            '/up',
        ]);
    }
}
