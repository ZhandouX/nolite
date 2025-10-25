<form method="GET" action="{{ route('customer.allProduk') }}">
    {{-- SEARCH --}}
    <div class="mb-6 mt-6">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                class="w-full border border-gray-300 rounded-md pl-8 pr-3 py-1.5 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <i class="fa fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
        </div>
    </div>

    {{-- PRODUCT CATEGORY --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Kategori</h2>

        @php
            $routeMap = [
                'T-shirt' => 'customer.kategori-tshirt',
                'Hoodie' => 'customer.kategori-hoodie',
                'Jersey' => 'customer.kategori-jersey',
            ];
            $currentRoute = Route::currentRouteName();
        @endphp

        @foreach($routeMap as $cat => $routeName)
            @php
                $isChecked = strtolower($currentRoute) === strtolower($routeName);
            @endphp
            <label class="block text-sm text-gray-700 cursor-pointer">
                <input type="radio" name="kategori" value="{{ $cat }}" {{ $isChecked ? 'checked' : '' }}
                    onclick="handleCategoryClick(this, '{{ route($routeName) }}', '{{ route('customer.allProduk') }}')"
                    class="mr-2 accent-gray-600">
                {{ $cat }}
            </label>
        @endforeach
    </div>

    {{-- PRODUCT TYPE --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Tipe Produk</h2>
        <label class="text-sm"><input type="radio" name="tipe" value="" {{ request('tipe') == '' ? 'checked' : '' }}> Semua</label><br>
        <label class="text-sm"><input type="radio" name="tipe" value="unggulan" {{ request('tipe') == 'unggulan' ? 'checked' : '' }}> Unggulan</label><br>
        <label class="text-sm"><input type="radio" name="tipe" value="diskon" {{ request('tipe') == 'diskon' ? 'checked' : '' }}> Diskon</label>
    </div>

    {{-- MIN & MAX PRICES --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Harga</h2>
        <input type="number" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}"
            class="w-full mb-2 border rounded-md p-1 text-sm">
        <input type="number" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}"
            class="w-full border rounded-md p-1 text-sm">
    </div>

    {{-- SIZES SELECTED --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Ukuran</h2>
        @foreach(['S', 'M', 'L', 'XL'] as $size)
            <button type="submit" name="ukuran" value="{{ $size }}"
                class="px-2 py-1 text-sm border rounded-md hover:bg-gray-100 {{ request('ukuran') == $size ? 'bg-gray-200 border-blue-500' : '' }}">
                {{ $size }}
            </button>
        @endforeach
    </div>

    {{-- SUBMIT BUTTON --}}
    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-500 text-white py-2 rounded-md text-sm">
        Terapkan Filter
    </button>
</form>
