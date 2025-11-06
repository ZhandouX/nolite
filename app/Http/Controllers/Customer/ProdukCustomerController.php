<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukCustomerController extends Controller
{
    /**
     * Search produk untuk customer
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Validasi minimal 2 karakter
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Gunakan ILIKE agar tidak case-sensitive (PostgreSQL)
        $produk = Produk::with([
            'fotos' => function ($q) {
                $q->orderBy('id', 'asc')->limit(1);
            }
        ])
            ->where(function ($q) use ($query) {
                $q->where('nama_produk', 'ILIKE', "%{$query}%")
                    ->orWhere('deskripsi', 'ILIKE', "%{$query}%")
                    ->orWhere('jenis', 'ILIKE', "%{$query}%")
                    ->orWhere('jenis_lain', 'ILIKE', "%{$query}%")
                    ->orWhere('warna_lain', 'ILIKE', "%{$query}%");
            })
            ->orderBy('nama_produk', 'asc')
            ->limit(20)
            ->get();

        // Format data response JSON
        $results = $produk->map(function ($item) {
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
        });

        return response()->json($results);
    }

    /**
     * Search produk dengan pagination (opsional)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
                $q->where('nama_produk', 'ILIKE', "%{$query}%")
                    ->orWhere('deskripsi', 'ILIKE', "%{$query}%")
                    ->orWhere('jenis', 'ILIKE', "%{$query}%")
                    ->orWhere('jenis_lain', 'ILIKE', "%{$query}%")
                    ->orWhere('warna_lain', 'ILIKE', "%{$query}%");
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
}
