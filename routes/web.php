<?php

use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ROUTE DEFAULT UNTUK LANDING PAGE (SAAT PERTAMA KALI MEMBUKA WEBSITE)
Route::get('/', function () {
    if (Auth::check()) {
        // Jika sudah login, redirect ke dashboard sesuai role
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        } else {
            // Jika role tidak dikenal, redirect ke login
            return redirect('/login');
        }
    }

    // Jika belum login, tampilkan landing page
    return view('welcome');
});

// ROLE ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('produk', ProdukController::class);
    });

// ROLE CUSTOMER
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', function () {
        return view('customer.dashboard'); // file Blade customer
    })->name('customer.dashboard');
});

// ROUTE UNTUK PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
