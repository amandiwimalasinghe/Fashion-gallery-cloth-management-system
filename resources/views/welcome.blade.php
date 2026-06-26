<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION GALLERY | Premium Clothing Designs</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --primary: #1a1a1a;
            --gold: #d4af37;
            --gold-light: #e5c76b;
            --gold-dark: #b5952f;
            --white: #ffffff;
            --off-white: #f9f9f9;
            --gray-100: #f1f3f5;
            --gray-200: #e9ecef;
            --gray-400: #ced4da;
            --gray-600: #868e96;
            --gray-800: #343a40;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-800);
            background-color: var(--off-white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* --- PRELOADER --- */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, #2d2d2d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .preloader.loaded {
            opacity: 0;
            visibility: hidden;
        }

        .preloader-content {
            text-align: center;
        }

        .preloader-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--white);
            letter-spacing: 3px;
            margin-bottom: 2rem;
        }

        .preloader-logo span {
            color: var(--gold);
        }

        .preloader-bar {
            width: 200px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
        }

        .preloader-progress {
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            animation: loading 1.5s ease-in-out forwards;
        }

        @keyframes loading {
            0% {
                width: 0;
            }

            100% {
                width: 100%;
            }
        }

        /* --- HEADER & NAVIGATION --- */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: var(--transition);
        }

        header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 1rem 5%;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--white);
            transition: var(--transition);
        }

        header.scrolled .logo {
            color: var(--primary);
        }

        .logo span {
            color: var(--gold);
            transition: var(--transition);
        }

        nav ul {
            display: flex;
            gap: 2.5rem;
        }

        nav a {
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.9);
            transition: var(--transition);
            position: relative;
        }

        header.scrolled nav a {
            color: var(--gray-600);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        nav a:hover,
        header.scrolled nav a:hover {
            color: var(--gold);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-login {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.5rem 0;
            position: relative;
            transition: var(--transition);
        }

        header.scrolled .btn-login {
            color: var(--primary);
        }

        .btn-login i {
            margin-right: 0.5rem;
            color: var(--gold);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        .btn-login:hover::after {
            width: 100%;
        }

        .btn-signup {
            background: linear-gradient(135deg, var(--primary) 0%, #333 100%);
            color: var(--white) !important;
            padding: 0.75rem 1.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 1px;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-signup i {
            margin-right: 0.5rem;
        }

        .btn-signup:hover {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
        }

        /* --- HERO SECTION --- */
        .hero {
            height: 100vh;
            min-height: 700px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: slowZoom 20s ease-in-out infinite alternate;
        }

        @keyframes slowZoom {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            padding: 0 2rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--gold);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 7vw, 5rem);
            margin-bottom: 1.5rem;
            color: var(--white);
            line-height: 1.1;
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.85);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.6s forwards;
            opacity: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 50px;
            transition: var(--transition);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--white);
            box-shadow: 0 10px 40px rgba(212, 175, 55, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(212, 175, 55, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-color: rgba(255, 255, 255, 0.3);
            color: var(--white);
        }

        .btn-outline:hover {
            background: var(--white);
            color: var(--primary);
            border-color: var(--white);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
        }

        .scroll-indicator a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .scroll-indicator a:hover {
            color: var(--gold);
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-10px);
            }
        }

        /* --- ANIMATIONS --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- PRODUCTS SECTION --- */
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }

        .container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 6rem 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: var(--white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
            border: 1px solid var(--gray-100);
        }

        .product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border-color: transparent;
        }

        .product-image-container {
            position: relative;
            height: 380px;
            overflow: hidden;
        }

        .product-image {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .product-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .product-category::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
        }

        .product-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, transparent 100%);
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-overlay {
            transform: translateY(0);
        }

        .btn-add-cart {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--white);
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-add-cart:hover {
            background: var(--white);
            color: var(--primary);
        }

        .product-info {
            padding: 1.5rem;
            text-align: center;
        }

        .product-name {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-family: 'Playfair Display', serif;
        }

        .product-price {
            font-weight: 700;
            color: var(--gold);
            font-size: 1.2rem;
        }

        /* --- ABOUT SECTION --- */
        .about-section {
            background: linear-gradient(135deg, var(--primary) 0%, #2d2d2d 100%);
            color: var(--white);
            padding: 6rem 5%;
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .about-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .about-section h2 {
            color: var(--white);
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .about-section p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item h3 {
            color: var(--gold);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* --- FOOTER --- */
        footer {
            background: #111;
            color: var(--gray-400);
            padding: 4rem 5% 2rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-brand .logo {
            color: var(--white);
            margin-bottom: 1rem;
            display: inline-block;
        }

        .footer-brand p {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.7;
            max-width: 300px;
        }

        .social-links {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--gold);
            color: var(--white);
            transform: translateY(-3px);
        }

        .footer-links h4 {
            color: var(--white);
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
        }

        .footer-links ul {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-links a {
            color: var(--gray-600);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--gold);
            padding-left: 5px;
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-bottom p {
            font-size: 0.85rem;
        }

        .footer-legal {
            display: flex;
            gap: 2rem;
        }

        .footer-legal a {
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .footer-legal a:hover {
            color: var(--white);
        }

        /* --- TOAST --- */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(150%);
            background: var(--primary);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
        }

        .toast i {
            color: var(--gold);
        }

        /* --- MOBILE MENU --- */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 5px;
        }

        .mobile-toggle span {
            width: 25px;
            height: 2px;
            background: var(--white);
            transition: var(--transition);
        }

        header.scrolled .mobile-toggle span {
            background: var(--primary);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            nav {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .about-stats {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .auth-buttons {
                gap: 0.5rem;
            }

            .btn-login {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-content">
            <div class="preloader-logo">FASHION GALLERY<span>.</span></div>
            <div class="preloader-bar">
                <div class="preloader-progress"></div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span>Added to Cart Successfully!</span>
    </div>

    <!-- Header -->
    <header id="header">
        <div class="logo">FASHION GALLERY<span>.</span></div>

        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#collection">Shop</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </nav>

        <div class="auth-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-signup">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-signup">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="mobile-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                alt="Fashion Background">
        </div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-sparkles"></i>
                Premium Designer Collection
            </div>

            <h1>Wear The <span>Art.</span></h1>

            <p>Exclusive limited edition designs for the modern minimalist. Discover handcrafted pieces from Sri Lanka's
                finest designers.</p>

            <div class="hero-buttons">
                <a href="#collection" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    View Collection
                </a>
                <a href="#about" class="btn btn-outline">
                    <i class="fas fa-play"></i>
                    Our Story
                </a>
            </div>
        </div>

        <div class="scroll-indicator">
            <a href="#collection">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="container" id="collection">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-star"></i>
                Featured
            </div>
            <h2 class="section-title">New Arrivals</h2>
            <p class="section-subtitle">Discover our latest collection of premium fashion pieces, handpicked for the
                discerning customer.</p>
        </div>

        <div class="product-grid">
            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1578932750294-f5075e85f44a?q=80&w=1000&auto=format&fit=crop"
                        alt="Urban Denim Jacket" class="product-image">
                    <span class="product-category">Outerwear</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Urban Denim Jacket</h3>
                    <span class="product-price">Rs. 12,500.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                        alt="Organic Cotton Tee" class="product-image">
                    <span class="product-category">Basics</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Organic Cotton Tee</h3>
                    <span class="product-price">Rs. 4,500.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-1.2.1&auto=format&fit=crop&w=972&q=80"
                        alt="Wool Overcoat" class="product-image">
                    <span class="product-category">Winter</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Wool Overcoat</h3>
                    <span class="product-price">Rs. 25,000.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?ixlib=rb-1.2.1&auto=format&fit=crop&w=934&q=80"
                        alt="Signature Black Shirt" class="product-image">
                    <span class="product-category">Formal</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Signature Black Shirt</h3>
                    <span class="product-price">Rs. 8,500.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1000&auto=format&fit=crop"
                        alt="Slim Fit Chinos" class="product-image">
                    <span class="product-category">Bottoms</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Slim Fit Chinos</h3>
                    <span class="product-price">Rs. 6,500.00</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                        alt="White Leather Sneakers" class="product-image">
                    <span class="product-category">Footwear</span>
                    <div class="product-overlay">
                        <button class="btn-add-cart add-to-cart">
                            <i class="fas fa-shopping-bag"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">White Leather Sneakers</h3>
                    <span class="product-price">Rs. 11,000.00</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="about-content">
            <div class="section-badge">
                <i class="fas fa-heart"></i>
                Our Story
            </div>
            <h2>About The Brand</h2>
            <p>We believe clothing is a form of expression. Every thread is woven with passion, ensuring you get not
                just a piece of cloth, but a piece of art. Founded in Sri Lanka, Fashion Gallery connects local
                designers with customers who appreciate quality and craftsmanship.</p>

            <div class="about-stats">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Local Designers</p>
                </div>
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Designs Created</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo">FASHION GALLERY<span>.</span></div>
                <p>Premium fashion platform connecting Sri Lankan designers with customers who appreciate quality and
                    craftsmanship.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#collection">Shop All</a></li>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Designers</a></li>
                    <li><a href="#about">About Us</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Info</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:hello@fashiongallery.lk">hello@fashiongallery.lk</a></li>
                    <li><a href="tel:+94771234567">+94 77 123 4567</a></li>
                    <li><a href="#">Colombo, Sri Lanka</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Fashion Gallery. All rights reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script>
        // Preloader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('preloader').classList.add('loaded');
            }, 1500);
        });

        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Toast notification
        const cartButtons = document.querySelectorAll('.add-to-cart');
        const toast = document.getElementById('toast');

        cartButtons.forEach(button => {
            button.addEventListener('click', () => {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            });
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>

</html>