@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">
    
    {{-- FORM WRAPPER UTAMA --}}
    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-ebook">
        @csrf

        {{-- BANNER DINAMIS --}}
        <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ $kategori->gambar_kategori ? asset('storage/' . $kategori->gambar_kategori) : asset('images/default-banner.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-8">
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">{{ $kategori->nama_kategori }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">
            
            {{-- STEP 1: INFORMASI PENGIRIMAN (ID TARGET & KONTAK) --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">1</span>
                    Informasi Pengiriman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- EMAIL SEBAGAI ID TARGET (WAJIB) --}}
                    <div class="space-y-2">
                        <input type="email" name="id_target" value="{{ old('id_target') }}" required placeholder="Alamat Email Aktif"
                            class="w-full bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        
                        @error('id_target')
                            <p class="text-red-500 text-xs font-semibold ml-1">{{ $message }}</p>
                        @else
                            <p class="text-[10px] text-gray-400 italic ml-1">* E-book akan dikirim ke email ini</p>
                        @enderror
                    </div>

                    {{-- WHATSAPP SEBAGAI KONTAK PELANGGAN (OPSIONAL) --}}
                    <div class="space-y-2">
                        <input type="number" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Nomor WhatsApp (Opsional)"
                            class="w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-green-500 outline-none transition">
                        
                        @error('kontak_pelanggan')
                            <p class="text-red-500 text-xs font-semibold ml-1">{{ $message }}</p>
                        @else
                            <p class="text-[10px] text-gray-400 italic ml-1">* Untuk notifikasi atau pengiriman VA</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STEP 2: PILIH PRODUK --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">2</span>
                    Pilih Produk {{ $kategori->nama_kategori }}
                </h3>

                @error('id_produk')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                        Anda belum memilih e-book.
                    </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($items as $item)
                    <label class="cursor-pointer group">
                        <input type="radio" name="id_produk" value="{{ $item->id_produk }}" class="peer hidden input-produk" 
                               data-name="{{ $item->nama_produk }}" 
                               data-price="{{ number_format($item->harga_produk, 0, ',', '.') }}"
                               {{ old('id_produk') == $item->id_produk ? 'checked' : '' }} required>
                        
                        <div class="bg-black/20 border border-white/10 rounded-2xl p-4 transition-all text-left peer-checked:border-blue-500 peer-checked:bg-blue-500/20 hover:border-blue-400">
                            <p class="text-[10px] font-bold text-gray-400 group-hover:text-blue-300 mb-1 line-clamp-1">{{ $item->nama_produk }}</p>
                            <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3: PEMBAYARAN --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl mb-32">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">3</span>
                    Metode Bayar
                </h3>

                @error('metode_pembayaran')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                        Pilih metode pembayaran terlebih dahulu.
                    </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {{-- DANA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="dana" class="hidden peer" {{ old('metode_pembayaran') == 'dana' ? 'checked' : '' }} required>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex items-center justify-center transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10 hover:border-cyan-400">
                            <span class="text-cyan-400 font-black text-sm uppercase">DANA</span>
                        </div>
                    </label>

                    {{-- GOPAY --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="gopay" class="hidden peer" {{ old('metode_pembayaran') == 'gopay' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex items-center justify-center transition peer-checked:border-green-500 peer-checked:bg-green-500/10 hover:border-green-400">
                            <span class="text-green-400 font-black text-sm uppercase">GoPay</span>
                        </div>
                    </label>

                    {{-- OVO --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="ovo" class="hidden peer" {{ old('metode_pembayaran') == 'ovo' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex items-center justify-center transition peer-checked:border-purple-500 peer-checked:bg-purple-500/10 hover:border-purple-400">
                            <span class="text-purple-400 font-black text-sm uppercase">OVO</span>
                        </div>
                    </label>

                    {{-- BCA VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bca_va" class="hidden peer" {{ old('metode_pembayaran') == 'bca_va' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-blue-600 peer-checked:bg-blue-600/10 hover:border-blue-500">
                            <span class="text-blue-500 font-black text-xs uppercase">BCA VA</span>
                        </div>
                    </label>

                    {{-- MANDIRI (ECHANNEL) --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="echannel" class="hidden peer" {{ old('metode_pembayaran') == 'echannel' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10 hover:border-yellow-400">
                            <span class="text-yellow-500 font-black text-xs uppercase">MANDIRI VA</span>
                        </div>
                    </label>

                    {{-- BNI VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bni_va" class="hidden peer" {{ old('metode_pembayaran') == 'bni_va' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-orange-500 peer-checked:bg-orange-500/10 hover:border-orange-400">
                            <span class="text-orange-500 font-black text-xs uppercase">BNI VA</span>
                        </div>
                    </label>

                    {{-- BRI VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bri_va" class="hidden peer" {{ old('metode_pembayaran') == 'bri_va' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-blue-400 peer-checked:bg-blue-400/10 hover:border-blue-300">
                            <span class="text-blue-400 font-black text-xs uppercase">BRI VA</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- FLOATING BAR (SUBMIT SECTION) --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/60 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Terpilih:</p>
                    <p id="display-item" class="text-sm font-bold text-white truncate max-w-[150px] md:max-w-[300px]">Belum memilih E-book</p>
                    <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
                </div>
                <button type="submit" class="bg-blue-600 px-6 py-3 md:px-8 md:py-4 rounded-2xl font-black text-sm text-white hover:bg-blue-500 transition-all active:scale-95 shadow-lg shadow-blue-600/30">
                    BELI SEKARANG
                </button>
            </div>
            
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productRadios = document.querySelectorAll('.input-produk');
        const displayItem = document.getElementById('display-item');
        const displayPrice = document.getElementById('display-price');

        // Fungsi untuk mengupdate floating bar
        function updateFloatingBar(element) {
            displayItem.innerText = element.getAttribute('data-name');
            displayPrice.innerText = 'Rp ' + element.getAttribute('data-price');
        }

        // Tambahkan event listener ke setiap radio button produk
        productRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateFloatingBar(this);
            });

            // Cek jika ada radio button yang sudah terpilih (karena fungsi old() dari error)
            if(radio.checked) {
                updateFloatingBar(radio);
            }
        });
    });
</script>
@endsection