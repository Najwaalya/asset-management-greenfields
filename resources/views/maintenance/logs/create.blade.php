@extends('layouts.app')

@section('title', 'Buat Log Maintenance')
@section('page-title', 'Buat Log')
@section('breadcrumb', 'Maintenance Logs')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- INFO SCHEDULE (kalau dari schedule) --}}
    @if($schedule)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <h4 class="text-sm font-semibold text-blue-900 mb-3">Dari Jadwal</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-blue-600 font-medium">Judul Jadwal</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->title }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">Asset</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->asset->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">📍 Lokasi</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $schedule->asset->location ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Buat Log Maintenance</h2>

        <form action="{{ route('maintenance.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Hidden fields dari schedule --}}
            @if($scheduleId)
                <input type="hidden" name="schedule_id" value="{{ $scheduleId }}">
            @endif

            {{-- ASSET --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asset</label>
                @if($schedule)
                    {{-- Kalau dari schedule, asset dikunci --}}
                    <input type="hidden" name="asset_id" value="{{ $schedule->asset_id }}">
                    <input type="text" value="{{ $schedule->asset->name ?? '-' }}" disabled
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                @else
                    <select name="asset_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('asset_id') border-red-400 @enderror">
                        <option value="">-- Pilih Asset --</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id', $assetId) == $asset->id ? 'selected' : '' }}>
                                {{ $asset->name }} ({{ $asset->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            {{-- TEKNISI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teknisi</label>
                <select name="assigned_to"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Teknisi --</option>
                    @foreach($teknisis as $teknisi)
                        <option value="{{ $teknisi->id }}"
                            {{ old('assigned_to', $schedule->assigned_to ?? '') == $teknisi->id ? 'selected' : '' }}>
                            {{ $teknisi->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ISSUE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Issue / Masalah <span class="text-red-500">*</span></label>
                <textarea name="issue" rows="3"
                          placeholder="Deskripsikan masalah yang ditemukan..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('issue') border-red-400 @enderror">{{ old('issue') }}</textarea>
                @error('issue')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- SOLUSI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solusi <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="solution" rows="3"
                          placeholder="Deskripsikan solusi yang dilakukan..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('solution') }}</textarea>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="pending"     {{ old('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved"    {{ old('status') == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ $scheduleId ? route('maintenance.schedule.show', $scheduleId) : route('maintenance.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Simpan Log
                </button>
            </div>

        </form>
    </div>
</div>
@endsection