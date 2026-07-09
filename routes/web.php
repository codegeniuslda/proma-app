<?php

use App\Http\Controllers\CollaboratorController;
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

Route::redirect('/', '/time-entries');

Route::get('/time-entries/import', [TimeEntryController::class, 'importForm'])->name('time-entries.import.form');
Route::post('/time-entries/import', [TimeEntryController::class, 'importStore'])->name('time-entries.import.store');

Route::resource('collaborators', CollaboratorController::class);
Route::resource('time-entries', TimeEntryController::class);