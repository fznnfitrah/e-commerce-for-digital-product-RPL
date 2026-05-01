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
        body {
            background: #0b0d17;
            /* Warna gelap angkasa */
            background-image: url('/images/galaxy-bg.png');
            background-attachment: fixed;
            background-size: cover;
            color: white;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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