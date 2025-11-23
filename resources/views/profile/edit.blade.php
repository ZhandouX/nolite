@extends('layouts.user_app')

@section('title', 'My Account')

@section('content')
    <div class="bg-gray-100 text-gray-800 min-h-screen py-10 px-2 md:px-4 flex justify-center items-start pt-20 lg:pt-9">
        <div class="w-full md:max-w-3xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold">
                    Hai {{ Auth::user()->name ?? 'Pelanggan Nolite' }}
                </h1>
                <a href="{{ route('profile.settings') }}"
                    class="border border-red-900 text-red-900 px-4 py-2 rounded-lg hover:bg-gray-600 hover:text-white transition">
                    <i class="fa-solid fa-gear mr-2"></i>
                    Settings
                </a>
            </div>

            <!-- Orders & Wishlist -->
            <div class="bg-white rounded-lg shadow-sm p-3 md:p-6 relative hover:shadow-md transition">

                <!-- Dropdown -->
                <div class="absolute top-16 right-1 md:top-6 md:right-6">
                    <select id="statusFilter" class="border border-gray-300 rounded px-2 py-1 md:px-3 text-sm">
                        <option value="all">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tabs -->
                <div class="flex justify-center border-b border-gray-200 mb-[50px] md:mb-5">
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
                @include('layouts.partials_user.panels.orders')

                <!-- Wishlist Content -->
                @include('layouts.partials_user.panels._wishlist-section')
            </div>
        </div>
    </div>
    @include('layouts.partials_user.modals.ulasan')
@endsection

@push('style')
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }

        .star-rating {
            color: #fbbf24;
        }
    </style>
@endpush

@push('script')
    <script>
        window.Account = {
            CSRF: "{{ csrf_token() }}",
            storageUrl: "{{ asset('storage') }}",
            storageUrlNoImg: "{{ asset('assets/images/no-image.png') }}",
            routes: {
                wishlistRemove: "{{ route('wishlist.remove', ':id') }}",
                ulasanShow: id => "{{ route('customer.ulasan.show', ':id') }}".replace(':id', id),
                ulasanEdit: id => "{{ route('customer.ulasan.edit', ':id') }}".replace(':id', id),
                ulasanUpdate: id => "{{ route('customer.ulasan.update', ':id') }}".replace(':id', id),
                ulasanFotoDelete: id => "{{ route('customer.ulasan.ulasan-foto.delete', ':id') }}".replace(':id', id),
                orderShow: id => "{{ route('customer.orders.show', ':id') }}".replace(':id', id),
            }
        }
    </script>
    <script src="/assets/js/user/main.js"></script>
@endpush