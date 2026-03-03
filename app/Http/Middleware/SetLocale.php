<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);
        if (!in_array($locale, ['az', 'en', 'ru'])) {
            $locale = session('locale', 'az');
        }
        app()->setLocale($locale);
        Carbon::setLocale($locale);
        session(['locale' => $locale]);
        return $next($request);
    }
}
