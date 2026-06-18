<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with([
            'items.produk.fotos', // produk pesanan
            'ulasan'              // ⬅ WAJIB supaya ulasan muncul
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('customer.invoice_pdf', compact('order'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
