@extends('layouts.user_app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

    <div
        class="w-full max-w-md px-8 py-10 rounded-[20px] border border-gray-200 shadow-2xl"
        style="background: linear-gradient(145deg, #ffffff 0%, #f5f5f5 100%); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);"
    >

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-gray-200 p-4 rounded-full border border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-gray-700"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 11c0-3.866 3.582-7 8-7v14c-4.418 0-8-3.134-8-7zM12 11C12 7.134 8.418 4 4 4v14c4.418 0 8-3.134 8-7z"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">
            Reset Password
        </h2>

        <!-- Description -->
        <p class="text-center text-sm text-gray-500 mb-8">
            Masukkan password baru untuk akun kamu.
        </p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-gray-700 focus:ring-4 focus:ring-gray-300/30 transition duration-300"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-gray-700 focus:ring-4 focus:ring-gray-300/30 transition duration-300"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-gray-700 focus:ring-4 focus:ring-gray-300/30 transition duration-300"
                >
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-3 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:-translate-y-0.5"
                style="background: linear-gradient(90deg, #1a1a1a 0%, #333333 100%);"
            >
                Reset Password
            </button>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <button
                    type="button"
                    onclick="openLoginModal()"
                    class="text-sm text-gray-700 hover:text-black transition duration-200 flex items-center justify-center gap-1 mx-auto"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Login
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
