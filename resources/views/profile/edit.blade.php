@extends('layouts.app')

@section('title', 'Edit Profile - Asset Management System')
@section('page-title', 'Edit Profile')
@section('breadcrumb', 'Edit Profile')

@section('content')

@php
    $user = auth()->user();
@endphp

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
        <p class="text-gray-600 text-sm mt-1">Update your personal information</p>
    </div>

    <!-- FORM -->
    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-lg shadow border border-gray-200 p-8">

        @csrf
        @method('PUT')

        <!-- AVATAR -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Profile Photo
            </label>

            <div class="flex items-center space-x-4">

                <!-- AVATAR -->
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-md">

                    {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}

                </div>

                <!-- UPLOAD -->
                <div class="flex-1">
                    <input type="file"
                           name="avatar"
                           accept="image/*"
                           class="block w-full text-sm text-gray-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:bg-green-100 file:text-green-700
                           hover:file:bg-green-200 transition">

                    <p class="text-xs text-gray-500 mt-1">
                        JPG, PNG or GIF (max. 2MB)
                    </p>
                </div>

            </div>
        </div>

        <!-- NAME -->
        <x-input
            label="Full Name"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
        />

        <!-- EMAIL -->
        <x-input
            label="Email Address"
            name="email"
            type="email"
            value="{{ old('email', $user->email) }}"
            required
        />

        <!-- PHONE -->
        <x-input
            label="Phone Number"
            name="phone"
            type="tel"
            value="{{ old('phone', $user->phone ?? '') }}"
        />

        <!-- DEPARTMENT -->
        <x-select
            label="Department"
            name="department"
            value="{{ old('department', $user->department ?? '') }}"
            :options="[
                'it' => 'IT & Systems',
                'hr' => 'Human Resources',
                'finance' => 'Finance',
                'operations' => 'Operations',
                'engineering' => 'Engineering',
                'marketing' => 'Marketing'
            ]"
        />

        <!-- BIO -->
        <x-textarea
            label="Bio"
            name="bio"
            value="{{ old('bio', $user->bio ?? '') }}"
            rows="4"
            placeholder="Tell us about yourself"
        />

        <!-- LANGUAGE -->
        <x-select
            label="Language Preference"
            name="language"
            value="{{ old('language', $user->language ?? 'en') }}"
            :options="[
                'en' => 'English',
                'id' => 'Bahasa Indonesia'
            ]"
        />

        <!-- NOTIFICATION -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">

            <h4 class="text-sm font-semibold text-blue-900 mb-3">
                Notification Preferences
            </h4>

            <div class="space-y-3">

                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="notif_asset" class="w-4 h-4"
                           {{ $user->notif_asset ? 'checked' : '' }}>
                    <span class="text-sm">Email notifications for new assets</span>
                </label>

                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="notif_maintenance" class="w-4 h-4"
                           {{ $user->notif_maintenance ? 'checked' : '' }}>
                    <span class="text-sm">Maintenance reminders</span>
                </label>

                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="notif_weekly" class="w-4 h-4"
                           {{ $user->notif_weekly ? 'checked' : '' }}>
                    <span class="text-sm">Weekly summary reports</span>
                </label>

            </div>
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end space-x-3 pt-6 border-t">

            <a href="{{ route('profile.show') }}"
               class="px-6 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Save Changes
            </button>

        </div>

    </form>
</div>

@endsection