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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #1a1a1a;
            --accent-color: #d4af37;
            --white: #ffffff;
            --text-color: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }

        /* Animated Background */
        .guest-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }

        .guest-layout::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%),
                url('https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            animation: slowZoom 20s ease-in-out infinite alternate;
            z-index: -1;
        }

        @keyframes slowZoom {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.1);
            }
        }

        /* Floating particles effect */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(212, 175, 55, 0.3);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 20s;
        }

        .particle:nth-child(2) {
            left: 20%;
            animation-delay: 2s;
            animation-duration: 25s;
        }

        .particle:nth-child(3) {
            left: 30%;
            animation-delay: 4s;
            animation-duration: 18s;
        }

        .particle:nth-child(4) {
            left: 40%;
            animation-delay: 1s;
            animation-duration: 22s;
        }

        .particle:nth-child(5) {
            left: 50%;
            animation-delay: 3s;
            animation-duration: 30s;
        }

        .particle:nth-child(6) {
            left: 60%;
            animation-delay: 5s;
            animation-duration: 17s;
        }

        .particle:nth-child(7) {
            left: 70%;
            animation-delay: 0.5s;
            animation-duration: 23s;
        }

        .particle:nth-child(8) {
            left: 80%;
            animation-delay: 2.5s;
            animation-duration: 28s;
        }

        .particle:nth-child(9) {
            left: 90%;
            animation-delay: 4.5s;
            animation-duration: 19s;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Logo Style */
        .logo-container {
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            letter-spacing: 3px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .logo-text:hover {
            letter-spacing: 5px;
        }

        .logo-text span {
            color: var(--accent-color);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
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

        /* Card Style */
        .auth-card {
            width: 100%;
            max-width: 480px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border-radius: 1.5rem;
            overflow: hidden;
            border-top: 5px solid var(--accent-color);
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

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

        /* Decorative element */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, transparent 100%);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        /* Input Styling */
        input[type="email"],
        input[type="password"],
        input[type="text"],
        textarea,
        select {
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15) !important;
            outline: none !important;
        }

        /* Button Styling */
        button[type="submit"] {
            background: linear-gradient(135deg, var(--primary-color) 0%, #333 100%) !important;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, var(--accent-color) 0%, #b5952f 100%) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        /* Link Styles */
        a {
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--accent-color);
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            accent-color: var(--accent-color);
        }

        /* Back link */
        .back-link {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-link:hover {
            color: var(--accent-color);
            transform: translateX(-5px);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="guest-layout">
        <!-- Floating Particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Back to Home -->
        <a href="/" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>

        <!-- Logo -->
        <div class="logo-container">
            <a href="/" class="logo-text">
                FASHION GALLERY<span>.</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            {{ $slot }}
        </div>

        <!-- Footer Text -->
        <p class="text-white/60 text-sm mt-6 text-center" style="animation: fadeInUp 0.8s ease-out 0.4s both;">
            &copy; {{ date('Y') }} Fashion Gallery. Premium Fashion Platform.
        </p>
    </div>
</body>

</html>