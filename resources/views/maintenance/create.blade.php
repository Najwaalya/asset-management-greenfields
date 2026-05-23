@extends('layouts.app')

@section('title', 'Add Maintenance Record - Asset Management System')
@section('page-title', 'Add Maintenance Record')
@section('breadcrumb', 'Maintenance / Add New')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- BACK -->
    <div class="mb-6">
        <a href="{{ route('maintenance.index') }}"
           class="inline-flex items-center text-blue-600 hover:text-blue-700 transition">

            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>

            Back to Maintenance
        </a>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">

        <!-- HEADER -->
        <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Add Maintenance Record</h2>
            <p class="text-sm text-gray-500 mt-1">
                Create a new maintenance log for asset tracking
            </p>
        </div>

        <!-- FORM -->
        <form action="{{ route('maintenance.store') }}"
              method="POST"
              class="px-6 py-6 space-y-6">

            @csrf

            <!-- ASSET -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Asset
                </label>

                <select name="asset_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50
                               focus:bg-white focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400
                               outline-none transition">

                    <option value="">Select Asset</option>

                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}">
                            {{ $asset->name }}
                        </option>
                    @endforeach

                </select>

                @error('asset_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ISSUE -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Issue Description
                </label>

                <textarea name="issue"
                          rows="4"
                          placeholder="Describe the problem..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50
                                 focus:bg-white focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400
                                 outline-none transition"></textarea>

                @error('issue')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- STATUS -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50
                               focus:bg-white focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400
                               outline-none transition">

                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>

                </select>

                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- SOLUTION (OPTIONAL) -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Solution (Optional)
                </label>

                <textarea name="solution"
                          rows="3"
                          placeholder="How was it fixed?"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50
                                 focus:bg-white focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400
                                 outline-none transition"></textarea>
            </div>

            <!-- ACTIONS -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">

                <a href="{{ route('maintenance.index') }}"
                   class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    Save Record
                </button>

            </div>

        </form>

    </div>

</div>

@endsection