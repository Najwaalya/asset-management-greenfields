@extends('layouts.app')

@section('title', 'Detail Jadwal Maintenance')
@section('page-title', 'Detail Jadwal')
@section('breadcrumb', 'Maintenance Schedule')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <!-- Detail Card -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ $schedule->title }}</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($schedule->status == 'upcoming')     bg-blue-100 text-blue-800
                @elseif($schedule->status == 'in_progress') bg-yellow-100 text-yellow-800
                @elseif($schedule->status == 'done')        bg-green-100 text-green-800
                @elseif($schedule->status == 'cancelled')   bg-red-100 text-red-800
                @endif">
                {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Asset</p>
                <p class="font-medium text-gray-900">{{ $schedule->asset->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Teknisi</p>
                <p class="font-medium text-gray-900">{{ $schedule->assignee->name ?? 'Belum diassign' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Tanggal Jadwal</p>
                <p class="font-medium text-gray-900">{{ $schedule->scheduled_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Jadwal Berikutnya</p>
                <p class="font-medium text-gray-900">
                    {{ $schedule->next_schedule ? $schedule->next_schedule->format('d M Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Repeat</p>
                <p class="font-medium text-gray-900">
                    {{ $schedule->repeat_every ? 'Setiap ' . $schedule->repeat_every . ' hari' : 'Tidak berulang' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Dibuat Oleh</p>
                <p class="font-medium text-gray-900">{{ $schedule->creator->name ?? '-' }}</p>
            </div>
            @if($schedule->description)
            <div class="md:col-span-2">
                <p class="text-gray-500">Deskripsi</p>
                <p class="font-medium text-gray-900">{{ $schedule->description }}</p>
            </div>
            @endif
        </div>

        <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
            <a href="{{ route('maintenance.schedule.index') }}"
               class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Kembali
            </a>
            <a href="{{ route('maintenance.schedule.edit', $schedule->id) }}"
               class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Edit
            </a>
        </div>

    </div>

    <!-- Log History -->
    @if($schedule->logs->count())
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Log</h3>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($schedule->logs as $log)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $log->issue }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Dilaporkan oleh {{ $log->reporter->name ?? '-' }}
                                · {{ $log->created_at->format('d M Y') }}
                            </p>
                            @if($log->solution)
                                <p class="text-xs text-green-600 mt-1">✓ {{ $log->solution }}</p>
                            @endif
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($log->status == 'pending')       bg-yellow-100 text-yellow-800
                            @elseif($log->status == 'in_progress') bg-blue-100 text-blue-800
                            @elseif($log->status == 'resolved')    bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    @endif

</div>

@endsection