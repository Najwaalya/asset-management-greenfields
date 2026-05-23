@extends('layouts.app')

@section('title', 'Edit Profile - Asset Management System')
@section('page-title', 'Edit Profile')
@section('breadcrumb', 'Edit Profile')

@section('content')
@php $user = auth()->user(); @endphp

<div class="max-w-2xl mx-auto">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
        <p class="text-gray-600 text-sm mt-1">Update your personal information</p>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST"
          class="bg-white rounded-lg shadow border border-gray-200 p-8">
        @csrf
        @method('PUT')

        <!-- NAME -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-400 @enderror"
                   required>
            @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-400 @enderror"
                   required>
            @error('email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ROLE (readonly) -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <input type="text" value="{{ ucfirst($user->role) }}" disabled
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
            <p class="text-xs text-gray-400 mt-1">Role tidak dapat diubah sendiri</p>
        </div>

        <!-- PASSWORD BARU (opsional) -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                New Password <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin ganti)</span>
            </label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-400 @enderror">
            @error('password')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('profile.show') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 text-sm hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                Save Changes
            </button>
        </div>

    </form>
</div>

@endsection