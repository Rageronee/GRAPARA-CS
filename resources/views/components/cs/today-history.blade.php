<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Riwayat Hari Ini</h3>
        <span
            class="bg-emerald-100 text-emerald-600 px-2 py-1 rounded-lg text-xs font-bold">{{ $todayTickets->count() }}</span>
    </div>

    <div class="divide-y divide-slate-50 max-h-[300px] overflow-y-auto custom-scrollbar">
        @forelse($todayTickets->sortByDesc('completed_at') as $ticket)
            <div class="p-4 hover:bg-slate-50 transition">
                <div class="flex justify-between items-start mb-1">
                    <span
                        class="font-mono font-bold text-slate-700 bg-slate-100 px-2 rounded text-xs">{{ $ticket->ticket_number }}</span>
                    <span class="text-[10px] text-slate-400 font-bold">{{ $ticket->completed_at->format('H:i') }}</span>
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs text-slate-600 font-bold line-clamp-1">{{ $ticket->customer_name }}</p>
                        <p class="text-[10px] text-slate-400 truncate w-32">{{ $ticket->issue_detail ?? 'Layanan Reguler' }}
                        </p>
                    </div>
                    @if($ticket->rating)
                        <div class="flex items-center text-yellow-400">
                            <span class="text-xs font-bold text-slate-600 mr-1">{{ $ticket->rating }}</span>
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        </div>
                    @else
                        <span class="text-[10px] text-slate-300 italic">Belum dinilai</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-slate-400 text-xs">
                Belum ada tiket yang diselesaikan hari ini.
            </div>
        @endforelse
    </div>
</div>