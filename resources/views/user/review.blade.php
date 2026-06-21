@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-2xl">
    
    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 shadow-2xl">
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-black text-white uppercase italic tracking-tighter">Beri Ulasan Produk</h2>
            <p class="text-gray-400 text-sm mt-2">Bagikan pengalaman Anda menggunakan produk ini.</p>
        </div>

        {{-- INFO PRODUK --}}
        <div class="bg-black/30 rounded-2xl p-4 mb-8 flex items-center gap-4 border border-white/5">
            <div class="w-16 h-16 bg-gray-800 rounded-xl overflow-hidden shrink-0">
                @if($transaksi->produk->gambar_produk)
                    <img src="{{ asset('storage/' . $transaksi->produk->gambar_produk) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-2xl">📦</div>
                @endif
            </div>
            <div>
                <h3 class="font-bold text-white">{{ $transaksi->produk->nama_produk ?? 'Produk' }}</h3>
                <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Order: {{ $transaksi->id_transaksi }}</p>
            </div>
        </div>

        <form action="{{ route('user.review.store', $transaksi->id_transaksi) }}" method="POST">
            @csrf

            {{-- INPUT RATING BINTANG --}}
            <div class="mb-8 flex flex-col items-center">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Rating Anda</label>
                
                {{-- Trik CSS Sibling Selector untuk Bintang --}}
                <div class="flex flex-row-reverse justify-center gap-1 group">
                    <input type="radio" name="rating" id="star5" value="5" class="hidden peer" required>
                    <label for="star5" class="text-4xl text-gray-700 cursor-pointer transition-colors peer-checked:text-yellow-400 peer-hover:text-yellow-400 hover:!text-yellow-400">★</label>

                    <input type="radio" name="rating" id="star4" value="4" class="hidden peer">
                    <label for="star4" class="text-4xl text-gray-700 cursor-pointer transition-colors peer-checked:text-yellow-400 peer-hover:text-yellow-400 hover:!text-yellow-400">★</label>

                    <input type="radio" name="rating" id="star3" value="3" class="hidden peer">
                    <label for="star3" class="text-4xl text-gray-700 cursor-pointer transition-colors peer-checked:text-yellow-400 peer-hover:text-yellow-400 hover:!text-yellow-400">★</label>

                    <input type="radio" name="rating" id="star2" value="2" class="hidden peer">
                    <label for="star2" class="text-4xl text-gray-700 cursor-pointer transition-colors peer-checked:text-yellow-400 peer-hover:text-yellow-400 hover:!text-yellow-400">★</label>

                    <input type="radio" name="rating" id="star1" value="1" class="hidden peer">
                    <label for="star1" class="text-4xl text-gray-700 cursor-pointer transition-colors peer-checked:text-yellow-400 peer-hover:text-yellow-400 hover:!text-yellow-400">★</label>
                </div>
                
                @error('rating')
                    <p class="text-red-500 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- INPUT KOMENTAR --}}
            <div class="mb-8">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Ulasan Tertulis</label>
                <textarea name="komentar" rows="4" required
                    class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                    placeholder="Bagaimana kualitas produk dan pelayanannya?"></textarea>
                @error('komentar')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('user.riwayat') }}" class="text-sm font-semibold text-gray-400 hover:text-white transition">Batal</a>
                <button type="submit" class="bg-[#DFFF00] hover:bg-[#c9e600] text-black font-extrabold px-8 py-3 rounded-xl uppercase tracking-wider transition active:scale-95 shadow-lg shadow-[#DFFF00]/20">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Agar saat di hover, bintang sebelumnya juga ikut kuning */
    .group label:hover ~ label {
        color: #facc15 !important; /* Tailwind yellow-400 */
    }
</style>
@endsection