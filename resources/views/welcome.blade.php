<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens Official - Minimalist Fashion Brand</title>
    <meta name="description"
        content="Koleksi fashion minimalis berkualitas premium dengan desain hitam/putih dan aksen merah khas brand Nolite Aspiciens" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/landing-page.css') }}" type="text/css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-content">
                <!-- Logo -->
                <a href="/" class="logo">
                    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Nolite Aspiciens Official" class="logo-image" />
                    <span class="logo-text">Nolite Aspiciens</span>
                    <span class="logo-official">Official</span>
                </a>

                <!-- Right Icons -->
                <div class="header-icons">
                    <!-- Search -->
                    <button class="icon-btn" id="searchBtn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="21 21l-4.35-4.35"></path>
                        </svg>
                    </button>

                    <!-- Wishlist -->
                    <button class="icon-btn" id="wishlistBtn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>
                        <span class="badge" id="wishlistCount">0</span>
                    </button>

                    <!-- Cart -->
                    <button class="icon-btn" id="cartBtn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span class="badge" id="cartCount">0</span>
                    </button>

                    <!-- User Menu -->
                    <div class="user-menu">
                        <button class="icon-btn" id="userBtn">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </button>

                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-info" id="userInfo" style="display: none">
                                <p class="user-name" id="userName">{{ Auth::check() ? Auth::user()->name : 'Guest' }}
                                </p>
                                <p class="user-email" id="userEmail">{{ Auth::check() ? Auth::user()->email : '' }}</p>
                            </div>

                            <div class="dropdown-menu">
                                @auth
                                    @php
                                        $user = Auth::user();
                                    @endphp

                                    {{-- Role admin --}}
                                    @if ($user->hasRole('admin'))
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="dropdown-item inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            Dashboard
                                        </a>
                                    @endif

                                    {{-- Role customer --}}
                                    @if ($user->hasRole('customer'))
                                        <a href="{{ route('customer.dashboard') }}"
                                            class="dropdown-item inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            Dashboard
                                        </a>
                                    @endif

                                    {{-- Tombol Logout --}}
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                            Logout
                                        </button>
                                    </form>
                                @else
                                    {{-- Tombol Login --}}
                                    <a href="{{ route('login') }}"
                                        class="dropdown-item inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                        Log in
                                    </a>

                                    {{-- Tombol Register --}}
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="dropdown-item inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Slider -->
        <section class="hero-slider" id="heroSlider">
            <!-- Floating Menu Button -->
            <div class="floating-menu-btn">
                <button class="menu-btn" id="menuBtn">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="menu-label">
                    <span>MENU</span>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="nav-arrow nav-arrow-left" id="prevSlide">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
            </button>

            <button class="nav-arrow nav-arrow-right" id="nextSlide">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </button>

            <!-- Slides Container -->
            <div class="slides-container" id="slidesContainer">
                <!-- Slides will be dynamically generated -->
            </div>

            <!-- Hero Content -->
            <div class="hero-content">
                <div class="hero-badge">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    <span>New Collection 2024</span>
                </div>

                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="title-main" id="heroTitleMain">MINIMALIST</span>
                        <span class="title-accent" id="heroTitleAccent">STREETWEAR</span>
                    </h1>

                    <p class="hero-description" id="heroDescription">
                        Koleksi minimalis dengan gaya streetwear yang elegan dan trendy
                    </p>
                </div>

                <div class="hero-buttons">
                    <a href="pages/shop.html" class="btn btn-primary">
                        <span>Shop Now</span>
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12,5 19,12 12,19"></polyline>
                        </svg>
                    </a>

                    <button class="btn btn-shopee" id="shopeeBtn">
                        🟧 Shopee Official Store
                    </button>
                </div>
            </div>

            <!-- Slide Indicators -->
            <div class="slide-indicators" id="slideIndicators">
                <!-- Indicators will be dynamically generated -->
            </div>

            <!-- Slide Counter -->
            <div class="slide-counter">
                <span id="slideCounter">1 / 5</span>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Products</h2>
                    <p>
                        Koleksi terpilih dari lineup terbaru kami dengan kualitas premium
                        dan desain eksklusif
                    </p>
                </div>

                <div class="products-grid" id="featuredProductsGrid">
                    <!-- Products will be dynamically generated -->
                </div>

                <div class="section-footer">
                    <a href="pages/shop.html" class="btn btn-secondary">
                        <span>View All Products</span>
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12,5 19,12 12,19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Ready to Upgrade Your Style?</h2>
                    <p>
                        Bergabunglah dengan ribuan customer yang sudah merasakan kualitas
                        premium Nolite Aspiciens
                    </p>

                    <div class="cta-buttons">
                        <a href="pages/shop.html" class="btn btn-primary">Browse Collection</a>
                        <button class="btn btn-whatsapp" id="whatsappBtn">
                            📱 Chat Admin
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <span>N</span>
                        </div>
                        <span class="logo-text">Nolite Aspiciens</span>
                    </div>
                    <p>
                        Fashion minimalis berkualitas premium dengan desain yang timeless
                        dan elegan.
                    </p>
                </div>

                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="pages/shop.html?category=t-shirt">T-Shirts</a></li>
                        <li><a href="pages/shop.html?category=hoodie">Hoodies</a></li>
                        <li><a href="pages/shop.html?category=jersey">Jerseys</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="pages/faq.html">FAQ</a></li>
                        <li><a href="pages/contact.html">Contact Us</a></li>
                        <li><a href="#" id="footerWhatsappBtn">WhatsApp Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Nolite Aspiciens Official. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Sidebar Menu -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <span class="logo-text">NOLITE ASPICIENS</span>
                </div>
                <button class="close-btn" id="closeSidebar">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <!-- Products -->
                <a href="pages/shop.html" class="nav-item">Products</a>

                <!-- Men -->
                <div class="nav-dropdown">
                    <button class="nav-item dropdown-trigger" data-dropdown="men">
                        <span>Men</span>
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6,9 12,15 18,9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-content" id="men-dropdown">
                        <a href="pages/shop.html?gender=men&category=t-shirt" class="dropdown-item">T-Shirt</a>
                        <a href="pages/shop.html?gender=men&category=hoodie" class="dropdown-item">Hoodie</a>
                        <a href="pages/shop.html?gender=men&category=jersey" class="dropdown-item">Jersey</a>
                    </div>
                </div>
            </nav>

            <!-- Sidebar CTA -->
            <div class="sidebar-cta">
                <button class="btn btn-shopee btn-full" id="sidebarShopeeBtn">
                    🛍️ Belanja di Shopee Official Store
                </button>

                <button class="btn btn-whatsapp btn-outline btn-full" id="sidebarWhatsappBtn">
                    💬 Chat via WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- WhatsApp Float -->
    <div class="whatsapp-float" id="whatsappFloat">
        <button class="whatsapp-btn">
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.525 3.488" />
            </svg>
        </button>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>