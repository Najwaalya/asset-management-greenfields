<div id="sidebar"
     class="relative z-40 w-64
            bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white
            transition-all duration-300 ease-in-out
            h-screen shadow-xl overflow-hidden flex-shrink-0
            flex flex-col">

    <!-- LOGO -->
    <div class="px-6 py-6 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4m0 0L4 7m16 0l-8 4m0 0l8 4m-8-4v10m-8-4l8 4m0 0l8-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold leading-none">AssetHub</h1>
                <p class="text-xs text-green-300 mt-0.5">Greenfields</p>
            </div>
        </div>
    </div>

    <!-- MENU -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

        <!-- Label -->
        <p class="text-xs font-semibold text-green-400 uppercase tracking-wider px-3 mb-2">
            Main Menu
        </p>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-sm">Dashboard</span>
        </a>

        @if(auth()->user()->role !== 'teknisi')
            <!-- Assets -->
            <a href="{{ route('assets.index') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition
                    {{ request()->routeIs('assets.*') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4m0 0L4 7m16 0l-8 4m0 0l8 4m-8-4v10m-8-4l8 4m0 0l8-4"/>
                </svg>
                <span class="text-sm">Assets</span>
            </a>
        @endif

        @if(auth()->user()->role === 'admin')
            <!-- Categories -->
            <a href="{{ route('categories.index') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition
                    {{ request()->routeIs('categories.*') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="text-sm">Categories</span>
            </a>

        @endif

        <!-- MAINTENANCE GROUP -->
        <div class="pt-3">
            <p class="text-xs font-semibold text-green-400 uppercase tracking-wider px-3 mb-2">
                Maintenance
            </p>

            <!-- Jadwal -->
            <a href="{{ route('maintenance.schedule.index') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition
                    {{ request()->routeIs('maintenance.schedule.*') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm">Jadwal</span>
            </a>

            <!-- Logs -->
            <a href="{{ route('maintenance.index') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition mt-1
                      {{ request()->routeIs('maintenance.index') || request()->routeIs('maintenance.show') || request()->routeIs('maintenance.edit') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-sm">Logs</span>
            </a>
        </div>

        <!-- Users -->
        @if(auth()->user()->isAdmin())
        <div class="pt-3">
            <p class="text-xs font-semibold text-green-400 uppercase tracking-wider px-3 mb-2">
                Management
            </p>
            <a href="{{ route('users.index') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition
                      {{ request()->routeIs('users.*') ? 'bg-white/20 text-white font-medium' : 'text-green-100 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="text-sm">Users</span>
            </a>
        </div>
        @endif

    </nav>

    <!-- USER INFO + LOGOUT -->
    <div class="px-3 py-4 border-t border-white/10">

        <!-- User Info -->
        <div class="flex items-center space-x-3 px-3 py-2 mb-2">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strrpos(auth()->user()->name, ' ') + 1, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-green-300 truncate capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>

        <!-- Logout -->
        <button onclick="document.getElementById('logout-form').submit()"
                class="flex items-center space-x-3 w-full px-3 py-2.5 rounded-lg text-green-100 hover:bg-red-500/30 transition">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="text-sm">Logout</span>
        </button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

    </div>

</div>

<!-- OVERLAY -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 hidden z-30"></div>