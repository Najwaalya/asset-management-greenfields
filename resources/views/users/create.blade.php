@extends('layouts.app')

@section('title', 'Add User - Asset Management System')
@section('page-title', 'Add User')
@section('breadcrumb', 'Users / Add New')

@section('content')

<div class="max-w-4xl mx-auto">

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

    <!-- CARD -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                Add New User
            </h2>

            <p class="text-gray-600 text-sm mt-1">
                Create a new system user account
            </p>
        </div>

        <!-- FORM -->
        <form action="{{ route('users.store') }}"
              method="POST"
              class="space-y-5">

            @csrf

            <!-- NAME -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Enter user name"
                       required>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- EMAIL -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Enter email"
                       required>

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- PASSWORD -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Enter password"
                       required>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- CONFIRM PASSWORD -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Confirm password"
                       required>

                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end space-x-3 pt-4">

                <a href="{{ route('users.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">

                    Cancel

                </a>

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">

                    Save User

                </button>

            </div>

        </form>

    </div>

</div>

@endsection