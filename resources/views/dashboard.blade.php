@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="relative w-full overflow-hidden h-87.5 md:h-125 bg-[#0b0e14] section-glow">
    <img src="{{ asset('images/hero-bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
    <img src="{{ asset('images/hero-mobile-legend.png') }}" class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain translate-x-10 md:translate-x-20 z-10 float">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0b0e14] via-[#0b0e14]/80 to-transparent"></div>
    {{-- Glow effect behind hero --}}
    <div class="absolute -top-1/4 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute inset-0 flex items-center z-20">
        <div class="container mx-auto px-4 md:px-16">
            <h2 class="text-4xl md:text-6xl font-black italic uppercase leading-tight text-white galaxy-title">
                BELI PRODUK <br>
                <span class="text-blue-500">DIGITAL</span> MUDAH <br>
                DAN CEPAT
            </h2>
            <p class="mt-4 mb-6 max-w-xl text-gray-400">
                Top up game favorit, Aplikasi Premium, Koleksi Ebook Lengkap, Token Listrik Instan, dan Pulsa/Paket Data Murah, Semua Tersedia disini, Transaksi Amanah, Layanan 24 Jam
            </p>
            <button class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:scale-105 transition shadow-[0_0_20px_rgba(37,99,235,0.4)] neon-border">
                BELANJA SEKARANG
            </button>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container mx-auto px-4 py-12 md:px-16">

    {{-- KATEGORI NAVIGASI (Aktif Scroll) --}}
    <h3 class="mb-6 text-xl font-bold flex items-center gap-2 text-white galaxy-title">
        <span class="text-blue-500 text-2xl">✦</span> Kategori Produk
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-16">
        @php
        $categories = [
        ['icon'=>'🎮','name'=>'Topup', 'target' => 'topup-section'],
        ['icon'=>'📱','name'=>'Apps', 'target' => 'apps-section'],
        ['icon'=>'📚','name'=>'Ebook', 'target' => 'ebook-section'],
        ['icon'=>'📶','name'=>'Pulsa', 'target' => 'utility-section'],
        ['icon'=>'⚡','name'=>'Token', 'target' => 'utility-section'],
        ];
        @endphp
        @foreach($categories as $cat)
        <div onclick="document.getElementById('{{ $cat['target'] }}').scrollIntoView({ behavior: 'smooth' })"
            class="bg-[#1a1c23] border border-blue-500/20 rounded-2xl p-4 flex items-center gap-4 hover:border-blue-500/80 hover:bg-[#1f222a] hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition cursor-pointer group float">
            <div class="text-3xl group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</div>
            <span class="text-sm font-bold text-gray-200 group-hover:text-blue-300 transition">{{ $cat['name'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- TOPUP SECTION --}}
    @php
    $gameCategories = $kategoris->whereIn('nama_kategori', ['Mobile Legend', 'Honor of King', 'PUBG Mobile', "Free Fire", "Genshin Impact", "Valorant", "Magic Chess", "Apex Legends", "Call of Duty Mobile", "League of Legends"]);
    @endphp

    <div id="topup-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-blue-600 to-purple-600 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span> 🎮 Topup Games Populer
        </h3>
        <a href="{{ route('kategori.all', 'Topup Games') }}" class="group text-sm font-bold text-blue-500 hover:text-blue-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @foreach($gameCategories as $index => $cat)
        <a href="{{ route('produk.detail', $cat->id_kategori) }}" class="group block">
            <div class="rounded-3xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-blue-500/20 shadow-2xl transition hover:-translate-y-2 hover:border-blue-400/60 hover:shadow-[0_0_30px_rgba(59,130,246,0.4)] float">
                <div class="relative aspect-square flex items-center justify-center p-6 bg-gradient-to-b from-blue-500/10 to-transparent">
                    <img src="{{ asset('images/game/game top-up-' . ($loop->iteration) . '.png') }}"
                        class="w-full h-full object-contain drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)] transition duration-500 group-hover:scale-110">
                </div>
                <div class="px-4 py-5 text-center bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-blue-500/10 border-t border-blue-500/20">
                    <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-300 transition">{{ $cat->nama_kategori }}</p>
                    <p class="text-[10px] text-gray-500 mt-1 font-bold uppercase tracking-widest">⚡ PROSES INSTAN</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- APLIKASI PREMIUM SECTION --}}
    @php
    // Mengambil data kategori Aplikasi Premium/Apps dari database beserta produknya
    $appsCategory = $kategoris->whereIn('nama_kategori', ['Apps', 'Aplikasi Premium', 'Akun', 'Akun Premium'])->first();
    @endphp

    <div id="apps-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span> 📱 Aplikasi Premium
        </h3>
        <a href="{{ route('kategori.all', $appsCategory ? $appsCategory->nama_kategori : 'Aplikasi Premium') }}" class="group text-sm font-bold text-purple-500 hover:text-purple-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @if($appsCategory && $appsCategory->produks->count() > 0)
        @foreach($appsCategory->produks->take(5) as $produk)
        <a href="{{ route('produk.detail', $produk->id_kategori) }}" class="group block">
            <div class="bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-purple-500/20 rounded-3xl p-6 text-center hover:border-purple-400/60 hover:shadow-[0_0_30px_rgba(168,85,247,0.3)] transition shadow-xl float group">

                {{-- Gambar Produk / Placeholder Icon jika tidak ada gambar --}}
                <div class="aspect-square bg-gradient-to-br from-purple-500/20 to-black/40 rounded-2xl mb-4 flex items-center justify-center overflow-hidden p-4 shadow-inner">
                    @if($produk->gambar_produk)
                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)]">
                    @else
                    <span class="text-4xl group-hover:scale-110 transition duration-500">📱</span>
                    @endif
                </div>

                <p class="text-sm font-black text-white uppercase tracking-wider truncate group-hover:text-purple-300 transition">{{ $produk->nama_produk }}</p>
                <p class="text-xs text-purple-400 mt-2 font-bold italic">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Belum ada koleksi Aplikasi Premium.</p>
        @endif
    </div>

    {{-- E-BOOK TERLARIS SECTION --}}
    @php
    $ebookCategory = $kategoris->where('nama_kategori', 'E-Book')->first();
    @endphp

    <div id="ebook-section" class="flex justify-between items-center mb-6 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-cyan-500 to-blue-600 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.5)]"></span> 📚 E-Book Terlaris
        </h3>
        <a href="{{ route('kategori.all', 'E-Book') }}" class="group text-sm font-semibold text-blue-500 hover:text-blue-300 flex items-center gap-1 transition">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($ebookCategory && $ebookCategory->produks->count() > 0)
        @foreach($ebookCategory->produks->take(5) as $produk)
        <a href="{{ route('produk.detail', $produk->id_kategori) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-white/5 to-white/0 border border-blue-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-blue-400/60 hover:shadow-[0_0_25px_rgba(59,130,246,0.3)] float">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-blue-500/10 to-black/40">
                    <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : asset('images/ebook-placeholder.png') }}"
                        class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105 p-2">
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-blue-500/20 border-t border-blue-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-blue-300 transition-colors">{{ $produk->nama_produk }}</p>
                    <p class="text-xs text-gray-400">Koleksi Digital</p>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Belum ada koleksi E-Book.</p>
        @endif
    </div>

    {{-- PULSA & TOKEN SECTION (Dinamis Sesuai Database) --}}
    @php
    // Sinkronisasi dengan nama kategori yang Anda daftarkan di database
    $utilityCategories = $kategoris->whereIn('nama_kategori', ['Pulsa Provider', 'Token Listrik', 'Pulsa & Data']);
    @endphp

    <div id="utility-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-yellow-500 to-orange-600 rounded-full shadow-[0_0_10px_rgba(234,179,8,0.5)]"></span> ⚡ Pulsa & Token Listrik
        </h3>
        <a href="{{ route('kategori.all', 'Utilitas') }}" class="group text-sm font-bold text-yellow-500 hover:text-yellow-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($utilityCategories->count() > 0)
        @foreach($utilityCategories as $cat)
        <a href="{{ route('produk.detail', $cat->id_kategori) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-yellow-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-yellow-400/60 hover:shadow-[0_0_30px_rgba(234,179,8,0.3)] text-center float">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-yellow-500/10 to-black/40">
                    <span class="text-6xl group-hover:scale-110 transition duration-500">
                        {{ Str::contains(Str::lower($cat->nama_kategori), 'token') ? '⚡' : '📶' }}
                    </span>
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-yellow-500/20 via-orange-500/20 to-yellow-500/20 border-t border-yellow-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-yellow-300 transition-colors">{{ $cat->nama_kategori }}</p>
                    <p class="text-[10px] text-yellow-400/70 tracking-widest uppercase font-bold">💳 Pembayaran Instan</p>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Kategori utilitas pulsa atau token belum tersedia di database.</p>
        @endif
    </div>

</div>
@endsection