@extends('layouts.user_app')

@section('title', 'Checkout')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('content')
    <div class="pt-24 max-w-6xl mx-auto px-3 py-8 grid md:grid-cols-3 gap-6">

        {{-- FORM: LEFT --}}
        <div class="md:col-span-2 bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-base font-semibold mb-3">Detail Alamat</h2>

            <form action="{{ route('customer.checkout.proses') }}" method="POST" class="space-y-4 text-sm">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label class="block text-gray-700 font-medium">Alamat Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300"
                        placeholder="kamu@email.com">
                </div>

                {{-- NAMA LENGKAP --}}
                <div>
                    <label class="block text-gray-700 font-medium">Nama Lengkap Penerima</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300"
                        required>
                </div>

                {{-- NOMOR HP --}}
                <div>
                    <label class="block text-gray-700 font-medium">Nomor HP Penerima</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300"
                        required>
                </div>

                {{-- PROVINSI --}}
                <div>
                    <label class="block text-gray-700 font-medium">Provinsi</label>
                    <select name="negara"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-gray-300"
                        required>
                        <option value="Aceh">Aceh</option>
                        <option value="Sumatera Utara">Sumatera Utara</option>
                        <option value="Sumatera Barat">Sumatera Barat</option>
                        <option value="Riau">Riau</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Jambi">Jambi</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Bangka Belitung">Kepulauan Bangka Belitung</option>
                        <option value="Bengkulu">Bengkulu</option>
                        <option value="Lampung">Lampung</option>

                        <option value="DKI Jakarta" selected>DKI Jakarta</option>
                        <option value="Banten">Banten</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="DI Yogyakarta">DI Yogyakarta</option>
                        <option value="Jawa Timur">Jawa Timur</option>

                        <option value="Bali">Bali</option>
                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>

                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kalimantan Utara">Kalimantan Utara</option>

                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                        <option value="Gorontalo">Gorontalo</option>
                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>

                        <option value="Maluku">Maluku</option>
                        <option value="Maluku Utara">Maluku Utara</option>

                        <option value="Papua">Papua</option>
                        <option value="Papua Barat">Papua Barat</option>
                        <option value="Papua Selatan">Papua Selatan</option>
                        <option value="Papua Tengah">Papua Tengah</option>
                        <option value="Papua Pegunungan">Papua Pegunungan</option>
                        <option value="Papua Barat Daya">Papua Barat Daya</option>
                    </select>
                </div>

                {{-- KOTA / KECAMATAN --}}
                <div>
                    <label class="block text-gray-700 font-medium">Kecamatan, Kota</label>
                    <input type="text" name="kota" value="{{ old('kota') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300"
                        required>
                </div>

                {{-- DETAIL ALAMAT --}}
                <div>
                    <label class="block text-gray-700 font-medium">Detail Alamat</label>
                    <textarea name="alamat_detail" rows="2"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-gray-300 text-sm"
                        placeholder="Nama jalan, nomor rumah, patokan, dll" required>{{ old('alamat_detail') }}</textarea>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="mt-5 relative">
                    <h3 class="text-sm font-semibold mb-2">Metode Pembayaran</h3>

                    <input type="hidden" name="metode_pembayaran" id="metode-pembayaran-input"
                        value="{{ old('metode_pembayaran') }}">
                    <button type="button" id="payment-toggle"
                        class="w-full flex items-center justify-between border border-gray-300 rounded-md px-4 py-2 text-sm bg-white">
                        <span id="selected-method">{{ old('metode_pembayaran', 'Pilih Metode Pembayaran') }}</span>
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="payment-options"
                        class="absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-md shadow-md hidden z-10">
                        <ul class="text-sm divide-y divide-gray-100">
                            <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer text-gray-700 hover:text-white"
                                onclick="selectMethod('QRIS')">QRIS</li>
                            <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer text-gray-700 hover:text-white"
                                onclick="selectMethod('Virtual Account')">Virtual Account</li>
                            <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer text-gray-700 hover:text-white"
                                onclick="selectMethod('E-Wallet')">E-Wallet (Gopay, Dana, dll)</li>
                            <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer text-gray-700 hover:text-white"
                                onclick="selectMethod('Kartu Kredit')">Kartu Kredit</li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

        {{-- FORM: RIGHT --}}
        <div class="bg-white p-5 rounded-lg shadow-md h-fit text-sm">
            <h2 class="text-base font-semibold mb-3">Pesanan Kamu</h2>

            <div id="checkout-items-container">
                @php $displayLimit = 2; @endphp
                @forelse($checkoutItems as $index => $item)
                    @php
                        $produk = \App\Models\Produk::find($item['produk_id']);
                        $foto = $produk->fotos->first()->foto ?? null;
                        $hiddenClass = $index >= $displayLimit ? 'hidden extra-item' : '';
                    @endphp

                    <div
                        class="flex items-start justify-between mb-3 p-2 border rounded-md bg-white transition-all duration-300 {{ $hiddenClass }}">
                        <div class="w-16 h-16 rounded overflow-hidden bg-gray-100 mr-3 flex items-center justify-center">
                            @if($foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $item['nama_produk'] }}"
                                    class="object-cover w-full h-full">
                            @else
                                <span class="text-gray-400 text-xs italic">No Foto</span>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm font-medium text-black">{{ $item['nama_produk'] }}</p>
                            <p class="text-xs text-gray-500">Warna: {{ $item['warna'] }} • Ukuran: {{ $item['ukuran'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Jumlah: {{ $item['jumlah'] }}</p>
                        </div>

                        <div class="text-sm font-semibold text-gray-800 flex-shrink-0">
                            IDR {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Tidak ada produk untuk checkout.</p>
                @endforelse
            </div>

            @if(count($checkoutItems) > $displayLimit)
                <button id="toggle-items-btn"
                    class="w-full mt-2 px-4 py-2 rounded-full border text-gray-700 bg-gray-50 hover:bg-gray-200 transition-all text-xs font-medium">
                    Lihat Lebih Banyak ▼
                </button>
            @endif

            <hr class="my-3">

            <div class="flex justify-between font-semibold text-base mt-2 border-t pt-2">
                <span>Total Bayar</span>
                <span>
                    IDR {{ number_format(collect($checkoutItems)->sum(fn($i) => $i['subtotal']), 0, ',', '.') }}
                </span>
            </div>

            <p class="text-xs text-center text-gray-400 mt-2">
                🔒 Pembayaran Aman | Transaksi kamu dienkripsi.
            </p>

            <button type="submit"
                class="w-full bg-gray-700 hover:bg-gray-500 text-white py-2.5 rounded-md text-sm font-semibold mt-4">
                Bayar Sekarang
            </button>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById("payment-toggle");
        const dropdown = document.getElementById("payment-options");
        const selectedMethod = document.getElementById("selected-method");
        const metodeInput = document.getElementById("metode-pembayaran-input");

        toggleBtn.addEventListener("click", () => dropdown.classList.toggle("hidden"));
        function selectMethod(method) {
            selectedMethod.textContent = method;
            metodeInput.value = method;
            dropdown.classList.add("hidden");
        }
        window.addEventListener("click", (e) => {
            if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add("hidden");
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-items-btn');
            if (!toggleBtn) return;

            toggleBtn.addEventListener('click', function () {
                const extras = document.querySelectorAll('.extra-item');
                const isHidden = extras[0].classList.contains('hidden');
                extras.forEach(el => el.classList.toggle('hidden'));
                toggleBtn.textContent = isHidden ? 'Tutup ▲' : 'Lihat Lebih Banyak ▼';
            });
        });
    </script>
@endsection