@extends('layouts.app')

@section('title', 'Edit Asset - Asset Management System')
@section('page-title', 'Edit Asset')
@section('breadcrumb', 'Assets / Edit')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Edit Asset
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                Update asset information
            </p>
        </div>

    </div>

    <!-- BACK BUTTON -->
    <div class="mb-6">

        <a href="{{ route('assets.index') }}"
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

            Back to Assets

        </a>

    </div>

    <!-- FORM CARD -->
    <form action="{{ route('assets.update', $asset->id) }}"
          method="POST"
          class="bg-white rounded-lg shadow border border-gray-200 p-8">

        @csrf
        @method('PUT')

        <!-- NAME -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Asset Name
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $asset->name) }}"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm"
                   required>

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- CODE -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Asset Code
            </label>

            <input type="text"
                   name="code"
                   value="{{ old('code', $asset->code) }}"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm"
                   required>

            @error('code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- CATEGORY -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Category
            </label>

            <select name="category_id"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                           focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                           outline-none transition shadow-sm"
                    required>

                <option value="">-- Select Category --</option>

                @foreach ($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

            @error('category_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- STATUS -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Status
            </label>

            <select name="status"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                           focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                           outline-none transition shadow-sm"
                    required>

                <option value="normal" {{ $asset->status == 'normal' ? 'selected' : '' }}>
                    Normal
                </option>

                <option value="maintenance" {{ $asset->status == 'maintenance' ? 'selected' : '' }}>
                    Maintenance
                </option>

                <option value="broken" {{ $asset->status == 'broken' ? 'selected' : '' }}>
                    Broken
                </option>

            </select>

        </div>

        <!-- LOCATION -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Location
            </label>

            <input type="text"
                   name="location"
                   value="{{ old('location', $asset->location) }}"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm">

        </div>

        <!-- DESCRIPTION -->
        <div class="mb-6">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Description
            </label>

            <textarea name="description"
                      rows="4"
                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                             focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                             outline-none transition shadow-sm">{{ old('description', $asset->description) }}</textarea>

        </div>

        <!-- INFO CARD -->
        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50
                    border border-blue-100 rounded-xl shadow-sm">

            <p class="text-sm text-blue-900">
                <span class="font-semibold">Current Status:</span>
                <span class="font-bold">
                    {{ ucfirst($asset->status) }}
                </span>
            </p>

        </div>

        <!-- BUTTONS -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">

            <a href="{{ route('assets.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">

                Cancel

            </a>

            <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

                Update Asset

            </button>

        </div>

    </form>

</div>

@endsection