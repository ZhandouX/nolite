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

        // VALIDASI SIGNATURE
        $isValid = $this->midtrans->verifySignature(
            $data['order_id'],
            $data['status_code'],
            $data['gross_amount'],
            $data['signature_key']
        );

        if (!$isValid) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 403);
        }

        // CARI ORDER
        $order = Order::where(
            'midtrans_order_id',
            $data['order_id']
        )->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        $transactionStatus = $data['transaction_status'];
        $paymentType = $data['payment_type'] ?? null;
        $vaNumbers = $data['va_numbers'] ?? null;

        // LABEL PEMBAYARAN
        $paymentLabel = $this->midtrans
            ->mapPaymentType($paymentType, $vaNumbers);

        // SIMPAN METODE
        $order->payment_type = $paymentType;
        $order->metode_pembayaran = $paymentLabel;

        // STATUS PEMBAYARAN
        switch ($transactionStatus) {

            case 'capture':
            case 'settlement':

                $order->payment_status = 'paid';

                // order mulai diproses admin
                if ($order->status === 'menunggu') {
                    $order->status = 'diproses';
                }

                break;

            case 'pending':

                $order->payment_status = 'pending';

                break;

            case 'deny':

                $order->payment_status = 'failed';

                break;

            case 'expire':

                $order->payment_status = 'expired';

                break;

            case 'cancel':

                $order->payment_status = 'cancel';

                break;
        }

        $order->save();

        return response()->json([
            'message' => 'OK'
        ], 200);
    }
}