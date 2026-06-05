@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container mx-auto px-4 py-12 max-w-3xl">
    <div class="bg-[#1a1c23] border border-blue-500/20 rounded-3xl p-8 backdrop-blur-xl shadow-2xl relative overflow-hidden">

        {{-- Efek Glow --}}
        <div class="absolute -top-1/4 -right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <div class="text-center mb-8 pb-8 border-b border-white/10">
                <h2 class="text-3xl font-black italic uppercase text-white tracking-widest mb-2">Checkout</h2>
                <p class="text-gray-400">Selesaikan pembayaran untuk memproses pesanan Anda.</p>
                <div class="inline-block mt-4 px-4 py-2 bg-blue-500/10 border border-blue-500/30 rounded-xl text-blue-400 font-mono text-sm">
                    {{-- PERBAIKAN INVOICE --}}
                    No. Invoice: TRX-{{ $transaksi->id_transaksi }}
                </div>
            </div>

            <div class="space-y-6 mb-10">
                <div class="flex justify-between items-center bg-black/30 p-5 rounded-2xl border border-white/5">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-bold mb-1">Produk</p>
                        <p class="text-lg font-bold text-white">{{ $transaksi->produk->nama_produk }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-black/30 p-5 rounded-2xl border border-white/5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">ID Tujuan / No. HP</p>
                        <p class="font-bold text-gray-300">
                            {{ $transaksi->kontak_pelanggan !== '-' ? $transaksi->kontak_pelanggan : $transaksi->id_target }}
                        </p>
                    </div>
                    @if($transaksi->id_server)
                    <div class="bg-black/30 p-5 rounded-2xl border border-white/5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">ID Server</p>
                        <p class="font-bold text-gray-300">{{ $transaksi->id_server }}</p>
                    </div>
                    @endif
                </div>

                <div class="flex justify-between items-center bg-gradient-to-r from-blue-600/20 to-purple-600/20 p-6 rounded-2xl border border-blue-500/30">
                    <p class="text-sm font-black text-white uppercase tracking-widest">Total Pembayaran</p>
                    {{-- PERBAIKAN TYPO TOTAL AKHIR --}}
                    <p class="text-2xl font-black text-blue-400">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</p>
                </div>
            </div>

            <button id="pay-button" class="w-full py-5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-black uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(59,130,246,0.4)] transition transform hover:-translate-y-1 active:scale-95 text-lg">
                BAYAR SEKARANG ➔
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT MIDTRANS SNAP --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        snap.pay('{{ $transaksi->snap_token }}', {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil!");
                window.location.href = "/"; 
            },
            onPending: function(result) {
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result) {
                alert("Pembayaran Gagal!");
            },
            onClose: function() {
                alert('Anda menutup jendela pembayaran sebelum menyelesaikan transaksi.');
            }
        });
    };
</script>
@endsection