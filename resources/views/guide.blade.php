<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Simulasi - Grapara CS</title>

    <!-- Favicon -->
    <link rel="icon" href="https://cdn.jsdelivr.net/gh/Rageronee/GRAPARA-CS@main/public/grapara.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(203, 213, 225, 0.4);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-100 selection:text-blue-900 overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="h-10 w-10 flex items-center justify-center transition group-hover:scale-110">
                        <img src="https://cdn.jsdelivr.net/gh/Rageronee/GRAPARA-CS@main/public/grapara.png" alt="Logo"
                            class="h-10 w-10 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 leading-none">Grapara</h1>
                        <p class="text-[10px] font-bold text-blue-600 tracking-wider uppercase">Future Connection</p>
                    </div>
                </a>

                <!-- Back Button -->
                <a href="{{ url('/') }}"
                    class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden md:inline">Kembali</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="pt-24 md:pt-32 pb-12 px-4 text-center relative overflow-hidden">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] max-w-full h-[600px] bg-blue-100 rounded-full blur-3xl opacity-40 pointer-events-none -z-10">
        </div>

        <span
            class="inline-block py-1 px-3 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">Documentation</span>
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 mb-4 md:mb-6 leading-tight">Panduan Simulasi Sistem
        </h1>
        <p class="text-sm md:text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed px-2 md:px-4">
            Skenario interaksi end-to-end antara <span class="text-blue-600 font-bold">Pelanggan</span>, <span
                class="text-emerald-600 font-bold">Customer Service</span>, dan <span
                class="text-slate-700 font-bold">Administrator</span>.
        </p>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 pb-24 space-y-8 md:space-y-12">

        <!-- STEP 1: CUSTOMER -->
        <section
            class="group relative bg-white rounded-3xl p-5 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-2xl transition duration-500">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <svg class="w-32 h-32 md:w-48 md:h-48" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>

            <div class="flex flex-col md:flex-row gap-6 md:gap-8 relative z-10">
                <div class="shrink-0 self-start">
                    <div
                        class="w-12 h-12 md:w-16 md:h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold shadow-lg shadow-blue-500/30">
                        1</div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-2">Aktor: Pelanggan (Customer)</h2>
                    <p class="text-sm md:text-base text-slate-500 mb-6">Simulasi pengambilan tiket antrian secara
                        mandiri.</p>

                    <ul class="space-y-4 text-sm md:text-base">
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">1</span>
                            <span class="text-slate-700">Buka Halaman Utama, klik tombol <strong>"Ambil
                                    Antrian"</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">2</span>
                            <span class="text-slate-700">Lakukan <strong>Registrasi / Login</strong> (Bisa pakai akun
                                sembarang untuk tes).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">3</span>
                            <span class="text-slate-700">Pilih Layanan (CS, Teller, atau Priority Tech) dan isi detail
                                keluhan.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">4</span>
                            <span class="text-slate-700">Tiket akan muncul. Status awal adalah <span
                                    class="bg-slate-100 px-2 py-0.5 rounded text-xs font-bold text-slate-600 uppercase">Waiting</span>.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- STEP 2: CS -->
        <section
            class="group relative bg-white rounded-3xl p-5 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-2xl transition duration-500">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <svg class="w-32 h-32 md:w-48 md:h-48" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>

            <div class="flex flex-col md:flex-row gap-6 md:gap-8 relative z-10">
                <div class="shrink-0 self-start">
                    <div
                        class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold shadow-lg shadow-emerald-500/30">
                        2</div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-2">Aktor: Customer Service (CS)</h2>
                    <p class="text-sm md:text-base text-slate-500 mb-6">Simulasi pemanggilan dan pelayanan tiket oleh
                        petugas.</p>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-6 inline-block w-full md:w-auto">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Akun Login Petugas</p>
                        <div class="flex flex-col md:flex-row gap-2 md:gap-4 text-sm">
                            <div
                                class="flex items-center justify-between md:justify-start gap-2 border-b md:border-b-0 border-slate-200 pb-2 md:pb-0">
                                <span class="text-slate-500">User:</span>
                                <code
                                    class="bg-white px-2 py-1 rounded border border-slate-200 font-bold text-slate-800">cs</code>
                            </div>
                            <div class="flex items-center justify-between md:justify-start gap-2">
                                <span class="text-slate-500">Pass:</span>
                                <code
                                    class="bg-white px-2 py-1 rounded border border-slate-200 font-bold text-slate-800">password</code>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm md:text-base">
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">1</span>
                            <span class="text-slate-700">Login dengan akun CS di atas (Gunakan Browser Lain / Incognito
                                agar sesi tidak tertimpa).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">2</span>
                            <span class="text-slate-700">Klik tombol <strong>"PANGGIL AUTO"</strong>. Sistem akan
                                memilih tiket terlama secara otomatis.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">3</span>
                            <span class="text-slate-700">Input solusi penanganan masalah pada kolom "Respon
                                Petugas".</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold shrink-0">4</span>
                            <span class="text-slate-700">Klik <strong>"Selesaikan Tiket"</strong>. Status berubah
                                menjadi <span
                                    class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold uppercase">Completed</span>.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- STEP 3: ADMIN -->
        <section
            class="group relative bg-white rounded-3xl p-5 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-2xl transition duration-500">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <svg class="w-32 h-32 md:w-48 md:h-48" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                    </path>
                </svg>
            </div>

            <div class="flex flex-col md:flex-row gap-6 md:gap-8 relative z-10">
                <div class="shrink-0 self-start">
                    <div
                        class="w-12 h-12 md:w-16 md:h-16 bg-slate-800 text-white rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold shadow-lg shadow-slate-500/30">
                        3</div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-2">Aktor: Manager (Admin)</h2>
                    <p class="text-sm md:text-base text-slate-500 mb-6">Monitoring kinerja staff dan statistik antrian.
                    </p>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-6 inline-block w-full md:w-auto">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Akun Login Manager</p>
                        <div class="flex flex-col md:flex-row gap-2 md:gap-4 text-sm">
                            <div
                                class="flex items-center justify-between md:justify-start gap-2 border-b md:border-b-0 border-slate-200 pb-2 md:pb-0">
                                <span class="text-slate-500">User:</span>
                                <code
                                    class="bg-white px-2 py-1 rounded border border-slate-200 font-bold text-slate-800">manager</code>
                            </div>
                            <div class="flex items-center justify-between md:justify-start gap-2">
                                <span class="text-slate-500">Pass:</span>
                                <code
                                    class="bg-white px-2 py-1 rounded border border-slate-200 font-bold text-slate-800">password</code>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm md:text-base">
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                            <span class="text-slate-700">Login dengan akun Manager.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
                            <span class="text-slate-700">Lihat Dashboard Utama untuk statistik real-time.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-1 w-5 h-5 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
                            <span class="text-slate-700">Pantau tabel <strong>"Penilaian Kinerja Staff"</strong> untuk
                                melihat total tiket yang diselesaikan petugas.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- ACTION BUTTONS (New Requested Features) -->
        <section class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8 px-4">
            <a href="{{ url('/') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-bold shadow-2xl hover:bg-slate-800 transition transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Kembali ke Beranda
            </a>

            <a href="http://github.com/rageronee/GRAPARA-CS/" target="_blank"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-slate-700 border-2 border-slate-200 px-8 py-4 rounded-full font-bold hover:bg-slate-50 hover:border-slate-300 transition transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0122 12.017C22 6.484 17.522 2 12 2z"
                        clip-rule="evenodd"></path>
                </svg>
                Source Code
            </a>
        </section>

        <!-- Tech Stack Badge -->
        <div class="text-center pt-12 border-t border-slate-200 mt-12">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Powered By</p>
            <div class="inline-flex gap-2 flex-wrap justify-center">
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Laravel
                    11</span>
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Tailwind
                    CSS 4</span>
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Supabase
                    (PostgreSQL)</span>
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Alpine.js</span>
            </div>
        </div>

    </main>

    <footer class="bg-slate-900 text-slate-400 py-8 text-center text-sm">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} Grapara Modern Simulation. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>