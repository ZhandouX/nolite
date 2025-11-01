<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['items.produk.fotos'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
