@extends('layouts.user_app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">

        {{-- Notifikasi --}}
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            <strong>Akun Anda telah dinonaktifkan!</strong>
            <p>Anda tidak bisa melakukan checkout. Silakan hubungi admin melalui form di bawah.</p>
        </div>

        {{-- Form kirim pesan --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('services.customer-service.send') }}" method="POST" class="space-y-4">
            @csrf
            <label for="message" class="font-semibold">Pesan untuk Admin:</label>
            <textarea name="message" id="message" rows="5"
                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Tuliskan pesan Anda..."></textarea>
            <button type="submit"
                class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-500 transition">
                Kirim Pesan
            </button>
        </form>
    </div>
@endsection