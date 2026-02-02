<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Antrian Menunggu</h3>
        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg text-xs font-bold">{{ $complaints->count() }}</span>
    </div>

    <div class="divide-y divide-slate-50 max-h-[500px] overflow-y-auto custom-scrollbar">
        @forelse($complaints as $complaint)
            <form action="{{ route('queue.call_specific', $complaint->id) }}" method="POST" class="block">
                @csrf
                <button type="submit"
                    class="w-full text-left p-4 md:p-5 hover:bg-slate-50 transition group relative overflow-hidden">
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition">
                    </div>
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-mono font-bold text-lg text-slate-700 group-hover:text-blue-600 transition">{{ $complaint->ticket_number }}</span>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $complaint->service_id == 1 ? 'bg-blue-100 text-blue-600' : ($complaint->service_id == 2 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600') }}">
                                {{ $complaint->service->name ?? 'Layanan' }}
                            </span>
                        </div>
                        <span
                            class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">{{ $complaint->created_at->format('H:i') }}</span>
                    </div>
                    <p class="text-xs text-slate-500 line-clamp-2 md:line-clamp-none mb-2">
                        {{ $complaint->issue_detail ? '"' . $complaint->issue_detail . '"' : 'Layanan Reguler' }}
                    </p>
                    <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                        {{ $complaint->customer_name }}
                    </div>
                </button>
            </form>
        @empty
            <div class="p-6 md:p-8 text-center text-slate-400">
                <div class="bg-slate-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium">Antrian Bersih!</p>
                <p class="text-xs mt-1 text-slate-300">Belum ada user menunggu.</p>
            </div>
        @endforelse
    </div>
</div>