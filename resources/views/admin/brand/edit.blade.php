@extends('layouts.admin')

@section('title', 'Edit Brand')
@section('header_title', 'Edit Data Brand')
@section('header_subtitle', 'Ubah data parameter dari brand terpilih.')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.brand.update', $brand->id_brand) }}" method="POST" enctype="multipart/form-data" class="bg-white/5 border border-white/10 rounded-[2rem] p-8 backdrop-blur-md shadow-2xl space-y-6">
        @csrf
        @method('PUT')

        {{-- KATEGORI PARENT --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Pilih Kategori Induk</label>
            <select name="id_kategori" required class="w-full bg-black/40 border @error('id_kategori') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3.5 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $brand->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('id_kategori')
                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- NAMA BRAND --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Nama Brand</label>
            <input type="text" name="nama_brand" value="{{ old('nama_brand', $brand->nama_brand) }}" required
                class="w-full bg-black/40 border @error('nama_brand') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3.5 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
            @error('nama_brand')
                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- PREFIX OPERATOR (KHUSUS PULSA) --}}
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Prefix Operator (Khusus Kategori Pulsa)</label>
            <input type="text" name="prefix" value="{{ old('prefix', $brand->prefix) }}" placeholder="Contoh: 0811,0812,0813,0821"
                class="w-full bg-black/40 border @error('prefix') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3.5 text-sm font-mono tracking-wider text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
            <p class="text-[10px] text-gray-500 font-medium leading-relaxed">
                * Wajib dipisahkan dengan tanda koma tanpa spasi jika lebih dari satu nomor. Biarkan kosong jika bukan kategori pulsa.
            </p>
            @error('prefix')
                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- GAMBAR / LOGO BRAND CURRENT AND NEW --}}
        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Logo Saat Ini</label>
                <div class="w-24 h-24 rounded-2xl border border-white/10 bg-black/40 overflow-hidden flex items-center justify-center text-3xl">
                    @if($brand->gambar_brand)
                        <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="w-full h-full object-cover">
                    @else
                        🏷️
                    @endif
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Ganti Logo / Banner Brand</label>
                <input type="file" name="gambar_brand" accept="image/*"
                    class="w-full bg-black/40 border @error('gambar_brand') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-gray-400 focus:ring-2 focus:ring-blue-500 outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500 file:cursor-pointer">
                <p class="text-[10px] text-gray-500 font-medium">* Biarkan kosong jika tidak ingin mengubah logo brand.</p>
                @error('gambar_brand')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- BUTTON SUBMIT --}}
        <div class="pt-4 flex items-center gap-3">
            <button type="submit" class="px-6 py-3.5 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-yellow-500/20 active:scale-95">
                🔄 PERBARUI DATA BRAND
            </button>
            <a href="{{ route('admin.brand.index') }}" class="px-6 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 text-xs font-black uppercase tracking-wider rounded-xl transition-all">
                BATAL
            </a>
        </div>

    </form>
</div>
@endsection