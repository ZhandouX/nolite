<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // === TOTAL PRODUK ===
        $totalProduk = Produk::count();
        $stokTersedia = Produk::where('jumlah', '>', 0)->sum('jumlah');

        // === TOTAL PESANAN ===
        $totalPesanan = Order::count();

        // Pesanan bulan lalu untuk growth
        $totalPesananBulanLalu = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $growthPesanan = $totalPesananBulanLalu > 0
            ? round((($totalPesanan - $totalPesananBulanLalu) / $totalPesananBulanLalu) * 100, 1)
            : 0;

        // === TOTAL PENJUALAN ===
        $totalPenjualan = Order::where('status', 'selesai')->sum('subtotal');

        // Penjualan bulan lalu untuk growth
        $totalPenjualanBulanLalu = Order::where('status', 'selesai')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('subtotal');

        $growthPenjualan = $totalPenjualanBulanLalu > 0
            ? round((($totalPenjualan - $totalPenjualanBulanLalu) / $totalPenjualanBulanLalu) * 100, 1)
            : 0;

        // === TOTAL PENDAPATAN ===
        $pendapatan = $totalPenjualan; // sama dengan totalPenjualan
        $pendapatanBulanLalu = $totalPenjualanBulanLalu;
        $growthPendapatan = $pendapatanBulanLalu > 0
            ? round((($pendapatan - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : 0;

        // === TOTAL PENGGUNA ===
        $totalPengguna = User::count();

        $penggunaBulanLalu = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $growthPengguna = $penggunaBulanLalu > 0
            ? round((($totalPengguna - $penggunaBulanLalu) / $penggunaBulanLalu) * 100, 1)
            : 0;

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

        $bulanLabels = [];
        $pendapatanData = [];
        for ($i = 0; $i < 12; $i++) {
            $bulan = now()->subMonths(11 - $i);
            $label = $bulan->translatedFormat('M Y'); // contoh: Okt 2025

            $data = $pendapatanBulanan->firstWhere(
                fn($row) => $row->bulan == $bulan->month && $row->tahun == $bulan->year
            );

            $bulanLabels[] = $label;
            $pendapatanData[] = $data ? (int) $data->total : 0;
        }

        // Pesanan menunggu untuk Floating Button
        $pesananMenunggu = Order::where('status', 'menunggu')->latest()->get();
        $jumlahMenunggu = $pesananMenunggu->count();

        // Statistik pengguna bulanan (12 bulan terakhir)
        $penggunaBulanan = User::select(
            DB::raw('EXTRACT(MONTH FROM created_at)::int as bulan'),
            DB::raw('EXTRACT(YEAR FROM created_at)::int as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $penggunaData = [];
        for ($i = 0; $i < 12; $i++) {
            $bulan = now()->subMonths(11 - $i);
            $data = $penggunaBulanan->firstWhere(
                fn($row) => $row->bulan == $bulan->month && $row->tahun == $bulan->year
            );
            $penggunaData[] = $data ? (int) $data->total : 0;
        }

        // Kirim ke view
        return view('admin.dashboard', compact(
            'bulanLabels',
            'pendapatanData',
            'penggunaData',
            'totalProduk',
            'stokTersedia',
            'totalPesanan',
            'growthPesanan',
            'totalPenjualan',
            'growthPenjualan',
            'pendapatan',
            'growthPendapatan',
            'totalPengguna',
            'growthPengguna',
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
