@extends('layouts.app')

@section('title', 'Edit Laporan Maintenance')
@section('page-title', 'Edit Laporan Maintenance')
@section('breadcrumb', 'Maintenance Logs')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Laporan</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('maintenance.update', $log->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            @if(auth()->user()->isAdminOrOperator())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Asset <span class="text-red-500">*</span></label>
                <select name="asset_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="">-- Pilih Asset --</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id', $log->asset_id) == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teknisi</label>
                <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Belum diassign --</option>
                    @foreach($teknisis as $teknisi)
                        <option value="{{ $teknisi->id }}" {{ old('assigned_to', $log->assigned_to) == $teknisi->id ? 'selected' : '' }}>
                            {{ $teknisi->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Issue / Masalah <span class="text-red-500">*</span></label>
                <textarea name="issue" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                          required>{{ old('issue', $log->issue) }}</textarea>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solusi</label>
                <textarea name="solution" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                          placeholder="Isi solusi yang dilakukan...">{{ old('solution', $log->solution) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="pending"     {{ old('status', $log->status) == 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $log->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved"    {{ old('status', $log->status) == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('maintenance.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Update Laporan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection