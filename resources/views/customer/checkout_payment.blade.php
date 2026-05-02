@extends('layouts.user_app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center">

        <div class="mb-6">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Selesaikan Pembayaran</h2>
            <p class="text-sm text-gray-500 mt-1">
                Order #{{ $order->id }} •
                <span class="font-semibold text-gray-700">
                    Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                </span>
            </p>
        </div>

        {{-- STATUS --}}
        <div id="payment-status"
            class="hidden mb-4 bg-green-50 border border-green-200 rounded-md px-4 py-3 text-sm text-green-700">
            ✅ Metode pembayaran: <strong id="payment-method-label">-</strong>
        </div>

        <button id="pay-button"
            class="w-full bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 rounded-xl text-sm">
            💳 Bayar Sekarang
        </button>

        <p class="text-xs text-gray-400 mt-4">🔒 Pembayaran aman menggunakan Midtrans</p>
    </div>
</div>

{{-- CSRF META (WAJIB) --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- MIDTRANS --}}
@if(config('midtrans.is_production'))
<script src="https://app.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {

    const snapToken = "{{ $order->snap_token }}";
    const successUrl = "{{ route('customer.order.success', ['id' => $order->id]) }}";
    const failUrl = "{{ route('customer.checkout.payment', ['id' => $order->id]) }}";
    const updateRoute = "{{ route('customer.checkout.update-payment-method', ['id' => $order->id]) }}";

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById('pay-button').addEventListener('click', function () {

        snap.pay(snapToken, {

            onSuccess: function (result) {
                updatePaymentMethod(result);
                window.location.href = successUrl;
            },

            onPending: function (result) {
                updatePaymentMethod(result);
                showPaymentStatus(result.payment_type);
            },

            onError: function (result) {
                alert('Pembayaran gagal: ' + result.status_message);
                window.location.href = failUrl;
            },

            onClose: function () {
                console.log('User menutup popup.');
            }

        });

    });

    function updatePaymentMethod(result) {

        fetch(updateRoute, {
            method: 'POST',
            credentials: 'same-origin', // 🔥 WAJIB untuk session
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                payment_type: result.payment_type,
                va_numbers: result.va_numbers ?? null,
                status_code: result.status_code ?? null,
            })
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error("HTTP " + res.status + " → " + text);
            }
            return res.json();
        })
        .then(data => {
            console.log('✅ Payment updated:', data);
        })
        .catch(err => {
            console.error('❌ Update error:', err);
        });

    }

    function showPaymentStatus(paymentType) {
        const labels = {
            credit_card: 'Kartu Kredit',
            qris: 'QRIS',
            gopay: 'QRIS (GoPay)',
            bank_transfer: 'Virtual Account',
            echannel: 'VA Mandiri',
            shopeepay: 'ShopeePay'
        };

        const label = labels[paymentType] || paymentType;

        document.getElementById('payment-method-label').textContent = label;
        document.getElementById('payment-status').classList.remove('hidden');
    }

});
</script>
@endsection