<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukCustomerController extends Controller
{
    public function search(Request $request)
    {
        $keyword = strtolower(trim($request->get('q')));
        $keywordNoSpace = str_replace([' ', '-', '_'], '', $keyword);

        // Deteksi apakah ekstensi pg_trgm aktif
        $pgTrgmEnabled = false;
        try {
            $check = \DB::select("SELECT extname FROM pg_extension WHERE extname = 'pg_trgm'");
            $pgTrgmEnabled = !empty($check);
        } catch (\Exception $e) {
            $pgTrgmEnabled = false;
        }

        if ($pgTrgmEnabled) {
            // Jika pg_trgm aktif → gunakan fuzzy search PostgreSQL
            $produks = Produk::with('fotos')
                ->whereRaw('similarity(LOWER(nama_produk), ?) > 0.25', [$keyword])
                ->orWhereRaw('similarity(LOWER(REPLACE(nama_produk, \'-\', \'\')), ?) > 0.25', [$keywordNoSpace])
                ->orderByRaw('similarity(LOWER(nama_produk), ?) DESC', [$keyword])
                ->limit(30)
                ->get();
        } else {
            // Fallback: pakai LIKE dan Levenshtein di PHP
            $produks = Produk::with('fotos')
                ->whereRaw('LOWER(nama_produk) LIKE ?', ['%' . $keyword . '%'])
                ->orWhereRaw('LOWER(REPLACE(nama_produk, \'-\', \'\')) LIKE ?', ['%' . $keywordNoSpace . '%'])
                ->orWhereRaw('LOWER(REPLACE(nama_produk, \' \', \'\')) LIKE ?', ['%' . $keywordNoSpace . '%'])
                ->limit(50)
                ->get()
                ->filter(function ($produk) use ($keywordNoSpace) {
                    $nama = strtolower(str_replace([' ', '-', '_'], '', $produk->nama_produk));
                    return levenshtein($nama, $keywordNoSpace) <= 3 || str_contains($nama, $keywordNoSpace);
                })
                ->values();
        }

        return response()->json($produks);
    }
}
