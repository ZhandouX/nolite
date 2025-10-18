<div class="left-header">
    <span id="menuBtn">&#9776;</span>
</div>
<div class="logo">
    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite" class="logo-img" />
    Nolite Aspiciens
</div>
<nav class="nav-icons flex items-center gap-5 relative fixed top-0 left-0">
    {{-- SEARCH --}}
    <button type="button" class="text-white-700 hover:text-gray-400 transition">
        <i data-lucide="search" class="w-6 h-6"></i>
    </button>

    <a href="{{ route('keranjang.index') }}" class="text-white-700 hover:text-gray-400 transition relative">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>

        {{-- CART TOTAL --}}
        @php
            if (Auth::check()) {
                $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count();
            } else {
                $jumlahKeranjang = count(session('keranjang', []));
            }
        @endphp

        @if($jumlahKeranjang > 0)
            <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                {{ $jumlahKeranjang }}
            </span>
        @endif
    </a>

    {{-- USER --}}
    <div class="relative">
        @auth
            {{-- Jika sudah login → klik menuju halaman profile --}}
            <a href="{{ route('profile.edit') }}"
                class="text-white-700 hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="w-5 h-5"></i>
            </a>
        @else
            {{-- Jika belum login → klik buka modal login --}}
            <button type="button" onclick="openLoginModal()"
                class="text-white-700 hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="w-5 h-5"></i>
            </button>
        @endauth
    </div>
</nav>

{{-- JS: DROPDOWN --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const userBtn = document.getElementById("userBtn");
        const userDropdown = document.getElementById("userDropdown");

        userBtn.addEventListener("click", () => {
            userDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", (e) => {
            if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add("hidden");
            }
        });
    });
</script>