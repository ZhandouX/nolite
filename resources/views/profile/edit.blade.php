@extends('layouts.user_app')

@section('title', 'My Account')

@section('content')
    <div class="bg-gray-100 text-gray-800 min-h-screen py-10 px-4 flex justify-center items-start pt-24">
        <div class="w-full max-w-3xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold">
                    Hi {{ Auth::user()->name ?? 'User' }}
                </h1>
                <a href="{{ route('profile.settings') }}"
                    class="border border-red-900 text-red-900 px-4 py-2 rounded hover:bg-red-900 hover:text-white transition">
                    Settings
                </a>
            </div>

            <!-- Vouchers Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-center mb-4">My Vouchers</h3>
                <div class="text-center text-gray-500">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No vouchers"
                        class="mx-auto w-14 mb-3 opacity-60">
                    <p>No vouchers available</p>
                    <small>You don't have any vouchers at the moment</small>
                </div>
            </div>

            <!-- Orders/Wishlist Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 relative hover:shadow-md transition">

                <!-- Dropdown top right -->
                <div class="absolute top-6 right-6">
                    <select class="border border-gray-300 rounded px-3 py-1 text-sm">
                        <option>All status</option>
                        <option>Pending</option>
                        <option>Shipped</option>
                        <option>Delivered</option>
                    </select>
                </div>

                <!-- Tabs -->
                <div class="flex justify-center border-b border-gray-200 mb-5">
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400 active-tab"
                        data-tab="orders">
                        Orders
                    </div>
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400"
                        data-tab="wishlist">
                        Wishlist
                    </div>
                </div>

                <!-- Orders Content -->
                <div id="orders" class="tab-content block text-center text-gray-500">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No orders"
                        class="mx-auto w-14 mb-3 opacity-60">
                    <p>No Orders Found</p>
                    <small>Place an order to see it listed here.</small>
                    <br><br>
                    <a href="#" class="text-red-900 font-medium hover:underline">Find your Orders</a>
                </div>

                <!-- Wishlist Content -->
                <div id="wishlist" class="tab-content hidden text-gray-700">

                    @if($wishlists->isEmpty())
                        <div class="text-center text-gray-500">
                            <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" alt="No wishlist"
                                class="mx-auto w-14 mb-3 opacity-60">
                            <p>No items in Wishlist</p>
                            <small>Add products to your wishlist to view them here.</small>
                            <br><br>
                            <a href="{{ route('customer.allProduk') }}" class="text-red-900 font-medium hover:underline">
                                Browse Products
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach($wishlists as $item)
                                <div
                                    class="border rounded-xl bg-white shadow-sm hover:shadow-md transition overflow-hidden group relative">

                                    {{-- Gambar produk --}}
                                    <a href="{{ route('produk.detail', $item->produk->id) }}" class="block relative">
                                        @if($item->produk->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                                alt="{{ $item->produk->nama_produk }}"
                                                class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                                class="w-full h-48 object-contain p-4">
                                        @endif
                                    </a>

                                    {{-- Info produk --}}
                                    <div class="p-4 text-center">
                                        <h3 class="font-semibold text-gray-800 text-sm truncate">
                                            {{ $item->produk->nama_produk }}
                                        </h3>
                                        <p class="text-red-600 font-bold mt-1">
                                            Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    {{-- Tombol hapus wishlist --}}
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST"
                                        class="absolute top-3 right-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-white/80 p-2 rounded-full shadow hover:scale-110 transition">
                                            <i class="fa-solid fa-heart text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');

                    tabs.forEach(t => t.classList.remove('border-black', 'text-black', 'active-tab'));
                    tab.classList.add('border-black', 'text-black', 'active-tab');

                    contents.forEach(c => c.classList.add('hidden'));
                    document.getElementById(target).classList.remove('hidden');
                });
            });
        });
    </script>
@endsection