<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.produk.fotos')->orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ambil relasi produk dan foto
        $order->load('items.produk.fotos');

        // Tambahkan harga_diskon untuk setiap item berdasarkan data produk
        foreach ($order->items as $item) {
            $produk = $item->produk;

            if ($produk && !empty($produk->diskon) && $produk->diskon > 0) {
                $item->harga_diskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                $item->diskon = $produk->diskon; // simpan juga nilai diskon untuk tampilan
            } else {
                $item->harga_diskon = $produk->harga ?? 0;
                $item->diskon = 0;
            }
        }

        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,dikirim,selesai',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }
}
