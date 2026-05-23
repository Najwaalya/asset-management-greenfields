@extends('layouts.app')

@section('title', 'Edit Log Maintenance')
@section('page-title', 'Edit Log')
@section('breadcrumb', 'Maintenance Logs')

@section('content')
<div class="max-w-2xl mx-auto">

<!-- BACK BUTTON -->
    <div class="mb-6">

        <a href="{{ route('maintenance.index') }}"
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

            Back to Maintenance Logs

        </a>

    </div>

    {{-- INFO ASSET --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <h4 class="text-sm font-semibold text-blue-900 mb-3">Informasi Asset</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-blue-600 font-medium">Nama Asset</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $log->asset->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">Kode Asset</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $log->asset->code ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-blue-600 font-medium">📍 Lokasi</p>
                <p class="text-sm text-blue-900 font-semibold mt-1">{{ $log->asset->location ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Log Maintenance</h2>

        <form action="{{ route('maintenance.update', $log->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- ASSET --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asset</label>
                <select name="asset_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('asset_id') border-red-400 @enderror">
                    <option value="">-- Pilih Asset --</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id', $log->asset_id) == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->code }})
                        </option>
                    @endforeach
                </select>
                @error('asset_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TEKNISI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teknisi</label>
                <select name="assigned_to"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Teknisi --</option>
                    @foreach($teknisis as $teknisi)
                        <option value="{{ $teknisi->id }}" {{ old('assigned_to', $log->assigned_to) == $teknisi->id ? 'selected' : '' }}>
                            {{ $teknisi->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ISSUE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Issue / Masalah <span class="text-red-500">*</span></label>
                <textarea name="issue" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('issue') border-red-400 @enderror">{{ old('issue', $log->issue) }}</textarea>
                @error('issue')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- SOLUSI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solusi <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="solution" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('solution', $log->solution) }}</textarea>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="pending"     {{ old('status', $log->status) == 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $log->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved"    {{ old('status', $log->status) == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('maintenance.show', $log->id) }}"
                   class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection