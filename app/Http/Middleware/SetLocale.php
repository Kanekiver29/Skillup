<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locales = config('app.available_locales', ['en']);
        $locale = $request->session()->get('locale', config('app.locale', 'en'));

        // Check URL param
        if ($request->has('lang') && in_array($request->query('lang'), $locales)) {
            $locale = $request->query('lang');
            $request->session()->put('locale', $locale);
        } elseif (!in_array($locale, $locales)) {
            $locale = $locales[0];
            $request->session()->put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}

