<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - J-Store</title>

    @vite('resources/css/app.css')
</head>
<body class="relative min-h-screen flex items-center justify-center bg-black overflow-hidden">

    {{-- BACKGROUND GALAXY --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/galaxy-bg2.png') }}" 
             class="w-full h-full object-cover" 
             alt="Background">
    </div>

    {{-- OVERLAY (BIAR DARK & FOKUS KE CARD) --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-[px]"></div>

    {{-- LOGIN CARD --}}
    <div class="relative z-10 w-full max-w-md p-10 mx-4 
                bg-white/10 backdrop-blur-2xl 
                rounded-3xl border border-white/10 
                shadow-2xl">

        {{-- TITLE --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white">
                Selamat Datang di<br>J-Store
            </h2>
        </div>

        {{-- TAB SWITCH --}}
        <div class="flex bg-white/80 rounded-xl overflow-hidden mb-6 p-1">
            <a href="{{ route('login') }}" 
               class="flex-1 py-2 text-center text-sm font-bold bg-blue-600 text-white rounded-lg">
               Login
            </a>
            <a href="#" 
               class="flex-1 py-2 text-center text-sm font-bold text-blue-600 hover:bg-gray-200 rounded-lg transition">
               Register
            </a>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600">✉</span>
                </div>
                <input type="email" name="email" required
                    class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 
                           placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Email Address">
            </div>

            {{-- PASSWORD --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600 font-bold">***</span>
                </div>
                <input type="password" name="password" required
                    class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 
                           placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                    placeholder="Password">
            </div>

            <div>
                <a href="#" class="text-xs text-blue-400 hover:underline">
                    Forgot Password?
                </a>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 
                       text-white font-bold rounded-xl shadow-lg 
                       hover:scale-105 active:scale-95 transition">
                Login
            </button>
        </form>
    </div>

</body>
</html>