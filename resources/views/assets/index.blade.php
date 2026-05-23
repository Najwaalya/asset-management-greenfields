@extends('layouts.app')

@section('title', 'Assets - Asset Management System')
@section('page-title', 'Assets')
@section('breadcrumb', 'Assets')

@section('content')

    <!-- Top Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Asset Inventory
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                Manage and track all company assets
            </p>
        </div>

        <a href="{{ route('assets.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

            <svg class="w-5 h-5 mr-2"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Add Asset

        </a>

    </div>

<!-- Assets Table -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">

    <div class="overflow-x-auto">

        <table id="assetsTable" class="w-full text-sm">

            <thead class="bg-gray-50 border-b border-gray-200">

                <tr>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Asset Name
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Code
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Category
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Status
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Location
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Created By
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                {{-- LOOP DATA --}}
                @forelse($assets as $asset)

                    <tr class="hover:bg-gray-50 transition">

                        <!-- Asset Name -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <a href="{{ route('assets.show', $asset->id) }}"
                               class="text-green-600 hover:text-green-700">
                                {{ $asset->name }}
                            </a>
                        </td>

                        <!-- Code -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $asset->code }}
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $asset->category->name ?? '-' }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-sm">
                            @if($asset->status == 'normal')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Normal
                                </span>
                            @elseif($asset->status == 'maintenance')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Maintenance
                                </span>
                            @elseif($asset->status == 'broken')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Broken
                                </span>
                            @endif
                        </td>

                        <!-- Location -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $asset->location }}
                        </td>

                        <!-- Created By -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $asset->creator->name ?? '-' }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end items-center space-x-3">

                                <a href="{{ route('assets.show', $asset->id) }}"
                                   class="text-blue-600 hover:text-blue-700">
                                    View
                                </a>

                                <a href="{{ route('assets.edit', $asset->id) }}"
                                   class="text-yellow-600 hover:text-yellow-700">
                                    Edit
                                </a>

                                <form action="{{ route('assets.destroy', $asset->id) }}"
                                      method="POST"
                                      class="inline delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:text-red-700">
                                        Delete
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No assets found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')

<script>

$(document).ready(function () {

    $('#assetsTable').DataTable({

        pageLength: 5,

        language: {
            search: "",
            searchPlaceholder: "Search assets..."
        },

        dom:
            "<'flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4'lf>" +
            "t" +
            "<'flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4'ip>"

    });

    $('.delete-form').on('submit', function(e) {

        e.preventDefault();

        let form = this;

        Swal.fire({
            title: 'Delete Asset?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});

</script>

@endpush