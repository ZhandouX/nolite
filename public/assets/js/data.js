// Product Data
const products = [
    {
        id: 1,
        name: 'NOLITE ASPICIENS - Essential Black Tee | Midnight Black',
        category: 't-shirt',
        price: 299000,
        originalPrice: 349000,
        images: [
            'https://images.unsplash.com/photo-1744551611811-4a1c48b190e5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsJTIwYmxhY2slMjB0LXNoaXJ0JTIwZmFzaGlvbnxlbnwxfHx8fDE3NTg1ODQ2NTl8MA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1556630184-066f7ac4e15f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsJTIwd2hpdGUlMjBzaGlydCUyMGZhc2hpb258ZW58MXx8fHwxNzU4NTg0NjY1fDA&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'Premium cotton t-shirt dengan cut minimalis. Bahan berkualitas tinggi, nyaman digunakan sehari-hari.',
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
        colors: ['Black', 'White'],
        stock: 25,
        featured: true,
        shopeeUrl: 'https://shopee.co.id/product/123456789',
        tags: ['new-arrival', 'bestseller']
    },
    {
        id: 2,
        name: 'NOLITE ASPICIENS - Oversized Hoodie | Shadow Black',
        category: 'hoodie',
        price: 549000,
        originalPrice: 599000,
        images: [
            'https://images.unsplash.com/photo-1627811269913-c0d964da1eb2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibGFjayUyMGhvb2RpZSUyMG1pbmltYWwlMjBmYXNoaW9ufGVufDF8fHx8MTc1ODU4NDY2Mnww&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'Hoodie oversized dengan material fleece premium. Cocok untuk cuaca dingin dan gaya streetwear.',
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
        colors: ['Black', 'Dark Grey'],
        stock: 15,
        featured: true,
        shopeeUrl: 'https://shopee.co.id/product/123456790',
        tags: ['new-arrival', 'limited']
    },
    {
        id: 3,
        name: 'NOLITE ASPICIENS - Classic Jersey | Pure White',
        category: 'jersey',
        price: 399000,
        originalPrice: 449000,
        images: [
            'https://images.unsplash.com/photo-1556630184-066f7ac4e15f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsJTIwd2hpdGUlMjBzaGlydCUyMGZhc2hpb258ZW58MXx8fHwxNzU4NTg0NjY1fDA&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'Jersey klasik dengan bahan polyester premium. Breathable dan perfect untuk aktivitas olahraga.',
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
        colors: ['White', 'Black'],
        stock: 20,
        featured: false,
        shopeeUrl: 'https://shopee.co.id/product/123456791',
        tags: ['sport', 'classic']
    },
    {
        id: 4,
        name: 'NOLITE ASPICIENS - Minimalist Tee | Storm Grey',
        category: 't-shirt',
        price: 279000,
        originalPrice: 329000,
        images: [
            'https://images.unsplash.com/photo-1744551611811-4a1c48b190e5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsJTIwYmxhY2slMjB0LXNoaXJ0JTIwZmFzaGlvbnxlbnwxfHx8fDE3NTg1ODQ2NTl8MA&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'T-shirt dengan desain minimalis dan cutting modern. Bahan cotton combed 30s berkualitas tinggi.',
        sizes: ['S', 'M', 'L', 'XL'],
        colors: ['Grey', 'Navy'],
        stock: 30,
        featured: true,
        shopeeUrl: 'https://shopee.co.id/product/123456792',
        tags: ['bestseller', 'basic']
    },
    {
        id: 5,
        name: 'NOLITE ASPICIENS - Premium Hoodie | Charcoal Black',
        category: 'hoodie',
        price: 629000,
        originalPrice: 679000,
        images: [
            'https://images.unsplash.com/photo-1627811269913-c0d964da1eb2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibGFjayUyMGhvb2RpZSUyMG1pbmltYWwlMjBmYXNoaW9ufGVufDF8fHx8MTc1ODU4NDY2Mnww&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'Hoodie premium dengan detail embossed logo. Material fleece tebal dan lining halus.',
        sizes: ['M', 'L', 'XL', 'XXL'],
        colors: ['Charcoal', 'Black'],
        stock: 12,
        featured: false,
        shopeeUrl: 'https://shopee.co.id/product/123456793',
        tags: ['premium', 'limited']
    },
    {
        id: 6,
        name: 'NOLITE ASPICIENS - Sports Jersey | Electric Red',
        category: 'jersey',
        price: 459000,
        originalPrice: 499000,
        images: [
            'https://images.unsplash.com/photo-1556630184-066f7ac4e15f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsJTIwd2hpdGUlMjBzaGlydCUyMGZhc2hpb258ZW58MXx8fHwxNzU4NTg0NjY1fDA&ixlib=rb-4.1.0&q=80&w=1080'
        ],
        description: 'Jersey sport dengan aksen merah khas brand. Dry-fit technology untuk performa maksimal.',
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
        colors: ['Red', 'White', 'Black'],
        stock: 18,
        featured: true,
        shopeeUrl: 'https://shopee.co.id/product/123456794',
        tags: ['new-arrival', 'sport']
    }
];

// Hero Slides Data
const heroSlides = [
    {
        id: 1,
        image: "https://images.unsplash.com/photo-1736555142217-916540c7f1b7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaW5pbWFsaXN0JTIwZmFzaGlvbiUyMHN0cmVldHdlYXJ8ZW58MXx8fHwxNzU4NTg1NzQ5fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        title: "MINIMALIST",
        subtitle: "STREETWEAR",
        description: "Koleksi minimalis dengan gaya streetwear yang elegan dan trendy"
    },
    {
        id: 2,
        image: "https://images.unsplash.com/photo-1624708593528-383fdb07eda5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxibGFjayUyMHdoaXRlJTIwZmFzaGlvbiUyMG1vZGVsfGVufDF8fHx8MTc1ODU4NTc1MXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        title: "BLACK & WHITE",
        subtitle: "COLLECTION",
        description: "Perpaduan sempurna hitam dan putih untuk tampilan yang timeless"
    },
    {
        id: 3,
        image: "https://images.unsplash.com/flagged/photo-1564723150667-e0c8d8ea3246?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx1cmJhbiUyMHN0cmVldHdlYXIlMjBmYXNoaW9ufGVufDF8fHx8MTc1ODU4NTc1NHww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        title: "URBAN",
        subtitle: "STYLE",
        description: "Fashion urban yang cocok untuk aktivitas sehari-hari di kota"
    },
    {
        id: 4,
        image: "https://images.unsplash.com/photo-1632773004171-02bc1c4a726a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBjbG90aGluZyUyMGZhc2hpb258ZW58MXx8fHwxNzU4NTI4MDcyfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        title: "MODERN",
        subtitle: "CLOTHING",
        description: "Pakaian modern dengan cutting edge design dan material premium"
    },
    {
        id: 5,
        image: "https://images.unsplash.com/photo-1495121605193-b116b5b9c5fe?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx0cmVuZHklMjBmYXNoaW9uJTIwb3V0Zml0fGVufDF8fHx8MTc1ODU4NTc1OXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral",
        title: "TRENDY",
        subtitle: "FASHION",
        description: "Mengikuti tren fashion terkini dengan sentuhan khas Nolite Aspiciens"
    }
];

// Utility Functions
const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};

const getProductsByCategory = (category) => {
    if (!category) return products;
    return products.filter(product => product.category === category);
};

const getFeaturedProducts = () => {
    return products.filter(product => product.featured);
};

const getProductById = (id) => {
    return products.find(product => product.id === parseInt(id));
};

// State Management
const state = {
    user: null,
    cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
    wishlistItems: JSON.parse(localStorage.getItem('wishlistItems')) || [],
    currentSlide: 0,
    isAutoPlaying: true,
    isSidebarOpen: false
};

// Save state to localStorage
const saveToLocalStorage = () => {
    localStorage.setItem('cartItems', JSON.stringify(state.cartItems));
    localStorage.setItem('wishlistItems', JSON.stringify(state.wishlistItems));
    if (state.user) {
        localStorage.setItem('user', JSON.stringify(state.user));
    } else {
        localStorage.removeItem('user');
    }
};

// Cart Functions
const addToCart = (product, size = 'M', quantity = 1) => {
    const existingItem = state.cartItems.find(
        item => item.id === product.id && item.size === size
    );

    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        state.cartItems.push({ ...product, size, quantity });
    }

    saveToLocalStorage();
    updateCartUI();
};

const removeFromCart = (productId, size) => {
    state.cartItems = state.cartItems.filter(
        item => !(item.id === productId && item.size === size)
    );
    saveToLocalStorage();
    updateCartUI();
};

const updateCartQuantity = (productId, size, quantity) => {
    if (quantity === 0) {
        removeFromCart(productId, size);
        return;
    }

    const item = state.cartItems.find(
        item => item.id === productId && item.size === size
    );
    
    if (item) {
        item.quantity = quantity;
        saveToLocalStorage();
        updateCartUI();
    }
};

// Wishlist Functions
const addToWishlist = (product) => {
    const exists = state.wishlistItems.find(item => item.id === product.id);
    
    if (exists) {
        state.wishlistItems = state.wishlistItems.filter(item => item.id !== product.id);
    } else {
        state.wishlistItems.push(product);
    }
    
    saveToLocalStorage();
    updateWishlistUI();
};

const isInWishlist = (productId) => {
    return state.wishlistItems.some(item => item.id === productId);
};

// UI Update Functions
const updateCartUI = () => {
    const cartCount = state.cartItems.reduce((total, item) => total + item.quantity, 0);
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) {
        cartBadge.textContent = cartCount;
        cartBadge.style.display = cartCount > 0 ? 'flex' : 'none';
    }
};

const updateWishlistUI = () => {
    const wishlistCount = state.wishlistItems.length;
    const wishlistBadge = document.getElementById('wishlistCount');
    if (wishlistBadge) {
        wishlistBadge.textContent = wishlistCount;
        wishlistBadge.style.display = wishlistCount > 0 ? 'flex' : 'none';
    }
};

// User Functions
const login = (userData) => {
    state.user = userData;
    saveToLocalStorage();
    updateUserUI();
};

const logout = () => {
    state.user = null;
    saveToLocalStorage();
    updateUserUI();
};

const updateUserUI = () => {
    const userInfo = document.getElementById('userInfo');
    const userName = document.getElementById('userName');
    const userEmail = document.getElementById('userEmail');
    const accountLink = document.getElementById('accountLink');
    const adminLink = document.getElementById('adminLink');
    const loginBtn = document.getElementById('loginBtn');
    const logoutBtn = document.getElementById('logoutBtn');

    if (state.user) {
        if (userInfo) userInfo.style.display = 'block';
        if (userName) userName.textContent = state.user.name;
        if (userEmail) userEmail.textContent = state.user.email;
        if (accountLink) accountLink.style.display = 'block';
        if (adminLink) adminLink.style.display = state.user.isAdmin ? 'block' : 'none';
        if (loginBtn) loginBtn.style.display = 'none';
        if (logoutBtn) logoutBtn.style.display = 'block';
    } else {
        if (userInfo) userInfo.style.display = 'none';
        if (accountLink) accountLink.style.display = 'none';
        if (adminLink) adminLink.style.display = 'none';
        if (loginBtn) loginBtn.style.display = 'block';
        if (logoutBtn) logoutBtn.style.display = 'none';
    }
};

// Initialize state from localStorage
const initializeState = () => {
    const savedUser = localStorage.getItem('user');
    if (savedUser) {
        state.user = JSON.parse(savedUser);
    }
    
    updateCartUI();
    updateWishlistUI();
    updateUserUI();
};

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        products,
        heroSlides,
        formatPrice,
        getProductsByCategory,
        getFeaturedProducts,
        getProductById,
        state,
        addToCart,
        removeFromCart,
        updateCartQuantity,
        addToWishlist,
        isInWishlist,
        login,
        logout,
        updateCartUI,
        updateWishlistUI,
        updateUserUI,
        initializeState
    };
}