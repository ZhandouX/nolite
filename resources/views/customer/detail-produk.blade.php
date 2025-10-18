@extends('layouts.user_app')

@section('title', 'Detail Produk')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/user/produk-detail.css') }}">

    @section('content')
        <main class="product-detail container mx-auto py-12 mt-10 grid md:grid-cols-2 gap-10">

            {{-- PRODUCT GALLERY --}}
            <div class="product-gallery">
                {{-- LARGE IMAGE --}}
                <div class="main-image mb-4 relative">
                    @if($produk->fotos->isNotEmpty())
                        <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" alt="{{ $produk->nama }}" id="mainImage"
                            class="w-full h-96 object-contain rounded-2xl shadow-md transition-all duration-300 cursor-pointer"
                            onclick="openModal('modalImage')" />
                    @else
                        <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image" id="mainImage"
                            class="w-full h-96 object-contain rounded-2xl shadow-md transition-all duration-300 cursor-pointer"
                            onclick="openModal('modalImage')" />
                    @endif
                </div>

                {{-- THUMBNAIL LIST --}}
                <div class="thumbnail-list flex gap-3 overflow-x-auto pb-2">
                    @if($produk->fotos->isNotEmpty())
                        @foreach($produk->fotos as $key => $foto)
                            <img src="{{ asset('storage/' . $foto->foto) }}" alt="thumb{{ $key + 1 }}"
                                class="thumb w-24 h-24 object-contain rounded-lg cursor-pointer border-2 
                                                                                                                                                                                                                                {{ $key === 0 ? 'border-red-800' : 'border-gray-200' }} 
                                                                                                                                                                                                                                hover:border-red-600 transition-all duration-300"
                                onclick="setMainImage(this.src)" />
                        @endforeach
                    @else
                        <span class="text-gray-400 italic">Tidak ada foto tambahan</span>
                    @endif
                </div>
            </div>

            {{-- MODAL IMAGE --}}
            <div id="modalImage" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50 p-4">
                <div class="relative w-full max-w-4xl bg-white rounded-2xl overflow-hidden">
                    <button onclick="closeModal('modalImage')"
                        class="absolute top-2 right-2 text-white text-3xl z-20">&times;</button>

                    {{-- LARGE IMAGE --}}
                    <div class="relative">
                        <img id="modalImgContent" src="" alt="Full Image"
                            class="w-full max-h-[600px] object-contain transition-all duration-300" />

                        {{-- PREV --}}
                        <button id="prevImage"
                            class="absolute top-1/2 left-2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            &#10094;
                        </button>

                        {{-- NEXT --}}
                        <button id="nextImage"
                            class="absolute top-1/2 right-2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            &#10095;
                        </button>
                    </div>

                    {{-- THUMBNAIL LIST --}}
                    <div class="flex justify-center gap-2 p-4 overflow-x-auto">
                        @foreach($produk->fotos as $key => $foto)
                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                class="modal-thumb w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 hover:border-blue-600 transition-all"
                                data-index="{{ $key }}">
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PRODUCT INFORMATION --}}
            <div class="product-info">
                <span class="badge bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Tersedia</span>
                <h2 class="text-3xl font-bold text-gray-800 mt-3">{{ $produk->nama_produk }}</h2>

                {{-- PRICE --}}
                <p class="price mt-3">
                    <span class="text-red-800 text-2xl font-bold">
                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                    </span>
                </p>

                {{-- FORM TAMBAH KE KERANJANG LANGSUNG --}}
                <div class="add-to-cart-section mt-8 p-6 bg-gray-100 rounded-2xl shadow-md space-y-6">

                    {{-- COLOR SELECT --}}
                    @if(!empty($produk->warna))
                        @php
                            $warnaList = is_array($produk->warna)
                                ? $produk->warna
                                : json_decode($produk->warna, true);

                            $mapWarna = [
                                'merah' => '#ef4444',
                                'biru' => '#3b82f6',
                                'hijau' => '#22c55e',
                                'kuning' => '#eab308',
                                'hitam' => '#000000',
                                'putih' => '#ffffff',
                                'abu-abu' => '#9ca3af',
                                'ungu' => '#8b5cf6',
                                'oranye' => '#f97316',
                                'pink' => '#ec4899',
                            ];
                        @endphp

                        <div>
                            <p class="font-semibold mb-2 text-gray-800">Pilih Warna:</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach($warnaList as $w)
                                    @php
                                        $hex = $mapWarna[strtolower(trim($w))] ?? '#d1d5db';
                                    @endphp
                                    <button type="button"
                                        class="color-btn px-4 py-2 rounded-xl border border-gray-300 text-sm font-medium transition"
                                        data-color="{{ $w }}" data-item="{{ $produk->id }}"
                                        style="--color-hex: {{ $hex }}; background-color: white; color: #333;"
                                        onmouseover="this.style.backgroundColor=this.style.getPropertyValue('--color-hex'); this.style.color=(this.style.getPropertyValue('--color-hex')=='#ffffff')?'#000':'#fff';"
                                        onmouseout="if(!this.classList.contains('active')){this.style.backgroundColor='white'; this.style.color='#333';}">
                                        {{ ucfirst($w) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="warna" id="selectedColor-{{ $produk->id }}">
                        </div>
                    @endif

                    {{-- SIZE SELECT --}}
                    @if(!empty($produk->ukuran))
                        <div>
                            <p class="font-semibold mb-2 text-gray-800">Pilih Ukuran:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($produk->ukuran as $u)
                                    <button type="button"
                                        class="size-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition"
                                        data-size="{{ $u }}" data-item="{{ $produk->id }}">
                                        {{ $u }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="ukuran" id="selectedSize-{{ $produk->id }}">
                        </div>
                    @endif

                    {{-- QTY --}}
                    <div class="flex items-center gap-4 border-t border-gray-200 pt-4">
                        <button type="button" onclick="decrementQty({{ $produk->id }})"
                            class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 text-gray-400 bg-white hover:bg-gray-50 active:scale-95 transition-all duration-200 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>

                        <input type="number" id="qty-{{ $produk->id }}" min="1" value="1"
                            class="w-10 text-center text-base font-semibold text-gray-900 border-none bg-transparent" readonly>

                        <button type="button" onclick="incrementQty({{ $produk->id }})"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-300 text-white hover:bg-gray-400 active:scale-95 transition-all duration-200 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <button type="button" onclick="addToCart('{{ $produk->id }}')"
                        class="w-full bg-gray-900 hover:bg-gray-600 text-white font-semibold py-3 rounded-xl transition-all duration-200">
                        Tambahkan ke Keranjang
                    </button>
                </div>

                {{-- PRODUCT DESKRIPTION --}}
                <div class="product-desc mt-10">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $produk->deskripsi ?? 'Belum ada deskripsi produk.' }}
                    </p>
                </div>

                {{-- SENDING --}}
                <div class="delivery mt-10">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Pengiriman</h3>
                    <p><strong>Area:</strong> Indonesia</p>
                </div>
            </div>

        </main>

    @endsection

    @push('script')
        {{-- JS: IMAGES --}}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const mainImage = document.getElementById("mainImage");
                const thumbs = document.querySelectorAll(".thumb");
                const modal = document.getElementById("modalImage");
                const modalImg = document.getElementById("modalImgContent");
                const closeBtn = document.querySelector("#modalImage button");
                const prevBtn = document.getElementById("prevImage");
                const nextBtn = document.getElementById("nextImage");
                const modalThumbs = document.querySelectorAll(".modal-thumb");
                const navbar = document.querySelector('header');

                let currentIndex = 0;

                thumbs.forEach((thumb, index) => {
                    thumb.addEventListener("click", () => {
                        thumbs.forEach(t => t.classList.remove("border-blue-600", "scale-105"));
                        thumb.classList.add("border-blue-600", "scale-105");
                        mainImage.src = thumb.src;
                    });
                });

                mainImage.addEventListener("click", () => {
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                    modalImg.src = mainImage.src;

                    if (navbar) navbar.style.display = "none";

                    thumbs.forEach((t, i) => {
                        if (t.src === mainImage.src) currentIndex = i;
                    });
                });

                closeBtn.addEventListener("click", () => {
                    modal.classList.add("hidden");
                    modal.classList.remove("flex");

                    if (navbar) navbar.style.display = "";
                });

                modal.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        modal.classList.add("hidden");
                        modal.classList.remove("flex");
                        if (navbar) navbar.style.display = "";
                    }
                });

                // PREVIOUS
                prevBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    currentIndex = (currentIndex === 0) ? modalThumbs.length - 1 : currentIndex - 1;
                    modalImg.src = modalThumbs[currentIndex].src;
                });

                // NEXT
                nextBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    currentIndex = (currentIndex === modalThumbs.length - 1) ? 0 : currentIndex + 1;
                    modalImg.src = modalThumbs[currentIndex].src;
                });

                // THUMBNAIL
                modalThumbs.forEach((thumb, index) => {
                    thumb.addEventListener("click", () => {
                        currentIndex = index;
                        modalImg.src = thumb.src;
                    });
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function incrementQty(id) {
                const qtyInput = document.getElementById(`qty-${id}`);
                qtyInput.value = parseInt(qtyInput.value) + 1;
            }

            function decrementQty(id) {
                const qtyInput = document.getElementById(`qty-${id}`);
                if (parseInt(qtyInput.value) > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                }
            }

            function addToCart(id) {
                const warna = document.querySelector(`#selectedColor-${id}`)?.value;
                const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
                const qty = document.querySelector(`#qty-${id}`)?.value || 1;

                if (!warna || !ukuran) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Silakan pilih warna dan ukuran terlebih dahulu!',
                        confirmButtonColor: '#d33',
                    });
                    return;
                }

                fetch("{{ route('keranjang.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        produk_id: id,
                        warna: warna,
                        ukuran: ukuran,
                        jumlah: qty
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message ?? 'Produk berhasil ditambahkan ke keranjang.',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-end',
                        });
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Gagal menambahkan produk ke keranjang.',
                            confirmButtonColor: '#d33',
                        });
                    });
            }

            document.addEventListener('click', e => {
                if (e.target.closest('.color-btn')) {
                    const btn = e.target.closest('.color-btn');
                    const itemId = btn.dataset.item;

                    document.querySelectorAll(`[data-item="${itemId}"].color-btn`).forEach(b => {
                        b.classList.remove('active', 'ring', 'ring-blue-400');
                        b.style.backgroundColor = 'white';
                        b.style.color = '#333';
                    });

                    btn.classList.add('active', 'ring', 'ring-blue-400');
                    const hex = getComputedStyle(btn).getPropertyValue('--color-hex');
                    btn.style.backgroundColor = hex;
                    btn.style.color = (hex === '#ffffff') ? '#000' : '#fff';

                    document.getElementById(`selectedColor-${itemId}`).value = btn.dataset.color;
                }

                if (e.target.closest('.size-btn')) {
                    const btn = e.target.closest('.size-btn');
                    const itemId = btn.dataset.item;
                    document.querySelectorAll(`[data-item="${itemId}"].size-btn`)
                        .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
                    btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
                    document.getElementById(`selectedSize-${itemId}`).value = btn.dataset.size;
                }
            });
        </script>
    @endpush

    <style>
        #modalImage {
            transition: opacity 0.3s ease-in-out;
        }

        .thumb {
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .thumb:hover {
            transform: scale(1.05);
        }

        .main-image img:hover {
            transform: scale(1.02);
            transition: transform 0.3s ease;
        }
    </style>
@endpush