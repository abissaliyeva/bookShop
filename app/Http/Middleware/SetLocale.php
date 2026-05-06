<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Read locale saved in session, fall back to config default
        $locale = session('locale', config('app.locale'));

        // Only accept locales that are actually supported
        $supported = config('app.available_locales', ['en']);

        if (in_array($locale, $supported)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}