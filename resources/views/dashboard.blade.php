@extends('layouts.app')

@section('content')

    {{-- 1. HERO SECTION --}}
    <div class="relative w-full overflow-hidden h-87.5 md:h-125">

        {{-- BACKGROUND GALAXY --}}
        <img src="{{ asset('images/hero-bg.png') }}" 
            class="object-cover w-full h-full absolute inset-0" 
            alt="Background">

        {{-- HERO CHARACTER (KANAN) --}}
        <img src="{{ asset('images/hero-mobile-legend.png') }}" 
            class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain 
                    translate-x-10 md:translate-x-20
                    drop-shadow-[0_20px_40px_rgba(0,0,0,0.8)]"
            alt="Hero Character">

        {{-- OVERLAY GRADIENT (BIAR TEKS KEBACA) --}}
        <div class="absolute inset-0 bg-linear-to-r from-black/90 via-black/60 to-transparent"></div>

        {{-- CONTENT --}}
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-4 md:px-16">
                
                <h2 class="mb-4 text-4xl md:text-6xl font-black italic tracking-tighter uppercase text-white leading-tight">
                    BELI PRODUK<br>
                    <span class="text-blue-500">DIGITAL</span> MUDAH<br>
                    DAN CEPAT
                </h2>

                <p class="max-w-xl mb-8 text-sm md:text-base text-gray-200">
                    Top up game favorit, Aplikasi Premium, Koleksi Ebook Lengkap, Token Listrik Instan, dan Pulsa/Paket Data Murah. Semua tersedia di sini, Transaksi Amanah, Layanan 24 Jam.
                </p>

                <button class="px-10 py-4 font-extrabold text-white bg-linear-to-r from-blue-700 to-blue-500 rounded-xl hover:scale-105 active:scale-95 transition shadow-lg shadow-blue-500/30 uppercase tracking-wider">
                    BELANJA SEKARANG
                </button>

            </div>
        </div>
    </div>


    {{-- 2. KONTEN UTAMA BERSAMA (Kategori, Produk, dll - Tetap dalam Container) --}}
    <div class="container mx-auto px-4 py-12 md:px-16">
        
        <h3 class="mb-6 text-2xl font-bold tracking-tight text-white uppercase flex items-center gap-2">
            <span class="text-blue-500">◆</span> Jelajahi Kategori
        </h3>

        <div class="grid grid-cols-2 gap-5 mb-16 md:grid-cols-5">
            @php
                $categories = [
                    ['icon' => '🎮', 'name' => 'Topup Games'],
                    ['icon' => '📱', 'name' => 'Aplikasi Premium'],
                    ['icon' => '📚', 'name' => 'E-Book'],
                    ['icon' => '📶', 'name' => 'Pulsa & Paket'],
                    ['icon' => '⚡', 'name' => 'Token Listrik'],
                ];
            @endphp
            
            @foreach($categories as $cat)
            <div class="transition duration-300 cursor-pointer glass-card p-6 rounded-2xl flex items-center gap-5 group hover:bg-white/10 border border-white/5 hover:border-blue-500/50 hover:-translate-y-1 shadow-xl">
                <div class="flex items-center justify-center w-14 h-14 text-3xl rounded-xl bg-blue-600/10 group-hover:bg-blue-600 transition-colors shadow-inner">
                    {{ $cat['icon'] }}
                </div>
                <span class="text-sm font-extrabold tracking-wider uppercase text-gray-100">{{ $cat['name'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Section Produk --}}
        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">🎮 Topup Games Populer</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            @for($i = 1; $i <= 5; $i++)
            <div class="glass-card rounded-2xl overflow-hidden hover:scale-105 transition group">
                <div class="h-48 bg-gray-700">
                    <img src="images/game/game top-up-{{ $i }}.png" class="w-full h-full object-cover">
                </div>
                <div class="p-3 text-center">
                    <p class="font-bold text-sm">Game Title {{ $i }}</p>
                    <p class="text-xs text-gray-400">Mobile Legends</p>
                </div>
            </div>
            @endfor
        </div>

        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">📱 Aplikasi Premium</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            @for($i = 1; $i <= 5; $i++)
            <div class="glass-card rounded-2xl overflow-hidden hover:scale-105 transition group">
                <div class="h-48 bg-gray-700">
                    <!-- <img src="https://via.placeholder.com/150x200" class="w-full h-full object-cover"> -->
                </div>
                <div class="p-3 text-center">
                    <p class="font-bold text-sm">Game Title {{ $i }}</p>
                    <p class="text-xs text-gray-400"></p>
                </div>
            </div>
            @endfor
        </div>

        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">📚 E-Book</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            @for($i = 1; $i <= 5; $i++)
            <div class="glass-card rounded-2xl overflow-hidden hover:scale-105 transition group">
                <div class="h-48 bg-gray-700">
                    <img src="images/e- book/ebook-{{ $i }}.png" class="w-full h-full object-cover">
                </div>
                <div class="p-3 text-center">
                    <p class="font-bold text-sm">Game Title {{ $i }}</p>
                    <p class="text-xs text-gray-400">Mobile Legends</p>
                </div>
            </div>
            @endfor
        </div>

        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">📶 Pulsa Paket & Token</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            @for($i = 1; $i <= 5; $i++)
            <div class="glass-card rounded-2xl overflow-hidden hover:scale-105 transition group">
                <div class="h-48 bg-gray-700">
                    <!-- <img src="https://via.placeholder.com/150x200" class="w-full h-full object-cover"> -->
                </div>
                <div class="p-3 text-center">
                    <p class="font-bold text-sm">Game Title {{ $i }}</p>
                    <p class="text-xs text-gray-400">Mobile Legends</p>
                </div>
            </div>
            @endfor
        </div>

        
    </div>
@endsection

