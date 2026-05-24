@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-10">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT SIDE --}}
        <div class="lg:col-span-3">

            <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-xl sticky top-24">

                {{-- IMAGE --}}
                <div class="aspect-square bg-white flex items-center justify-center p-6">
                    @if($brand->gambar_brand)
                    <img src="{{ asset('storage/' . $brand->gambar_brand) }}"
                        class="max-w-full max-h-full object-contain">
                    @else
                    <span class="text-7xl">📱</span>
                    @endif
                </div>

                {{-- INFO --}}
                <div class="p-6">

                    <h2 class="text-2xl font-black text-white">
                        {{ $brand->nama_brand }}
                    </h2>

                    <p class="text-sm text-purple-400 font-semibold mt-1">
                        {{ $kategori->nama_kategori }}
                    </p>

                    <div class="mt-5 space-y-3">

                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span>
                            Proses otomatis
                        </div>

                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span>
                            Garansi aman
                        </div>

                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span>
                            Support 24 jam
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="lg:col-span-9">

            <form action="#" method="POST" class="space-y-6">
                @csrf

                {{-- STEP 1 --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center font-black text-white">
                            1
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-white">
                                Masukkan Data
                            </h3>

                            <p class="text-sm text-gray-400">
                                Isi data pembeli terlebih dahulu
                            </p>
                        </div>
                    </div>

                    <div class="space-y-5">

                        {{-- EMAIL --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                Email / Catatan Request
                            </label>

                            <input
                                type="text"
                                name="id_target"
                                placeholder="contoh@email.com"
                                autocomplete="off"
                                class="w-full bg-black/30 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-gray-500 focus:ring-2 focus:ring-purple-500 outline-none transition">
                        </div>

                        {{-- PHONE --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                Nomor WhatsApp (Opsional)
                            </label>

                            <input
                                type="text"
                                name="phone"
                                placeholder="08xxxxxxxxxx"
                                autocomplete="off"
                                class="w-full bg-black/30 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-gray-500 focus:ring-2 focus:ring-purple-500 outline-none transition">
                        </div>

                    </div>
                </div>

                {{-- STEP 2 --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-purple-600 flex items-center justify-center font-black text-white">
                            2
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-white">
                                Pilih Paket
                            </h3>

                            <p class="text-sm text-gray-400">
                                Pilih nominal atau paket yang tersedia
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach($items as $produk)

                        <label class="cursor-pointer">

                            <input
                                type="radio"
                                name="id_produk"
                                value="{{ $produk->id_produk }}"
                                class="hidden peer id-produk-radio"
                                data-name="{{ $produk->nama_produk }}"
                                data-price="{{ number_format($produk->harga_produk, 0, ',', '.') }}">

                            <div class="border border-white/10 bg-black/20 rounded-2xl p-5 transition hover:border-purple-500/50 peer-checked:border-purple-500 peer-checked:bg-purple-500/10">

                                <div class="flex items-start justify-between gap-4">

                                    <div>
                                        <h4 class="text-white font-bold">
                                            {{ $produk->nama_produk }}
                                        </h4>

                                        <p class="text-xs text-gray-400 mt-1">
                                            Fast Process
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-black text-purple-400">
                                            Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </label>

                        @endforeach

                    </div>
                </div>

                {{-- STEP 3 --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-pink-600 flex items-center justify-center font-black text-white">
                            3
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-white">
                                Metode Pembayaran
                            </h3>

                            <p class="text-sm text-gray-400">
                                Pilih pembayaran yang tersedia
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        {{-- GOPAY --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="payment" value="gopay" class="hidden peer">

                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex items-center justify-center text-white font-bold transition hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10">
                                GoPay
                            </div>
                        </label>

                        {{-- DANA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="payment" value="dana" class="hidden peer">

                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex items-center justify-center text-white font-bold transition hover:border-cyan-500 peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10">
                                DANA
                            </div>
                        </label>

                        {{-- QRIS --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="payment" value="qris" class="hidden peer">

                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex items-center justify-center text-white font-bold transition hover:border-yellow-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">
                                QRIS
                            </div>
                        </label>

                        {{-- OVO --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="payment" value="ovo" class="hidden peer">

                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex items-center justify-center text-white font-bold transition hover:border-purple-500 peer-checked:border-purple-500 peer-checked:bg-purple-500/10">
                                OVO
                            </div>
                        </label>

                    </div>
                </div>

                {{-- STEP 4 --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-orange-600 flex items-center justify-center font-black text-white">
                            4
                        </div>

                        <div>
                            <h3 class="text-lg font-black text-white">
                                Detail Pesanan
                            </h3>

                            <p class="text-sm text-gray-400">
                                Ringkasan transaksi Anda
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                        <div>

                            <p id="selected-product"
                                class="text-sm text-gray-400">
                                Belum memilih paket
                            </p>

                            <h2 id="selected-price"
                                class="text-4xl font-black text-white mt-2">
                                Rp 0
                            </h2>

                        </div>

                        <button
                            type="submit"
                            id="submit_button"
                            disabled
                            class="px-10 py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-black uppercase tracking-wide shadow-xl shadow-purple-500/20 transition active:scale-95">

                            Beli Sekarang

                        </button>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const radios = document.querySelectorAll('.id-produk-radio');

        const selectedProduct = document.getElementById('selected-product');

        const selectedPrice = document.getElementById('selected-price');

        const submitButton = document.getElementById('submit_button');

        radios.forEach(radio => {

            radio.addEventListener('change', function() {

                selectedProduct.textContent = this.dataset.name;

                selectedPrice.textContent = 'Rp ' + this.dataset.price;

                submitButton.disabled = false;
            });
        });

    });
</script>
@endsection