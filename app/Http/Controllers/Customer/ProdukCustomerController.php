<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukCustomerController extends Controller
{
    /**
     * Search produk untuk customer (tanpa pagination)
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $produk = Produk::with(['fotos' => fn($q) => $q->orderBy('id', 'asc')->limit(1)])
            ->where('nama_produk', 'ILIKE', "%{$query}%")
            ->orderBy('nama_produk', 'asc')
            ->limit(20)
            ->get();

        $results = $produk->map(function ($item) {
            // Hitung diskon jika ada
            $hargaAsli = (float) $item->harga;
            $diskon = (float) ($item->diskon ?? 0);
            $hargaSetelahDiskon = $diskon > 0
                ? $hargaAsli - ($hargaAsli * $diskon / 100)
                : $hargaAsli;

            return [
                'id' => $item->id,
                'nama_produk' => $item->nama_produk,
                'harga' => $hargaAsli,
                'harga_diskon' => $hargaSetelahDiskon,
                'diskon' => $diskon,
                'jumlah' => $item->jumlah,
                'jenis' => $item->jenis ?? '-',
                'foto' => $item->fotos->isNotEmpty()
                    ? asset('storage/' . $item->fotos->first()->foto)
                    : asset('assets/images/no-image.png'),
                'warna' => $item->warna ?? '-',
                'ukuran' => $item->ukuran ?? '-',
            ];
        });

        return response()->json($results);
    }

    /**
     * Search produk dengan pagination (opsional)
     */
    public function searchWithPagination(Request $request)
    {
        $query = $request->input('q');
        $perPage = $request->input('per_page', 12);

        if (strlen($query) < 2) {
            return response()->json([
                'data' => [],
                'total' => 0,
                'current_page' => 1,
                'last_page' => 1
            ]);
        }

        $produk = Produk::with([
            'fotos' => function ($q) {
                $q->orderBy('id', 'asc')->limit(1);
            }
        ])
            ->where(function ($q) use ($query) {
                $q->whereRaw('nama_produk ILIKE ?', ["%{$query}%"])
                    ->orWhereRaw('deskripsi ILIKE ?', ["%{$query}%"])
                    ->orWhereRaw('jenis ILIKE ?', ["%{$query}%"])
                    ->orWhereRaw('jenis_lain ILIKE ?', ["%{$query}%"])
                    ->orWhereRaw('warna_lain ILIKE ?', ["%{$query}%"]);
            })
            ->orderBy('nama_produk', 'asc')
            ->paginate($perPage);

        $results = [
            'data' => $produk->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_produk' => $item->nama_produk,
                    'harga' => $item->harga,
                    'diskon' => $item->diskon ?? 0,
                    'jumlah' => $item->jumlah,
                    'jenis' => $item->jenis ?? '-',
                    'foto' => $item->fotos->isNotEmpty()
                        ? asset('storage/' . $item->fotos->first()->foto)
                        : asset('assets/images/no-image.png'),
                    'warna' => is_array($item->warna) ? implode(', ', $item->warna) : ($item->warna ?? '-'),
                    'ukuran' => is_array($item->ukuran) ? implode(', ', $item->ukuran) : ($item->ukuran ?? '-'),
                ];
            }),
            'total' => $produk->total(),
            'current_page' => $produk->currentPage(),
            'last_page' => $produk->lastPage(),
            'per_page' => $produk->perPage(),
        ];

        return response()->json($results);
    }

    public function getProductModals($id)
    {
        $item = Produk::with('fotos')->findOrFail($id);
        return view('layouts.partials_user.modal-beli', compact('item'))->render()
            . view('layouts.partials_user.modal-cart', compact('item'))->render();
    }
}
