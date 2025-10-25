<div class="left-header">
    <span id="menuBtn">&#9776;</span>
</div>
<div class="logo">
    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite" class="logo-img" />
    Nolite Aspiciens
</div>
<nav class="nav-icons flex items-center gap-5">
    {{-- SEARCH --}}
    <button type="button" class="text-white-700 hover:text-gray-400 transition">
        <i data-lucide="search" class="w-6 h-6"></i>
    </button>

    @php
        if (Auth::check()) {
            $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count();
        } else {
            $jumlahKeranjang = count(session('keranjang', []));
        }
    @endphp

    <a href="{{ route('keranjang.index') }}" class="text-white-700 hover:text-gray-400 transition relative">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>

        <span id="cartBadge" class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5
        @if($jumlahKeranjang == 0) hidden @endif">
            {{ $jumlahKeranjang }}
        </span>
    </a>

    {{-- USER --}}
    <div class="relative">
        @auth
            <a href="{{ route('profile.edit') }}"
                class="text-white-700 hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="w-5 h-5"></i>
            </a>
        @else
            <button type="button" onclick="openLoginModal()"
                class="text-white-700 hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="w-5 h-5"></i>
            </button>
        @endauth
    </div>
</nav>

<style>
    /* Mobile styles only */
    @media (max-width: 768px) {
        .left-header span {
            font-size: 1.2rem;
        }

        .logo {
            font-size: 1rem;
            margin-left: 5.1rem;
            /* geser ke kanan */
            display: flex;
            align-items: center;
            gap: 0.25rem;
            /* beri jarak logo dan teks */
        }

        .logo-img {
            width: 1.2rem;
            height: 1.2rem;
        }

        .nav-icons {
            gap: 0.5rem;
            /* rapatkan sedikit */
        }

        /* semua ikon */
        .nav-icons i {
            width: 1rem;
            height: 1rem;
        }

        /* tombol a/button pembungkus ikon */
        .nav-icons a,
        .nav-icons button {
            width: 1.2rem;
            height: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        /* khusus ikon user */
        .nav-icons i[data-lucide="user"] {
            width: 0.9rem;
            height: 0.9rem;
            margin-right: 0;
            /* hapus margin berlebihan */
        }


        .absolute {
            width: 0.9rem;
            height: 0.9rem;
            font-size: 0.55rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const userBtn = document.getElementById("userBtn");
        const userDropdown = document.getElementById("userDropdown");

        if (userBtn && userDropdown) {
            userBtn.addEventListener("click", () => {
                userDropdown.classList.toggle("hidden");
            });

            document.addEventListener("click", (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add("hidden");
                }
            });
        }
    });
</script>