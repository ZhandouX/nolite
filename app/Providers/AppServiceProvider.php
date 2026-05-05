<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Listeners\SyncCartAfterLogin;
use App\Models\Order;
use App\Models\Produk;
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
        /**
         * 🔐 FORCE HTTPS (untuk ngrok / production)
         */
        if (!app()->environment('local')) {
            URL::forceScheme('https');
        }

        /**
         * 🔐 HANDLE PROXY (ngrok supaya Laravel baca HTTPS dengan benar)
         */
        if (request()->server->has('HTTP_X_FORWARDED_PROTO')) {
            request()->server->set('HTTPS', 'on');
        }

        /**
         * 🔁 Event login → sync cart
         */
        Event::listen(Login::class, [SyncCartAfterLogin::class, 'handle']);

        /**
         * 📦 Share data pesanan admin
         */
        View::composer('layouts.admin_app', function ($view) {
            $jumlahMenunggu = Order::where('status', 'menunggu')->count();
            $pesananMenunggu = Order::where('status', 'menunggu')->latest()->get();

            $view->with(compact('jumlahMenunggu', 'pesananMenunggu'));
        });

        /**
         * 🛒 Share produk global (pakai cache)
         */
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

        /**
         * ❤️ Wishlist composer
         */
        View::composer('*', WishlistComposer::class);

        /**
         * 🌐 Multi bahasa
         */
        App::setLocale(Session::get('locale', 'id'));
    }
}
