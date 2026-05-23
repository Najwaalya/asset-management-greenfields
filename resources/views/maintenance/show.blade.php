@extends('layouts.app')

@section('title', 'Maintenance Detail')
@section('page-title', 'Maintenance Detail')
@section('breadcrumb', 'Maintenance / Detail')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- BACK -->
    <div>
        <a href="{{ route('maintenance.index') }}"
           class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium">
            ← Back to Maintenance
        </a>
    </div>

    <!-- HEADER CARD -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="flex items-start justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Maintenance Detail
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Detailed information of maintenance record
                </p>
            </div>

            <!-- STATUS BADGE -->
            <div>
                @if($log->status == 'resolved')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        Resolved
                    </span>
                @elseif($log->status == 'in_progress')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                        In Progress
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                        Pending
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
                <p class="text-xs text-gray-500 uppercase">Asset</p>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $log->asset->name }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Reported By</p>
                <p class="text-gray-800 font-medium">
                    {{ $log->reporter->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Created At</p>
                <p class="text-gray-800">
                    {{ $log->created_at->format('d M Y H:i') }}
                </p>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 space-y-5">

            <div>
                <p class="text-xs text-gray-500 uppercase">Issue</p>
                <p class="text-gray-800 leading-relaxed">
                    {{ $log->issue }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase">Solution</p>
                <p class="text-gray-800 leading-relaxed">
                    {{ $log->solution ?? 'No solution yet' }}
                </p>
            </div>

        </div>

    </div>

    <!-- ACTION FOOTER -->
    <div class="flex justify-end space-x-3">

        <a href="{{ route('maintenance.edit', $log->id) }}"
           class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm">
            Edit
        </a>

        <form action="{{ route('maintenance.destroy', $log->id) }}"
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