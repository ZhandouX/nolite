<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;

class MidtransController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * ✅ Update metode pembayaran dari Snap (AJAX dari frontend)
     */
    public function updatePaymentMethod(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->update([
            'payment_type' => $request->payment_type,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * ✅ Webhook Midtrans (WAJIB)
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        // 🔐 VALIDASI SIGNATURE
        $isValid = $this->midtrans->verifySignature(
            $data['order_id'],
            $data['status_code'],
            $data['gross_amount'],
            $data['signature_key']
        );

        if (!$isValid) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 🔥 AMBIL ORDER
        $order = Order::where('midtrans_order_id', $data['order_id'])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $data['transaction_status'];
        $paymentType = $data['payment_type'] ?? null;
        $vaNumbers = $data['va_numbers'] ?? null;

        // 🔥 MAP PAYMENT METHOD
        $paymentLabel = $this->midtrans->mapPaymentType($paymentType, $vaNumbers);

        $order->metode_pembayaran = $paymentLabel;
        $order->payment_type = $paymentType;

        // 🔥 UPDATE STATUS
        switch ($transactionStatus) {
            case 'capture':
            case 'settlement':
                $order->status = 'dibayar';
                break;

            case 'pending':
                $order->status = 'menunggu';
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->status = 'dibatalkan';
                break;
        }

        $order->save();

        return response()->json(['message' => 'OK'], 200);
    }
}