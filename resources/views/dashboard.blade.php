@extends('layouts.app')

@section('content')

{{-- HERO --}}
<div class="relative w-full overflow-hidden h-[350px] md:h-[500px]">

    <img src="{{ asset('images/hero-bg.png') }}"
        class="absolute inset-0 w-full h-full object-cover">

    <img src="{{ asset('images/hero-mobile-legend.png') }}"
        class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain translate-x-10 md:translate-x-20">

    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>

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


    {{-- TOPUP --}}
    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">🎮 Topup</h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">

        @for($i = 1; $i <= 5; $i++)
            <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2">

            <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                <img src="{{ asset('images/game/game top-up-' . $i . '.png') }}"
                    class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105">

                <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            </div>

            <div class="px-4 py-3 bg-gradient-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                <p class="text-sm font-bold truncate">Game Title {{ $i }}</p>
                <p class="text-xs text-gray-300">Mobile Legends</p>
            </div>

    </div>
    @endfor

</div>

{{-- EBOOK --}}
<h3 class="text-xl font-bold mb-6 flex items-center gap-2">📚 E-Book</h3>
<div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">

    @for($i = 1; $i <= 5; $i++)
        <div class="group relative">

        <div class="rounded-2xl overflow-hidden bg-white/5 border border-white/10 backdrop-blur-xl transition hover:-translate-y-2">

            <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-black/40">
                <img src="{{ asset('images/e-book/ebook-' . $i . '.png') }}"
                    class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105">

                <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            </div>

            <div class="px-4 py-3 bg-gradient-to-r from-purple-500/20 via-pink-500/20 to-blue-500/20">
                <p class="text-sm font-bold truncate">Book Title {{ $i }}</p>
                <p class="text-xs text-gray-300">Mobile Legends</p>
            </div>

        </div>

        {{-- glow --}}
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 blur-xl transition -z-10
                bg-gradient-to-r from-purple-500/30 via-pink-500/30 to-blue-500/30">
        </div>

</div>
@endfor

</div>


{{-- APLIKASI --}}
<h3 class="text-xl font-bold mb-6">📱 Aplikasi Premium</h3>

<div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">

    @for($i = 1; $i <= 5; $i++)
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:bg-white/10 transition">
        <div class="h-32 bg-black/40 rounded-lg mb-3"></div>
        <p class="text-sm font-bold">App {{ $i }}</p>
</div>
@endfor

</div>


{{-- PULSA --}}
<h3 class="text-xl font-bold mb-6">📶 Pulsa & Token</h3>

<div class="grid grid-cols-2 md:grid-cols-5 gap-6">

    @for($i = 1; $i <= 5; $i++)
        <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center hover:bg-white/10 transition">
        <div class="h-32 bg-black/40 rounded-lg mb-3"></div>
        <p class="text-sm font-bold">Item {{ $i }}</p>
</div>
@endfor

</div>

</div>

@endsection