<?php

use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\TimeEntryController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/time-entries/import', [TimeEntryController::class, 'importForm'])->name('time-entries.import.form');
Route::post('/time-entries/import', [TimeEntryController::class, 'importStore'])->name('time-entries.import.store');
Route::get('/time-entries/export', [TimeEntryController::class, 'export'])->name('time-entries.export');

Route::resource('establishments', EstablishmentController::class);
Route::resource('collaborators', CollaboratorController::class);
Route::resource('time-entries', TimeEntryController::class);