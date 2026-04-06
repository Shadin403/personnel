<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SoldierController;
use App\Http\Controllers\Admin\ChainOfCommandController;

// Redirect root to dashboard or login
Route::get('/', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\Admin\UnitController;

// Admin Routes (protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Units CRUD
    Route::resource('units', UnitController::class);

    // Soldiers CRUD
    Route::get('/soldiers', [SoldierController::class, 'index'])->name('soldiers.index');

    // Admin-only Soldier Actions (Static paths first)
    Route::middleware('admin-only')->group(function () {
        Route::get('/soldiers/weak', [SoldierController::class, 'weak'])->name('soldiers.weak');
        Route::get('/soldiers/create', [SoldierController::class, 'create'])->name('soldiers.create');
        Route::post('/soldiers', [SoldierController::class, 'store'])->name('soldiers.store');
        Route::get('/soldiers/{soldier}/edit', [SoldierController::class, 'edit'])->name('soldiers.edit');
        Route::put('/soldiers/{soldier}', [SoldierController::class, 'update'])->name('soldiers.update');
        Route::delete('/soldiers/{soldier}', [SoldierController::class, 'destroy'])->name('soldiers.destroy');
        Route::post('/soldiers/bulk-action', [SoldierController::class, 'bulkAction'])->name('soldiers.bulk-action');
    });

    // Dynamic paths last
    Route::get('/soldiers/{soldier}', [SoldierController::class, 'show'])->name('soldiers.show');
    Route::get('/soldiers/{soldier}/download-trg', [SoldierController::class, 'downloadTrg'])->name('soldiers.download-trg');
    Route::get('/soldiers/{soldier}/download-record-book', [SoldierController::class, 'downloadRecordBook'])->name('soldiers.download-record-book');
    Route::get('/soldiers/{soldier}/print-record-book', [SoldierController::class, 'printRecordBook'])->name('soldiers.print-record-book');
});
