<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\EstablishmentManagementController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\SqlExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/users/create', 'auth.users-create-disabled')->name('users.create');

    Route::get('/time-entries/import', [TimeEntryController::class, 'importForm'])->name('time-entries.import.form');
    Route::post('/time-entries/import', [TimeEntryController::class, 'importStore'])->name('time-entries.import.store');

    Route::resource('establishments', EstablishmentController::class);
    Route::resource('collaborators', CollaboratorController::class);
    Route::resource('establishment-managements', EstablishmentManagementController::class);
    Route::resource('time-entries', TimeEntryController::class);

    Route::get('/exportar', [SqlExportController::class, 'index'])->name('sql-export.index');
    Route::get('/sql-export/full', [SqlExportController::class, 'exportFullBackup'])->name('sql-export.full');
    Route::get('/sql-export/module/{module}', [SqlExportController::class, 'exportModule'])->name('sql-export.module');
});