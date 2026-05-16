<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Services\NotificationService;
use App\Events\NotificationUpdated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Http\Controllers\Customer\LokasiController;
use Illuminate\Support\Facades\DB;
use App\Services\MidtransService;

class CheckoutController extends Controller
{
    // INDEX
    public function index()
    {
        // Ambil data checkout dari session
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }

        // Hitung total harga
        $total = collect($checkoutItems)->sum(fn($i) => $i['harga'] * $i['jumlah']);

        // Ambil daftar provinsi dari LokasiController
        $lokasi = new LokasiController();
        $provinsiList = array_keys($lokasi->provinsiKota);

        return view('customer.checkout', compact('checkoutItems', 'total', 'provinsiList'));
    }

    // STORE
    public function store(Request $request)
    {
        $selectedItems = json_decode($request->selected_items, true);

        if (!$selectedItems || count($selectedItems) === 0) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        // Ambil data dari DB sesuai ID keranjang user
        $keranjangItems = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedItems)
            ->get()
            ->map(function ($item) {
                $hargaProduk = $item->produk->harga;
                $diskon = $item->produk->diskon ?? 0;

                $hargaFinal = $diskon > 0 ? $hargaProduk - ($hargaProduk * $diskon / 100) : $hargaProduk;

                return [
                    'keranjang_id' => $item->id,
                    'produk_id' => $item->produk->id,
                    'nama_produk' => $item->produk->nama_produk,
                    'harga_asli' => $hargaProduk,
                    'diskon' => $diskon,
                    'harga' => $hargaFinal, // harga setelah diskon
                    'warna' => $item->warna,
                    'ukuran' => $item->ukuran,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $hargaFinal * $item->jumlah, // subtotal sudah diskon
                ];
            })->toArray();

        // Simpan ke session
        session(['checkout_items' => $keranjangItems]);

        return redirect()->route('customer.checkout.view');
    }

    /**
     * Proses checkout, simpan pesanan
     */
    // =========================
    // 🔥 PROSES (SNAP POPUP)
    // =========================
    public function proses(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'alamat_detail' => 'required|string',
        ]);

        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return response()->json([
                'error' => 'Tidak ada produk di keranjang.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $total = collect($checkoutItems)->sum(fn($item) => $item['subtotal']);

            // ✅ CREATE ORDER (TANPA midtrans_order_id)
            $order = Order::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,
                'email' => $request->email ?? Auth::user()->email,

                // pembayaran
                'metode_pembayaran' => 'pending',
                'payment_status' => 'pending',

                // order
                'status' => 'menunggu',

                'subtotal' => $total,
            ]);

            // ✅ SAVE ITEMS
            foreach ($checkoutItems as $item) {

                $produk = Produk::find($item['produk_id']);

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($produk->jumlah < $item['jumlah']) {
                    throw new \Exception('Stok tidak mencukupi.');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item['produk_id'],
                    'nama_produk' => $item['nama_produk'],
                    'warna' => $item['warna'],
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                $produk->jumlah -= $item['jumlah'];
                $produk->save();

                Keranjang::where('user_id', Auth::id())
                    ->where('produk_id', $item['produk_id'])
                    ->delete();
            }

            session()->forget('checkout_items');

            DB::commit();

            // ✅ MIDTRANS (INI YANG HANDLE order_id)
            $midtrans = new MidtransService();
            $snapData = $midtrans->createSnapToken($order);

            // ✅ NOTIF
            $data = app(NotificationService::class)->get();
            broadcast(new NotificationUpdated($data));

            return response()->json([
                'snap_token' => $snapData['snap_token'],
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan halaman checkout langsung(beli langsung tanpa keranjang)
     */
    // =========================
    // DASHBOARD CHECKOUT (optional)
    // =========================
    public function indexDashboard(Request $request)
    {
        $user = auth()->user();

        if ($user->status === 'nonaktif') {
            return redirect()->route('services.customer-service')
                ->with('error', 'Akun dinonaktifkan.');
        }

        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'nullable|integer|min:1',
            'warna' => 'nullable|string|max:50',
            'ukuran' => 'nullable|string|max:50',
        ]);

        $produk = Produk::findOrFail($validated['produk_id']);

        $lokasi = new LokasiController();
        $provinsiList = array_keys($lokasi->provinsiKota);

        $diskon = $produk->diskon ?? 0;

        $hargaFinal = $diskon > 0
            ? $produk->harga - ($produk->harga * $diskon / 100)
            : $produk->harga;

        $jumlah = $validated['jumlah'] ?? 1;

        $checkoutItem = [
            'produk_id' => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'harga' => $hargaFinal,
            'warna' => $validated['warna'] ?? null,
            'ukuran' => $validated['ukuran'] ?? null,
            'jumlah' => $jumlah,
            'subtotal' => $hargaFinal * $jumlah,
        ];

        session(['checkout_dashboard' => $checkoutItem]);

        return view('customer.checkout_dashboard', [
            'checkoutItem' => $checkoutItem,
            'total' => $checkoutItem['subtotal'],
            'provinsiList' => $provinsiList,
        ]);
    }


    /**
     * Proses checkout langsung
     */
    public function prosesDashboard(Request $request)
    {
        $checkoutItem = session('checkout_dashboard', null);

        if (!$checkoutItem) {
            return response()->json([
                'error' => 'Tidak ada produk untuk checkout.'
            ], 400);
        }

        // VALIDASI
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'provinsi' => 'required|string',
            'kota' => 'required|string|max:100',
            'alamat_detail' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $produk = Produk::find($checkoutItem['produk_id']);

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            if ($produk->jumlah < $checkoutItem['jumlah']) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }

            $midtransOrderId = 'ORDER-' . time();

            // 🔥 CREATE ORDER
            $order = Order::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'email' => $request->email ?? Auth::user()->email,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,

                // pembayaran
                'metode_pembayaran' => 'pending',
                'payment_status' => 'pending',

                // order
                'status' => 'menunggu',

                'subtotal' => $checkoutItem['subtotal'],
                'midtrans_order_id' => $midtransOrderId,
            ]);

            // 🔥 ORDER ITEM
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $checkoutItem['produk_id'],
                'nama_produk' => $checkoutItem['nama_produk'],
                'warna' => $checkoutItem['warna'],
                'ukuran' => $checkoutItem['ukuran'],
                'jumlah' => $checkoutItem['jumlah'],
                'subtotal' => $checkoutItem['subtotal'],
            ]);

            // 🔥 KURANGI STOK
            $produk->jumlah -= $checkoutItem['jumlah'];
            $produk->save();

            // 🔥 HAPUS SESSION
            session()->forget('checkout_dashboard');

            DB::commit();

            // 🔥 MIDTRANS SNAP
            $midtrans = new MidtransService();
            $snapData = $midtrans->createSnapToken($order);

            // 🔥 NOTIF ADMIN
            $data = app(NotificationService::class)->get();
            broadcast(new NotificationUpdated($data));

            // 🔥 RETURN JSON (WAJIB)
            return response()->json([
                'snap_token' => $snapData['snap_token'],
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}