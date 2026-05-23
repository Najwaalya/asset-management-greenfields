@extends('layouts.app')

@section('title', 'Edit Jadwal Maintenance')
@section('page-title', 'Edit Jadwal Maintenance')
@section('breadcrumb', 'Maintenance Schedule')

@section('content')

<div class="max-w-2xl mx-auto">
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
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Jadwal</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('maintenance.schedule.update', $schedule->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Asset -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asset <span class="text-red-500">*</span></label>
                <select name="asset_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="">-- Pilih Asset --</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id', $schedule->asset_id) == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $schedule->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $schedule->description) }}</textarea>
            </div>

            <!-- Assign Teknisi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teknisi</label>
                <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Belum diassign --</option>
                    @foreach($teknisis as $teknisi)
                        <option value="{{ $teknisi->id }}" {{ old('assigned_to', $schedule->assigned_to) == $teknisi->id ? 'selected' : '' }}>
                            {{ $teknisi->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jadwal <span class="text-red-500">*</span></label>
                <input type="date" name="scheduled_date"
                       value="{{ old('scheduled_date', $schedule->scheduled_date->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <!-- Repeat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ulangi Setiap (hari)</label>
                <input type="number" name="repeat_every" value="{{ old('repeat_every', $schedule->repeat_every) }}" min="1"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="Kosongkan jika tidak berulang">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="upcoming"    {{ old('status', $schedule->status) == 'upcoming'    ? 'selected' : '' }}>Upcoming</option>
                    <option value="in_progress" {{ old('status', $schedule->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="done"        {{ old('status', $schedule->status) == 'done'        ? 'selected' : '' }}>Done</option>
                    <option value="cancelled"   {{ old('status', $schedule->status) == 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('maintenance.schedule.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Update Jadwal
                </button>
            </div>

        </form>
    </div>
</div>

@endsection