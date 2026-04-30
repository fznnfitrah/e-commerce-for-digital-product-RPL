<nav class="glass-card sticky top-0 z-50 px-4 py-3">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-8">
            <h1 class="text-2xl font-bold text-blue-400">J-Store</h1>
            <div class="hidden md:flex gap-6 text-sm">
                <a href="#" class="hover:text-blue-400">Top Up</a>
                <a href="#" class="hover:text-blue-400">Riwayat Pembelian</a>
            </div>
        </div>
        
        <div class="flex-1 max-w-md w-full">
            <input type="text" placeholder="Cari produk..." class="w-full bg-gray-800 border-none rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex gap-4">
            @guest
                <a href="#" class="bg-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">Masuk</a>
            @else
                <span class="text-blue-400">Halo, {{ auth()->user()->name }}</span>
            @endguest
        </div>
    </div>
</nav>