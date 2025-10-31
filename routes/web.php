<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\LandingController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\ProdukCustomerController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\LokasiController;
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

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('produk', ProdukController::class);
        Route::patch('/produk/{produk}/diskon', [ProdukController::class, 'updateDiskon'])->name('admin.produk.diskon');

        // ORDER
        Route::resource('order', AdminOrderController::class);
        Route::post('/order/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('order.updateStatus');
    });

// MIDDLEWARE: CUSTOMER 
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'index'])
        ->name('customer.dashboard');

    // CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout.view');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('customer.checkout.proses');
    Route::post('/dashboard/checkout', [CheckoutController::class, 'indexDashboard'])->name('customer.checkout.dashboard');
    Route::post('/dashboard/checkout/proses', [CheckoutController::class, 'prosesDashboard'])->name('customer.checkout.dashboard.proses');

    // SUCCESS PAGE
    Route::get('/checkout/success/{id}', function ($id) {
        $order = \App\Models\Order::with('items')->findOrFail($id);
        return view('customer.checkout_success', compact('order'));
    })->name('customer.order.success');

    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{produkId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
});


// SEMUA PRODUK
Route::get('/all-produk/customer', [DashboardController::class, 'allProduk'])->name('customer.allProduk');

// DETAIL PRODUK
Route::get('/produk/{id}', [DashboardController::class, 'show'])->name('produk.detail');

Route::get('/search-produk', [ProdukCustomerController::class, 'search'])->name('produk.search');


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
Route::patch('keranjang/{id}', [KeranjangController::class, 'updateQuantity']);

// API WILAYAH
Route::get('/lokasi-form', [LokasiController::class, 'form'])->name('lokasi.form');
Route::get('/get-kota', [LokasiController::class, 'getKota'])->name('lokasi.getKota');

// AUTH SETTINGS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
