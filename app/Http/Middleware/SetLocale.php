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
        $available = ['en', 'fr'];

        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } else {
            $locale = substr($request->getPreferredLanguage($available), 0, 2);
        }

        if (! in_array($locale, $available)) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}