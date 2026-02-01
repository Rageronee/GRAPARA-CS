<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grapara CS</title>
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(203, 213, 225, 0.4);
        }

        .bg-grid {
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="antialiased bg-slate-50 text-slate-800 min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900"
    x-cloak x-data="{ 
          queueOpen: false, 
          // Stop popup if logged in
          authOpen: {{ !Auth::check() && (request()->has('action') || $errors->any()) ? 'true' : 'false' }}, 
          authType: '{{ $errors->has('name') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('username') && !$errors->has('login_error') ? 'register' : 'login' }}',
          historyOpen: false,
          historyData: [],
          loading: false,
          hasNewHistory: false,
          async fetchHistory() {
              const res = await fetch('{{ route('queue.history') }}');
              this.historyData = await res.json();
              if(this.historyData.length > 0) {
                 this.hasNewHistory = this.historyData.some(i => i.status === 'completed'); 
              }
          },
          init() {
              if({{ Auth::check() && Auth::user()->role === 'customer' ? 'true' : 'false' }}) {
                  this.fetchHistory();
                  setInterval(() => this.fetchHistory(), 5000);
              }
          }
      }">

    <!-- Global Loader (Premium w/ Logo) -->
    <div x-show="loading"
        class="fixed inset-0 z-100 bg-white/80 backdrop-blur-md flex flex-col items-center justify-center transition-all duration-500"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
        style="display: none;">
        
        <div class="relative flex flex-col items-center">
            <!-- Logo Animation -->
            <div class="relative w-24 h-24 mb-6">
                <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-20"></div>
                <div class="absolute inset-0 bg-white rounded-full shadow-xl flex items-center justify-center border border-slate-100 z-10">
                <img src="{{ asset('grapara.png') }}" alt="Loading..." class="w-14 h-14 object-contain animate-pulse">
                </div>
                <!-- Spinning Ring -->
                <div class="absolute -inset-2 border-4 border-blue-600/20 rounded-full"></div>
                <div class="absolute -inset-2 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
            
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Grapara</h3>
            <p class="text-blue-600 text-xs font-bold uppercase tracking-[0.2em] animate-pulse mt-1">Future Connection</p>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="fixed w-full z-40 glass shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3 cursor-pointer" @click="window.location.reload()">
                    <div class="h-10 w-10 flex items-center justify-center">
                        <img src="{{ asset('grapara.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 leading-none">Grapara</h1>
                        <p class="text-[10px] font-bold text-blue-600 tracking-wider uppercase">Future Connection</p>
                    </div>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#products"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Produk</a>
                    <a href="#services"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Layanan</a>
                    <a href="#faq" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Bantuan</a>

                    @auth
                        <div class="flex items-center gap-4 pl-4 border-l border-slate-200">
                            <!-- History Button: Only for Customers -->
                            @if(Auth::user()->role === 'customer')
                                <button @click="historyOpen = true; hasNewHistory = false"
                                    class="relative flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Riwayat
                                    <span x-show="hasNewHistory"
                                        class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                                </button>
                            @endif

                            <div class="text-right hidden lg:block">
                                <p class="text-xs text-slate-500">Selamat Datang,</p>
                                <p class="text-sm font-bold text-slate-900 capitalize">{{ Auth::user()->name }}</p>
                            </div>

                            @if(Auth::user()->role !== 'customer')
                                <div class="flex items-center gap-2">
                                    <a href="{{ url('/dashboard') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-xs font-bold shadow-lg shadow-blue-500/30 transition">DASHBOARD</a>
                                    <!-- Admin Logout Button -->
                                    <form action="{{ route('logout') }}" method="POST" @submit="loading = true">
                                        @csrf
                                        <button class="bg-red-50 text-red-600 hover:bg-red-100 p-2 rounded-full transition" title="Logout">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('logout') }}" method="POST" @submit="loading = true">
                                    @csrf
                                    <button
                                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg text-xs font-bold transition">Logout</button>
                                </form>
                            @endif
                        </div>
                    @else
                        <button @click="authOpen = true; authType = 'login'"
                            class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-slate-900/20 transition flex items-center gap-2">
                            <span>Mulai Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header
        class="pt-32 pb-20 px-4 max-w-7xl mx-auto min-h-[85vh] flex flex-col items-center text-center justify-center">
        <div class="max-w-3xl space-y-8 relative z-10">
            <div
                class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full text-blue-600 text-xs font-bold uppercase tracking-wider mx-auto">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                MEMBANGUN DEMI NEGERI
            </div>

            <h1 class="text-6xl md:text-7xl font-bold text-slate-900 leading-tight">
                Layanan Digital <br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Terintegrasi.</span>
            </h1>

            <p class="text-lg text-slate-500 leading-relaxed max-w-xl mx-auto">
                Nikmati kemudahan akses layanan perbankan dan telekomunikasi dalam satu atap. Cepat, efisien, dan ramah.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <!-- Buttons: Conditional Logic for Admin/Customer -->
                @if(Auth::check() && Auth::user()->role !== 'customer')
                    <a href="{{ url('/dashboard') }}"
                        class="px-8 py-4 bg-slate-900 text-white rounded-xl font-bold transition hover:scale-105 flex justify-center items-center gap-2">
                        Masuk Dashboard
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @else
                    <button
                        @click="{{ Auth::check() ? "queueOpen = true; queueType = 'general'" : "authOpen = true; authType = 'login'" }}"
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-xl shadow-blue-600/20 transition hover:scale-105 flex justify-center items-center gap-2">
                        Ambil Antrian
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                    <button
                        @click="{{ Auth::check() ? "queueOpen = true; queueType = 'complaint'" : "authOpen = true; authType = 'login'" }}"
                        class="px-8 py-4 bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-700 rounded-xl font-bold transition flex justify-center items-center gap-2 hover:border-red-500 hover:text-red-500">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        Lapor Gangguan
                    </button>
                @endif
            </div>

            @if(session('message'))
                <div
                    class="inline-flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold animate-fade-in-up shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <!-- Decoration -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-100 rounded-full blur-3xl opacity-30 pointer-events-none -z-10">
        </div>
    </header>

    <!-- Products Section -->
    <section id="products" class="py-20 bg-slate-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-grid opacity-50 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Produk Unggulan</span>
                <h2 class="text-4xl font-bold text-slate-900 mt-2">Koneksi Tanpa Batas</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Telkomsel Halo -->
                <div
                    class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-slate-100">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 rounded-full blur-3xl -mr-16 -mt-16 transition group-hover:bg-red-500/20">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Telkom Halu</h3>
                        <p class="text-slate-500 mb-6 line-clamp-2">Layanan pascabayar prioritas dengan jaringan
                            tercepat dan kuota melimpah tanpa batas.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-slate-600 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Prioritas Jaringan 5G
                            </li>
                            <li class="flex items-center gap-2 text-slate-600 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kuota Roaming Internasional
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Indihome Fiber -->
                <div
                    class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-slate-100">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16 transition group-hover:bg-blue-500/20">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Indihomie Siber</h3>
                        <p class="text-slate-500 mb-6 line-clamp-2">Internet rumah ultra-cepat dengan stabilitas tinggi
                            untuk hiburan keluarga tanpa henti.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-2 text-slate-600 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kecepatan up to 300 Mbps
                            </li>
                            <li class="flex items-center gap-2 text-slate-600 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Unlimited Tanpa FUP*
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Pusat Bantuan</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Pertanyaan Umum (FAQ)</h2>
            </div>
            <div class="space-y-4" x-data="{ active: null }">
                <!-- item 1 -->
                <div class="bg-slate-50 rounded-2xl p-6 shadow-sm cursor-pointer hover:bg-white border border-transparent hover:border-blue-100 transition"
                    @click="active === 1 ? active = null : active = 1">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800">Bagaimana cara mengambil antrian online?</h4>
                        <svg class="w-5 h-5 text-slate-400 transition-transform"
                            :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="active === 1" x-collapse class="mt-4 text-slate-600 text-sm leading-relaxed"
                        style="display: none;">
                        Cukup login/daftar akun, lalu klik tombol "Ambil Antrian" di halaman utama. Pilih layanan yang
                        Anda butuhkan (CS, Teller, atau Pengaduan), dan Anda akan mendapatkan nomor antrian digital.
                    </div>
                </div>
                <!-- item 2 -->
                <div class="bg-slate-50 rounded-2xl p-6 shadow-sm cursor-pointer hover:bg-white border border-transparent hover:border-blue-100 transition"
                    @click="active === 2 ? active = null : active = 2">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800">Apakah saya perlu datang sebelum dipanggil?</h4>
                        <svg class="w-5 h-5 text-slate-400 transition-transform"
                            :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="active === 2" x-collapse class="mt-4 text-slate-600 text-sm leading-relaxed"
                        style="display: none;">
                        Kami sarankan datang 15 menit sebelum estimasi waktu panggilan. Anda bisa memantau status
                        antrian secara live melalui dashboard untuk estimasi yang lebih akurat.
                    </div>
                </div>
                <!-- item 3 -->
                <div class="bg-slate-50 rounded-2xl p-6 shadow-sm cursor-pointer hover:bg-white border border-transparent hover:border-blue-100 transition"
                    @click="active === 3 ? active = null : active = 3">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800">Apa syarat ganti kartu hilang?</h4>
                        <svg class="w-5 h-5 text-slate-400 transition-transform"
                            :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div x-show="active === 3" x-collapse class="mt-4 text-slate-600 text-sm leading-relaxed"
                        style="display: none;">
                        Membawa e-KTP asli pemilik nomor. Jika diwakilkan, wajib menyertakan surat kuasa bermaterai dan
                        e-KTP asli pemberi & penerima kuasa.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Details (New Section) -->
    <section id="services" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Layanan Unggulan</span>
                <h2 class="text-4xl font-bold text-slate-900 mt-2">Solusi Kebutuhan Anda</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Customer Service</h3>
                    <p class="text-slate-500 leading-relaxed mb-6">
                        Layanan pembukaan rekening, ganti kartu, migrasi paket data, dan informasi umum produk Grapara.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Ganti Kartu Hilang</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Upgrade 4G/5G</li>
                    </ul>
                </div>

                <!-- Card 2 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <div
                        class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Teller & Pembayaran</h3>
                    <p class="text-slate-500 leading-relaxed mb-6">
                        Loket khusus untuk pembayaran tagihan Indihome, Kartu Halo, dan pembelian pulsa atau paket data.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Bayar Tagihan</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Buka Blokir / Ganti PIN</li>
                    </ul>
                </div>

                <!-- Card 3 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Support Teknis</h3>
                    <p class="text-slate-500 leading-relaxed mb-6">
                        Kendala teknis jaringan internet, modem rusak, atau gangguan sinyal? Tim teknisi kami siap
                        membantu.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Komplain Jaringan</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Ganti Perangkat</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 text-center text-sm">
        <div class="max-w-7xl mx-auto px-4">
            <p>Implementasi Basis Data. Enhanced and Perfected By <a href="https://mafnanrisandi-portfolio.vercel.app"
                    target="_blank" class="text-blue-500 font-bold hover:text-blue-400 transition">Muhammad Afnan
                    Risandi</a>.</p>
        </div>
    </footer>

    <!-- UI Components (Modals) -->

    <!-- Auth Modal -->
    <div x-show="authOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
        style="display: none;">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden relative"
            @click.away="authOpen = false">
            <button @click="authOpen = false"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 z-50 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="p-8">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-slate-900">Selamat Datang</h3>
                    <p class="text-slate-500 text-sm mt-1">Silakan masuk untuk melanjutkan</p>
                </div>

                <div class="flex bg-slate-100 rounded-xl p-1 mb-6">
                    <button @click="authType = 'login'"
                        :class="authType === 'login' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 py-2 text-sm font-bold rounded-lg transition">Login</button>
                    <button @click="authType = 'register'"
                        :class="authType === 'register' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 py-2 text-sm font-bold rounded-lg transition">Daftar</button>
                </div>

                <!-- Login Form -->
                <form x-show="authType === 'login'" action="{{ route('login.post') }}" method="POST" class="space-y-4" @submit="loading = true">
                    @csrf
                    <div>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Password"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600">
                             <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                             <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-600/20 transition">MASUK
                        SEKARANG</button>
                </form>

                <!-- Register Form -->
                <form x-show="authType === 'register'" action="{{ route('register') }}" method="POST" class="space-y-4" @submit="loading = true"
                    style="display: none;">
                    @csrf
                    <div>
                        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Password"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                        <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600">
                             <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                             <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                        <p class="text-[10px] text-slate-500 mt-1 ml-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Minimal 8 karakter
                        </p>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <button
                        class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-slate-900/20 transition">BUAT
                        AKUN</button>
                </form>
            </div>
        </div>
    </div>

    <!-- History Modal (Only accessible via Trigger, ensuring Role check) -->
    <div x-show="historyOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
        style="display: none;">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl h-[80vh] flex flex-col relative"
            @click.away="historyOpen = false">
            <div class="flex justify-between items-center p-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-800">Riwayat Laporan</h3>
                <button @click="historyOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50">
                <template x-for="item in historyData" :key="item.id">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 transition hover:shadow-md">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span
                                    class="bg-slate-100 text-slate-600 px-2 py-1 rounded-md text-xs font-bold font-mono"
                                    x-text="item.ticket_number"></span>
                                <span class="text-xs text-slate-400 ml-2"
                                    x-text="new Date(item.created_at).toLocaleString()"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    :class="{'text-green-600 bg-green-50': item.status === 'completed', 'text-yellow-600 bg-yellow-50': item.status !== 'completed'}"
                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase"
                                    x-text="item.status === 'completed' ? 'Selesai' : 'Proses'"></span>

                                <!-- Rating Button if Completed but Not Rated -->
                                <template x-if="item.status === 'completed' && !item.rating">
                                    <a :href="'/queue/' + item.id" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-[10px] font-bold uppercase transition flex items-center gap-1 shadow-md hover:scale-105">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        Beri Nilai
                                    </a>
                                </template>
                            </div>
                                
                                <template x-if="item.status === 'waiting'">
                                    <form :action="`/queue/${item.id}/cancel`" method="POST" @submit="loading = true" class="ml-2">
                                        @csrf
                                        <button class="bg-red-50 text-red-600 hover:bg-red-100 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide border border-red-100 transition">
                                            Batalkan
                                        </button>
                                    </form>
                                </template>
                        </div>
                        <p class="text-sm text-slate-800 font-medium mb-4"
                            x-text="item.issue_detail || 'Layanan Reguler'"></p>

                        <template x-if="item.staff_response">
                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl">
                                    <p class="text-blue-700 text-xs font-bold uppercase mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        Tanggapan Petugas
                                    </p>
                                    <p class="text-slate-700 text-sm leading-relaxed" x-text="item.staff_response"></p>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        @click="historyOpen = false; queueOpen = true; selectedService = 3; detail = 'Tindak lanjut (Ref: ' + item.ticket_number + ') - ' + (item.issue_detail || 'Detail baru...')"
                                        class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1 group">
                                        Masalah Belum Selesai? Lapor Lagi
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                <div x-show="historyData.length === 0" class="text-center py-12 text-slate-400">
                    <p>Belum ada riwayat laporan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Queue Modal -->
    <div x-show="queueOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
        style="display: none;">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl p-8 relative" @click.away="queueOpen = false">
            <button @click="queueOpen = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Pilih Jenis Layanan</h2>
            <p class="text-slate-500 mb-8">Silakan pilih layanan yang sesuai dengan kebutuhan Anda.</p>

            <form action="{{ route('queue.store') }}" method="POST" x-data="{ selectedService: null, detail: '' }">
                @csrf
                <input type="hidden" name="service_id" :value="selectedService">
                <input type="hidden" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div @click="selectedService = 1"
                        :class="selectedService === 1 ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-400'"
                        class="cursor-pointer border-2 rounded-2xl p-4 text-center transition">
                        <div
                            class="h-10 w-10 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-3 text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Customer Service</h4>
                    </div>
                    <div @click="selectedService = 3"
                        :class="selectedService === 3 ? 'border-red-600 bg-red-50' : 'border-slate-200 hover:border-red-400'"
                        class="cursor-pointer border-2 rounded-2xl p-4 text-center transition">
                        <div
                            class="h-10 w-10 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-3 text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Lapor Gangguan</h4>
                    </div>
                    <div @click="selectedService = 2"
                        :class="selectedService === 2 ? 'border-green-600 bg-green-50' : 'border-slate-200 hover:border-green-400'"
                        class="cursor-pointer border-2 rounded-2xl p-4 text-center transition">
                        <div
                            class="h-10 w-10 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3 text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Teller</h4>
                    </div>
                </div>

                <!-- CS Options (Dynamic) -->
                <div x-show="selectedService === 1" class="mb-6 grid grid-cols-2 gap-2 animate-fade-in-up">
                    <button type="button" @click="detail = 'Ganti Kartu Hilang/Rusak'"
                        :class="detail.includes('Ganti') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Ganti Kartu</button>
                    <button type="button" @click="detail = 'Upgrade Kartu 4G/5G'"
                        :class="detail.includes('Upgrade') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Upgrade 4G/5G</button>
                    <button type="button" @click="detail = 'Registrasi Ulang Prabayar'"
                        :class="detail.includes('Registrasi') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Registrasi Ulang</button>
                    <button type="button" @click="detail = 'Informasi Produk & Layanan'"
                        :class="detail.includes('Informasi') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Info Produk</button>
                </div>

                <!-- Teller Options (Dynamic) -->
                <div x-show="selectedService === 2" class="mb-6 grid grid-cols-3 gap-2 animate-fade-in-up">
                    <button type="button" @click="detail = 'Pembayaran Tagihan (Indihome/Halo)'"
                        :class="detail.includes('Pembayaran') ? 'bg-green-600 text-white border-green-600' : 'bg-white text-slate-600 border-slate-200 hover:border-green-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Bayar Tagihan</button>
                    <button type="button" @click="detail = 'Isi Ulang Wallet/Pulsa'"
                        :class="detail.includes('Isi Ulang') ? 'bg-green-600 text-white border-green-600' : 'bg-white text-slate-600 border-slate-200 hover:border-green-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Isi Ulang</button>
                    <button type="button" @click="detail = 'Buka Blokir / Ganti PIN'"
                        :class="detail.includes('Setor') ? 'bg-green-600 text-white border-green-600' : 'bg-white text-slate-600 border-slate-200 hover:border-green-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Buka Blokir / Ganti
                        PIN</button>
                </div>
                <!-- Priority Options (Dynamic) -->
                <div x-show="selectedService === 3" class="mb-6 grid grid-cols-2 gap-2 animate-fade-in-up">
                    <button type="button" @click="detail = 'Gangguan Internet/WiFi Mati'"
                        :class="detail.includes('Internet') ? 'bg-red-600 text-white border-red-600' : 'bg-white text-slate-600 border-slate-200 hover:border-red-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Internet Mati</button>
                    <button type="button" @click="detail = 'Perangkat/Modem Rusak'"
                        :class="detail.includes('Perangkat') ? 'bg-red-600 text-white border-red-600' : 'bg-white text-slate-600 border-slate-200 hover:border-red-400'"
                        class="border px-2 py-2 rounded-lg text-xs font-bold transition">Modem Rusak</button>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Detail Keperluan <span
                            class="text-red-500">*</span></label>
                    <textarea name="issue_detail" x-model="detail" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 transition"
                        placeholder="Jelaskan keperluan atau gangguan Anda..." required></textarea>
                </div>

                <button type="submit"
                    :class="selectedService && detail.length > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                    :disabled="!selectedService || detail.length === 0"
                    class="w-full font-bold py-4 rounded-xl transition shadow-xl">AMBIL TIKET ANTRIAN</button>
            </form>
        </div>
    </div>



    <!-- Guide Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('guide') }}" class="bg-white/90 backdrop-blur text-blue-600 px-4 py-2 rounded-full font-bold shadow-lg hover:scale-105 transition flex items-center gap-2 text-sm border border-blue-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Panduan Simulasi
        </a>
    </div>

</body>
</html>