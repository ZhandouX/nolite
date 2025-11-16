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

        $totalPesananBulanLalu = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $growthPesanan = $totalPesananBulanLalu > 0
            ? round((($totalPesanan - $totalPesananBulanLalu) / $totalPesananBulanLalu) * 100, 1)
            : 0;

        // === TOTAL PENJUALAN ===
        $totalPenjualan = Order::where('status', 'selesai')->sum('subtotal');
        $totalPenjualanBulanLalu = Order::where('status', 'selesai')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('subtotal');

        $growthPenjualan = $totalPenjualanBulanLalu > 0
            ? round((($totalPenjualan - $totalPenjualanBulanLalu) / $totalPenjualanBulanLalu) * 100, 1)
            : 0;

        // === TOTAL PENDAPATAN ===
        $pendapatan = $totalPenjualan;
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

        // === PESANAN ===
        $pesananPending = Order::where('status', 'menunggu')->count();
        $pesananTerbaru = Order::latest()->take(5)->get();

        // === PRODUK TERLARIS ===
        $produkTerlaris = Produk::with(['fotos'])
            ->withStatistik()
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();


        // === USER TERBARU ===
        $usersTerbaru = User::latest()->take(5)->get();

        // === PENDAPATAN BULANAN ===
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
            $label = $bulan->translatedFormat('M Y');

            $data = $pendapatanBulanan->firstWhere(
                fn($row) => $row->bulan == $bulan->month && $row->tahun == $bulan->year
            );

            $bulanLabels[] = $label;
            $pendapatanData[] = $data ? (int) $data->total : 0;
        }

        // === PESANAN MENUNGGU FLOATING ===
        $pesananMenunggu = Order::where('status', 'menunggu')->latest()->get();
        $jumlahMenunggu = $pesananMenunggu->count();

        // === STATISTIK PENGGUNA BULANAN ===
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

        // === KIRIM KE VIEW ===
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
            'usersTerbaru',
            'pesananMenunggu',
            'jumlahMenunggu'
        ));
    }
}
