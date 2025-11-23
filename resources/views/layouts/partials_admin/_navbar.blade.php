<header id="navbar"
  class="fixed top-0 right-0 left-0 bg-black dark:bg-gray-800 shadow-sm border-b border-gray-700 dark:border-gray-700 z-50 transition-colors duration-300">
  <div class="flex items-center justify-between px-6 py-4 md:py-[17px]">
    <div class="flex items-center">
      <!-- Mobile Menu Toggle -->
      <button id="mobile-menu-toggle"
        class="mr-4 text-gray-300 dark:text-gray-400 md:hidden p-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200 -ml-4">
        <i data-lucide="panel-left-close" class="toggle-mobile w-[15px] h-[15px] md:w-5 md:h-5"></i>
      </button>

      <!-- LOGO -->
      <div class="brand-nav hidden md:flex items-center justify-between p-0 mr-6">
        <div class="flex items-center space-x-3">
          <div class="relative">
            <div
              class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-400 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-cyan-400/30 animate-pulse-slow">
              <div
                class="absolute inset-0 rounded-2xl bg-gradient-to-br from-cyan-400 via-purple-500 to-pink-500 blur-sm opacity-75">
              </div>
              <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo"
                class="w-8 h-8 rounded-lg relative z-10">
            </div>
          </div>
          <div>
            <h1 class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent">
              NoliteAspiciens</h1>
            <p class="text-xs text-gray-300 dark:text-gray-400 font-light">Admin Panel</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex items-center space-x-3">
      <!-- Search Button for Mobile -->
      <button id="mobile-search-toggle"
        class="md:hidden p-2 rounded-full hover:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-300 dark:text-gray-400">
        <i data-lucide="search" class="w-[13px] h-[13px]"></i>
      </button>

      <!-- Search Bar -->
      <div class="relative hidden md:block">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <i data-lucide="search" class="h-5 w-5 text-gray-400 stroke-[3]"></i>
        </div>
        <input type="text"
          class="pl-10 pr-4 py-2 w-64 lg:w-80 border border-gray-600 dark:border-gray-600 rounded-tl-xl rounded-br-xl bg-gray-800 dark:bg-gray-700 text-white dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
          placeholder="Cari sesuatu...">
      </div>

      <!-- Toggle Dark/Light Mode -->
      <button id="theme-toggle"
        class="p-2 rounded-full hover:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200 group relative">
        <span id="theme-icon-light" class="">
          <i data-lucide="sun" class="w-[15px] h-[15px] md:w-5 md:h-5 text-gray-300 dark:text-gray-400"></i>
        </span>
        <span id="theme-icon-dark" class="hidden">
          <i data-lucide="moon" class="w-[15px] h-[15px] md:w-5 md:h-5 text-gray-300 dark:text-gray-400"></i>
        </span>
        <span
          class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
          Toggle Theme
        </span>
      </button>

      {{-- NOFIFICATIONS --}}
      <div class="relative" x-data="{ open: false }">
        <!-- Tombol badge -->
        <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-700 relative group">
          <i data-lucide="bell" class="w-5 h-5 text-gray-300 dark:text-gray-400"></i>
          <span id="notif-count"
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full hidden">0</span>
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition
          class="absolute right-0 mt-2 w-80 bg-gray-800 dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
          <div class="p-4 border-b border-gray-700 dark:border-gray-700">
            <h3 class="text-center text-lg font-semibold text-white dark:text-white">Notifikasi</h3>
          </div>

          <!-- Notification Items -->
          <div class="max-h-96 overflow-y-auto" id="notification-list">
            <div class="p-4 text-center text-sm text-gray-300 dark:text-gray-400">Memuat...</div>
          </div>

          <!-- Footer -->
          <div class="p-4 border-t border-gray-700 dark:border-gray-700">
            <a href="javascript:void(0)" @click="$dispatch('open-notif-modal')"
              class="block text-center text-sm text-primary-500 dark:text-primary-500 hover:text-primary-300 dark:hover:text-primary-300 transition-colors duration-200">
              Lihat semua notifikasi
            </a>
          </div>
        </div>
      </div>
      <!-- MODAL NOTIFICATION CENTER -->
      <div 
  id="notificationsAll" 
  x-data="notifCenter()" 
  @open-notif-modal.window="openModal"
>

        <!-- Backdrop -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm z-40"
          @click="open = false"></div>

        <!-- Modal -->
        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="bg-white dark:bg-gray-900 w-full max-w-4xl rounded-xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
              <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Pusat Notifikasi
              </h2>
              <button @click="open = false">
                <i data-lucide="x" class="w-5 h-5 text-gray-500 dark:text-gray-300"></i>
              </button>
            </div>

            <!-- Content -->
            <div
              class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x border-gray-200 dark:divide-gray-700">

              <!-- COLUMN ORDER -->
              <div class="p-4 max-h-[70vh] overflow-y-auto">
                <h3 class="text-md font-semibold mb-2 text-gray-800 dark:text-gray-200">Pesanan Baru</h3>

                <template x-if="order.length === 0">
                  <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada pesanan baru</p>
                </template>

                <template x-for="o in order" :key="o.id">
                  <div class="p-3 rounded-lg border mb-3 border-gray-200 dark:border-gray-700">
                    <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="o.customer"></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1" x-text="o.products"></p>

                    <!-- LINK KE DETAIL ORDER -->
                    <a :href="o.url" class="text-primary-600 dark:text-primary-400 text-sm mt-2 inline-block">
                      Lihat detail →
                    </a>
                  </div>
                </template>
              </div>

              <!-- COLUMN CHAT -->
              <div class="p-4 max-h-[70vh] overflow-y-auto">
                <h3 class="text-md font-semibold mb-2 text-gray-800 dark:text-gray-200">Chat Masuk</h3>

                <template x-if="chat.length === 0">
                  <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada chat baru</p>
                </template>

                <template x-for="c in chat" :key="c.id">
                  <div class="p-3 rounded-lg border mb-3 border-gray-200 dark:border-gray-700">
                    <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="c.name"></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1" x-text="c.message"></p>

                    <!-- LINK KE CHAT -->
                    <a :href="c.url" class="text-primary-600 dark:text-primary-400 text-sm mt-2 inline-block">
                      Buka chat →
                    </a>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- User Menu -->
      <div class="relative" x-data="{ open: false }">
        @php
          $user = Auth::user();
          $name = $user->name ?? 'User';
          $initials = collect(explode(' ', $name))->map(fn($w) => substr($w, 0, 1))->join('');
        @endphp

        <button @click="open = !open" id="user-menu-button"
          class="flex items-center -mr-4 lg:mr-0 text-sm rounded-2xl focus:outline-none transition-all duration-300 group p-1.5 bg-transparent">

          <!-- Avatar Inisial -->
          <div
            class="h-8 w-8 flex items-center justify-center rounded-full font-bold text-white uppercase bg-gradient-to-br from-cyan-400 to-purple-500 shadow-lg shadow-cyan-400/30 group-hover:scale-110 transition-transform duration-300">
            {{ $initials }}
          </div>

          <!-- Nama -->
          <span class="ml-2 text-sm font-semibold text-white dark:text-white hidden md:block">
            {{ $name }}
          </span>

          <!-- Ikon Panah -->
          <i data-lucide="chevron-down"
            class=" hidden lg:flex ml-1 h-4 w-4 text-cyan-400 group-hover:rotate-180 transition-transform duration-300"></i>
        </button>

        <!-- User Menu Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95"
          class="absolute right-0 mt-2 w-56 bg-gray-800/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-2xl ring-1 ring-gray-700/20 dark:ring-gray-700/20 z-50 overflow-hidden border border-gray-600/20 dark:border-gray-600/20">
          <div class="p-4 border-b border-gray-700/20 dark:border-gray-700/20">
            <div class="flex items-center">
              <div
                class="h-10 w-10 rounded-full bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center text-white font-bold uppercase shadow-lg shadow-cyan-400/30">
                {{ $initials }}
              </div>
              <div class="ml-3">
                <p class="text-sm font-semibold text-white dark:text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-300 dark:text-gray-400">{{ Auth::user()->email }}</p>
              </div>
            </div>
          </div>
          <div class="py-2">
            <a href="{{ route('profile.profile-admin') }}"
              class="flex items-center px-4 py-2.5 text-sm text-gray-300 dark:text-gray-300 hover:bg-cyan-400/10 hover:text-cyan-400 dark:hover:text-cyan-400 transition-all duration-300 group">
              <i data-lucide="circle-user-round"
                class="mr-3 h-4 w-4 text-cyan-400 group-hover:scale-110 transition-transform duration-300"></i>
              Profile
            </a>
            <a href="#"
              class="flex items-center px-4 py-2.5 text-sm text-gray-300 dark:text-gray-300 hover:bg-purple-400/10 hover:text-purple-400 dark:hover:text-purple-400 transition-all duration-300 group">
              <i data-lucide="settings"
                class="mr-3 h-4 w-4 text-purple-400 group-hover:scale-110 transition-transform duration-300"></i>
              Settings
            </a>
          </div>
          <div class="py-2 border-t border-gray-700/20 dark:border-gray-700/20">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="flex items-center px-4 py-2.5 w-full text-sm text-rose-400 hover:bg-rose-400/10 transition-all duration-300 group">
                <i data-lucide="log-out"
                  class="mr-3 h-4 w-4 text-rose-400 group-hover:scale-110 transition-transform duration-300"></i>
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Search Bar -->
  <div id="mobile-search" class="md:hidden px-4 pb-4 hidden">
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
      </div>
      <input type="text"
        class="pl-10 pr-4 py-2 w-full border border-gray-600 dark:border-gray-600 rounded-lg bg-gray-800 dark:bg-gray-700 text-white dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
        placeholder="Cari sesuatu...">
    </div>
  </div>
</header>