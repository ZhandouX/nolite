@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-users text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Kelola Pengguna
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Kelola status dan informasi pengguna aplikasi
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Pengguna -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="shrink-0 p-3 rounded-lg bg-blue-100 dark:bg-blue-900">
                            <i class="fa-solid fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pengguna Aktif -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="shrink-0 p-3 rounded-lg bg-green-100 dark:bg-green-900">
                            <i class="fa-solid fa-user-check text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['aktif'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pengguna Nonaktif -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="shrink-0 p-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                            <i class="fa-solid fa-user-slash text-gray-600 dark:text-gray-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nonaktif</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['nonaktif'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pengguna Diblokir -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="shrink-0 p-3 rounded-lg bg-red-100 dark:bg-red-900">
                            <i class="fa-solid fa-user-lock text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diblokir</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['diblokir'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Container -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all duration-300">
                <!-- Header Card -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center">
                            <i class="fa-solid fa-list text-primary-500 mr-2"></i>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mr-3">Daftar Pengguna</h4>
                        </div>

                        <!-- Form Pencarian -->
                        <form method="GET" class="flex-1 sm:max-w-md">
                            <div class="flex flex-cols gap-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                    placeholder="Cari pengguna...">
                                <button type="submit"
                                    class="bg-primary-500 px-4 py-3 rounded-xl text-white hover:bg-gray-500">
                                    <i data-lucide="search" class="w-5 h-5 stroke-[3]"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pengguna
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal Daftar
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users->where('id', '!=', auth()->id()) as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- Informasi Pengguna -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <i class="fa-solid fa-user text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    ID: {{ $user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ substr($user->email, 0, 3) . '***' . substr($user->email, strpos($user->email, '@')) }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->status == 'aktif')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                <i class="fa-solid fa-circle-check mr-1"></i>
                                                Aktif
                                            </span>
                                        @elseif($user->status == 'nonaktif')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                <i class="fa-solid fa-circle-pause mr-1"></i>
                                                Nonaktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                <i class="fa-solid fa-ban mr-1"></i>
                                                Diblokir
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Tanggal Daftar -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-calendar-day mr-1.5 text-gray-400"></i>
                                            {{ $user->created_at->format('d M Y') }}
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Tombol Lihat -->
                                            <button onclick="openModal('modal-{{ $user->id }}')"
                                                class="inline-flex items-center p-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                                title="Lihat Detail">
                                                <i class="fa-solid fa-eye text-blue-500"></i>
                                            </button>

                                            <!-- Action Buttons -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="inline-flex items-center p-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                                    title="Aksi Lainnya">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open" @click.away="open = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1" role="menu">
                                                        @if ($user->status == 'aktif')
                                                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST"
                                                                class="block" role="menuitem">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150">
                                                                    <i
                                                                        class="fa-solid fa-ban mr-2 w-4 h-4 text-yellow-500"></i>Blokir
                                                                    Pengguna
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.users.nonaktif', $user->id) }}"
                                                                method="POST" class="block" role="menuitem">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150">
                                                                    <i
                                                                        class="fa-solid fa-pause mr-2 w-4 h-4 text-gray-500"></i>Nonaktifkan
                                                                </button>
                                                            </form>
                                                        @elseif($user->status == 'nonaktif' || $user->status == 'diblokir')
                                                            <form action="{{ route('admin.users.activate', $user->id) }}"
                                                                method="POST" class="block" role="menuitem">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150">
                                                                    <i
                                                                        class="fa-solid fa-play mr-2 w-4 h-4 text-green-500"></i>Aktifkan
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <!-- Hapus -->
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus permanen pengguna ini?')"
                                                            class="border-t border-gray-200 dark:border-gray-600"
                                                            role="menuitem">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150">
                                                                <i class="fa-solid fa-trash mr-2 w-4 h-4"></i>Hapus Permanen
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div id="modal-{{ $user->id }}"
                                    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300 p-4">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300 scale-95"
                                        @click.away="closeModal('modal-{{ $user->id }}')">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                                <i class="fa-solid fa-user-circle text-primary-500 mr-2"></i>
                                                Detail Pengguna
                                            </h3>
                                            <button onclick="closeModal('modal-{{ $user->id }}')"
                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                                <i class="fa-solid fa-times text-xl"></i>
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <div class="flex items-center space-x-4">
                                                <div
                                                    class="shrink-0 h-12 w-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                    <i class="fa-solid fa-user text-primary-600 dark:text-primary-400"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $user->id }}</p>
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <div
                                                    class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                                    <span
                                                        class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</span>
                                                    <span
                                                        class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</span>
                                                </div>

                                                <div
                                                    class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                                                    <span
                                                        class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                            @if($user->status == 'aktif') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                                                            @elseif($user->status == 'nonaktif') bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                                                            @else 
                                                                                bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 
                                                                            @endif
                                                                            ">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </div>

                                                <div class="flex justify-between items-center py-2">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal
                                                        Daftar</span>
                                                    <span
                                                        class="text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                                <i class="fa-solid fa-user-slash text-gray-400 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                                Tidak ada pengguna ditemukan
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                                @if(request('search'))
                                                    Tidak ada hasil untuk pencarian "{{ request('search') }}"
                                                @else
                                                    Belum ada pengguna terdaftar di sistem
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel (Pagination) -->
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna
                            </div>
                            <div class="flex space-x-2">
                                @if($users->onFirstPage())
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-700 cursor-not-allowed">
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        Sebelumnya
                                    </a>
                                @endif

                                @if($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 transition-colors duration-200">
                                        Selanjutnya
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-primary-300 dark:bg-primary-800 cursor-not-allowed">
                                        Selanjutnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('[id^="modal-"]');
                modals.forEach(modal => {
                    if (modal.classList.contains('flex')) {
                        closeModal(modal.id);
                    }
                });
            }
        });
    </script>

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('fade-in');
            });
        });
    </script>
@endsection