<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Store - Tu tienda de música</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-music"></i>
                    <span>Music Store</span>
                </a>
                <nav class="nav">
                    <a href="{{ route('home') }}" class="nav-link active">Inicio</a>
                    <a href="{{ route('products.index') }}" class="nav-link">Productos</a>
                    <a href="{{ route('categories.index') }}" class="nav-link">Categorías</a>
                    <a href="{{ route('about') }}" class="nav-link">Nosotros</a>
                </nav>
                <div class="header-actions">
                    <button class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="cart-btn" id="cartBtn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cartCount">0</span>
                    </button>
                </div>
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <nav class="mobile-nav">
            <a href="{{ route('home') }}" class="mobile-nav-link">Inicio</a>
            <a href="{{ route('products.index') }}" class="mobile-nav-link">Productos</a>
            <a href="{{ route('categories.index') }}" class="mobile-nav-link">Categorías</a>
            <a href="{{ route('about') }}" class="mobile-nav-link">Nosotros</a>
        </nav>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Descubre el sonido perfecto</h1>
            <p class="hero-subtitle">Instrumentos musicales, equipo de audio y accesorios de alta calidad para músicos profesionales y entusiastas.</p>
            <div class="hero-buttons">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Ver Productos</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Explorar Categorías</a>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Categorías</h2>
                <a href="{{ route('categories.index') }}" class="section-link">Ver todas <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="categories-grid">
                @foreach($categories as $category)
                <div class="category-card" data-category="{{ $category->slug }}">
                    <div class="category-icon">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <span class="category-count">{{ $category->products_count }} productos</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Productos Destacados</h2>
                <a href="{{ route('products.index') }}" class="section-link">Ver todos <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="products-grid">
                @foreach($featuredProducts as $product)
                <div class="product-card" data-id="{{ $product->id }}">
                    <div class="product-image">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                        @if($product->badge)
                        <div class="product-badge {{ $product->badge_class }}">{{ $product->badge }}</div>
                        @endif
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="product-action-btn" title="Ver detalles"><i class="fas fa-eye"></i></a>
                            <button class="product-action-btn add-to-cart" title="Añadir al carrito" data-id="{{ $product->id }}"><i class="fas fa-shopping-cart"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->rating)
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span>({{ $product->reviews_count }})</span>
                        </div>
                        <div class="product-price">
                            @if($product->discount)
                                <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                <span class="price-current">${{ number_format($product->final_price, 2) }}</span>
                            @else
                                <span class="price-current">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="feature-title">Envío Gratis</h3>
                    <p class="feature-desc">En pedidos mayores a $99</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Garantía</h3>
                    <p class="feature-desc">2 años de garantía</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h3 class="feature-title">Devolución</h3>
                    <p class="feature-desc">30 días sin costo</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">Soporte 24/7</h3>
                    <p class="feature-desc">Siempre disponibles</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Únete a nuestro Newsletter</h2>
                <p class="newsletter-desc">Recibe ofertas exclusivas y las últimas novedades en instrumentos musicales.</p>
                <form class="newsletter-form" id="newsletterForm">
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="btn btn-primary">Suscribirse</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Cart Sidebar -->
    @include('layouts.cart-sidebar')

    <!-- Search Modal -->
    @include('layouts.search-modal')

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <div class="toast-content">
            <i class="fas fa-check-circle"></i>
            <span id="toastMessage">Producto añadido al carrito</span>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>