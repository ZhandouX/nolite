@extends('layouts.user_app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900">

    <div class="w-full max-w-md px-8 py-10 bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-blue-500/20 p-4 rounded-full border border-blue-400/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0-3.866 3.582-7 8-7v14c-4.418 0-8-3.134-8-7zM12 11C12 7.134 8.418 4 4 4v14c4.418 0 8-3.134 8-7z" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-white mb-2">
            Reset Password
        </h2>

        <!-- Description -->
        <p class="text-center text-sm text-blue-200/70 mb-8">
            Masukkan password baru untuk akun kamu.
        </p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-blue-200 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-blue-200 mb-1">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-blue-200 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/40 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl shadow-lg transition"
            >
                Reset Password
            </button>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <button
                    type="button"
                    onclick="openLoginModal()"
                    class="text-sm text-blue-300/70 hover:text-blue-300 flex items-center justify-center gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </button>
            </div>

        </form>
    </div>
</div>

@endsection