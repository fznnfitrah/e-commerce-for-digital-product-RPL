@extends('layouts.app')

{{-- Tambahkan CDN SweetAlert2 di bagian atas atau di layout utama --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">
    {{-- BANNER PRODUK --}}
    <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
        <img src="{{ asset('images/banner-ml.png') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        {{-- STEP 1: MASUKKAN ID --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-4">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                Masukkan User ID
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="user-id" placeholder="Masukkan User ID" class="bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500 text-white">
                <input type="text" id="zone-id" placeholder="Zone ID" class="bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-blue-500 text-white">
            </div>
        </div>

        {{-- STEP 2: PILIH NOMINAL --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-6">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                Pilih Nominal {{ $kategori->nama_kategori }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($items as $item)
                <button onclick="selectItem(this, '{{ $item->nama_produk }}', '{{ number_format($item->harga_produk, 0, ',', '.') }}')"
                    class="nominal-card bg-black/20 border border-white/5 rounded-2xl p-4 hover:border-blue-500 transition-all text-left group">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-gray-400 group-hover:text-blue-400">{{ $item->nama_produk }}</span>
                        <img src="{{ asset('images/diamond-icon.png') }}" class="w-4 h-4">
                    </div>
                    <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- STEP 3: METODE BAYAR --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-6">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                Pilih Metode Bayar
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div onclick="selectPayment(this, 'Gopay')" class="payment-card bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-4 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/gopay.png') }}" class="h-6 object-contain">
                </div>
                <div onclick="selectPayment(this, 'Dana')" class="payment-card bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-4 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/dana.png') }}" class="h-6 object-contain">
                </div>
            </div>
        </div>

        {{-- FLOATING PURCHASE BAR --}}
        <div class="sticky bottom-6 bg-white/10 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Item Terpilih:</p>
                <p id="display-item" class="text-xs font-bold text-white">-</p>
                <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
            </div>
            <button onclick="prosesBeli()" class="bg-blue-600 px-10 py-3 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-600/20 text-white">
                BELI SEKARANG
            </button>
        </div>
    </div>
</div>

<script>
    let selectedItem = null;
    let selectedPrice = null;
    let selectedMethod = null;

    function selectItem(element, name, price) {
        // Reset border semua kartu nominal
        document.querySelectorAll('.nominal-card').forEach(el => el.classList.remove('border-blue-500', 'bg-blue-500/10'));
        // Set active
        element.classList.add('border-blue-500', 'bg-blue-500/10');
        
        selectedItem = name;
        selectedPrice = price;
        document.getElementById('display-item').innerText = name;
        document.getElementById('display-price').innerText = 'Rp ' + price;
    }

    function selectPayment(element, method) {
        document.querySelectorAll('.payment-card').forEach(el => el.classList.remove('border-blue-500'));
        element.classList.add('border-blue-500');
        selectedMethod = method;
    }

    function prosesBeli() {
        const userId = document.getElementById('user-id').value;
        const zoneId = document.getElementById('zone-id').value;

        // Validasi
        if (!userId || !zoneId || !selectedItem || !selectedMethod) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi semua form (ID, Nominal, dan Metode Bayar)!',
                background: '#1a1c23',
                color: '#fff',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        // Pop Up Konfirmasi & QRIS
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `
                <div class="text-left text-sm text-gray-300 space-y-2 bg-black/20 p-4 rounded-xl border border-white/10 mb-4">
                    <p><strong>User ID:</strong> ${userId} (${zoneId})</p>
                    <p><strong>Item:</strong> ${selectedItem}</p>
                    <p><strong>Metode:</strong> ${selectedMethod}</p>
                    <p class="text-lg text-[#DFFF00] font-black"><strong>Total:</strong> Rp ${selectedPrice}</p>
                </div>
                <div class="bg-white p-4 rounded-2xl mx-auto w-48 shadow-lg">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=JSTORE-QRIS" alt="QRIS" class="w-full">
                    <p class="text-[10px] text-black mt-2 font-bold uppercase">QRIS</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'KONFIRMASI BAYAR',
            cancelButtonText: 'BATAL',
            background: '#1a1c23',
            color: '#fff',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#ef4444',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Notifikasi Berhasil
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pesanan Anda sedang diproses. Mohon tunggu beberapa saat.',
                    icon: 'success',
                    background: '#1a1c23',
                    color: '#fff',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    window.location.reload(); // Refresh halaman setelah sukses
                });
            }
        });
    }
</script>

<style>
    /* Tambahan style agar tampilan SweetAlert matching dengan tema */
    .swal2-popup {
        border-radius: 2rem !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
</style>
@endsection