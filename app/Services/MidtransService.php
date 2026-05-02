<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * 🔥 Generate Snap Token (FINAL FIX)
     */
    public function createSnapToken(Order $order): array
    {
        // ✅ WAJIB: ambil dari DB, JANGAN generate ulang
        $orderId = $order->midtrans_order_id;

        if (!$orderId) {
            throw new \Exception('midtrans_order_id belum dibuat di order');
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $order->subtotal,
            ],
            'customer_details' => [
                'first_name' => $order->nama_penerima,
                'email' => $order->email,
                'phone' => $order->no_hp,
                'billing_address' => [
                    'address' => $order->alamat_detail,
                    'city' => $order->kota,
                    'postal_code' => '00000',
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $this->buildItemDetails($order),
        ];

        $snapToken = Snap::getSnapToken($params);

        // ✅ Simpan ke DB
        $order->update([
            'snap_token' => $snapToken,
        ]);

        return [
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ];
    }

    /**
     * 🔥 Build item details (ANTI ERROR)
     */
    private function buildItemDetails(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {

            // ✅ Hindari pembagian float error
            $price = (int) round($item->subtotal / max($item->jumlah, 1));

            $items[] = [
                'id' => (string) $item->produk_id,
                'price' => $price,
                'quantity' => (int) $item->jumlah,
                'name' => substr(
                    $item->nama_produk . ' (' . ($item->warna ?? '-') . '/' . ($item->ukuran ?? '-') . ')',
                    0,
                    50
                ),
            ];
        }

        // ✅ Fallback kalau kosong (WAJIB biar Midtrans tidak error)
        if (empty($items)) {
            $items[] = [
                'id' => 'ORDER',
                'price' => (int) $order->subtotal,
                'quantity' => 1,
                'name' => 'Order Payment',
            ];
        }

        return $items;
    }

    /**
     * 🔐 Verifikasi signature webhook
     */
    public function verifySignature(
        string $orderId,
        string $statusCode,
        string $grossAmount,
        string $signatureKey
    ): bool {
        $serverKey = config('midtrans.server_key');

        $hash = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return $hash === $signatureKey;
    }

    /**
     * 🔥 Mapping payment type (lebih akurat)
     */
    public function mapPaymentType(
        string $paymentType,
        ?array $vaNumbers = null
    ): string {
        return match ($paymentType) {
            'credit_card' => 'Kartu Kredit',
            'gopay' => 'GoPay',
            'qris' => 'QRIS',
            'bank_transfer' => $this->mapBankTransfer($vaNumbers),
            'echannel' => 'Virtual Account - Mandiri',
            'bca_klikpay' => 'BCA KlikPay',
            'cimb_clicks' => 'CIMB Clicks',
            'danamon_online' => 'Danamon Online',
            'shopeepay' => 'ShopeePay',
            'akulaku' => 'Akulaku',
            default => ucfirst(str_replace('_', ' ', $paymentType)),
        };
    }

    /**
     * 🔥 Mapping VA Bank
     */
    private function mapBankTransfer(?array $vaNumbers): string
    {
        if (empty($vaNumbers)) {
            return 'Virtual Account';
        }

        $bank = strtoupper($vaNumbers[0]['bank'] ?? '');

        return "Virtual Account - {$bank}";
    }
}