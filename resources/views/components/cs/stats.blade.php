<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div
        class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center transition hover:shadow-md">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Tiket Hari Ini</span>
        <span class="text-2xl font-black text-slate-900"
            x-text="stats.total_served">{{ $stats['total_served'] ?? 0 }}</span>
    </div>
    <div
        class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center transition hover:shadow-md">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rating Rata-rata</span>
        <div class="flex items-center gap-1">
            <span class="text-2xl font-black text-slate-900"
                x-text="Number(stats.avg_rating).toFixed(1)">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</span>
            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
        </div>
    </div>
    <div
        class="md:col-span-2 bg-blue-600 bg-linear-to-r from-blue-600 to-indigo-600 p-4 rounded-2xl shadow-lg shadow-blue-500/20 text-white flex items-center justify-between relative overflow-hidden group">
        <div
            class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 transition group-hover:bg-white/20">
        </div>
        <div class="relative z-10">
            <p class="font-bold text-lg text-white">Halo, {{ Auth::user()->name }}!</p>
            <p class="text-blue-100 text-sm">Siap melayani pelanggan hari ini?</p>
        </div>
        <div class="h-10 w-10 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
    </div>
</div>