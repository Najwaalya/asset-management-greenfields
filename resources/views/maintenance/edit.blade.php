@extends('layouts.app')

@section('title', 'Edit Maintenance')
@section('page-title', 'Edit Maintenance')
@section('breadcrumb', 'Maintenance / Edit')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Edit Maintenance
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                Update maintenance record information
            </p>
        </div>

    </div>

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

            Back to Maintenance

        </a>

    </div>

    <!-- FORM CARD -->
    <form action="{{ route('maintenance.update', $log->id) }}"
          method="POST"
          class="bg-white rounded-lg shadow border border-gray-200 p-8">

        @csrf
        @method('PUT')

        <!-- ASSET -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Asset
            </label>

            <select name="asset_id"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                           focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                           outline-none transition shadow-sm">

                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}"
                        {{ $log->asset_id == $asset->id ? 'selected' : '' }}>
                        {{ $asset->name }}
                    </option>
                @endforeach

            </select>

        </div>

        <!-- ISSUE -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Issue
            </label>

            <textarea name="issue"
                      rows="4"
                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                             focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                             outline-none transition shadow-sm">{{ old('issue', $log->issue) }}</textarea>

        </div>

        <!-- SOLUTION -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Solution
            </label>

            <textarea name="solution"
                      rows="3"
                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                             focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                             outline-none transition shadow-sm">{{ old('solution', $log->solution) }}</textarea>

        </div>

        <!-- STATUS -->
        <div class="mb-6">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Status
            </label>

            <select name="status"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                           focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                           outline-none transition shadow-sm">

                <option value="pending" {{ $log->status == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="in_progress" {{ $log->status == 'in_progress' ? 'selected' : '' }}>
                    In Progress
                </option>

                <option value="resolved" {{ $log->status == 'resolved' ? 'selected' : '' }}>
                    Resolved
                </option>

            </select>

        </div>

        <!-- INFO CARD -->
        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50
                    border border-blue-100 rounded-xl shadow-sm">

            <p class="text-sm text-blue-900">
                <span class="font-semibold">Created at:</span>
                <span class="font-bold">
                    {{ $log->created_at->format('d M Y') }}
                </span>
            </p>

        </div>

        <!-- BUTTONS -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">

            <a href="{{ route('maintenance.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">

                Cancel

            </a>

            <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

                Update Maintenance

            </button>

        </div>

    </form>

</div>

@endsection