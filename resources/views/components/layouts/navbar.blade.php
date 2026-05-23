<header class="bg-white border-b border-green-200 shadow-sm sticky top-0 z-20">

    <div class="flex items-center justify-between px-4 py-4">

        <!-- LEFT -->
        <div class="flex items-center space-x-3">

            <button id="open-sidebar"
                    class="p-2 rounded-md text-green-700 hover:bg-green-50">
                ☰
            </button>

            <h2 class="text-xl font-semibold text-gray-900">
                @yield('page-title', 'Dashboard')
            </h2>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center space-x-4">

            <input class="hidden lg:block border px-3 py-1 rounded-lg text-sm"
                   placeholder="Search...">

            <!-- PROFILE DROPDOWN -->
            <div class="relative" id="profile-wrapper">

                <!-- AVATAR BUTTON -->
                <button id="profile-btn"
                        class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-50 transition">

                    <!-- AVATAR INITIALS -->
                    <div class="w-9 h-9 rounded-full bg-green-600 flex items-center justify-center text-white text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strrpos(auth()->user()->name, ' ') + 1, 1)) }}
                    </div>

                    <!-- NAME (hidden on small screens) -->
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-800 leading-none">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <!-- CHEVRON -->
                    <svg class="w-4 h-4 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>

                </button>

                <!-- DROPDOWN MENU -->
                <div id="profile-dropdown"
                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 z-50">

                    <!-- USER INFO -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <!-- MENU ITEMS -->
                    <div class="py-1 border-b border-gray-100">
                        <a href="{{ route('profile.show') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            My Profile
                        </a>
                        <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <!-- LOGOUT -->
                    <div class="py-1">
                        <button onclick="document.getElementById('navbar-logout-form').submit()"
                                class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </div>

                </div>

            </div>

            <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>

        </div>

    </div>

</header>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('profile-btn');
    const dropdown = document.getElementById('profile-dropdown');

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        dropdown.classList.add('hidden');
    });

});
</script>