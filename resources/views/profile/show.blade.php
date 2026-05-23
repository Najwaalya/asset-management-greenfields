@extends('layouts.app')

@section('title', 'My Profile - Asset Management System')
@section('page-title', 'My Profile')
@section('breadcrumb', 'Profile')

@section('content')
@php $user = auth()->user(); @endphp

    <div class="max-w-4xl mx-auto">
        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex items-center space-x-8">
                <button class="px-4 py-3 text-greenfields-natural font-medium border-b-2 border-greenfields-natural transition-colors duration-200">
                    Profile
                </button>
                <button class="px-4 py-3 text-gray-600 hover:text-gray-900 font-medium border-b-2 border-transparent hover:border-gray-300 transition-colors duration-200">
                    Change Password
                </button>
                <button class="px-4 py-3 text-gray-600 hover:text-gray-900 font-medium border-b-2 border-transparent hover:border-gray-300 transition-colors duration-200">
                    Preferences
                </button>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-8 text-center">
                <div class="mb-4">
                    <div class="w-24 h-24 bg-gradient-to-br from-greenfields-natural to-greenfields-dark rounded-full flex items-center justify-center mx-auto text-white font-bold text-3xl shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->name, strrpos($user->name, ' ') + 1, 1)) }}
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-greenfields-natural font-medium text-sm mt-1">{{ ucfirst($user->role) }}</p>

                <div class="mt-6 space-y-2 text-left">
                    <p class="text-sm text-gray-600">
                        <strong>Email:</strong> {{ $user->email }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Role:</strong> {{ ucfirst($user->role) }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Joined:</strong> {{ $user->created_at->format('d F Y') }}
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-greenfields-natural text-white font-medium rounded-lg hover:bg-greenfields-dark transition-colors duration-200">
                    Edit Profile
                </a>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Account created</p>
                                    <p class="text-xs text-gray-600 mt-1">Welcome, {{ $user->name }}!</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Email address</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Registered email</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Role & Access</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ ucfirst($user->role) }} — access level assigned by admin</p>
                                    <p class="text-xs text-gray-500 mt-1">Since {{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                        <p class="text-xs text-gray-400">Showing account information for {{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-8 bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Security & Sessions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm font-medium text-green-900">Password Last Updated</p>
                    <p class="text-xs text-green-700 mt-2">{{ $user->updated_at->diffForHumans() }}</p>
                </div>
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm font-medium text-blue-900">Current Sessions</p>
                    <p class="text-xs text-blue-700 mt-2">1 active session (this device)</p>
                </div>
            </div>
        </div>
    </div>
@endsection