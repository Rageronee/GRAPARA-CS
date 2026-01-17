<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian - Grapara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <!-- Auto Refresh if Waiting/Calling -->
    @if(in_array($queue->status, ['waiting', 'calling']))
        <meta http-equiv="refresh" content="5">
    @endif
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <!-- Card Container -->
    <div
        class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/50 max-w-sm w-full text-center relative overflow-hidden ring-1 ring-slate-100">

        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <!-- LOGO -->
        <div class="mb-6 flex justify-center">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <img src="{{ asset('grapara.png') }}" class="w-8 h-8 object-contain">
            </div>
        </div>

        <!-- STATUS: WAITING / CALLING -->
        @if(in_array($queue->status, ['waiting', 'calling']))

            <h2 class="text-slate-500 uppercase tracking-widest text-xs font-bold mb-3">Nomor Antrian Anda</h2>
            <div class="text-6xl font-black text-slate-900 mb-6 font-mono tracking-tighter">
                {{ $queue->ticket_number }}
            </div>

            @if($queue->status === 'calling')
                <div class="bg-green-50 border border-green-200 p-4 rounded-xl mb-6 animate-pulse">
                    <p class="text-green-700 font-bold text-lg">Silakan Ke Counter!</p>
                    <p class="text-green-600 text-sm">Nomor Anda sedang dipanggil.</p>
                </div>
            @else
                <div class="bg-slate-50 p-4 rounded-xl mb-6 border border-slate-100">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Status</p>
                    <p class="font-bold text-blue-600">Menunggu Giliran</p>
                </div>
            @endif

            <p class="text-slate-400 text-xs mb-8 leading-relaxed">
                Mohon menunggu hingga nomor dipanggil.<br>
                <span class="opacity-70">Tiket: {{ $queue->created_at->format('H:i') }}</span>
            </p>

            <a href="{{ url('/') }}" class="inline-block text-slate-400 hover:text-slate-600 text-sm font-bold transition">
                &larr; Kembali ke Menu
            </a>

            <!-- STATUS: COMPLETED (RATING) -->
        @elseif($queue->status === 'completed' && !$queue->rating)
            
            <div x-data="{ showRating: false }" class="text-left w-full">
                
                <!-- CS Response Section -->
                <div class="mb-6 bg-blue-50 p-5 rounded-2xl border border-blue-100">
                    <p class="text-blue-600 font-bold text-xs uppercase mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Tanggapan Petugas
                    </p>
                    <p class="text-slate-800 text-sm leading-relaxed font-medium">
                        "{{ $queue->staff_response ?? 'Terima kasih telah menggunakan layanan kami.' }}"
                    </p>
                </div>

                <!-- Step 1: 'Selesai' Button to Acknowledge Response -->
                <div x-show="!showRating" class="text-center">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Layanan Selesai</h2>
                    <p class="text-slate-500 text-sm mb-6">Silakan konfirmasi jika tanggapan petugas sudah jelas.</p>
                    
                    <button @click="showRating = true" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl shadow-lg transition hover:scale-[1.02]">
                        Selesai & Beri Nilai
                    </button>
                </div>

                <!-- Step 2: Rating Form -->
                <div x-show="showRating" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-slate-900">Beri Penilaian</h2>
                        <p class="text-slate-500 text-xs">Seberapa puas Anda dengan solusi ini?</p>
                    </div>

                    <form action="{{ route('queue.rate', $queue->id) }}" method="POST" class="text-left">
                        @csrf
                        
                        <!-- Stars -->
                        <div class="flex justify-center flex-row-reverse gap-2 mb-6 group">
                             @for($i=5; $i>=1; $i--)
                                <input type="radio" name="rating" id="star{{$i}}" value="{{$i}}" class="peer hidden" required />
                                <label for="star{{$i}}" class="cursor-pointer text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition transform hover:scale-110">
                                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                </label>
                            @endfor
                        </div>
        
                        <div class="mb-4">
                            <textarea name="feedback" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:border-blue-500 transition resize-none" placeholder="Masukan tambahan (opsional)..."></textarea>
                        </div>
        
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-600/20 transition transform hover:-translate-y-0.5 mb-2">
                            Kirim Jawaban
                        </button>
                        
                        <a href="{{ url('/') }}" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 py-2">
                            Lewati
                        </a>
                    </form>
                </div>
                
            </div>

            <!-- STATUS: COMPLETED & RATED -->
        @elseif($queue->status === 'completed' && $queue->rating)

            <div class="py-10">
                <div
                    class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Terima Kasih!</h2>
                <p class="text-slate-500">Penilaian Anda sangat berarti bagi kami.</p>

                <a href="{{ url('/') }}"
                    class="inline-block mt-8 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-8 rounded-full transition">
                    Kembali ke Beranda
                </a>
            </div>

        @else
            <!-- CANCELLED/SKIPPED -->
            <div class="py-10 opacity-75">
                <div
                    class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-700">Tiket Tidak Aktif</h2>
                <p class="text-sm text-slate-400 mt-2">Tiket ini telah dibatalkan atau kadaluarsa.</p>
                <a href="{{ url('/') }}" class="inline-block mt-6 text-blue-600 font-bold text-sm hover:underline">Buat
                    Tiket Baru</a>
            </div>

        @endif

    </div>
</body>

</html>