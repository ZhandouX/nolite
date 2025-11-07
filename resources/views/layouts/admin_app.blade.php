<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nolite Shop</title>

    {{-- LIBRARY CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/select.dataTables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')

    {{-- THEMES --}}
    <link rel="stylesheet" href="{{ asset('assets/css/themes/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themes/light.css') }}">

    <!-- DATEPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- FLATPICKR CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

</head>

<body class="with-welcome-text">
    <div class="container-scroller">

        {{-- NAVBAR --}}
        @include('layouts.partials_admin.navbar')

        <div class="container-fluid page-body-wrapper">

            {{-- SIDEBAR --}}
            @include('layouts.partials_admin.sidebar')

            {{-- PARTIALS CONTENTS --}}
            <div class="main-panel">
                {{-- MAIN PANEL --}}
                @include('layouts.partials_admin.main-panel')

                {{-- FOOTER --}}
                @include('layouts.partials_admin.footer')
            </div>
        </div>

        {{-- SPINNER ICON --}}
        @include('layouts.partials_admin.spinner-setting')

        <!-- Floating Button Pesanan Menunggu -->
        <button id="pesananButton"
            class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-500 text-white rounded-full shadow-xl flex items-center gap-3 pl-4 pr-5 py-3 transition-all duration-300 group z-[9999]">

            <div class="relative">
                <i class="fa-solid fa-bell text-2xl"></i>

                {{-- Badge di atas ikon --}}
                @if (!empty($jumlahMenunggu) && $jumlahMenunggu > 0)
                    <span
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-full shadow">
                        {{ $jumlahMenunggu }}
                    </span>
                @endif
            </div>

            <span class="text-sm font-medium tracking-wide">Pesanan Terbaru</span>
        </button>

        {{-- Tooltip teks saat hover --}}
        <span
            class="absolute right-16 bg-gray-800 text-white text-sm rounded-lg py-1.5 px-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap shadow-lg">
            Pesanan Menunggu
        </span>
        </button>

        <!-- Modal Pesanan Menunggu -->
        @include('layouts.partials_admin.modals.order')
    </div>

    {{-- LIBRARY JAVASCRIPT --}}
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

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

    {{-- TOGGLE THEME --}}
    <script src="{{ asset('assets/js/toggle-theme.js') }}"></script>

    {{-- JAVASCRIPT NEWS STATISTIC --}}
    @isset($newsPerMonth)
        <script>
            var newsPerMonth = @json($newsPerMonth->values());
        </script>
        <script src="{{ asset('assets/js/dashboard-chart.js') }}"></script>
    @endisset

    {{-- MOMENT & DATEPICKR --}}
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

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
