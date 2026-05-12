// ================================
// MUSIC STORE - JAVASCRIPT
// ================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('musicStoreCart')) || [];
    updateCartCount();
    renderCartItems();

    // DOM Elements
    const cartBtn = document.getElementById('cartBtn');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartClose = document.getElementById('cartClose');
    const clearCart = document.getElementById('clearCart');
    const searchBtn = document.getElementById('searchBtn');
    const searchModal = document.getElementById('searchModal');
    const searchClose = document.getElementById('searchClose');
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const toast = document.getElementById('toast');
    const newsletterForm = document.getElementById('newsletterForm');

    // Cart Toggle
    if (cartBtn && cartSidebar) {
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.add('active');
        });

        cartClose.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
        });

        document.addEventListener('click', (e) => {
            if (!cartSidebar.contains(e.target) && !cartBtn.contains(e.target)) {
                cartSidebar.classList.remove('active');
            }
        });
    }

    // Clear Cart
    if (clearCart) {
        clearCart.addEventListener('click', () => {
            cart = [];
            saveCart();
            renderCartItems();
            updateCartCount();
            showToast('Carrito vaciado');
        });
    }

    // Search Modal
    if (searchBtn && searchModal) {
        searchBtn.addEventListener('click', () => {
            searchModal.classList.add('active');
            document.getElementById('searchInput').focus();
        });

        searchClose.addEventListener('click', () => {
            searchModal.classList.remove('active');
        });

        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                searchModal.classList.remove('active');
            }
        });
    }

    // Mobile Menu
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });
    }

    // Add to Cart buttons
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productCard = btn.closest('.product-card');
            const productId = productCard.dataset.id;
            const productName = productCard.querySelector('.product-name').textContent;
            const productPrice = productCard.querySelector('.price-current').textContent;
            const productImage = productCard.querySelector('.product-image img').src;

            addToCart({
                id: productId,
                name: productName,
                price: parseFloat(productPrice.replace(/[$,]/g, '')),
                image: productImage,
                quantity: 1
            });

            showToast('Producto añadido al carrito');
        });
    });

    // Newsletter Form
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            showToast('¡Gracias por suscribirte!');
            newsletterForm.reset();
        });
    }

    // Add to Cart Function
    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push(product);
        }

        saveCart();
        updateCartCount();
        renderCartItems();
    }

    // Save Cart to localStorage
    function saveCart() {
        localStorage.setItem('musicStoreCart', JSON.stringify(cart));
    }

    // Update Cart Count
    function updateCartCount() {
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartCountEl = document.getElementById('cartCount');
        if (cartCountEl) {
            cartCountEl.textContent = count;
        }
    }

    // Render Cart Items
    function renderCartItems() {
        const cartItemsEl = document.getElementById('cartItems');
        const cartTotalEl = document.getElementById('cartTotal');

        if (!cartItemsEl) return;

        if (cart.length === 0) {
            cartItemsEl.innerHTML = `
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Tu carrito está vacío</p>
                    <a href="products.html" class="btn btn-primary">Ver Productos</a>
                </div>
            `;
            if (cartTotalEl) cartTotalEl.textContent = '$0.00';
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            html += `
                <div class="cart-item" data-id="${item.id}">
                    <div class="cart-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-details">
                        <h4 class="cart-item-name">${item.name}</h4>
                        <p class="cart-item-price">$${itemTotal.toFixed(2)}</p>
                        <div class="cart-item-quantity">
                            <button class="qty-btn decrease" data-id="${item.id}">-</button>
                            <span>${item.quantity}</span>
                            <button class="qty-btn increase" data-id="${item.id}">+</button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        });

        cartItemsEl.innerHTML = html;
        if (cartTotalEl) cartTotalEl.textContent = '$' + total.toFixed(2);

        // Add event listeners to quantity buttons
        document.querySelectorAll('.qty-btn.decrease').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.id, -1));
        });

        document.querySelectorAll('.qty-btn.increase').forEach(btn => {
            btn.addEventListener('click', () => updateQuantity(btn.dataset.id, 1));
        });

        document.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', () => removeFromCart(btn.dataset.id));
        });
    }

    // Update Quantity
    function updateQuantity(id, change) {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(id);
            } else {
                saveCart();
                updateCartCount();
                renderCartItems();
            }
        }
    }

    // Remove from Cart
    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        saveCart();
        updateCartCount();
        renderCartItems();
        showToast('Producto eliminado');
    }

    // Show Toast Notification
    function showToast(message) {
        if (toast) {
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.add('active');
            setTimeout(() => {
                toast.classList.remove('active');
            }, 3000);
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (searchModal) searchModal.classList.remove('active');
            if (cartSidebar) cartSidebar.classList.remove('active');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});