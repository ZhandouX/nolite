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
                $orders = Order::where('status_pembayaran', 'success')->get();
                $total = $orders->sum('subtotal');
                $pajak = $total * 0.1;
                $bersih = $total - $pajak;
                $data = [[
                    'Total Pendapatan (Rp)' => number_format($total, 0, ',', '.'),
                    'Pajak (10%) (Rp)' => number_format($pajak, 0, ',', '.'),
                    'Pendapatan Bersih (Rp)' => number_format($bersih, 0, ',', '.'),
                ]];
                $chart = [
                    'labels' => ['Pajak', 'Pendapatan Bersih'],
                    'values' => [$pajak, $bersih],
                    'title' => 'Distribusi Keuangan',
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
                $produk = Produk::orderBy('jumlah')->take(10)->get(['nama_produk', 'jumlah'])
                    ->map(fn($p) => ['Nama Produk' => $p->nama_produk, 'Jumlah Stok' => $p->jumlah]);
                $chart = [
                    'labels' => $produk->pluck('Nama Produk'),
                    'values' => $produk->pluck('Jumlah Stok'),
                    'title' => '10 Produk dengan Stok Terendah',
                ];
                $data = $produk;
                break;

            case 'pesanan':
                $data = Order::latest()->get(['id', 'user_id', 'subtotal', 'status'])
                    ->map(fn($o) => [
                        'ID Pesanan' => $o->id,
                        'ID Pengguna' => $o->user_id,
                        'Total Pembelian (Rp)' => number_format($o->subtotal, 0, ',', '.'),
                        'Status' => ucfirst($o->status),
                    ]);
                break;

            case 'ulasan':
                $data = Ulasan::with('user', 'produk')->latest()->get()
                    ->map(fn($u) => [
                        'Nama Pengguna' => $u->user->name ?? '-',
                        'Produk' => $u->produk->nama_produk ?? '-',
                        'Rating' => $u->rating,
                        'Komentar' => $u->komentar,
                        'Tanggal' => Carbon::parse($u->created_at)->translatedFormat('d F Y'),
                    ]);
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
