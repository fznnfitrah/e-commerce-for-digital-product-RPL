@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    {{-- BANNER PRODUK --}}
    <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
        <img src="{{ asset('images/banner-ml.png') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
    </div>

    <div class="grid grid-cols-1 gap-8">

        {{-- STEP 1: MASUKKAN ID --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-4">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                Masukkan User ID
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Masukkan User ID" class="bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" placeholder="Zone ID" class="bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <p class="text-[10px] text-gray-400 mt-3 italic">Untuk mengetahui User ID Anda, silakan klik menu profil di bagian kiri atas menu utama game.</p>
        </div>

        {{-- STEP 2: PILIH NOMINAL --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-6">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                Pilih Nominal {{ $kategori->nama_kategori }}
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($items as $item)
                <button onclick="selectItem('{{ $item->nama_produk }}', '{{ number_format($item->harga_produk, 0, ',', '.') }}')"
                    class="bg-black/20 border border-white/5 rounded-2xl p-4 hover:border-blue-500 transition-all text-left group">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-gray-400 group-hover:text-blue-400">{{ $item->nama_produk }}</span>
                        <img src="{{ asset('images/diamond-icon.png') }}" class="w-4 h-4">
                    </div>
                    <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- STEP 3: METODE BAYAR --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-6">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                Pilih Metode Bayar
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-2 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/gopay.png') }}" class="h-6 object-contain">
                </div>
                <div class="bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-2 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/dana.png') }}" class="h-6 object-contain">
                </div>
            </div>
        </div>

        {{-- FLOATING PURCHASE BAR --}}
        <div class="sticky bottom-6 bg-white/10 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Item Terpilih:</p>
                <p id="display-item" class="text-xs font-bold text-white">-</p>
                <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
            </div>
            <button class="bg-blue-600 px-10 py-3 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-600/20">
                BELI SEKARANG
            </button>
        </div>

    </div>
</div>

<script>
    function selectItem(name, price) {
        document.getElementById('display-item').innerText = name;
        document.getElementById('display-price').innerText = 'Rp ' + price;
    }
</script>
@endsection