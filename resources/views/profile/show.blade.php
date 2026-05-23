@extends('layouts.app')

@section('title', 'My Profile - Asset Management System')
@section('page-title', 'My Profile')
@section('breadcrumb', 'Profile')

@section('content')
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
                        JD
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-900">John Doe</h3>
                <p class="text-greenfields-natural font-medium text-sm mt-1">Administrator</p>

                <div class="mt-6 space-y-2">
                    <p class="text-sm text-gray-600">
                        <strong>Department:</strong> IT & Systems
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Email:</strong> john.doe@greenfields.com
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Phone:</strong> +62-21-XXXX-XXXX
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Joined:</strong> January 15, 2024
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
                                    <p class="text-sm font-medium text-gray-900">Created new asset</p>
                                    <p class="text-xs text-gray-600 mt-1">Asset ID: AST-00156 - Laptop Dell XPS 15</p>
                                    <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Updated asset status</p>
                                    <p class="text-xs text-gray-600 mt-1">Asset ID: AST-00045 - Monitor changed to "Maintenance"</p>
                                    <p class="text-xs text-gray-500 mt-1">5 hours ago</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-3a1 1 0 000-2 2 2 0 00-2 2v3H5V5z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Created new category</p>
                                    <p class="text-xs text-gray-600 mt-1">New category: "Safety Equipment" added to system</p>
                                    <p class="text-xs text-gray-500 mt-1">1 day ago</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Deleted asset</p>
                                    <p class="text-xs text-gray-600 mt-1">Asset ID: AST-00012 removed from system</p>
                                    <p class="text-xs text-gray-500 mt-1">3 days ago</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                        <a href="#" class="text-sm font-medium text-greenfields-natural hover:text-greenfields-dark transition-colors duration-200">
                            View all activity →
                        </a>
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
                    <p class="text-xs text-green-700 mt-2">45 days ago</p>
                </div>
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm font-medium text-blue-900">Current Sessions</p>
                    <p class="text-xs text-blue-700 mt-2">1 active session (this device)</p>
                </div>
            </div>
        </div>
    </div>
@endsection
