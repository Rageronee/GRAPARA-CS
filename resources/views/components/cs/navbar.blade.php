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

                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        @if($complaintsCount > 0)
                            <span
                                class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-pulse border border-white"></span>
                        @endif
                    </button>
                </div>

                <!-- Home Button -->
                <a href="{{ url('/') }}"
                    class="hidden sm:flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold text-sm transition px-3 py-2 rounded-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Home
                </a>

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