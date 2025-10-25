<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function store(Request $request)
    {
        // Ambil data JSON
        $data = $request->json()->all();

        // Validasi manual
        $validator = \Validator::make($data, [
            'produk_id' => 'required|exists:produks,id',
            'warna' => 'required|string',
            'ukuran' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $produk = Produk::findOrFail($data['produk_id']);

        // Jika user belum login → simpan ke session
        if (!Auth::check()) {
            $keranjang = session()->get('keranjang', []);

            $key = $produk->id . '_' . $data['warna'] . '_' . $data['ukuran'];

            if (isset($keranjang[$key])) {
                $keranjang[$key]['jumlah'] += $data['jumlah'];
            } else {
                $keranjang[$key] = [
                    'produk_id' => $produk->id, // <- FIX: harus pakai $produk->id
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'foto' => $produk->fotos->first()->foto ?? null, // ✅ ambil foto pertama dari relasi
                    'warna' => $data['warna'],
                    'ukuran' => $data['ukuran'],
                    'jumlah' => $data['jumlah'],
                ];
            }

            session()->put('keranjang', $keranjang);

            return response()->json(['message' => 'Produk ditambahkan ke keranjang (session).']);
        }

        // Kalau sudah login → simpan ke database
        $subtotal = $produk->harga * $data['jumlah'];

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->where('warna', $data['warna'])
            ->where('ukuran', $data['ukuran'])
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $data['jumlah'];
            $keranjang->subtotal = $keranjang->jumlah * $produk->harga;
            $keranjang->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id, // <- FIX juga di sini
                'warna' => $data['warna'],
                'ukuran' => $data['ukuran'],
                'jumlah' => $data['jumlah'],
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    public function index()
    {
        if (Auth::check()) {
            $keranjang = Keranjang::with('produk')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            // Ambil dari SESSION
            $keranjang = session()->get('keranjang', []);
        }

        if (Auth::check()) {
            $items = Keranjang::with('produk')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            // Ambil dari SESSION
            $items = session()->get('keranjang', []);
        }

        return view('customer.keranjang', compact('keranjang', 'items'));
    }

    public function destroy($id)
    {
        // Jika user login
        if (Auth::check()) {
            $item = Keranjang::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan.'
                ], 404);
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang!'
            ]);
        }

        // Jika belum login (pakai session)
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang (session)!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan di keranjang.'
        ], 404);
    }

    public function kirimKeCheckout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []); // ID item yang dipilih

        $keranjangItems = Keranjang::with('produk')
            ->whereIn('id', $selectedItems)
            ->get()
            ->map(function ($item) {
                return [
                    'produk_id' => $item->produk->produk_id,
                    'nama_produk' => $item->produk->nama_produk,
                    'harga' => $item->produk->harga,
                    'warna' => $item->warna,
                    'ukuran' => $item->ukuran,
                    'jumlah' => $item->jumlah,
                ];
            })
            ->toArray();

        session(['checkout_items' => $keranjangItems]);

        return redirect()->route('customer.checkout.view');
    }

    public function checkout(Request $request)
    {
        $selectedItems = json_decode($request->selected_items, true);

        if (!$selectedItems || empty($selectedItems)) {
            return redirect()->route('customer.keranjang')->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }

        // Simpan item ke session
        session(['checkout_items' => $selectedItems]);

        return redirect()->route('customer.checkout.view');
    }

    public function count()
    {
        if (Auth::check()) {
            $count = Keranjang::where('user_id', Auth::id())->sum('jumlah');
        } else {
            $keranjang = session('keranjang', []);
            $count = array_sum(array_column($keranjang, 'jumlah'));
        }

        return response()->json(['count' => $count]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah produk berhasil diperbarui'
        ]);
    }
}
