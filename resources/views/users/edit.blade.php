@extends('layouts.app')

@section('title', 'Edit User - Asset Management System')
@section('page-title', 'Edit User')
@section('breadcrumb', 'Edit User')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- HEADER + BACK -->
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Edit User
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                Update user information
            </p>
        </div>

    </div>

    <!-- BACK BUTTON -->
    <div class="mb-6">

        <a href="{{ route('users.index') }}"
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

            Back to Users

        </a>

    </div>

    <!-- FORM CARD -->
    <form action="{{ route('users.update', $user->id) }}"
          method="POST"
          class="bg-white rounded-lg shadow border border-gray-200 p-8">

        @csrf
        @method('PUT')

        <!-- NAME -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Name
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm"
                   required>

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- EMAIL -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Email
            </label>

            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm"
                   required>

            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- PASSWORD -->
        <div class="mb-5">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Password
            </label>

            <input type="password"
                   name="password"
                   placeholder="Leave blank if not changing"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm">

            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="mb-6">

            <label class="block text-sm font-medium text-gray-600 mb-2">
                Confirm Password
            </label>

            <input type="password"
                   name="password_confirmation"
                   placeholder="Confirm new password"
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                          focus:bg-white focus:ring-2 focus:ring-green-400/30 focus:border-green-400
                          outline-none transition shadow-sm">

        </div>

        <!-- INFO CARD -->
        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50
                    border border-blue-100 rounded-xl shadow-sm">

            <p class="text-sm text-blue-900">
                <span class="font-semibold">Account created:</span>
                <span class="font-bold">
                    {{ $user->created_at->format('d M Y') }}
                </span>
            </p>

        </div>

        <!-- BUTTONS -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">

            <a href="{{ route('users.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">

                Cancel

            </a>

            <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">

                Update User

            </button>

        </div>

    </form>

</div>

@endsection