<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="stylesheet" href="{{ asset('assets/css/user/style.css') }}" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user/kategori.css') }}">
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.partials_user.sidebar')

    {{-- OVERLAY --}}
    <div id="overlay"></div>

    {{-- HEADER --}}
    <header>
        @include('layouts.partials_user.navbar')
    </header>

    {{-- HERO SLIDER --}}
    <section class="hero" id="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('assets/images/hero/1.jpeg')"></div>
            <div class="slide" style="background-image: url('assets/images/hero/2.jpeg')"></div>
            <div class="slide" style="background-image: url('assets/images/hero/3.jpeg')"></div>
        </div>
    </section>

    {{-- MAIN PANEL / TABS --}}
    <div class="tabs">
        <button class="tab" data-category="kategori">Kategori</button>
        <button class="tab active" data-category="all">Semua Produk</button>
        <button class="tab" data-category="diskon">Diskon</button>
    </div>

    {{-- PANEL: CATEGORY --}}
    @include('layouts.partials_user.panels.kategori')

    {{-- PANEL: PRODUCT: FILTERED --}}
    <div id="filtered-category" class="hidden">
        <div id="category-banner" class="relative h-96 bg-cover bg-center rounded-3xl shadow-lg mb-12"></div>
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800" id="category-title"></h2>
        <div id="filtered-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
    </div>

    {{-- PANEL: DISKON --}}
    @include('layouts.partials_user.panels.diskon')

    {{-- PANEL: ALL PRODUK --}}
    @include('layouts.partials_user.panels.all-produk')

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}">
            <button class="see-all-btn">Lihat Semua Produk</button>
        </a>
    </div>

    <div class="extra-icons">
        <div class="icon-box">
            <i data-lucide="info"></i>
            <span>Tentang Kami</span>
        </div>
        <div class="icon-box">
            <a href="{{ route('customer.allProduk') }}" class="icon-box">
                <i data-lucide="shopping-bag"></i>
                <span>Semua Produk</span>
            </a>
        </div>
    </div>

    {{-- FOOTER --}}
    @include('layouts.partials_user.footer')

    {{-- BACK TO TOP --}}
    <button id="backToTop" title="Kembali ke atas"
        class="fixed bottom-6 right-6 w-12 h-12 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-700 hover:scale-110 transition-all duration-300 z-50">
        <i data-lucide="arrow-up" class="w-6 h-6"></i>
    </button>

    {{-- LOGIN & REGISTER MODAL --}}
    @include('layouts.partials_user.modals.login')
    @include('layouts.partials_user.modals.register')


    {{-- JS: LOGIN & REGISTER MODAL --}}
    <script>
        //Login Modal
        function openLoginModal() {
            closeRegisterModal();
            const modal = document.getElementById('loginModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('loginModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeLoginModal();
        });

        // Register Modal
        function openRegisterModal() {
            closeLoginModal();
            const modal = document.getElementById('registerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('registerModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeRegisterModal();
        });

        // Switch modal
        function switchToRegisterModal() {
            closeLoginModal();
            setTimeout(() => openRegisterModal(), 200);
        }
        function switchToLoginModal() {
            closeRegisterModal();
            setTimeout(() => openLoginModal(), 200);
        }

        // Password Toggle (Login)
        const loginToggle = document.getElementById('loginPasswordToggle');
        const loginInput = document.getElementById('loginPassword');
        const loginIcon = loginToggle.querySelector('i');
        loginToggle.addEventListener('click', () => {
            const isHidden = loginInput.type === 'password';
            loginInput.type = isHidden ? 'text' : 'password';
            loginIcon.classList.toggle('fa-eye');
            loginIcon.classList.toggle('fa-eye-slash');
        });

        // Password Toggle (Register)
        const regToggle = document.getElementById('registerPasswordToggle');
        const regInput = document.getElementById('registerPassword');
        const regIcon = regToggle.querySelector('i');
        regToggle.addEventListener('click', () => {
            const isHidden = regInput.type === 'password';
            regInput.type = isHidden ? 'text' : 'password';
            regIcon.classList.toggle('fa-eye');
            regIcon.classList.toggle('fa-eye-slash');
        });

        // Password Strength Indicator
        const bar = document.getElementById('passwordStrength');
        const text = document.getElementById('passwordText');
        regInput.addEventListener('input', () => {
            const val = regInput.value;
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;
            const colors = ['#e53e3e', '#ed8936', '#38a169', '#1a1a1a'];
            const texts = ['Lemah', 'Cukup', 'Baik', 'Sangat Kuat'];
            bar.style.width = strength * 25 + '%';
            bar.style.backgroundColor = colors[strength - 1] || '#333';
            text.textContent = texts[strength - 1] || 'Status Password';
            text.style.color = colors[strength - 1] || '#333';
        });

        // Loading Button
        document.getElementById('loginForm').addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;
        });
        document.getElementById('registerForm').addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
        });
    </script>

    {{-- JS: CART MODAL --}}
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal(id);
                    }
                });
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('hidden');
        }

        function addToCart(id) {
            const warna = document.querySelector(`#selectedColor-${id}`)?.value;
            const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
            const qty = document.querySelector(`#qty-${id}`)?.value || 1;

            if (!warna || !ukuran) {
                alert('Silakan pilih warna dan ukuran terlebih dahulu!');
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
                    alert(data.message);
                    closeModal(`productModal-${id}`);
                    updateCartBadge();
                })
                .catch(err => console.error(err));
        }

        // 🔹 Fungsi untuk update badge jumlah keranjang


        // COLOR & SIZE SELECTED
        document.addEventListener('click', e => {
            if (e.target.closest('.color-btn')) {
                const btn = e.target.closest('.color-btn');
                const itemId = btn.dataset.item;
                document.querySelectorAll(`[data-item="${itemId}"].color-btn`)
                    .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
                btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
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

    {{-- JS: INCREMENT & DECREMENT QTY --}}
    <script>
        function incrementQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;

            // Animasi feedback
            input.classList.add('ring-2', 'ring-green-400');
            setTimeout(() => {
                input.classList.remove('ring-2', 'ring-green-400');
            }, 200);
        }

        function decrementQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 1;

            if (currentValue > 1) {
                input.value = currentValue - 1;

                // Animasi feedback
                input.classList.add('ring-2', 'ring-red-400');
                setTimeout(() => {
                    input.classList.remove('ring-2', 'ring-red-400');
                }, 200);
            }
        }

        function validateQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const value = parseInt(input.value);

            if (isNaN(value) || value < 1) {
                input.value = 1;
            }
        }
    </script>


    {{-- JS: BUY MODAL --}}
    <script>
        // Fungsi update jumlah produk
        function updateQty(button, change) {
            const input = button.parentElement.querySelector('input[type="number"]');
            let value = parseInt(input.value) + change;
            const min = parseInt(input.min);
            const max = parseInt(input.max);

            if (value < min) value = min;
            if (value > max) value = max;

            input.value = value;
        }

        // Fungsi redirect ke halaman login
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }

        // Fungsi pilih warna
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const itemId = this.dataset.item;
                const color = this.dataset.color;
                const buttons = document.querySelectorAll(`[data-item="${itemId}"].color-btn`);

                buttons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
                this.classList.add('border-blue-600', 'bg-blue-50');

                document.getElementById(`selectedColor-${itemId}`).value = color;
            });
        });

        // Fungsi pilih ukuran
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const itemId = this.dataset.item;
                const size = this.dataset.size;
                const buttons = document.querySelectorAll(`[data-item="${itemId}"].size-btn`);

                buttons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
                this.classList.add('border-blue-600', 'bg-blue-50');

                document.getElementById(`selectedSize-${itemId}`).value = size;
            });
        });
    </script>

    {{-- JS: USER DROPDOWN --}}
    <script>
        lucide.createIcons();
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userBtn && userDropdown) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target) && !userBtn.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('block');
                });

                const filteredCategory = document.getElementById('filtered-category');
                if (filteredCategory) filteredCategory.classList.add('hidden');
                const target = tab.dataset.category;
                const targetPanel = document.getElementById(`panel-${target}`);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('block');
                }
            });
        });
    </script>

    {{-- JS: KATEGORI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allProducts = @json($produk);
            window.showCategory = function (jenis) {
                const kategoriPanel = document.getElementById('panel-kategori');
                const filteredPanel = document.getElementById('filtered-category');
                const grid = document.getElementById('filtered-products');
                const bannerTitle = document.getElementById('category-banner-title');
                const bannerImg = document.getElementById('category-banner-img');
                kategoriPanel.classList.add('hidden');
                filteredPanel.classList.remove('hidden');
                bannerTitle.textContent = jenis;
                const bannerMap = {
                    'T-Shirt': '/assets/images/banner/tshirt.jpeg',
                    'Hoodie': '/assets/images/banner/hoodie-1.jpg',
                    'Jersey': '/assets/images/banner/jersey.jpg',
                };
                bannerImg.src = bannerMap[jenis] || '/assets/images/default-banner.jpg';
                const filtered = allProducts.filter(p => p.jenis === jenis);
                grid.innerHTML = '';

                if (filtered.length === 0) {
                    grid.innerHTML = `<p class='col-span-3 text-center text-gray-500 text-lg py-12'>Belum ada produk untuk kategori ${jenis}</p>`;
                    return;
                }

                filtered.forEach(item => {
                    const foto = item.fotos?.length ? `/storage/${item.fotos[0].foto}` : `/assets/images/no-image.png`;

                    const card = `
                                                                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                                                                    data-id="${item.id}" data-nama="${item.nama_produk}" data-harga="${item.harga}"
                                                                    data-foto="${foto}" data-category="${item.kategori ?? 'umum'}">

                                                                    <a href="/produk/detail/${item.id}" class="block overflow-hidden rounded-t-2xl bg-gray-50">
                                                                        <img src="${foto}" alt="${item.nama_produk}" class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                                                                    </a>

                                                                    <div class="p-6 flex flex-col gap-3">
                                                                        <h3 class="text-center text-xl font-bold text-gray-900 line-clamp-1">${item.nama_produk}</h3>
                                                                        <p class="text-center text-lg text-black font-bold">
                                                                            IDR ${new Intl.NumberFormat('id-ID').format(item.harga)}
                                                                        </p>

                                                                        <div class="flex gap-2 w-full mt-2">
                                                                            <!-- CART -->
                                                                            <button
                                                                                class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                                                                onclick="openModal('productModal-${item.id}')" title="Tambah ke Keranjang">
                                                                                <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                    <path stroke-linecap='round' stroke-linejoin='round'
                                                                                        d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'/>
                                                                                </svg>
                                                                            </button>

                                                                            <!-- BUY -->
                                                                            <button
                                                                                class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                                                                onclick="openModal('productBeliModal-${item.id}')">
                                                                                <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                    <path stroke-linecap='round' stroke-linejoin='round' d='M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'/>
                                                                                </svg>
                                                                                <span>Beli Sekarang</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>`;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            };

            window.backToCategories = function () {
                document.getElementById('filtered-category').classList.add('hidden');
                document.getElementById('panel-kategori').classList.remove('hidden');
            };
        });
    </script>

    {{-- SESSION LOGIN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!empty($showLoginModal) && $showLoginModal)
                openLoginModal();
            @endif
    });
    </script>

    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>

</body>

</html>