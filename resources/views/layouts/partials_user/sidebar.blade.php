<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite" class="logo-img" />
        <h2 class="text-bold">Nolite Aspiciens</h2>
        <span class="close-btn" id="closeSidebar">&times;</span>
    </div>
    <ul class="sidebar-links">
        <li><a href="{{ route('customer.dashboard') }}">Beranda</a></li>
        <li><a href="{{ route('customer.allProduk') }}">Produk</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle">Men</a>
            <ul class="dropdown-menu">
                <li><a href="#men-tshirt">T-Shirt</a></li>
                <li><a href="#men-shoes">Hoodie</a></li>
                <li><a href="#men-jacket">Jersey</a></li>
            </ul>
        </li>
    </ul>
</div>