@extends('layouts.app')

@section('title', 'Detail Laporan Maintenance')
@section('page-title', 'Detail Laporan')
@section('breadcrumb', 'Maintenance Logs')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Detail Laporan</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($log->status == 'pending')       bg-yellow-100 text-yellow-800
                @elseif($log->status == 'in_progress') bg-blue-100 text-blue-800
                @elseif($log->status == 'resolved')    bg-green-100 text-green-800
                @endif">
                {{ ucfirst(str_replace('_', ' ', $log->status)) }}
            </span>
        </div>

        <div class="space-y-4 text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500">Asset</p>
                    <p class="font-medium text-gray-900">{{ $log->asset->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Teknisi</p>
                    <p class="font-medium text-gray-900">{{ $log->assignee->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Dilaporkan Oleh</p>
                    <p class="font-medium text-gray-900">{{ $log->reporter->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal</p>
                    <p class="font-medium text-gray-900">{{ $log->created_at->format('d M Y, H:i') }}</p>
                </div>
                @if($log->resolved_at)
                <div>
                    <p class="text-gray-500">Diselesaikan</p>
                    <p class="font-medium text-gray-900">{{ $log->resolved_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
                @if($log->schedule)
                <div>
                    <p class="text-gray-500">Dari Jadwal</p>
                    <a href="{{ route('maintenance.schedule.show', $log->schedule->id) }}"
                       class="font-medium text-green-600 hover:text-green-700">
                        {{ $log->schedule->title }}
                    </a>
                </div>
                @endif
            </div>

            <div class="pt-2 border-t border-gray-100">
                <p class="text-gray-500 mb-1">Issue / Masalah</p>
                <p class="font-medium text-gray-900">{{ $log->issue }}</p>
            </div>

            @if($log->solution)
            <div class="pt-2 border-t border-gray-100">
                <p class="text-gray-500 mb-1">Solusi</p>
                <p class="font-medium text-gray-900">{{ $log->solution }}</p>
            </div>
            @endif
        </div>

        <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
            <a href="{{ route('maintenance.index') }}"
               class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Kembali
            </a>
            <a href="{{ route('maintenance.edit', $log->id) }}"
               class="px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Edit
            </a>
        </div>

    </div>
</div>

@endsection