<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - J-Store</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#0a0a0a] text-white overflow-hidden">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-black/60 backdrop-blur-xl border-r border-white/10 p-6 flex flex-col">
            <div class="mb-10">
                <h1 class="text-2xl font-black italic tracking-tighter uppercase">
                    J-<span class="text-[#DFFF00]">ADMIN</span>
                </h1>
            </div>

            <nav class="flex-1 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'text-gray-400 hover:bg-white/5' }} rounded-xl font-bold transition">
                    <span>📊</span> Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
                    <span>👥</span> Users
                </a>

                <a href="{{ route('admin.produk.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.produk.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
                    <span>📦</span> Produk
                </a>

                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
                    <span>📂</span> Kategori
                </a>

                <a href="#" class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                    <span>🎟️</span> Promo & Voucher
                </a>

                <a href="#" class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                    <span>🧾</span> Riwayat Transaksi
                </a>
            </nav>

            <div class="pt-6 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl w-full transition">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-10 overflow-y-auto relative">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <img src="{{ asset('images/galaxy-bg2.png') }}" class="w-full h-full object-cover">
            </div>

            <div class="relative z-10">
                {{-- HEADER --}}
                <header class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-3xl font-bold">@yield('header_title')</h2>
                        <p class="text-gray-400">@yield('header_subtitle')</p>
                    </div>

                    <div class="bg-white/5 px-4 py-2 rounded-lg border border-white/10">
                        <span class="text-sm text-gray-400">{{ now()->format('d M Y') }}</span>
                    </div>
                </header>

                {{-- Konten Halaman --}}
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>