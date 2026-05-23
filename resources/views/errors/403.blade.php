@extends('layouts.app')

@section('title', '403 - Unauthorized')
@section('page-title', 'Access Denied')

@section('content')

    <div class="flex flex-col items-center justify-center py-20">

        <div class="text-center">

            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m0 0v2m0-2h2m-2 0H10m2-5V7m0 0V5m0 2h2M12 7H10m9.293 9.293a1 1 0 01-1.414 0L12 12.414l-5.879 5.879a1 1 0 01-1.414-1.414L10.586 11 4.707 5.121a1 1 0 011.414-1.414L12 9.586l5.879-5.879a1 1 0 011.414 1.414L13.414 11l5.879 5.879a1 1 0 010 1.414z"/>
                </svg>
            </div>

            <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>

            <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                Access Denied
            </h2>

            <p class="text-gray-500 mb-8">
                You don't have permission to access this page.
            </p>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>

        </div>

    </div>

@endsection