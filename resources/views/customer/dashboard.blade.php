@extends('layouts.user_app')

@section('content')

    {{-- HERO SLIDER --}}
    <section class="hero" id="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('{{ asset('assets/images/hero/1.jpeg') }}')"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/hero/2.jpeg') }}')"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/hero/3.jpeg') }}')"></div>
        </div>
    </section>

    {{-- MAIN PANEL / TABS --}}
    <div class="tabs">
        <button class="tab" data-category="kategori">Kategori</button>
        <button class="tab active" data-category="all">Semua Produk</button>
        <button class="tab" data-category="diskon">Diskon</button>
    </div>

    {{-- PANEL: CATEGORY --}}
    @include('layouts.partials_user.panels.kategori')

    {{-- PANEL: DISKON --}}
    @include('layouts.partials_user.panels.diskon')

    {{-- PANEL: ALL PRODUCT --}}
    @include('layouts.partials_user.panels.all-produk')

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}" class="see-all-btn">
            LIHAT SEMUA PRODUK
        </a>
    </div>

    <div class="extra-icons">
        <div class="icon-box">
            <i data-lucide="info"></i>
            <span>Tentang Kami</span>
        </div>
        <div class="icon-box">
            <a href="{{ route('customer.allProduk') }}" class="icon-box">
                <i data-lucide="shopping-bag"></i>
                <span>Semua Produk</span>
            </a>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('block');
                });

                const filteredCategory = document.getElementById('filtered-category');
                if (filteredCategory) filteredCategory.classList.add('hidden');
                const target = tab.dataset.category;
                const targetPanel = document.getElementById(`panel-${target}`);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('block');
                }
            });
        });
    </script>
@endpush