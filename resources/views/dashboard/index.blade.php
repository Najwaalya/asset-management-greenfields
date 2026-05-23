@extends('layouts.app')

@section('title', 'Dashboard - Asset Management System')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card title="Total Assets"    :value="$totalAssets"       trend="2.5"  color="green"  icon='...' />
        <x-stat-card title="Normal Assets"   :value="$normalAssets"      trend="1.2"  color="green"  icon='...' />
        <x-stat-card title="In Maintenance"  :value="$maintenanceAssets" trend="-0.5" color="yellow" icon='...' />
        <x-stat-card title="Broken Assets"   :value="$brokenAssets"      trend="7.2"  color="red"    icon='...' />
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('assets.create') }}"      class="flex items-center space-x-3 px-6 py-4 bg-white rounded-lg shadow border border-gray-200 hover:shadow-lg hover:border-green-600 transition-all duration-300">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="font-medium text-gray-900">Create Asset</span>
            </a>
            <a href="{{ route('maintenance.create') }}" class="flex items-center space-x-3 px-6 py-4 bg-white rounded-lg shadow border border-gray-200 hover:shadow-lg hover:border-green-600 transition-all duration-300">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-medium text-gray-900">Schedule Maintenance</span>
            </a>
            <a href="{{ route('categories.create') }}"  class="flex items-center space-x-3 px-6 py-4 bg-white rounded-lg shadow border border-gray-200 hover:shadow-lg hover:border-green-600 transition-all duration-300">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                <span class="font-medium text-gray-900">New Category</span>
            </a>
            <a href="{{ route('users.create') }}"       class="flex items-center space-x-3 px-6 py-4 bg-white rounded-lg shadow border border-gray-200 hover:shadow-lg hover:border-green-600 transition-all duration-300">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="font-medium text-gray-900">Add User</span>
            </a>
        </div>
    </div>

    <!-- Alerts + Calendar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <!-- PRIORITY ALERTS -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden h-full">

                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Priority Alerts
                    </h3>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($recentAlerts as $alert)

                        @php
                            $levelConfig = match($alert->alert_level) {
                                'critical' => [
                                    'border' => 'border-red-500',
                                    'badge'  => 'bg-red-100 text-red-700',
                                    'label'  => 'Critical',
                                    'dot'    => 'bg-red-500',
                                ],
                                'info' => [
                                    'border' => 'border-blue-500',
                                    'badge'  => 'bg-blue-100 text-blue-700',
                                    'label'  => 'Info',
                                    'dot'    => 'bg-blue-500',
                                ],
                                default => [
                                    'border' => 'border-yellow-400',
                                    'badge'  => 'bg-yellow-100 text-yellow-700',
                                    'label'  => 'Warning',
                                    'dot'    => 'bg-yellow-400',
                                ],
                            };
                        @endphp

                        <a href="{{ route('maintenance.show', $alert->id) }}"
                           class="block p-4 hover:bg-gray-50 transition border-l-4 {{ $levelConfig['border'] }}">

                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $alert->asset->name ?? '-' }}
                                </span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $levelConfig['badge'] }}">
                                    {{ $levelConfig['label'] }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-600 truncate">
                                {{ $alert->issue }}
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                {{ $alert->created_at->diffForHumans() }}
                            </p>

                        </a>

                    @empty
                        <div class="p-6 text-center text-gray-400 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            No alerts — all clear!
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- CALENDAR -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Maintenance Calendar</h3>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400 inline-block"></span> Pending</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span> In Progress</span>
                        <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span> Resolved</span>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="p-4" id="calendar-container">

                    <!-- Nav -->
                    <div class="flex items-center justify-between mb-4">
                        <button id="cal-prev" class="p-1.5 rounded hover:bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span id="cal-title" class="text-sm font-semibold text-gray-700"></span>
                        <button id="cal-next" class="p-1.5 rounded hover:bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                    <!-- Days Header -->
                    <div class="grid grid-cols-7 mb-1">
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                            <div class="text-center text-xs font-medium text-gray-400 py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    <!-- Days Grid -->
                    <div id="cal-grid" class="grid grid-cols-7 gap-1"></div>

                    <!-- Tooltip -->
                    <div id="cal-tooltip"
                         class="hidden absolute z-50 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 shadow-xl max-w-xs pointer-events-none">
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Recent Maintenance Table -->
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Maintenance</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentMaintenances as $maintenance)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $maintenance->asset->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ $maintenance->issue }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($maintenance->status == 'pending')       bg-yellow-100 text-yellow-800
                                    @elseif($maintenance->status == 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($maintenance->status == 'resolved')    bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $maintenance->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('maintenance.show', $maintenance->id) }}"
                                   class="text-green-600 hover:text-green-700 font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No maintenance data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Data dari Laravel
    const events = @json($calendarEvents);

    // Group events by date
    const eventMap = {};
    events.forEach(e => {
        if (!eventMap[e.date]) eventMap[e.date] = [];
        eventMap[e.date].push(e);
    });

    const statusColor = {
        pending:     'bg-yellow-400',
        in_progress: 'bg-blue-500',
        resolved:    'bg-green-500',
    };

    const monthNames = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];

    let currentDate = new Date();

    function renderCalendar(date) {
        const year  = date.getFullYear();
        const month = date.getMonth();

        document.getElementById('cal-title').textContent =
            monthNames[month] + ' ' + year;

        const firstDay  = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today     = new Date();

        const grid = document.getElementById('cal-grid');
        grid.innerHTML = '';

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            grid.insertAdjacentHTML('beforeend', '<div></div>');
        }

        // Day cells
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const dayEvents = eventMap[dateStr] || [];
            const isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());

            const dots = dayEvents.slice(0, 3).map(e =>
                `<span class="w-1.5 h-1.5 rounded-full ${statusColor[e.status] || 'bg-gray-400'} inline-block"></span>`
            ).join('');

            const cell = document.createElement('div');
            cell.className = `relative flex flex-col items-center justify-start pt-1 pb-1 rounded-lg min-h-[40px] cursor-default transition
                ${isToday ? 'bg-green-600 text-white font-bold' : 'hover:bg-gray-50 text-gray-700'}
                ${dayEvents.length ? 'cursor-pointer' : ''}`;

            cell.innerHTML = `
                <span class="text-xs leading-none">${d}</span>
                <div class="flex gap-0.5 mt-0.5">${dots}</div>
            `;

            // Tooltip on hover
            if (dayEvents.length) {
                const tooltip = document.getElementById('cal-tooltip');

                cell.addEventListener('mouseenter', function (e) {
                    const lines = dayEvents.map(ev =>
                        `<div class="flex items-center gap-1.5 py-0.5">
                            <span class="w-2 h-2 rounded-full ${statusColor[ev.status] || 'bg-gray-400'} flex-shrink-0"></span>
                            <span>${ev.title}</span>
                            <span class="opacity-60 capitalize">(${ev.status.replace('_',' ')})</span>
                            <span class="opacity-40 text-xs">[${ev.type === 'schedule' ? 'jadwal' : 'log'}]</span>
                        </div>`
                    ).join('');

                    tooltip.innerHTML = lines;
                    tooltip.classList.remove('hidden');

                    const rect = cell.getBoundingClientRect();
                    tooltip.style.top  = (window.scrollY + rect.bottom + 6) + 'px';
                    tooltip.style.left = (window.scrollX + rect.left) + 'px';
                });

                cell.addEventListener('mouseleave', function () {
                    tooltip.classList.add('hidden');
                });

                // Click → go to maintenance show (first event)
                cell.addEventListener('click', function () {
                    const ev = dayEvents[0];
                    if (ev.type === 'schedule') {
                        window.location.href = `/maintenance/schedule/${ev.id}`;
                    } else {
                        window.location.href = `/maintenance/${ev.id}`;
                    }
                });
            }

            grid.appendChild(cell);
        }
    }

    renderCalendar(currentDate);

    document.getElementById('cal-prev').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    document.getElementById('cal-next').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

});
</script>
@endpush