<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Store - Produk Digital Tercepat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="icon" type="image/png" href="{{ asset('/images/logo.png') }}">
    <style>
        * {
            scroll-behavior: smooth;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #0b0d17;
            background-image: url('/images/bg2.jpg');
            background-attachment: scroll;
            background-size: auto;
            background-repeat: repeat;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated stars background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20% 30%, #eee, rgba(255,255,255,0)),
                radial-gradient(2px 2px at 60% 70%, #fff, rgba(255,255,255,0)),
                radial-gradient(1px 1px at 50% 50%, #ddd, rgba(255,255,255,0)),
                radial-gradient(1px 1px at 80% 10%, #fff, rgba(255,255,255,0)),
                radial-gradient(2px 2px at 90% 60%, #eee, rgba(255,255,255,0)),
                radial-gradient(1px 1px at 30% 80%, #fff, rgba(255,255,255,0)),
                radial-gradient(1px 1px at 10% 90%, #ddd, rgba(255,255,255,0)),
                radial-gradient(2px 2px at 40% 40%, #eee, rgba(255,255,255,0));
            background-size: 200% 200%;
            background-repeat: repeat;
            pointer-events: none;
            z-index: 1;
            opacity: 0.5;
            animation: twinkle 6s ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        main {
            position: relative;
            z-index: 2;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        }

        /* Glow effect untuk section */
        .section-glow {
            position: relative;
        }

        .section-glow::before {
            content: '';
            position: absolute;
            inset: -50px;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: -1;
            animation: pulseGlow 4s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.05); }
        }

        /* Neon border effect */
        .neon-border {
            border: 2px solid transparent;
            background: linear-gradient(rgba(255,255,255,0.05), rgba(255,255,255,0.05)) padding-box,
                        linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899) border-box;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3), inset 0 0 15px rgba(59, 130, 246, 0.1);
        }

        /* Galaxy title effect */
        .galaxy-title {
            background: linear-gradient(135deg, #3b82f6, #a78bfa, #ec4899, #3b82f6);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: galaxyShift 6s ease infinite;
        }

        @keyframes galaxyShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

       
        /* Scroll glow indicator */
        .scroll-glow {
            position: relative;
            overflow: hidden;
        }

        .scroll-glow::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, transparent, rgba(59, 130, 246, 0.2));
            pointer-events: none;
            z-index: 10;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>