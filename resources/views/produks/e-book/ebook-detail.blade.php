@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    @php
    $selectedProduct = $items->firstWhere('id_produk', request('selected')) ?? $items->first();
    @endphp

    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-ebook">
        @csrf

        <input type="hidden" name="id_produk" value="{{ $selectedProduct->id_produk }}">

        {{-- BANNER --}}
        <div class="relative w-full h-48 md:h-64 rounded-3xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ $selectedProduct->gambar_produk ? asset('storage/' . $selectedProduct->gambar_produk) : asset('images/default-banner.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-8">
                <p class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-1">E-BOOK DIGITAL</p>
                <h2 class="text-3xl font-black text-white uppercase italic">{{ $selectedProduct->nama_produk }}</h2>
            </div>
        </div>

        <div class="space-y-6">

            {{-- STEP 1 --}}
            <section class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center">1</span>
                    Informasi Pengiriman
                </h3>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] text-gray-400 uppercase font-bold ml-1">Email Aktif (Wajib)</label>
                        <input type="email" name="id_target" value="{{ old('id_target') }}" placeholder="user@email.com" required class="w-full mt-2 bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white outline-none focus:ring-2 focus:ring-blue-500">
                        @error('id_target')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @else
                        <p class="text-[10px] text-gray-500 mt-2">File ebook akan dikirim melalui email.</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-[10px] text-gray-400 uppercase font-bold ml-1">Nomor WhatsApp (Opsional)</label>
                        <input type="number" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="0812xxxx" class="w-full mt-2 bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white outline-none focus:ring-2 focus:ring-blue-500">
                        @error('kontak_pelanggan')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- STEP 2 --}}
            <section class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center">2</span>
                    Detail Pesanan
                </h3>

                <div class="flex gap-5 bg-black/40 p-5 rounded-2xl border border-white/5">
                    <img src="{{ $selectedProduct->gambar_produk ? asset('storage/' . $selectedProduct->gambar_produk) : asset('images/ebook-placeholder.png') }}" class="w-20 h-24 object-cover rounded-xl">
                    <div>
                        <h4 class="text-xl font-black text-white">{{ $selectedProduct->nama_produk }}</h4>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ $selectedProduct->deskripsi_produk ?? 'Buku digital PDF dikirim otomatis setelah pembayaran.' }}
                        </p>
                        <p class="text-blue-400 font-black text-xl mt-3">
                            Rp {{ number_format($selectedProduct->harga_produk, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 border-t border-white/10 pt-5">
                    <label class="text-[10px] text-gray-400 font-bold uppercase">Kode Promo</label>
                    <div class="flex gap-3 mt-2">
                        <input type="hidden" id="hidden_kode_promo" name="kode_promo">
                        <input type="text" id="input_kode_promo" placeholder="MASUKKAN KODE..." class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none">
                        <button type="button" id="btn_terapkan_promo" class="px-6 bg-blue-600 rounded-xl text-white font-bold">
                            Terapkan
                        </button>
                    </div>
                    <p id="pesan_promo" class="hidden text-xs mt-2 font-bold"></p>
                </div>
            </section>

            {{-- STEP 3 --}}
            <section class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/10 p-6 shadow-xl mb-32">
                <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center">3</span>
                    Metode Pembayaran
                </h3>

                @error('metode_pembayaran')
                <div class="bg-red-500/10 border border-red-500 rounded-xl p-3 text-red-400 text-sm mb-4">
                    Pilih metode pembayaran terlebih dahulu.
                </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach([
                    ['dana', 'DANA'],
                    ['gopay', 'GoPay'],
                    ['bca_va', 'BCA VA'],
                    ['echannel', 'MANDIRI VA']
                    ] as $pay)
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="{{ $pay[0] }}" class="hidden peer" {{ old('metode_pembayaran') == $pay[0] ? 'checked' : '' }} required>
                        <div class="h-14 bg-black/30 border border-white/10 rounded-xl flex items-center justify-center text-sm font-black text-white transition peer-checked:border-blue-500 peer-checked:bg-blue-500/10 hover:border-blue-400">
                            {{ $pay[1] }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </section>

            {{-- FLOATING PAYMENT --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/70 backdrop-blur-xl border border-white/20 p-4 rounded-3xl flex justify-between items-center shadow-2xl z-50">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase">Total Pembayaran</p>
                    <p class="text-sm text-white font-bold">
                        {{ $selectedProduct->nama_produk }}
                    </p>
                    <p id="tampil_diskon" class="hidden text-xs text-green-400 font-bold">
                        Diskon
                    </p>
                    <p id="tampil_total_akhir" class="text-xl text-blue-400 font-black">
                        Rp {{ number_format($selectedProduct->harga_produk, 0, ',', '.') }}
                    </p>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 px-8 py-3 rounded-2xl text-white font-black">
                    BELI SEKARANG
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('btn_terapkan_promo');
        const input = document.getElementById('input_kode_promo');
        const hidden = document.getElementById('hidden_kode_promo');
        const msg = document.getElementById('pesan_promo');

        btn.onclick = async () => {
            let kode = input.value.trim();

            if (!kode) return;

            btn.innerHTML = "...";

            try {
                let res = await fetch("{{ route('transaksi.cek-promo') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        kode_promo: kode,
                        // SINTAKS BLADE DIRAPATKAN DI SINI
                        total_pembelian: {{ $selectedProduct->harga_produk }}
                    })
                });

                let data = await res.json();
                msg.classList.remove('hidden');

                if (data.status === "success") {
                    hidden.value = kode;
                    msg.className = "text-green-400 text-xs mt-2 font-bold";
                    msg.innerHTML = data.message;

                    document.getElementById('tampil_diskon').classList.remove('hidden');
                    document.getElementById('tampil_diskon').innerHTML = "- Diskon Rp " + new Intl.NumberFormat('id-ID').format(data.potongan_harga);

                    // SINTAKS BLADE DIRAPATKAN DI SINI
                    let totalAkhir = Math.max(0, {{ $selectedProduct->harga_produk }} - data.potongan_harga);
                    
                    document.getElementById('tampil_total_akhir').innerHTML = "Rp " + new Intl.NumberFormat('id-ID').format(totalAkhir);
                } else {
                    msg.className = "text-red-400 text-xs mt-2 font-bold";
                    msg.innerHTML = data.message;
                }
            } catch (error) {
                msg.classList.remove('hidden');
                msg.className = "text-red-400 text-xs mt-2 font-bold";
                msg.innerHTML = "Terjadi kesalahan sistem.";
            }

            btn.innerHTML = "Terapkan";
        }
    });
</script>
@endsection