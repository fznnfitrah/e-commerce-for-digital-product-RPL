<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - J-Store</title>
    @vite('resources/css/app.css')
</head>

<body class="relative min-h-screen flex items-center justify-center bg-black text-white overflow-hidden">

    {{-- BACKGROUND GALAXY --}}
    <img src="{{ asset('images/galaxy-bg2.png') }}"
        class="absolute inset-0 w-full h-full object-cover opacity-70">

    {{-- OVERLAY GELAP --}}
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    {{-- CARD --}}
    <div class="relative z-10 w-full max-w-md mx-4">

        <div class="bg-white/5 border border-white/10 rounded-[2.5rem] p-10 backdrop-blur-xl shadow-2xl">

            {{-- HEADER --}}
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-black uppercase tracking-tight">
                    Lupa <span class="text-blue-500">Password?</span>
                </h2>
                <p class="text-gray-400 text-sm mt-2">
                    Masukkan email Anda untuk menerima link reset
                </p>
            </div>

            {{-- ALERT --}}
            @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                        Email Address
                    </label>

                    <input type="email" name="email" required
                        placeholder="you@email.com"
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-5 py-4 
                               text-white placeholder-gray-500 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               outline-none transition-all">
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full py-4 bg-blue-600 hover:bg-blue-700 
                           text-white font-bold rounded-2xl 
                           shadow-lg shadow-blue-600/30 
                           transition-all active:scale-95">
                    Kirim Link Reset
                </button>

                {{-- BACK LINK --}}
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" 
                       class="text-sm text-gray-400 hover:text-white transition">
                        ← Kembali ke Login
                    </a>
                </div>

            </form>

        </div>

    </div>

</body>
</html>