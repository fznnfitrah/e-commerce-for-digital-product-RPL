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

        <div class="flex items-center gap-6">
            @guest
                <a href="{{ route('login') }}" class="bg-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all">Masuk</a>
            @else
                <div class="flex items-center gap-4">
                    {{-- Bagian Teks & Link Admin --}}
                    <div class="flex flex-col items-end leading-tight">
                        <span class="text-blue-400 font-bold text-sm">Halo, {{ auth()->user()->name }}</span>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-[10px] text-yellow-500 hover:text-yellow-400 font-bold uppercase tracking-tighter transition-colors">
                                Ke Panel Admin
                            </a>
                        @endif
                    </div>

                    {{-- Garis Pembatas Vertikal --}}
                    <div class="h-8 w-[1px] bg-white/10"></div>

                    {{-- Tombol Keluar --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-400 hover:text-red-500 transition-colors flex items-center gap-2 group">
                            <span>Keluar</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </button>
                    </form>
                </div>
            @endguest
        </div>

    </div>
</nav>