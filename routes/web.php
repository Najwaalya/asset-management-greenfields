<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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

    // Assets → admin & operator only
    Route::resource('assets', AssetController::class)
        ->middleware('role:admin,operator');

    // Categories → admin only
    Route::resource('categories', AssetCategoryController::class)
        ->middleware('role:admin');

    // Users → admin only
    Route::resource('users', UserController::class)
        ->middleware('role:admin');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Maintenance Schedule
    Route::get('maintenance/schedule', [MaintenanceScheduleController::class, 'index'])
        ->name('maintenance.schedule.index')
        ->middleware('role:admin,operator,teknisi');

    Route::get('maintenance/schedule/{id}', [MaintenanceScheduleController::class, 'show'])
        ->name('maintenance.schedule.show')
        ->middleware('role:admin,operator,teknisi');

    Route::resource('maintenance/schedule', MaintenanceScheduleController::class)
        ->except(['index', 'show'])
        ->middleware('role:admin,operator')
        ->names([
            'create'  => 'maintenance.schedule.create',
            'store'   => 'maintenance.schedule.store',
            'edit'    => 'maintenance.schedule.edit',
            'update'  => 'maintenance.schedule.update',
            'destroy' => 'maintenance.schedule.destroy',
        ]);

    Route::patch('maintenance/schedule/{id}/status', [MaintenanceScheduleController::class, 'updateStatus'])
        ->name('maintenance.schedule.updateStatus')
        ->middleware('role:admin,operator,teknisi');

    // Maintenance Logs
    Route::resource('maintenance/logs', MaintenanceLogController::class)
        ->names([
            'index'   => 'maintenance.index',
            'create'  => 'maintenance.create',
            'store'   => 'maintenance.store',
            'show'    => 'maintenance.show',
            'edit'    => 'maintenance.edit',
            'update'  => 'maintenance.update',
            'destroy' => 'maintenance.destroy',
        ]);

    Route::get('/profile',        [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',        [ProfileController::class, 'update'])->name('profile.update');

});