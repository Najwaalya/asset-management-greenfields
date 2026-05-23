@extends('layouts.app')

@section('title', 'Detail Jadwal Maintenance')
@section('page-title', 'Detail Jadwal')
@section('breadcrumb', 'Maintenance Schedule')

@section('content')

<div class="max-w-3xl mx-auto space-y-4">
<!-- BACK BUTTON -->
    <div class="mb-6">

        <a href="{{ route('maintenance.schedule.index') }}"
           class="inline-flex items-center text-blue-600 hover:text-blue-700 transition">

            <svg class="w-5 h-5 mr-2"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7"/>

            </svg>

            Back to Maintenance Schedule

        </a>

    </div>
    @php
        $isAssignedToMe    = auth()->id() === $schedule->assigned_to;
        $isAdminOrOperator = in_array(auth()->user()->role, ['admin', 'operator']);
    @endphp

    {{-- INFO ASSET & LOKASI --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-blue-900 mb-3">Informasi Asset</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-blue-600 font-medium">Nama Asset</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->asset->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">Kode Asset</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->asset->code ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">📍 Lokasi</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->asset->location ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- DETAIL JADWAL --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ $schedule->title }}</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($schedule->status == 'upcoming')        bg-blue-100 text-blue-800
                @elseif($schedule->status == 'in_progress') bg-yellow-100 text-yellow-800
                @elseif($schedule->status == 'done')        bg-green-100 text-green-800
                @elseif($schedule->status == 'cancelled')   bg-red-100 text-red-800
                @endif">
                {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div>
                <p class="text-gray-500">Teknisi</p>
                <p class="font-medium text-gray-900">{{ $schedule->assignee->name ?? 'Belum diassign' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Dibuat Oleh</p>
                <p class="font-medium text-gray-900">{{ $schedule->creator->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Tanggal Jadwal</p>
                <p class="font-medium text-gray-900">{{ $schedule->scheduled_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Repeat</p>
                <p class="font-medium text-gray-900">
                    {{ $schedule->repeat_every ? 'Setiap ' . $schedule->repeat_every . ' hari' : '-' }}
                </p>
            </div>
            @if($schedule->next_schedule)
            <div>
                <p class="text-gray-500">Jadwal Berikutnya</p>
                <p class="font-medium text-gray-900">{{ $schedule->next_schedule->format('d M Y') }}</p>
            </div>
            @endif
        </div>

        @if($schedule->description)
        <div class="pt-4 border-t border-gray-100 text-sm">
            <p class="text-gray-500 mb-1">Deskripsi</p>
            <p class="font-medium text-gray-900">{{ $schedule->description }}</p>
        </div>
        @endif

        {{-- UPDATE STATUS --}}
        @if($schedule->status !== 'done' && $schedule->status !== 'cancelled')
            @if($isAdminOrOperator || $isAssignedToMe)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                    <h4 class="text-sm font-semibold text-yellow-900 mb-3">Update Status Pengerjaan</h4>
                    <form action="{{ route('maintenance.schedule.updateStatus', $schedule->id) }}" method="POST"
                          class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="upcoming"    {{ $schedule->status == 'upcoming'    ? 'selected' : '' }}>Upcoming</option>
                            <option value="in_progress" {{ $schedule->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done"        {{ $schedule->status == 'done'        ? 'selected' : '' }}>Done</option>
                        </select>
                        <button type="submit"
                                class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Update Status
                        </button>
                    </form>
                </div>
            @endif
        @endif

        {{-- TOMBOL AKSI --}}
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
            <a href="{{ route('maintenance.schedule.index') }}"
               class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Kembali
            </a>

            <div class="flex items-center gap-3">

                {{-- Buat Log — admin/operator semua jadwal, teknisi hanya yang di-assign --}}
                @if($schedule->status !== 'done' && $schedule->status !== 'cancelled')
                    @if($isAdminOrOperator || $isAssignedToMe)
                        <a href="{{ route('maintenance.create', ['schedule_id' => $schedule->id, 'asset_id' => $schedule->asset_id]) }}"
                           class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            + Buat Log
                        </a>
                    @endif
                @endif

                {{-- Edit & Hapus — hanya admin/operator --}}
                @if($isAdminOrOperator)
                    <a href="{{ route('maintenance.schedule.edit', $schedule->id) }}"
                       class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('maintenance.schedule.destroy', $schedule->id) }}"
                          method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </form>
                @endif

            </div>
        </div>

    </div>

    {{-- LOG HISTORY dari schedule ini --}}
    @if($schedule->logs->count() > 0)
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-900 mb-4">History Log</h3>
        <div class="space-y-3">
            @foreach($schedule->logs as $log)
                <a href="{{ route('maintenance.show', $log->id) }}"
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $log->issue }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ $log->reporter->name ?? '-' }} · {{ $log->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        @if($log->status == 'pending')         bg-yellow-100 text-yellow-800
                        @elseif($log->status == 'in_progress') bg-blue-100 text-blue-800
                        @elseif($log->status == 'resolved')    bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: "Jadwal yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush

@endsection