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

// ======================
// AUTH
// ======================

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// ======================
// PROTECTED ROUTES
// ======================

Route::middleware('auth')->group(function () {

    // ======================
    // DASHBOARD
    // ======================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ======================
    // PROFILE
    // ======================
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])
            ->name('profile.show');

        Route::get('/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/', [ProfileController::class, 'update'])
            ->name('profile.update');
    });

    // ======================
    // ASSET
    // ======================
    Route::resource('assets', AssetController::class)
        ->middleware('role:admin,operator');

    // ======================
    // CATEGORY
    // ======================
    Route::resource('categories', AssetCategoryController::class)
        ->middleware('role:admin');

    // ======================
    // USER
    // ======================
    Route::resource('users', UserController::class)
        ->middleware('role:admin');

    // ======================
    // MAINTENANCE SCHEDULE
    // ======================

    Route::prefix('maintenance/schedule')
        ->name('maintenance.schedule.')
        ->group(function () {

            // Semua role bisa lihat daftar & detail
            Route::middleware('role:admin,operator,teknisi')->group(function () {

                Route::get('/', [MaintenanceScheduleController::class, 'index'])
                    ->name('index');

                // PENTING: create HARUS sebelum {id}
                Route::get('/create', [MaintenanceScheduleController::class, 'create'])
                    ->middleware('role:admin,operator')
                    ->name('create');

                Route::get('/{id}', [MaintenanceScheduleController::class, 'show'])
                    ->name('show');

                Route::patch('/{id}/status', [MaintenanceScheduleController::class, 'updateStatus'])
                    ->name('updateStatus');
            });

            // Admin & Operator
            Route::middleware('role:admin,operator')->group(function () {

                Route::post('/', [MaintenanceScheduleController::class, 'store'])
                    ->name('store');

                Route::get('/{id}/edit', [MaintenanceScheduleController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [MaintenanceScheduleController::class, 'update'])
                    ->name('update');

                Route::delete('/{id}', [MaintenanceScheduleController::class, 'destroy'])
                    ->name('destroy');
            });
        });

    // ======================
    // MAINTENANCE LOG
    // ======================
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
});