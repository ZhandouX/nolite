<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminTransaksiController extends Controller
{
    /**
     * Halaman monitor transaksi
     */
    public function index(Request $request)
    {
        $query = Order::with([
            'user',
            'items'
        ])->latest();

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('midtrans_order_id', 'like', "%{$search}%")
                    ->orWhere('nama_penerima', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

            });
        }

        $orders = $query->paginate(10);

        return view(
            'admin.transaksi.index',
            compact('orders')
        );
    }
}