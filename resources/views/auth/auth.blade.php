<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Store - Masuk atau Daftar</title>
    @vite('resources/css/app.css')
    <style>
        .form-container { transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        .hidden-form { display: none; }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center bg-black overflow-hidden">

    {{-- BACKGROUND GALAXY --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/galaxy-bg2.png') }}" class="w-full h-full object-cover" alt="Background">
    </div>
    <div class="absolute inset-0 bg-black/20 backdrop-blur-sm"></div>

    {{-- AUTH CARD --}}
    <div class="relative z-10 w-full max-w-md p-10 mx-4 bg-white/10 backdrop-blur-2xl rounded-[3rem] border border-white/10 shadow-2xl">
        
        <div class="text-center mb-6">
            <h2 id="auth-title" class="text-2xl font-bold text-white transition-all duration-500">
                Selamat Datang di<br>J-Store
            </h2>
        </div>

        {{-- TAB SWITCH (JAVASCRIPT DRIVEN) --}}
        <div class="flex bg-white/80 rounded-xl overflow-hidden mb-8 p-1 relative">
            <button id="btn-login" onclick="toggleAuth('login')" 
                    class="flex-1 py-2 text-center text-sm font-bold bg-blue-600 text-white rounded-lg z-10 transition-all duration-300">
               Login
            </button>
            <button id="btn-register" onclick="toggleAuth('register')" 
                    class="flex-1 py-2 text-center text-sm font-bold text-blue-600 rounded-lg z-10 transition-all duration-300">
               Register
            </button>
        </div>

        {{-- LOGIN FORM --}}
        <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-5 transition-all duration-500">
            @csrf
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600 text-lg">✉</span>
                </div>
                <input type="email" name="email" required class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email Address">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600 font-bold">***</span>
                </div>
                <input type="password" name="password" required class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Password">
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">Login</button>
        </form>

        {{-- REGISTER FORM (HIDDEN BY DEFAULT) --}}
        <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-4 hidden-form transition-all duration-500">
            @csrf
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600 font-bold">👤</span>
                </div>
                <input type="text" name="name" required class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Full Name">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600">✉</span>
                </div>
                <input type="email" name="email" required class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Email Address">
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-400 px-3">
                    <span class="text-gray-600 font-bold">***</span>
                </div>
                <input type="password" name="password" required class="w-full bg-white/90 rounded-xl py-4 pl-14 pr-4 text-gray-800 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Password">
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">Register</button>
        </form>

    </div>

    <script>
        function toggleAuth(type) {
            const loginForm = document.getElementById('login-form');
            const regForm = document.getElementById('register-form');
            const title = document.getElementById('auth-title');
            const btnLogin = document.getElementById('btn-login');
            const btnReg = document.getElementById('btn-register');

            if (type === 'register') {
                loginForm.classList.add('hidden-form');
                regForm.classList.remove('hidden-form');
                title.innerHTML = 'Daftar Akun Baru<br>di J-Store';
                
                // Toggle Button Style
                btnReg.classList.add('bg-blue-600', 'text-white');
                btnReg.classList.remove('text-blue-600');
                btnLogin.classList.remove('bg-blue-600', 'text-white');
                btnLogin.classList.add('text-blue-600');
            } else {
                regForm.classList.add('hidden-form');
                loginForm.classList.remove('hidden-form');
                title.innerHTML = 'Selamat Datang di<br>J-Store';

                // Toggle Button Style
                btnLogin.classList.add('bg-blue-600', 'text-white');
                btnLogin.classList.remove('text-blue-600');
                btnReg.classList.remove('bg-blue-600', 'text-white');
                btnReg.classList.add('text-blue-600');
            }
        }
    </script>
</body>
</html>