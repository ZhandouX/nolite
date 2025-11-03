<div id="panel-kategori" class="tab-panel hidden mt-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto px-4">
        {{-- T-SHIRT --}}
        <a href="{{ route('customer.kategori-tshirt') }}"
            class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=600&q=80"
                    alt="T-Shirt" />
                <div class="kategori-overlay">
                    <h3>T-SHIRT</h3>
                </div>
            </div>
        </a>

        {{-- HOODIE --}}
        <a href="{{ route('customer.kategori-hoodie') }}"
            class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="{{ asset('assets/images/banner/hoodie-1.jpg') }}" alt="Hoodie" />
                <div class="kategori-overlay">
                    <h3>HOODIE</h3>
                </div>
            </div>
        </a>

        {{-- JERSEY --}}
        <a href="{{ route('customer.kategori-jersey') }}"
            class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="kategori-item">
                <img src="{{ asset('assets/images/banner/jersey.jpg') }}" alt="Jersey" />
                <div class="kategori-overlay">
                    <h3>JERSEY</h3>
                </div>
            </div>
        </a>
    </div>
</div>