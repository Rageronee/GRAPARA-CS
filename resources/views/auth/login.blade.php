<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Grapara</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('grapara.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .bg-grid {
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>

<body
    class="antialiased bg-slate-50 text-slate-800 min-h-screen relative overflow-hidden flex items-center justify-center selection:bg-blue-100 selection:text-blue-900">

    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full bg-grid opacity-50 pointer-events-none"></div>
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] max-w-full h-[600px] bg-blue-400 rounded-full blur-[100px] opacity-20 pointer-events-none -z-10">
    </div>
    <div
        class="absolute bottom-0 right-0 w-[400px] max-w-full h-[400px] bg-cyan-400 rounded-full blur-[80px] opacity-20 pointer-events-none -z-10">
    </div>

    <!-- Login Card -->
    <div class="w-full mx-4 max-w-sm relative z-10 glass rounded-3xl p-6 md:p-8 shadow-2xl shadow-blue-900/10 border-t border-white"
        x-data="{ loading: false }">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <a href="{{ url('/') }}" class="group mb-4">
                <div
                    class="relative w-16 h-16 flex items-center justify-center bg-white rounded-2xl shadow-lg border border-slate-100 transition group-hover:scale-105 group-hover:shadow-blue-200">
                    <img src="{{ asset('grapara.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                </div>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang</h1>
            <p class="text-slate-500 text-sm mt-1">Masuk untuk mengakses dashboard</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4" @submit="loading = true">
            @csrf

            <!-- Username -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2 pl-1">Username</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: cs, manager"
                        class="w-full bg-white/50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm font-semibold"
                        required autofocus>
                </div>
                @error('username')
                    <p class="text-red-500 text-xs mt-1 pl-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2 pl-1">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" placeholder="••••••••"
                        class="w-full bg-white/50 border border-slate-200 rounded-xl pl-11 pr-12 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm font-semibold"
                        required>
                    <button type="button" @click="show = !show"
                        class="absolute right-4 top-3.5 text-slate-400 hover:text-blue-600 transition">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-900/20 transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed group flex justify-center items-center gap-2"
                :disabled="loading">
                <span x-show="!loading">MASUK SEKARANG</span>
                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-200/50 pt-6">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>

</html>