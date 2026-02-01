<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 flex items-center justify-center">
                    <img src="{{ asset('grapara.png') }}" class="h-9 w-9 object-contain" alt="Grapara Logo">
                </div>
                <span class="font-bold text-xl text-slate-900 tracking-tight hidden sm:block">Grapara <span
                        class="text-blue-600">CS</span></span>
            </div>

            <!-- Right Buttons -->
            <div class="flex items-center gap-3">
                <!-- Manual Refresh (Backup) -->
                <button @click="fetchUpdates()"
                    class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition relative group"
                    title="Force Refresh Data">
                    <svg class="w-5 h-5 transition-transform duration-700" :class="{'rotate-180': loading}" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    <!-- Loading Indicator Dot -->
                    <span x-show="loading" class="absolute top-2 right-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                </button>



                <!-- Home Button -->


                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                <div class="text-right hidden sm:block">
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Staff</p>
                    <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-50 text-red-600 hover:bg-red-100 p-2 rounded-lg transition" title="Logout">
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
</nav>