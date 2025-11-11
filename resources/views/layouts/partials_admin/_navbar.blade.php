<header
  class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 z-50 transition-colors duration-300">
  <div class="flex items-center justify-between px-6 py-7 lg:py-[25px]">
    <div class="flex items-center">
      <!-- Mobile Menu Toggle -->
      <button id="mobile-menu-toggle"
        class="mr-4 text-gray-500 dark:text-gray-400 lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 -ml-4">
        <i data-lucide="list-indent-decrease" class="toggle-mobile w-5 h-5"></i>
      </button>

      <button id="sidebar-toggle"
        class="hidden lg:flex bg-white/10 text-gray-500 dark:text-gray-400 p-2 mr-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-500">
        <i data-lucide="list-indent-decrease" class="toggle-desktop w-5 h-5"></i>
      </button>

      <!-- Search Bar -->
      <div class="relative hidden md:block">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text"
          class="pl-10 pr-4 py-2 w-64 lg:w-80 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
          placeholder="Cari sesuatu...">
      </div>
    </div>

    <!-- Page Title for Mobile -->
    <!-- <div class="md:hidden">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Nolite Aspiciens</h2>
    </div> -->

    <div class="flex items-center space-x-3">
      <!-- Search Button for Mobile -->
      <button id="mobile-search-toggle"
        class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-500 dark:text-gray-400">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>

      <!-- Toggle Dark/Light Mode -->
      <button id="theme-toggle"
        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group relative">
        <svg id="theme-icon-light" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
            clip-rule="evenodd" />
        </svg>
        <svg id="theme-icon-dark" xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 text-gray-500 dark:text-gray-400 hidden" viewBox="0 0 20 20" fill="currentColor">
          <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
        <span
          class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
          Toggle Theme
        </span>
      </button>

      <!-- Notifications -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
          class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 relative group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20"
            fill="currentColor">
            <path
              d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
          </svg>
          <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
          <span
            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
            Notifications
          </span>
        </button>

        <!-- Notifications Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95"
          class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
          <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
              <span
                class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-xs px-2 py-1 rounded-full">3
                new</span>
            </div>
          </div>
          <div class="max-h-96 overflow-y-auto">
            <!-- Notification Items -->
            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
              <div
                class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">New order received</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Order #1234 has been placed</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">2 minutes ago</p>
              </div>
            </a>

            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
              <div
                class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Payment confirmed</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Payment for order #1234 has been confirmed</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">1 hour ago</p>
              </div>
            </a>

            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
              <div
                class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Low stock alert</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Product "T-Shirt Basic" is running low</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">5 hours ago</p>
              </div>
            </a>
          </div>
          <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="#"
              class="block text-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-200">
              View all notifications
            </a>
          </div>
        </div>
      </div>

      <!-- Messages -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
          class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 relative group">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
          <span
            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
            Messages
          </span>
        </button>

        <!-- Messages Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95"
          class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
          <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Messages</h3>
          </div>
          <div class="max-h-96 overflow-y-auto">
            <!-- Message Items -->
            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
              <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                  src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="Sarah Johnson">
              </div>
              <div class="ml-3 flex-1">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Sarah Johnson</p>
                  <span class="text-xs text-gray-500 dark:text-gray-400">10:24 AM</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">Hi, I have a question about my
                  order...</p>
              </div>
            </a>

            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
              <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                  src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="Michael Chen">
              </div>
              <div class="ml-3 flex-1">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Michael Chen</p>
                  <span class="text-xs text-gray-500 dark:text-gray-400">Yesterday</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">The product arrived damaged, can I get
                  a replacement?</p>
              </div>
            </a>

            <a href="#"
              class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
              <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                  src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt="Emily Rodriguez">
              </div>
              <div class="ml-3 flex-1">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Emily Rodriguez</p>
                  <span class="text-xs text-gray-500 dark:text-gray-400">2 days ago</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">Thanks for the quick shipping!</p>
              </div>
            </a>
          </div>
          <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="#"
              class="block text-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-200">
              View all messages
            </a>
          </div>
        </div>
      </div>

      <!-- User Menu -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" id="user-menu-button"
          class="flex items-center text-sm rounded-full focus:outline-none transition-colors duration-200 group">
          <img
            class="h-8 w-8 rounded-full border-2 border-transparent group-hover:border-primary-500 transition-colors duration-200"
            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
            alt="Profile">
          <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">Admin User</span>
          <svg class="ml-1 h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- User Menu Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95"
          class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
          <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
              <img class="h-10 w-10 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="Profile">
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Admin User</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">admin@example.com</p>
              </div>
            </div>
          </div>
          <div class="py-1">
            <a href="#"
              class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
              <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profile
            </a>
            <a href="#"
              class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
              <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Settings
            </a>
            <a href="#"
              class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
              <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Support
            </a>
          </div>
          <div class="py-1 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="flex items-center px-4 py-2 w-full text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                <svg class="mr-3 h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
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
        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text"
        class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
        placeholder="Cari sesuatu...">
    </div>
  </div>
</header>

<script>
  // Mobile search toggle
  document.getElementById('mobile-search-toggle').addEventListener('click', function () {
    const mobileSearch = document.getElementById('mobile-search');
    mobileSearch.classList.toggle('hidden');
  });
</script>