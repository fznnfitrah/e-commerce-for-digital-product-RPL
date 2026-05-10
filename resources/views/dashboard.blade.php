@extends('layouts.app')

@section('content')

{{-- HERO --}}
<div class="relative w-full overflow-hidden h-87.5 md:h-125">
    <img src="{{ asset('images/hero-bg.png') }}" class="absolute inset-0 w-full h-full object-cover">
    <img src="{{ asset('images/hero-mobile-legend.png') }}" class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain translate-x-10 md:translate-x-20">
    <div class="absolute inset-0 bg-linear-to-r from-black/90 via-black/60 to-transparent"></div>
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-4 md:px-16">
            <h2 class="text-4xl md:text-6xl font-black italic uppercase leading-tight">
                BELI PRODUK <br>
                <span class="text-blue-500">DIGITAL</span> MUDAH <br>
                DAN CEPAT
            </h2>
            <p class="mt-4 mb-6 max-w-xl text-gray-300">
                Top up game, aplikasi premium, ebook, token listrik, dan pulsa.
            </p>
            <button class="px-8 py-3 bg-blue-600 rounded-xl font-bold hover:scale-105 transition">
                BELANJA SEKARANG
            </button>
        </div>
    </div>
</div>

{{-- CONTENT --}}
<div class="container mx-auto px-4 py-12 md:px-16">

    {{-- KATEGORI --}}
    <h3 class="mb-6 text-xl font-bold flex items-center gap-2">
        <span class="text-blue-500">◆</span> Kategori
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
        @php
        $categories = [
        ['icon'=>'🎮','name'=>'Topup'],
        ['icon'=>'📱','name'=>'Apps'],
        ['icon'=>'📚','name'=>'Ebook'],
        ['icon'=>'📶','name'=>'Pulsa'],
        ['icon'=>'⚡','name'=>'Token'],
        ];
        @endphp
        @foreach($categories as $cat)
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 flex items-center gap-3 hover:bg-white/10 transition">
            <div class="text-2xl">{{ $cat['icon'] }}</div>
            <span class="text-sm font-semibold">{{ $cat['name'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- TOPUP SECTION --}}
    @php
    // Mencari Kategori Game dari Database (Misal: Mobile Legend, Honor of King)
    $gameCategories = $kategoris->whereIn('nama_kategori', ['Mobile Legend', 'Honor of King', 'PUBG Mobile', "Free Fire", "Genshin Impact", "Valorant", "Magic Chess", "Apex Legends", "Call of Duty Mobile", "League of Legends"]);
    @endphp

    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">🎮 Topup</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @foreach($gameCategories as $index => $cat)
        <a href="{{ route('produk.detail', $cat->id_kategori) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                    <img src="{{ asset('images/game/game top-up-' . ($loop->iteration) . '.png') }}"
                        class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105">
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-linear-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-linear-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                    <p class="text-sm font-bold truncate group-hover:text-blue-400 transition-colors">{{ $cat->nama_kategori }}</p>
                    <p class="text-xs text-gray-300">Top Up Instan</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- EBOOK SECTION --}}
    @php
    $ebookCategory = $kategoris->where('nama_kategori', 'E-Book')->first();
    @endphp

    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">📚 E-Book</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($ebookCategory && $ebookCategory->produks->count() > 0)
        @foreach($ebookCategory->produks as $produk)    
        <a href="{{ route('produk.detail', $produk->id_kategori) }}" class="group relative block">
            <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                    <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : asset('images/placeholder.png') }}"
                        class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105">
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-linear-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-linear-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                    <p class="text-sm font-bold truncate">{{ $produk->nama_produk }}</p>
                    <p class="text-xs text-gray-300">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 blur-xl transition -z-10 bg-linear-to-r from-purple-500/30 via-pink-500/30 to-blue-500/30"></div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic">Belum ada koleksi E-Book.</p>
        @endif
    </div>

    {{-- APLIKASI --}}
    @php
    $appCategory = $kategoris->where('nama_kategori', 'Akun Premium')->first();
    @endphp
    <h3 class="text-xl font-bold mb-6">📱 Aplikasi Premium</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @for($i = 1; $i <= 5; $i++)
            <a href="{{ $appCategory ? route('produk.detail', $appCategory->id_kategori) : '#' }}" class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:bg-white/10 transition block">
            <div class="h-32 bg-black/40 rounded-lg mb-3 flex items-center justify-center text-2xl">📱</div>
            <p class="text-sm font-bold">Premium App {{ $i }}</p>
            </a>
            @endfor
    </div>

</div>

@endsection