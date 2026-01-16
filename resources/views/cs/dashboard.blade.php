<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Workspace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="/grapara.ico"> <!-- Favicon CS -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex overflow-hidden" x-data="{ loading: false }">

    <!-- Global Loader (Premium w/ Logo) -->
    <div x-show="loading"
        class="fixed inset-0 z-[100] bg-white/80 backdrop-blur-md flex flex-col items-center justify-center transition-all duration-500"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
        style="display: none;">
        
        <div class="relative flex flex-col items-center">
            <!-- Logo Animation -->
            <div class="relative w-24 h-24 mb-6">
                <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-20"></div>
                <div class="absolute inset-0 bg-white rounded-full shadow-xl flex items-center justify-center border border-slate-100 z-10">
                    <img src="/grapara.png" alt="Loading..." class="w-14 h-14 object-contain animate-pulse">
                </div>
                <!-- Spinning Ring -->
                <div class="absolute -inset-2 border-4 border-blue-600/20 rounded-full"></div>
                <div class="absolute -inset-2 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
            
            <h3 class="text-xl font-bold text-slate-900 tracking-tight">Grapara</h3>
            <p class="text-blue-600 text-xs font-bold uppercase tracking-[0.2em] animate-pulse mt-1">Future Connection</p>
        </div>
    </div>

    <!-- Sidebar: Incoming Complaints -->
    <aside class="w-80 bg-white border-r border-slate-200 flex flex-col z-20 shadow-sm">
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100 bg-white">
            <h2 class="font-bold text-lg text-slate-800">Laporan Masuk</h2>
            <span
                class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $complaints->count() }}</span>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50/50">
            @forelse($complaints as $complaint)
                <form action="{{ route('queue.call_specific', $complaint->id) }}" method="POST" class="block" @submit="loading = true">
                    @csrf
                    <button type="submit" class="w-full text-left group relative overflow-hidden transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                        
                        <!-- Priority Highlighting -->
                        <div class="{{ $complaint->service_id == 3 ? 'bg-red-50 border-red-200 hover:bg-red-100 hover:border-red-300' : ($complaint->service_id == 2 ? 'bg-emerald-50 border-emerald-200 hover:bg-emerald-100' : 'bg-white border-slate-100 hover:bg-blue-50 hover:border-blue-200') }} 
                                    p-4 rounded-xl border shadow-sm relative z-10 transition-colors">
                            
                            <!-- Header: Code & Time -->
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    @php
                                        $serviceCode = match($complaint->service_id) {
                                            1 => 'A',
                                            2 => 'B',
                                            3 => 'C',
                                            default => '?'
                                        };
                                    @endphp
                                    <div class="{{ $complaint->service_id == 3 ? 'bg-red-600 text-white' : ($complaint->service_id == 2 ? 'bg-emerald-600 text-white' : 'bg-blue-600 text-white') }} 
                                                w-6 h-6 rounded-lg flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $serviceCode }}
                                    </div>
                                    <span class="font-mono font-bold text-slate-700 text-sm tracking-tight">{{ $complaint->ticket_number }}</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $complaint->created_at->diffInMinutes() > 15 ? 'text-red-500 animate-pulse' : 'text-slate-400' }}">
                                    {{ $complaint->created_at->format('H:i') }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="mb-2">
                                @if($complaint->service_id == 3)
                                    <div class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide mb-1">
                                        Priority
                                    </div>
                                @endif
                                <h4 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-blue-700 transition">"{{ $complaint->issue_detail ?? 'Layanan Reguler' }}"</h4>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 truncate">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $complaint->customer_name }}
                                </p>
                            </div>

                            <!-- Action Hint -->
                            <div class="pt-2 border-t {{ $complaint->service_id == 3 ? 'border-red-200' : 'border-slate-100' }} flex justify-between items-center group-hover:border-blue-200">
                                <span class="text-[10px] font-bold text-slate-400 uppercase group-hover:text-blue-500">Layani</span>
                                <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="text-center py-10 text-slate-400">
                    <p class="text-sm">Tidak ada laporan pending.</p>
                </div>
            @endforelse
        </div>

        <!-- User Profile & Navigation -->
        <div class="p-4 border-t border-slate-100 bg-white">
            <div class="flex items-center gap-3 justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-slate-900 truncate w-32" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500">Customer Service</p>
                    </div>
                </div>
                <div class="flex gap-1">
                    <a href="{{ url('/') }}"
                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                        title="Ke Beranda">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" @submit="loading = true">
                        @csrf
                        <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                            title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative bg-slate-50">
        <!-- Top Decor -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl mix-blend-multiply opacity-70 pointer-events-none">
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 z-10 w-full max-w-7xl mx-auto">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Workspace</h1>
                    <p class="text-slate-500">Kelola antrian dan layanan.</p>
                </div>

                <div class="flex gap-4">
                    <button onclick="window.location.reload()"
                        class="bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 px-4 py-2 rounded-xl font-bold transition flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Refresh
                    </button>

                    <!-- Control Panel (Auto Call Option) -->
                    <form action="{{ route('cs.call_auto') }}" method="POST" class="flex md:w-auto w-full" @submit="loading = true">
                        @csrf
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition flex items-center gap-2">
                            Panggil Auto
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Active Ticket Panel -->
            @if(session('queue') || session('message'))
                @if(session('message'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in-up">
                        <div class="bg-green-100 p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg></div>
                        <span class="font-semibold">{{ session('message') }}</span>
                    </div>
                @endif

                @if(session('queue') && session('queue')->status == 'calling')
                    <div
                        class="bg-white border border-slate-200 rounded-3xl p-8 flex flex-col shadow-xl shadow-slate-200/50 relative overflow-hidden">
                        <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">
                            <div>
                                <span
                                    class="text-xs font-bold bg-blue-100 text-blue-700 px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Sedang
                                    Melayani</span>
                                <h2 class="text-6xl font-bold text-slate-900 mb-2 tracking-tight">
                                    {{ session('queue')->ticket_number }}</h2>
                                <p class="text-xl text-slate-500 font-medium">{{ session('queue')->customer_name }}</p>
                            </div>
                            <div class="text-left md:text-right">
                                <p class="text-sm text-slate-400 mb-1 font-semibold uppercase tracking-wide">Layanan</p>
                                <p class="font-bold text-xl text-slate-800">{{ session('queue')->service->name }}</p>
                            </div>
                        </div>

                        <!-- Complaint Details Section -->
                        @if(session('queue')->issue_detail)
                            <div class="bg-red-50 border border-red-100 p-6 rounded-2xl mb-8">
                                <h4 class="text-red-700 font-bold mb-2 flex items-center gap-2 text-sm uppercase tracking-wide">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Keluhan Pelanggan
                                </h4>
                                <p class="text-slate-800 text-lg leading-relaxed font-medium">"{{ session('queue')->issue_detail }}"
                                </p>
                            </div>
                        @else
                            <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl mb-8 text-center text-slate-400">
                                <p>Layanan reguler (Tanpa keluhan spesifik)</p>
                            </div>
                        @endif

                        <!-- Customer History Section (Collapsible) -->
                        @isset($customerHistory)
                        <div class="mb-8 border-t border-slate-100 pt-6" x-data="{ showHistory: false }">
                            <button @click="showHistory = !showHistory" class="flex items-center gap-2 text-slate-600 font-bold uppercase text-sm tracking-wide hover:text-blue-600 transition mb-4">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Riwayat Interaksi User
                                <svg class="w-4 h-4 transition-transform duration-300" :class="showHistory ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="showHistory" 
                                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                 class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 max-h-60 overflow-y-auto">
                                @forelse($customerHistory as $history)
                                <div class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm border border-slate-100">
                                    <span class="font-mono font-bold text-slate-500 text-xs bg-slate-100 px-2 py-1 rounded">{{ $history->ticket_number }}</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-800">"{{ $history->issue_detail ?? 'Layanan Reguler' }}"</p>
                                        <p class="text-xs text-slate-500 mt-1">Solusi: <span class="italic text-slate-600">{{ $history->staff_response ?? '-' }}</span></p>
                                    </div>
                                    <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $history->created_at->diffForHumans() }}</span>
                                </div>
                                @empty
                                <p class="text-sm text-slate-400 italic text-center">Belum ada riwayat sebelumnya.</p>
                                @endforelse
                            </div>
                        </div>
                        @endisset

                        <!-- Response Form -->
                        <form action="{{ route('cs.complete', session('queue')->id) }}" method="POST" class="mt-4" @submit="loading = true">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-slate-700 text-sm font-bold mb-2 ml-1">Saran / Tindakan Solusi</label>
                                <textarea name="staff_response" rows="4"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-5 text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition resize-none placeholder-slate-400"
                                    placeholder="Ketik tindakan atau solusi yang diberikan..."></textarea>
                            </div>

                            <button
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2 text-lg transform hover:-translate-y-0.5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                Selesaikan Tiket
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div
                    class="flex-1 flex flex-col items-center justify-center text-slate-400 min-h-[50vh] bg-white rounded-3xl border border-slate-200 border-dashed">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Siap Melayani</h3>
                    <p>Pilih layanan dan klik "Panggil Antrian".</p>
                </div>
            @endif

            <div class="h-20"></div>
        </div>
    </main>

</body>

</html>