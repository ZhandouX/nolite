<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo d-flex align-items-center" href="#">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="logo"
                    style="height:40px; width:auto; margin-right:10px;">
                <h2 class="text-white mb-0">Nolite</h2>
            </a>
            <a class="navbar-brand brand-logo-mini" href="#">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="logo" />
            </a>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-top">
        {{-- WELCOME TEXT --}}
        <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Halo!
                    <span class="text-black fw-bold">{{ auth()->user()->name ?? 'Administrator' }}</span>
                </h1>
                <h3 class="welcome-sub-text">Selamat Datang di Nolite Shop
                    <strong class="text-dark">
                        <i class="mdi mdi-account-tie-hat"></i>
                    </strong>
                </h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">

            {{-- SEARCH SECTION --}}
            <li class="nav-item">
                <form class="search-form" action="#" method="GET">
                    <i class="icon-search"></i>
                    <input type="search" name="q" class="form-control" placeholder="Search Here" title="Search here"
                        value="">
                </form>
            </li>

            {{-- NOTIFICATION --}}
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="icon-bell"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                    aria-labelledby="notificationDropdown">
                    <a class="dropdown-item py-3 border-bottom">
                        <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                        <span class="badge badge-pill badge-primary float-end">View all</span>
                    </a>
                    <a class="dropdown-item preview-item py-3">
                        <div class="preview-thumbnail">
                            <i class="mdi mdi-alert m-auto text-primary"></i>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                            <p class="fw-light small-text mb-0"> Just now </p>
                        </div>
                    </a>
                </div>
            </li>

            {{-- PROFILE ACCOUNT --}}
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs profile-default rounded-circle"
                        src="{{ asset('assets/images/default-profile.png') }}" alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md profile-default rounded-circle"
                            src="{{ asset('assets/images/default-profile.png') }}" alt="Profile image">
                        <p class="mb-1 mt-3 fw-semibold">{{ auth()->user()->name ?? '' }}</p>
                        <p class="fw-light text-muted mb-0">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="logout-btn dropdown-item block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

<style>
    /* ==================== CUSTOM SUBMENU ==================== */
    .dropdown-menu.custom-submenu {
        display: none;
        position: absolute;
        top: 0;
        right: 100%;
        margin-left: 5px;
        background: #fff;
        border: 1px solid #ddd;
        min-width: 220px;
        border-radius: 6px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        animation: fadeInLeft 0.25s ease forwards;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .dropdown-menu>.custom-submenu-toggle:hover+.custom-submenu {
        display: block;
    }

    .dropdown-menu.custom-submenu:hover {
        display: block;
    }

    .dropdown-menu.custom-submenu .dropdown-item {
        padding: 8px 15px;
        transition: all 0.2s ease;
    }

    .dropdown-menu.custom-submenu .dropdown-item:hover {
        background: var(--bs-primary);
        color: #fff;
    }

    .submenu-icon {
        transition: transform 0.3s ease;
    }

    .custom-submenu-toggle:hover .submenu-icon {
        transform: translateX(-3px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelectorAll('.custom-submenu').forEach(menu => {
                    if (menu !== this.nextElementSibling) {
                        menu.style.display = 'none';
                    }
                });

                const submenu = this.nextElementSibling;
                submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.nav-item.dropdown')) {
                document.querySelectorAll('.custom-submenu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    });
</script>