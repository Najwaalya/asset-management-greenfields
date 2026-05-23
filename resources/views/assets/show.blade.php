@extends('layouts.app')

@section('title', 'Asset Detail - Asset Management System')
@section('page-title', 'Asset Detail')
@section('breadcrumb', 'Assets / Detail')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- BACK -->
    <div>
        <a href="{{ route('assets.index') }}"
           class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium">
            ← Back to Assets
        </a>
    </div>

    <!-- HEADER CARD -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="flex items-start justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Asset Detail
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Detailed information of asset
                </p>
            </div>

            <!-- STATUS BADGE -->
            <div>
                @if($asset->status == 'normal')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        Normal
                    </span>
                @elseif($asset->status == 'maintenance')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                        Maintenance
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                        Broken
                    </span>
                @endif
            </div>

        </div>

    </div>

    <!-- CONTENT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- LEFT -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 space-y-5">

            <div>
                <p class="text-xs text-gray-500 uppercase">Asset Name</p>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $asset->name }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Asset Code</p>
                <p class="text-gray-800 font-medium">
                    {{ $asset->code }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Category</p>
                <p class="text-gray-800">
                    {{ $asset->category->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Location</p>
                <p class="text-gray-800">
                    {{ $asset->location ?? '-' }}
                </p>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 space-y-5">

            <div>
                <p class="text-xs text-gray-500 uppercase">Created By</p>
                <p class="text-gray-800 font-medium">
                    {{ $asset->creator->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Description</p>
                <p class="text-gray-800 leading-relaxed">
                    {{ $asset->description ?? 'No description' }}
                </p>
            </div>

        </div>

    </div>

    <!-- MAINTENANCE HISTORY -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="mb-4">
            <h3 class="font-semibold text-gray-900">Maintenance History</h3>
        </div>

        <div class="space-y-4">

            @forelse($asset->maintenanceLogs as $log)

                <div class="border rounded-lg p-4 hover:bg-gray-50">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="font-medium text-gray-900">
                                {{ $log->issue }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $log->created_at->format('d M Y') }}
                            </p>

                        </div>

                        <span class="px-2 py-1 text-xs rounded
                            {{ $log->status == 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $log->status == 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $log->status == 'pending' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($log->status) }}
                        </span>

                    </div>

                </div>

            @empty

                <p class="text-gray-500 text-sm">
                    No maintenance history
                </p>

            @endforelse

        </div>

    </div>

    <!-- ACTION FOOTER -->
    <div class="flex justify-end space-x-3">

        <a href="{{ route('assets.edit', $asset->id) }}"
           class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">
            Edit
        </a>

        <form action="{{ route('assets.destroy', $asset->id) }}"
              method="POST"
              class="delete-form">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                Delete
            </button>

        </form>

    </div>

</div>

@endsection