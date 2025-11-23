<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CustomerServiceAdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerServiceController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\LandingController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProdukCustomerController;
use App\Http\Controllers\Customer\UlasanController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\LokasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminChatController;


// DEFAULT LANDING PAGE
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/add-to-cart', [LandingController::class, 'addToCart'])->name('landing.addToCart');

// ==========================
// 🔐 MIDDLEWARE: ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ================
        // KATEGORI
        // ================
        Route::resource('kategori', KategoriController::class);
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::post('/store-ajax', [KategoriController::class, 'storeAjax'])->name('store-ajax');
            Route::post('/{kategori}/update-ajax', [KategoriController::class, 'updateAjax'])->name('update-ajax');
            Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
        });

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ====================================
        // PRODUK
        // ====================================
        Route::resource('produk', ProdukController::class);
        Route::prefix('produk')->name('produk.')->group(function () {
            Route::delete('/foto/{id}', [ProdukController::class, 'hapusFoto'])->name('foto.hapus');
            Route::patch('/{produk}/diskon', [ProdukController::class, 'updateDiskon'])->name('diskon');
        });

        // ============
        // ORDER
        // ============
        Route::resource('order', AdminOrderController::class);
        Route::prefix('order')->name('order.')->group(function () {
            Route::post('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        });

        // ==========================
        // 📊 LAPORAN
        // ==========================
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::post('/get-data', [LaporanController::class, 'getData'])->name('getData');

            // Export PDF & Excel
            Route::get('/export-pdf/{jenis}', [LaporanController::class, 'exportPDF'])->name('exportPDF');
            Route::get('/export-excel/{jenis}', [LaporanController::class, 'exportExcel'])->name('exportExcel');
        });

        // ==========================
        // 🧩 CHAT MANAGEMENT (ADMIN)
        // ==========================
        Route::prefix('chats')->name('chats.')->group(function () {
            Route::get('/', [AdminChatController::class, 'index'])->name('index');
            Route::get('/{chat}', [AdminChatController::class, 'show'])->name('show');
            Route::post('/{chat}/send', [AdminChatController::class, 'send'])->name('send');
            Route::delete('/message/{id}', [AdminChatController::class, 'deleteMessage'])->name('message.delete');
            Route::delete('/{id}', [AdminChatController::class, 'deleteChat'])->name('delete');
        });


        // ==========================
        // 👥 KELOLA PENGGUNA
        // ==========================
        Route::controller(UserController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{user}', 'show')->name('show');
            Route::patch('/{user}/block', 'block')->name('block');
            Route::patch('/{user}/activate', 'activate')->name('activate');
            Route::patch('/{user}/nonaktif', 'nonaktif')->name('nonaktif');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

        // ==========================
        // 💬 CUSTOMER SERVICE (ADMIN)
        // ==========================
        Route::prefix('customer-service')->name('customer-service.')->group(function () {
            Route::get('/', [CustomerServiceAdminController::class, 'index'])->name('index');
            Route::get('/{user}', [CustomerServiceAdminController::class, 'show'])->name('show');
            Route::post('/reply/{id}', [CustomerServiceAdminController::class, 'reply'])->name('reply');
        });

        // =========================
        // NOTIFICATIONS
        // =========================
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'notifications'])->name('index');
            Route::get('/all', [NotificationController::class, 'all'])->name('all');
        });
    });


// MIDDLEWARE: CUSTOMER
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'index'])
        ->name('customer.dashboard');

    // COSTUMER SERVICE
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/customer-service', [CustomerServiceController::class, 'index'])->name('customer-service');
        Route::post('/customer-service/send', [CustomerServiceController::class, 'sendMessage'])->name('customer-service.send');
    });

    // CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout.view');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('customer.checkout.proses');
    Route::post('/dashboard/checkout', [CheckoutController::class, 'indexDashboard'])->name('customer.checkout.dashboard');
    Route::post('/dashboard/checkout/proses', [CheckoutController::class, 'prosesDashboard'])->name('customer.checkout.dashboard.proses');

    // ORDER
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('customer.orders.show');
    
    // SUCCESS PAGE
    Route::get('/checkout/success/{id}', function ($id) {
        $order = \App\Models\Order::with('items')->findOrFail($id);
        return view('customer.checkout_success', compact('order'));
    })->name('customer.order.success');

    // ULASAN
    Route::prefix('ulasan')->group(function () {
        Route::post('/', [UlasanController::class, 'store'])->name('customer.ulasan.store');
        Route::get('/{ulasan}', [UlasanController::class, 'show'])->name('customer.ulasan.show');
        Route::put('/{ulasan}', [UlasanController::class, 'update'])->name('customer.ulasan.update');
        Route::get('/{ulasan}/edit', [UlasanController::class, 'edit'])->name('customer.ulasan.edit');
        Route::delete('/ulasan-foto/{foto}', [UlasanController::class, 'hapusFoto'])->name('customer.ulasan.ulasan-foto.delete');
    });
    
    // WISHLIST
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{produkId}', [WishlistController::class, 'toggleWishlist'])->name('toggle');
        Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('remove');
    });
});


// SEMUA PRODUK
Route::prefix('produk')->group(function () {
    Route::get('/all', [DashboardController::class, 'allProduk'])->name('customer.allProduk');
    Route::get('/unggulan', [DashboardController::class, 'unggulanProduk'])->name('customer.unggulan');
    Route::get('/diskon', [DashboardController::class, 'diskonProduk'])->name('customer.diskon');
    Route::get('/{id}', [DashboardController::class, 'show'])->name('produk.detail');
});
Route::get('/kategori/{kategori}', [ProdukCustomerController::class, 'kategori'])->name('customer.kategori-produk');

// ============================================
// SEARCH
// ============================================
Route::get('/search-produk', [ProdukCustomerController::class, 'search'])->name('produk.search');
Route::get('/search-produk-pagination', [ProdukCustomerController::class, 'searchWithPagination'])->name('produk.search.pagination');

// ============================================
// OPTIONAL: AUTOCOMPLETE ROUTES (fix)
// ============================================
Route::get('/autocomplete-produk', function (Request $request) {
    $query = $request->input('q');

    if (strlen($query) < 2) {
        return response()->json([]);
    }

    $suggestions = Produk::where('nama_produk', 'ILIKE', "%{$query}%")
        ->orderBy('nama_produk', 'asc')
        ->limit(5)
        ->pluck('nama_produk');

    return response()->json($suggestions);
})->name('produk.autocomplete');
Route::get('/get-product-modals/{id}', [ProdukCustomerController::class, 'getProductModals']);

// KERANJANG
Route::prefix('keranjang')->name('keranjang.')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('index');
    Route::post('/', [KeranjangController::class, 'store'])->name('store');
    Route::delete('/{id}', [KeranjangController::class, 'destroy'])->name('destroy');
    Route::get('/cek', [KeranjangController::class, 'check'])->name('check');
    Route::get('/count', [KeranjangController::class, 'count'])->name('count');
    Route::patch('/{id}', [KeranjangController::class, 'updateQuantity'])->name('update');
    Route::post('/session/update', [KeranjangController::class, 'updateSession'])->name('session.update');
});

// API WILAYAH
Route::get('/lokasi-form', [LokasiController::class, 'form'])->name('lokasi.form');
Route::get('/get-kota', [LokasiController::class, 'getKota'])->name('lokasi.getKota');

// CHATBOT
Route::post('/chatbot/query', [ChatbotController::class, 'query'])->name('chatbot.query');



// AUTH SETTINGS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/profile-admin', [ProfileController::class, 'profileAdmin'])->name('profile.profile-admin');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
