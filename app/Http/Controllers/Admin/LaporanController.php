<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\AdminLog;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    // Ambil data untuk UI
    public function getData(Request $request)
    {
        $jenis = $request->jenis;
        $tanggalAwal = $request->tanggal_awal ?? Carbon::now()->subDays(30);
        $tanggalAkhir = $request->tanggal_akhir ?? Carbon::now();

        $data = [];
        $chart = null;

        switch ($jenis) {
            case 'penjualan':
                $orders = Order::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->where('status', 'selesai')->get(['id', 'subtotal', 'created_at']);
                $data = $orders->map(fn($o) => [
                    'ID Pesanan' => $o->id,
                    'Tanggal Transaksi' => Carbon::parse($o->created_at)->translatedFormat('d F Y'),
                    'Total (Rp)' => number_format($o->subtotal, 0, ',', '.'),
                ]);
                $chartData = Order::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->where('status', 'selesai')
                    ->selectRaw('DATE(created_at) as tanggal, SUM(subtotal) as total')
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->get();
                $chart = [
                    'labels' => $chartData->pluck('tanggal')->map(fn($t) => Carbon::parse($t)->translatedFormat('d M')),
                    'values' => $chartData->pluck('total'),
                    'title' => 'Grafik Penjualan Harian (Rp)',
                ];
                break;

            case 'produk':
                $produk = Produk::withCount('orderItems')->orderByDesc('order_items_count')->take(10)->get();
                $data = $produk->map(fn($p) => [
                    'Nama Produk' => $p->nama_produk,
                    'Jumlah Terjual' => $p->order_items_count,
                    'Stok Tersisa' => $p->jumlah,
                ]);
                $chart = [
                    'labels' => $produk->pluck('nama_produk'),
                    'values' => $produk->pluck('order_items_count'),
                    'title' => '10 Produk Terlaris',
                ];
                break;

            case 'keuangan':
                $orders = Order::where('status', 'selesai')
                    ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->get();

                $totalPendapatan = $orders->sum('subtotal');
                $jumlahTransaksi = $orders->count();
                $rataRata = $jumlahTransaksi > 0
                    ? $totalPendapatan / $jumlahTransaksi
                    : 0;

                $transaksiTertinggi = $orders->max('subtotal') ?? 0;
                $transaksiTerendah = $orders->min('subtotal') ?? 0;

                $data = collect([
                    [
                        'Keterangan' => 'Total Pendapatan',
                        'Nilai' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.')
                    ],
                    [
                        'Keterangan' => 'Jumlah Transaksi',
                        'Nilai' => $jumlahTransaksi
                    ],
                    [
                        'Keterangan' => 'Rata-rata Transaksi',
                        'Nilai' => 'Rp ' . number_format($rataRata, 0, ',', '.')
                    ],
                    [
                        'Keterangan' => 'Transaksi Tertinggi',
                        'Nilai' => 'Rp ' . number_format($transaksiTertinggi, 0, ',', '.')
                    ],
                    [
                        'Keterangan' => 'Transaksi Terendah',
                        'Nilai' => 'Rp ' . number_format($transaksiTerendah, 0, ',', '.')
                    ],
                ]);

                $chart = [
                    'labels' => [
                        'Total Pendapatan',
                        'Rata-rata Transaksi',
                        'Transaksi Tertinggi',
                        'Transaksi Terendah'
                    ],
                    'values' => [
                        $totalPendapatan,
                        $rataRata,
                        $transaksiTertinggi,
                        $transaksiTerendah
                    ],
                    'title' => 'Ringkasan Keuangan'
                ];
                break;

            case 'pengguna':
                $users = User::select('id', 'name', 'email', 'created_at')->get()
                    ->map(fn($u) => [
                        'ID Pengguna' => $u->id,
                        'Nama' => $u->name,
                        'Email' => $u->email,
                        'Tanggal Daftar' => Carbon::parse($u->created_at)->translatedFormat('d F Y'),
                    ]);
                $chartData = User::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
                    ->groupBy('tanggal')->orderBy('tanggal')->get();
                $chart = [
                    'labels' => $chartData->pluck('tanggal')->map(fn($t) => Carbon::parse($t)->translatedFormat('d M')),
                    'values' => $chartData->pluck('jumlah'),
                    'title' => 'Grafik Pertumbuhan Pengguna',
                ];
                $data = $users;
                break;

            case 'stok':
                $produkStok = Produk::orderBy('jumlah')->take(10)->get(['nama_produk', 'jumlah']);
                $chart = [
                    'labels' => $produkStok->pluck('nama_produk')->values(),
                    'values' => $produkStok->pluck('jumlah')->values(),
                    'title'  => '10 Produk dengan Stok Terendah',
                ];
                $data = $produkStok->map(fn($p) => [
                    'Nama Produk' => $p->nama_produk,
                    'Jumlah Stok' => $p->jumlah,
                ])->values();
                break;

            case 'pesanan':

                $data = Order::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->select('id', 'nama_penerima', 'status', 'created_at')
                    ->latest()
                    ->get()
                    ->map(fn($o) => [
                        'ID Pesanan' => $o->id,
                        'Pelanggan' => $o->nama_penerima,
                        'Status' => ucfirst($o->status),
                        'Tanggal' => Carbon::parse($o->created_at)->translatedFormat('d F Y'),
                    ]);

                $chartStatus = Order::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->selectRaw('status, COUNT(*) as total')
                    ->groupBy('status')
                    ->get();

                $chart = [
                    'labels' => $chartStatus->pluck('status')->map(function ($status) {
                        return match ($status) {
                            'pending' => 'Menunggu',
                            'diproses' => 'Diproses',
                            'dikirim' => 'Dikirim',
                            'selesai' => 'Selesai',
                            default => ucfirst($status)
                        };
                    }),
                    'values' => $chartStatus->pluck('total'),
                    'title' => 'Distribusi Status Pesanan',
                ];

                break;

            case 'ulasan':
                $ulasanList = Ulasan::with('user', 'produk')->latest()->get();
                $ratingCount = $ulasanList->groupBy('rating')->map->count();
                $chart = [
                    'labels' => collect([1, 2, 3, 4, 5])->map(fn($r) => $r . ' Bintang'),
                    'values' => collect([1, 2, 3, 4, 5])->map(fn($r) => $ratingCount->get($r, 0)),
                    'title'  => 'Distribusi Rating Ulasan',
                ];
                $data = $ulasanList->map(fn($u) => [
                    'Nama Pengguna' => optional($u->user)->name        ?? '-',
                    'Produk'        => optional($u->produk)->nama_produk ?? '-',
                    'Rating'        => $u->rating . ' ★',
                    'Komentar'      => $u->komentar ?? '-',
                    'Tanggal'       => Carbon::parse($u->created_at)->translatedFormat('d F Y'),
                ])->values();
                break;

            case 'aktivitas':
                $data = AdminLog::latest()->take(100)->get()
                    ->map(fn($log) => [
                        'Admin' => $log->admin_name ?? '-',
                        'Aksi' => $log->aksi ?? '-',
                        'Deskripsi' => $log->deskripsi ?? '-',
                        'Tanggal' => Carbon::parse($log->created_at)->translatedFormat('d F Y H:i'),
                    ]);
                break;
        }

        return response()->json(['data' => $data, 'chart' => $chart]);
    }

    // 🔹 Export PDF
    public function exportPDF($jenis)
    {
        $data = $this->getExportData($jenis);

        // Load view dengan data dan jenis
        $pdf = Pdf::loadView('admin.laporan.export_pdf', compact('data', 'jenis'))
            ->setPaper('a4', 'portrait'); // 📄 Ukuran A4, portrait

        return $pdf->download("laporan_{$jenis}_" . now()->format('Ymd_His') . ".pdf");
    }

    // 🔹 Export Excel (dengan sheet name & header rapi)
    public function exportExcel($jenis)
    {
        $data = $this->getExportData($jenis);

        return Excel::download(
            new GenericExport($data, "Laporan " . ucfirst($jenis)),
            "laporan_{$jenis}_" . now()->format('Ymd_His') . ".xlsx"
        );
    }

    // 🔹 Ambil data mentah untuk export
    private function getExportData($jenis)
    {
        $request = new Request(['jenis' => $jenis]);
        $response = $this->getData($request);
        return json_decode($response->getContent(), true)['data'];
    }
}
