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
        if (auth()->check()) {
            $user = auth()->user();

            // Cek Role User
            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            } elseif ($user->hasRole('customer')) {
                return route('customer.dashboard');
            }
        }

        // Jika belum login di arahkan ke halaman login
        return route('login');
    }
}
