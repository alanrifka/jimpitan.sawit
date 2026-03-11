<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\JimpitanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasMasukController;
use Illuminate\Support\Facades\Route;

// Public login routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Protected application routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('wargas', WargaController::class);
    Route::resource('rumahs', RumahController::class);
    Route::resource('jimpitans', JimpitanController::class);
    Route::resource('pengeluarans', PengeluaranController::class);
    Route::resource('users', UserController::class);
    Route::resource('kas-masuks', KasMasukController::class);
    Route::get('wargas/{warga}/print-jimpitan', [JimpitanController::class, 'printCard'])->name('jimpitans.print');
});
