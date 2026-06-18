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
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">
            Lupa Kata Sandi?
        </h2>

        <!-- Description -->
        <p class="text-center text-sm text-gray-500 mb-8">
            Tenang! Masukkan email kamu dan kami akan mengirimkan tautan untuk mereset kata sandi.
        </p>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg p-3"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Alamat Email
                </label>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-gray-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="nama@contoh.com"
                        class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-gray-700 focus:ring-4 focus:ring-gray-300/30 transition duration-300"
                    />
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full py-3 px-4 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2 mt-2 hover:-translate-y-0.5"
                style="background: linear-gradient(90deg, #1a1a1a 0%, #333333 100%);"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Kirim Tautan Reset
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
