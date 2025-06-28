<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SleepRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;

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

Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード（睡眠データ込み）
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// プロフィール関連（認証済みユーザ用）
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 睡眠時間専用更新
    Route::put('/profile/sleep', [ProfileController::class, 'updateSleepTime'])->name('profile.sleep.update');
});

// 睡眠記録機能
Route::middleware('auth')->group(function () {
    Route::get('/sleep', [SleepRecordController::class, 'index'])->name('sleep.index');
    Route::get('/sleep/create', [SleepRecordController::class, 'create'])->name('sleep.create');
    Route::post('/sleep', [SleepRecordController::class, 'store'])->name('sleep.store');
});

// カレンダーページ
Route::get('/calendar', [EventController::class, 'show'])->name('calendar');

Route::get('/sleep/by-date', [SleepRecordController::class, 'getByDate'])
    ->middleware('auth')
    ->name('sleep.by-date');


require __DIR__.'/auth.php';