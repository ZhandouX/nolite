@extends('layouts.user_app')

@section('title', 'Checkout Produk')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8 pt-14 md:pt-9 grid md:grid-cols-3 gap-8">

        {{-- FORM DETAIL ALAMAT --}}
        <form id="checkout-form" action="{{ route('customer.checkout.dashboard.proses') }}" method="POST"
            class="md:col-span-2 space-y-3">
            @csrf

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- DETAIL ALAMAT --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                <h2 class="text-base font-semibold mb-3 text-gray-800">Detail Alamat</h2>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}"
                        class="w-full mt-1 bg-white border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-1 focus:ring-gray-400"
                        placeholder="kamu@email.com">
                    <p class="text-xs text-gray-400 mt-1">Kami akan mengirim detail pesanan ke email kamu</p>
                </div>

                {{-- NAMA LENGKAP --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700">Nama Lengkap Penerima</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}"
                        class="w-full mt-1 bg-white border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-1 focus:ring-gray-400"
                        required>
                </div>

                {{-- NOMOR HP --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700">Nomor HP Penerima</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full mt-1 bg-white border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-1 focus:ring-gray-400"
                        required>
                </div>

                {{-- PROVINSI --}}
                <div class="relative">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Provinsi</label>
                    <select id="provinsi" name="provinsi" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-gray-400 focus:border-gray-400 bg-white">
                        <option value=""> -> Pilih Provinsi <- </option>
                                @foreach($provinsiList as $prov)
                                    <option value="{{ $prov }}" {{ old('provinsi') == $prov ? 'selected' : '' }}>
                                        {{ $prov }}
                                    </option>
                                @endforeach
                    </select>
                </div>

                {{-- KOTA --}}
                <div class="relative mt-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kota</label>
                    <select id="kota" name="kota" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-gray-400 focus:border-gray-400 bg-white">
                        <option value=""> Pilih Provinsi Terlebih Dahulu </option>
                        {{-- Jika form reload karena validasi gagal --}}
                        @if(old('provinsi'))
                            @php
                                $lokasi = new \App\Http\Controllers\Customer\LokasiController();
                                $kotaList = $lokasi->provinsiKota[old('provinsi')] ?? [];
                            @endphp
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota }}" {{ old('kota') == $kota ? 'selected' : '' }}>
                                    {{ $kota }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- DETAIL ALAMAT --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700">Detail Alamat</label>
                    <textarea name="alamat_detail" rows="2"
                        class="w-full mt-1 bg-white border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-1 focus:ring-gray-400"
                        placeholder="Nama jalan, nomor rumah, patokan, dll" required>{{ old('alamat_detail') }}</textarea>
                </div>

                {{-- Metode pembayaran diisi otomatis dari Midtrans --}}
                <input type="hidden" name="metode_pembayaran" value="pending">
                <div class="mt-5 bg-blue-50 border border-blue-200 rounded-md px-4 py-3 text-sm text-blue-700">
                    💡 Metode pembayaran akan dipilih saat proses pembayaran berlangsung.
                </div>
            </div> {{-- END DETAIL ALAMAT --}}
        </form>

        {{-- RINGKASAN PESANAN DI KANAN --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
            <h2 class="text-base font-semibold mb-3 text-gray-800">Pesanan Kamu</h2>

            @php
                $produk = \App\Models\Produk::find($checkoutItem['produk_id']);
                $foto = $produk->fotos->first()->foto ?? null;
            @endphp

            <div class="flex items-start justify-between mb-3 p-3 border rounded-md bg-gray-50">
                <div class="w-20 h-20 rounded-md overflow-hidden bg-gray-100 mr-3 flex items-center justify-center">
                    @if($foto)
                        <img src="{{ asset('storage/' . $foto) }}" alt="{{ $checkoutItem['nama_produk'] }}"
                            class="object-cover w-full h-full">
                    @else
                        <span class="text-gray-400 text-xs italic">Belum ada foto</span>
                    @endif
                </div>

                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $checkoutItem['nama_produk'] }}</p>
                    <p class="text-xs text-gray-500">Warna: {{ $checkoutItem['warna'] }} • Ukuran:
                        {{ $checkoutItem['ukuran'] }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Jumlah: {{ $checkoutItem['jumlah'] }}</p>
                </div>

                <div class="text-sm font-semibold text-gray-800 flex-shrink-0">
                    Rp{{ number_format($checkoutItem['subtotal'], 0, ',', '.') }}
                </div>
            </div>

            <hr class="my-2">

            <div class="flex justify-between font-semibold text-sm mt-3 border-t pt-2">
                <span>Total Bayar</span>
                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <p class="text-xs text-center text-gray-400 mt-2">
                🔒 Pembayaran Aman | Transaksi kamu dienkripsi.
            </p>

            <button type="button" id="pay-button" form="checkout-form"
                class="w-full bg-gray-700 hover:bg-gray-500 text-white font-semibold py-2.5 rounded-md transition mt-5 text-sm">
                Bayar Sekarang
            </button>
        </div>

    </div>


@endsection

@push('script')
    {{-- CHECKOUT FORM --}}
    <script>
        window.CheckoutForm = {
            routes: {
                kota: "{{ url('/get-kota') }}",
            }
        };
    </script>
    <script src="/assets/js/user/transactions/_checkout-form.js"></script>

    {{-- MIDTRANS SNAP --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {

            let button = this;
            button.disabled = true;
            button.innerText = "Memproses...";

            let form = document.getElementById('checkout-form');
            let formData = new FormData(form);

            // 🔥 FIX MIXED CONTENT
            let url = form.action.replace("http://", "https://");

            fetch(url, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(async res => {
                    if (!res.ok) {
                        let text = await res.text();
                        console.error("SERVER ERROR:", text);
                        throw new Error("Server error " + res.status);
                    }
                    return res.json();
                })
                .then(data => {

                    console.log("RESPONSE:", data);

                    if (!data.snap_token) {
                        alert(data.error || "Gagal mendapatkan Snap Token");
                        button.disabled = false;
                        button.innerText = "Bayar Sekarang";
                        return;
                    }

                    snap.pay(data.snap_token, {

                        onSuccess: function (result) {
                            updatePayment(result, data.order_id);
                            alert("Pembayaran berhasil!");
                            window.location.href = `/checkout/success/${data.order_id}`;
                        },

                        onPending: function (result) {
                            updatePayment(result, data.order_id);
                            alert("Mohon selesaikan pembayaran Anda!");
                            button.disabled = false;
                            button.innerText = "Bayar Sekarang";
                        },

                        onError: function (result) {
                            console.error("MIDTRANS ERROR:", result);
                            alert("Pembayaran gagal!");
                            button.disabled = false;
                            button.innerText = "Bayar Sekarang";
                        },

                        onClose: function () {
                            alert("Mohon selesaikan pembayaran Anda!");
                            button.disabled = false;
                            button.innerText = "Bayar Sekarang";
                        }
                    });

                })
                .catch(err => {
                    console.error("FETCH ERROR:", err);
                    alert("Terjadi kesalahan! Cek console (F12)");
                    button.disabled = false;
                    button.innerText = "Bayar Sekarang";
                });

        });

        // 🔥 UPDATE PAYMENT
        function updatePayment(result, orderId) {

            let url = `/checkout/payment/${orderId}/update-method`.replace("http://", "https://");

            fetch(url, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    payment_type: result.payment_type,
                    va_numbers: result.va_numbers || null
                })
            })
                .then(res => res.json())
                .then(data => console.log("Update payment:", data))
                .catch(err => console.error("Update error:", err));
        }
    </script>
@endpush