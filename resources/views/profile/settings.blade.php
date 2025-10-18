@extends('layouts.user_app')

@section('title', 'Profile Settings')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 px-4 pt-24">
        <form method="POST" action="{{ route('logout') }}" class="absolute right-6">
            @csrf
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 active:bg-red-800 transition">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </button>
        </form>
        <div class="max-w-md mx-auto">

            {{-- PROFILE CARD --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 text-center relative">

                {{-- PHOTO PROFILE --}}
                <div
                    class="w-24 h-24 mx-auto rounded-full bg-gray-600 flex items-center justify-center text-white text-3xl font-semibold shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) . strtoupper(substr(strstr(Auth::user()->name, ' ') ? strstr(Auth::user()->name, ' ') : Auth::user()->name, 1, 1)) }}
                </div>

                {{-- INFO USER --}}
                <h2 class="mt-4 text-xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                <p class="text-xs text-gray-400 mt-2">Member since {{ Auth::user()->created_at->format('F Y') }}</p>

                {{-- OPTIONS BUTTON --}}
                <div class="mt-6">
                    <button id="optionsButton"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-400 transition inline-flex items-center justify-center">
                        Options
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- OPTIONS DROPDOWN --}}
                    <div id="optionsMenu"
                        class="hidden absolute left-1/2 transform -translate-x-1/2 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-10">
                        <button onclick="openModal('updateProfileModal')"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <i class="fa-solid fa-user mr-2"></i> Ubah Profil
                        </button>
                        <button onclick="openModal('updatePasswordModal')"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <i class="fa-solid fa-lock mr-2"></i> Ganti Password
                        </button>
                        <button onclick="openDeleteModal()"
                            class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                            <i class="fa-regular fa-trash-can mr-2"></i> Hapus Akun
                        </button>
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