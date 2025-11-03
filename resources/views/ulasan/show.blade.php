@extends('layouts.user_app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pesanan</h1>
                <p class="text-gray-600">Kelola dan ulas produk yang telah Anda beli</p>
            </div>

            <!-- Order Summary Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Pesanan #{{ $order->id }}</h2>
                        <p class="text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($order->items as $item)
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <!-- Product Info -->
                        <div class="p-6 flex gap-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if(optional($item->produk->fotos)->isNotEmpty())
                                    <div class="w-24 h-24 rounded-xl overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                            class="w-full h-full object-cover" alt="{{ $item->produk->nama_produk }}">
                                    </div>
                                @else
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-lg">
                                    {{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }}</h3>
                                <div class="flex items-center text-gray-500 text-sm mt-1">
                                    <span class="mr-3">{{ $item->ukuran }}</span>
                                    <span>•</span>
                                    <span class="ml-3">{{ $item->warna }}</span>
                                </div>
                                <div class="mt-3">
                                    <span class="text-lg font-bold text-gray-900">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    <span class="text-gray-500 ml-2">x{{ $item->jumlah }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review Section -->
                        <div class="border-t border-gray-100 p-6 bg-gray-50">
                            @if($item->ulasan)
                                <!-- Existing Review -->
                                <div class="bg-white rounded-xl p-4 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <div class="flex mr-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 {{ $i <= $item->ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                            </path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">{{ $item->ulasan->rating }}/5</span>
                                            </div>
                                            <p class="text-gray-700 mb-3">{{ $item->ulasan->komentar }}</p>

                                            <!-- Review Photos -->
                                            @if(optional($item->ulasan->fotos)->isNotEmpty())
                                                <div class="flex gap-2 mt-3 overflow-x-auto pb-2">
                                                    @foreach($item->ulasan->fotos as $f)
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('storage/' . $f->foto) }}"
                                                                class="w-16 h-16 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                                                onclick="openImageModal('{{ asset('storage/' . $f->foto) }}')">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Edit Button -->
                                        <button
                                            class="ml-4 text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100"
                                            onclick="openEditModal({{ $item->ulasan->id }}, '{{ addslashes($item->ulasan->komentar) }}', {{ $item->ulasan->rating }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <!-- Add Review Button -->
                                <div class="text-center">
                                    <a href="{{ route('ulasan.create', ['order_item_id' => $item->id]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                        Beri Ulasan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div id="editModal" class="fixed z-[9999] inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Ulasan</h3>
                    <button onclick="closeEditModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors rounded-full p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <form id="editUlasanForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Rating</label>
                    <div id="starRating" class="flex gap-2 cursor-pointer">
                        @for($i = 1; $i <= 5; $i++)
                            <svg data-value="{{ $i }}" class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition-colors"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="editRating">
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="editKomentar" class="block text-gray-700 font-medium mb-3">Komentar</label>
                    <textarea name="komentar" id="editKomentar" rows="4"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all resize-none"></textarea>
                </div>

                <!-- Photos -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Foto Ulasan (opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="editFotos"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span>
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (Maks. 5MB)</p>
                            </div>
                            <input id="editFotos" name="fotos[]" type="file" multiple class="hidden"
                                onchange="previewFotos(this)">
                        </label>
                    </div>
                    <div id="previewContainer" class="flex gap-2 mt-3 overflow-x-auto"></div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-xl transition-colors font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center hidden z-50 p-4">
        <div class="max-w-4xl max-h-full">
            <div class="relative">
                <button onclick="closeImageModal()"
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <img id="modalImage" src="" class="max-w-full max-h-screen object-contain rounded-lg">
            </div>
        </div>
    </div>

    <script>
        let currentRating = 0;

        // Modal functions
        function openEditModal(id, komentar, rating) {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            const form = document.getElementById('editUlasanForm');
            form.action = `/ulasan/${id}`;
            document.getElementById('editKomentar').value = komentar;

            // Set rating
            currentRating = rating;
            document.getElementById('editRating').value = rating;
            updateStars(rating);
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('previewContainer').innerHTML = '';
        }

        // Image modal functions
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            img.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Rating stars
        const stars = document.querySelectorAll('#starRating svg');
        stars.forEach(star => {
            star.addEventListener('click', function () {
                currentRating = this.dataset.value;
                document.getElementById('editRating').value = currentRating;
                updateStars(currentRating);
            });

            star.addEventListener('mouseover', function () {
                const hoverValue = this.dataset.value;
                updateStars(hoverValue);
            });
        });

        document.getElementById('starRating').addEventListener('mouseleave', function () {
            updateStars(currentRating);
        });

        function updateStars(rating) {
            stars.forEach(star => {
                if (star.dataset.value <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.add('text-gray-300');
                    star.classList.remove('text-yellow-400');
                }
            });
        }

        // Photo preview
        function previewFotos(input) {
            const container = document.getElementById('previewContainer');
            container.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = 'relative flex-shrink-0';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-20 h-20 object-cover rounded-lg';

                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.innerHTML = '×';
                            removeBtn.className = 'absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600';
                            removeBtn.onclick = function () {
                                div.remove();
                                // Also remove from file input
                                // This would require more complex handling with a FileList
                            };

                            div.appendChild(img);
                            div.appendChild(removeBtn);
                            container.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // Close modals with ESC key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeEditModal();
                closeImageModal();
            }
        });
    </script>
@endsection