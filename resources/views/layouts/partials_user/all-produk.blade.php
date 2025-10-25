<div class="container mx-auto px-4 py-8 pt-24">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Sidebar Filter -->
        <aside class="w-full md:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
            <form method="GET" action="{{ route('customer.allProduk') }}">
                <!-- Pencarian -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                        <i class="fa fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Kategori</h2>
                    @foreach(['T-shirt', 'Hoodie', 'Jersey'] as $cat)
                        <label class="block text-sm text-gray-700">
                            <input type="checkbox" name="kategori[]" value="{{ $cat }}" {{ in_array($cat, (array) request('kategori')) ? 'checked' : '' }} class="mr-2"> {{ $cat }}
                        </label>
                    @endforeach
                </div>

                <!-- Tipe Produk -->
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Tipe Produk</h2>
                    <label><input type="radio" name="tipe" value="" {{ request('tipe') == '' ? 'checked' : '' }}>
                        Semua</label><br>
                    <label><input type="radio" name="tipe" value="unggulan" {{ request('tipe') == 'unggulan' ? 'checked' : '' }}> Unggulan</label><br>
                    <label><input type="radio" name="tipe" value="diskon" {{ request('tipe') == 'diskon' ? 'checked' : '' }}> Diskon</label>
                </div>

                <!-- Rentang Harga -->
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Harga</h2>
                    <input type="number" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}"
                        class="w-full mb-2 border rounded-md p-2">
                    <input type="number" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}"
                        class="w-full border rounded-md p-2">
                </div>

                <!-- Ukuran -->
                <div class="mb-6">
                    <h2 class="font-semibold mb-2">Ukuran</h2>
                    @foreach(['S', 'M', 'L', 'XL'] as $size)
                        <button type="submit" name="ukuran" value="{{ $size }}"
                            class="px-3 py-1 border rounded-md hover:bg-gray-100 {{ request('ukuran') == $size ? 'bg-gray-200 border-blue-500' : '' }}">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>

                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-500 text-white py-2 rounded-md">
                    Terapkan Filter
                </button>
            </form>
        </aside>


        <!-- Daftar Produk -->
        <main class="w-full md:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Semua Produk</h1>

                <form method="GET" action="{{ route('customer.allProduk') }}">
                    <select name="sort" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-4 py-2">
                        <option value="">Urutkan</option>
                        <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga
                            Terendah</option>
                        <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga
                            Tertinggi</option>
                        <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A–Z)</option>
                        <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z–A)</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($produks as $item)
                    <div class="bg-white border rounded-lg p-3 text-center hover:shadow-lg transition">
                        <a href="{{ route('produk.detail', $item->id) }}">
                            <img src="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}"
                                class="w-full h-48 object-contain mb-3">
                        </a>
                        <h3 class="font-semibold">{{ $item->nama_produk }}</h3>
                        <p class="text-red-600 font-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 italic">Belum ada produk ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $produks->links() }}
            </div>
        </main>

    </div>
</div>

<!-- Script Dropdown -->
<script>
    const dropdownButton = document.getElementById('sortDropdownButton');
    const dropdownMenu = document.getElementById('sortDropdown');
    const selectedSort = document.getElementById('selectedSort');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.querySelectorAll('.sort-option').forEach(option => {
        option.addEventListener('click', () => {
            selectedSort.textContent = 'Urutkan: ' + option.textContent;
            dropdownMenu.classList.add('hidden');
        });
    });

    window.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>