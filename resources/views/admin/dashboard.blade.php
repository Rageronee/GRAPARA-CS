<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Grapara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('grapari.ico') }}"> <!-- Favicon -->
    <meta http-equiv="refresh" content="30"> <!-- Auto Refresh every 30s -->
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center p-1">
                        <img src="{{ asset('grapari.png') }}" alt="Logo" class="h-full w-full object-contain">
                    </div>
                    <span class="font-bold text-xl text-slate-900 tracking-tight">Admin<span class="text-blue-600">Panel</span></span>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-slate-500">Logged in as</p>
                        <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="h-8 w-px bg-slate-200"></div>
                     <a href="{{ url('/') }}" class="text-slate-500 hover:text-blue-600 transition" title="Home">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-slate-500 hover:text-red-600 transition" title="Logout">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8 space-y-8">

        <!-- ACTIVE TICKET WORKSPACE (Visible when serving) -->
        @if(session('queue'))
            <div class="bg-gradient-to-br from-blue-900 to-slate-900 rounded-3xl p-8 shadow-2xl relative overflow-hidden animate-fade-in-down border border-blue-800">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                    <!-- Ticket Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">SEDANG DILAYANI</span>
                            <span class="text-blue-300 font-mono text-sm tracking-widest uppercase">ID: {{ session('queue')->ticket_number }}</span>
                        </div>
                        
                        <h1 class="text-5xl font-bold text-white mb-2">{{ session('queue')->ticket_number }}</h1>
                        <p class="text-blue-200 text-lg mb-8 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ session('queue')->customer_name }}
                        </p>

                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                            <h3 class="text-blue-300 text-sm font-bold uppercase mb-2">Keluhan / Keperluan:</h3>
                            <p class="text-white text-lg font-medium leading-relaxed">"{{ session('queue')->issue_detail }}"</p>
                        </div>
                    </div>

                    <!-- Action Form -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-slate-800 font-bold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Input Tindakan
                        </h3>
                        <form action="{{ route('cs.complete', session('queue')->id) }}" method="POST">
                            @csrf
                            <textarea name="staff_response" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 mb-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm text-slate-700" placeholder="Tulis solusi atau tindakan yang diambil..." required></textarea>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-600/20 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                SELESAIKAN TIKET
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Kunjungan</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_today'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
             <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Keluhan Pending</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['pending_complaints'] }}</p>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
             <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Staff Aktif</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['staff_active'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
             <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Selesai Hari Ini</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['completed_today'] }}</p>
                </div>
                <div class="p-3 bg-slate-100 text-slate-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Live Status & Reports -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Live Queue Monitor -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            Live Queue Monitor
                        </h2>
                        <span class="text-xs bg-white border border-slate-200 px-3 py-1 rounded-full text-slate-500 font-mono hidden md:inline-block">Updated: {{ now()->format('H:i') }}</span>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($liveStatus as $service)
                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-blue-300 transition">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="p-2 bg-white rounded-lg shadow-sm text-blue-600">
                                            @if($service->id == 1)<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            @elseif($service->id == 2)<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @else<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>@endif
                                        </div>
                                        @php 
                                            $serving = $service->queues->where('status', 'calling')->first();
                                            $waitingCount = $service->queues->where('status', 'waiting')->count();
                                            $badgeInfo = match($service->id) {
                                                1 => ['label' => 'General CS', 'class' => 'bg-blue-100 text-blue-700'],
                                                2 => ['label' => 'Teller', 'class' => 'bg-green-100 text-green-700'],
                                                3 => ['label' => 'Priority Tech', 'class' => 'bg-red-100 text-red-700'],
                                                default => ['label' => 'Service', 'class' => 'bg-slate-100 text-slate-700']
                                            };
                                        @endphp
                                        <div class="text-right">
                                            <span class="block text-[10px] font-bold uppercase tracking-wide mb-1 {{ $badgeInfo['class'] }} px-2 py-0.5 rounded">{{ $badgeInfo['label'] }}</span>
                                            <span class="{{ $waitingCount > 5 ? 'text-red-600' : 'text-slate-500' }} text-xs font-bold">{{ $waitingCount }} Waiting</span>
                                        </div>
                                    </div>
                                    <h3 class="text-slate-500 font-bold uppercase text-xs mb-1">{{ $service->name }}</h3>
                                    <div class="flex items-end gap-2">
                                        <p class="text-3xl font-bold text-slate-800">{{ $serving ? $serving->ticket_number : '-' }}</p>
                                        <span class="text-xs text-slate-400 mb-1">Serving Now</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Interaction History (User - Staff) -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800">Riwayat Interaksi & Solusi</h2>
                        <p class="text-sm text-slate-500">Log penyelesaian masalah pelanggan.</p>
                    </div>
                    <div>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                                    <th class="px-8 py-4 font-semibold">Tiket / Waktu</th>
                                    <th class="px-6 py-4 font-semibold">Pelanggan & Keluhan</th>
                                    <th class="px-6 py-4 font-semibold">Solusi Staff</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($historyLogs as $log)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-8 py-4">
                                            <span class="block font-mono font-bold text-slate-700 bg-slate-100 inline-block px-2 rounded mb-1">{{ $log->ticket_number }}</span>
                                            <span class="block text-xs text-slate-400">{{ $log->completed_at->format('H:i') }}</span>
                                        </td>
                                        <td class="px-6 py-4 max-w-xs">
                                            <p class="font-bold text-slate-800 text-sm">{{ $log->customer_name }}</p>
                                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $log->issue_detail ?? 'Layanan Reguler' }}</p>
                                        </td>
                                        <td class="px-6 py-4 max-w-xs">
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">{{ substr($log->server->name ?? '?', 0, 1) }}</div>
                                                <span class="text-xs font-bold text-slate-600">{{ $log->server->name ?? 'System' }}</span>
                                            </div>
                                            <p class="text-xs text-slate-600 bg-blue-50/50 p-2 rounded-lg border border-blue-50 italic">"{{ $log->staff_response }}"</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Selesai
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-10 text-center text-slate-400">Belum ada riwayat interaksi selesai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right: Incoming Reports -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <div class="px-6 py-5 border-b border-slate-100 bg-red-50/30 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Laporan Masuk</h2>
                            <p class="text-xs text-slate-500">Permintaan penanganan terbaru</p>
                        </div>
                        <span class="bg-white border border-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-lg animate-pulse">Live</span>
                    </div>
                    
                    <div class="divide-y divide-slate-50 max-h-[600px] overflow-y-auto">
                        @forelse($incomingReports as $report)
                            <!-- Ticket Card -->
                            <form action="{{ route('queue.call_specific', $report->id) }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left group relative overflow-hidden transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                                    
                                    <!-- Priority Highlighting -->
                                    <div class="{{ $report->service_id == 3 ? 'bg-red-50 border-red-200 hover:bg-red-100 hover:border-red-300' : ($report->service_id == 2 ? 'bg-emerald-50 border-emerald-200 hover:bg-emerald-100' : 'bg-white border-slate-100 hover:bg-blue-50 hover:border-blue-200') }} 
                                                p-5 rounded-2xl border shadow-sm relative z-10">
                                        
                                        <!-- Header: Code & Time -->
                                        <div class="flex justify-between items-center mb-3">
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $serviceCode = match($report->service_id) {
                                                        1 => 'A',
                                                        2 => 'B',
                                                        3 => 'C',
                                                        default => '?'
                                                    };
                                                @endphp
                                                <div class="{{ $report->service_id == 3 ? 'bg-red-600 text-white' : ($report->service_id == 2 ? 'bg-emerald-600 text-white' : 'bg-blue-600 text-white') }} 
                                                            w-8 h-8 rounded-lg flex items-center justify-center font-bold text-lg shadow-md">
                                                    {{ $serviceCode }}
                                                </div>
                                                <span class="font-mono font-bold text-slate-700 text-lg tracking-tight">{{ $report->ticket_number }}</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-[10px] font-bold uppercase tracking-wider {{ $report->created_at->diffInMinutes() > 15 ? 'text-red-500 animate-pulse' : 'text-slate-400' }}">
                                                    {{ $report->created_at->format('H:i') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="mb-3">
                                            @if($report->service_id == 3)
                                                <div class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide mb-2">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    Priority Concern
                                                </div>
                                            @endif
                                            <p class="text-sm font-bold text-slate-900 leading-snug line-clamp-2">"{{ $report->issue_detail }}"</p>
                                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $report->customer_name }}
                                            </p>
                                        </div>

                                        <!-- Action Indicator -->
                                        <div class="pt-3 border-t {{ $report->service_id == 3 ? 'border-red-200' : 'border-slate-100' }} flex justify-between items-center">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Click to Serve</span>
                                            <div class="w-6 h-6 rounded-full {{ $report->service_id == 3 ? 'bg-red-200 text-red-700' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @empty
                            <div class="p-10 text-center text-slate-400">
                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-sm">Semua layanan terkendali.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-4 bg-slate-50 border-t border-slate-100 text-center">
                        <a href="{{ url('/cs') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Masuk workspace CS &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>
</html>