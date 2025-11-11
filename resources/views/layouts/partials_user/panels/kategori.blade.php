<div id="panel-kategori" class="tab-panel hidden mt-4 md:mt-10">
    <div id="kategoriGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 max-w-6xl mx-auto px-4">
        {{-- T-SHIRT --}}
        <a href="{{ route('customer.kategori-tshirt') }}"
            class="kategori-item-wrapper group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=600&q=80"
                    alt="T-Shirt" />
                <div class="kategori-overlay">
                    <h3 class="text-xl sm:text-xl md:text-2xl lg:text-4xl">T-SHIRT</h3>
                </div>
            </div>
        </a>

        {{-- HOODIE --}}
        <a href="{{ route('customer.kategori-hoodie') }}"
            class="kategori-item-wrapper group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="{{ asset('assets/images/banner/hoodie-1.jpg') }}" alt="Hoodie" />
                <div class="kategori-overlay">
                    <h3 class="text-xl sm:text-xl md:text-2xl lg:text-4xl">HOODIE</h3>
                </div>
            </div>
        </a>

        {{-- JERSEY --}}
        <a href="{{ route('customer.kategori-jersey') }}"
            class="kategori-item-wrapper group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="{{ asset('assets/images/banner/jersey.jpg') }}" alt="Jersey" />
                <div class="kategori-overlay">
                    <h3 class="text-xl sm:text-xl md:text-2xl lg:text-4xl">JERSEY</h3>
                </div>
            </div>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('kategoriGrid');
        const items = grid.querySelectorAll('.kategori-item-wrapper');

        // Cek apakah jumlah item ganjil
        if (items.length % 2 !== 0) {
            const lastItem = items[items.length - 1];
            // Tambahkan col-span-2 hanya untuk tampilan kecil
            lastItem.classList.add('col-span-2', 'sm:col-span-1', 'lg:col-span-1');
        }
    });
</script>