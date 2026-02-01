<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Workspace - Grapara Modern</title>
    <link rel="icon" href="{{ asset('grapara.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            bg-slate-100;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            bg-slate-300;
            rounded-full;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            bg-slate-400;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-600" x-data="{
        stats: {{ json_encode($myDailyStats) }},
        loading: false,
        init() {
            // Start polling every 5 seconds
            setInterval(() => this.fetchUpdates(), 5000);
        },
        async fetchUpdates() {
            this.loading = true;
            try {
                const response = await fetch('{{ route('cs.updates') }}');
                const data = await response.json();
                
                // Update Stats
                this.stats = data.stats;

                // Update Partial Views (Smooth DOM Replacement)
                // We check if content changed to avoid unnecessary repaints if possible, 
                // but for simplicity we just replace.
                if (this.$refs.queueList) this.$refs.queueList.innerHTML = data.html_queue;
                if (this.$refs.activeTicket) this.$refs.activeTicket.innerHTML = data.html_active;
                if (this.$refs.historyList) this.$refs.historyList.innerHTML = data.html_history;
            } catch (error) {
                console.error('Polling failed:', error);
            } finally {
                this.loading = false;
            }
        }
    }">

    <!-- Navbar Component -->
    <x-cs.navbar :complaintsCount="$complaints->count()" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Stats Component -->
        <x-cs.stats :stats="$myDailyStats" />

        <div class="grid lg:grid-cols-3 gap-8 items-start">

            <!-- LEFT: Queue List (Sticky) -->
            <div class="lg:col-span-1 space-y-6">
                <div x-ref="queueList">
                    <x-cs.queue-list :complaints="$complaints" />
                </div>
                <div x-ref="historyList">
                    <x-cs.today-history :todayTickets="$todayTickets" />
                </div>
            </div>

            <!-- RIGHT: Active Workspace -->
            <div class="lg:col-span-2" x-ref="activeTicket">
                <!-- Server-side Render Initial State -->
                <x-cs.active-ticket />
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-12 py-6 text-center text-xs text-slate-400 border-t border-slate-200">
        <p>&copy; {{ date('Y') }} Grapara Modern. High Performance & Lightweight Queue System.</p>
    </footer>

</body>

</html>