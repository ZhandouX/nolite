<section class="featured-products">
    <div class="container">
        <div class="section-header">
            <h2>Featured Products</h2>
            <p>
                Koleksi terpilih dari lineup terbaru kami dengan kualitas premium
                dan desain eksklusif
            </p>
        </div>

        <div class="products-grid">
            @forelse($produk as $item)
                <div class="product-card border border-gray-500">
                    <div class="product-image">
                        @if($item->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                                alt="{{ $item->nama_produk }}" style="width: 100%; height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                style="width: 100%; height: 250px; object-fit: cover;">
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $item->nama_produk }}</h3>
                        <div class="product-price">
                            <span class="price-current">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </div>
                        <p class="product-desc">{{ Str::limit($item->deskripsi, 60) }}</p>
                        <p class="product-meta">
                            Warna: {{ $item->warna }} | Stok: {{ $item->jumlah }}
                        </p>
                        <div class="product-actions-bottom">
                            <button class="btn-cart" data-id="{{ $item->id }}">Add to Cart</button>

                            {{-- VIEW BUTTON --}}
                            <button class="btn-view btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#productModal" 
                                data-nama="{{ $item->nama_produk }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-warna="{{ $item->warna }}"
                                data-stok="{{ $item->jumlah }}"
                                data-harga="{{ number_format($item->harga, 0, ',', '.') }}"
                                @if($item->fotos->isNotEmpty())
                                    data-fotos="{{ $item->fotos->pluck('foto')->map(fn($f) => asset('storage/' . $f))->implode(',') }}"
                                @else 
                                    data-fotos="{{ asset('assets/images/no-image.png') }}" 
                                @endif
                            >
                                View
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada produk tersedia</p>
            @endforelse
        </div>

        <div class="section-footer">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <span>View All Products</span>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12,5 19,12 12,19"></polyline>
                </svg>
            </a>
        </div>
    </div>
</section>