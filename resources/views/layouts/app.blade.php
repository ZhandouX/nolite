<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .sidebar-transition {
                transition: all 0.3s ease;
            }
            .chart-loading {
                opacity: 0;
                transform: translateY(10px);
                transition: opacity 0.5s ease, transform 0.5s ease;
            }
            .chart-loaded {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @stack('style')

    <!-- DATEPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- FLATPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="flex h-full">
        <!-- Sidebar -->
        @include('layouts.partials_admin._sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            @include('layouts.partials_admin._navbar')

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                <!-- Statistik -->
                @yield('content')

            </main>
        </div>
    </div>
    {{-- FOOTER --}}
    @include('layouts.partials_admin._footer')

    {{-- JAVASCRIPT NEWS STATISTIC --}}
    @isset($newsPerMonth)
        <script>
            var newsPerMonth = @json($newsPerMonth->values());
        </script>
        <script src="/assets/js/dashboard-chart.js"></script>
    @endisset

    {{-- MOMENT & DATEPICKR --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');

            // Sembunyikan teks di sidebar ketika dikompres
            const sidebarTexts = sidebar.querySelectorAll('span, .sidebar-text, p, h1');
            sidebarTexts.forEach(text => {
                text.classList.toggle('hidden');
            });

            // Sembunyikan info pengguna ketika dikompres
            // const userInfo = sidebar.querySelector('.ml-3');
            // if (userInfo) userInfo.classList.toggle('hidden');

            // Animasi Toggle button (rotate icon)
            const toggleIcon = sidebarToggle.querySelector('.toggle-desktop');
            if (sidebar.classList.contains('w-20')) {
                toggleIcon.style.transform = 'rotate(180deg)'; // saat sidebar ditutup
            } else {
                toggleIcon.style.transform = 'rotate(0deg)'; // saat sidebar dibuka
            }
        });

        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');

            // Sembunyikan teks di sidebar ketika dikompres
            const sidebarTexts = sidebar.querySelectorAll('span, .sidebar-text, p, h1');
            sidebarTexts.forEach(text => {
                text.classList.toggle('hidden');
            });

            // Sembunyikan info pengguna ketika dikompres
            // const userInfo = sidebar.querySelector('.ml-3');
            // if (userInfo) userInfo.classList.toggle('hidden');

            // Animasi Toggle button (rotate icon)
            const toggleIcon = mobileMenuToggle.querySelector('.toggle-mobile');
            if (sidebar.classList.contains('w-20')) {
                toggleIcon.style.transform = 'rotate(180deg)'; // saat sidebar ditutup
            } else {
                toggleIcon.style.transform = 'rotate(0deg)'; // saat sidebar dibuka
            }
        });

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
    </script>

    <!-- Script Modal -->
    <script>
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
    </script>

    <script>
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
    </script>

    @stack('scripts')
</body>

</html>