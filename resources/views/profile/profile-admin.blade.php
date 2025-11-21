@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-screen mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg mb-4">
                    <i class="fa-solid fa-user-gear text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Pengaturan Profil</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Kelola informasi akun Anda dan pertahankan keamanan profil
                </p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                <!-- Sidebar Navigation -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="relative bg-gradient-to-r from-gray-900 via-blue-900 to-purple-900 h-20">
                            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 border-4 border-white dark:border-gray-800 shadow-xl flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-14 pb-6 px-6 text-center">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Auth::user()->email }}</p>
                            <div class="inline-flex items-center bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[10px] px-3 py-1.5 rounded-full font-medium">
                                <i class="fa-regular fa-calendar mr-1.5"></i>
                                Bergabung {{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 px-1 py-4">
                        <nav class="space-y-2">
                            <button onclick="openModals('updateProfileModal')" 
                                class="w-full flex items-center px-4 py-4 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all duration-300 group border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-user-pen text-blue-600 dark:text-blue-400 text-lg"></i>
                                </div>
                                <div class="text-left flex-1">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">Edit Profil</div>
                                    <div class="text-[10px] text-gray-500 dark:text-gray-400">Ubah informasi pribadi</div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                            </button>

                            <button onclick="openModals('updatePasswordModal')" 
                                class="w-full flex items-center px-4 py-4 text-gray-700 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition-all duration-300 group border border-transparent hover:border-amber-200 dark:hover:border-amber-800">
                                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-lock text-amber-600 dark:text-amber-400 text-lg"></i>
                                </div>
                                <div class="text-left flex-1">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">Keamanan</div>
                                    <div class="text-[10px] text-gray-500 dark:text-gray-400">Perbarui kata sandi</div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-amber-500 transition-colors"></i>
                            </button>

                            <!-- <button onclick="openDeleteModal()" 
                                class="w-full flex items-center px-4 py-4 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-300 group border border-transparent hover:border-red-200 dark:hover:border-red-800">
                                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-regular fa-trash-can text-red-600 dark:text-red-400 text-lg"></i>
                                </div>
                                <div class="text-left flex-1">
                                    <div class="text-sm font-semibold">Hapus Akun</div>
                                    <div class="text-[10px] text-red-500 dark:text-red-400">Hapus permanen akun</div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-red-400 group-hover:text-red-500 transition-colors"></i>
                            </button> -->

                            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="border-t border-gray-400 dark:border-white/20">
                                @csrf
                                <button type="submit" 
                                    class="w-full flex items-center px-4 py-4 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-300 group border border-transparent hover:border-gray-200 dark:hover:border-gray-600 mt-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-right-from-bracket text-gray-600 dark:text-gray-400 text-lg"></i>
                                    </div>
                                    <div class="text-left flex-1">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Keluar</div>
                                        <div class="text-[10px] text-gray-500 dark:text-gray-400">Logout dari akun</div>
                                    </div>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="xl:col-span-3 space-y-8">
                    <!-- Account Overview -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Ringkasan Akun</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">Tinjau status dan informasi akun Anda</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                <i class="fa-solid fa-chart-pie text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Akun</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                                            @if($user->status === 'aktif')
                                                <span class="flex items-center gap-2 text-green-600 dark:text-green-400">
                                                    <i class="fa-solid fa-circle-check"></i> Aktif
                                                </span>
                                            @elseif($user->status === 'nonaktif')
                                                <span class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                                    <i class="fa-solid fa-circle-xmark"></i> Nonaktif
                                                </span>
                                            @else
                                                <span class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                    <i class="fa-solid fa-circle-question"></i> Tidak Diketahui
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    @if($user->status === 'aktif')
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                                            <i class="fa-solid fa-check text-white text-2xl"></i>
                                        </div>
                                    @elseif($user->status === 'nonaktif')
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-red-500 to-rose-600 flex items-center justify-center shadow-lg">
                                            <i class="fa-solid fa-xmark text-white text-2xl"></i>
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-2xl bg-gray-400 flex items-center justify-center shadow-lg">
                                            <i class="fa-solid fa-question text-white text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Member Since Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Member Sejak</p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                                            {{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                        </p>
                                    </div>
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                        <i class="fa-regular fa-clock text-white text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Status -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Status Keamanan</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">Tinjau dan tingkatkan keamanan akun Anda</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                                <i class="fa-solid fa-shield-halved text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Email Verification -->
                            <div class="flex items-center justify-between p-6 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900/20 rounded-2xl border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-envelope-circle-check text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">Verifikasi Email</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pastikan email Anda sudah terverifikasi</p>
                                    </div>
                                </div>
                                @if($user->hasVerifiedEmail())
                                    <span class="px-4 py-2 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 text-sm rounded-full font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-check"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-sm rounded-full font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-exclamation"></i> Belum Verifikasi
                                    </span>
                                @endif
                            </div>

                            <!-- Password Strength -->
                            <div class="flex items-center justify-between p-6 bg-gradient-to-r from-gray-50 to-amber-50 dark:from-gray-700 dark:to-amber-900/20 rounded-2xl border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-bolt text-amber-600 dark:text-amber-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">Kekuatan Kata Sandi</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Perbarui kata sandi secara berkala</p>
                                    </div>
                                </div>
                                <button onclick="openModals('updatePasswordModal')"
                                    class="px-6 py-3 bg-gray-900 dark:bg-gray-700 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    Perbarui Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE PROFILE -->
    <div id="updateProfileModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto hide-scrollbar">
            <!-- Header -->
            <div class="bg-gradient-to-r from-gray-900 to-blue-900 p-8 rounded-t-2xl sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fa-solid fa-user-pen text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Update Profil</h2>
                            <p class="text-blue-200 text-sm mt-1">Kelola informasi akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeModals('updateProfileModal')" class="text-white/80 hover:text-white transition-colors p-2">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
                    @csrf
                    @method('patch')

                    <!-- Name Field -->
                    <div class="space-y-4">
                        <label for="name" class="block text-lg font-semibold text-gray-900 dark:text-white">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg"
                                placeholder="Masukkan nama lengkap">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <i class="fa-solid fa-circle-check text-green-500 opacity-0 transition-opacity duration-300 text-xl"
                                    id="name-check"></i>
                            </div>
                        </div>
                        @error('name')
                            <div class="flex items-center gap-3 text-base text-red-600 dark:text-red-400 mt-3 bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-4">
                        <label for="email" class="block text-lg font-semibold text-gray-900 dark:text-white">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg"
                                placeholder="Masukkan alamat email">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <i class="fa-solid fa-circle-check text-green-500 opacity-0 transition-opacity duration-300 text-xl"
                                    id="email-check"></i>
                            </div>
                        </div>
                        @error('email')
                            <div class="flex items-center gap-3 text-base text-red-600 dark:text-red-400 mt-3 bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-6 p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-2xl text-base text-amber-800 dark:text-amber-300">
                                <div class="flex items-start gap-4">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xl mt-1"></i>
                                    <div>
                                        <p class="font-semibold">Email Anda belum terverifikasi</p>
                                        <button form="send-verification"
                                            class="mt-3 text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300 transition font-semibold flex items-center gap-3">
                                            <i class="fa-solid fa-paper-plane"></i>
                                            Kirim ulang email verifikasi
                                        </button>

                                        @if (session('status') === 'verification-link-sent')
                                            <div class="mt-3 flex items-center gap-3 text-green-600 dark:text-green-400 font-semibold">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Link verifikasi baru telah dikirim ke email Anda
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-6 pt-6">
                        <button type="submit"
                            class="px-8 py-4 bg-primary-500 text-white text-lg font-semibold rounded-2xl hover:bg-gray-400 active:scale-[0.98] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-3">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="flex items-center gap-3 text-base text-green-600 dark:text-green-400 font-semibold bg-green-50 dark:bg-green-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-check"></i> Profil berhasil diperbarui
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE PASSWORD -->
    <div id="updatePasswordModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto hide-scrollbar">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-900 to-gray-900 p-8 rounded-t-2xl sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fa-solid fa-lock text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Perbarui Kata Sandi</h2>
                            <p class="text-amber-200 text-sm mt-1">Tingkatkan keamanan akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeModals('updatePasswordModal')" class="text-white/80 hover:text-white transition-colors p-2">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">
                <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div class="space-y-4">
                        <label for="current_password" class="block text-lg font-semibold text-gray-900 dark:text-white">
                            Kata Sandi Saat Ini
                        </label>
                        <div class="relative">
                            <input id="current_password" name="current_password" type="password" required
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg pr-16"
                                placeholder="Masukkan kata sandi saat ini">
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-6 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                                onclick="togglePasswordVisibility('current_password', this)">
                                <i class="fa-regular fa-eye text-xl"></i>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <div class="flex items-center gap-3 text-base text-red-600 dark:text-red-400 mt-3 bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="space-y-4">
                        <label for="password" class="block text-lg font-semibold text-gray-900 dark:text-white">
                            Kata Sandi Baru
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg pr-16"
                                placeholder="Masukkan kata sandi baru">
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-6 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                                onclick="togglePasswordVisibility('password', this)">
                                <i class="fa-regular fa-eye text-xl"></i>
                            </button>
                        </div>

                        <!-- Password Strength -->
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between text-base">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Kekuatan kata sandi:</span>
                                <span id="password-strength-text" class="font-semibold">Sangat Lemah</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3">
                                <div id="password-strength-bar"
                                    class="h-3 rounded-full bg-red-500 transition-all duration-500" style="width:0%"></div>
                            </div>
                        </div>

                        @error('password', 'updatePassword')
                            <div class="flex items-center gap-3 text-base text-red-600 dark:text-red-400 mt-3 bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-4">
                        <label for="password_confirmation" class="block text-lg font-semibold text-gray-900 dark:text-white">
                            Konfirmasi Kata Sandi Baru
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg pr-16"
                                placeholder="Konfirmasi kata sandi baru">
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-6 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                                onclick="togglePasswordVisibility('password_confirmation', this)">
                                <i class="fa-regular fa-eye text-xl"></i>
                            </button>
                        </div>

                        <!-- Password Match Indicator -->
                        <div id="password-match"
                            class="hidden flex items-center gap-3 text-base text-green-600 dark:text-green-400 mt-3 bg-green-50 dark:bg-green-900/20 px-4 py-3 rounded-xl">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Kata Sandi cocok!</span>
                        </div>

                        @error('password_confirmation', 'updatePassword')
                            <div class="flex items-center gap-3 text-base text-red-600 dark:text-red-400 mt-3 bg-red-50 dark:bg-red-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Requirements -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-2xl border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                            <i class="fa-solid fa-shield-alt text-amber-500"></i>
                            Kriteria Kata Sandi Aman
                        </h3>
                        <ul class="text-base text-gray-600 dark:text-gray-400 space-y-3">
                            <li id="req-length" class="flex items-center gap-3 transition-colors">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                Minimal 8 karakter
                            </li>
                            <li id="req-uppercase" class="flex items-center gap-3 transition-colors">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                Mengandung huruf kapital dan kecil
                            </li>
                            <li id="req-number" class="flex items-center gap-3 transition-colors">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                Mengandung angka dan karakter khusus
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-6 pt-6">
                        <button type="submit" id="submit-btn"
                            class="px-8 py-4 bg-primary-600 text-white text-lg font-semibold rounded-2xl hover:bg-primary-500 active:scale-[0.98] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-key"></i>
                            Perbarui Kata Sandi
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="flex items-center gap-3 text-base text-green-600 dark:text-green-400 font-semibold bg-green-50 dark:bg-green-900/20 px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-circle-check"></i> Kata Sandi berhasil diperbarui
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE ACCOUNT MODAL -->
    <div id="deleteAccountModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            <!-- Header -->
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Hapus Akun</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Tindakan ini permanen dan tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="p-8">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-2xl p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mt-1"></i>
                        <div class="text-base text-red-800 dark:text-red-300">
                            <p class="font-semibold">Perhatian!</p>
                            <p class="mt-2">Semua data Anda akan dihapus secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.</p>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-6">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="delete_password" class="block text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            Konfirmasi Password
                        </label>
                        <input id="delete_password" name="password" type="password" required
                            class="w-full px-6 py-4 rounded-2xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all outline-none placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white text-lg"
                            placeholder="Masukkan password untuk konfirmasi">
                        @error('password', 'userDeletion')
                            <p class="text-base text-red-600 dark:text-red-400 mt-3">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-6 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-lg font-semibold rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-red-500 to-rose-600 text-white text-lg font-semibold rounded-2xl hover:from-red-600 hover:to-rose-700 active:scale-[0.98] transition-all duration-300 shadow-lg hover:shadow-xl">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openModals(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModals(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Delete Modal Functions
        function openDeleteModal() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Password Visibility Toggle
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Profile Form Validation
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const nameCheck = document.getElementById('name-check');
            const emailCheck = document.getElementById('email-check');

            nameInput.addEventListener('input', function () {
                nameCheck.classList.toggle('opacity-100', nameInput.value.length > 0);
                nameCheck.classList.toggle('opacity-0', nameInput.value.length === 0);
            });

            emailInput.addEventListener('input', function () {
                emailCheck.classList.toggle('opacity-100', emailInput.value.length > 0);
                emailCheck.classList.toggle('opacity-0', emailInput.value.length === 0);
            });
        });

        // Password Strength Checker
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const passwordMatch = document.getElementById('password-match');
            const submitBtn = document.getElementById('submit-btn');

            // Requirements elements
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqNumber = document.getElementById('req-number');

            function checkPasswordStrength(password) {
                let strength = 0;

                // Length check
                if (password.length >= 8) {
                    strength += 1;
                    reqLength.classList.add('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqLength.classList.remove('text-gray-600', 'dark:text-gray-400');
                } else {
                    reqLength.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqLength.classList.add('text-gray-600', 'dark:text-gray-400');
                }

                // Uppercase & lowercase check
                if (/[A-Z]/.test(password) && /[a-z]/.test(password)) {
                    strength += 1;
                    reqUppercase.classList.add('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqUppercase.classList.remove('text-gray-600', 'dark:text-gray-400');
                } else {
                    reqUppercase.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqUppercase.classList.add('text-gray-600', 'dark:text-gray-400');
                }

                // Number & special char check
                if (/[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength += 1;
                    reqNumber.classList.add('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqNumber.classList.remove('text-gray-600', 'dark:text-gray-400');
                } else {
                    reqNumber.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                    reqNumber.classList.add('text-gray-600', 'dark:text-gray-400');
                }

                // Update strength indicator
                let width = '0%';
                let color = 'bg-red-500';
                let text = 'Sangat Lemah';

                if (strength === 0) {
                    width = '0%';
                    color = 'bg-red-500';
                    text = 'Sangat Lemah';
                } else if (strength === 1) {
                    width = '33%';
                    color = 'bg-red-500';
                    text = 'Lemah';
                } else if (strength === 2) {
                    width = '66%';
                    color = 'bg-yellow-500';
                    text = 'Cukup';
                } else {
                    width = '100%';
                    color = 'bg-green-500';
                    text = 'Sangat Kuat';
                }

                strengthBar.className = `h-3 rounded-full ${color} transition-all duration-500`;
                strengthBar.style.width = width;
                strengthText.textContent = text;
            }

            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;

                if (password && confirm) {
                    if (password === confirm) {
                        passwordMatch.classList.remove('hidden');
                        submitBtn.disabled = false;
                    } else {
                        passwordMatch.classList.add('hidden');
                        submitBtn.disabled = true;
                    }
                } else {
                    passwordMatch.classList.add('hidden');
                    submitBtn.disabled = true;
                }
            }

            passwordInput.addEventListener('input', function () {
                checkPasswordStrength(this.value);
                checkPasswordMatch();
            });

            confirmInput.addEventListener('input', checkPasswordMatch);

            // Initialize
            submitBtn.disabled = true;
        });

        // Close modals on outside click
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                });
            }
        });
    </script>
@endsection

@push('style')
    <style>
        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        /* Smooth transitions for dark mode */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
    </style>
@endpush