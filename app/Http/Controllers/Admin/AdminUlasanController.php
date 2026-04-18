<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminUlasanController extends Controller
{
    /**
     * Halaman daftar ulasan + search + filter + pagination
     */
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'produk', 'fotos'])->latest();

        // 🔍 SEARCH (user atau produk)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })->orWhereHas('produk', function ($p) use ($search) {
                    $p->where('nama_produk', 'like', "%{$search}%");
                });
            });
        }

        // ⭐ FILTER RATING
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // 💬 FILTER STATUS BALASAN
        if ($request->filled('reply')) {
            if ($request->reply === 'belum') {
                $query->whereNull('admin_reply');
            } elseif ($request->reply === 'sudah') {
                $query->whereNotNull('admin_reply');
            }
        }

        // 📄 PAGINATION
        $ulasans = $query->paginate(10)->withQueryString();

        // jumlah belum dibalas (untuk badge)
        $jumlahBelumDibalas = Ulasan::whereNull('admin_reply')->count();

        return view('admin.ulasan.index', compact('ulasans', 'jumlahBelumDibalas'));
    }

    /**
     * Halaman detail ulasan
     */
    public function show($id)
    {
        $ulasan = Ulasan::with(['user', 'produk', 'fotos'])->findOrFail($id);

        return view('admin.ulasan.show', compact('ulasan'));
    }

    /**
     * Admin membalas ulasan
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|min:3'
        ]);

        $ulasan = Ulasan::findOrFail($id);

        $ulasan->admin_reply = $request->admin_reply;

        // cek apakah tabel memiliki kolom 'status'
        if (Schema::hasColumn('ulasans', 'status')) {
            $ulasan->status = 'dibalas';
        }

        $ulasan->save();

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
