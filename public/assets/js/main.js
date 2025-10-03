// Main JavaScript File for Nolite Aspiciens Website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize application
    initializeApp();
});

function initializeApp() {
    // Initialize state
    initializeState();
    
    // Initialize components
    initializeHeroSlider();
    initializeNavigation();
    initializeProductGrid();
    initializeEventListeners();
    
    console.log('Nolite Aspiciens website initialized');
}

// Hero Slider Implementation
function initializeHeroSlider() {
    const slidesContainer = document.getElementById('slidesContainer');
    const indicatorsContainer = document.getElementById('slideIndicators');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const slideCounter = document.getElementById('slideCounter');
    const heroTitleMain = document.getElementById('heroTitleMain');
    const heroTitleAccent = document.getElementById('heroTitleAccent');
    const heroDescription = document.getElementById('heroDescription');

    if (!slidesContainer) return;

    // Create slides
    heroSlides.forEach((slide, index) => {
        const slideElement = createSlideElement(slide, index);
        slidesContainer.appendChild(slideElement);
    });

    // Create indicators
    heroSlides.forEach((_, index) => {
        const indicator = createIndicatorElement(index);
        indicatorsContainer.appendChild(indicator);
    });

    // Auto-slide functionality
    let autoSlideInterval;

    function startAutoSlide() {
        if (!state.isAutoPlaying) return;
        
        autoSlideInterval = setInterval(() => {
            nextSlide();
        }, 5000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    function nextSlide() {
        state.currentSlide = (state.currentSlide + 1) % heroSlides.length;
        updateSlider();
    }

    function prevSlide() {
        state.currentSlide = (state.currentSlide - 1 + heroSlides.length) % heroSlides.length;
        updateSlider();
    }

    function goToSlide(index) {
        state.currentSlide = index;
        updateSlider();
    }

    function updateSlider() {
        // Update slides
        const slides = slidesContainer.querySelectorAll('.slide');
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === state.currentSlide);
        });

        // Update indicators
        const indicators = indicatorsContainer.querySelectorAll('.indicator');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === state.currentSlide);
        });

        // Update content
        const currentSlideData = heroSlides[state.currentSlide];
        if (heroTitleMain) heroTitleMain.textContent = currentSlideData.title;
        if (heroTitleAccent) heroTitleAccent.textContent = currentSlideData.subtitle;
        if (heroDescription) heroDescription.textContent = currentSlideData.description;

        // Update counter
        if (slideCounter) {
            slideCounter.textContent = `${state.currentSlide + 1} / ${heroSlides.length}`;
        }
    }

    // Event listeners
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    // Indicator click events
    indicatorsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('indicator')) {
            const index = parseInt(e.target.dataset.index);
            goToSlide(index);
        }
    });

    // Pause auto-slide on hover
    const heroSlider = document.getElementById('heroSlider');
    if (heroSlider) {
        heroSlider.addEventListener('mouseenter', () => {
            state.isAutoPlaying = false;
            stopAutoSlide();
        });

        heroSlider.addEventListener('mouseleave', () => {
            state.isAutoPlaying = true;
            startAutoSlide();
        });
    }

    // Initialize slider
    updateSlider();
    startAutoSlide();
}

function createSlideElement(slide, index) {
    const slideDiv = document.createElement('div');
    slideDiv.className = `slide ${index === 0 ? 'active' : ''}`;
    
    slideDiv.innerHTML = `
        <img src="${slide.image}" alt="${slide.title} ${slide.subtitle}" loading="lazy">
        <div class="slide-overlay"></div>
    `;
    
    return slideDiv;
}

function createIndicatorElement(index) {
    const indicator = document.createElement('button');
    indicator.className = `indicator ${index === 0 ? 'active' : ''}`;
    indicator.dataset.index = index;
    indicator.setAttribute('aria-label', `Go to slide ${index + 1}`);
    
    return indicator;
}

// Navigation Implementation
function initializeNavigation() {
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const closeSidebar = document.getElementById('closeSidebar');

    // Sidebar toggle
    if (menuBtn) {
        menuBtn.addEventListener('click', openSidebar);
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', closeSidebarFunc);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebarFunc);
    }

    // Dropdown toggles
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const dropdownId = trigger.dataset.dropdown + '-dropdown';
            const dropdown = document.getElementById(dropdownId);
            
            if (dropdown) {
                dropdown.classList.toggle('show');
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-content').forEach(content => {
                    if (content !== dropdown) {
                        content.classList.remove('show');
                    }
                });
            }
        });
    });

    function openSidebar() {
        state.isSidebarOpen = true;
        if (sidebar) sidebar.classList.add('show');
        if (sidebarOverlay) sidebarOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebarFunc() {
        state.isSidebarOpen = false;
        if (sidebar) sidebar.classList.remove('show');
        if (sidebarOverlay) sidebarOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    // User dropdown
    const userBtn = document.getElementById('userBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdown.contains(e.target) && !userBtn.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    }
}

// Product Grid Implementation
function initializeProductGrid() {
    const gridContainer = document.getElementById('featuredProductsGrid');
    if (!gridContainer) return;

    const featuredProducts = getFeaturedProducts();
    
    featuredProducts.slice(0, 6).forEach(product => {
        const productCard = createProductCard(product);
        gridContainer.appendChild(productCard);
    });
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.dataset.productId = product.id;

    const hasDiscount = product.originalPrice > product.price;
    const discountPercent = hasDiscount ? 
        Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100) : 0;

    card.innerHTML = `
        <div class="product-image">
            <img src="${product.images[0]}" alt="${product.name}" loading="lazy">
            <div class="product-actions">
                <button class="action-btn wishlist-btn" data-product-id="${product.id}" aria-label="Add to wishlist">
                    <svg class="icon" viewBox="0 0 24 24" fill="${isInWishlist(product.id) ? 'currentColor' : 'none'}" stroke="currentColor" stroke-width="2">
                        <path d="20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </button>
                <button class="action-btn quick-view-btn" data-product-id="${product.id}" aria-label="Quick view">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
            ${hasDiscount ? `<div class="discount-badge">-${discountPercent}%</div>` : ''}
        </div>
        <div class="product-info">
            <h3 class="product-name">${product.name}</h3>
            <div class="product-price">
                <span class="price-current">${formatPrice(product.price)}</span>
                ${hasDiscount ? `<span class="price-original">${formatPrice(product.originalPrice)}</span>` : ''}
            </div>
            <div class="product-actions-bottom">
                <button class="btn-cart" data-product-id="${product.id}">Add to Cart</button>
                <button class="btn-view" data-product-id="${product.id}">View</button>
            </div>
        </div>
    `;

    // Add event listeners
    addProductCardEventListeners(card, product);
    
    return card;
}

function addProductCardEventListeners(card, product) {
    // Wishlist button
    const wishlistBtn = card.querySelector('.wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            addToWishlist(product);
            updateWishlistButton(wishlistBtn, product.id);
        });
    }

    // Add to cart button
    const cartBtn = card.querySelector('.btn-cart');
    if (cartBtn) {
        cartBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            addToCart(product);
            showNotification('Product added to cart!', 'success');
        });
    }

    // View button
    const viewBtn = card.querySelector('.btn-view');
    if (viewBtn) {
        viewBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            window.location.href = `pages/product.html?id=${product.id}`;
        });
    }

    // Quick view button
    const quickViewBtn = card.querySelector('.quick-view-btn');
    if (quickViewBtn) {
        quickViewBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            showProductQuickView(product);
        });
    }
}

function updateWishlistButton(button, productId) {
    const svg = button.querySelector('svg');
    const isWishlisted = isInWishlist(productId);
    
    if (svg) {
        svg.setAttribute('fill', isWishlisted ? 'currentColor' : 'none');
    }
}

// Event Listeners
function initializeEventListeners() {
    // External links
    const shopeeButtons = document.querySelectorAll('#shopeeBtn, #sidebarShopeeBtn');
    shopeeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            window.open('https://shopee.co.id/nolite.aspiciens.official', '_blank');
        });
    });

    const whatsappButtons = document.querySelectorAll('#whatsappBtn, #sidebarWhatsappBtn, #footerWhatsappBtn');
    whatsappButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const message = encodeURIComponent('Halo, saya ingin bertanya tentang produk Nolite Aspiciens');
            window.open(`https://wa.me/6281234567890?text=${message}`, '_blank');
        });
    });

    // WhatsApp float button
    const whatsappFloat = document.getElementById('whatsappFloat');
    if (whatsappFloat) {
        whatsappFloat.addEventListener('click', () => {
            const message = encodeURIComponent('Halo, saya ingin melihat koleksi terbaru Nolite Aspiciens');
            window.open(`https://wa.me/6281234567890?text=${message}`, '_blank');
        });
    }

    // User authentication
    const loginBtn = document.getElementById('loginBtn');
    const logoutBtn = document.getElementById('logoutBtn');

    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            handleLogin();
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            logout();
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                userDropdown.classList.remove('show');
            }
        });
    }

    // Search functionality
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            // Redirect to shop page with search functionality
            window.location.href = 'pages/shop.html';
        });
    }

    // Cart and wishlist buttons
    const cartBtn = document.getElementById('cartBtn');
    const wishlistBtn = document.getElementById('wishlistBtn');

    if (cartBtn) {
        cartBtn.addEventListener('click', () => {
            window.location.href = 'pages/cart.html';
        });
    }

    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', () => {
            window.location.href = 'pages/account.html?tab=wishlist';
        });
    }
}

// User Authentication
function handleLogin() {
    // Mock login - in real app, this would be a proper login form/modal
    const mockUser = {
        id: 1,
        name: 'John Doe',
        email: 'john@example.com',
        isAdmin: false
    };
    
    login(mockUser);
    const userDropdown = document.getElementById('userDropdown');
    if (userDropdown) {
        userDropdown.classList.remove('show');
    }
    
    showNotification('Logged in successfully!', 'success');
}

// Utility Functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add styles
    Object.assign(notification.style, {
        position: 'fixed',
        top: '100px',
        right: '20px',
        background: type === 'success' ? '#16a34a' : type === 'error' ? '#dc2626' : '#3b82f6',
        color: 'white',
        padding: '12px 20px',
        borderRadius: '8px',
        zIndex: '9999',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease-in-out'
    });
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function showProductQuickView(product) {
    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.cssText = `
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    `;

    // Create modal content
    const modal = document.createElement('div');
    modal.className = 'quick-view-modal';
    modal.style.cssText = `
        background: white;
        border-radius: 12px;
        max-width: 600px;
        width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        position: relative;
    `;

    const hasDiscount = product.originalPrice > product.price;

    modal.innerHTML = `
        <button class="close-modal" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 24px; cursor: pointer; z-index: 10;">&times;</button>
        <div style="padding: 30px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
                <div>
                    <img src="${product.images[0]}" alt="${product.name}" style="width: 100%; border-radius: 8px;">
                </div>
                <div>
                    <h2 style="margin-bottom: 15px; font-size: 18px; line-height: 1.4;">${product.name}</h2>
                    <div style="margin-bottom: 15px;">
                        <span style="font-size: 24px; font-weight: bold; color: #dc2626;">${formatPrice(product.price)}</span>
                        ${hasDiscount ? `<span style="font-size: 16px; color: #6b7280; text-decoration: line-through; margin-left: 10px;">${formatPrice(product.originalPrice)}</span>` : ''}
                    </div>
                    <p style="color: #6b7280; margin-bottom: 20px; line-height: 1.6;">${product.description}</p>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Size:</label>
                        <select class="size-select" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px;">
                            ${product.sizes.map(size => `<option value="${size}">${size}</option>`).join('')}
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button class="add-to-cart-modal" style="flex: 1; background: #111827; color: white; padding: 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">Add to Cart</button>
                        <button class="wishlist-modal" style="background: ${isInWishlist(product.id) ? '#dc2626' : 'white'}; color: ${isInWishlist(product.id) ? 'white' : '#111827'}; border: 1px solid #d1d5db; padding: 12px; border-radius: 6px; cursor: pointer;">♡</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    // Event listeners
    const closeBtn = modal.querySelector('.close-modal');
    const addToCartBtn = modal.querySelector('.add-to-cart-modal');
    const wishlistBtn = modal.querySelector('.wishlist-modal');
    const sizeSelect = modal.querySelector('.size-select');

    closeBtn.addEventListener('click', () => {
        document.body.removeChild(overlay);
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            document.body.removeChild(overlay);
        }
    });

    addToCartBtn.addEventListener('click', () => {
        const selectedSize = sizeSelect.value;
        addToCart(product, selectedSize);
        showNotification('Product added to cart!', 'success');
        document.body.removeChild(overlay);
    });

    wishlistBtn.addEventListener('click', () => {
        addToWishlist(product);
        wishlistBtn.style.background = isInWishlist(product.id) ? '#dc2626' : 'white';
        wishlistBtn.style.color = isInWishlist(product.id) ? 'white' : '#111827';
        showNotification(
            isInWishlist(product.id) ? 'Added to wishlist!' : 'Removed from wishlist!', 
            'success'
        );
    });
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        // Close sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        if (sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Close user dropdown
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown && userDropdown.classList.contains('show')) {
            userDropdown.classList.remove('show');
        }

        // Close any modals
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            if (modal.parentNode) {
                modal.parentNode.removeChild(modal);
            }
        });
    }
});

// Smooth scrolling for anchor links
document.addEventListener('click', (e) => {
    if (e.target.tagName === 'A' && e.target.getAttribute('href')?.startsWith('#')) {
        e.preventDefault();
        const targetId = e.target.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// Initialize on page load
window.addEventListener('load', () => {
    // Hide loading indicators if any
    const loadingElements = document.querySelectorAll('.loading');
    loadingElements.forEach(el => el.style.display = 'none');
    
    // Initialize performance optimizations
    if ('IntersectionObserver' in window) {
        // Lazy load images
        const images = document.querySelectorAll('img[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src; // Trigger load
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
});