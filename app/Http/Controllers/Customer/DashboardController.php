<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\ProdukFoto;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // INDEX
    public function index()
    {
        // PRODUK TERBARU + STATISTIK
        $produk = Produk::with('fotos')
            ->withStatistik()
            ->orderByDesc('produks.created_at')
            ->take(6)
            ->get();

        // PRODUK DISKON + STATISTIK
        $produkDiskon = Produk::with('fotos')
            ->withStatistik()
            ->where('produks.diskon', '>', 0)
            ->orderByDesc('produks.created_at')
            ->get();

        return view('customer.dashboard', compact('produk', 'produkDiskon'));
    }

    public function show($id)
    {
        $produk = Produk::with(['fotos', 'ulasan.user', 'ulasan.fotos'])->findOrFail($id);

        // Hitung rata-rata rating dan jumlah ulasan
        $totalUlasan = $produk->ulasan->count();
        $averageRating = $totalUlasan > 0 ? round($produk->ulasan->avg('rating'), 1) : 0;

        // Gunakan accessor dari model Produk
        $terjual = $produk->terjual;

        return view('customer.detail-produk', compact('produk', 'totalUlasan', 'averageRating', 'terjual'));
    }

    // HALAMAN ALL PRODUK
    public function allProduk(Request $request)
    {
        $query = Produk::query()
            ->with('fotos')
            ->withStatistik();

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // CATEGORY FILTER
        if ($request->filled('kategori')) {
            $query->whereIn('jenis', $request->kategori);
        }

        // PRODUCT TYPE FILTER
        if ($request->filled('tipe')) {
            if ($request->tipe == 'unggulan') {
                $query->where('unggulan', true);
            } elseif ($request->tipe == 'diskon') {
                $query->where('diskon', '>', 0);
            }
        }

        // MIN & MAX PRICE
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // SIZE
        if ($request->filled('ukuran')) {
            $query->whereJsonContains('ukuran', $request->ukuran);
        }

        // SORT
        switch ($request->get('sort')) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_produk', 'desc');
                break;
            default:
                $query->latest(); // ini sekarang valid, masih QueryBuilder
                break;
        }

        // PAGINATION (eksekusi query di sini)
        $produks = $query->paginate(12)->appends($request->query());

        return view('customer.all-produk', compact('produks'));
    }

    public function unggulanProduk()
    {
        $produks = Produk::with('fotos')
            ->withStatistik()
            ->orderByDesc('total_terjual')
            ->paginate(12);

        return view('customer.unggulan', compact('produks'));
    }

    // === PRODUK DISKON ===
    public function diskonProduk()
    {
        $produks = Produk::with('fotos')
            ->where('diskon', '>', 0)
            ->orderByDesc('diskon')
            ->withStatistik()
            ->paginate(12);

        return view('customer.diskon', compact('produks'));
    }

    public function tshirtCategory(Request $request)
    {
        $query = Produk::with('fotos')
            ->where('jenis', 'T-Shirt')
            ->withStatistik();

        switch ($request->input('sort')) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_produk', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $produks = $query->take(6)->get();
        return view('customer.kategori-tshirt', compact('produks'));
    }

    public function hoodieCategory(Request $request)
    {
        $query = Produk::with('fotos')
            ->where('jenis', 'Hoodie')
            ->withStatistik();

        // ==== Tambahkan logika sorting berdasarkan query string ====
        switch ($request->input('sort')) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_produk', 'desc');
                break;
            default:
                $query->latest(); // default: terbaru
                break;
        }

        // ==== Batasi 6 item (opsional) ====
        $produks = $query->take(6)->get();

        return view('customer.kategori-hoodie', compact('produks'));
    }

    public function jerseyCategory(Request $request)
    {
        $query = Produk::with('fotos')
            ->where('jenis', 'Jersey')
            ->withStatistik();

        // ==== Tambahkan logika sorting berdasarkan query string ====
        switch ($request->input('sort')) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_az':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_produk', 'desc');
                break;
            default:
                $query->latest(); // default: terbaru
                break;
        }

        // ==== Batasi 6 item (opsional) ====
        $produks = $query->take(6)->get();

        return view('customer.kategori-jersey', compact('produks'));
    }
}
