<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @stack('style')

    <style>
        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>

    <!-- DATEPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- FLATPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
</head>

<body class="h-full bg-gray-200 dark:bg-gray-900 transition-colors duration-300 pt-20">
    <div class="flex h-full">

        <!-- Sidebar -->
        @include('layouts.partials_admin._sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- TOGGLE -->
            <div class="hidden md:flex items-center fixed top-20 left-18 z-50">
                <button id="sidebar-toggle"
                    class="hidden md:flex bg-gray-200 dark:bg-gray-800 text-gray-500 dark:text-gray-400 p-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-br-lg">
                    <i data-lucide="panel-left-close" class="toggle-desktop w-5 h-5"></i>
                </button>
            </div>
            <!-- Navbar -->
            @include('layouts.partials_admin._navbar')

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 hide-scrollbar">
                <div class="p-6">
                    @yield('content')
                </div>

                <div class="flex flex-col bg-gray-200 dark:bg-gray-800 px-6 py-3 border-t-2 border-gray-500">
                    <div class="grid grid-cols-2">
                        <p class="text-xs text-left text-gray-700 dark:text-gray-300">Nolite Aspiciens</p>
                        <span class="text-xs text-right text-gray-700 dark:text-gray-300">&copy; {{ date('Y') }}. All rights reserved.</span>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    {{-- JAVASCRIPT NEWS STATISTIC --}}
    @isset($newsPerMonth)
        <script>
            var newsPerMonth = @json($newsPerMonth->values());
        </script>
        <script src="/assets/js/dashboard.js"></script>
    @endisset

    {{-- MOMENT & DATEPICKR --}}
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    {{-- NOTIFICATIONS --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notifCount = document.getElementById('notif-count');
            const notifList = document.getElementById('notification-list');

            function updateNotifications() {
                axios.get("{{ route('admin.notifications') }}")
                    .then(res => {
                        const notifications = res.data.notifications;

                        // Hitung total
                        let total = 0;
                        notifications.forEach(n => total += n.count);

                        // Update badge
                        if (total > 0) {
                            notifCount.textContent = total;
                            notifCount.classList.remove('hidden');
                        } else {
                            notifCount.classList.add('hidden');
                        }

                        // Update dropdown
                        notifList.innerHTML = '';
                        notifications.forEach(n => {
                            if (n.count > 0) {
                                notifList.insertAdjacentHTML('beforeend', `
                            <a href="${n.url}" class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-${n.color}-100 dark:bg-${n.color}-900 flex items-center justify-center">
                                    <i data-lucide="${n.icon}" class="h-5 w-5 text-${n.color}-600 dark:text-${n.color}-400"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${n.title}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${n.message}</p>
                                </div>
                            </a>
                        `);
                            }
                        });

                        if (total === 0) {
                            notifList.innerHTML = `<div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru</div>`;
                        }

                        // Render Lucide icons
                        window.createIcons({ icons: window.lucideIcons });
                    })
                    .catch(err => console.error(err));
            }

            // Polling setiap 10 detik
            updateNotifications();
            setInterval(updateNotifications, 10000);
        });
    </script>

    {{-- SIDEBAR & THEMES TOGGLE --}}
    <script>
        // Toggle Sidebar Mobile
        const sidebar = document.getElementById('sidebar');
        // const navbar = document.getElementById('navbar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        // Mobile toggle
        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });

        // Close sidebar on mobile
        sidebarClose.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Desktop toggle (untuk mode collapsed)
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('md:w-64');
                sidebar.classList.toggle('md:w-20');

                // Sembunyikan teks di sidebar
                const sidebarTexts = sidebar.querySelectorAll('span, .sidebar-text, p, h1');
                sidebarTexts.forEach(text => text.classList.toggle('hidden'));

                // Sembunyikan brand logo/header
                // const navbarBrand = document.querySelectorAll('.brand-nav');
                // navbarBrand.forEach(brand => brand.classList.toggle('md:hidden'));

                // Animasi Toggle button (rotate icon)
                const toggleIcon = sidebarToggle.querySelector('.toggle-desktop');
                if (sidebar.classList.contains('md:w-20')) {
                    toggleIcon.style.transform = 'rotate(180deg)'; // saat sidebar ditutup
                } else {
                    toggleIcon.style.transform = 'rotate(0deg)'; // saat sidebar dibuka
                }
            });
        }

        // Toggle Tema Gelap/Terang
        const themeToggle = document.getElementById('theme-toggle');
        const themeIconLight = document.getElementById('theme-icon-light');
        const themeIconDark = document.getElementById('theme-icon-dark');

        // Periksa preferensi tema yang disimpan atau gunakan preferensi sistem
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            themeIconLight.classList.add('hidden');
            themeIconDark.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            themeIconLight.classList.remove('hidden');
            themeIconDark.classList.add('hidden');
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');

            if (document.documentElement.classList.contains('dark')) {
                localStorage.theme = 'dark';
                themeIconLight.classList.add('hidden');
                themeIconDark.classList.remove('hidden');
            } else {
                localStorage.theme = 'light';
                themeIconLight.classList.remove('hidden');
                themeIconDark.classList.add('hidden');
            }
        });

        // Close sidebar when clicking a link on mobile
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) { // Mobile
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- Script Modal -->
    <!-- <script>
        const pesananButton = document.getElementById('pesananButton');
        const pesananModal = document.getElementById('pesananModal');
        const closeModal = document.getElementById('closeModal');

        pesananButton.addEventListener('click', () => {
            pesananModal.classList.remove('hidden');
            pesananModal.classList.add('flex');
        });

        closeModal.addEventListener('click', () => {
            pesananModal.classList.remove('flex');
            pesananModal.classList.add('hidden');
        });

        pesananModal.addEventListener('click', (e) => {
            if (e.target === pesananModal) {
                pesananModal.classList.remove('flex');
                pesananModal.classList.add('hidden');
            }
        });
    </script> -->

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dateInput = document.querySelector("#news-date-filter");

            const fp = flatpickr(dateInput, {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id",
                allowInput: true,

                onReady: function (selectedDates, dateStr, instance) {
                    if (document.body.getAttribute("data-bs-theme") === "dark") {
                        instance.calendarContainer.classList.add("flatpickr-dark");
                    }
                },

                onClose: function (selectedDates, dateStr, instance) {
                    let baseUrl = "{{ route('admin.dashboard') }}";
                    let url = new URL(baseUrl, window.location.origin);

                    if (selectedDates.length === 1) {
                        url.searchParams.set("date", instance.formatDate(selectedDates[0], "Y-m-d"));
                    } else if (selectedDates.length === 2) {
                        url.searchParams.set("start_date", instance.formatDate(selectedDates[0], "Y-m-d"));
                        url.searchParams.set("end_date", instance.formatDate(selectedDates[1], "Y-m-d"));
                    }

                    if (selectedDates.length > 0) {
                        window.location.href = url.toString();
                    }
                }
            });

            const observer = new MutationObserver(() => {
                if (document.body.getAttribute("data-bs-theme") === "dark") {
                    fp.calendarContainer.classList.add("flatpickr-dark");
                } else {
                    fp.calendarContainer.classList.remove("flatpickr-dark");
                }
            });

            observer.observe(document.body, { attributes: true, attributeFilter: ["data-bs-theme"] });
        });
    </script> -->

    @stack('scripts')
</body>

</html>