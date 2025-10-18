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