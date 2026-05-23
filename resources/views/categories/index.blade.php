@extends('layouts.app')

@section('title', 'Asset Categories')
@section('page-title', 'Asset Categories')
@section('breadcrumb', 'Categories')

@section('content')

<!-- TOP BAR -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            Asset Categories
        </h2>

        <p class="text-gray-600 text-sm mt-1">
            Manage and organize asset categories
        </p>
    </div>

    <button onclick="openModal()"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
        </svg>

        Add Category

    </button>

</div>

<!-- TABLE -->
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">

    <div class="overflow-x-auto">

        <table id="categoriesTable" class="w-full text-sm">

            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Assets</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @forelse($categories as $category)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 text-gray-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $category->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $category->description ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ $category->assets_count }} assets
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $category->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-right">

                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="text-yellow-600 hover:text-yellow-700 mr-3">
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}"
                                  method="POST"
                                  class="inline delete-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:text-red-700">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            No categories found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL -->
<div id="categoryModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-lg p-6 relative">

        <!-- CLOSE -->
        <button onclick="closeModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            ✕
        </button>

        <h2 class="text-lg font-bold mb-4">
            Create Category
        </h2>

        <form id="categoryForm"
              action="{{ route('categories.store') }}"
              method="POST">

            @csrf

            <input type="text"
                   name="name"
                   placeholder="Category name"
                   class="w-full border px-3 py-2 rounded mb-3"
                   required>

            <textarea name="description"
                      placeholder="Description"
                      class="w-full border px-3 py-2 rounded mb-3"></textarea>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                Save
            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>
/* =========================
   MODAL FUNCTION
========================= */

function openModal() {
    const modal = document.getElementById('categoryModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('categoryModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/* =========================
   DATATABLE + SWEETALERT
========================= */

$(document).ready(function () {

    $('#categoriesTable').DataTable({
        pageLength: 5,
        language: {
            search: "",
            searchPlaceholder: "Search categories..."
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
            title: 'Delete Category?',
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