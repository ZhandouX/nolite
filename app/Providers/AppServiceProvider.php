<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\SyncCartAfterLogin;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\Facades\View;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\View\Composers\WishlistComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dengarkan event login, lalu jalankan sinkronisasi keranjang
        Event::listen(Login::class, [SyncCartAfterLogin::class, 'handle']);

        // Share jumlah pesanan menunggu ke semua view admin
        View::composer('layouts.admin_app', function ($view) {
            $jumlahMenunggu = Order::where('status', 'menunggu')->count();
            $pesananMenunggu = Order::where('status', 'menunggu')->latest()->get();

            $view->with(compact('jumlahMenunggu', 'pesananMenunggu'));
        });

        // === Share produk terbaru & produk diskon ke semua view (pakai cache) ===
        View::composer('*', function ($view) {
            $produkTerbaru = cache()->remember('produk_terbaru', 60, function () {
                return Produk::with('fotos')
                    ->latest()
                    ->take(6)
                    ->get();
            });

            $produkDiskon = cache()->remember('produk_diskon', 60, function () {
                return Produk::with('fotos')
                    ->where('diskon', '>', 0)
                    ->latest()
                    ->get();
            });

            $view->with(compact('produkTerbaru', 'produkDiskon'));
        });

        View::composer('*', WishlistComposer::class);

        // Multi bahasa
        App::setLocale(Session::get('locale', 'id'));
    }
}
