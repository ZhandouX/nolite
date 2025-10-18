<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Simpan flag agar modal login muncul
            return redirect('/')
                ->with('showLoginModal', true);
        }

        return $next($request);
    }
}
