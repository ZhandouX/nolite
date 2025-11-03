<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }

    // EDIT
    public function update(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $ulasan->rating = $request->rating;
        $ulasan->komentar = $request->komentar;
        $ulasan->save();

        if($request->hasFile('fotos')){
            foreach($request->file('fotos') as $foto){
                $path = $foto->store('ulasan', 'public');
                $ulasan->fotos()->create(['foto' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    // SHOW
    public function show($orderId)
    {
        $order = Order::with([
            'items.produk.fotos',
            'items.ulasan' => function ($q) {
                $q->where('user_id', Auth::id());
            },
        ])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Tandai apakah sudah diulas (cek setiap order item apakah punya ulasan oleh user ini)
        $order->sudah_diulas = $order->items->contains(function ($item) {
            return !empty($item->ulasan);
        });

        return view('ulasan.show', compact('order'));
    }
}
