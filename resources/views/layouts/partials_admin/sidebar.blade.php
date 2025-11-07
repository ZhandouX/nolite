<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- DASHBOARD --}}
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-gauge menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

```
    {{-- MANAJEMEN DATA --}}
    <li class="nav-item nav-category">Manajemen Data</li>

    {{-- MANAGEMENT PRODUK --}}
    <li class="nav-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.produk.index') }}">
            <i class="menu-icon mdi mdi-tshirt-crew"></i>
            <span class="menu-title">Produk</span>
        </a>
    </li>

    {{-- MANAGEMENT ORDER --}}
    <li class="nav-item {{ request()->routeIs('admin.order.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.order.index') }}">
            <i class="menu-icon mdi mdi-cart"></i>
            <span class="menu-title">Pesanan</span>
        </a>
    </li>

    {{-- LAPORAN --}}
    <li class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.laporan.index') }}">
            <i class="menu-icon mdi mdi-chart-bar"></i>
            <span class="menu-title">Laporan</span>
        </a>
    </li>

    {{-- MANAJEMEN CHAT --}}
    <li class="nav-item {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.chats.index') }}">
            <i class="menu-icon mdi mdi-message-text"></i>
            <span class="menu-title">Chat</span>
        </a>
    </li>

    {{-- MANAJEMEN PENGGUNA --}}
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="menu-icon mdi mdi-account-multiple"></i>
            <span class="menu-title">Pengguna</span>
        </a>
    </li>
</ul>
```

</nav>
