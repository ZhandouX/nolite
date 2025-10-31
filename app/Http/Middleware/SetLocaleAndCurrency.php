<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleAndCurrency
{
    public function handle(Request $request, Closure $next)
    {
        // --- Bahasa (locale) ---
        $locale = Session::get('locale', 'id');
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }
        App::setLocale($locale);

        // --- Mata uang ---
        $currency = Session::get('currency', 'IDR');
        if ($request->has('currency')) {
            $currency = strtoupper($request->get('currency'));
            Session::put('currency', $currency);
        }

        config(['app.currency' => $currency]);

        return $next($request);
    }
}
