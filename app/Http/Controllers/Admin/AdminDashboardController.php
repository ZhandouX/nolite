<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\ProdukFoto;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $produks = Produk::with('fotos')->get();

        // Total produk
        $totalProduk = Produk::count();

        // Stok tersedia
        $stokTersedia = Produk::where('jumlah', '>', 0)->sum('jumlah');

        // Total pesanan
        $totalPesanan = Order::count();

        // Total pendapatan (status = selesai)
        $totalPendapatan = Order::where('status', 'selesai')->sum('subtotal');

        // Pesanan pending
        $pesananPending = Order::where('status', 'menunggu')->count();

        // Pesanan terbaru
        $pesananTerbaru = Order::latest()->take(5)->get();

        // Produk terlaris
        $produkTerlaris = Produk::withSum('orderItems as total_terjual', 'jumlah')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // === Pendapatan bulanan (12 bulan terakhir) ===
        $pendapatanBulanan = Order::select(
            DB::raw('EXTRACT(MONTH FROM created_at)::int as bulan'),
            DB::raw('EXTRACT(YEAR FROM created_at)::int as tahun'),
            DB::raw('SUM(subtotal) as total')
        )
            ->where('status', 'selesai')
            ->whereBetween('created_at', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Format data untuk chart
        $bulanLabels = [];
        $pendapatanData = [];

        for ($i = 0; $i < 12; $i++) {
            $bulan = now()->subMonths(11 - $i);
            $label = $bulan->translatedFormat('M Y'); // contoh: Okt 2025

            $data = $pendapatanBulanan->firstWhere(
                fn($row) =>
                $row->bulan == $bulan->month && $row->tahun == $bulan->year
            );

            $bulanLabels[] = $label;
            $pendapatanData[] = $data ? (int) $data->total : 0;
        }

        // === Tambahan untuk Floating Button Pesanan Menunggu ===
        $pesananMenunggu = Order::where('status', 'menunggu')
            ->latest()
            ->get();

        $jumlahMenunggu = $pesananMenunggu->count();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalProduk',
            'stokTersedia',
            'totalPesanan',
            'totalPendapatan',
            'pesananPending',
            'pesananTerbaru',
            'produkTerlaris',
            'bulanLabels',
            'pendapatanData',
            'pesananMenunggu',
            'jumlahMenunggu'
        ));
    }
}
