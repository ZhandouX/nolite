@extends('layouts.user_app')

@section('title', 'Profile Settings')

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8 px-4 pt-20 lg:pt-0">
        <div class="max-w-4xl mx-auto">
            {{-- HEADER SECTION --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan Akun Profil</h1>
                <p class="text-gray-600">Kelola informasi akun dan keamanan Anda</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- SIDEBAR PROFILE --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        {{-- COVER & AVATAR --}}
                        <div class="relative">
                            <div class="h-24 bg-gradient-to-r from-gray-900 via-gray-800 to-black"></div>
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <div
                                    class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 border-4 border-white flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>
                        </div>

                        {{-- USER INFO --}}
                        <div class="pt-12 pb-6 px-6 text-center">
                            <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600 text-sm mb-3">{{ Auth::user()->email }}</p>
                            <div class="inline-flex items-center bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">
                                <i class="fa-regular fa-calendar mr-1.5"></i>
                                Bergabung
                                {{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </div>
                        </div>

                        {{-- QUICK ACTIONS --}}
                        <div class="border-t border-gray-200 p-4 space-y-2">
                            <button onclick="openModals('updateProfileModal')"
                                class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 group">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mr-3 group-hover:bg-blue-100 transition-colors">
                                    <i class="fa-solid fa-user-pen text-blue-600 text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-gray-900">Edit Profil</div>
                                    <div class="text-xs text-gray-500">Ubah informasi pribadi</div>
                                </div>
                            </button>

                            <button onclick="openModals('updatePasswordModal')"
                                class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 group">
                                <div
                                    class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center mr-3 group-hover:bg-amber-100 transition-colors">
                                    <i class="fa-solid fa-lock text-amber-600 text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-gray-900">Update Kata Sandi</div>
                                    <div class="text-xs text-gray-500">Perbarui kata sandi akun</div>
                                </div>
                            </button>

                            <button onclick="openDeleteModal()"
                                class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group">
                                <div
                                    class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center mr-3 group-hover:bg-red-100 transition-colors">
                                    <i class="fa-regular fa-trash-can text-red-600 text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium">Hapus Akun</div>
                                    <div class="text-xs text-red-500">Hapus permanen akun</div>
                                </div>
                            </button>

                            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 group mt-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-gray-200 transition-colors">
                                        <i class="fa-solid fa-right-from-bracket text-gray-600 text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="font-medium text-gray-900">Keluar</div>
                                        <div class="text-xs text-gray-500">Logout dari akun</div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- MAIN CONTENT AREA --}}
                <div class="lg:col-span-2">
                    {{-- ACCOUNT OVERVIEW CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fa-solid fa-chart-line mr-2 text-gray-700"></i>
                            Ringkasan Akun
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Status Akun</p>
                                        <p class="text-lg font-semibold text-gray-900 mt-1">
                                            @if($user->status === 'aktif')
                                                <span class="flex items-center gap-1 text-green-600">
                                                    <i data-lucide="check-circle" class="w-4 h-4"></i> Aktif
                                                </span>
                                            @elseif($user->status === 'nonaktif')
                                                <span class="flex items-center gap-1 text-red-600">
                                                    <i data-lucide="x-circle" class="w-4 h-4"></i> Nonaktif
                                                </span>
                                            @else
                                                <span class="flex items-center gap-1 text-gray-600">
                                                    <i data-lucide="help-circle" class="w-4 h-4"></i> Tidak Diketahui
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Kotak kanan dinamis --}}
                                    @if($user->status === 'aktif')
                                        <div
                                            class="w-12 h-12 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center">
                                            <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                                        </div>
                                    @elseif($user->status === 'nonaktif')
                                        <div
                                            class="w-12 h-12 rounded-lg bg-gradient-to-r from-red-500 to-rose-600 flex items-center justify-center">
                                            <i data-lucide="x-circle" class="w-5 h-5 text-white"></i>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-300 flex items-center justify-center">
                                            <i data-lucide="help-circle" class="w-5 h-5 text-white"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Member Sejak</p>
                                        <p class="text-lg font-semibold text-gray-900 mt-1">
                                            {{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-12 h-12 rounded-lg bg-gradient-to-r from-gray-700 to-gray-900 flex items-center justify-center">
                                        <i class="fa-regular fa-clock text-white text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU STATUS KEAMANAN --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fa-solid fa-shield-halved mr-2 text-gray-700"></i>
                            Status Keamanan
                        </h3>

                        <div class="space-y-4">
                            {{-- Email Verification --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fa-solid fa-envelope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Verifikasi Email</p>
                                        <p class="text-sm text-gray-600">Pastikan email Anda sudah terverifikasi</p>
                                    </div>
                                </div>
                                @if($user->hasVerifiedEmail())
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full font-medium">
                                        <i class="fa-solid fa-check mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm rounded-full font-medium">
                                        <i class="fa-solid fa-exclamation mr-1"></i> Belum Verifikasi
                                    </span>
                                @endif
                            </div>

                            {{-- Password Strength --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mr-3">
                                        <i class="fa-solid fa-lock text-amber-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Kekuatan Kata Sandi</p>
                                        <p class="text-sm text-gray-600">Perbarui kata sandi secara berkala</p>
                                    </div>
                                </div>
                                <button onclick="openModals('updatePasswordModal')"
                                    class="px-4 py-2 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 transition-colors font-medium">
                                    Perbarui
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE PROFILE -->
    <div id="updateProfileModal"
        class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 backdrop-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-gray-900 to-black p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fa-solid fa-user-pen text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Update Profile</h2>
                            <p class="text-gray-300 text-sm">Kelola informasi akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeModals('updateProfileModal')"
                        class="text-white/80 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- MODAL UPDATE PASSWORD -->
    <div id="updatePasswordModal"
        class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 backdrop-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto hide-scrollbar">
            <!-- Header -->
            <div class="bg-gradient-to-r from-gray-900 to-black p-6 rounded-t-2xl sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fa-solid fa-lock text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Perbarui Kata Sandi</h2>
                            <p class="text-gray-300 text-sm">Tingkatkan keamanan akun Anda</p>
                        </div>
                    </div>
                    <button onclick="closeModals('updatePasswordModal')"
                        class="text-white/80 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- DELETE ACCOUNT MODAL -->
    <div id="deleteAccountModal"
        class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 backdrop-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Hapus Akun</h3>
                        <p class="text-sm text-gray-600 mt-1">Tindakan ini permanen dan tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="p-6">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                        <div class="text-sm text-red-800">
                            <p class="font-semibold">Perhatian!</p>
                            <p class="mt-1">Semua data Anda akan dihapus secara permanen. Data yang sudah dihapus tidak
                                dapat dikembalikan.</p>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                @include('profile.partials.delete-user-form')
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
                    reqLength.classList.add('text-green-600', 'font-semibold');
                    reqLength.classList.remove('text-gray-600');
                } else {
                    reqLength.classList.remove('text-green-600', 'font-semibold');
                    reqLength.classList.add('text-gray-600');
                }

                // Uppercase & lowercase check
                if (/[A-Z]/.test(password) && /[a-z]/.test(password)) {
                    strength += 1;
                    reqUppercase.classList.add('text-green-600', 'font-semibold');
                    reqUppercase.classList.remove('text-gray-600');
                } else {
                    reqUppercase.classList.remove('text-green-600', 'font-semibold');
                    reqUppercase.classList.add('text-gray-600');
                }

                // Number & special char check
                if (/[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength += 1;
                    reqNumber.classList.add('text-green-600', 'font-semibold');
                    reqNumber.classList.remove('text-gray-600');
                } else {
                    reqNumber.classList.remove('text-green-600', 'font-semibold');
                    reqNumber.classList.add('text-gray-600');
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

                strengthBar.className = `h-2 rounded-full ${color} transition-all duration-500`;
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
    </style>
@endpush