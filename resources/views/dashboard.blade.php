@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="relative w-full overflow-hidden h-87.5 md:h-125 bg-[#0b0e14]">
    <img src="{{ asset('images/hero-bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
    <img src="{{ asset('images/hero-mobile-legend.png') }}" class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain translate-x-10 md:translate-x-20 z-10">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0b0e14] via-[#0b0e14]/80 to-transparent"></div>
    <div class="absolute inset-0 flex items-center z-20">
        <div class="container mx-auto px-4 md:px-16">
            <h2 class="text-4xl md:text-6xl font-black italic uppercase leading-tight text-white">
                BELI PRODUK <br>
                <span class="text-blue-500">DIGITAL</span> MUDAH <br>
                DAN CEPAT
            </h2>
            <p class="mt-4 mb-6 max-w-xl text-gray-400">
                Top up game favorit, Aplikasi Premium, Koleksi Ebook Lengkap, Token Listrik Instan, dan Pulsa/Paket Data Murah, Semua Tersedia disini, Transaksi Amanah, Layanan 24 Jam
            </p>
            <button class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:scale-105 transition shadow-[0_0_20px_rgba(37,99,235,0.4)]">
                BELANJA SEKARANG
            </button>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container mx-auto px-4 py-12 md:px-16">

    {{-- KATEGORI NAVIGASI --}}
    <h3 class="mb-6 text-xl font-bold flex items-center gap-2 text-white">
        <span class="text-blue-500">◆</span> Kategori
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-16">
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
        <div class="bg-[#1a1c23] border border-white/5 rounded-2xl p-4 flex items-center gap-4 hover:border-blue-500/50 hover:bg-[#1f222a] transition cursor-pointer group">
            <div class="text-3xl group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</div>
            <span class="text-sm font-bold text-gray-200">{{ $cat['name'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- TOPUP SECTION --}}
    @php
    $gameCategories = $kategoris->whereIn('nama_kategori', ['Mobile Legend', 'Honor of King', 'PUBG Mobile', "Free Fire", "Genshin Impact", "Valorant", "Magic Chess", "Apex Legends", "Call of Duty Mobile", "League of Legends"]);
    @endphp

    <div class="flex justify-between items-center mb-8">
        <h3 class="text-2xl font-black italic uppercase text-white flex items-center gap-3">
            <span class="w-2 h-8 bg-blue-600 rounded-full"></span> 🎮 Topup Games Populer
        </h3>
        <a href="{{ route('kategori.all', 'Topup Games') }}" class="group ..." class="group text-sm font-bold text-blue-500 hover:text-blue-400 flex items-center gap-2 transition">
            LIHAT SEMUA 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @foreach($gameCategories as $index => $cat)
        <a href="{{ route('produk.detail', $cat->id_kategori) }}" class="group block">
            <div class="rounded-3xl overflow-hidden bg-[#1a1c23] border border-white/5 shadow-2xl transition hover:-translate-y-2 hover:border-blue-500/40">
                <div class="relative aspect-square flex items-center justify-center p-6 bg-gradient-to-b from-white/5 to-transparent">
                    <img src="{{ asset('images/game/game top-up-' . ($loop->iteration) . '.png') }}"
                        class="w-full h-full object-contain drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)] transition duration-500 group-hover:scale-110">
                </div>
                <div class="px-4 py-5 text-center bg-[#12141a] border-t border-white/5">
                    <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-400 transition">{{ $cat->nama_kategori }}</p>
                    <p class="text-[10px] text-gray-500 mt-1 font-bold uppercase tracking-widest">PROSES INSTAN</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- APLIKASI PREMIUM --}}
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-2xl font-black italic uppercase text-white flex items-center gap-3">
            <span class="w-2 h-8 bg-purple-600 rounded-full"></span> 📱 Aplikasi Premium
        </h3>
        <a href="{{ route('kategori.all', 'Aplikasi Premium') }}" class="group ..." class="group text-sm font-bold text-purple-500 hover:text-purple-400 flex items-center gap-2 transition">
            LIHAT SEMUA 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @for($i = 1; $i <= 5; $i++)
        <div class="bg-[#1a1c23] border border-white/5 rounded-3xl p-6 text-center hover:border-purple-500/50 transition cursor-pointer shadow-xl">
            <div class="aspect-square bg-black/40 rounded-2xl mb-4 flex items-center justify-center text-4xl shadow-inner">📱</div>
            <p class="text-sm font-black text-white uppercase tracking-wider">Premium App {{ $i }}</p>
            <p class="text-xs text-purple-400 mt-2 font-bold italic">Mulai Rp 15.000</p>
        </div>
        @endfor
    </div>

{{-- E-BOOK TERLARIS SECTION --}}
    @php
    $ebookCategory = $kategoris->where('nama_kategori', 'E-Book')->first();
    @endphp

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold flex items-center gap-2 text-white">📚 E-Book Terlaris</h3>
        <a href="{{ route('kategori.all', 'E-Book') }}" class="group ..." class="group text-sm font-semibold text-blue-500 hover:text-blue-400 flex items-center gap-1 transition">
            Lihat Semua 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($ebookCategory && $ebookCategory->produks->count() > 0)
            @foreach($ebookCategory->produks->take(5) as $produk)
            <a href="{{ route('produk.detail', $produk->id_produk) }}" class="group block">
                <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2">
                    <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                        <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : asset('images/ebook-placeholder.png') }}"
                            class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105 p-2">
                        <div class="absolute bottom-0 left-0 w-full h-24 bg-linear-to-t from-black/80 via-black/40 to-transparent"></div>
                    </div>
                    <div class="px-4 py-3 bg-linear-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                        <p class="text-sm font-bold truncate text-white group-hover:text-blue-400 transition-colors">{{ $produk->nama_produk }}</p>
                        <p class="text-xs text-gray-300">Koleksi Digital</p>
                    </div>
                </div>
            </a>
            @endforeach
        @else
            <p class="text-gray-500 col-span-full italic text-sm">Belum ada koleksi E-Book.</p>
        @endif
    </div>

    {{-- PULSA & TOKEN SECTION --}}
    @php
    $utilityCategories = $kategoris->whereIn('nama_kategori', ['Pulsa & Data', 'Token Listrik']);
    @endphp

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold flex items-center gap-2 text-white">📶 Pulsa & Token Listrik</h3>
        <a href="{{ route('kategori.all', 'Pulsa & Token') }}" class="group ..." class="group text-sm font-semibold text-blue-500 hover:text-blue-400 flex items-center gap-1 transition">
            Lihat Semua 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($utilityCategories->count() > 0)
            @foreach($utilityCategories as $cat)
            <a href="{{ route('produk.detail', $cat->id_kategori) }}" class="group block">
                <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2 text-center">
                    <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                        <span class="text-6xl group-hover:scale-110 transition duration-500">
                            {{ $cat->nama_kategori == 'Token Listrik' ? '⚡' : '📱' }}
                        </span>
                        <div class="absolute bottom-0 left-0 w-full h-24 bg-linear-to-t from-black/80 via-black/40 to-transparent"></div>
                    </div>
                    <div class="px-4 py-3 bg-linear-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                        <p class="text-sm font-bold truncate text-white group-hover:text-blue-400 transition-colors">{{ $cat->nama_kategori }}</p>
                        <p class="text-[10px] text-gray-400 tracking-widest uppercase">Cek Harga</p>
                    </div>
                </div>
            </a>
            @endforeach
        @else
            <p class="text-gray-500 col-span-full italic text-sm">Kategori utilitas belum tersedia.</p>
        @endif
    </div>

</div>

{{-- FLOATING WHATSAPP BUTTON --}}
<a href="https://wa.me/6285172280957" target="_blank" 
   class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-16 h-16 bg-green-500 rounded-full shadow-[0_0_30px_rgba(34,197,94,0.4)] hover:scale-110 active:scale-95 transition-all group">
    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
    <span class="absolute right-20 bg-white text-black text-xs font-black px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all whitespace-nowrap shadow-2xl pointer-events-none">
        BANTUAN CS VIA WHATSAPP
    </span>
</a>

@endsection