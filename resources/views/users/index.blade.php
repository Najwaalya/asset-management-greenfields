@extends('layouts.app')

@section('title', 'Users - Asset Management System')
@section('page-title', 'User Management')
@section('breadcrumb', 'Users')

@section('content')

<!-- TOP BAR (samain Assets style) -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            User Management
        </h2>

        <p class="text-gray-600 text-sm mt-1">
            Manage all users in the system
        </p>
    </div>

    <a href="{{ route('users.create') }}"
       class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

        + Add User

    </a>

</div>

<!-- TABLE CARD -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">

    <div class="overflow-x-auto">

        <table id="usersTable" class="w-full text-sm">

            <thead class="bg-gray-50 border-b border-gray-200">

                <tr>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        No
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Name
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Email
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">
                        Created At
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @forelse($users as $user)

                    <tr class="hover:bg-gray-50 transition">

                        <!-- No -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $loop->iteration }}
                        </td>

                        <!-- Name -->
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $user->name }}
                        </td>

                        <!-- Email -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->email }}
                        </td>

                        <!-- Created -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-sm text-right">

                            <div class="flex justify-end items-center space-x-3">

                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="text-yellow-600 hover:text-yellow-700">
                                    Edit
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}"
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No user data found
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

    $('#usersTable').DataTable({
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search users..."
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
            title: 'Delete User?',
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