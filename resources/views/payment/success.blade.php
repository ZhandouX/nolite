@extends('layouts.app_user')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="max-w-xl mx-auto mt-20 text-center">
    <h1 class="text-2xl font-bold text-green-600">Pembayaran Berhasil!</h1>
    <p class="mt-4 text-gray-700">Terima kasih, pesanan Anda berhasil diproses.</p>
    <a href="{{ route('customer.dashboard') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        Kembali ke Dashboard
    </a>
</div>
@endsection