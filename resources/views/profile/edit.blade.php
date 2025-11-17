@extends('layouts.user_app')

@section('title', 'My Account')

@section('content')
    <div class="bg-gray-100 text-gray-800 min-h-screen py-10 px-2 md:px-4 flex justify-center items-start pt-20 md:pt-9">
        <div class="w-full md:max-w-3xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold">
                    Hai {{ Auth::user()->name ?? 'User' }}
                </h1>
                <a href="{{ route('profile.settings') }}"
                    class="border border-red-900 text-red-900 px-4 py-2 rounded-lg hover:bg-gray-600 hover:text-white transition">
                    <i class="fa-solid fa-gear mr-2"></i>
                    Settings
                </a>
            </div>

            <!-- Orders & Wishlist -->
            <div class="bg-white rounded-lg shadow-sm p-3 md:p-6 relative hover:shadow-md transition">

                <!-- Dropdown -->
                <div class="absolute top-16 right-1 md:top-6 md:right-6">
                    <select id="statusFilter" class="border border-gray-300 rounded px-2 py-1 md:px-3 text-sm">
                        <option value="all">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tabs -->
                <div class="flex justify-center border-b border-gray-200 mb-[50px] md:mb-5">
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400 active-tab"
                        data-tab="orders">
                        Orders
                    </div>
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400"
                        data-tab="wishlist">
                        Wishlist
                    </div>
                </div>

                <!-- Orders Content -->
                @include('layouts.partials_user.panels.orders')

                <!-- Wishlist Content -->
                @include('layouts.partials_user._wishlist-section')
            </div>
        </div>
    </div>

    {{-- MODAL ULASAN (DETAIL & EDIT) --}}
    <div id="ulasanModal"
        class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 md:p-6">
        <div
            class="bg-white w-full max-w-2xl max-h-[90vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col border border-gray-200 animate-fadeIn">

            {{-- HEADER --}}
            <div
                class="bg-gradient-to-r from-red-900 via-red-800 to-red-700 text-white px-6 py-5 flex items-center justify-between">
                <h2 class="text-2xl font-bold" id="ulasanModalTitle">Detail Ulasan</h2>
                <button onclick="closeUlasanModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- BODY --}}
            <div class="flex-1 overflow-y-auto p-6">
                {{-- DETAIL ULASAN --}}
                <div id="ulasanDetailContent">
                    {{-- Diisi oleh JavaScript --}}
                </div>

                {{-- FORM EDIT ULASAN --}}
                <div id="ulasanEditContent" class="hidden">
                    <form id="editUlasanForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <select name="rating" class="w-full border rounded-lg p-2" required>
                                <option value="">Pilih Rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                            <textarea name="komentar" rows="3" class="w-full border rounded-lg p-2"
                                placeholder="Tulis ulasan Anda..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Ulasan Saat Ini</label>
                            <div id="currentPhotos" class="grid grid-cols-3 gap-2 mb-3">
                                {{-- Foto akan dimuat di sini --}}
                            </div>
                        </div>

                        {{-- FILE UPLOAD (EDIT FORM) --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-800 mb-3">Tambah Foto Baru</label>

                            {{-- Upload Area --}}
                            <div id="uploadAreaEdit"
                                class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center transition-all duration-300 hover:border-red-400 hover:bg-red-50 cursor-pointer">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                                <p class="text-sm font-medium text-gray-700 mb-1">Klik atau drag & drop foto di sini</p>
                                <p class="text-xs text-gray-500">Format: JPG, PNG, JPEG (Maks. 5MB per gambar)</p>

                                <input type="file" name="fotos[]" multiple accept="image/*" id="fileInputEdit"
                                    class="hidden" onchange="previewImagesEdit(this)">
                            </div>

                            {{-- Image Previews --}}
                            <div id="imagePreviewsEdit" class="grid grid-cols-3 gap-3 mt-4 hidden"></div>

                            {{-- Upload Info --}}
                            <div id="uploadInfoEdit" class="flex items-center gap-2 mt-3 text-xs text-gray-500 hidden">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Anda dapat mengupload maksimal 5 foto</span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="showUlasanDetail()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Batal</button>
                            <button type="submit"
                                class="bg-red-900 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }

        .star-rating {
            color: #fbbf24;
        }
    </style>
@endpush

@push('script')
    <script>
        // Filter status pesanan
        document.addEventListener('DOMContentLoaded', () => {
            const statusFilter = document.getElementById('statusFilter');
            const orderCards = document.querySelectorAll('.order-card');

            statusFilter.addEventListener('change', () => {
                const selected = statusFilter.value;

                orderCards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    card.style.display = (selected === 'all' || status === selected) ? 'block' : 'none';
                });
            });
        });

        // Hapus wishlist tanpa reload
        document.addEventListener('DOMContentLoaded', function () {
            const token = '{{ csrf_token() }}';

            document.querySelectorAll('.remove-wishlist').forEach(button => {
                button.addEventListener('click', async function () {
                    const id = this.dataset.id;
                    const itemElement = document.getElementById(`wishlist-item-${id}`);

                    const confirmation = await Swal.fire({
                        title: 'Hapus dari Wishlist?',
                        text: 'Produk ini akan dihapus dari daftar wishlist kamu.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    });

                    if (confirmation.isConfirmed) {
                        const response = await fetch(`/wishlist/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                        });

                        if (response.ok) {
                            if (itemElement) {
                                itemElement.classList.add('opacity-0', 'scale-90', 'transition', 'duration-300');
                                setTimeout(() => itemElement.remove(), 300);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Produk berhasil dihapus dari wishlist.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus wishlist.',
                            });
                        }
                    }
                });
            });
        });

        // Tabs navigasi
        document.addEventListener("DOMContentLoaded", () => {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');

                    tabs.forEach(t => t.classList.remove('border-black', 'text-black', 'active-tab'));
                    tab.classList.add('border-black', 'text-black', 'active-tab');

                    contents.forEach(c => c.classList.add('hidden'));
                    document.getElementById(target).classList.remove('hidden');
                });
            });
        });

        // Validasi ukuran gambar
        function validateImages(input) {
            const maxSize = 5 * 1024 * 1024;
            for (const file of input.files) {
                if (file.size > maxSize) {
                    alert(`File "${file.name}" melebihi 5MB!`);
                    input.value = '';
                    break;
                }
            }
        }

        // === MODAL ULASAN FUNCTIONS ===
        let currentUlasanId = null;

        function openUlasanModal(ulasanId, orderItemId = null) {
            currentUlasanId = ulasanId;
            const modal = document.getElementById('ulasanModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            loadUlasanDetail(ulasanId);
        }

        function closeUlasanModal() {
            const modal = document.getElementById('ulasanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentUlasanId = null;
        }

        function loadUlasanDetail(ulasanId) {
            fetch(`/ulasan/${ulasanId}`)
                .then(response => response.json())
                .then(ulasan => {
                    displayUlasanDetail(ulasan);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal memuat detail ulasan', 'error');
                });
        }

        function displayUlasanDetail(ulasan) {
            const content = document.getElementById('ulasanDetailContent');
            const title = document.getElementById('ulasanModalTitle');

            title.textContent = 'Detail Ulasan';

            // Generate stars
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= ulasan.rating
                    ? '<i class="fas fa-star star-rating"></i>'
                    : '<i class="far fa-star star-rating"></i>';
            }

            // Generate photos
            let photosHTML = '';
            if (ulasan.fotos && ulasan.fotos.length > 0) {
                photosHTML = '<div class="mt-4"><p class="font-medium text-gray-700 mb-2">Foto Ulasan:</p><div class="grid grid-cols-3 gap-2">';
                ulasan.fotos.forEach(foto => {
                    photosHTML += `<img src="{{ asset('storage') }}/${foto.foto}" class="w-full h-24 object-cover rounded-lg border">`;
                });
                photosHTML += '</div></div>';
            }

            content.innerHTML = `
                                    <div>
                                        <div class="flex items-center mb-4">
                                            <div class="flex mr-2">${stars}</div>
                                            <span class="text-lg font-semibold">${ulasan.rating}.0</span>
                                        </div>
                                        <p class="text-gray-700 mb-4">${ulasan.komentar || '-'}</p>
                                        ${photosHTML}
                                        <div class="mt-6 flex justify-end">
                                            <button onclick="showEditUlasanForm(${ulasan.id})" class="bg-red-900 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition">Edit Ulasan</button>
                                        </div>
                                    </div>
                                `;

            document.getElementById('ulasanDetailContent').classList.remove('hidden');
            document.getElementById('ulasanEditContent').classList.add('hidden');
        }

        function showEditUlasanForm(ulasanId) {
            fetch(`/ulasan/${ulasanId}/edit`)
                .then(response => response.json())
                .then(ulasan => {
                    displayEditUlasanForm(ulasan);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal memuat form edit', 'error');
                });
        }

        function displayEditUlasanForm(ulasan) {
            const title = document.getElementById('ulasanModalTitle');
            title.textContent = 'Edit Ulasan';

            // Set form values
            document.querySelector('#editUlasanForm select[name="rating"]').value = ulasan.rating;
            document.querySelector('#editUlasanForm textarea[name="komentar"]').value = ulasan.komentar || '';

            // Display current photos
            const currentPhotos = document.getElementById('currentPhotos');
            currentPhotos.innerHTML = '';

            if (ulasan.fotos && ulasan.fotos.length > 0) {
                ulasan.fotos.forEach(foto => {
                    currentPhotos.innerHTML += `
                                            <div class="relative">
                                                <img src="{{ asset('storage') }}/${foto.foto}" class="w-full h-24 object-cover rounded-lg border">
                                                <button type="button" onclick="hapusFotoUlasan(${foto.id})" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center transform translate-x-1/2 -translate-y-1/2">×</button>
                                            </div>
                                        `;
                });
            } else {
                currentPhotos.innerHTML = '<p class="text-gray-500 text-sm">Belum ada foto</p>';
            }

            document.getElementById('ulasanDetailContent').classList.add('hidden');
            document.getElementById('ulasanEditContent').classList.remove('hidden');
        }

        function showUlasanDetail() {
            if (currentUlasanId) {
                loadUlasanDetail(currentUlasanId);
            }
        }

        // Handle edit form submission
        document.getElementById('editUlasanForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(`/ulasan/${currentUlasanId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Sukses', data.success, 'success');
                        loadUlasanDetail(currentUlasanId); // Kembali ke detail
                    } else {
                        Swal.fire('Error', data.error || 'Gagal memperbarui ulasan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat memperbarui ulasan', 'error');
                });
        });

        // Handle create form submission
        document.getElementById('ulasanForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Sukses', data.success, 'success');
                        closeOrderModal();
                    } else {
                        Swal.fire('Error', data.error || 'Gagal mengirim ulasan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat mengirim ulasan', 'error');
                });
        });

        function hapusFotoUlasan(fotoId) {
            Swal.fire({
                title: 'Hapus Foto?',
                text: "Foto ini akan dihapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/ulasan-foto/${fotoId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Terhapus!', data.success, 'success');
                                showEditUlasanForm(currentUlasanId); // Reload form edit
                            } else {
                                Swal.fire('Error', data.error || 'Gagal menghapus foto', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus foto', 'error');
                        });
                }
            });
        }

        // === ORDER MODAL FUNCTIONS ===
        function openOrderModal(orderId) {
            const orderDiv = document.querySelector(`.order-data[data-id='${orderId}']`);
            if (!orderDiv) return;

            const items = JSON.parse(orderDiv.getAttribute('data-items') || '[]');
            const status = orderDiv.getAttribute('data-status') || '-';
            const subtotal = orderDiv.getAttribute('data-subtotal') || 0;

            document.getElementById('ulasanContainer').classList.add('hidden');

            document.getElementById('modalOrderId').textContent = orderId;
            document.getElementById('modalOrderStatus').textContent = status;
            document.getElementById('modalOrderSubtotal').textContent = 'Rp ' + Number(subtotal).toLocaleString('id-ID');
            document.getElementById('detailOrderLink').href = `/orders/${orderId}`;

            const itemsContainer = document.getElementById('modalOrderItems');
            itemsContainer.innerHTML = '';

            items.forEach(item => {
                const produk = item.produk || {};
                const ulasan = (item.ulasan_data && item.ulasan_data.id) ? item.ulasan_data : null;

                const fotoUrl = produk.foto
                    ? `{{ asset('storage') }}/${produk.foto}`
                    : `{{ asset('assets/images/no-image.png') }}`;

                itemsContainer.innerHTML += `
                                        <div class="flex items-center border border-gray-200 rounded-lg p-3 bg-white hover:shadow-md transition-all">
                                            <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center mr-4">
                                                <img src="${fotoUrl}" class="w-full h-full object-cover">
                                            </div>

                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800">${produk.nama_produk || 'Produk tidak diketahui'}</p>
                                                <p class="text-sm text-gray-500 mt-1">Warna: ${item.warna || '-'}</p>
                                                <p class="text-sm text-gray-500">Ukuran: ${item.ukuran || '-'}</p>
                                                <p class="text-sm text-gray-500">Jumlah: ${item.jumlah || 0}</p>

                                                <div class="mt-2">
                                                    ${status.toLowerCase() !== 'selesai'
                        ? `<span class="text-gray-400 text-sm">Pesanan belum selesai</span>`
                        : ulasan
                            ? `
                                                                <button onclick="openUlasanModal(${ulasan.id})"
                                                                    class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg text-xs">
                                                                    <i class="fa-solid fa-eye"></i> Lihat Ulasan
                                                                </button>
                                                            `
                            : `
                                                                <button onclick="openUlasanForm(${item.id}, ${item.produk_id}, ${orderId})"
                                                                    class="inline-flex items-center gap-2 bg-red-900 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs">
                                                                    <i class="fa-solid fa-pen"></i> Tulis Ulasan
                                                                </button>
                                                            `}
                                                </div>
                                            </div>

                                            <div class="text-right font-semibold text-gray-800">
                                                Rp${Number(item.subtotal || 0).toLocaleString('id-ID')}
                                            </div>
                                        </div>`;
            });

            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openUlasanForm(order_item_id, produk_id, order_id) {
            document.getElementById('ulasanContainer').classList.remove('hidden');
            document.getElementById('ulasanForm').classList.remove('hidden');

            document.getElementById('ulasanOrderId').value = order_id;
            document.getElementById('ulasanProdukId').value = produk_id;
            document.getElementById('ulasanOrderItemId').value = order_item_id;

            document.getElementById('ulasanContainer').scrollIntoView({ behavior: 'smooth' });
        }

        // Klik luar modal
        document.getElementById('orderModal').addEventListener('click', function (e) {
            if (e.target === this) closeOrderModal();
        });

        document.getElementById('ulasanModal').addEventListener('click', function (e) {
            if (e.target === this) closeUlasanModal();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Star Rating System
            const starButtons = document.querySelectorAll('.star-btn');
            const selectedRating = document.getElementById('selectedRating');
            const ratingText = document.getElementById('ratingText');
            const submitBtn = document.getElementById('submitBtn');
            const textarea = document.querySelector('textarea[name="komentar"]');
            const charCount = document.getElementById('charCount');
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const imagePreviews = document.getElementById('imagePreviews');
            const uploadInfo = document.getElementById('uploadInfo');
            const cancelBtn = document.getElementById('cancelBtn');

            // Star Rating Logic
            starButtons.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    selectedRating.value = rating;

                    // Update stars appearance
                    starButtons.forEach((s, index) => {
                        const starSpan = s.querySelector('span');
                        if (index < rating) {
                            starSpan.className = 'text-yellow-400';
                        } else {
                            starSpan.className = 'text-gray-300';
                        }
                    });

                    // Update rating text
                    const ratingTexts = {
                        1: 'Tidak Puas - Produk tidak sesuai ekspektasi',
                        2: 'Kurang Puas - Ada beberapa kekurangan',
                        3: 'Cukup - Produk standar, biasa saja',
                        4: 'Puas - Produk bagus dan memuaskan',
                        5: 'Sangat Puas - Produk luar biasa, melebihi ekspektasi'
                    };
                    ratingText.textContent = ratingTexts[rating];
                    ratingText.className = 'text-sm font-medium text-green-600 mt-2';

                    validateForm();
                });

                // Hover effect for stars
                star.addEventListener('mouseenter', function () {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    starButtons.forEach((s, index) => {
                        const starSpan = s.querySelector('span');
                        if (index < rating && !starSpan.classList.contains('text-yellow-400')) {
                            starSpan.className = 'text-yellow-200';
                        }
                    });
                });

                star.addEventListener('mouseleave', function () {
                    const currentRating = parseInt(selectedRating.value) || 0;
                    starButtons.forEach((s, index) => {
                        const starSpan = s.querySelector('span');
                        if (index >= currentRating && !starSpan.classList.contains('text-yellow-400')) {
                            starSpan.className = 'text-gray-300';
                        }
                    });
                });
            });

            // Character Count for Textarea
            textarea.addEventListener('input', function () {
                const count = this.value.length;
                charCount.textContent = count;

                if (count > 500) {
                    charCount.className = 'text-xs text-red-500';
                } else if (count > 400) {
                    charCount.className = 'text-xs text-orange-500';
                } else {
                    charCount.className = 'text-xs text-gray-400';
                }

                validateForm();
            });

            // File Upload Handling
            uploadArea.addEventListener('click', () => fileInput.click());

            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('border-red-400', 'bg-red-50');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('border-red-400', 'bg-red-50');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('border-red-400', 'bg-red-50');
                fileInput.files = e.dataTransfer.files;
                previewImages(fileInput);
            });

            // Cancel Button
            cancelBtn.addEventListener('click', function () {
                resetForm();
                document.getElementById('ulasanContainer').classList.add('hidden');
            });

            // Form Validation
            function validateForm() {
                const hasRating = selectedRating.value !== '';
                const hasComment = textarea.value.trim().length >= 10;
                const withinLimit = textarea.value.length <= 500;

                submitBtn.disabled = !(hasRating && hasComment && withinLimit);
            }

            function resetForm() {
                selectedRating.value = '';
                textarea.value = '';
                charCount.textContent = '0';
                charCount.className = 'text-xs text-gray-400';
                ratingText.textContent = 'Pilih rating dengan mengklik bintang';
                ratingText.className = 'text-sm text-gray-500 mt-2';
                imagePreviews.innerHTML = '';
                imagePreviews.classList.add('hidden');
                uploadInfo.classList.add('hidden');
                fileInput.value = '';

                // Reset stars
                starButtons.forEach(star => {
                    star.querySelector('span').className = 'text-gray-300';
                });

                validateForm();
            }
        });

        function previewImages(input) {
            const previews = document.getElementById('imagePreviews');
            const uploadInfo = document.getElementById('uploadInfo');

            previews.innerHTML = '';

            if (input.files && input.files.length > 0) {
                previews.classList.remove('hidden');
                uploadInfo.classList.remove('hidden');

                Array.from(input.files).slice(0, 5).forEach((file, index) => {
                    if (validateImage(file)) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const preview = document.createElement('div');
                            preview.className = 'relative group';
                            preview.innerHTML = `
                                                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg" alt="Preview">
                                                    <button type="button" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200" onclick="removeImage(${index})">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                `;
                            previews.appendChild(preview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previews.classList.add('hidden');
                uploadInfo.classList.add('hidden');
            }
        }

        function removeImage(index) {
            const fileInput = document.getElementById('fileInput');
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);

            files.forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });

            fileInput.files = dt.files;
            previewImages(fileInput);
        }

        function validateImage(file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung. Harap upload gambar JPG, JPEG, atau PNG.');
                return false;
            }

            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 5MB per gambar.');
                return false;
            }

            return true;
        }
    </script>

    <script>
        // Klik area → buka file input
        document.getElementById('uploadAreaEdit').addEventListener('click', function () {
            document.getElementById('fileInputEdit').click();
        });

        // Preview function
        function previewImagesEdit(input) {
            const previewContainer = document.getElementById("imagePreviewsEdit");
            const info = document.getElementById("uploadInfoEdit");

            previewContainer.innerHTML = "";
            previewContainer.classList.remove("hidden");
            info.classList.remove("hidden");

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer.innerHTML += `
                        <div class="relative group">
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-xl shadow-sm border" />
                        </div>`;
                };
                reader.readAsDataURL(file);
            });
        }

        // Drag & Drop
        const dropAreaEdit = document.getElementById('uploadAreaEdit');

        dropAreaEdit.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropAreaEdit.classList.add('border-red-400', 'bg-red-50');
        });

        dropAreaEdit.addEventListener('dragleave', () => {
            dropAreaEdit.classList.remove('border-red-400', 'bg-red-50');
        });

        dropAreaEdit.addEventListener('drop', (e) => {
            e.preventDefault();
            dropAreaEdit.classList.remove('border-red-400', 'bg-red-50');

            document.getElementById('fileInputEdit').files = e.dataTransfer.files;
            previewImagesEdit(document.getElementById('fileInputEdit'));
        });
    </script>
@endpush