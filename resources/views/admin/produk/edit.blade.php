@extends('layouts.admin')

@section('title', 'Edit Produk - ' . $produk->nama_produk)
@section('header_title', 'Edit Produk')
@section('header_subtitle', 'Perbarui detail data produk ' . $produk->nama_produk)

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- SEKSI KIRI: INFORMASI UTAMA --}}
            <div class="space-y-6 bg-white/5 p-8 rounded-3xl border border-white/10 backdrop-blur-md">
                <h3 class="text-lg font-bold text-blue-400 mb-4 flex items-center gap-2">
                    <span>✏️</span> Ubah Informasi Dasar
                </h3>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Deskripsi Produk</label>
                    <textarea name="deskripsi_produk" required rows="4"
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Kategori</label>
                        <select name="id_kategori" required
                            class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}" {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Harga Produk (Rp)</label>
                        <input type="number" name="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}" required
                            class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- SEKSI KANAN: MEDIA --}}
            <div class="space-y-6 bg-white/5 p-8 rounded-3xl border border-white/10 backdrop-blur-md">
                <h3 class="text-lg font-bold text-[#DFFF00] mb-4 flex items-center gap-2">
                    <span>🖼️</span> Media Produk
                </h3>

                <div class="space-y-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Gambar Saat Ini</label>
                    <div class="relative w-full h-48 rounded-2xl overflow-hidden border border-white/10 bg-black/50">
                        @if($produk->gambar_produk)
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="w-full h-full object-cover" id="img-preview">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                            <span class="text-xs italic">Belum ada gambar</span>
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Ganti Gambar (Opsional)</label>
                        <input type="file" name="gambar" id="input-gambar" accept="image/*"
                            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600/10 file:text-blue-400 hover:file:bg-blue-600/20 transition-all">
                    </div>
                </div>

                {{-- INFO TYPE (Read Only di Edit untuk Keamanan Relasi Aset) --}}
                <div class="mt-10 p-4 bg-yellow-500/10 rounded-xl border border-yellow-500/20">
                    <p class="text-[10px] text-yellow-500 font-bold uppercase mb-1">Tipe Produk</p>
                    <p class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $produk->type ?? 'Digital Item' }}
                    </p>
                    <p class="text-[10px] text-gray-500 mt-2 italic">
                        *Tipe produk tidak dapat diubah setelah dibuat untuk menjaga integritas data aset.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.produk.index') }}"
                class="px-8 py-3 rounded-xl font-bold text-gray-400 hover:text-white transition-all flex items-center">
                Batal
            </a>
            <button type="submit"
                class="px-10 py-3 bg-[#DFFF00] hover:bg-[#c9e600] text-black font-extrabold rounded-xl 
               shadow-lg shadow-[#DFFF00]/20 transition-all active:scale-95 uppercase tracking-wider">
                PERBARUI DATA
            </button>
        </div>
    </form>
</div>

<script>
    // Live Preview Gambar saat dipilih
    document.getElementById('input-gambar').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('img-preview').src = URL.createObjectURL(file);
        }
    };
</script>
@endsection