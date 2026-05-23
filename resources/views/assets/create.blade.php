@extends('layouts.app')

@section('title', 'Add New Asset - Asset Management System')
@section('page-title', 'Add New Asset')
@section('breadcrumb', 'Assets / Add New')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('assets.index') }}"
           class="inline-flex items-center text-green-600 hover:text-green-700 transition-colors duration-200">

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

    <!-- Card -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-green-100 to-green-50 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">
                Add New Asset
            </h2>

            <p class="text-sm text-gray-600 mt-1">
                Fill in the asset information below
            </p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="mx-6 mt-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('assets.store') }}"
              method="POST"
              class="px-6 py-6 space-y-6">

            @csrf

            <!-- Asset Name -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    Asset Name *
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g., Laptop Dell XPS 13"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500
                              focus:border-transparent transition-all duration-200">

            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Asset Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Asset Code *
                    </label>

                    <input type="text"
                           name="code"
                           value="{{ old('code') }}"
                           placeholder="e.g., AST-001"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  focus:border-transparent transition-all duration-200">

                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Category *
                    </label>

                    <select name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-green-500
                                   focus:border-transparent transition-all duration-200 bg-white">

                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Status *
                    </label>

                    <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-green-500
                                   focus:border-transparent transition-all duration-200 bg-white">

                        <option value="">Select Status</option>

                        <option value="normal"
                            {{ old('status') == 'normal' ? 'selected' : '' }}>
                            Normal
                        </option>

                        <option value="maintenance"
                            {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                            Maintenance
                        </option>

                        <option value="broken"
                            {{ old('status') == 'broken' ? 'selected' : '' }}>
                            Broken
                        </option>

                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Location
                    </label>

                    <input type="text"
                           name="location"
                           value="{{ old('location') }}"
                           placeholder="e.g., Warehouse A"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  focus:border-transparent transition-all duration-200">

                </div>

            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    Description
                </label>

                <textarea name="description"
                          rows="4"
                          placeholder="Enter asset description..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm
                                 focus:outline-none focus:ring-2 focus:ring-green-500
                                 focus:border-transparent transition-all duration-200 resize-none">{{ old('description') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">

                <a href="{{ route('assets.index') }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">

                    Cancel

                </a>

                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg
                               hover:bg-green-700 focus:outline-none focus:ring-2
                               focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">

                    Add Asset

                </button>

            </div>

        </form>
    </div>
</div>
@endsection