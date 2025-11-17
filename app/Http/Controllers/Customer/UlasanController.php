<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\UlasanFoto;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'produk_id' => 'required|exists:produks,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Cegah duplikasi ulasan
        $existing = Ulasan::where('order_item_id', $request->order_item_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Anda sudah membuat ulasan untuk produk ini.'], 422);
        }

        $ulasan = Ulasan::create([
            'user_id' => Auth::id(),
            'produk_id' => $request->produk_id,
            'order_id' => $request->order_id,
            'order_item_id' => $request->order_item_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Simpan foto
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $file->store('ulasan', 'public');
                $ulasan->fotos()->create(['foto' => $path]);
            }
        }

        return response()->json(['success' => 'Ulasan berhasil dikirim.']);
    }

    public function show($ulasanId)
    {
        $ulasan = Ulasan::with(['produk.fotos', 'fotos', 'user'])
            ->where('id', $ulasanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($ulasan);
    }

    public function edit($ulasanId)
    {
        $ulasan = Ulasan::with(['produk.fotos', 'fotos'])
            ->where('id', $ulasanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($ulasan);
    }

    public function update(Request $request, Ulasan $ulasan)
    {
        // Pastikan ulasan milik user yang login
        if ($ulasan->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $ulasan->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Simpan foto baru
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $file->store('ulasan', 'public');
                $ulasan->fotos()->create(['foto' => $path]);
            }
        }

        return response()->json(['success' => 'Ulasan berhasil diperbarui!']);
    }

    public function hapusFoto($fotoId)
    {
        $foto = UlasanFoto::findOrFail($fotoId);
        $ulasan = $foto->ulasan;

        // Pastikan foto milik ulasan user yang login
        if ($ulasan->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($foto->foto);
        $foto->delete();

        return response()->json(['success' => 'Foto berhasil dihapus']);
    }
}