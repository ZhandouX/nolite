<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirect jika tidak login.
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Jika user masih login dan punya role
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            } elseif ($user->hasRole('customer')) {
                return route('customer.dashboard');
            }
        }

        // 🔹 Jika session habis atau belum login → arahkan ke landing page dengan parameter modal login
        return route('landing', ['showLogin' => 'true']);
    }
}
