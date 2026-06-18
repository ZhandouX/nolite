<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * DETAIL ORDER
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with([
                'items.produk.fotos',
                'ulasan'
            ])
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * CANCEL ORDER (KEMBALIKAN STOK)
     */
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('items.produk')
            ->firstOrFail();

        if ($order->status !== 'menunggu') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses atau dibayar.');
        }

        DB::transaction(function () use ($order) {

            // 🔥 KEMBALIKAN STOK
            foreach ($order->items as $item) {
                if ($item->produk) {
                    $item->produk->jumlah += $item->jumlah;
                    $item->produk->save();
                }
            }

            // 🔴 update status
            $order->update([
                'status' => 'dibatalkan'
            ]);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    }

    /**
     * DELETE ORDER (SOFT DELETE)
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $order->delete(); // soft delete

        return back()->with('success', 'Pesanan berhasil dihapus dari tampilan.');
    }

    /**
     * DOWNLOAD INVOICE PDF
     */
    public function downloadInvoice($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.invoice_pdf', compact('order'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
