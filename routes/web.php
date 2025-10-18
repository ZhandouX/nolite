<?php

use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\LandingController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\AllProdukController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// DEFAULT LANDING PAGE
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/add-to-cart', [LandingController::class, 'addToCart'])->name('landing.addToCart');

// MIDDLEWARE: ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('produk', ProdukController::class);
        Route::patch('/admin/produk/{produk}/diskon', [ProdukController::class, 'updateDiskon'])->name('admin.produk.diskon');
    });

// MIDDLEWARE: CUSTOMER 
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'index'])
        ->name('customer.dashboard');

    // CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout.view');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('customer.checkout.proses');
    Route::get('/dashboard/checkout', [CheckoutController::class, 'indexDashboard'])->name('customer.checkout.dashboard');
    Route::post('/dashboard/checkout/proses', [CheckoutController::class, 'prosesDashboard'])->name('customer.checkout.dashboard.proses');

    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{produkId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// SEMUA PRODUK
Route::get('/all-produk/customer', [DashboardController::class, 'allProduk'])->name('customer.allProduk');

// DETAIL PRODUK
Route::get('/produk/{id}', [DashboardController::class, 'show'])->name('produk.detail');

// KATEGORI
Route::get('/kategori-tshirt/customer', [DashboardController::class, 'tshirtCategory'])->name('customer.kategori-tshirt');
Route::get('/kategori-hoodie/customer', [DashboardController::class, 'hoodieCategory'])->name('customer.kategori-hoodie');
Route::get('/kategori-jersey/customer', [DashboardController::class, 'jerseyCategory'])->name('customer.kategori-jersey');

// KERANJANG
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])
    ->name('keranjang.destroy');
Route::get('/keranjang/cek', function () {
    if (!Auth::check()) {
        $cart = session('cart', []);
        return response()->json(['items' => array_values($cart)]);
    } else {
        $cart = Keranjang::where('user_id', Auth::id())
            ->with(['produk.fotos'])
            ->get()
            ->map(function ($item) {
                $foto = $item->produk->fotos->isNotEmpty()
                    ? asset('storage/' . $item->produk->fotos->first()->foto)
                    : asset('assets/images/no-image.png');

                return [
                    'id' => $item->id,
                    'produk_id' => $item->produk_id,
                    'nama' => $item->produk->nama_produk,
                    'foto' => $foto,
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                ];
            });

        $total_produk_unik = $cart->count();

        return response()->json([
            'items' => $cart,
            'total_produk_unik' => $total_produk_unik,
        ]);
    }
});
Route::get('/keranjang/count', [KeranjangController::class, 'count'])->name('keranjang.count');


// AUTH SETTINGS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
