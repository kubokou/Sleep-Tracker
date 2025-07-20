<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SleepRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/sleep', [ProfileController::class, 'updateSleepTime'])->name('profile.sleep.update');

    Route::get('/sleep', [SleepRecordController::class, 'index'])->name('sleep.index');
    Route::get('/sleep/create', [SleepRecordController::class, 'create'])->name('sleep.create');
    Route::post('/sleep', [SleepRecordController::class, 'store'])->name('sleep.store');

    Route::get('/pie_chart', [SleepRecordController::class, 'pieChart'])->name('pie_chart');
    Route::post('/pie_chart', [SleepRecordController::class, 'filterChart'])->name('pie_chart.filter');
});

Route::get('/calendar', [EventController::class, 'show'])->name('calendar');
Route::post('/calendar/create', [EventController::class, 'create'])->name("create");
Route::post('/calendar/get', [EventController::class, 'get'])->name("get");
Route::get('/sleep/{date}', [SleepRecordController::class, 'showByDate'])->name('sleep.showByDate');

require __DIR__.'/auth.php';
