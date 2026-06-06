<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - J-Store</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                <a href="{{ route('admin.brand.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.brand.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
                    <span>🏷️</span> Brand
                </a>

                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
                    <span>📂</span> Kategori
                </a>

                <a href="{{ route('admin.promo.index') }}"
                    class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.promo.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}zz rounded-xl transition">
                    <span>🎟️</span> Promo & Voucher
                </a>

                <a href="{{ route('admin.transaksi.riwayat') }}" class="flex items-center gap-3 p-3 {{ request()->routeIs('admin.transaksi.riwayat') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl transition">
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
        <main class="h-screen flex-1 p-10 overflow-y-auto relative">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <img src="{{ asset('images/bg2.jpg') }}" class="w-full h-full object-cover">
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
<script>
    // Gunakan event delegation agar lebih aman untuk elemen yang mungkin dimuat dinamis
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete')) {
            const button = e.target.closest('.btn-delete');
            const form = button.closest('form');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Tindakan ini akan menghapus data dari galaksi J-Store selamanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7c3aed', // Purple Theme
                cancelButtonColor: '#374151',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#111827',
                color: '#ffffff',
                backdrop: `rgba(0,0,123,0.4)` // Efek overlay galaxy
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
</script>

</html>