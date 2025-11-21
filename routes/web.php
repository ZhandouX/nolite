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

        // KATEGORI
        Route::resource('kategori', KategoriController::class);
        Route::post('/kategori/store-ajax', [KategoriController::class, 'storeAjax'])->name('kategori.store-ajax');
        Route::post('/kategori/{kategori}/update-ajax', [KategoriController::class, 'updateAjax'])->name('kategori.update-ajax');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // HAPUS FOTO PRODUK DARI STORAGE
        Route::delete('/produk/foto/{id}', [ProdukController::class, 'hapusFoto'])
            ->name('produk.foto.hapus');

        // PRODUK
        Route::resource('produk', ProdukController::class);
        Route::patch('/produk/{produk}/diskon', [ProdukController::class, 'updateDiskon'])
            ->name('produk.diskon');

        // ORDER
        Route::resource('order', AdminOrderController::class);
        Route::post('/order/{order}/update-status', [AdminOrderController::class, 'updateStatus'])
            ->name('order.updateStatus');

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
            Route::get('/', [AdminChatController::class, 'index'])->name('index');              // daftar chat
            Route::get('/{chat}', [AdminChatController::class, 'show'])->name('show');          // lihat chat
            Route::post('/{chat}/send', [AdminChatController::class, 'send'])->name('send');    // kirim pesan
    
            // Hapus pesan tertentu
            Route::delete('/message/{id}', [AdminChatController::class, 'deleteMessage'])
                ->name('message.delete');

            // Hapus seluruh chat (beserta semua pesan)
            Route::delete('/{id}', [AdminChatController::class, 'deleteChat'])
                ->name('delete');
        });


        // ==========================
        // 👥 KELOLA PENGGUNA
        // ==========================
        Route::controller(UserController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
            Route::get('/', 'index')->name('index');                // daftar
            Route::get('/{user}', 'show')->name('show');            // detail
            Route::patch('/{user}/block', 'block')->name('block');  // blokir
            Route::patch('/{user}/activate', 'activate')->name('activate'); // aktifkan
            Route::patch('/{user}/nonaktif', 'nonaktif')->name('nonaktif'); // nonaktifkan
            Route::delete('/{user}', 'destroy')->name('destroy');   // hapus permanen
        });

        // ==========================
        // 💬 CUSTOMER SERVICE (ADMIN)
        // ==========================
        Route::prefix('customer-service')->name('customer-service.')->group(function () {
            Route::get('/', [CustomerServiceAdminController::class, 'index'])
                ->name('index'); // Route name: admin.customer-service.index
    
            Route::get('/{user}', [CustomerServiceAdminController::class, 'show'])
                ->name('show'); // Route name: admin.customer-service.show
    
            Route::post('/reply/{id}', [CustomerServiceAdminController::class, 'reply'])
                ->name('reply'); // Route name: admin.customer-service.reply
        });

        // =========================
        // NOTIFICATIONS
        // =========================
        Route::get('/notifications', [NotificationController::class, 'notifications'])->name('notifications');
    });


// MIDDLEWARE: CUSTOMER
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'index'])
        ->name('customer.dashboard');

    // COSTUMER SERVICE
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/customer-service', [CustomerServiceController::class, 'index'])
            ->name('customer-service'); // hasil: services.customer-service

        Route::post('/customer-service/send', [CustomerServiceController::class, 'sendMessage'])
            ->name('customer-service.send'); // hasil: services.customer-service.send
    });

    // CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout.view');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('customer.checkout.proses');
    Route::post('/dashboard/checkout', [CheckoutController::class, 'indexDashboard'])->name('customer.checkout.dashboard');
    Route::post('/dashboard/checkout/proses', [CheckoutController::class, 'prosesDashboard'])->name('customer.checkout.dashboard.proses');

    // ORDER
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    // SUCCESS PAGE
    Route::get('/checkout/success/{id}', function ($id) {
        $order = \App\Models\Order::with('items')->findOrFail($id);
        return view('customer.checkout_success', compact('order'));
    })->name('customer.order.success');

    // ULASAN
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('customer.ulasan.store');
    Route::get('/ulasan/{ulasan}', [UlasanController::class, 'show'])->name('customer.ulasan.show');
    Route::put('/ulasan/{ulasan}', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::get('/ulasan/{ulasan}/edit', [UlasanController::class, 'edit'])->name('ulasan.edit'); // Baru
    Route::delete('/ulasan-foto/{foto}', [UlasanController::class, 'hapusFoto'])->name('ulasan.foto.hapus'); // Baru
    
    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{produkId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
});


// SEMUA PRODUK
Route::get('/all-produk/customer', [DashboardController::class, 'allProduk'])->name('customer.allProduk');
Route::get('/produk/unggulan', [DashboardController::class, 'unggulanProduk'])->name('customer.unggulan');
Route::get('/produk/diskon', [DashboardController::class, 'diskonProduk'])->name('customer.diskon');

// KATEGORI
Route::get('/kategori/{kategori}', [ProdukCustomerController::class, 'kategori'])->name('customer.kategori-produk');

// DETAIL PRODUK
Route::get('/produk/{id}', [DashboardController::class, 'show'])->name('produk.detail');

// ============================================
// SEARCH ROUTES
// ============================================

// Route untuk search produk
Route::get('/search-produk', [ProdukCustomerController::class, 'search'])
    ->name('produk.search');

// Route untuk search dengan pagination (Alternative)
Route::get('/search-produk-pagination', [ProdukCustomerController::class, 'searchWithPagination'])
    ->name('produk.search.pagination');

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
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])
    ->name('keranjang.destroy');
Route::get('/keranjang/cek', function () {
    if (!Auth::check()) {
        $cart = session('keranjang', []);
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
Route::patch('keranjang/{id}', [KeranjangController::class, 'updateQuantity'])->name('keranjang.update');
Route::post('/keranjang/session/update', [KeranjangController::class, 'updateSession'])
    ->name('keranjang.session.update');

// API WILAYAH
Route::get('/lokasi-form', [LokasiController::class, 'form'])->name('lokasi.form');
Route::get('/get-kota', [LokasiController::class, 'getKota'])->name('lokasi.getKota');

// CHATBOT
Route::get('/chatbot', function () {
    return view('chatbot'); // pastikan file-nya: resources/views/chatbot.blade.php
})->name('chatbot.view');

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
