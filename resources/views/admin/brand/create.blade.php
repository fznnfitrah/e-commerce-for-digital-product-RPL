@extends('layouts.admin')

@section('title', 'Tambah Brand Baru')
@section('header_title', 'Tambah Brand')
@section('header_subtitle', 'Tambahkan brand baru sebagai sub-kategori produk J-Store.')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data" class="bg-white/5 p-8 rounded-3xl border border-white/10 backdrop-blur-md shadow-2xl space-y-6">
        @csrf

        <h3 class="text-lg font-bold text-blue-400 mb-6 flex items-center gap-2">
            <span>🏷️</span> Informasi Brand
        </h3>

        {{-- Nama Brand --}}
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Nama Brand <span class="text-red-500">*</span></label>
            <input type="text" name="nama_brand" value="{{ old('nama_brand') }}" required placeholder="Contoh: Telkomsel / Mobile Legends"
                class="w-full bg-black/50 border @error('nama_brand') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            @error('nama_brand') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori Dropdown --}}
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Kategori Induk <span class="text-red-500">*</span></label>
            <select name="id_kategori" required class="w-full bg-black/50 border @error('id_kategori') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                <option value="">-- Pilih Kategori --</option>
                {{-- Pastikan dari controller Anda mengirimkan variabel $kategoris --}}
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
                @endforeach
            </select>
            @error('id_kategori') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        {{-- Prefix (Khusus Pulsa) --}}
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Prefix Operator (Khusus Pulsa)</label>
            <input type="text" name="prefix" value="{{ old('prefix') }}" placeholder="Contoh: 0812,0813,0821"
                class="w-full bg-black/50 border @error('prefix') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            <p class="text-[10px] text-gray-500 italic mt-2 ml-1">*Pisahkan dengan koma. Kosongkan jika brand ini bukan untuk provider pulsa.</p>
            @error('prefix') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        {{-- Logo Brand --}}
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Logo / Gambar Brand</label>
            <input type="file" name="gambar" accept="image/*" id="input-gambar"
                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600/10 file:text-blue-400 hover:file:bg-blue-600/20 transition-all">

            {{-- Preview Gambar --}}
            <div class="mt-4 w-32 h-32 rounded-2xl border border-white/10 bg-black/50 overflow-hidden hidden" id="preview-container">
                <img src="" id="img-preview" class="w-full h-full object-cover">
            </div>
            @error('gambar') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-4 pt-6 border-t border-white/10">
            <a href="{{ route('admin.brand.index') }}" class="px-8 py-3 rounded-xl font-bold text-gray-400 hover:text-white transition-all flex items-center">
                Batal
            </a>
            <button type="submit" class="px-10 py-3 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-wider">
                SIMPAN BRAND
            </button>
        </div>
    </form>
</div>

<script>
    // Live Preview Gambar
    document.getElementById('input-gambar').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const previewContainer = document.getElementById('preview-container');
            const imgPreview = document.getElementById('img-preview');

            imgPreview.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
        }
    };
</script>
@endsection