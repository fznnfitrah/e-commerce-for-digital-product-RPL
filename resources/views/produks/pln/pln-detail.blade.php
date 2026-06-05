@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">

    <form action="{{ route('transaksi.checkout') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        @csrf

        {{-- SIDEBAR PRODUK --}}
        <div class="lg:col-span-4">
            <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-xl sticky top-24">

                {{-- IMAGE --}}
                <div class="relative h-64 bg-black/30 overflow-hidden">
                    @if($brand->gambar_brand)
                    <img src="{{ asset('storage/' . $brand->gambar_brand) }}"
                        class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        ⚡
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f1117] via-transparent to-transparent"></div>
                </div>

                {{-- INFO --}}
                <div class="p-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-bold uppercase tracking-widest mb-4">
                        ⚡ Token Listrik
                    </div>

                    <h2 class="text-2xl font-black text-white leading-tight uppercase">
                        {{ $brand->nama_brand }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3 leading-relaxed">
                        Isi token listrik PLN prabayar secara instan, cepat, dan otomatis 24 jam.
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Proses</span>
                            <span class="font-bold text-green-400">Instan</span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Status</span>
                            <span class="font-bold text-blue-400">Aktif 24 Jam</span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-bold text-white">PLN Prabayar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- STEP 1 --}}
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">
                        1
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white uppercase">
                            Masukkan ID Pelanggan
                        </h3>
                        <p class="text-xs text-gray-400">
                            Nomor meter / ID pelanggan PLN
                        </p>
                    </div>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-widest text-gray-500 font-bold block mb-3">
                        Nomor Meter / ID Pelanggan
                    </label>

                    <div class="relative">
                        <input
                            type="number"
                            id="id_pelanggan"
                            name="id_target"
                            placeholder="Contoh: 14123456789"
                            required
                            autocomplete="off"
                            class="w-full bg-black/40 border border-white/10 rounded-2xl px-5 py-4 text-white text-lg font-bold tracking-wide focus:ring-2 focus:ring-yellow-500 outline-none transition">

                        <div id="status_badge"
                            class="hidden absolute right-4 top-1/2 -translate-y-1/2 px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-black uppercase">
                            ✓ Valid
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-3">
                        Minimal 11 digit dan maksimal 12 digit.
                    </p>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div id="nominal_section"
                class="hidden bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">
                        2
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white uppercase">
                            Pilih Nominal Token
                        </h3>

                        <p class="text-xs text-gray-400">
                            Pilih nominal token listrik
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($items as $produk)
                    <label class="group cursor-pointer">

                        <input
                            type="radio"
                            name="id_produk"
                            value="{{ $produk->id_produk }}"
                            class="peer hidden"
                            required>

                        <div class="h-full rounded-2xl border border-white/10 bg-black/20 p-5 transition-all duration-300
                                    hover:border-yellow-500/50 hover:-translate-y-1
                                    peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">

                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h4 class="text-white font-black text-base">
                                        {{ $produk->nama_produk }}
                                    </h4>

                                    <p class="text-xs text-gray-400 mt-1">
                                        PLN Prabayar
                                    </p>
                                </div>

                                <div class="w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-yellow-500 flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-yellow-500 hidden peer-checked:block"></div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <span class="text-yellow-400 text-lg font-black">
                                    Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3 --}}
            <div id="payment_section"
                class="hidden bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">
                        3
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white uppercase">
                            Pilih Metode Pembayaran
                        </h3>

                        <p class="text-xs text-gray-400">
                            Gunakan e-wallet atau transfer bank
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="dana" class="peer hidden">

                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center
                                    hover:border-blue-500 transition peer-checked:border-blue-500 peer-checked:bg-blue-500/10">

                            <span class="text-blue-400 font-black text-lg uppercase">
                                DANA
                            </span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="gopay" class="peer hidden">

                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center
                                    hover:border-green-500 transition peer-checked:border-green-500 peer-checked:bg-green-500/10">

                            <span class="text-green-400 font-black text-lg uppercase">
                                GOPAY
                            </span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="ovo" class="peer hidden">

                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center
                                    hover:border-purple-500 transition peer-checked:border-purple-500 peer-checked:bg-purple-500/10">

                            <span class="text-purple-400 font-black text-lg uppercase">
                                OVO
                            </span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="qris" class="peer hidden">

                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center
                                    hover:border-yellow-500 transition peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">

                            <span class="text-yellow-400 font-black text-lg uppercase">
                                QRIS
                            </span>
                        </div>
                    </label>

                </div>
            </div>

            {{-- DETAIL --}}
            <div id="submit_section"
                class="hidden bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/20 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">
                            Total Pembayaran
                        </p>

                        <h3 id="price_preview"
                            class="text-4xl font-black text-white mt-2">
                            Rp 0
                        </h3>

                        <p class="text-xs text-gray-500 mt-2">
                            Pastikan data pelanggan sudah benar.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="px-10 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-black uppercase tracking-widest transition active:scale-95 shadow-xl shadow-yellow-500/20">
                        Bayar Sekarang
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const idInput = document.getElementById('id_pelanggan');
        const statusBadge = document.getElementById('status_badge');

        const nominalSection = document.getElementById('nominal_section');
        const paymentSection = document.getElementById('payment_section');
        const submitSection = document.getElementById('submit_section');

        const radios = document.querySelectorAll('input[name="id_produk"]');
        const pricePreview = document.getElementById('price_preview');

        // VALIDASI ID PELANGGAN
        idInput.addEventListener('input', function() {

            const value = this.value.trim();

            if (value.length >= 11 && value.length <= 12) {

                statusBadge.classList.remove('hidden');
                nominalSection.classList.remove('hidden');

            } else {

                statusBadge.classList.add('hidden');
                nominalSection.classList.add('hidden');
                paymentSection.classList.add('hidden');
                submitSection.classList.add('hidden');
            }
        });

        // PILIH PRODUK
        radios.forEach(radio => {

            radio.addEventListener('change', function() {

                const parent = this.closest('label');
                const priceText = parent.querySelector('.text-yellow-400').textContent;

                paymentSection.classList.remove('hidden');
                submitSection.classList.remove('hidden');

                pricePreview.textContent = priceText;
            });
        });

    });
</script>

<style>
    .animate-fade-in {
        animation: fadeIn .4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection