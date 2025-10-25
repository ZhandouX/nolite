<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('admin.dashboard') }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-gauge menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Manajemen Data</li>

        {{-- MANAGEMENT DATA --}}
        <li class="nav-item {{ request()->routeIs('admin.produk.index') }}">
            <a class="nav-link" href="{{ route('admin.produk.index') }}">
                <i class="menu-icon mdi mdi-tshirt-crew"></i>
                <span class="menu-title">Produk</span>
            </a>
        </li>

        {{-- MANAGEMENT ORDER --}}
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.order.index') }}">
                <i class="menu-icon mdi mdi-cart"></i>
                <span class="menu-title">Pesanan</span>
            </a>
        </li>
    </ul>
</nav>