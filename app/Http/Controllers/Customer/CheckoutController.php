<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Http\Controllers\Customer\LokasiController;
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

        // Ambil daftar provinsi dari LokasiController
        $lokasi = new LokasiController();
        $provinsiList = array_keys($lokasi->provinsiKota);

        return view('customer.checkout', compact('checkoutItems', 'total', 'provinsiList'));
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
    public function proses(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'alamat_detail' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Ambil item dari session checkout
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return back()->with('error', 'Tidak ada produk di keranjang.');
        }

        // Gunakan transaksi biar aman
        try {
            \DB::beginTransaction();

            // Hitung total subtotal
            $total = collect($checkoutItems)->sum(fn($item) => $item['subtotal']);

            // Simpan order utama
            $order = Order::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,
                'email' => $request->email ?? Auth::user()->email,
                'metode_pembayaran' => $request->metode_pembayaran,
                'subtotal' => $total,
                'status' => 'menunggu',
            ]);

            // Loop semua item checkout
            foreach ($checkoutItems as $item) {
                $produk = Produk::find($item['produk_id']);

                if (!$produk) {
                    throw new \Exception('Produk dengan ID ' . $item['produk_id'] . ' tidak ditemukan.');
                }

                if ($produk->jumlah < $item['jumlah']) {
                    throw new \Exception('Stok produk "' . $produk->nama_produk . '" tidak mencukupi.');
                }

                // Simpan detail order
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item['produk_id'],
                    'nama_produk' => $item['nama_produk'],
                    'warna' => $item['warna'],
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok
                $produk->jumlah -= $item['jumlah'];
                $produk->save();

                Keranjang::where('user_id', Auth::id())
                    ->where('produk_id', $item['produk_id'])
                    ->when(isset($item['ukuran']), function ($q) use ($item) {
                        $q->where('ukuran', $item['ukuran']);
                    })
                    ->when(isset($item['warna']), function ($q) use ($item) {
                        $q->where('warna', $item['warna']);
                    })
                    ->delete();
            }

            // Hapus session checkout
            session()->forget('checkout_items');

            \DB::commit();

            return redirect()->route('customer.order.success', ['id' => $order->id])
                ->with('success', 'Pesanan berhasil dibuat, stok diperbarui, dan produk dihapus dari keranjang!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman checkout langsung(beli langsung tanpa keranjang)
     */
    public function indexDashboard(Request $request)
    {
        $user = auth()->user();

        // Cek apakah akun nonaktif
        if ($user->status === 'nonaktif') {
            return redirect()->route('services.customer-service') // atau halaman lain
                ->with('error', 'Akun Anda dinonaktifkan, tidak bisa melakukan checkout.');
        }

        // Validasi data input
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'nullable|integer|min:1',
            'warna' => 'nullable|string|max:50',
            'ukuran' => 'nullable|string|max:50',
        ]);

        // Ambil produk
        $produk = Produk::findOrFail($validated['produk_id']);

        // Ambil daftar provinsi
        $lokasi = new LokasiController();
        $provinsiList = array_keys($lokasi->provinsiKota);

        // Hitung harga final
        $diskon = $produk->diskon ?? 0;
        $hargaFinal = $diskon > 0
            ? $produk->harga - ($produk->harga * $diskon / 100)
            : $produk->harga;

        $jumlah = $validated['jumlah'] ?? 1;

        // Siapkan data checkout tunggal
        $checkoutItem = [
            'produk_id' => $produk->id,
            'nama_produk' => $produk->nama_produk,
            'harga' => $hargaFinal,
            'warna' => $validated['warna'] ?? null,
            'ukuran' => $validated['ukuran'] ?? null,
            'jumlah' => $jumlah,
            'subtotal' => $hargaFinal * $jumlah,
        ];

        // Simpan sementara ke session
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
            return redirect()->route('customer.dashboard')
                ->with('error', 'Tidak ada produk yang diproses untuk checkout.');
        }

        // Validasi input pengiriman
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'provinsi' => 'required|string',
            'kota' => 'required|string|max:100',
            'alamat_detail' => 'required|string',
            'metode_pembayaran' => 'required|string',
        ]);

        $order = DB::transaction(function () use ($request, $checkoutItem) {

            // Ambil data produk dari database
            $produk = Produk::find($checkoutItem['produk_id']);

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            // Cek stok cukup atau tidak
            if ($produk->jumlah < $checkoutItem['jumlah']) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }

            // Simpan ke tabel orders
            $order = Order::create([
                'user_id' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'email' => $request->email ?? Auth::user()->email,
                'provinsi' => $request->provinsi ?? 'Sulawesi Selatan',
                'kota' => $request->kota,
                'alamat_detail' => $request->alamat_detail,
                'metode_pembayaran' => $request->metode_pembayaran,
                'subtotal' => $checkoutItem['subtotal'],
                'status' => 'menunggu',
            ]);

            // Simpan detail produk ke tabel order_items
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $checkoutItem['produk_id'],
                'nama_produk' => $checkoutItem['nama_produk'],
                'warna' => $checkoutItem['warna'],
                'ukuran' => $checkoutItem['ukuran'],
                'jumlah' => $checkoutItem['jumlah'],
                'subtotal' => $checkoutItem['subtotal'],
            ]);

            // Kurangi stok produk
            $produk->jumlah -= $checkoutItem['jumlah'];
            $produk->save();

            // Bersihkan session
            session()->forget('checkout_dashboard');

            return $order;
        });

        return redirect()->route('customer.order.success', ['id' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat dan menunggu pembayaran!');
    }
}
