@extends('layouts.user_app')

@section('title', 'Profile Settings')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 px-4 pt-24">
        <div class="max-w-md mx-auto">
            {{-- PROFILE CARD --}}
            <div
                class="bg-white/90 backdrop-blur-md rounded-3xl shadow-lg p-8 pt-16 border border-gray-100 text-center relative overflow-hidden">

                {{-- SAMPUL --}}
                <div
                    class="absolute top-0 left-0 w-full h-24 rounded-t-3xl bg-gradient-to-r from-gray-700 via-gray-600 to-gray-800">
                </div>

                {{-- FOTO PROFIL (Inisial) --}}
                <div class="relative w-32 h-32 mx-auto rounded-full border-4 border-white bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center text-white text-6xl font-bold    "
                    style="margin-top:-1.5rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                {{-- INFO USER --}}
                <h2 class="mt-5 text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    Pengguna Sejak
                    {{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->translatedFormat('F Y') }}
                </p>

                {{-- OPTIONS --}}
                <div class="mt-6 relative">
                    <button id="optionsButton"
                        class="px-5 py-2.5 bg-gray-600 text-white rounded-xl text-sm font-medium shadow-sm hover:bg-gray-700 transition inline-flex items-center">
                        <i class="fa-solid fa-gear mr-2"></i> Pengaturan
                    </button>

                    {{-- DROPDOWN (muncul di atas tombol) --}}
                    <div id="optionsMenu"
                        class="hidden absolute left-1/2 transform -translate-x-1/2 bottom-full mb-3 w-52 bg-white rounded-xl shadow-lg border border-gray-100 z-10 overflow-hidden">
                        <button onclick="openModal('updateProfileModal')"
                            class="block w-full text-left px-4 py-2.5 text-gray-700 hover:bg-gray-50 text-sm">
                            <i class="fa-solid fa-user mr-2 text-gray-500"></i> Ubah Profil
                        </button>
                        <button onclick="openModal('updatePasswordModal')"
                            class="block w-full text-left px-4 py-2.5 text-gray-700 hover:bg-gray-50 text-sm">
                            <i class="fa-solid fa-lock mr-2 text-gray-500"></i> Ganti Password
                        </button>
                        <button onclick="openDeleteModal()"
                            class="block w-full text-left px-4 py-2.5 text-red-600 hover:bg-red-50 text-sm">
                            <i class="fa-regular fa-trash-can mr-2"></i> Hapus Akun
                        </button>
                        <button onclick="document.getElementById('logoutForm').submit()"
                            class="block w-full text-left px-4 py-2.5 text-gray-700 hover:bg-red-50 text-sm text-red-600">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                        </button>

                        <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UPDATE PROFILE --}}
    <div id="updateProfileModal"
        class="z-[9999] modal hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
            <h2 class="text-lg text-center font-bold mb-4">Ubah Profil</h2>
            <button onclick="closeModal('updateProfileModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">&times;</button>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- MODAL UPDATE PASSWORD --}}
    <div id="updatePasswordModal" class="modal hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
            <h2 class="text-lg text-center font-bold mb-4">Ganti Password</h2>
            <button onclick="closeModal('updatePasswordModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">&times;</button>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteAccountModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-[9999]">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md relative">
            <!-- Tombol Close -->
            <button type="button" onclick="closeDeleteModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Apakah kamu yakin ingin menghapus akunmu?
            </h3>
            <p class="text-sm text-gray-600 mb-5">
                Tindakan ini <span class="font-semibold text-red-600">tidak dapat dibatalkan</span>.
                Masukkan password untuk konfirmasi.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="delete_password" name="password" type="password"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition outline-none placeholder-gray-400"
                        placeholder="Masukkan password" required>
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 active:bg-red-800 transition">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS: DROPDOWN --}}
    <script>
        const optionsButton = document.getElementById('optionsButton');
        const optionsMenu = document.getElementById('optionsMenu');

        optionsButton.addEventListener('click', () => {
            optionsMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!optionsButton.contains(e.target) && !optionsMenu.contains(e.target)) {
                optionsMenu.classList.add('hidden');
            }
        });

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            optionsMenu.classList.add('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

    {{-- JS: MODAL DELETE ACCOUNT --}}
    <script>
        function openDeleteModal() {
            const modal = document.getElementById('deleteAccountModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteAccountModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    </script>
@endsection

@push('scripts')
