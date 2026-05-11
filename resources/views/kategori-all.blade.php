@extends('layouts.app')

@section('content')
{{-- Script Alpine.js untuk logika Interaktif --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-[#0b0e14] min-h-screen text-white pb-20" x-data="{ 
    tab: 'pulsa', 
    submitted: false, 
    phoneNumber: '',
    submitForm() {
        if(this.phoneNumber.length >= 10) {
            this.submitted = true;
        } else {
            alert('Masukkan nomor/ID yang valid (minimal 10 digit)!');
        }
    }
}">
    <div class="container mx-auto px-4 py-12 md:px-16">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-8 text-sm text-gray-400 gap-2">
            <a href="/" class="hover:text-blue-500 transition">Home</a>
            <span>/</span>
            <span class="text-white font-bold">{{ $kategori }}</span>
        </nav>

        {{-- Header & Tabs Filter --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6 border-b border-white/5 pb-8">
            <div class="flex items-center gap-4">
                <div class="w-2.5 h-10 bg-blue-600 rounded-full shadow-[0_0_20px_rgba(37,99,235,0.4)]"></div>
                <h2 class="text-3xl font-black italic uppercase tracking-wider">
                    {{ $kategori }}
                </h2>
            </div>

            {{-- Tabs Khusus Pulsa & Token --}}
            @if($kategori == 'Pulsa & Token')
            <div class="flex bg-[#16181d] p-1.5 rounded-2xl border border-white/10 shadow-inner">
                <button @click="tab = 'pulsa'; submitted = false; phoneNumber = ''" 
                    :class="tab == 'pulsa' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-6 py-2.5 rounded-xl font-black italic uppercase text-xs transition-all duration-300">
                    Pulsa
                </button>
                <button @click="tab = 'data'; submitted = false; phoneNumber = ''" 
                    :class="tab == 'data' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-6 py-2.5 rounded-xl font-black italic uppercase text-xs transition-all duration-300">
                    Paket Data
                </button>
                <button @click="tab = 'token'; submitted = false; phoneNumber = ''" 
                    :class="tab == 'token' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-6 py-2.5 rounded-xl font-black italic uppercase text-xs transition-all duration-300">
                    Token PLN
                </button>
            </div>
            @endif
        </div>

        {{-- Section Input (Hanya muncul jika kategori Pulsa & Token) --}}
        @if($kategori == 'Pulsa & Token')
        <div class="max-w-3xl mx-auto mb-16 p-8 bg-[#16181d] rounded-[2rem] border border-white/10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-600"></div>
            
            <label class="block text-sm font-black mb-4 uppercase tracking-widest text-blue-500 italic">
                <span x-text="tab == 'token' ? 'Masukkan ID Pelanggan / No. Meter' : 'Masukkan Nomor Handphone'"></span>
            </label>
            
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <input 
                        type="number" 
                        x-model="phoneNumber"
                        placeholder="0812xxxx"
                        class="w-full bg-[#0b0e14] border border-white/10 rounded-2xl px-6 py-4 text-xl font-bold tracking-widest text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    >
                </div>
                <button 
                    @click="submitForm()"
                    class="bg-blue-600 hover:bg-blue-700 px-12 py-4 rounded-2xl font-black italic uppercase transition-all shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95"
                >
                    Konfirmasi
                </button>
            </div>
            <p class="mt-4 text-[11px] text-gray-500 font-medium tracking-wide uppercase">
                *Sistem akan mendeteksi provider secara otomatis setelah konfirmasi.
            </p>
        </div>
        @endif

        {{-- Grid Produk --}}
        {{-- Logika: Langsung muncul jika BUKAN Pulsa & Token. Jika Pulsa & Token, tunggu sampai submitted == true --}}
        <div x-show="submitted || '{{ $kategori }}' != 'Pulsa & Token'" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform translate-y-10"
             x-transition:enter-end="opacity-100 transform translate-y-0">
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                @for($i = 1; $i <= 15; $i++)
                <div class="group block cursor-pointer">
                    <div class="rounded-[2rem] overflow-hidden bg-[#16181d] border border-white/5 shadow-2xl transition-all duration-500 hover:-translate-y-3 hover:border-blue-500/50">
                        
                        {{-- Bagian Visual Card --}}
                        <div class="relative aspect-square flex items-center justify-center p-8 bg-gradient-to-br from-white/5 to-transparent">
                            
                            {{-- Icon Berdasarkan Konteks --}}
                            @if($kategori == 'Pulsa & Token')
                                <template x-if="tab == 'pulsa'"><div class="text-7xl drop-shadow-2xl">📱</div></template>
                                <template x-if="tab == 'data'"><div class="text-7xl drop-shadow-2xl text-blue-400">📶</div></template>
                                <template x-if="tab == 'token'"><div class="text-7xl drop-shadow-2xl text-yellow-500">⚡</div></template>
                            @elseif($kategori == 'Aplikasi Premium')
                                <div class="text-7xl group-hover:scale-110 transition duration-500">📱</div>
                            @elseif($kategori == 'E-Book')
                                <div class="text-7xl group-hover:scale-110 transition duration-500">📚</div>
                            @else
                                {{-- Default untuk Topup Game --}}
                                <img src="{{ asset('images/game/game top-up-1.png') }}" class="w-full h-full object-contain transition duration-500 group-hover:scale-110">
                            @endif

                        </div>

                        {{-- Bagian Informasi Card --}}
                        <div class="px-6 py-6 text-center bg-[#111317] border-t border-white/5">
                            <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-400 transition">
                                @if($kategori == 'Pulsa & Token')
                                    <span x-text="tab.toUpperCase()"></span> ITEM {{ $i }}
                                @else
                                    {{ $kategori }} {{ $i }}
                                @endif
                            </p>
                            <p class="text-[11px] text-blue-500 mt-2 font-black italic uppercase tracking-widest bg-blue-500/10 py-1 rounded-lg">
                                Rp {{ number_format($i * 10000, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

    </div>
</div>

{{-- FLOATING WHATSAPP BUTTON --}}
<a href="https://wa.me/6285172280957" target="_blank" 
   class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-16 h-16 bg-green-500 rounded-full shadow-[0_0_30px_rgba(34,197,94,0.4)] hover:scale-110 active:scale-95 transition-all group">
    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
    <span class="absolute right-20 bg-white text-black text-xs font-black px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all whitespace-nowrap shadow-2xl pointer-events-none">
        BANTUAN CS VIA WHATSAPP
    </span>
</a>
@endsection