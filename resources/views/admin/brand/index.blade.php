@extends('layouts.admin')

@section('title', 'Kelola Brand')
@section('header_title', 'Manajemen Brand')
@section('header_subtitle', 'Kelola data brand penghubung kategori produk digital J-Store.')

@section('content')
{{-- NOTIFIKASI SUKSES --}}
@if(session('success'))
<div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 text-green-400 rounded-2xl flex items-center gap-3 text-sm font-semibold animate-fade-in">
    <span>✅</span>
    <span>{{ session('success') }}</span>
</div>
@endif

<section class="bg-white/5 rounded-[2rem] border border-white/10 overflow-hidden backdrop-blur-md shadow-2xl">

    {{-- HEADER TABEL --}}
    <div class="p-8 border-b border-white/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/[0.02]">
        <div>
            <h3 class="font-black text-xl uppercase tracking-tighter flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                Daftar Brand
            </h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Total data master penghubung sistem</p>
        </div>
        <a href="{{ route('admin.brand.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-blue-600/20 active:scale-95">
            ➕ TAMBAH BRAND BARU
        </a>
    </div>

    {{-- KONTEN TABEL --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

            <thead class="bg-black/20 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                <tr>
                    <th class="p-6 w-20">Logo</th>
                    <th class="p-6">Nama Brand & Kategori</th>
                    <th class="p-6">Prefix Operator</th>
                    <th class="p-6 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($brands as $brand)
                <tr class="hover:bg-white/[0.03] transition-all group">
                    
                    {{-- Logo/Gambar Brand --}}
                    <td class="p-6">
                        <div class="w-12 h-12 rounded-xl border border-white/10 bg-black/40 overflow-hidden flex items-center justify-center text-xl shadow-inner">
                            @if($brand->gambar_brand)
                                <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="w-full h-full object-cover">
                            @else
                                🏷️
                            @endif
                        </div>
                    </td>

                    {{-- Nama & Kategori --}}
                    <td class="p-6">
                        <p class="font-bold text-white group-hover:text-blue-400 transition-colors text-base">
                            {{ $brand->nama_brand }}
                        </p>
                        <p class="text-[10px] font-black text-purple-400 bg-purple-400/10 px-2 py-0.5 rounded w-fit uppercase tracking-widest mt-1">
                            {{ $brand->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </p>
                    </td>

                    {{-- Prefix (Untuk Pulsa) --}}
                    <td class="p-6">
                        @if($brand->prefix)
                            <div class="flex flex-wrap gap-1 max-w-md">
                                @foreach(explode(',', $brand->prefix) as $pref)
                                    <span class="text-[10px] font-mono font-bold bg-black/40 text-gray-300 border border-white/5 px-2 py-0.5 rounded">
                                        {{ trim($pref) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-gray-500 italic font-medium">Bukan Operator Seluler (NULL)</span>
                        @endif
                    </td>

                    {{-- Tombol Aksi --}}
                    <td class="p-6">
                        <div class="flex justify-center items-center gap-2">
                            {{-- EDIT --}}
                            <a href="{{ route('admin.brand.edit', $brand->id_brand) }}" class="p-2.5 bg-yellow-500/10 hover:bg-yellow-500 border border-yellow-500/20 text-yellow-500 hover:text-black rounded-xl text-xs font-bold transition-all" title="Edit">
                                ✏️
                            </a>
                            
                            {{-- DELETE --}}
                            <form action="{{ route('admin.brand.destroy', $brand->id_brand) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus brand ini beserta aset gambarnya?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-red-500/10 hover:bg-red-500 border border-red-500/20 text-red-400 hover:text-white rounded-xl text-xs font-bold transition-all" title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-20 text-center">
                        <span class="text-4xl block mb-4 opacity-20">📥</span>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-xs italic">
                            Belum ada data brand yang tercatat.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- LINK PAGINATION --}}
    @if($brands->hasPages())
    <div class="p-6 border-t border-white/10 bg-black/10">
        {{ $brands->links() }}
    </div>
    @endif

</section>
@endsection