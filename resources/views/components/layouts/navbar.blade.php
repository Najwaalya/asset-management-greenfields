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

            <!-- SEARCH FORM -->
            <form action="{{ route('assets.index') }}" method="GET" class="hidden lg:block">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search assets..."
                        class="border border-gray-200 pl-9 pr-4 py-1.5 rounded-lg text-sm
                            focus:ring-2 focus:ring-green-500 focus:border-transparent
                            transition-all duration-200 w-56"
                    >
                    <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
            </form>
            
            <!-- BELL NOTIFICATION -->
            <div class="relative" id="notif-wrapper">

                <button id="notif-btn"
                        class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-50 transition">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>

                    @if($navNotifCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                            {{ $navNotifCount > 9 ? '9+' : $navNotifCount }}
                        </span>
                    @endif

                </button>

                <!-- DROPDOWN NOTIFIKASI -->
                <div id="notif-dropdown"
                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 z-50">

                    <!-- HEADER -->
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900">Notifikasi Jadwal</p>
                        @if($navNotifCount > 0)
                            <span class="text-xs bg-red-100 text-red-600 font-medium px-2 py-0.5 rounded-full">
                                {{ $navNotifCount }} jadwal
                            </span>
                        @endif
                    </div>

                    <!-- LIST -->
                    <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">

                        @forelse($navNotifications as $notif)
                            @php
                                $isOverdue  = $notif->scheduled_date->isPast() && $notif->status === 'upcoming';
                                $isToday    = $notif->scheduled_date->isToday();
                                $isSoon     = $notif->scheduled_date->diffInDays(now()) <= 3 && !$isOverdue;

                                $badgeClass = match(true) {
                                    $isOverdue => 'bg-red-100 text-red-700',
                                    $isToday   => 'bg-yellow-100 text-yellow-700',
                                    $isSoon    => 'bg-orange-100 text-orange-700',
                                    default    => 'bg-blue-100 text-blue-700',
                                };

                                $badgeLabel = match(true) {
                                    $isOverdue => 'Overdue',
                                    $isToday   => 'Hari ini',
                                    $isSoon    => 'Segera',
                                    default    => 'Upcoming',
                                };
                            @endphp

                            <a href="{{ route('maintenance.schedule.show', $notif->id) }}"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition">

                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $notif->title }}</p>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $notif->asset->name ?? '-' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs {{ $badgeClass }} px-1.5 py-0.5 rounded-full font-medium">
                                            {{ $badgeLabel }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            {{ $notif->scheduled_date->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                            </a>

                        @empty
                            <div class="px-4 py-6 text-center text-gray-400 text-sm">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada jadwal aktif
                            </div>
                        @endforelse

                    </div>

                    <!-- FOOTER -->
                    <div class="px-4 py-2 border-t border-gray-100">
                        <a href="{{ route('maintenance.schedule.index') }}"
                        class="text-xs text-green-600 hover:text-green-700 font-medium">
                            Lihat semua jadwal →
                        </a>
                    </div>

                </div>

            </div>

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

    // Notifikasi dropdown
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');

    notifBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('hidden');
        // Tutup profile dropdown kalau terbuka
        dropdown.classList.add('hidden');
    });

    document.addEventListener('click', function() {
        notifDropdown?.classList.add('hidden');
    });

});
</script>