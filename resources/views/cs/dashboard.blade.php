@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 relative overflow-hidden flex items-center justify-center p-4">

        <!-- Decorative Background -->
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-purple-200/40 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-blue-200/40 rounded-full blur-[100px] animate-pulse-slow animation-delay-2000"></div>

        <div class="max-w-4xl w-full relative z-10">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Workspace Customer Service</h1>
                <div class="flex items-center justify-center gap-2 text-slate-500 text-sm font-medium bg-white/60 backdrop-blur px-4 py-2 rounded-full inline-flex border border-white/50 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Status: Online & Siap Melayani
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                <!-- LEFT COLUMN: Active Interaction Area -->
                <div class="lg:col-span-2 space-y-6">

                    @if(session('message'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in-up">
                            <div class="bg-green-100 p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <span class="font-semibold">{{ session('message') }}</span>
                        </div>
                    @endif

                    @if(session('queue') && session('queue')->status == 'calling')
                        <div class="bg-white border border-slate-200 rounded-3xl p-8 flex flex-col shadow-xl shadow-slate-200/50 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

                            <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4">
                                <div>
                                    <span class="text-xs font-bold bg-blue-100 text-blue-700 px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Sedang Melayani</span>
                                    <h2 class="text-6xl font-bold text-slate-900 mb-2 tracking-tight">{{ session('queue')->ticket_number }}</h2>
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
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Keluhan Pelanggan
                                    </h4>
                                    <p class="text-slate-800 text-lg leading-relaxed font-medium">"{{ session('queue')->issue_detail }}"</p>
                                </div>
                            @else
                                <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl mb-8 text-center text-slate-400">
                                    <p>Layanan reguler (Tanpa keluhan spesifik)</p>
                                </div>
                            @endif

                            <!-- Customer History Section (Collapsible) -->
                            @isset($customerHistory)
                                <div class="mb-8 border-t border-slate-100 pt-6" x-data="{ showHistory: false, limit: 5 }">
                                    <button @click="showHistory = !showHistory" class="flex items-center gap-2 w-full text-left bg-slate-50 hover:bg-slate-100 p-3 rounded-xl transition group">
                                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg group-hover:bg-blue-200 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm">Riwayat Interaksi User</h4>
                                            <p class="text-[10px] text-slate-500">Klik untuk melihat history tiket sebelumnya</p>
                                        </div>
                                        <svg class="w-4 h-4 text-slate-400 ml-auto transition-transform duration-300" :class="showHistory ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <div x-show="showHistory" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 -translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="mt-3 space-y-3">

                                        @forelse($customerHistory as $index => $history)
                                            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm" x-show="{{ $index }} < limit">
                                                <div class="flex justify-between items-start mb-2">
                                                    <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $history->ticket_number }}</span>
                                                    <span class="text-[10px] text-slate-400">{{ $history->created_at->format('d M H:i') }}</span>
                                                </div>
                                                <p class="text-xs text-slate-600 mb-2 font-medium">{{ $history->issue_detail }}</p>
                                                <div class="text-xs text-slate-500 bg-slate-50 p-2 rounded-lg border border-slate-100 italic">
                                                    "{{ Str::limit($history->staff_response, 100) }}"
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-4 text-slate-400 text-xs text-center border-2 border-dashed border-slate-100 rounded-xl">
                                                Belum ada riwayat interaksi sebelumnya.
                                            </div>
                                        @endforelse

                                        @if($customerHistory->count() > 5)
                                            <button @click="limit = limit === 5 ? 100 : 5" class="w-full py-2 text-xs font-bold text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <span x-text="limit === 5 ? 'Lihat Semua ({{ $customerHistory->count() }})' : 'Tampilkan Lebih Sedikit'"></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endisset

                            <!-- Response Form -->
                            <form action="{{ route('cs.complete', session('queue')->id) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-6">
                                    <label class="block text-slate-700 text-sm font-bold mb-2 ml-1">Saran / Tindakan Solusi</label>
                                    <textarea name="staff_response" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-5 text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition resize-none placeholder-slate-400" placeholder="Ketik tindakan atau solusi yang diberikan..."></textarea>
                                </div>

                                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2 text-lg transform hover:-translate-y-0.5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Selesaikan Tiket
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-slate-400 min-h-[50vh] bg-white rounded-3xl border border-slate-200 border-dashed">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <img src="{{ asset('grapara.png') }}" class="w-10 h-10 grayscale opacity-50">
                            </div>
                            <p class="font-medium text-lg">Belum ada antrian yang dipanggil.</p>
                            <p class="text-sm mt-2">Silahkan panggil antrian dari panel kanan.</p>
                        </div>
                    @endif
                </div>

                <!-- RIGHT COLUMN: Control Panel -->
                <div class="space-y-6">

                    <!-- Auto Call Button -->
                    <form action="{{ route('cs.call_auto') }}" method="POST">
                        @csrf
                        <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-500/30 transition transform hover:scale-[1.02] flex items-center justify-center gap-3">
                            <span class="p-1 bg-white/20 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </span>
                            PANGGIL ANTRIAN (AUTO)
                        </button>
                    </form>

                    <!-- Queue List -->
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-8">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">Antrian Menunggu</h3>
                            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg text-xs font-bold">{{ $complaints->count() }}</span>
                        </div>

                        <div class="divide-y divide-slate-50 max-h-[500px] overflow-y-auto">
                            @forelse($complaints as $complaint)
                                <form action="{{ route('queue.call_specific', $complaint->id) }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-5 hover:bg-slate-50 transition group">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono font-bold text-lg text-slate-700 group-hover:text-blue-600 transition">{{ $complaint->ticket_number }}</span>
                                                @if($complaint->service_id == 3)
                                                    <span class="bg-red-100 text-red-600 text-[10px] uppercase font-bold px-1.5 py-0.5 rounded">Urgent</span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">{{ $complaint->created_at->format('H:i') }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 line-clamp-2 md:line-clamp-none mb-2">
                                            {{ $complaint->issue_detail ? '"' . $complaint->issue_detail . '"' : 'Layanan Reguler' }}
                                        </p>
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $complaint->customer_name }}
                                        </div>
                                    </button>
                                </form>
                            @empty
                                <div class="p-8 text-center text-slate-400">
                                    <p class="text-sm">Tidak ada antrian menunggu.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection