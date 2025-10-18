<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
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

        return view('customer.checkout', compact('checkoutItems', 'total'));
    }

    /**
     * Simpan produk yang dipilih dari keranjang ke session
     */
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
                return [
                    'keranjang_id' => $item->id,
                    'produk_id' => $item->produk->id,
                    'nama_produk' => $item->produk->nama_produk,
                    'harga' => $item->produk->harga,
                    'warna' => $item->warna,
                    'ukuran' => $item->ukuran,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ];
            })->toArray();

        // Simpan ke session
        session(['checkout_items' => $keranjangItems]);

        return redirect()->route('customer.checkout.view');
    }

    /**
     * Proses checkout, simpan pesanan
     */
    public function proses(Request $request)
    {
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Tidak ada produk yang diproses.');
        }

        // Validasi input pengiriman
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'kota' => 'required|string|max:100',
            'alamat_detail' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $checkoutItems) {

            $total = collect($checkoutItems)->sum(fn($i) => $i['harga'] * $i['jumlah']);

            // Simpan pesanan
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'email' => $request->email ?? Auth::user()->email,
                'negara' => $request->negara ?? 'Indonesia',
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,
                'is_dropship' => $request->has('is_dropship'),
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $total,
                'status' => 'Menunggu Pembayaran',
            ]);

            // Simpan item pesanan
            foreach ($checkoutItems as $item) {
                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item['produk_id'],
                    'nama_produk' => $item['nama_produk'],
                    'harga' => $item['harga'],
                    'warna' => $item['warna'],
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);
            }

            // Hapus dari keranjang user
            Keranjang::where('user_id', Auth::id())
                ->whereIn('id', collect($checkoutItems)->pluck('keranjang_id'))
                ->delete();

            // Bersihkan session
            session()->forget('checkout_items');
        });

        return redirect()->route('customer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat dan menunggu pembayaran!');
    }

    /**
     * Menampilkan halaman checkout langsung dari dashboard (beli langsung tanpa keranjang)
     */
    public function indexDashboard(Request $request)
    {
        $produk = \App\Models\Produk::findOrFail($request->produk_id);

        // Siapkan data checkout tunggal
        $checkoutItem = [
            'produk_id' => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'harga' => $produk->harga,
            'warna' => $request->warna ?? null,
            'ukuran' => $request->ukuran ?? null,
            'jumlah' => $request->jumlah ?? 1,
            'subtotal' => $produk->harga * ($request->jumlah ?? 1),
        ];

        // Simpan sementara ke session
        session(['checkout_dashboard' => $checkoutItem]);

        return view('customer.checkout_dashboard', [
            'checkoutItem' => $checkoutItem,
            'total' => $checkoutItem['subtotal'],
        ]);
    }

    /**
     * Proses checkout langsung dari dashboard
     */
    public function prosesDashboard(Request $request)
    {
        $checkoutItem = session('checkout_dashboard', null);

        if (!$checkoutItem) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Tidak ada produk yang diproses untuk checkout.');
        }

        // Validasi input pengiriman
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'kota' => 'required|string|max:100',
            'alamat_detail' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $checkoutItem) {
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'email' => $request->email ?? Auth::user()->email,
                'negara' => $request->negara ?? 'Indonesia',
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,
                'is_dropship' => $request->has('is_dropship'),
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $checkoutItem['subtotal'],
                'status' => 'Menunggu Pembayaran',
            ]);

            // Simpan item pesanan tunggal
            PesananItem::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $checkoutItem['produk_id'],
                'nama_produk' => $checkoutItem['nama_produk'],
                'harga' => $checkoutItem['harga'],
                'warna' => $checkoutItem['warna'],
                'ukuran' => $checkoutItem['ukuran'],
                'jumlah' => $checkoutItem['jumlah'],
                'subtotal' => $checkoutItem['subtotal'],
            ]);

            // Bersihkan session
            session()->forget('checkout_dashboard');
        });

        return redirect()->route('customer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat dan menunggu pembayaran!');
    }
}
