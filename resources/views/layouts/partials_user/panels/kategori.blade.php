<div id="panel-kategori" class="tab-panel hidden mt-4 md:mt-10">
    <div id="kategoriGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 max-w-6xl mx-auto px-4">
        @php
            $kategoris = \App\Models\Kategori::all();
        @endphp

        @foreach($kategoris as $index => $kategori)
            <a href="{{ route('customer.kategori-produk', $kategori->id) }}"
               class="kategori-item-wrapper group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="kategori-item relative">
                    <img src="{{ $kategori->foto_sampul ? asset('storage/' . $kategori->foto_sampul) : 'https://via.placeholder.com/600x400?text='.$kategori->nama_kategori }}"
                         alt="{{ $kategori->nama_kategori }}" class="w-full h-full object-cover" />
                    <div class="kategori-overlay absolute inset-0 flex items-center justify-center bg-black/25">
                        <h3 class="text-xl sm:text-xl md:text-2xl lg:text-4xl text-white font-bold">
                            {{ strtoupper($kategori->nama_kategori) }}
                        </h3>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('kategoriGrid');
        const items = grid.querySelectorAll('.kategori-item-wrapper');

        // Jika jumlah item ganjil, col-span-2 hanya untuk tampilan kecil
        if (items.length % 2 !== 0) {
            const lastItem = items[items.length - 1];
            lastItem.classList.add('col-span-2', 'sm:col-span-1', 'lg:col-span-1');
        }
    });
</script>
