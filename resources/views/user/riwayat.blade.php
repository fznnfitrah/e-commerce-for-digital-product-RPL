@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    <div class="mb-8">
        <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">Riwayat Pembelian</h2>
        <p class="text-gray-400 text-sm mt-1">Pantau pesanan digital Anda dan berikan ulasan untuk produk yang telah dibeli.</p>
    </div>

    @if($transaksis->isEmpty())
    <div class="bg-white/5 border border-white/10 p-10 rounded-3xl text-center shadow-xl">
        <span class="text-4xl block mb-3">🛒</span>
        <h3 class="text-lg font-bold text-white mb-2">Belum Ada Transaksi</h3>
        <p class="text-gray-400 text-sm">Anda belum melakukan pembelian produk digital apapun.</p>
        <a href="{{ route('dashboard') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition">Mulai Belanja</a>
    </div>
    @else
    <div class="space-y-5">
        @foreach($transaksis as $trx)
        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6 transition-all hover:bg-white/10 shadow-lg">

            {{-- INFO SEBELAH KIRI --}}
            <div class="w-full md:w-auto">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                    <span class="text-[10px] font-bold bg-black/50 text-gray-300 px-2 py-1 rounded-md">{{ $trx->id_transaksi }}</span>
                </div>
                <h3 class="text-lg font-bold text-white">{{ $trx->produk->nama_produk ?? 'Produk telah dihapus' }}</h3>
                <p class="text-sm font-black text-[#DFFF00] mt-1">Rp {{ number_format($trx->total_akhir, 0, ',', '.') }}</p>
            </div>

            {{-- AKSI SEBELAH KANAN --}}
            <div class="w-full md:w-auto flex flex-row md:flex-col justify-between md:justify-end items-center md:items-end gap-3">

                {{-- BADGE STATUS MIDTRANS --}}
                @php
                $status = strtolower($trx->status_pembayaran);
                $badgeColor = 'bg-yellow-500/20 text-yellow-500 border-yellow-500/30'; // Default Pending

                if(in_array($status, ['settlement', 'capture', 'success'])) {
                $badgeColor = 'bg-green-500/20 text-green-400 border-green-500/30';
                } elseif(in_array($status, ['deny', 'cancel', 'expire', 'failure'])) {
                $badgeColor = 'bg-red-500/20 text-red-400 border-red-500/30';
                }
                @endphp
                <span class="px-4 py-1 text-[10px] font-black uppercase tracking-widest rounded-full border {{ $badgeColor }}">
                    {{ $status === 'settlement' ? 'SUCCESS' : $status }}
                </span>

                {{-- LOGIKA TOMBOL ULASAN (VERIFIED BUYER) --}}
                @if(in_array($status, ['settlement', 'capture', 'success']))
                @if($trx->review)
                <div class="flex items-center gap-2 text-gray-400 text-sm font-semibold">
                    <span>✅</span> Ulasan Terkirim
                </div>
                @else
                {{-- Nanti href ini akan kita arahkan ke form review --}}
                <a href="{{ route('user.review.create', $trx->id_transaksi) }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-lg shadow-blue-600/30 active:scale-95">
                    ⭐ Beri Ulasan
                </a>
                @endif
                @endif

            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection