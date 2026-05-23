<div id="sidebar"
     class="relative z-40 w-64
            bg-gradient-to-b from-green-800 to-green-700 text-white
            transition-all duration-300 ease-in-out
            h-screen shadow-xl overflow-hidden
            flex-shrink-0">

    <!-- LOGO -->
    <div class="px-6 py-8 border-b border-green-700/50">
        <h1 class="text-lg font-bold">AssetHub</h1>
        <p class="text-xs text-green-200">Greenfields</p>
    </div>

    <!-- MENU -->
    <nav class="px-4 py-6 space-y-2">

        <a href="{{ route('dashboard') }}"
           class="block px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-green-600' : 'hover:bg-green-700/50' }}">
            Dashboard
        </a>

        <a href="{{ route('assets.index') }}"
           class="block px-4 py-3 rounded-lg {{ request()->routeIs('assets.*') ? 'bg-green-600' : 'hover:bg-green-700/50' }}">
            Assets
        </a>

        <a href="{{ route('categories.index') }}"
           class="block px-4 py-3 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-green-600' : 'hover:bg-green-700/50' }}">
            Categories
        </a>

        <a href="{{ route('maintenance.index') }}"
           class="block px-4 py-3 rounded-lg {{ request()->routeIs('maintenance.*') ? 'bg-green-600' : 'hover:bg-green-700/50' }}">
            Maintenance
        </a>

        <a href="{{ route('users.index') }}"
           class="block px-4 py-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-green-600' : 'hover:bg-green-700/50' }}">
            Users
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="px-4 py-6 border-t border-green-700/50">
        <button onclick="document.getElementById('logout-form').submit()"
                class="w-full px-4 py-3 rounded-lg hover:bg-red-600/30 text-left">
            Logout
        </button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>

<!-- OVERLAY - hapus md:hidden -->
<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/50 hidden z-30"></div>