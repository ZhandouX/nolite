<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\ProdukFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::with('fotos')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.dashboard', compact('produk'));
    }

    public function show($id)
    {
        $produk = Produk::with('fotos')->findOrFail($id);

        return view('customer.detail-produk', compact('produk'));
    }

    public function allProduk(Request $request)
    {
        $query = Produk::query()->with('fotos');

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

        // SIZED
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
                $query->latest();
                break;
        }

        // PAGINATION
        $produks = $query->paginate(12)->appends($request->query());

        return view('customer.all-produk', compact('produks'));
    }

    public function tshirtCategory()
    {
        $produk = Produk::with('fotos')
            ->where('jenis', 'T-Shirt')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.kategori-tshirt', compact('produk'));
    }

    public function hoodieCategory()
    {
        $produk = Produk::with('fotos')
            ->where('jenis', 'Hoodie')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.kategori-hoodie', compact('produk'));
    }

    public function jerseyCategory()
    {
        $produk = Produk::with('fotos')
            ->where('jenis', 'Jersey')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.kategori-jersey', compact('produk'));
    }
}
