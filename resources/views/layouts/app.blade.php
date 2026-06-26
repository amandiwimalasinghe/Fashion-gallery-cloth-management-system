<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FASHION GALLERY') }}</title>

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Premium Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Premium Page Loader */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .page-loader.loaded {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
        }

        .loader-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 3px;
            margin-bottom: 2rem;
        }

        .loader-logo span {
            color: #d4af37;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top-color: #d4af37;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Page Transition */
        .page-content {
            opacity: 0;
            transform: translateY(20px);
            animation: pageEnter 0.6s ease forwards;
            animation-delay: 0.3s;
        }

        @keyframes pageEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Premium Footer */
        .footer-premium {
            background: linear-gradient(135deg, #1a1a1a 0%, #111 100%);
            color: #fff;
            padding: 4rem 0 2rem;
        }

        .footer-premium .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
        }

        .footer-premium .footer-brand span {
            color: #d4af37;
        }

        .footer-premium .footer-links a {
            color: #999;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .footer-premium .footer-links a:hover {
            color: #d4af37;
        }

        .footer-premium .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
        }

        .footer-premium .social-icon:hover {
            background: #d4af37;
            transform: translateY(-3px);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #d4af37 0%, #b5952f 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.4);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.5);
        }

        /* Toast Notification Enhancement */
        .premium-toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(150%);
            background: #1a1a1a;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .premium-toast.show {
            transform: translateX(-50%) translateY(0);
        }

        .premium-toast.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .premium-toast.gold {
            background: linear-gradient(135deg, #d4af37 0%, #b5952f 100%);
        }

        .premium-toast i {
            font-size: 1.1rem;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo">FASHION GALLERY<span>.</span></div>
            <div class="loader-spinner"></div>
        </div>
    </div>

    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Header -->
        @isset($header)
            <header class="bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main Content -->
        <main class="page-content">
            {{ $slot }}
        </main>

        <!-- Premium Footer -->
        <footer class="footer-premium">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-gray-800">
                    <!-- Brand -->
                    <div class="md:col-span-2">
                        <div class="footer-brand mb-4">FASHION GALLERY<span>.</span></div>
                        <p class="text-gray-400 text-sm max-w-md leading-relaxed">
                            Discover exclusive fashion designs from talented local designers. Quality craftsmanship
                            meets contemporary style.
                        </p>
                        <div class="flex gap-3 mt-6">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-links">
                        <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('dashboard') }}">Shop All</a></li>
                            <li><a href="#">New Arrivals</a></li>
                            <li><a href="#">Designers</a></li>
                            <li><a href="#">About Us</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-links">
                        <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Support</h4>
                        <ul class="space-y-2">
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="#">Shipping Info</a></li>
                            <li><a href="#">Returns</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} Fashion Gallery. All rights reserved.
                    </p>
                    <div class="flex items-center gap-4 text-gray-500 text-sm">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <span>|</span>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Back to Top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Session Flash Messages -->
    @if(session('success'))
        <div class="premium-toast success" id="successToast">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="premium-toast" id="errorToast" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <script>
        // Page Loader
        window.addEventListener('load', function () {
            setTimeout(function () {
                document.getElementById('pageLoader').classList.add('loaded');
            }, 500);
        });

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Toast Notifications
        document.addEventListener('DOMContentLoaded', function () {
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');

            if (successToast) {
                setTimeout(() => successToast.classList.add('show'), 100);
                setTimeout(() => successToast.classList.remove('show'), 4000);
            }

            if (errorToast) {
                setTimeout(() => errorToast.classList.add('show'), 100);
                setTimeout(() => errorToast.classList.remove('show'), 4000);
            }
        });

        // Scroll Animation for Elements
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>