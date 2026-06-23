@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-6xl">

    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-topup">
        @csrf

        {{-- BANNER --}}
        <div class="relative h-48 md:h-64 rounded-3xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ asset('images/banner-ml.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40"></div>
            <div class="absolute bottom-6 left-8">
                <h2 class="text-3xl font-black italic uppercase text-white">
                    {{ $kategori->nama_kategori }}
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT PRODUCT CARD --}}
            <div class="lg:col-span-4">
                <div class="sticky top-24 bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6">

                    {{-- BAGIAN GAMBAR DINAMIS --}}
                    <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 flex items-center justify-center p-4">
                        @if($brand->gambar_brand)
                        <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="max-w-full max-h-full object-contain">
                        @else
                        <span class="text-7xl">🎮</span>
                        @endif
                    </div>
                    <h2 class="text-xl font-black text-white uppercase">
                        {{ $brand->nama_brand }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-2">
                        Top Up {{ $brand->nama_brand }} cepat dan aman.
                    </p>

                    <div class="mt-5 space-y-3 text-xs text-gray-400">
                        <p class="flex gap-2"><span class="text-green-400">●</span> Proses otomatis</p>
                        <p class="flex gap-2"><span class="text-green-400">●</span> Pembayaran aman</p>
                        <p class="flex gap-2"><span class="text-green-400">●</span> Masuk dalam hitungan detik</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- STEP 1: AKUN & KONTAK --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6">
                    <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                        <span class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">1</span>
                        Masukkan Data
                    </h3>

                    {{-- Hidden Input Utama untuk Controller --}}
                    <input type="hidden" name="id_target" id="hidden_id_target" value="{{ old('id_target') }}">

                    @error('id_target')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-400 text-xs font-semibold">
                        Error Data Game: {{ $message }}
                    </div>
                    @enderror

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase">User ID</label>
                            <input type="text" id="visual_user_id" placeholder="User ID" required
                                class="mt-2 w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-bold uppercase">Zone ID</label>
                            <input type="text" id="visual_zone_id" placeholder="Zone ID"
                                class="mt-2 w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="text-xs text-gray-400 font-bold uppercase">Whatsapp / Email</label>
                        <input type="text" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Untuk bukti transaksi" required
                            class="mt-2 w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('kontak_pelanggan')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- STEP 2: NOMINAL --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6">
                    <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                        <span class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">2</span>
                        Pilih Nominal
                    </h3>

                    @error('id_produk')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-400 text-xs font-semibold">
                        Pilih nominal produk terlebih dahulu.
                    </div>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($items as $item)
                        <label class="cursor-pointer">
                            <input type="radio" name="id_produk" value="{{ $item->id_produk }}" class="hidden peer input-produk"
                                data-name="{{ $item->nama_produk }}" data-raw-price="{{ $item->harga_produk }}"
                                {{ old('id_produk') == $item->id_produk ? 'checked' : '' }} required>

                            <div class="bg-black/30 border border-white/10 rounded-2xl p-4 transition peer-checked:border-blue-500 peer-checked:bg-blue-500/20 hover:border-blue-400">
                                <p class="text-xs text-gray-400">{{ $item->nama_produk }}</p>
                                <p class="text-white font-black mt-2">Rp {{ number_format($item->harga_produk,0,',','.') }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 3: METODE PEMBAYARAN --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6">
                    <h3 class="flex items-center gap-3 text-white font-bold mb-5">
                        <span class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">3</span>
                        Metode Pembayaran
                    </h3>

                    @error('metode_pembayaran')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-400 text-xs font-semibold">
                        Pilih metode pembayaran terlebih dahulu.
                    </div>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach([
                        'gopay' => 'GOPAY',
                        'dana' => 'DANA',
                        'ovo' => 'OVO',
                        'bca_va' => 'BCA VA',
                        'echannel' => 'MANDIRI VA',
                        'bni_va' => 'BNI VA',
                        'bri_va' => 'BRI VA'
                        ] as $key => $name)
                        <label>
                            <input type="radio" name="metode_pembayaran" value="{{ $key }}" class="hidden peer" {{ old('metode_pembayaran') == $key ? 'checked' : '' }} required>
                            <div class="h-14 rounded-xl bg-black/30 border border-white/10 flex items-center justify-center text-xs font-black text-white peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-colors">
                                {{ $name }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 4: PROMO --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6">
                    <h3 class="text-white font-bold mb-4">
                        Detail Pembelian & Promo
                    </h3>

                    <div class="flex gap-3">
                        <input type="hidden" name="kode_promo" id="hidden_kode_promo" value="{{ old('kode_promo') }}">
                        <input type="text" id="input_kode_promo" placeholder="Kode Promo" class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none uppercase">
                        <button type="button" id="btn_terapkan_promo" class="px-5 rounded-xl bg-yellow-500 text-black font-bold transition active:scale-95">
                            Terapkan
                        </button>
                    </div>
                    <p id="pesan_promo" class="hidden text-xs mt-2 font-bold"></p>
                </div>

            </div>
        </div>

        {{-- FLOAT BAR --}}
        <div class="fixed bottom-5 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/80 backdrop-blur-xl border border-white/20 rounded-3xl p-4 flex justify-between items-center z-50 shadow-2xl">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Total Pembayaran</p>
                <p id="display-price" class="text-2xl font-black text-lime-400">Rp 0</p>
            </div>
            <button type="submit" class="bg-blue-600 px-8 py-3 rounded-xl font-black text-white hover:bg-blue-500 transition active:scale-95">
                BELI SEKARANG
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // 1. Elemen ID & Zone
        const uid = document.getElementById('visual_user_id');
        const zid = document.getElementById('visual_zone_id');
        const hiddenIdTarget = document.getElementById('hidden_id_target');

        function updateID() {
            hiddenIdTarget.value = zid.value ? `${uid.value} (${zid.value})` : uid.value;
        }

        uid.addEventListener('input', updateID);
        zid.addEventListener('input', updateID);

        // Kembalikan form jika error reload
        if (hiddenIdTarget.value) {
            const match = hiddenIdTarget.value.match(/^(.*?)(?:\s*\((.*?)\))?$/);
            if (match) {
                uid.value = match[1] || '';
                zid.value = match[2] || '';
            }
        }

        // 2. Elemen Harga & Promo
        const radios = document.querySelectorAll('.input-produk');
        const priceDisplay = document.getElementById('display-price');
        const btnPromo = document.getElementById('btn_terapkan_promo');
        const inputPromo = document.getElementById('input_kode_promo');
        const hiddenPromo = document.getElementById('hidden_kode_promo');
        const pesanPromo = document.getElementById('pesan_promo');

        let currentPrice = 0;
        let currentDiscount = 0;

        function updatePriceDisplay() {
            const total = Math.max(0, currentPrice - currentDiscount);
            priceDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        radios.forEach(r => {
            r.addEventListener('change', () => {
                currentPrice = parseInt(r.dataset.rawPrice);

                // Reset promo jika user ganti nominal
                if (hiddenPromo.value !== '') {
                    inputPromo.value = '';
                    hiddenPromo.value = '';
                    currentDiscount = 0;
                    pesanPromo.innerText = 'Nominal diubah. Terapkan ulang promo.';
                    pesanPromo.className = 'text-xs mt-2 font-bold text-yellow-500 block';
                }
                updatePriceDisplay();
            });

            // Trigger harga awal jika radio sudah checked (karena old() helper)
            if (r.checked) {
                currentPrice = parseInt(r.dataset.rawPrice);
                updatePriceDisplay();
            }
        });

        // 3. Logika Fetch Promo Asinkron
        if (btnPromo) {
            btnPromo.addEventListener('click', async () => {
                const kode = inputPromo.value.trim().toUpperCase();

                if (!kode) {
                    pesanPromo.innerText = 'Masukkan kode promo!';
                    pesanPromo.className = 'text-xs mt-2 font-bold text-red-500 block';
                    return;
                }
                if (currentPrice === 0) {
                    pesanPromo.innerText = 'Pilih nominal terlebih dahulu!';
                    pesanPromo.className = 'text-xs mt-2 font-bold text-red-500 block';
                    return;
                }

                btnPromo.innerText = '...';
                btnPromo.disabled = true;

                try {
                    // Gunakan path relatif agar aman dari isu CORS Ngrok
                    const response = await fetch('/transaksi/cek-promo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            kode_promo: kode,
                            total_pembelian: currentPrice
                        })
                    });

                    const result = await response.json();

                    if (result.status === 'success') {
                        hiddenPromo.value = kode;
                        currentDiscount = result.potongan_harga;
                        pesanPromo.innerText = result.message + ` (Diskon: Rp ${new Intl.NumberFormat('id-ID').format(currentDiscount)})`;
                        pesanPromo.className = 'text-xs mt-2 font-bold text-green-400 block';
                        updatePriceDisplay();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (err) {
                    hiddenPromo.value = '';
                    currentDiscount = 0;
                    pesanPromo.innerText = err.message || 'Gagal mengecek promo.';
                    pesanPromo.className = 'text-xs mt-2 font-bold text-red-500 block';
                    updatePriceDisplay();
                } finally {
                    btnPromo.innerText = 'Terapkan';
                    btnPromo.disabled = false;
                }
            });
        }
    });
</script>
@endsection