<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Simulasi Sistem Grapara</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('grapara.ico') }}">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="max-w-4xl mx-auto px-6 py-12">

        <header class="text-center mb-16">
            <img src="/grapara.png" alt="Logo" class="w-20 h-20 mx-auto mb-6 object-contain animate-bounce">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">Panduan Simulasi Sistem</h1>
            <p class="text-lg text-slate-500">Skenario Interaksi Customer, CS, dan Admin</p>
        </header>

        <div class="grid gap-12 relative">
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-linear-to-b from-blue-200 to-slate-200 hidden md:block">
            </div>

            <!-- STEP 1: CUSTOMER -->
            <div class="relative pl-0 md:pl-24 group">
                <div
                    class="hidden md:flex absolute left-0 w-16 h-16 bg-blue-600 rounded-2xl items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-500/30 group-hover:scale-110 transition">
                    1</div>
                <div
                    class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group-hover:shadow-xl transition relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Aktor:
                        Customer</span>
                    <h2 class="text-2xl font-bold mb-4">Ambil Antrian</h2>
                    <ol class="list-decimal list-inside space-y-2 text-slate-600 marker:font-bold marker:text-blue-500">
                        <li>Buka Halaman Utama (Home).</li>
                        <li>Klik <strong>"Daftar"</strong> untuk membuat akun baru (Simulasi User Baru).</li>
                        <li>Setelah login, pilih <strong>Layanan (Customer Service / Teller)</strong>.</li>
                        <li>Isi detail keluhan (opsional tapi disarankan untuk tes fitur History).</li>
                        <li>Klik <strong>"Ambil Antrian"</strong>. Tiket akan muncul.</li>
                    </ol>
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('register') }}" target="_blank"
                            class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-bold text-sm hover:bg-blue-100">Buka
                            Register</a>
                    </div>
                </div>
            </div>

            <!-- STEP 2: CS -->
            <div class="relative pl-0 md:pl-24 group">
                <div
                    class="hidden md:flex absolute left-0 w-16 h-16 bg-emerald-600 rounded-2xl items-center justify-center text-white font-bold text-2xl shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition">
                    2</div>
                <div
                    class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group-hover:shadow-xl transition relative overflow-hidden">
                    <span class="text-emerald-600 font-bold tracking-widest uppercase text-xs mb-2 block">Aktor:
                        Customer Service</span>
                    <h2 class="text-2xl font-bold mb-4">Melayani Pelanggan</h2>
                    <ol
                        class="list-decimal list-inside space-y-2 text-slate-600 marker:font-bold marker:text-emerald-500">
                        <li>Login sebagai Staff (Username: <strong>cs1</strong>, Password: <strong>password</strong>).
                        </li>
                        <li>Masuk ke <strong>CS Workspace</strong>.</li>
                        <li>Klik tombol <strong>"PANGGIL AUTO"</strong> di pojok kanan atas.</li>
                        <li>Sistem akan otomatis memanggil tiket prioritas / terlama.</li>
                        <li>Cek <strong>"Riwayat Interaksi"</strong> (Expandable) untuk lihat history user.</li>
                        <li>Isi solusi dan klik <strong>"Selesaikan Tiket"</strong>.</li>
                    </ol>
                    <div class="mt-6">
                        <p class="text-xs text-slate-400 bg-slate-50 p-2 rounded border border-slate-100 inline-block">
                            Tips: Coba login CS di Browser berbeda / Incognito Mode.</p>
                    </div>
                </div>
            </div>

            <!-- STEP 3: ADMIN -->
            <div class="relative pl-0 md:pl-24 group">
                <div
                    class="hidden md:flex absolute left-0 w-16 h-16 bg-slate-800 rounded-2xl items-center justify-center text-white font-bold text-2xl shadow-lg shadow-slate-500/30 group-hover:scale-110 transition">
                    3</div>
                <div
                    class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group-hover:shadow-xl transition relative overflow-hidden">
                    <span class="text-slate-600 font-bold tracking-widest uppercase text-xs mb-2 block">Aktor:
                        Administrator</span>
                    <h2 class="text-2xl font-bold mb-4">Monitoring Kinerja</h2>
                    <ol
                        class="list-decimal list-inside space-y-2 text-slate-600 marker:font-bold marker:text-slate-500">
                        <li>Login sebagai Admin (Username: <strong>admin</strong>, Password: <strong>password</strong>).
                        </li>
                        <li>Lihat <strong>Dashboard Analytics</strong>.</li>
                        <li>Perhatikan tabel <strong>"Penilaian Kinerja Staff"</strong>.</li>
                        <li>Data "Total Tiket" dan "Rata-rata Durasi" akan update realtime sesuai aktivitas CS.</li>
                    </ol>
                </div>
            </div>

        </div>

        <div class="mt-16 text-center border-t border-slate-200 pt-8">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Lingkungan Sistem (System
                Environment)</h3>
            <div class="inline-flex gap-4 flex-wrap justify-center">
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-mono border border-slate-200">
                    📂 Database: <strong>SQLite (Local)</strong> / TiDB (Cloud)
                </span>
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-mono border border-slate-200">
                    ⚡ Framework: <strong>Laravel 11.x</strong>
                </span>
                <span
                    class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-mono border border-slate-200">
                    🎨 Frontend: <strong>Tailwind CSS 4</strong>
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-4 italic">
                *Simulasi ini berjalan menggunakan database lokal SQLite untuk performa maksimal tanpa latensi internet.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-bold shadow-2xl hover:bg-slate-800 transition transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Mulai Simulasi Sekarang
                </a>

                <a href="https://github.com/Rageronee/GRAPARA-CS" target="_blank"
                    class="inline-flex items-center gap-2 bg-white text-slate-700 border-2 border-slate-200 px-8 py-4 rounded-full font-bold hover:bg-slate-50 hover:border-slate-300 transition transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0122 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Source Code
                </a>
            </div>
        </div>

    </div>

</body>

</html>