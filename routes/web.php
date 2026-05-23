<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// LOGIN & LOGOUT
Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// PROTECTED ROUTES
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Assets
    Route::resource('assets', AssetController::class);

    // Categories
    Route::resource('categories', AssetCategoryController::class);

    // Users
    Route::resource('users', UserController::class);

    // Profile
    Route::get('/profile', fn() => view('profile.show'))->name('profile.show');
    Route::get('/profile/edit', fn() => view('profile.edit'))->name('profile.edit');
    Route::put('/profile', fn() => redirect()->route('profile.show'))->name('profile.update');

    // Maintenance Schedule — admin & operator only
    Route::middleware('role:admin,operator')->group(function () {
        Route::resource('maintenance/schedule', MaintenanceScheduleController::class)
            ->names('maintenance.schedule');
    });

    // Maintenance Log — semua role (pembatasan di controller)
    Route::resource('maintenance/logs', MaintenanceLogController::class)
        ->names('maintenance');

});