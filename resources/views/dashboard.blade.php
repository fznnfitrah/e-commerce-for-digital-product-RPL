@extends('layouts.app')

@section('content')
    <div class="rounded-3xl overflow-hidden mb-12 relative h-[300px] md:h-[450px]">
        <img src="/images/hero-mobile-legend.png" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent flex flex-col justify-center px-10">
            <h2 class="text-4xl md:text-6xl font-black mb-4 leading-tight">BELI PRODUK<br>DIGITAL MUDAH<br>DAN CEPAT</h2>
            <p class="text-gray-300 mb-6 max-w-md">Top-up game, Aplikasi Premium, Pulsa, dan Token Listrik. Transaksi Amanah, Layanan 24 Jam.</p>
            <button class="bg-blue-600 w-fit px-8 py-3 rounded-full font-bold hover:scale-105 transition">BELANJA SEKARANG</button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
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
        <div class="glass-card p-4 rounded-xl flex items-center gap-3 hover:border-blue-500 cursor-pointer transition">
            <span class="text-2xl">{{ $cat['icon'] }}</span>
            <span class="font-medium text-sm">{{ $cat['name'] }}</span>
        </div>
        @endforeach
    </div>

    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">🎮 Topup Games Populer</h3>
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
@endsection