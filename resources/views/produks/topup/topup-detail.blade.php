@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-topup">
        @csrf

        {{-- BANNER PRODUK --}}
        <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ asset('images/banner-ml.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <div class="absolute bottom-6 left-8">
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">{{ $kategori->nama_kategori }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">

            {{-- STEP 1: MASUKKAN ID & KONTAK --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Informasi Akun & Kontak
                </h3>

                {{-- Hidden input untuk ditangkap oleh Controller --}}
                <input type="hidden" name="id_target" id="hidden_id_target" value="{{ old('id_target') }}" required>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Input Visual User ID & Zone ID --}}
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Data Game</label>
                        <div class="flex gap-2">
                            <input type="text" id="visual_user_id" placeholder="User ID"
                                class="w-2/3 bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            <input type="text" id="visual_zone_id" placeholder="Zone ID"
                                class="w-1/3 bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                        @error('id_target')
                        <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Kontak (WhatsApp/Email) --}}
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">WhatsApp / Email</label>
                        <input type="text" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Untuk bukti top-up" required
                            class="w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        @error('kontak_pelanggan')
                        <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STEP 2: PILIH NOMINAL --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    Pilih Nominal {{ $kategori->nama_kategori }}
                </h3>

                @error('id_produk')
                <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                    Pilih produk nominal terlebih dahulu.
                </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($items as $item)
                    <label class="cursor-pointer group">
                        <input type="radio" name="id_produk" value="{{ $item->id_produk }}" class="peer hidden input-produk"
                            data-name="{{ $item->nama_produk }}"
                            data-price="{{ number_format($item->harga_produk, 0, ',', '.') }}"
                            {{ old('id_produk') == $item->id_produk ? 'checked' : '' }} required>

                        <div class="bg-black/20 border border-white/5 rounded-2xl p-4 transition-all text-left peer-checked:border-blue-500 peer-checked:bg-blue-500/20 hover:border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold text-gray-400 group-hover:text-blue-400">{{ $item->nama_produk }}</span>
                                <img src="{{ asset('images/diamond-icon.png') }}" class="w-4 h-4">
                            </div>
                            <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3: METODE BAYAR --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl mb-32">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Pilih Metode Bayar
                </h3>

                @error('metode_pembayaran')
                <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                    Pilih metode pembayaran terlebih dahulu.
                </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {{-- E-WALLETS --}}
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="gopay" class="hidden peer" {{ old('metode_pembayaran') == 'gopay' ? 'checked' : '' }} required>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex items-center justify-center h-12 transition peer-checked:border-green-500 peer-checked:bg-green-500/10 hover:border-green-500">
                            <span class="text-green-500 font-black text-xs uppercase">GOPAY</span>
                        </div>
                    </label>
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="dana" class="hidden peer" {{ old('metode_pembayaran') == 'dana' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex items-center justify-center h-12 transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10 hover:border-cyan-500">
                            <span class="text-cyan-500 font-black text-xs uppercase">DANA</span>
                        </div>
                    </label>
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="ovo" class="hidden peer" {{ old('metode_pembayaran') == 'ovo' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex items-center justify-center h-12 transition peer-checked:border-purple-500 peer-checked:bg-purple-500/10 hover:border-purple-500">
                            <span class="text-purple-500 font-black text-xs uppercase">OVO</span>
                        </div>
                    </label>

                    {{-- VIRTUAL ACCOUNTS --}}
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="bca_va" class="hidden peer" {{ old('metode_pembayaran') == 'bca_va' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex flex-col items-center justify-center transition peer-checked:border-blue-600 peer-checked:bg-blue-600/10 hover:border-blue-600">
                            <span class="text-blue-500 font-black text-[10px] uppercase">BCA VA</span>
                        </div>
                    </label>
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="echannel" class="hidden peer" {{ old('metode_pembayaran') == 'echannel' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex flex-col items-center justify-center transition peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10 hover:border-yellow-500">
                            <span class="text-yellow-500 font-black text-[10px] uppercase">MANDIRI VA</span>
                        </div>
                    </label>
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="bni_va" class="hidden peer" {{ old('metode_pembayaran') == 'bni_va' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex flex-col items-center justify-center transition peer-checked:border-orange-500 peer-checked:bg-orange-500/10 hover:border-orange-500">
                            <span class="text-orange-500 font-black text-[10px] uppercase">BNI VA</span>
                        </div>
                    </label>
                    <label class="cursor-pointer"><input type="radio" name="metode_pembayaran" value="bri_va" class="hidden peer" {{ old('metode_pembayaran') == 'bri_va' ? 'checked' : '' }}>
                        <div class="bg-black/30 border border-white/10 p-3 rounded-xl flex flex-col items-center justify-center transition peer-checked:border-blue-400 peer-checked:bg-blue-400/10 hover:border-blue-400">
                            <span class="text-blue-400 font-black text-[10px] uppercase">BRI VA</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- FLOATING PURCHASE BAR --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/80 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Item Terpilih:</p>
                    <p id="display-item" class="text-sm font-bold text-white truncate max-w-[150px] md:max-w-[300px]">Belum memilih item</p>
                    <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
                </div>
                <button type="submit" class="bg-blue-600 px-6 py-3 md:px-10 rounded-2xl font-black text-sm hover:bg-blue-500 transition-all active:scale-95 shadow-lg shadow-blue-600/30 text-white">
                    BELI SEKARANG
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualUserId = document.getElementById('visual_user_id');
        const visualZoneId = document.getElementById('visual_zone_id');
        const hiddenIdTarget = document.getElementById('hidden_id_target');

        const productRadios = document.querySelectorAll('.input-produk');
        const displayItem = document.getElementById('display-item');
        const displayPrice = document.getElementById('display-price');

        // Fungsi menggabungkan ID
        function updateHiddenId() {
            const uid = visualUserId.value.trim();
            const zid = visualZoneId.value.trim();
            if (uid && zid) {
                hiddenIdTarget.value = `${uid} (${zid})`;
            } else if (uid) {
                hiddenIdTarget.value = uid;
            } else {
                hiddenIdTarget.value = '';
            }
        }

        visualUserId.addEventListener('input', updateHiddenId);
        visualZoneId.addEventListener('input', updateHiddenId);

        // Jika ada old('id_target') yang dikembalikan oleh Laravel, kita coba pecah kembali
        if (hiddenIdTarget.value) {
            const match = hiddenIdTarget.value.match(/^(.*?)(?:\s*\((.*?)\))?$/);
            if (match) {
                visualUserId.value = match[1] || '';
                visualZoneId.value = match[2] || '';
            }
        }

        // Fungsi update Floating Bar
        function updateFloatingBar(element) {
            displayItem.innerText = element.getAttribute('data-name');
            displayPrice.innerText = 'Rp ' + element.getAttribute('data-price');
        }

        productRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateFloatingBar(this);
            });

            if (radio.checked) {
                updateFloatingBar(radio);
            }
        });
    });
</script>
@endsection