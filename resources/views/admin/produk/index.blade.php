@extends('layouts.admin')

@section('title', 'Daftar Produk')
@section('header_title', 'Semua Produk')
@section('header_subtitle', 'Kelola katalog dan aset digital J-Store Anda.')

@section('content')
<div class="mb-8 flex justify-between items-center">
    {{-- Search & Filter Simple --}}
    <div class="relative w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">🔍</span>
        <input type="text" placeholder="Cari nama produk..."
            class="w-full bg-white/5 border border-white/10 rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
    </div>

    <a href="{{ route('admin.produk.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 transition-all active:scale-95 shadow-lg shadow-blue-600/20">
        <span>✚</span> Tambah Produk Baru
    </a>
</div>

{{-- GRID PRODUK --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($produks as $p)
    <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-md group hover:border-blue-500/50 transition-all duration-300">

        {{-- Gambar Produk --}}
        <div class="relative h-48 overflow-hidden">
            @if($p->gambar_produk)
            <img src="{{ asset('storage/' . $p->gambar_produk) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @else
            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-black flex items-center justify-center">
                <span class="text-4xl">📦</span>
            </div>
            @endif

            {{-- Badge Status --}}
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                    {{ $p->status == 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                    {{ $p->status }}
                </span>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="p-5">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">
                    {{ $p->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                </p>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                    {{ $p->asets_count ?? 0 }} Stok
                </p>
            </div>

            <h4 class="font-bold text-lg text-white mb-4 line-clamp-1">{{ $p->nama_produk }}</h4>

            <div class="flex justify-between items-center mt-auto">
                <p class="font-black text-xl text-[#DFFF00]">
                    <span class="text-xs font-normal text-gray-400 mr-1">Rp</span>{{ number_format($p->harga_produk, 0, ',', '.') }}
                </p>

                <div class="flex gap-2">
                    <a href="{{ route('admin.produk.edit', $p->id_produk) }}"
                        class="p-2 bg-white/5 hover:bg-white/10 rounded-lg text-gray-400 hover:text-white transition" title="Edit">
                        ✏️
                    </a>

                    <form action="{{ route('admin.produk.destroy', $p->id_produk) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete p-2 bg-white/5 hover:bg-red-500/10 rounded-lg text-gray-400 hover:text-red-500 transition" title="Hapus">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center">
        <div class="text-6xl mb-4 text-gray-700">🛒</div>
        <h3 class="text-xl font-bold text-gray-400">Belum ada produk.</h3>
        <p class="text-gray-600">Mulai tambahkan produk digital pertama Anda.</p>
    </div>
    @endforelse
</div>
@endsection