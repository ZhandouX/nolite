<form method="GET" action="{{ route('customer.allProduk') }}">
    {{-- SEARCH --}}
    <div class="mb-3 mt-3">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                class="w-full border border-gray-300 bg-white rounded-md pl-8 pr-3 py-1.5 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <i class="fa fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
        </div>
    </div>

    {{-- CATEGORY --}}
    <div class="mb-3">
        <h2 class="font-semibold mb-2 text-sm">Kategori</h2>

        @php
            // Ambil semua kategori dari DB
            $kategoris = \App\Models\Kategori::all();
            $currentKategoriId = request('kategori_id');
        @endphp

        @foreach($kategoris as $kategori)
            <label class="block text-sm text-gray-700 cursor-pointer">
                <input type="radio" name="kategori_id" value="{{ $kategori->id }}"
                    onclick="window.location.href='{{ route('customer.kategori-produk', $kategori->id) }}'"
                    class="mr-2 accent-gray-600" {{ request()->route('kategori') == $kategori->id ? 'checked' : '' }}>
                {{ $kategori->nama_kategori }}
            </label>
        @endforeach
    </div>

    {{-- TYPE --}}
    <div id="filterTipeForm" class="space-y-1 mb-3">
        <h2 class="font-semibold mb-2 text-sm">Sortis Berdasarkan</h2>
        <label class="text-sm block">
            <input type="radio" name="tipe" value="all" {{ request()->routeIs('customer.allProduk') ? 'checked' : '' }}>
            Semua
        </label>

        <label class="text-sm block">
            <input type="radio" name="tipe" value="unggulan" {{ request()->routeIs('customer.unggulan') ? 'checked' : '' }}>
            Terlaris
        </label>

        <label class="text-sm block">
            <input type="radio" name="tipe" value="diskon" {{ request()->routeIs('customer.diskon') ? 'checked' : '' }}>
            Diskon
        </label>
    </div>

    {{-- PRICES --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Harga</h2>
        <input type="number" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}"
            class="w-full mb-2 bg-white border rounded-md p-1 text-sm">
        <input type="number" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}"
            class="w-full bg-white border rounded-md p-1 text-sm">
    </div>

    {{-- SIZES --}}
    <div class="mb-6">
        <h2 class="font-semibold mb-2 text-sm">Ukuran</h2>
        @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
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