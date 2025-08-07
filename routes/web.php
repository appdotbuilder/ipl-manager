<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSyncController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IplPaymentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - Main IPL Management Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // IPL Payment Management
    Route::resource('ipl', IplPaymentController::class);
    
    // Expense Management
    Route::resource('expenses', ExpenseController::class);
    
    // Data Sync with Google Sheets
    Route::resource('data-sync', DataSyncController::class)->only(['index', 'create', 'store', 'show', 'update']);
    
    // Activity Logs
    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/activity-logs', 'index')->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', 'show')->name('activity-logs.show');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
